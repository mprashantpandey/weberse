@extends('layouts.website', ['title' => 'About Weberse Infotech'])

@section('content')
    <section class="dark-band relative overflow-hidden">
        <div class="section-shell section-spacious">
            <div class="grid gap-10 lg:grid-cols-[1fr_0.95fr] lg:items-center">
                <div data-reveal>
                    <div class="section-kicker">About Weberse</div>
                    <h1 class="mt-5 headline-lg">Weberse builds premium digital systems.</h1>
                    <p class="mt-5 body-lg text-slate-200">We help growing businesses launch clearer websites, systems, and client platforms.</p>
                    <div class="mt-8 grid gap-4 sm:grid-cols-3">
                        @foreach ([
                            ['icon' => 'layers', 'label' => 'Structured Delivery'],
                            ['icon' => 'shield', 'label' => 'Reliable Engineering'],
                            ['icon' => 'sparkles', 'label' => 'Premium Interfaces'],
                        ] as $item)
                            <div class="glass-card premium-card p-4">
                                <div class="premium-icon inline-flex rounded-2xl bg-white/10 p-3 text-brand-green">
                                    @include('website.partials.icon', ['name' => $item['icon'], 'class' => 'h-5 w-5'])
                                </div>
                                <div class="mt-4 text-sm font-semibold text-white">{{ $item['label'] }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="hero-media-stage" data-reveal>
                    <img src="{{ $mediaAssetUrl($websiteImages['about']['hero_team'] ?? null, 'assets/legacy/team.jpg') }}" alt="Weberse team" class="hero-media-image">
                </div>
            </div>
            <div class="mt-10 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                @foreach ([
                    ['value' => '50+', 'label' => 'Projects Delivered'],
                    ['value' => '20+', 'label' => 'Client Engagements'],
                    ['value' => '5+', 'label' => 'Years in Delivery'],
                    ['value' => '1', 'label' => 'Integrated Mindset'],
                ] as $stat)
                    <div class="glass-card premium-card p-5 text-center" data-reveal>
                        <div class="text-4xl font-bold text-white">{{ $stat['value'] }}</div>
                        <div class="mt-3 text-xs font-semibold uppercase tracking-[0.24em] text-slate-300">{{ $stat['label'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="page-panel py-18 lg:py-22">
        <div class="section-shell">
            <div class="mb-10 max-w-3xl" data-reveal>
                <div class="section-kicker">Who We Are</div>
                <h2 class="mt-4 max-w-2xl text-3xl font-bold leading-[1.08] text-brand-blue md:text-4xl xl:text-[3.2rem]">A practical partner for brands that need more than a generic agency site.</h2>
                <p class="mt-4 max-w-2xl text-base leading-7 text-slate-600 md:text-lg">Weberse combines business-aware strategy, premium interface design, and maintainable engineering into one delivery approach.</p>
            </div>
            <div class="grid gap-6 lg:grid-cols-[0.78fr_1.22fr] lg:items-start">
                <div class="surface-card premium-card lg:sticky lg:top-28" data-reveal>
                    <img src="{{ $mediaAssetUrl($websiteImages['about']['strategy_meeting'] ?? null, 'assets/legacy/office-meeting.jpg') }}" alt="Weberse strategy meeting" class="h-[360px] w-full rounded-[24px] object-cover">
                    <div class="mt-5 flex items-center justify-between gap-4">
                        <div>
                            <div class="text-sm font-semibold uppercase tracking-[0.22em] text-brand-green">Weberse Approach</div>
                            <div class="mt-2 text-lg font-bold text-brand-blue">Business logic, design quality, and engineering discipline.</div>
                        </div>
                        <div class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-brand-surface text-brand-blue">
                            @include('website.partials.icon', ['name' => 'briefcase', 'class' => 'h-5 w-5'])
                        </div>
                    </div>
                </div>
                <div class="grid gap-4 md:grid-cols-2">
                    @foreach ([
                        ['icon' => 'briefcase', 'title' => 'Business-aware execution', 'copy' => 'We think in terms of offers, trust, workflows, and outcomes, not just pages and screens.'],
                        ['icon' => 'palette', 'title' => 'Design that earns trust', 'copy' => 'Our visual systems are shaped to make complex services feel clear, premium, and credible.'],
                        ['icon' => 'cpu', 'title' => 'Engineering that stays maintainable', 'copy' => 'We structure implementations so they can extend over time instead of becoming rewrite candidates.'],
                        ['icon' => 'layers', 'title' => 'Integrated delivery', 'copy' => 'Strategy, interface design, and implementation stay connected instead of breaking across handoffs.'],
                    ] as $point)
                        <div class="surface-card premium-card" data-reveal>
                            <div class="premium-icon inline-flex rounded-2xl bg-brand-surface p-4 text-brand-blue">
                                @include('website.partials.icon', ['name' => $point['icon'], 'class' => 'h-6 w-6'])
                            </div>
                            <h3 class="mt-5 text-2xl font-bold text-brand-blue">{{ $point['title'] }}</h3>
                            <p class="mt-4 text-slate-600">{{ $point['copy'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section class="dark-band">
        <div class="section-shell section-spacious">
            <div class="grid gap-10 lg:grid-cols-[0.88fr_1.12fr] lg:items-start">
                <div data-reveal>
                    <div class="section-kicker">What We Value</div>
                    <h2 class="mt-4 headline-lg">Weberse is built around clarity in both design and execution.</h2>
                    <p class="mt-4 body-lg">The standard we aim for is simple: clean thinking, good systems, and work that still feels solid after launch.</p>
                </div>
                <div class="grid gap-6 md:grid-cols-3">
                @foreach ([
                    ['icon' => 'sparkles', 'title' => 'Clarity First', 'copy' => 'We simplify complexity without flattening the product.'],
                    ['icon' => 'cpu', 'title' => 'Built to Extend', 'copy' => 'Our systems are structured so they can grow without rewriting everything.'],
                    ['icon' => 'palette', 'title' => 'Design with Purpose', 'copy' => 'Visual quality is used to improve trust, usability, and differentiation.'],
                ] as $value)
                    <div class="glass-card premium-card" data-reveal>
                        <div class="premium-icon inline-flex rounded-2xl bg-white/10 p-4 text-brand-green">
                            @include('website.partials.icon', ['name' => $value['icon'], 'class' => 'h-6 w-6'])
                        </div>
                        <h2 class="mt-5 text-2xl font-bold text-white">{{ $value['title'] }}</h2>
                        <p class="mt-4 text-slate-300">{{ $value['copy'] }}</p>
                    </div>
                @endforeach
                </div>
            </div>
        </div>
    </section>

    <section class="page-panel py-20 lg:py-24">
        <div class="section-shell">
            <div class="grid gap-10 lg:grid-cols-[1fr_0.95fr] lg:items-center">
                <div class="grid gap-4 sm:grid-cols-2" data-reveal>
                    @foreach ([
                        ['step' => '01', 'title' => 'Understand the business', 'copy' => 'We start by clarifying the offer, the audience, and the actual operational problem.'],
                        ['step' => '02', 'title' => 'Shape the experience', 'copy' => 'We turn that clarity into interfaces, structures, and content flows people can actually trust.'],
                        ['step' => '03', 'title' => 'Build the system', 'copy' => 'We implement with enough discipline that the product can extend, not just launch.'],
                        ['step' => '04', 'title' => 'Refine after release', 'copy' => 'The work improves through performance, feedback, and real operational use.'],
                    ] as $step)
                        <div class="surface-card premium-card" data-reveal>
                            <div class="text-sm font-semibold uppercase tracking-[0.24em] text-brand-green">{{ $step['step'] }}</div>
                            <h3 class="mt-4 text-xl font-bold text-brand-blue">{{ $step['title'] }}</h3>
                            <p class="mt-3 text-slate-600">{{ $step['copy'] }}</p>
                        </div>
                    @endforeach
                </div>
                <div data-reveal>
                    <div class="section-kicker">Delivery Rhythm</div>
                    <h2 class="mt-4 headline-lg text-brand-blue">We keep strategy, design, and implementation connected.</h2>
                    <p class="mt-4 text-lg leading-8 text-slate-600">That means better handoffs, less confusion, and a product that still makes sense once it becomes part of a real business workflow.</p>
                    <div class="mt-6 rounded-[28px] border border-slate-200 bg-white p-6 shadow-[0_18px_42px_rgba(13,47,80,0.08)]">
                        <img src="{{ $mediaAssetUrl($websiteImages['about']['delivery_systems'] ?? null, 'assets/legacy/work-1.jpg') }}" alt="Weberse delivery systems" class="h-[320px] w-full rounded-[22px] object-cover">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="dark-band">
        <div class="section-shell section-spacious">
            <div class="grid gap-8 lg:grid-cols-[0.9fr_1.1fr] lg:items-center">
                <div data-reveal>
                    <div class="section-kicker">Where We Help</div>
                    <h2 class="mt-4 headline-lg">Weberse works best where brand experience and system thinking need to meet.</h2>
                    <p class="mt-4 body-lg">That includes public-facing sites, client portals, software workflows, digital funnels, and the supporting interfaces that help teams operate with more control.</p>
                </div>
                <div class="grid gap-4 sm:grid-cols-2">
                    @foreach ([
                        ['icon' => 'globe', 'title' => 'Web Presence', 'copy' => 'Websites and public digital experiences with better structure, messaging, and conversion clarity.'],
                        ['icon' => 'briefcase', 'title' => 'Operational Software', 'copy' => 'Internal tools, dashboards, and business systems designed around how teams really work.'],
                        ['icon' => 'server', 'title' => 'Hosting Journeys', 'copy' => 'Hosting storefronts and branded client journeys that integrate cleanly with WHMCS.'],
                        ['icon' => 'sparkles', 'title' => 'Automation Layers', 'copy' => 'AI and workflow enhancements applied where they reduce friction and increase leverage.'],
                    ] as $step)
                        <div class="glass-card premium-card" data-reveal>
                            <div class="premium-icon inline-flex rounded-2xl bg-white/10 p-3 text-brand-green">
                                @include('website.partials.icon', ['name' => $step['icon'], 'class' => 'h-5 w-5'])
                            </div>
                            <h3 class="mt-4 text-xl font-bold text-white">{{ $step['title'] }}</h3>
                            <p class="mt-3 text-slate-300">{{ $step['copy'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section class="page-panel py-20 lg:py-24">
        <div class="section-shell">
            <div class="mb-10" data-reveal>
                <div class="section-kicker">Capabilities</div>
                <h2 class="mt-4 headline-lg text-brand-blue">Core services shaped around product quality and operational fit.</h2>
                <p class="mt-4 max-w-2xl text-lg text-slate-600">These are the areas where Weberse typically brings the most value for growing digital-first businesses.</p>
            </div>
            <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
                @foreach ($serviceDetails as $service)
                    @include('website.partials.service-card', ['service' => $service, 'light' => true])
                @endforeach
            </div>
        </div>
    </section>

    <section class="section-shell py-20 lg:py-24">
        <div class="mb-10 max-w-3xl" data-reveal>
            <div class="section-kicker">Technology Perspective</div>
            <h2 class="mt-4 headline-lg">A stack chosen for reliability, speed, and pragmatic control.</h2>
            <p class="mt-4 body-lg">We select tools based on delivery value and maintainability, not trend-chasing.</p>
        </div>
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach($technologies as $technology)
                <div class="surface-card flex items-center gap-4 py-5" data-reveal>
                    <div class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-brand-surface text-brand-blue">
                        @include('website.partials.icon', ['name' => ['layers', 'cpu', 'database', 'cloud'][($loop->index % 4)], 'class' => 'h-5 w-5'])
                    </div>
                    <div class="text-sm font-semibold text-slate-700">{{ $technology }}</div>
                </div>
            @endforeach
        </div>
    </section>

    @include('website.partials.cta-banner')
@endsection
