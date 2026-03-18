<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Auth\AccountClaimService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AccountClaimController extends Controller
{
    public function show(string $token, AccountClaimService $claims): View
    {
        $record = $claims->resolveValidToken($token);

        abort_if(! $record, 404);

        return view('auth.claim', [
            'token' => $token,
            'email' => $record->user?->email,
        ]);
    }

    public function store(string $token, Request $request, AccountClaimService $claims): RedirectResponse
    {
        $record = $claims->resolveValidToken($token);
        abort_if(! $record, 404);

        $data = $request->validate([
            'password' => ['required', 'string', 'min:8', 'max:255', 'confirmed'],
        ]);

        $user = $record->user;
        abort_if(! $user, 404);

        $user->password = $data['password'];
        $user->save();

        $record->used_at = now();
        $record->save();

        Auth::login($user);

        return redirect()->route('client.dashboard');
    }
}

