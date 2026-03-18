<?php

namespace App\Http\Controllers\Auth;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AuthenticatedSessionController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => 'Invalid credentials.',
            ]);
        }

        $request->session()->regenerate();
        $request->user()->forceFill(['last_login_at' => now()])->save();

        if ($request->user()->hasRole('client')) {
            return redirect()->route('client.dashboard');
        }

        return redirect()->route('admin.dashboard');
    }

    public function quickLogin(Request $request, string $role): RedirectResponse
    {
        $this->ensureQuickLoginIsAllowed();

        $userRole = UserRole::tryFrom($role);

        if (! $userRole) {
            throw new NotFoundHttpException();
        }

        $user = User::query()
            ->role($userRole->value)
            ->orderBy('id')
            ->firstOrFail();

        Auth::login($user, true);

        $request->session()->regenerate();
        $user->forceFill(['last_login_at' => now()])->save();

        if ($user->hasRole(UserRole::Client->value)) {
            return redirect()->route('client.dashboard');
        }

        return redirect()->route('admin.dashboard');
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    protected function ensureQuickLoginIsAllowed(): void
    {
        if (! config('platform.features.quick_login')) {
            throw new NotFoundHttpException();
        }
    }
}
