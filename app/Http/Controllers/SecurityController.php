<?php

namespace App\Http\Controllers;

use App\Models\CMS\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class SecurityController extends Controller
{
    public function index(Request $request): View
    {
        $sessions = DB::table(config('session.table', 'sessions'))
            ->where('user_id', $request->user()->getAuthIdentifier())
            ->orderByDesc('last_activity')
            ->get()
            ->map(fn ($session) => (object) [
                'id' => $session->id,
                'ip_address' => $session->ip_address,
                'user_agent' => $session->user_agent,
                'last_activity' => \Carbon\Carbon::createFromTimestamp($session->last_activity),
                'is_current' => $session->id === $request->session()->getId(),
            ]);

        return view('security.index', [
            'sessions' => $sessions,
            'user' => $request->user(),
        ]);
    }

    public function updateTwoFactor(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'current_password' => ['required', 'current_password'],
            'two_factor_enabled' => ['nullable'],
        ]);

        $request->user()->update([
            'two_factor_enabled' => array_key_exists('two_factor_enabled', $data),
            'two_factor_method' => array_key_exists('two_factor_enabled', $data) ? 'email' : null,
            'two_factor_confirmed_at' => array_key_exists('two_factor_enabled', $data) ? now() : null,
        ]);

        activity()
            ->causedBy($request->user())
            ->event('security_updated')
            ->withProperties(['two_factor_enabled' => $request->user()->fresh()->two_factor_enabled])
            ->log('Two-factor settings updated');

        return back()->with('status', 'Two-factor settings updated.');
    }

    public function destroySession(Request $request, string $sessionId): RedirectResponse
    {
        DB::table(config('session.table', 'sessions'))
            ->where('user_id', $request->user()->getAuthIdentifier())
            ->where('id', $sessionId)
            ->delete();

        activity()
            ->causedBy($request->user())
            ->event('session_revoked')
            ->withProperties(['session_id' => $sessionId])
            ->log('Session revoked');

        return back()->with('status', 'Session revoked.');
    }

    public function destroyOtherSessions(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
        ]);

        DB::table(config('session.table', 'sessions'))
            ->where('user_id', $request->user()->getAuthIdentifier())
            ->where('id', '!=', $request->session()->getId())
            ->delete();

        activity()
            ->causedBy($request->user())
            ->event('sessions_revoked')
            ->log('Other sessions revoked');

        return back()->with('status', 'Other sessions were signed out.');
    }
}
