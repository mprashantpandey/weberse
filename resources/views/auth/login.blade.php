<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
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
                    <div class="text-sm font-semibold uppercase tracking-[0.3em] text-brand-green">Weberse Platform</div>
                    <h1 class="mt-5 text-5xl font-semibold leading-tight text-white">Unified business operations with a cleaner control layer.</h1>
                    <p class="mt-5 max-w-lg text-base leading-7 text-slate-300">Access CRM, support, content, HR, and the client workspace through one product-grade control surface designed for operational clarity.</p>
                </div>
            </div>

            <div class="relative z-10 grid gap-4 md:grid-cols-2">
                <div class="auth-stat">
                    <div class="text-xs uppercase tracking-[0.24em] text-slate-300">Workspaces</div>
                    <div class="mt-3 text-3xl font-semibold text-white">5 Roles</div>
                    <div class="mt-2 text-sm text-slate-300">Admin, Sales, HR, Support, and Client access.</div>
                </div>
                <div class="auth-stat">
                    <div class="text-xs uppercase tracking-[0.24em] text-slate-300">Platform Scope</div>
                    <div class="mt-3 text-3xl font-semibold text-white">Core Ops</div>
                    <div class="mt-2 text-sm text-slate-300">CRM, CMS, HRM, support, hosting visibility, and billing handoff.</div>
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
                    <div class="text-sm font-semibold uppercase tracking-[0.28em] text-brand-green">Secure Access</div>
                    <h2 class="mt-3 text-3xl font-semibold text-brand-blue">Sign in to Weberse</h2>
                    <p class="mt-3 text-sm text-slate-500">Use the shared login for internal staff and clients. Access is role-aware after authentication.</p>
                </div>

                <form method="POST" action="{{ route('login.store') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">Email</label>
                        <input type="email" name="email" class="input" value="{{ old('email') }}" required>
                        @error('email')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">Password</label>
                        <input type="password" name="password" class="input" required>
                    </div>
                    <label class="flex items-center gap-2 text-sm text-slate-600">
                        <input type="checkbox" name="remember">
                        <span>Remember me</span>
                    </label>
                    <button class="btn-primary w-full justify-center" type="submit">@include('website.partials.icon', ['name' => 'shield', 'class' => 'h-4 w-4']) Login</button>
                </form>

                <div class="mt-6 rounded-[24px] border border-slate-200 bg-slate-50/90 p-4 text-sm text-slate-600">
                    <div class="font-medium text-slate-700">Seeded demo accounts</div>
                    <div class="mt-2 leading-6">`admin@weberse.test`, `sales@weberse.test`, `hr@weberse.test`, `support@weberse.test`, `client@weberse.test`</div>
                </div>

                @if (config('platform.features.quick_login'))
                    <div class="mt-6">
                        <div class="mb-3 text-sm font-medium text-slate-700">One-click local login</div>
                        <div class="quick-login-grid">
                            @foreach ([
                                ['role' => 'admin', 'label' => 'Admin'],
                                ['role' => 'sales', 'label' => 'Sales'],
                                ['role' => 'hr', 'label' => 'HR'],
                                ['role' => 'support', 'label' => 'Support'],
                                ['role' => 'client', 'label' => 'Client'],
                            ] as $quickUser)
                                <form method="POST" action="{{ route('login.quick', $quickUser['role']) }}">
                                    @csrf
                                    <button class="quick-login-card w-full" type="submit">
                                        <span>Login as {{ $quickUser['label'] }}</span>
                                        <span class="metric-icon h-9 w-9">@include('website.partials.icon', ['name' => 'arrow', 'class' => 'h-4 w-4'])</span>
                                    </button>
                                </form>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </section>
    </div>
</body>
</html>
