<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\Auth\TwoFactorCodeMail;
use App\Models\User;
use App\Services\Mail\PlatformMailConfigurator;
use Illuminate\Cache\RateLimiter;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class TwoFactorChallengeController extends Controller
{
    public function __construct(
        protected PlatformMailConfigurator $mailConfigurator,
        protected RateLimiter $limiter
    ) {}

    public function create(Request $request): View|RedirectResponse
    {
        $user = $this->pendingUser($request);

        if (! $user) {
            return redirect()->route('login');
        }

        return view('auth.two-factor-challenge', [
            'email' => $user->email,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'code' => ['required', 'digits:6'],
        ]);

        $user = $this->pendingUser($request);

        if (! $user) {
            return redirect()->route('login');
        }

        $cacheKey = $this->codeKey($user->id);
        $cached = Cache::get($cacheKey);

        if (! $cached || ! hash_equals((string) $cached, (string) $request->string('code'))) {
            throw ValidationException::withMessages([
                'code' => 'The verification code is invalid or expired.',
            ]);
        }

        Cache::forget($cacheKey);
        $request->session()->forget(['auth.2fa.user_id', 'auth.2fa.remember']);

        Auth::login($user, (bool) $request->session()->pull('auth.2fa.remember', false));
        $request->session()->regenerate();
        $user->forceFill(['last_login_at' => now()])->save();

        activity()
            ->causedBy($user)
            ->event('two_factor_verified')
            ->withProperties(['ip' => $request->ip()])
            ->log('Two-factor challenge completed');

        if ($user->hasRole('client')) {
            return redirect()->route('client.dashboard');
        }

        if ($user->hasAnyRole(['hr', 'sales', 'support'])) {
            return redirect()->route('employee.dashboard');
        }

        return redirect()->route('admin.dashboard');
    }

    public function resend(Request $request): RedirectResponse
    {
        $user = $this->pendingUser($request);

        if (! $user) {
            return redirect()->route('login');
        }

        $throttleKey = 'two-factor-resend:'.$user->id.':'.$request->ip();
        if ($this->limiter->tooManyAttempts($throttleKey, 3)) {
            throw ValidationException::withMessages([
                'code' => 'Please wait before requesting another verification code.',
            ]);
        }

        $this->limiter->hit($throttleKey, 60);
        $this->sendCode($user);

        return back()->with('status', 'A fresh verification code has been sent.');
    }

    public function sendCode(User $user): void
    {
        $code = (string) random_int(100000, 999999);
        Cache::put($this->codeKey($user->id), $code, now()->addMinutes(10));

        $mailer = $this->mailConfigurator->mailer('general');

        $pending = $mailer ? Mail::mailer($mailer) : Mail::mailer();
        $pending->to($user->email, $user->name)->send(new TwoFactorCodeMail($user->name, $code));
    }

    private function pendingUser(Request $request): ?User
    {
        $userId = $request->session()->get('auth.2fa.user_id');

        return $userId ? User::query()->find($userId) : null;
    }

    private function codeKey(int $userId): string
    {
        return 'two-factor-code:'.$userId;
    }
}
