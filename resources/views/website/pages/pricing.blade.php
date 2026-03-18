@extends('layouts.website', ['title' => 'Pricing | Weberse Infotech'])

@section('content')
    <section class="dark-band relative overflow-hidden">
        <div class="section-shell section-spacious relative pt-12 lg:pt-16">
            <div class="grid gap-10 lg:grid-cols-[1.05fr_0.95fr] lg:items-center">
                <div class="max-w-3xl" data-reveal>
                    <div class="section-kicker">Pricing</div>
                    <h1 class="mt-5 headline-lg">Clear pricing for serious work.</h1>
                    <p class="mt-5 body-lg text-slate-300">Choose a model that matches your timeline: fixed-scope builds, ongoing delivery, or custom system development.</p>
                    <div class="mt-7 flex flex-wrap gap-4">
                        <a href="{{ route('website.contact') }}" class="btn-primary"
                           x-on:click.prevent="$store.marketingPopup.openLead({ title: 'Request a Quote', source: 'pricing_cta', context: 'Pricing page quote request', submitLabel: 'Request Quote' })">
                            @include('website.partials.icon', ['name' => 'calendar', 'class' => 'h-4 w-4'])
                            Request a Quote
                        </a>
                        <a href="{{ route('website.portfolio') }}" class="btn-secondary">
                            @include('website.partials.icon', ['name' => 'layers', 'class' => 'h-4 w-4'])
                            See Our Work
                        </a>
                    </div>
                </div>
                <div class="hero-media-stage" data-reveal>
                    <img src="{{ $mediaAssetUrl($websiteImages['pricing']['hero_showcase'] ?? null, 'assets/images/service-showcase.svg') }}" alt="Pricing showcase" class="hero-media-image">
                </div>
            </div>

            <div class="mt-10 grid gap-4 sm:grid-cols-3">
                @foreach ([
                    ['icon' => 'shield', 'label' => 'Clear scope', 'meta' => 'No vague promises'],
                    ['icon' => 'calendar', 'label' => 'Predictable delivery', 'meta' => 'Visible milestones'],
                    ['icon' => 'chart', 'label' => 'Built for extension', 'meta' => 'Maintainable systems'],
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
                        <span class="badge-chip">Included</span>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="page-panel py-20 lg:py-24">
        <div class="section-shell">
            <div class="mb-10 max-w-3xl" data-reveal>
                <div class="section-kicker">Engagement models</div>
                <h2 class="mt-4 headline-lg text-brand-blue">Pick a plan based on delivery style.</h2>
                <p class="mt-4 text-slate-600">Final pricing depends on scope. These packages explain how we work and what you can expect.</p>
            </div>

            <div class="grid gap-6 md:grid-cols-3">
                @foreach ([
                    [
                        'badge' => 'Starter',
                        'title' => 'Single Project',
                        'price' => 'Best for a focused build',
                        'icon' => 'rocket',
                        'desc' => 'Landing pages, smaller websites, or a defined feature set with a clear finish line.',
                        'items' => ['Fixed scope & timeline', 'Design + development', 'Launch support', 'Performance + SEO basics'],
                    ],
                    [
                        'badge' => 'Growth',
                        'title' => 'Ongoing Retainer',
                        'price' => 'Best for continuous shipping',
                        'icon' => 'layers',
                        'desc' => 'A consistent design & engineering partner for roadmap-driven delivery.',
                        'items' => ['Monthly or quarterly blocks', 'Roadmap-based priorities', 'Priority support', 'Iteration + improvements'],
                        'featured' => true,
                    ],
                    [
                        'badge' => 'Custom',
                        'title' => 'Custom Engagement',
                        'price' => 'Best for complex systems',
                        'icon' => 'cpu',
                        'desc' => 'Platforms, integrations, and multi-phase rollouts tailored to your workflow.',
                        'items' => ['Scoping workshop', 'Phased delivery plan', 'Architecture + modules', 'Training + handover'],
                    ],
                ] as $plan)
                    <div class="{{ ($plan['featured'] ?? false) ? 'surface-card premium-card ring-1 ring-brand-green/35 shadow-[0_22px_54px_rgba(13,47,80,0.14)]' : 'surface-card premium-card' }}" data-reveal>
                        <div class="flex items-start justify-between gap-4">
                            <div class="premium-icon inline-flex rounded-2xl bg-brand-surface p-4 text-brand-blue">
                                @include('website.partials.icon', ['name' => $plan['icon'], 'class' => 'h-6 w-6'])
                            </div>
                            <span class="badge-chip !bg-brand-blue/10 !text-brand-blue">{{ $plan['badge'] }}</span>
                        </div>
                        <h3 class="mt-5 text-2xl font-bold text-brand-blue">{{ $plan['title'] }}</h3>
                        <div class="mt-2 text-sm font-semibold text-slate-600">{{ $plan['price'] }}</div>
                        <p class="mt-4 text-slate-600">{{ $plan['desc'] }}</p>
                        <ul class="mt-6 space-y-3 text-sm text-slate-700">
                            @foreach ($plan['items'] as $line)
                                <li class="flex items-start gap-3">
                                    <span class="mt-0.5 inline-flex h-8 w-8 items-center justify-center rounded-2xl bg-brand-surface text-brand-blue">
                                        @include('website.partials.icon', ['name' => 'check', 'class' => 'h-4 w-4'])
                                    </span>
                                    <span class="font-semibold">{{ $line }}</span>
                                </li>
                            @endforeach
                        </ul>
                        <div class="mt-8">
                            <a href="{{ route('website.contact') }}"
                               class="{{ ($plan['featured'] ?? false) ? 'btn-primary w-full justify-center' : 'btn-dark w-full justify-center' }}"
                               x-on:click.prevent="$store.marketingPopup.openLead({ title: @js($plan['title'].' Quote'), source: 'pricing_plan_cta', context: @js('Pricing: '.$plan['title']), submitLabel: 'Request Quote' })">
                                Request Quote
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="light-band">
        <div class="section-shell section-spacious">
            <div class="mb-10 max-w-3xl" data-reveal>
                <div class="section-kicker">Add-ons</div>
                <h2 class="mt-4 headline-lg text-brand-blue">Common add-ons teams ask for.</h2>
                <p class="mt-4 text-slate-600">You can attach these to any engagement depending on what you’re building.</p>
            </div>

            <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
                @foreach ([
                    ['icon' => 'shield', 'title' => 'Security hardening', 'copy' => 'Auth, permissions, audit trails, and safer defaults.'],
                    ['icon' => 'chart', 'title' => 'Analytics + tracking', 'copy' => 'Events, funnels, dashboards, and reporting.'],
                    ['icon' => 'server', 'title' => 'DevOps / deployment', 'copy' => 'CI/CD, environments, backups, monitoring and alerts.'],
                    ['icon' => 'smartphone', 'title' => 'Mobile app build', 'copy' => 'Native/cross-platform delivery for the same product.'],
                    ['icon' => 'briefcase', 'title' => 'Custom software modules', 'copy' => 'CRM, support, ops dashboards, internal tools.'],
                    ['icon' => 'mail', 'title' => 'Email automation', 'copy' => 'Lifecycle sequences, deliverability, segmentation.'],
                    ['icon' => 'bot', 'title' => 'AI & automation', 'copy' => 'Chatbots, workflows, knowledge base + guardrails.'],
                    ['icon' => 'globe', 'title' => 'SEO + performance', 'copy' => 'Core Web Vitals, technical SEO, and speed improvements.'],
                ] as $item)
                    <div class="surface-card premium-card" data-reveal>
                        <div class="premium-icon inline-flex rounded-2xl bg-brand-surface p-4 text-brand-blue">
                            @include('website.partials.icon', ['name' => $item['icon'], 'class' => 'h-6 w-6'])
                        </div>
                        <h3 class="mt-5 text-2xl font-bold text-brand-blue">{{ $item['title'] }}</h3>
                        <p class="mt-4 text-slate-600">{{ $item['copy'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section-shell py-20 lg:py-24">
        <div class="grid gap-10 lg:grid-cols-2 lg:items-start">
            <div data-reveal>
                <div class="section-kicker">FAQ</div>
                <h2 class="mt-4 text-3xl font-bold text-white">Pricing questions</h2>
                <p class="mt-4 text-slate-300">How we scope, quote, and keep delivery predictable.</p>
            </div>
            <div class="space-y-3" data-reveal x-data="{ open: 0 }">
                @foreach ([
                    ['q' => 'Do you share exact prices on the website?', 'a' => 'Pricing depends on scope, timeline, integrations, and the number of screens/modules. We keep the website simple and provide a detailed quote after scope clarity.'],
                    ['q' => 'Can you do fixed-price projects?', 'a' => 'Yes—when scope is clear. We define deliverables and milestones first, then quote for a fixed scope and timeline.'],
                    ['q' => 'What is included in a retainer?', 'a' => 'A retainer is a structured delivery partnership: roadmap priorities, continuous shipping, and a consistent team with predictable output each cycle.'],
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
