<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Dashboard' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="shell" x-data="{ mobileMenu: false }">
    @php
        $navIcons = [
            'Overview' => 'dashboard',
            'CMS' => 'layers',
            'Clients' => 'briefcase',
            'Store' => 'cart',
            'CRM' => 'users',
            'HRM' => 'briefcase',
            'Jobs' => 'briefcase',
            'Applications' => 'file',
            'Employees' => 'user',
            'Leave' => 'calendar',
            'Attendance' => 'clock',
            'Interviews' => 'calendar',
            'Compensation' => 'receipt',
            'Expenses' => 'wallet',
            'Perks' => 'sparkles',
            'Support' => 'ticket',
            'Email' => 'mail',
            'Templates' => 'file',
            'Subscribers' => 'users',
            'Campaigns' => 'mail',
            'Compose' => 'mail',
            'Analytics' => 'chart',
            'Settings' => 'settings',
            'Security' => 'shield',
            'Hosting' => 'server',
            'Domains' => 'globe',
            'Invoices' => 'receipt',
            'Documents' => 'folder',
            'Profile' => 'user',
        ];
        $resolvedNav = $nav ?? [];
        if (auth()->user()?->hasRole('admin') && ! collect($resolvedNav)->contains(fn ($item) => ($item['label'] ?? null) === 'Clients')) {
            array_splice($resolvedNav, 1, 0, [[
                'label' => 'Clients',
                'route' => 'admin.clients.index',
                'active' => 'admin.clients.*',
            ]]);
        }
        if (auth()->user()?->hasRole('admin') && ! collect($resolvedNav)->contains(fn ($item) => ($item['label'] ?? null) === 'Store')) {
            array_splice($resolvedNav, 2, 0, [[
                'label' => 'Store',
                'route' => 'admin.store.products.index',
                'active' => 'admin.store.*',
            ]]);
        }
        if (auth()->user()?->hasRole('admin')) {
            $resolvedNav[] = ['label' => 'Email', 'route' => 'admin.email.index', 'active' => 'admin.email.*'];
            $resolvedNav[] = ['label' => 'Settings', 'route' => 'admin.settings.index', 'active' => 'admin.settings.*'];
        }
    @endphp
    <div class="dashboard-shell">
        <aside class="dashboard-sidebar hidden xl:sticky xl:top-4 xl:block xl:h-[calc(100vh-2rem)]">
            <div class="relative z-10">
                <div class="inline-flex rounded-2xl bg-white/10 p-3 shadow-[inset_0_1px_0_rgba(255,255,255,0.18)]">
                    <img src="{{ asset('assets/legacy/weberse-light.svg') }}" alt="Weberse logo" class="h-9 w-auto">
                </div>
            </div>

            <div class="dashboard-user-card relative z-10 mt-8">
                <div class="text-xs uppercase tracking-[0.28em] text-slate-300">Signed in as</div>
                <div class="mt-3 text-xl font-semibold text-white">{{ auth()->user()->name }}</div>
                <div class="mt-1 text-sm text-slate-300">{{ auth()->user()->email }}</div>
                <div class="mt-4 inline-flex rounded-full bg-white/8 px-3 py-1 text-xs font-medium text-slate-200">
                    {{ auth()->user()->job_title ?: 'Weberse User' }}
                </div>
            </div>

            <div class="relative z-10 mt-8 text-xs uppercase tracking-[0.26em] text-slate-400">Workspace</div>
            <nav class="relative z-10 mt-3 space-y-2">
                @foreach ($resolvedNav as $item)
                    <a href="{{ route($item['route']) }}" class="sidebar-link {{ request()->routeIs($item['active']) ? 'sidebar-link-active' : '' }}">
                        <span class="sidebar-icon">
                            @include('website.partials.icon', ['name' => $navIcons[$item['label']] ?? 'dashboard', 'class' => 'h-4 w-4'])
                        </span>
                        <span>{{ $item['label'] }}</span>
                    </a>
                @endforeach
            </nav>

            <div class="relative z-10 mt-auto pt-8">
                <div class="rounded-[24px] border border-white/10 bg-white/5 p-4 text-sm text-slate-300">
                    Operational access, hiring, support, and content management in one system.
                </div>
            </div>

            <form method="POST" action="{{ route('logout') }}" class="relative z-10 mt-4">
                @csrf
                <button class="btn-secondary w-full justify-center">@include('website.partials.icon', ['name' => 'shield', 'class' => 'h-4 w-4']) Logout</button>
            </form>
        </aside>

        <section class="dashboard-main">
            <div class="mobile-dashboard-bar">
                <div class="flex items-center gap-3">
                    <div class="rounded-2xl bg-brand-blue p-2 text-white">
                        @include('website.partials.icon', ['name' => 'dashboard', 'class' => 'h-4 w-4'])
                    </div>
                    <div>
                        <div class="text-sm font-semibold text-brand-blue">{{ $heading ?? 'Dashboard' }}</div>
                        <div class="text-xs text-slate-500">{{ auth()->user()->getRoleNames()->first() ?? 'user' }} workspace</div>
                    </div>
                </div>
                <button class="inline-flex h-11 w-11 items-center justify-center rounded-2xl border border-[rgba(13,47,80,0.12)] bg-white/90 text-brand-blue shadow-[0_10px_24px_rgba(13,47,80,0.08)]" type="button" @click="mobileMenu = !mobileMenu">
                    <span x-show="!mobileMenu">@include('website.partials.icon', ['name' => 'menu', 'class' => 'h-5 w-5'])</span>
                    <span x-show="mobileMenu">@include('website.partials.icon', ['name' => 'close', 'class' => 'h-5 w-5'])</span>
                </button>
            </div>

            <div class="mobile-dashboard-menu" x-show="mobileMenu" x-transition>
                <div class="rounded-[20px] border border-[rgba(13,47,80,0.06)] bg-white/70 px-4 py-4 shadow-[inset_0_1px_0_rgba(255,255,255,0.6)]">
                    <div class="text-xs uppercase tracking-[0.22em] text-slate-500">Signed in as</div>
                    <div class="mt-2 text-base font-semibold text-brand-blue">{{ auth()->user()->name }}</div>
                    <div class="mt-1 text-sm text-slate-500">{{ auth()->user()->email }}</div>
                </div>
                <nav class="mt-4 space-y-2">
                    @foreach ($resolvedNav as $item)
                        <a href="{{ route($item['route']) }}" class="mobile-nav-link {{ request()->routeIs($item['active']) ? 'mobile-nav-link-active' : '' }}">
                            <span class="mobile-nav-icon">
                                @include('website.partials.icon', ['name' => $navIcons[$item['label']] ?? 'dashboard', 'class' => 'h-4 w-4'])
                            </span>
                            <span>{{ $item['label'] }}</span>
                        </a>
                    @endforeach
                </nav>
                <form method="POST" action="{{ route('logout') }}" class="mt-4">
                    @csrf
                    <button class="btn-secondary w-full justify-center">@include('website.partials.icon', ['name' => 'shield', 'class' => 'h-4 w-4']) Logout</button>
                </form>
            </div>

            <header class="dashboard-topbar flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div class="relative z-10">
                    <div class="text-xs font-semibold uppercase tracking-[0.28em] text-brand-green">Operational View</div>
                    <h1 class="mt-3 text-3xl font-semibold text-brand-blue">{{ $heading ?? 'Dashboard' }}</h1>
                    <p class="mt-2 text-sm text-slate-500">{{ $subheading ?? 'Unified operations for Weberse.' }}</p>
                </div>
                <div class="relative z-10 flex flex-wrap items-center gap-3">
                    <div class="topbar-pill">@include('website.partials.icon', ['name' => 'calendar', 'class' => 'h-4 w-4']) {{ now()->format('d M Y') }}</div>
                    <div class="topbar-pill">@include('website.partials.icon', ['name' => 'user', 'class' => 'h-4 w-4']) {{ auth()->user()->job_title ?: 'Weberse User' }}</div>
                    @if (auth()->user()?->hasAnyRole(['admin', 'hr', 'sales', 'support']))
                        @if (request()->routeIs('employee.*'))
                            <a href="{{ route('admin.dashboard') }}" class="btn-dark">@include('website.partials.icon', ['name' => 'dashboard', 'class' => 'h-4 w-4']) Admin Workspace</a>
                        @else
                            <a href="{{ route('employee.dashboard') }}" class="btn-dark">@include('website.partials.icon', ['name' => 'user', 'class' => 'h-4 w-4']) Employee Workspace</a>
                        @endif
                    @endif
                    @if (auth()->user()?->hasRole('admin'))
                        <a href="{{ route('admin.settings.index') }}" class="btn-dark">@include('website.partials.icon', ['name' => 'settings', 'class' => 'h-4 w-4']) Settings</a>
                    @endif
                    <a href="{{ route('security.index') }}" class="btn-dark">@include('website.partials.icon', ['name' => 'shield', 'class' => 'h-4 w-4']) Security</a>
                    @isset($headerAction)
                        {{ $headerAction }}
                    @endisset
                </div>
            </header>

            @hasSection('quick_actions')
                <section class="dashboard-quick-actions">
                    @yield('quick_actions')
                </section>
            @endif

            @yield('content')
        </section>
    </div>
</body>
</html>
