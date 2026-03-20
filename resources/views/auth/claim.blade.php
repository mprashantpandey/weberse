<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Set password</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="auth-shell">
    <div class="auth-wrapper">
        <section class="auth-brand-panel">
            <div class="relative z-10">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('assets/legacy/weberse-light.svg') }}" alt="Weberse logo" class="h-12 w-auto">
                </div>
                <div class="mt-12 max-w-xl">
                    <div class="text-sm font-semibold uppercase tracking-[0.3em] text-brand-green">Weberse Store</div>
                    <h1 class="mt-5 text-5xl font-semibold leading-tight text-white">Your downloads, secured.</h1>
                    <p class="mt-5 max-w-lg text-base leading-7 text-slate-300">Set a password once and access your purchases from your client dashboard anytime.</p>
                </div>
            </div>
        </section>

        <section class="auth-form-shell">
            <div class="auth-form-card">
                <div class="mb-8">
                    <div class="mb-5 xl:hidden">
                        <img src="{{ asset('assets/legacy/weberse-dark.svg') }}" alt="Weberse logo" class="h-12 w-auto">
                    </div>
                    <div class="mb-5 hidden xl:block">
                        <img src="{{ asset('assets/legacy/weberse-dark.svg') }}" alt="Weberse logo" class="h-12 w-auto">
                    </div>
                    <div class="text-sm font-semibold uppercase tracking-[0.28em] text-brand-green">Account Setup</div>
                    <h2 class="mt-3 text-3xl font-semibold text-brand-blue">Set your password</h2>
                    <p class="mt-3 text-sm text-slate-500">
                        This will secure your account for <span class="font-semibold text-slate-700">{{ $email }}</span>.
                    </p>
                </div>

                <form method="POST" action="{{ route('account.claim.store', ['token' => $token]) }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">New password</label>
                        <input type="password" name="password" class="input" required>
                        @error('password')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">Confirm password</label>
                        <input type="password" name="password_confirmation" class="input" required>
                    </div>
                    <button class="btn-primary w-full justify-center" type="submit">
                        @include('website.partials.icon', ['name' => 'shield', 'class' => 'h-4 w-4'])
                        Save password
                    </button>
                </form>

                <div class="mt-6 rounded-[24px] border border-slate-200 bg-slate-50/90 p-4 text-sm text-slate-600">
                    After setting your password, you’ll be signed in automatically and redirected to your dashboard.
                </div>
            </div>
        </section>
    </div>
</body>
</html>

