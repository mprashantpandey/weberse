@extends('layouts.website', ['title' => 'Hosting | Weberse Infotech'])

@section('content')
    <section class="dark-band relative overflow-hidden">
        <div class="section-shell section-spacious relative pt-12 lg:pt-16">
            <div class="grid gap-10 lg:grid-cols-[1.05fr_0.95fr] lg:items-center">
                <div data-reveal>
                    <div class="section-kicker">Hosting</div>
                    <h1 class="mt-5 headline-lg">Fast, secure hosting with a branded billing experience.</h1>
                    <p class="mt-5 body-lg text-slate-300">Choose plans, register domains, and manage services in a clean client portal built for speed, clarity, and support.</p>
                    <div class="mt-8 flex flex-wrap gap-4">
                        <a href="{{ route('billing') }}" class="btn-primary">Buy Hosting</a>
                        <a href="{{ route('billing') }}" class="btn-secondary">Check Plans</a>
                        <a href="{{ route('billing') }}?rp=/cart/domain/register" class="btn-secondary">Search Domains</a>
                    </div>

                    <div class="mt-9 flex flex-wrap items-center gap-3 text-sm text-slate-300">
                        @foreach ([
                            ['icon' => 'lucide:zap', 'label' => 'Fast setup'],
                            ['icon' => 'lucide:shield-check', 'label' => 'Secure billing'],
                            ['icon' => 'lucide:layers', 'label' => 'Branded experience'],
                            ['icon' => 'lucide:life-buoy', 'label' => 'Support-ready'],
                        ] as $chip)
                            <div class="inline-flex items-center gap-2 rounded-2xl border border-white/10 bg-white/5 px-4 py-2">
                                <iconify-icon icon="{{ $chip['icon'] }}" class="h-4 w-4 text-brand-green"></iconify-icon>
                                <span>{{ $chip['label'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="hero-media-stage" data-reveal>
                    <img src="{{ $mediaAssetUrl($websiteImages['hosting']['hero_interface'] ?? null, 'assets/images/project-hosting.svg') }}" alt="Hosting interface" class="hero-media-image">
                </div>
            </div>

            <div class="mt-10 grid gap-4 sm:grid-cols-3">
                @foreach ([
                    ['icon' => 'server', 'label' => 'Branded storefront', 'meta' => 'Plans + domain journey'],
                    ['icon' => 'receipt', 'label' => 'Billing portal', 'meta' => 'Invoices + payments'],
                    ['icon' => 'users', 'label' => 'Client portal', 'meta' => 'Services + support'],
                ] as $item)
                    <div class="glass-card premium-card flex items-center justify-between gap-4 p-5" data-reveal>
                        <div class="flex items-center gap-4">
                            <div class="premium-icon inline-flex rounded-2xl bg-white/10 p-3 text-brand-green">
                                @include('website.partials.icon', ['name' => $item['icon'], 'class' => 'h-5 w-5'])
                            </div>
                            <div>
                                <div class="text-sm font-semibold text-white">{{ $item['label'] }}</div>
                                <div class="mt-1 text-xs text-slate-300">{{ $item['meta'] }}</div>
                            </div>
                        </div>
                        <span class="badge-chip">Live</span>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="page-panel py-20 lg:py-24">
        <div class="section-shell">
            <div class="mb-10 max-w-3xl" data-reveal>
                <div class="section-kicker">Services & features</div>
                <h2 class="mt-4 headline-lg text-brand-blue">Hosting built for reliability and growth.</h2>
                <p class="mt-4 text-slate-600">Everything you need to launch and manage your website: plans, domains, billing, renewals, and support—handled inside a structured client portal.</p>
            </div>

            <div class="grid gap-6 md:grid-cols-3">
                @foreach ([
                    ['icon' => 'server', 'title' => 'Hosting plans', 'copy' => 'Choose a plan that matches your traffic and growth. Upgrade anytime.'],
                    ['icon' => 'globe', 'title' => 'Domains + DNS', 'copy' => 'Register domains, manage DNS, and keep everything in one place.'],
                    ['icon' => 'life-buoy', 'title' => 'Support + ticketing', 'copy' => 'Open tickets, track responses, and keep service history organized.'],
                    ['icon' => 'receipt', 'title' => 'Billing + renewals', 'copy' => 'Invoices, payments, and renewals handled inside your client portal.'],
                    ['icon' => 'shield', 'title' => 'Security-first', 'copy' => 'Clean account access, secure service management, and best-practice defaults.'],
                    ['icon' => 'layers', 'title' => 'Unified experience', 'copy' => 'A consistent Weberse journey from marketing pages into the client portal.'],
                ] as $item)
                    <div class="surface-card premium-card" data-reveal>
                        <div class="premium-icon inline-flex rounded-2xl bg-brand-surface p-4 text-brand-blue">
                            @include('website.partials.icon', ['name' => $item['icon'], 'class' => 'h-6 w-6'])
                        </div>
                        <h2 class="mt-5 text-2xl font-bold text-brand-blue">{{ $item['title'] }}</h2>
                        <p class="mt-4 text-slate-600">{{ $item['copy'] }}</p>
                    </div>
                @endforeach
            </div>

            <div class="section-divider mt-14 mb-0"></div>
        </div>
    </section>

    <section class="light-band">
        <div class="section-shell section-spacious">
            <div class="mb-10 max-w-3xl" data-reveal>
                <div class="section-kicker">What we sell</div>
                <h2 class="mt-4 headline-lg text-brand-blue">Hosting services for every stage.</h2>
                <p class="mt-4 text-slate-600">Pick only what you need—start small, then add security, email, and performance as you grow.</p>
            </div>

            <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
                @foreach ([
                    ['icon' => 'lucide:server', 'title' => 'Web hosting plans', 'copy' => 'Reliable hosting for websites and business landing pages.'],
                    ['icon' => 'lucide:globe', 'title' => 'Domains', 'copy' => 'Search, register, renew, and manage DNS.'],
                    ['icon' => 'lucide:shield-check', 'title' => 'SSL certificates', 'copy' => 'Secure your site and improve trust with HTTPS.'],
                    ['icon' => 'lucide:mail', 'title' => 'Business email', 'copy' => 'Professional email for your domain with clean management.'],
                    ['icon' => 'lucide:cloud', 'title' => 'Backups', 'copy' => 'Backup add-ons for safer recovery and peace of mind.'],
                    ['icon' => 'lucide:zap', 'title' => 'Performance add-ons', 'copy' => 'Caching/CDN-style optimizations depending on plan.'],
                    ['icon' => 'lucide:move-right', 'title' => 'Site migration', 'copy' => 'Move your website with minimal downtime and clear steps.'],
                    ['icon' => 'lucide:life-buoy', 'title' => 'Support services', 'copy' => 'Ticket-based support for hosting and account requests.'],
                ] as $item)
                    <div class="surface-card premium-card" data-reveal>
                        <div class="premium-icon inline-flex rounded-2xl bg-brand-surface p-4 text-brand-blue">
                            <iconify-icon icon="{{ $item['icon'] }}" class="h-6 w-6 text-brand-blue"></iconify-icon>
                        </div>
                        <h3 class="mt-5 text-2xl font-bold text-brand-blue">{{ $item['title'] }}</h3>
                        <p class="mt-4 text-slate-600">{{ $item['copy'] }}</p>
                    </div>
                @endforeach
            </div>

            <div class="mt-10 flex flex-wrap gap-4" data-reveal>
                <a href="{{ route('billing') }}" class="btn-primary">Check Plans</a>
                <a href="{{ route('billing') }}?rp=/cart/domain/register" class="btn-secondary">Search Domains</a>
            </div>
        </div>
    </section>

    <section class="light-band">
        <div class="section-shell section-spacious">
            <div class="mb-10 max-w-3xl" data-reveal>
                <div class="section-kicker">Common flows</div>
                <h2 class="mt-4 headline-lg text-brand-blue">What you can do in the client area.</h2>
            </div>

            <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
                @foreach ([
                    ['icon' => 'lucide:globe', 'title' => 'Domains', 'copy' => 'Search, register, renew, and manage DNS.'],
                    ['icon' => 'lucide:server', 'title' => 'Hosting services', 'copy' => 'Order plans, view services, and manage add-ons.'],
                    ['icon' => 'lucide:receipt', 'title' => 'Invoices', 'copy' => 'Pay invoices and track billing history.'],
                    ['icon' => 'lucide:life-buoy', 'title' => 'Support', 'copy' => 'Open tickets and track responses in one place.'],
                ] as $item)
                    <div class="surface-card premium-card" data-reveal>
                        <div class="premium-icon inline-flex rounded-2xl bg-brand-surface p-4 text-brand-blue">
                            <iconify-icon icon="{{ $item['icon'] }}" class="h-6 w-6 text-brand-blue"></iconify-icon>
                        </div>
                        <h3 class="mt-5 text-2xl font-bold text-brand-blue">{{ $item['title'] }}</h3>
                        <p class="mt-4 text-slate-600">{{ $item['copy'] }}</p>
                    </div>
                @endforeach
            </div>

            <div class="mt-10 flex flex-wrap gap-4" data-reveal>
                <a href="{{ route('billing') }}" class="btn-primary">Open Billing</a>
                <a href="{{ route('billing') }}" class="btn-secondary">Check Plans</a>
                <a href="{{ route('website.contact') }}" class="btn-secondary"
                   x-on:click.prevent="$store.marketingPopup.openLead({ title: 'Hosting inquiry', source: 'hosting_cta', context: 'Hosting inquiry', submitLabel: 'Discuss Hosting' })">
                    Discuss hosting
                </a>
            </div>
        </div>
    </section>

    <section class="section-shell py-20 lg:py-24">
        <div class="grid gap-10 lg:grid-cols-2 lg:items-start">
            <div data-reveal>
                <div class="section-kicker">FAQ</div>
                <h2 class="mt-4 text-3xl font-bold text-white">Hosting questions</h2>
                <p class="mt-4 text-slate-300">How the billing portal works and what’s included.</p>
            </div>
            <div class="space-y-3" data-reveal x-data="{ open: 0 }">
                @foreach ([
                    ['q' => 'How do I manage billing and renewals?', 'a' => 'You’ll manage invoices, payments, renewals, and services from the client portal. Everything stays in one place.'],
                    ['q' => 'Can I buy domains too?', 'a' => 'Yes. You can search and register domains directly in the cart and manage them from the client area.'],
                    ['q' => 'Will the experience match the main website?', 'a' => 'Yes. The goal is a consistent Weberse look and feel from marketing pages into the client portal.'],
                ] as $faq)
                    <div class="rounded-[28px] border border-white/10 bg-white/5 backdrop-blur-md">
                        <button type="button"
                                class="flex w-full items-center justify-between gap-4 px-5 py-4 text-left"
                                @click="open = open === {{ $loop->index }} ? -1 : {{ $loop->index }}"
                                :aria-expanded="(open === {{ $loop->index }}).toString()">
                            <span class="text-base font-semibold text-white">{{ $faq['q'] }}</span>
                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-white/10 text-brand-green">
                                <span class="transition-transform duration-200" :class="open === {{ $loop->index }} && 'rotate-180'">
                                    @include('website.partials.icon', ['name' => 'chevron', 'class' => 'h-5 w-5'])
                                </span>
                            </span>
                        </button>
                        <div x-show="open === {{ $loop->index }}"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 -translate-y-1"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 -translate-y-1"
                             class="px-5 pb-5 text-sm text-slate-300"
                             x-cloak>
                            {{ $faq['a'] }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    @include('website.partials.cta-banner')
@endsection
