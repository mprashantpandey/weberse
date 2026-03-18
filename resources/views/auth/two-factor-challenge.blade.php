@extends('layouts.guest')

@section('content')
    <div class="auth-shell">
        <div class="auth-form-panel">
            <div class="auth-form-card max-w-md">
                <img src="{{ asset('assets/legacy/weberse-dark.svg') }}" alt="Weberse" class="h-10 w-auto">
                <div class="mt-6 text-xs font-semibold uppercase tracking-[0.28em] text-brand-green">Verification required</div>
                <h1 class="mt-3 text-3xl font-semibold text-brand-blue">Enter your login code</h1>
                <p class="mt-3 text-sm text-slate-500">We sent a 6-digit verification code to {{ $email }}.</p>

                @if (session('status'))
                    <div class="mt-5 rounded-2xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">{{ session('status') }}</div>
                @endif

                <form method="POST" action="{{ route('two-factor.store') }}" class="mt-6 space-y-4">
                    @csrf
                    <input class="input text-center tracking-[0.35em]" name="code" inputmode="numeric" maxlength="6" placeholder="123456" required>
                    @error('code')
                        <div class="text-sm text-red-600">{{ $message }}</div>
                    @enderror
                    <button class="btn-primary w-full justify-center">Verify & Continue</button>
                </form>

                <form method="POST" action="{{ route('two-factor.resend') }}" class="mt-3">
                    @csrf
                    <button class="btn-secondary w-full justify-center">Resend Code</button>
                </form>
            </div>
        </div>
    </div>
@endsection
