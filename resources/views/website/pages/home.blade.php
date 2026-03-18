@extends('layouts.website', [
    'title' => 'Weberse Infotech | Digital & Development Agency',
    'description' => 'A digital and development agency for premium websites, platforms, and automation — including hosting, digital marketing, WhatsApp Cloud, and email automation.',
])

@section('content')
    <section class="dark-band relative overflow-hidden">
        <div class="section-shell section-spacious relative pt-12 lg:pt-16">
        <div class="grid gap-10 lg:grid-cols-[1.1fr_0.9fr] lg:items-center">
            <div data-reveal>
                <div class="section-kicker">Let&apos;s Build</div>
                <h1 class="mt-5 max-w-3xl text-4xl font-bold leading-[1.08] md:text-5xl xl:text-[3.85rem]">Premium websites and platforms that convert.</h1>
                <p class="mt-5 max-w-lg text-base leading-8 text-slate-300 md:text-lg">
                    Weberse designs and builds modern digital systems and marketing funnels for ambitious brands.
                </p>
                <div class="mt-4 flex flex-wrap gap-2">
                    <span class="badge-chip inline-flex items-center gap-2">
                        @include('website.partials.icon', ['name' => 'layers', 'class' => 'h-4 w-4'])
                        Digital Marketing
                    </span>
                    <span class="badge-chip inline-flex items-center gap-2">
                        @include('website.partials.icon', ['name' => 'globe', 'class' => 'h-4 w-4'])
                        Web Development
                    </span>
                    <span class="badge-chip inline-flex items-center gap-2">
                        @include('website.partials.icon', ['name' => 'sparkles', 'class' => 'h-4 w-4'])
                        Automation & AI
                    </span>
                </div>
                <div class="mt-7 flex flex-wrap gap-4">
                    <a href="{{ route('website.contact') }}"
                       class="btn-primary"
                       data-lead-popup
                       data-lead-title="Get a Free Consultation"
                       data-lead-source="hero_get_quote"
                       data-lead-context="Homepage consultation request"
                       data-lead-submit="Book Free Consultation"
                       x-on:click.prevent="$store.marketingPopup.openLead({ title: 'Get a Free Consultation', source: 'hero_get_quote', context: 'Homepage consultation request', submitLabel: 'Book Free Consultation' })">@include('website.partials.icon', ['name' => 'calendar', 'class' => 'h-4 w-4']) Get Free Consultation</a>
                    @if ($websiteFeatures['portfolio_enabled'])
                        <a href="{{ route('website.portfolio') }}" class="btn-secondary">@include('website.partials.icon', ['name' => 'layers', 'class' => 'h-4 w-4']) See Our Work</a>
                    @endif
                </div>
            </div>

            <div data-reveal>
                <div class="hero-media-stage">
                    <img src="{{ $mediaAssetUrl($websiteImages['home']['hero_dashboard'] ?? null, 'assets/images/dashboard-mockup.svg') }}" alt="Dashboard mockup" class="hero-media-image relative z-10">
                </div>
            </div>
        </div>
        </div>
    </section>

    <section class="light-band">
        <div class="section-shell py-8 sm:py-10">
        <div class="stats-grid">
            @foreach ([
                ['value' => 50, 'label' => 'Projects Delivered'],
                ['value' => 20, 'label' => 'Active Client Engagements'],
                ['value' => 5, 'label' => 'Years in Delivery'],
                ['value' => 12, 'label' => 'Production Technologies'],
            ] as $stat)
                <div class="stat-card" data-reveal>
                    <div class="counter" data-counter-target="{{ $stat['value'] }}">0+</div>
                    <div class="mt-3 text-sm uppercase tracking-[0.22em] text-slate-600">{{ $stat['label'] }}</div>
                </div>
            @endforeach
        </div>
        </div>
    </section>

    <section class="light-band">
        <div class="section-shell section-spacious">
        <div class="mb-8 max-w-3xl" data-reveal>
            <div class="section-kicker">Services Overview</div>
            <h2 class="mt-4 headline-lg text-brand-blue">Web builds, funnel strategy, and marketing systems that grow.</h2>
        </div>
        <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
            @foreach ($serviceDetails as $service)
                @include('website.partials.service-card', ['service' => $service, 'light' => true])
            @endforeach
        </div>
        </div>
    </section>

    <section class="dark-band">
        <div class="section-shell section-spacious">
        <div class="mb-6 max-w-3xl" data-reveal>
            <div class="section-kicker">Advanced Tech Stack</div>
            <h2 class="mt-4 headline-lg">Production-ready technology choices for fast shipping, stable systems, and cloud-native scale.</h2>
            <p class="mt-4 max-w-2xl body-lg">
                We build for delivery speed and include growth instrumentation: landing pages, tracking, analytics dashboards, and clean conversion reporting.
            </p>
        </div>
        <div class="grid gap-6 lg:grid-cols-2 xl:grid-cols-4">
            @foreach ($techStack as $group)
                <div class="glass-card premium-card" data-reveal>
                    <div class="text-xs uppercase tracking-[0.24em] text-brand-green">{{ $group['category'] }}</div>
                    <h3 class="mt-3 text-2xl font-bold text-white">{{ $group['category'] }} Systems</h3>
                    <p class="mt-3 text-sm text-slate-300">{{ $group['summary'] }}</p>
                    <div class="mt-6 space-y-3">
                        @foreach ($group['items'] as $item)
                            <div class="stack-item">
                                <div class="flex items-center gap-3">
                                    <div class="stack-logo inline-flex h-10 w-10 items-center justify-center rounded-2xl text-white">
                                        <span
                                            data-simple-icon="{{ $item['icon'] }}"
                                            data-fallback="{{ match($item['icon']) {
                                                'aws-fallback' => 'AWS',
                                                'openai-fallback' => 'AI',
                                                'database-fallback' => 'DB',
                                                default => strtoupper(substr($item['label'], 0, 2)),
                                            } }}"
                                            class="flex h-5 w-5 items-center justify-center"
                                        ></span>
                                    </div>
                                    <div>
                                        <div class="text-sm font-semibold text-white">{{ $item['label'] }}</div>
                                        <div class="text-xs text-slate-400">{{ $item['meta'] }}</div>
                                    </div>
                                </div>
                                <span class="badge-chip">Ready</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
        </div>
    </section>

    @if ($websiteFeatures['portfolio_enabled'])
        <section class="page-panel py-16 lg:py-20">
            <div class="light-grid relative">
                <div class="section-shell">
                    <div class="mb-8 max-w-3xl" data-reveal>
                        <div class="section-kicker">Featured Projects</div>
                        <h2 class="mt-4 headline-lg text-brand-blue">Selected work that balances visual quality with business utility.</h2>
                    </div>
                    <div class="grid gap-6 lg:grid-cols-3">
                        @foreach ($featuredProjects as $project)
                            @include('website.partials.project-card', ['project' => $project, 'light' => true])
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if (($websiteFeatures['case_studies_enabled'] ?? false) && $caseStudies->isNotEmpty())
        <section class="page-panel py-16 lg:py-20">
            <div class="section-shell">
                <div class="mb-8 flex flex-col gap-4 md:flex-row md:items-end md:justify-between" data-reveal>
                    <div>
                        <div class="section-kicker">Case Studies</div>
                        <h2 class="mt-4 headline-lg text-brand-blue">Real delivery stories behind the work.</h2>
                    </div>
                    <a href="{{ route('website.case-studies.index') }}" class="btn-dark">View Case Studies</a>
                </div>
                <div class="grid gap-6 lg:grid-cols-2">
                    @foreach ($caseStudies as $caseStudy)
                        <article class="surface-card premium-card overflow-hidden" data-reveal>
                            <div class="content-image-frame h-72">
                                <img
                                    src="{{ $mediaAssetUrl($caseStudy->featured_image, 'assets/images/map-placeholder.svg') }}"
                                    alt="{{ $caseStudy->title }}"
                                    class="rounded-[24px]"
                                >
                            </div>
                            <div class="mt-5 flex items-center justify-between gap-4">
                                <div>
                                    <div class="text-sm font-semibold text-brand-green">{{ $caseStudy->client }}</div>
                                    <div class="mt-1 text-sm text-slate-500">{{ $caseStudy->industry }}</div>
                                </div>
                                <span class="surface-badge">{{ $caseStudy->duration }}</span>
                            </div>
                            <h3 class="mt-4 text-2xl font-bold text-brand-blue">{{ $caseStudy->title }}</h3>
                            <p class="mt-3 text-slate-600">{{ $caseStudy->summary }}</p>
                            <a href="{{ route('website.case-studies.show', $caseStudy->slug) }}" class="mt-5 inline-flex items-center gap-2 text-sm font-semibold text-brand-blue">
                                Read Case Study
                                @include('website.partials.icon', ['name' => 'arrow', 'class' => 'h-4 w-4'])
                            </a>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <section class="dark-band">
        <div class="section-shell py-16 lg:py-20">
        <div class="grid gap-6 lg:grid-cols-[0.9fr_1.1fr] lg:items-center">
            <div data-reveal>
                <div class="section-kicker">Development Process</div>
                <h2 class="mt-4 headline-lg">A structured delivery rhythm that keeps design and engineering aligned.</h2>
                <p class="mt-4 body-lg">Every engagement moves through discovery, design architecture, implementation, and refinement with visible checkpoints.</p>
            </div>
            <div class="process-track grid gap-4 sm:grid-cols-2">
                @foreach (['Discover', 'Design', 'Build', 'Optimize'] as $index => $step)
                    <div class="glass-card process-step premium-card" data-reveal>
                        @if ($index < 3)
                            <span class="step-line hidden sm:block"></span>
                        @endif
                        <div class="text-sm font-semibold uppercase tracking-[0.25em] text-brand-green">0{{ $index + 1 }}</div>
                        <h3 class="mt-4 text-2xl font-bold text-white">{{ $step }}</h3>
                        <p class="mt-3 text-slate-300">
                            {{
                                [
                                    'Clarify goals, audience, and offer positioning.',
                                    'Shape structure, visuals, and conversion flow.',
                                    'Implement responsive interfaces and the tracking hooks that keep campaigns measurable.',
                                    'Refine performance, content, and conversion insights for launch and iteration.'
                                ][$index]
                            }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
        </div>
    </section>

    @if ($websiteFeatures['testimonials_enabled'])
        <section class="page-panel py-16 lg:py-20">
            <div class="section-shell">
                <div class="mb-8 max-w-3xl" data-reveal>
                    <div class="section-kicker">Client Testimonials</div>
                    <h2 class="mt-4 headline-lg text-brand-blue">Feedback from businesses that needed better digital clarity.</h2>
                </div>
                <div class="mb-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ([
                        ['src' => 'clutchreview.svg', 'alt' => 'Clutch'],
                        ['src' => 'appstore.svg', 'alt' => 'App Store'],
                        ['src' => 'trustplot.svg', 'alt' => 'Trustpilot'],
                        ['src' => 'logo-1.png', 'alt' => 'Client logo'],
                    ] as $logo)
                        <div class="logo-pill" data-reveal>
                            <img src="{{ asset('assets/legacy/'.$logo['src']) }}" alt="{{ $logo['alt'] }}" class="max-h-8 w-auto object-contain">
                        </div>
                    @endforeach
                </div>
                <div x-data="{ active: 0, total: {{ $testimonials->count() }} }" x-init="setInterval(() => active = (active + 1) % total, 5000)" class="testimonial-slider">
                    <div class="testimonial-track" :style="`transform: translateX(-${active * 100}%);`">
                        @foreach ($testimonials as $testimonial)
                            <div class="min-w-full px-1">
                                @include('website.partials.testimonial-card', ['testimonial' => $testimonial, 'light' => true])
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-6 flex items-center justify-center gap-3 rounded-full bg-white/80 py-2 shadow-[0_10px_24px_rgba(13,47,80,0.06)]">
                        @foreach ($testimonials as $index => $testimonial)
                            <button @click="active = {{ $index }}" :class="active === {{ $index }} ? 'bg-brand-blue w-8' : 'bg-slate-300 w-3'" class="h-3 rounded-full transition-all duration-300"></button>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif

    <section class="dark-band">
        <div class="section-shell py-16 lg:py-20">
        <div class="mb-6" data-reveal>
            <div class="section-kicker">Industries Served</div>
            <h2 class="mt-4 headline-lg">Sector-aware solutions for teams that need both speed and structure.</h2>
        </div>
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($industries as $industry)
                <div class="glass-card premium-card flex items-center justify-between gap-4" data-reveal>
                    <div class="flex items-center gap-4">
                        <div class="premium-icon inline-flex rounded-2xl bg-white/10 p-3 text-brand-green">
                            @include('website.partials.icon', ['name' => $industry['icon'], 'class' => 'h-5 w-5'])
                        </div>
                        <div class="text-xl font-bold text-white">{{ $industry['label'] }}</div>
                    </div>
                    <span class="badge-chip">Sector</span>
                </div>
            @endforeach
        </div>
        </div>
    </section>

    @if ($websiteFeatures['blog_enabled'])
        <section class="page-panel py-16 lg:py-20">
            <div class="section-shell">
                <div class="mb-8 flex flex-col gap-4 md:flex-row md:items-end md:justify-between" data-reveal>
                    <div>
                        <div class="section-kicker">Blog Preview</div>
                        <h2 class="mt-4 headline-lg text-brand-blue">Insights on digital products, systems, and delivery discipline.</h2>
                    </div>
                    <a href="{{ route('website.blog.index') }}" class="btn-dark">Read Articles</a>
                </div>
                <div class="grid gap-6 lg:grid-cols-3">
                    @foreach($posts as $post)
                        @php
                            $img = $post->cover_image
                                ? $mediaAssetUrl($post->cover_image)
                                : $mediaAssetUrl($websiteImages['blog']['post_fallback_cover'] ?? null, 'assets/images/blog-cover.svg');
                        @endphp
                        <article class="surface-card" data-reveal>
                            <a href="{{ route('website.blog.show', $post->slug) }}" class="block">
                                <div class="content-image-frame h-52">
                                    <img src="{{ $img }}" alt="{{ $post->title }}" class="rounded-[24px]">
                                </div>
                            </a>
                            <div class="mt-5 text-sm font-semibold uppercase tracking-[0.22em] text-brand-green">{{ optional($post->published_at)->format('d M Y') }}</div>
                            <h3 class="mt-3 text-2xl font-bold text-brand-blue">{{ $post->title }}</h3>
                            <p class="mt-3 text-slate-600">{{ $post->excerpt }}</p>
                            <a href="{{ route('website.blog.show', $post->slug) }}" class="mt-5 inline-flex items-center gap-2 text-sm font-semibold text-brand-blue">
                                Read Article
                                @include('website.partials.icon', ['name' => 'arrow', 'class' => 'h-4 w-4'])
                            </a>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @include('website.partials.cta-banner')
@endsection
