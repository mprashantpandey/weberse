@extends('layouts.website', [
    'title' => $service['title'].' | Weberse Infotech',
    'description' => $service['summary'] ?? ($service['title'].' services from Weberse Infotech.'),
])

@section('content')
    @if(($service['slug'] ?? '') === 'mobile-app-development')
        <section class="dark-band relative overflow-hidden">
            <div class="section-shell section-spacious relative pt-12 lg:pt-16">
                <div class="grid gap-12 lg:grid-cols-[1.05fr_0.95fr] lg:items-center">
                    <div data-reveal>
                        <div class="section-kicker">Mobile App Development</div>
                        <h1 class="mt-5 headline-lg">App development that feels native and ships fast.</h1>
                        <p class="mt-5 body-lg text-slate-300">
                            We build mobile products with disciplined UX, scalable architecture, and release confidence—so your app is smooth under real users, not just demos.
                        </p>

                        <div class="mt-7 flex flex-wrap gap-4">
                            <a href="{{ route('website.contact') }}" class="btn-primary"
                               x-on:click.prevent="$store.marketingPopup.openLead({ title: 'Build a Mobile App', source: 'service_mobile_cta', context: 'Mobile app development inquiry', submitLabel: 'Discuss App' })">
                                @include('website.partials.icon', ['name' => 'calendar', 'class' => 'h-4 w-4'])
                                Discuss Your App
                            </a>
                            <a href="{{ route('website.services') }}" class="btn-secondary">
                                @include('website.partials.icon', ['name' => 'layers', 'class' => 'h-4 w-4'])
                                All Services
                            </a>
                        </div>

                        <div class="mt-9 flex flex-wrap items-center gap-3 text-sm text-slate-300">
                            <div class="inline-flex items-center gap-2 rounded-2xl border border-white/10 bg-white/5 px-4 py-2">
                                <iconify-icon icon="simple-icons:apple" class="h-4 w-4 text-brand-green"></iconify-icon>
                                <span>iOS</span>
                            </div>
                            <div class="inline-flex items-center gap-2 rounded-2xl border border-white/10 bg-white/5 px-4 py-2">
                                <iconify-icon icon="simple-icons:android" class="h-4 w-4 text-brand-green"></iconify-icon>
                                <span>Android</span>
                            </div>
                            <div class="inline-flex items-center gap-2 rounded-2xl border border-white/10 bg-white/5 px-4 py-2">
                                <iconify-icon icon="simple-icons:flutter" class="h-4 w-4 text-brand-green"></iconify-icon>
                                <span>Cross-platform</span>
                            </div>
                            <div class="inline-flex items-center gap-2 rounded-2xl border border-white/10 bg-white/5 px-4 py-2">
                                <iconify-icon icon="lucide:badge-check" class="h-4 w-4 text-brand-green"></iconify-icon>
                                <span>Store submissions</span>
                            </div>
                        </div>
                    </div>

                    <div data-reveal>
                        <div class="hero-media-stage">
                            <img src="{{ $mediaAssetUrl($websiteImages['services']['mobile-app-development'] ?? null, 'assets/legacy/app-mockup.png') }}" alt="Mobile app mockup" class="hero-media-image">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="light-band">
            <div class="section-shell section-spacious">
                <div class="mb-10 max-w-3xl" data-reveal>
                    <div class="section-kicker">Platforms & Build Options</div>
                    <h2 class="mt-4 headline-lg text-brand-blue">Choose the right approach for your product.</h2>
                    <p class="mt-4 text-slate-600">We help you pick the best delivery path—native where it matters, cross-platform where it saves time without sacrificing quality.</p>
                </div>

                <div class="grid gap-6 lg:grid-cols-3">
                    @foreach ([
                        ['icon' => 'simple-icons:apple', 'title' => 'iOS (Swift)', 'copy' => 'Polished native feel, platform-grade performance, iOS-first experiences.'],
                        ['icon' => 'simple-icons:android', 'title' => 'Android (Kotlin)', 'copy' => 'Modern Android architecture, clean UI systems, reliable releases.'],
                        ['icon' => 'simple-icons:flutter', 'title' => 'Cross-platform (Flutter / RN)', 'copy' => 'One codebase, fast iteration, native-feeling UI with discipline.'],
                    ] as $card)
                        <div class="surface-card premium-card" data-reveal>
                            <div class="premium-icon inline-flex rounded-2xl bg-brand-surface p-4 text-brand-blue">
                                <iconify-icon icon="{{ $card['icon'] }}" class="h-6 w-6 text-brand-blue"></iconify-icon>
                            </div>
                            <h3 class="mt-5 text-2xl font-bold text-brand-blue">{{ $card['title'] }}</h3>
                            <p class="mt-4 text-slate-600">{{ $card['copy'] }}</p>
                            <div class="mt-6 flex flex-wrap gap-2">
                                <span class="badge-chip !bg-brand-blue/8 !text-brand-blue">UI</span>
                                <span class="badge-chip !bg-brand-blue/8 !text-brand-blue">Auth</span>
                                <span class="badge-chip !bg-brand-blue/8 !text-brand-blue">Push</span>
                                <span class="badge-chip !bg-brand-blue/8 !text-brand-blue">Payments</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="section-shell py-20 lg:py-24">
            <div class="grid gap-8 lg:grid-cols-2">
                <div class="glass-card" data-reveal>
                    <div class="section-kicker">What You Get</div>
                    <h2 class="mt-4 text-3xl font-bold text-white">Deliverables that keep launch predictable</h2>
                    <p class="mt-4 text-slate-300">A complete delivery surface: design → build → QA → release, with clean handoff and post-launch iteration support.</p>
                    <ul class="mt-6 grid gap-3 sm:grid-cols-2">
                        @foreach ([
                            ['icon' => 'lucide:map', 'label' => 'Product flow mapping'],
                            ['icon' => 'lucide:layout-template', 'label' => 'High-fidelity UI + component system'],
                            ['icon' => 'lucide:lock', 'label' => 'Authentication + role flows'],
                            ['icon' => 'lucide:plug', 'label' => 'API integration + backend support'],
                            ['icon' => 'lucide:shield-alert', 'label' => 'Crash reporting + analytics events'],
                            ['icon' => 'lucide:badge-check', 'label' => 'App Store / Play Store submission'],
                        ] as $item)
                            <li class="flex items-start gap-3 rounded-[22px] bg-white/8 px-4 py-3 text-slate-200">
                                <span class="mt-0.5 inline-flex h-9 w-9 items-center justify-center rounded-2xl bg-white/10 text-brand-green">
                                    <iconify-icon icon="{{ $item['icon'] }}" class="h-5 w-5"></iconify-icon>
                                </span>
                                <span class="text-sm font-semibold text-white">{{ $item['label'] }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="glass-card" data-reveal>
                    <div class="section-kicker">Process</div>
                    <h2 class="mt-4 text-3xl font-bold text-white">How we ship apps</h2>
                    <ol class="mt-6 space-y-4">
                        @foreach ([
                            ['icon' => 'lucide:compass', 'label' => 'Discovery & product mapping (flows, success metrics, scope)'],
                            ['icon' => 'lucide:pen-tool', 'label' => 'UX/UI and prototype review (approval checkpoints)'],
                            ['icon' => 'lucide:code-2', 'label' => 'Sprint build (weekly demos, feature-by-feature delivery)'],
                            ['icon' => 'lucide:check-circle-2', 'label' => 'QA + release prep (devices, edge cases, store readiness)'],
                            ['icon' => 'lucide:rocket', 'label' => 'Launch + iteration loop (analytics + improvements)'],
                        ] as $step)
                            <li class="flex items-start gap-3 rounded-[24px] bg-white/10 px-5 py-4 text-slate-200">
                                <span class="mt-0.5 inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-white/10 text-brand-green">
                                    <iconify-icon icon="{{ $step['icon'] }}" class="h-5 w-5"></iconify-icon>
                                </span>
                                <span class="text-sm text-slate-200">{{ $step['label'] }}</span>
                            </li>
                        @endforeach
                    </ol>
                </div>
            </div>
        </section>

        <section class="page-panel py-20 lg:py-24">
            <div class="section-shell">
                <div class="mb-10 max-w-3xl" data-reveal>
                    <div class="section-kicker">Tech Stack</div>
                    <h2 class="mt-4 headline-lg text-brand-blue">Modern tooling for fast iteration and stable releases.</h2>
                </div>
                <div class="grid gap-6 lg:grid-cols-2">
                    <div class="surface-card" data-reveal>
                        <h3 class="text-2xl font-bold text-brand-blue">Frontend & Mobile</h3>
                        <div class="mt-5 grid gap-3 sm:grid-cols-2">
                            @foreach ([
                                ['label' => 'Flutter', 'icon' => 'simple-icons:flutter'],
                                ['label' => 'React Native', 'icon' => 'simple-icons:react'],
                                ['label' => 'Swift', 'icon' => 'simple-icons:swift'],
                                ['label' => 'Kotlin', 'icon' => 'simple-icons:kotlin'],
                                ['label' => 'UI Systems', 'icon' => 'lucide:layout-template'],
                            ] as $tech)
                                <div class="flex items-center gap-3 rounded-[18px] border border-brand-blue/10 bg-white/70 px-4 py-3">
                                    <iconify-icon icon="{{ $tech['icon'] }}" class="h-5 w-5 text-brand-blue"></iconify-icon>
                                    <span class="text-sm font-semibold text-brand-blue">{{ $tech['label'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="surface-card" data-reveal>
                        <h3 class="text-2xl font-bold text-brand-blue">Backend & Ops</h3>
                        <div class="mt-5 grid gap-3 sm:grid-cols-2">
                            @foreach ([
                                ['label' => 'Laravel APIs', 'icon' => 'simple-icons:laravel'],
                                ['label' => 'Firebase', 'icon' => 'simple-icons:firebase'],
                                ['label' => 'Analytics', 'icon' => 'lucide:bar-chart-3'],
                                ['label' => 'Crash Reporting', 'icon' => 'lucide:bug'],
                                ['label' => 'CI/CD', 'icon' => 'lucide:git-branch'],
                            ] as $tech)
                                <div class="flex items-center gap-3 rounded-[18px] border border-brand-blue/10 bg-white/70 px-4 py-3">
                                    <iconify-icon icon="{{ $tech['icon'] }}" class="h-5 w-5 text-brand-blue"></iconify-icon>
                                    <span class="text-sm font-semibold text-brand-blue">{{ $tech['label'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section-shell py-20 lg:py-24">
            <div class="grid gap-10 lg:grid-cols-2 lg:items-start">
                <div data-reveal>
                    <div class="section-kicker">FAQ</div>
                    <h2 class="mt-4 text-3xl font-bold text-white">Common questions</h2>
                    <p class="mt-4 text-slate-300">Quick answers to the things teams usually want clarity on before starting.</p>
                </div>
                <div class="space-y-3" data-reveal x-data="{ open: 0 }">
                    @foreach ([
                        ['q' => 'Do you build in Flutter or React Native?', 'a' => 'Yes—selection depends on your UI complexity, team preferences, and release cadence. We’ll recommend the fastest path that still feels premium.'],
                        ['q' => 'Can you handle backend + admin panels too?', 'a' => 'Yes. We can deliver APIs, dashboards, and integrations so mobile is not isolated from operations.'],
                        ['q' => 'How do you manage quality and releases?', 'a' => 'Device testing, structured QA checklists, and release gates. We also wire crash reporting and analytics for post-launch iteration.'],
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
    @elseif(($service['slug'] ?? '') === 'web-development')
        <section class="dark-band relative overflow-hidden">
            <div class="section-shell section-spacious relative pt-12 lg:pt-16">
                <div class="grid gap-10 lg:grid-cols-[1.05fr_0.95fr] lg:items-center">
                    <div data-reveal>
                        <div class="section-kicker">Web Development</div>
                        <h1 class="mt-5 headline-lg">High-performance websites and web platforms.</h1>
                        <p class="mt-5 body-lg text-slate-300">
                            Weberse builds fast, SEO-friendly websites and scalable web applications with clean structure, modern UI, and production-grade engineering.
                        </p>

                        <div class="mt-7 flex flex-wrap gap-4">
                            <a href="{{ route('website.contact') }}" class="btn-primary"
                               x-on:click.prevent="$store.marketingPopup.openLead({ title: 'Build a Website', source: 'service_web_cta', context: 'Web development inquiry', submitLabel: 'Discuss Website' })">
                                @include('website.partials.icon', ['name' => 'calendar', 'class' => 'h-4 w-4'])
                                Discuss Your Website
                            </a>
                            <a href="{{ route('website.services') }}" class="btn-secondary">
                                @include('website.partials.icon', ['name' => 'layers', 'class' => 'h-4 w-4'])
                                All Services
                            </a>
                        </div>

                        <div class="mt-9 flex flex-wrap items-center gap-3 text-sm text-slate-300">
                            @foreach ([
                                ['icon' => 'simple-icons:laravel', 'label' => 'Laravel'],
                                ['icon' => 'simple-icons:tailwindcss', 'label' => 'Tailwind'],
                                ['icon' => 'simple-icons:vite', 'label' => 'Vite'],
                                ['icon' => 'lucide:search', 'label' => 'SEO-ready'],
                                ['icon' => 'lucide:gauge', 'label' => 'Fast load'],
                            ] as $chip)
                                <div class="inline-flex items-center gap-2 rounded-2xl border border-white/10 bg-white/5 px-4 py-2">
                                    <iconify-icon icon="{{ $chip['icon'] }}" class="h-4 w-4 text-brand-green"></iconify-icon>
                                    <span>{{ $chip['label'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div data-reveal>
                        <div class="hero-media-stage">
                            <img src="{{ $mediaAssetUrl($websiteImages['services']['web-development'] ?? null, 'assets/legacy/web-development.png') }}" alt="Web development" class="hero-media-image">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="light-band">
            <div class="section-shell section-spacious">
                <div class="mb-10 max-w-3xl" data-reveal>
                    <div class="section-kicker">What We Build</div>
                    <h2 class="mt-4 headline-lg text-brand-blue">From premium marketing sites to complex web apps.</h2>
                    <p class="mt-4 text-slate-600">Clear pages, strong UX hierarchy, and backend structure that makes future changes easy.</p>
                </div>

                <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
                    @foreach ([
                        ['icon' => 'lucide:layout-template', 'title' => 'Marketing Websites', 'copy' => 'Landing pages, service sites, conversion-first funnels.'],
                        ['icon' => 'lucide:panel-top', 'title' => 'Web Applications', 'copy' => 'Dashboards, portals, workflows, internal tools.'],
                        ['icon' => 'lucide:shopping-bag', 'title' => 'Ecommerce', 'copy' => 'Catalogs, checkout flows, payments, analytics.'],
                        ['icon' => 'lucide:database', 'title' => 'APIs & Integrations', 'copy' => 'CRMs, WHMCS, automation, third-party APIs.'],
                    ] as $item)
                        <div class="surface-card premium-card" data-reveal>
                            <div class="premium-icon inline-flex rounded-2xl bg-brand-surface p-5 text-brand-blue">
                                <iconify-icon icon="{{ $item['icon'] }}" class="h-7 w-7 text-brand-blue"></iconify-icon>
                            </div>
                            <h3 class="mt-5 text-2xl font-bold text-brand-blue">{{ $item['title'] }}</h3>
                            <p class="mt-4 text-slate-600">{{ $item['copy'] }}</p>
                        </div>
                    @endforeach
                </div>

                <div class="mt-12" data-reveal>
                    <div class="section-kicker">Website Types</div>
                    <h3 class="mt-4 text-3xl font-bold text-brand-blue">Built for real industries and real buyer journeys.</h3>
                    <p class="mt-4 max-w-3xl text-slate-600">We adapt UX, content hierarchy, and integrations based on how your customers decide—whether it’s bookings, checkout, onboarding, or complex forms.</p>

                    <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6">
                        @foreach ([
                            ['icon' => 'lucide:shopping-cart', 'label' => 'Ecommerce'],
                            ['icon' => 'lucide:plane', 'label' => 'Travel'],
                            ['icon' => 'lucide:landmark', 'label' => 'Fintech'],
                            ['icon' => 'lucide:stethoscope', 'label' => 'Healthcare'],
                            ['icon' => 'lucide:graduation-cap', 'label' => 'Education'],
                            ['icon' => 'lucide:building-2', 'label' => 'Real Estate'],
                        ] as $type)
                            <div class="web-type-tile" data-reveal>
                                <div class="web-type-icon">
                                    <iconify-icon icon="{{ $type['icon'] }}"></iconify-icon>
                                </div>
                                <div class="text-sm font-semibold text-brand-blue">{{ $type['label'] }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <section class="section-shell py-20 lg:py-24">
            <div class="grid gap-8 lg:grid-cols-2">
                <div class="glass-card" data-reveal>
                    <div class="section-kicker">Deliverables</div>
                    <h2 class="mt-4 text-3xl font-bold text-white">Everything needed to launch confidently</h2>
                    <p class="mt-4 text-slate-300">Design-to-deploy delivery with performance and maintainability baked in.</p>
                    <ul class="mt-6 grid gap-3 sm:grid-cols-2">
                        @foreach ([
                            ['icon' => 'lucide:sitemap', 'label' => 'Information architecture + page structure'],
                            ['icon' => 'lucide:component', 'label' => 'Component-based UI system'],
                            ['icon' => 'lucide:badge-check', 'label' => 'Responsive + cross-browser QA'],
                            ['icon' => 'lucide:search', 'label' => 'Technical SEO foundations'],
                            ['icon' => 'lucide:rocket', 'label' => 'Performance optimization (Core Web Vitals)'],
                            ['icon' => 'lucide:shield', 'label' => 'Security basics + best practices'],
                        ] as $item)
                            <li class="flex items-start gap-3 rounded-[22px] bg-white/8 px-4 py-3 text-slate-200">
                                <span class="mt-0.5 inline-flex h-9 w-9 items-center justify-center rounded-2xl bg-white/10 text-brand-green">
                                    <iconify-icon icon="{{ $item['icon'] }}" class="h-5 w-5"></iconify-icon>
                                </span>
                                <span class="text-sm font-semibold text-white">{{ $item['label'] }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="glass-card" data-reveal>
                    <div class="section-kicker">Process</div>
                    <h2 class="mt-4 text-3xl font-bold text-white">How we deliver</h2>
                    <ol class="mt-6 space-y-4">
                        @foreach ([
                            ['icon' => 'lucide:compass', 'label' => 'Discovery (goals, pages, audience, funnel)'],
                            ['icon' => 'lucide:pen-tool', 'label' => 'UI/UX & content structure (review checkpoints)'],
                            ['icon' => 'lucide:code-2', 'label' => 'Build (components, pages, integrations)'],
                            ['icon' => 'lucide:gauge', 'label' => 'Optimize (speed, SEO, accessibility)'],
                            ['icon' => 'lucide:cloud-upload', 'label' => 'Deploy (hosting, CDN, monitoring)'],
                        ] as $step)
                            <li class="flex items-start gap-3 rounded-[24px] bg-white/10 px-5 py-4 text-slate-200">
                                <span class="mt-0.5 inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-white/10 text-brand-green">
                                    <iconify-icon icon="{{ $step['icon'] }}" class="h-5 w-5"></iconify-icon>
                                </span>
                                <span class="text-sm text-slate-200">{{ $step['label'] }}</span>
                            </li>
                        @endforeach
                    </ol>
                </div>
            </div>
        </section>

        <section class="page-panel py-20 lg:py-24">
            <div class="section-shell">
                <div class="mb-10 max-w-3xl" data-reveal>
                    <div class="section-kicker">Tech Stack</div>
                    <h2 class="mt-4 headline-lg text-brand-blue">Modern stack, clean delivery.</h2>
                </div>

                <div class="grid gap-6 lg:grid-cols-2">
                    <div class="surface-card" data-reveal>
                        <h3 class="text-2xl font-bold text-brand-blue">Frontend</h3>
                        <div class="mt-5 grid gap-3 sm:grid-cols-2">
                            @foreach ([
                                ['label' => 'React', 'icon' => 'simple-icons:react'],
                                ['label' => 'Next.js', 'icon' => 'simple-icons:nextdotjs'],
                                ['label' => 'TypeScript', 'icon' => 'simple-icons:typescript'],
                                ['label' => 'Tailwind CSS', 'icon' => 'simple-icons:tailwindcss'],
                                ['label' => 'Alpine.js', 'icon' => 'simple-icons:alpinedotjs'],
                                ['label' => 'JavaScript', 'icon' => 'simple-icons:javascript'],
                                ['label' => 'Vite', 'icon' => 'simple-icons:vite'],
                            ] as $tech)
                                <div class="stack-tile">
                                    <span class="stack-icon"><iconify-icon icon="{{ $tech['icon'] }}"></iconify-icon></span>
                                    <span class="stack-label">{{ $tech['label'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="surface-card" data-reveal>
                        <h3 class="text-2xl font-bold text-brand-blue">Backend</h3>
                        <div class="mt-5 grid gap-3 sm:grid-cols-2">
                            @foreach ([
                                ['label' => 'Laravel', 'icon' => 'simple-icons:laravel'],
                                ['label' => 'PHP', 'icon' => 'simple-icons:php'],
                                ['label' => 'MySQL', 'icon' => 'simple-icons:mysql'],
                                ['label' => 'PostgreSQL', 'icon' => 'simple-icons:postgresql'],
                                ['label' => 'Redis', 'icon' => 'simple-icons:redis'],
                                ['label' => 'Node.js', 'icon' => 'simple-icons:nodedotjs'],
                                ['label' => 'APIs', 'icon' => 'lucide:plug'],
                            ] as $tech)
                                <div class="stack-tile">
                                    <span class="stack-icon"><iconify-icon icon="{{ $tech['icon'] }}"></iconify-icon></span>
                                    <span class="stack-label">{{ $tech['label'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="mt-10 grid gap-6 lg:grid-cols-2">
                    <div class="surface-card" data-reveal>
                        <h3 class="text-2xl font-bold text-brand-blue">CMS & Ecommerce</h3>
                        <p class="mt-3 text-slate-600">We also deliver on CMS platforms when you need editor-friendly pages, product management, and plugin ecosystems.</p>
                        <div class="mt-5 grid gap-3 sm:grid-cols-2">
                            @foreach ([
                                ['label' => 'WordPress', 'icon' => 'simple-icons:wordpress'],
                                ['label' => 'Shopify', 'icon' => 'simple-icons:shopify'],
                                ['label' => 'Magento', 'icon' => 'simple-icons:magento'],
                                ['label' => 'Headless CMS', 'icon' => 'lucide:layers'],
                            ] as $tech)
                                <div class="stack-tile">
                                    <span class="stack-icon"><iconify-icon icon="{{ $tech['icon'] }}"></iconify-icon></span>
                                    <span class="stack-label">{{ $tech['label'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="surface-card" data-reveal>
                        <h3 class="text-2xl font-bold text-brand-blue">Infra & Delivery</h3>
                        <p class="mt-3 text-slate-600">Deployment pipelines, monitoring, and caching so production stays stable and fast.</p>
                        <div class="mt-5 grid gap-3 sm:grid-cols-2">
                            @foreach ([
                                ['label' => 'Terraform', 'icon' => 'simple-icons:terraform'],
                                ['label' => 'AWS', 'icon' => 'simple-icons:amazonaws'],
                                ['label' => 'Cloudflare', 'icon' => 'simple-icons:cloudflare'],
                                ['label' => 'CI/CD', 'icon' => 'lucide:git-branch'],
                            ] as $tech)
                                <div class="stack-tile">
                                    <span class="stack-icon"><iconify-icon icon="{{ $tech['icon'] }}"></iconify-icon></span>
                                    <span class="stack-label">{{ $tech['label'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section-shell py-20 lg:py-24">
            <div class="grid gap-10 lg:grid-cols-2 lg:items-start">
                <div data-reveal>
                    <div class="section-kicker">FAQ</div>
                    <h2 class="mt-4 text-3xl font-bold text-white">Web development questions</h2>
                    <p class="mt-4 text-slate-300">Quick clarity on scope, SEO, performance, and timelines.</p>
                </div>
                <div class="space-y-3" data-reveal x-data="{ open: 0 }">
                    @foreach ([
                        ['q' => 'Will the website be fast and SEO-friendly?', 'a' => 'Yes. We prioritize structure, clean HTML, image optimization, and performance baselines for Core Web Vitals plus technical SEO.'],
                        ['q' => 'Can you integrate WHMCS / forms / CRM?', 'a' => 'Yes. We can integrate WHMCS handoffs, lead forms, analytics, and CRM pipelines depending on your workflow.'],
                        ['q' => 'Do you provide hosting and deployment?', 'a' => 'Yes. We can deploy to your preferred host or provide hosting guidance (CDN, caching, SSL, monitoring).'],
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
    @elseif(($service['slug'] ?? '') === 'digital-marketing')
        <section class="dark-band relative overflow-hidden">
            <div class="section-shell section-spacious relative pt-12 lg:pt-16">
                <div class="grid gap-10 lg:grid-cols-[1.05fr_0.95fr] lg:items-center">
                    <div data-reveal>
                        <div class="section-kicker">Digital Marketing</div>
                        <h1 class="mt-5 headline-lg">Clarity first. Then traffic.</h1>
                        <p class="mt-5 body-lg text-slate-300">
                            We build clean funnels, strong landing pages, and measurable campaigns—so you know exactly what is working (and why).
                        </p>

                        <div class="mt-7 flex flex-wrap gap-4">
                            <a href="{{ route('website.contact') }}" class="btn-primary"
                               x-on:click.prevent="$store.marketingPopup.openLead({ title: 'Run Digital Marketing', source: 'service_marketing_cta', context: 'Digital marketing inquiry', submitLabel: 'Discuss Marketing' })">
                                @include('website.partials.icon', ['name' => 'calendar', 'class' => 'h-4 w-4'])
                                Discuss Marketing
                            </a>
                            <a href="{{ route('website.services') }}" class="btn-secondary">
                                @include('website.partials.icon', ['name' => 'layers', 'class' => 'h-4 w-4'])
                                All Services
                            </a>
                        </div>

                        <div class="mt-9 flex flex-wrap items-center gap-3 text-sm text-slate-300">
                            @foreach ([
                                ['icon' => 'simple-icons:googleads', 'label' => 'Google Ads'],
                                ['icon' => 'simple-icons:meta', 'label' => 'Meta Ads'],
                                ['icon' => 'simple-icons:googleanalytics', 'label' => 'Analytics'],
                                ['icon' => 'lucide:route', 'label' => 'Funnels'],
                                ['icon' => 'lucide:line-chart', 'label' => 'Reporting'],
                            ] as $chip)
                                <div class="inline-flex items-center gap-2 rounded-2xl border border-white/10 bg-white/5 px-4 py-2">
                                    <iconify-icon icon="{{ $chip['icon'] }}" class="h-4 w-4 text-brand-green"></iconify-icon>
                                    <span>{{ $chip['label'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div data-reveal>
                        <div class="hero-media-stage">
                            <img src="{{ $mediaAssetUrl($websiteImages['services']['digital-marketing-hero'] ?? null, 'assets/images/hero-market-analysis.svg') }}" alt="Digital marketing analytics illustration" class="hero-media-image">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="light-band">
            <div class="section-shell section-spacious">
                <div class="mb-10 max-w-3xl" data-reveal>
                    <div class="section-kicker">What We Do</div>
                    <h2 class="mt-4 headline-lg text-brand-blue">A complete marketing system, not random ads.</h2>
                    <p class="mt-4 text-slate-600">Positioning, landing pages, campaigns, and tracking—tied into one clear acquisition flow.</p>
                </div>

                <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
                    @foreach ([
                        ['icon' => 'lucide:target', 'title' => 'Offer & Positioning', 'copy' => 'Clarify value, audience, and the promise behind the click.'],
                        ['icon' => 'lucide:layout-template', 'title' => 'Landing Pages', 'copy' => 'Conversion-first pages with strong messaging hierarchy.'],
                        ['icon' => 'lucide:megaphone', 'title' => 'Campaign Management', 'copy' => 'Google/Meta campaigns with disciplined testing and iteration.'],
                        ['icon' => 'lucide:activity', 'title' => 'Tracking & Reporting', 'copy' => 'Analytics, events, dashboards, and weekly performance review.'],
                    ] as $item)
                        <div class="surface-card premium-card" data-reveal>
                            <div class="premium-icon inline-flex rounded-2xl bg-brand-surface p-5 text-brand-blue">
                                <iconify-icon icon="{{ $item['icon'] }}" class="h-7 w-7 text-brand-blue"></iconify-icon>
                            </div>
                            <h3 class="mt-5 text-2xl font-bold text-brand-blue">{{ $item['title'] }}</h3>
                            <p class="mt-4 text-slate-600">{{ $item['copy'] }}</p>
                        </div>
                    @endforeach
                </div>

                <div class="mt-12" data-reveal>
                    <div class="section-kicker">Channels</div>
                    <h3 class="mt-4 text-3xl font-bold text-brand-blue">Where we run and optimize.</h3>
                    <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 channels-grid">
                        @foreach ([
                            ['icon' => 'simple-icons:google', 'label' => 'Google Search'],
                            ['icon' => 'simple-icons:youtube', 'label' => 'YouTube'],
                            ['icon' => 'simple-icons:facebook', 'label' => 'Facebook'],
                            ['icon' => 'simple-icons:instagram', 'label' => 'Instagram'],
                            ['icon' => 'simple-icons:linkedin', 'label' => 'LinkedIn'],
                            ['icon' => 'simple-icons:mailchimp', 'label' => 'Email'],
                        ] as $type)
                            <div class="web-type-tile" data-reveal>
                                <div class="web-type-icon">
                                    <iconify-icon icon="{{ $type['icon'] }}"></iconify-icon>
                                </div>
                                <div class="text-sm font-semibold text-brand-blue">{{ $type['label'] }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <section class="section-shell py-20 lg:py-24">
            <div class="grid gap-8 lg:grid-cols-2">
                <div class="glass-card" data-reveal>
                    <div class="section-kicker">Deliverables</div>
                    <h2 class="mt-4 text-3xl font-bold text-white">What you get each month</h2>
                    <p class="mt-4 text-slate-300">Clear work output and measurable progress—no vague “optimizations”.</p>
                    <ul class="mt-6 grid gap-3 sm:grid-cols-2">
                        @foreach ([
                            ['icon' => 'lucide:scroll-text', 'label' => 'Offer & funnel mapping'],
                            ['icon' => 'lucide:file-text', 'label' => 'Landing page copy & structure'],
                            ['icon' => 'lucide:sliders-horizontal', 'label' => 'Campaign setup & testing plan'],
                            ['icon' => 'lucide:tags', 'label' => 'Creative angles & variations'],
                            ['icon' => 'lucide:bar-chart-3', 'label' => 'Dashboard + KPI reporting'],
                            ['icon' => 'lucide:repeat', 'label' => 'Iteration loop & next actions'],
                        ] as $item)
                            <li class="flex items-start gap-3 rounded-[22px] bg-white/8 px-4 py-3 text-slate-200">
                                <span class="mt-0.5 inline-flex h-9 w-9 items-center justify-center rounded-2xl bg-white/10 text-brand-green">
                                    <iconify-icon icon="{{ $item['icon'] }}" class="h-5 w-5"></iconify-icon>
                                </span>
                                <span class="text-sm font-semibold text-white">{{ $item['label'] }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="glass-card" data-reveal>
                    <div class="section-kicker">Process</div>
                    <h2 class="mt-4 text-3xl font-bold text-white">How we run marketing</h2>
                    <ol class="mt-6 space-y-4">
                        @foreach ([
                            ['icon' => 'lucide:compass', 'label' => 'Audit (offer, pages, tracking, current campaigns)'],
                            ['icon' => 'lucide:route', 'label' => 'Funnel plan (traffic → landing → lead capture)'],
                            ['icon' => 'lucide:rocket', 'label' => 'Launch (campaigns + measurement)'],
                            ['icon' => 'lucide:beaker', 'label' => 'Test (angles, creatives, audiences, pages)'],
                            ['icon' => 'lucide:line-chart', 'label' => 'Scale (winners, budgets, improvements)'],
                        ] as $step)
                            <li class="flex items-start gap-3 rounded-[24px] bg-white/10 px-5 py-4 text-slate-200">
                                <span class="mt-0.5 inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-white/10 text-brand-green">
                                    <iconify-icon icon="{{ $step['icon'] }}" class="h-5 w-5"></iconify-icon>
                                </span>
                                <span class="text-sm text-slate-200">{{ $step['label'] }}</span>
                            </li>
                        @endforeach
                    </ol>
                </div>
            </div>
        </section>

        <section class="page-panel py-20 lg:py-24">
            <div class="section-shell">
                <div class="mb-10 max-w-3xl" data-reveal>
                    <div class="section-kicker">Tooling</div>
                    <h2 class="mt-4 headline-lg text-brand-blue">Tracking, reporting, and execution tools.</h2>
                </div>

                <div class="grid gap-6 lg:grid-cols-2">
                    <div class="surface-card" data-reveal>
                        <h3 class="text-2xl font-bold text-brand-blue">Ads & Channels</h3>
                        <div class="mt-5 grid gap-3 sm:grid-cols-2">
                            @foreach ([
                                ['label' => 'Google Ads', 'icon' => 'simple-icons:googleads'],
                                ['label' => 'Meta Ads', 'icon' => 'simple-icons:meta'],
                                ['label' => 'LinkedIn', 'icon' => 'simple-icons:linkedin'],
                                ['label' => 'YouTube', 'icon' => 'simple-icons:youtube'],
                            ] as $tech)
                                <div class="stack-tile">
                                    <span class="stack-icon"><iconify-icon icon="{{ $tech['icon'] }}"></iconify-icon></span>
                                    <span class="stack-label">{{ $tech['label'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="surface-card" data-reveal>
                        <h3 class="text-2xl font-bold text-brand-blue">Tracking & CRM</h3>
                        <div class="mt-5 grid gap-3 sm:grid-cols-2">
                            @foreach ([
                                ['label' => 'Google Analytics', 'icon' => 'simple-icons:googleanalytics'],
                                ['label' => 'Tag Manager', 'icon' => 'simple-icons:googletagmanager'],
                                ['label' => 'Search Console', 'icon' => 'simple-icons:googlesearchconsole'],
                                ['label' => 'Email', 'icon' => 'lucide:mail'],
                            ] as $tech)
                                <div class="stack-tile">
                                    <span class="stack-icon"><iconify-icon icon="{{ $tech['icon'] }}"></iconify-icon></span>
                                    <span class="stack-label">{{ $tech['label'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section-shell py-20 lg:py-24">
            <div class="grid gap-10 lg:grid-cols-2 lg:items-start">
                <div data-reveal>
                    <div class="section-kicker">FAQ</div>
                    <h2 class="mt-4 text-3xl font-bold text-white">Digital marketing questions</h2>
                    <p class="mt-4 text-slate-300">Budget, timelines, and what “success” means.</p>
                </div>
                <div class="space-y-3" data-reveal x-data="{ open: 0 }">
                    @foreach ([
                        ['q' => 'Do you handle landing pages too?', 'a' => 'Yes. We usually include landing page structure and messaging because traffic without a strong page wastes budget.'],
                        ['q' => 'How soon do we see results?', 'a' => 'You typically see early signals in 1–2 weeks and stronger clarity by weeks 3–6 as tests accumulate and we identify winners.'],
                        ['q' => 'Can you work with our existing team?', 'a' => 'Yes. We can collaborate with your designer/dev/team, or deliver end-to-end including pages and tracking.'],
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
    @elseif(($service['slug'] ?? '') === 'ui-ux-design')
        <section class="dark-band relative overflow-hidden">
            <div class="section-shell section-spacious relative pt-12 lg:pt-16">
                <div class="grid gap-10 lg:grid-cols-[1.05fr_0.95fr] lg:items-center">
                    <div data-reveal>
                        <div class="section-kicker">UI/UX Design</div>
                        <h1 class="mt-5 headline-lg">Premium interfaces that make complex products feel simple.</h1>
                        <p class="mt-5 body-lg text-slate-300">
                            We design clear journeys, scalable component systems, and modern UI that improves trust, adoption, and conversion—across web, mobile, and dashboards.
                        </p>

                        <div class="mt-7 flex flex-wrap gap-4">
                            <a href="{{ route('website.contact') }}" class="btn-primary"
                               x-on:click.prevent="$store.marketingPopup.openLead({ title: 'Design UI/UX', source: 'service_uiux_cta', context: 'UI/UX design inquiry', submitLabel: 'Discuss Design' })">
                                @include('website.partials.icon', ['name' => 'calendar', 'class' => 'h-4 w-4'])
                                Discuss Design
                            </a>
                            <a href="{{ route('website.services') }}" class="btn-secondary">
                                @include('website.partials.icon', ['name' => 'layers', 'class' => 'h-4 w-4'])
                                All Services
                            </a>
                        </div>

                        <div class="mt-9 flex flex-wrap items-center gap-3 text-sm text-slate-300">
                            @foreach ([
                                ['icon' => 'simple-icons:figma', 'label' => 'Figma'],
                                ['icon' => 'lucide:component', 'label' => 'Design Systems'],
                                ['icon' => 'lucide:scan-eye', 'label' => 'UX Audits'],
                                ['icon' => 'lucide:layout-dashboard', 'label' => 'Dashboards'],
                                ['icon' => 'lucide:smartphone', 'label' => 'Mobile UI'],
                            ] as $chip)
                                <div class="inline-flex items-center gap-2 rounded-2xl border border-white/10 bg-white/5 px-4 py-2">
                                    <iconify-icon icon="{{ $chip['icon'] }}" class="h-4 w-4 text-brand-green"></iconify-icon>
                                    <span>{{ $chip['label'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div data-reveal>
                        <div class="hero-media-stage">
                            <img src="{{ $mediaAssetUrl($websiteImages['services']['ui-ux-design-hero'] ?? null, 'assets/images/uiux-hero.svg') }}" alt="UI/UX design illustration" class="hero-media-image">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="light-band">
            <div class="section-shell section-spacious">
                <div class="mb-10 max-w-3xl" data-reveal>
                    <div class="section-kicker">What We Design</div>
                    <h2 class="mt-4 headline-lg text-brand-blue">Interfaces built for clarity, speed, and trust.</h2>
                    <p class="mt-4 text-slate-600">We combine information hierarchy, modern layout systems, and real user flows—so your product feels premium and easy.</p>
                </div>

                <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
                    @foreach ([
                        ['icon' => 'lucide:layout-template', 'title' => 'Web UI', 'copy' => 'Marketing sites, portals, and product pages with clear hierarchy.'],
                        ['icon' => 'lucide:layout-dashboard', 'title' => 'Dashboards', 'copy' => 'Data-heavy screens that stay readable and fast to use.'],
                        ['icon' => 'lucide:smartphone', 'title' => 'Mobile UI', 'copy' => 'Native-feeling UI states, onboarding, and retention flows.'],
                        ['icon' => 'lucide:shopping-cart', 'title' => 'Checkout UX', 'copy' => 'Product selection, pricing clarity, and conversion improvements.'],
                    ] as $item)
                        <div class="surface-card premium-card" data-reveal>
                            <div class="premium-icon inline-flex rounded-2xl bg-brand-surface p-5 text-brand-blue">
                                <iconify-icon icon="{{ $item['icon'] }}" class="h-7 w-7 text-brand-blue"></iconify-icon>
                            </div>
                            <h3 class="mt-5 text-2xl font-bold text-brand-blue">{{ $item['title'] }}</h3>
                            <p class="mt-4 text-slate-600">{{ $item['copy'] }}</p>
                        </div>
                    @endforeach
                </div>

                <div class="section-divider mt-14 mb-0"></div>
            </div>
        </section>

        <section class="light-band">
            <div class="section-shell section-spacious">
                <div class="grid gap-10 lg:grid-cols-[1fr_0.9fr] lg:items-center">
                    <div data-reveal>
                        <div class="section-kicker">Industry level UI/UX</div>
                        <h2 class="mt-4 headline-lg text-brand-blue">Designed for real users, real constraints.</h2>
                        <p class="mt-4 text-slate-600">Every industry has different trust signals, compliance needs, and conversion triggers. We design with those realities in mind—so your product feels “right” to your audience from day one.</p>

                        <div class="mt-8 grid gap-5 sm:grid-cols-2">
                            @foreach ([
                                ['icon' => 'lucide:shopping-bag', 'title' => 'eCommerce', 'copy' => 'Checkout clarity, product discovery, upsells, and CRO-focused UI.'],
                                ['icon' => 'lucide:heart-pulse', 'title' => 'Healthcare', 'copy' => 'Accessible UI, patient-friendly flows, and trust-first information design.'],
                                ['icon' => 'lucide:badge-dollar-sign', 'title' => 'Fintech', 'copy' => 'Security UX, KYC-friendly steps, and clean, data-dense dashboards.'],
                                ['icon' => 'lucide:layers', 'title' => 'SaaS & Platforms', 'copy' => 'Onboarding that sticks, role-based UI, and scalable component systems.'],
                                ['icon' => 'lucide:graduation-cap', 'title' => 'EdTech', 'copy' => 'Progress-first UX, content navigation, and motivation loops.'],
                                ['icon' => 'lucide:plane', 'title' => 'Travel & Booking', 'copy' => 'Search, filters, comparisons, and confident booking experiences.'],
                            ] as $ind)
                                <div class="surface-card premium-card" data-reveal>
                                    <div class="flex items-start gap-4">
                                        <span class="premium-icon inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-brand-surface text-brand-blue">
                                            <iconify-icon icon="{{ $ind['icon'] }}" class="h-6 w-6 text-brand-blue"></iconify-icon>
                                        </span>
                                        <div>
                                            <div class="text-lg font-bold text-brand-blue">{{ $ind['title'] }}</div>
                                            <div class="mt-1 text-sm text-slate-600">{{ $ind['copy'] }}</div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-8 grid gap-3 sm:grid-cols-3">
                            @foreach ([
                                ['icon' => 'lucide:shield-check', 'label' => 'Trust-first layouts'],
                                ['icon' => 'lucide:accessibility', 'label' => 'Accessible by default'],
                                ['icon' => 'lucide:rocket', 'label' => 'Conversion-focused'],
                            ] as $proof)
                                <div class="flex items-center gap-3 rounded-[22px] border border-slate-200 bg-white px-4 py-3 shadow-sm">
                                    <span class="inline-flex h-9 w-9 items-center justify-center rounded-2xl bg-brand-surface text-brand-blue">
                                        <iconify-icon icon="{{ $proof['icon'] }}" class="h-5 w-5 text-brand-blue"></iconify-icon>
                                    </span>
                                    <span class="text-sm font-semibold text-brand-blue">{{ $proof['label'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div data-reveal>
                        <div class="hero-media-stage">
                            <img src="{{ $mediaAssetUrl($websiteImages['services']['ui-ux-design-industries'] ?? null, 'assets/images/uiux-industries.svg') }}" alt="Industries UI/UX illustration" class="hero-media-image">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section-shell py-20 lg:py-24">
            <div class="grid gap-8 lg:grid-cols-2">
                <div class="glass-card" data-reveal>
                    <div class="section-kicker">Deliverables</div>
                    <h2 class="mt-4 text-3xl font-bold text-white">Design output you can build from</h2>
                    <p class="mt-4 text-slate-300">Clear artifacts for teams: structure, UI components, and developer-ready specs.</p>
                    <ul class="mt-6 grid gap-3 sm:grid-cols-2">
                        @foreach ([
                            ['icon' => 'lucide:route', 'label' => 'User journeys & flows'],
                            ['icon' => 'lucide:layout-template', 'label' => 'Wireframes & structure'],
                            ['icon' => 'lucide:component', 'label' => 'Component library (design system)'],
                            ['icon' => 'lucide:palette', 'label' => 'Visual style & tokens'],
                            ['icon' => 'lucide:mouse-pointer-click', 'label' => 'Prototypes & interactions'],
                            ['icon' => 'lucide:code', 'label' => 'Developer handoff specs'],
                        ] as $item)
                            <li class="flex items-start gap-3 rounded-[22px] bg-white/8 px-4 py-3 text-slate-200">
                                <span class="mt-0.5 inline-flex h-9 w-9 items-center justify-center rounded-2xl bg-white/10 text-brand-green">
                                    <iconify-icon icon="{{ $item['icon'] }}" class="h-5 w-5"></iconify-icon>
                                </span>
                                <span class="text-sm font-semibold text-white">{{ $item['label'] }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="glass-card" data-reveal>
                    <div class="section-kicker">Process</div>
                    <h2 class="mt-4 text-3xl font-bold text-white">How we design</h2>
                    <ol class="mt-6 space-y-4">
                        @foreach ([
                            ['icon' => 'lucide:search', 'label' => 'Audit (screens, friction, hierarchy, opportunities)'],
                            ['icon' => 'lucide:route', 'label' => 'Flow mapping (journeys, states, edge cases)'],
                            ['icon' => 'lucide:layout-template', 'label' => 'Wireframes (structure + layout decisions)'],
                            ['icon' => 'lucide:palette', 'label' => 'High-fidelity UI (components + tokens)'],
                            ['icon' => 'lucide:check-circle-2', 'label' => 'Design QA + dev handoff'],
                        ] as $step)
                            <li class="flex items-start gap-3 rounded-[24px] bg-white/10 px-5 py-4 text-slate-200">
                                <span class="mt-0.5 inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-white/10 text-brand-green">
                                    <iconify-icon icon="{{ $step['icon'] }}" class="h-5 w-5"></iconify-icon>
                                </span>
                                <span class="text-sm text-slate-200">{{ $step['label'] }}</span>
                            </li>
                        @endforeach
                    </ol>
                </div>
            </div>
        </section>

        <section class="page-panel py-20 lg:py-24">
            <div class="section-shell">
                <div class="mb-10 max-w-3xl" data-reveal>
                    <div class="section-kicker">Tools</div>
                    <h2 class="mt-4 headline-lg text-brand-blue">The tooling we work in.</h2>
                </div>

                <div class="grid gap-6 lg:grid-cols-2">
                    <div class="surface-card" data-reveal>
                        <h3 class="text-2xl font-bold text-brand-blue">Design & Handoff</h3>
                        <div class="mt-5 grid gap-3 sm:grid-cols-2">
                            @foreach ([
                                ['label' => 'Figma', 'icon' => 'simple-icons:figma'],
                                ['label' => 'Prototyping', 'icon' => 'lucide:mouse-pointer-click'],
                                ['label' => 'Design Tokens', 'icon' => 'lucide:palette'],
                                ['label' => 'Component Systems', 'icon' => 'lucide:component'],
                            ] as $tech)
                                <div class="stack-tile">
                                    <span class="stack-icon"><iconify-icon icon="{{ $tech['icon'] }}"></iconify-icon></span>
                                    <span class="stack-label">{{ $tech['label'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="surface-card" data-reveal>
                        <h3 class="text-2xl font-bold text-brand-blue">Research & QA</h3>
                        <div class="mt-5 grid gap-3 sm:grid-cols-2">
                            @foreach ([
                                ['label' => 'UX Audits', 'icon' => 'lucide:scan-eye'],
                                ['label' => 'Accessibility', 'icon' => 'lucide:person-standing'],
                                ['label' => 'Responsive States', 'icon' => 'lucide:smartphone'],
                                ['label' => 'Design QA', 'icon' => 'lucide:check-circle-2'],
                            ] as $tech)
                                <div class="stack-tile">
                                    <span class="stack-icon"><iconify-icon icon="{{ $tech['icon'] }}"></iconify-icon></span>
                                    <span class="stack-label">{{ $tech['label'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section-shell py-20 lg:py-24">
            <div class="grid gap-10 lg:grid-cols-2 lg:items-start">
                <div data-reveal>
                    <div class="section-kicker">FAQ</div>
                    <h2 class="mt-4 text-3xl font-bold text-white">UI/UX questions</h2>
                    <p class="mt-4 text-slate-300">Scopes, timelines, and how handoff works.</p>
                </div>
                <div class="space-y-3" data-reveal x-data="{ open: 0 }">
                    @foreach ([
                        ['q' => 'Do you provide design systems?', 'a' => 'Yes. We can deliver a component library with tokens so UI stays consistent as the product grows.'],
                        ['q' => 'Will developers get handoff-ready files?', 'a' => 'Yes. We provide developer-friendly specs, interaction notes, and responsive states for implementation.'],
                        ['q' => 'Can you redesign an existing product?', 'a' => 'Yes. We start with an audit, map friction points, then rebuild key screens with better hierarchy and flow.'],
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
    @elseif(($service['slug'] ?? '') === 'email-marketing-automation')
        <section class="dark-band relative overflow-hidden">
            <div class="section-shell section-spacious relative pt-12 lg:pt-16">
                <div class="grid gap-10 lg:grid-cols-[1.05fr_0.95fr] lg:items-center">
                    <div data-reveal>
                        <div class="section-kicker">Email Marketing & Automation</div>
                        <h1 class="mt-5 headline-lg">Email sequences that convert—and keep converting.</h1>
                        <p class="mt-5 body-lg text-slate-300">
                            We design lifecycle journeys, segmentation, and automated follow-ups so leads don’t go cold and customers keep moving forward—without spammy blasts.
                        </p>

                        <div class="mt-7 flex flex-wrap gap-4">
                            <a href="{{ route('website.contact') }}" class="btn-primary"
                               x-on:click.prevent="$store.marketingPopup.openLead({ title: 'Email Marketing & Automation', source: 'service_email_automation_cta', context: 'Email marketing automation inquiry', submitLabel: 'Discuss Email' })">
                                @include('website.partials.icon', ['name' => 'calendar', 'class' => 'h-4 w-4'])
                                Discuss Email
                            </a>
                            <a href="{{ route('website.services') }}" class="btn-secondary">
                                @include('website.partials.icon', ['name' => 'layers', 'class' => 'h-4 w-4'])
                                All Services
                            </a>
                        </div>

                        <div class="mt-9 flex flex-wrap items-center gap-3 text-sm text-slate-300">
                            @foreach ([
                                ['icon' => 'lucide:mail', 'label' => 'Lifecycle sequences'],
                                ['icon' => 'lucide:users', 'label' => 'Segmentation'],
                                ['icon' => 'lucide:repeat', 'label' => 'Automation rules'],
                                ['icon' => 'lucide:shield-check', 'label' => 'Deliverability'],
                                ['icon' => 'lucide:line-chart', 'label' => 'Tracking'],
                            ] as $chip)
                                <div class="inline-flex items-center gap-2 rounded-2xl border border-white/10 bg-white/5 px-4 py-2">
                                    <iconify-icon icon="{{ $chip['icon'] }}" class="h-4 w-4 text-brand-green"></iconify-icon>
                                    <span>{{ $chip['label'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div data-reveal>
                        <div class="hero-media-stage">
                            <img src="{{ $mediaAssetUrl($websiteImages['services']['email-marketing-automation-hero'] ?? null, 'assets/images/email-automation-hero.svg') }}" alt="Email automation illustration" class="hero-media-image">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="light-band">
            <div class="section-shell section-spacious">
                <div class="mb-10 max-w-3xl" data-reveal>
                    <div class="section-kicker">What we build</div>
                    <h2 class="mt-4 headline-lg text-brand-blue">Automations that match how buyers decide.</h2>
                    <p class="mt-4 text-slate-600">We map your funnel, intent, and timing—then implement sequences that feel helpful, not pushy.</p>
                </div>

                <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
                    @foreach ([
                        ['icon' => 'lucide:user-plus', 'title' => 'Lead nurture', 'copy' => 'Turn inquiries into qualified calls with structured follow-ups.'],
                        ['icon' => 'lucide:shopping-cart', 'title' => 'eCommerce flows', 'copy' => 'Abandoned cart, browse abandonment, post-purchase, and winback.'],
                        ['icon' => 'lucide:sparkles', 'title' => 'Onboarding', 'copy' => 'Teach users, reduce churn, and increase activation with timing.'],
                        ['icon' => 'lucide:badge-check', 'title' => 'Transactional', 'copy' => 'Order updates, invoices, account alerts—clean and reliable.'],
                        ['icon' => 'lucide:target', 'title' => 'Segmentation', 'copy' => 'Behavior-based segments, tagging, and intent-based routing.'],
                        ['icon' => 'lucide:clipboard-check', 'title' => 'B2B follow-up', 'copy' => 'Sales reminders, proposals, re-engagement, and pipeline hygiene.'],
                        ['icon' => 'lucide:calendar-check', 'title' => 'Bookings', 'copy' => 'Appointment confirmations, reminders, and no-show prevention.'],
                        ['icon' => 'lucide:line-chart', 'title' => 'Reporting', 'copy' => 'Dashboards, attribution hygiene, and “what actually worked” clarity.'],
                    ] as $item)
                        <div class="surface-card premium-card" data-reveal>
                            <div class="premium-icon inline-flex rounded-2xl bg-brand-surface p-5 text-brand-blue">
                                <iconify-icon icon="{{ $item['icon'] }}" class="h-7 w-7 text-brand-blue"></iconify-icon>
                            </div>
                            <h3 class="mt-5 text-2xl font-bold text-brand-blue">{{ $item['title'] }}</h3>
                            <p class="mt-4 text-slate-600">{{ $item['copy'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="section-shell py-20 lg:py-24">
            <div class="grid gap-8 lg:grid-cols-2">
                <div class="glass-card" data-reveal>
                    <div class="section-kicker">Deliverables</div>
                    <h2 class="mt-4 text-3xl font-bold text-white">A complete email system—not just templates</h2>
                    <p class="mt-4 text-slate-300">Strategy, copy structure, segmentation, and deliverability foundations so the system performs at scale.</p>
                    <ul class="mt-6 grid gap-3 sm:grid-cols-2">
                        @foreach ([
                            ['icon' => 'lucide:map', 'label' => 'Lifecycle + funnel mapping'],
                            ['icon' => 'lucide:mail', 'label' => 'Template system (brand-consistent)'],
                            ['icon' => 'lucide:users', 'label' => 'Segmentation + tagging rules'],
                            ['icon' => 'lucide:repeat', 'label' => 'Automation workflows + triggers'],
                            ['icon' => 'lucide:shield-check', 'label' => 'Deliverability setup (SPF/DKIM/DMARC)'],
                            ['icon' => 'lucide:layout-dashboard', 'label' => 'Reporting + testing plan'],
                        ] as $item)
                            <li class="flex items-start gap-3 rounded-[22px] bg-white/8 px-4 py-3 text-slate-200">
                                <span class="mt-0.5 inline-flex h-9 w-9 items-center justify-center rounded-2xl bg-white/10 text-brand-green">
                                    <iconify-icon icon="{{ $item['icon'] }}" class="h-5 w-5"></iconify-icon>
                                </span>
                                <span class="text-sm font-semibold text-white">{{ $item['label'] }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="glass-card" data-reveal>
                    <div class="section-kicker">Process</div>
                    <h2 class="mt-4 text-3xl font-bold text-white">How we build email automation</h2>
                    <ol class="mt-6 space-y-4">
                        @foreach ([
                            ['icon' => 'lucide:search', 'label' => 'Audit (funnel, audiences, offers, existing emails)'],
                            ['icon' => 'lucide:route', 'label' => 'Architecture (segments, events, triggers, timing)'],
                            ['icon' => 'lucide:pen-tool', 'label' => 'Templates + copy structure (brand tone)'],
                            ['icon' => 'lucide:wrench', 'label' => 'Implementation (automations + tracking)'],
                            ['icon' => 'lucide:check-circle-2', 'label' => 'Testing + iteration (A/B and deliverability checks)'],
                        ] as $step)
                            <li class="flex items-start gap-3 rounded-[24px] bg-white/10 px-5 py-4 text-slate-200">
                                <span class="mt-0.5 inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-white/10 text-brand-green">
                                    <iconify-icon icon="{{ $step['icon'] }}" class="h-5 w-5"></iconify-icon>
                                </span>
                                <span class="text-sm text-slate-200">{{ $step['label'] }}</span>
                            </li>
                        @endforeach
                    </ol>
                </div>
            </div>
        </section>

        <section class="page-panel py-20 lg:py-24">
            <div class="section-shell">
                <div class="mb-10 max-w-3xl" data-reveal>
                    <div class="section-kicker">Providers & Compatibility</div>
                    <h2 class="mt-4 headline-lg text-brand-blue">Works with your provider and your stack.</h2>
                    <p class="mt-4 text-slate-600">We can implement email automation in your marketing platform, or build a clean SMTP/API sending foundation—depending on your needs.</p>
                </div>

                <div class="grid gap-6 lg:grid-cols-2">
                    <div class="surface-card" data-reveal>
                        <h3 class="text-2xl font-bold text-brand-blue">Email platforms</h3>
                        <div class="mt-5 grid gap-3 sm:grid-cols-2">
                            @foreach ([
                                ['label' => 'Mailchimp / Brevo', 'icon' => 'lucide:mail'],
                                ['label' => 'Klaviyo', 'icon' => 'lucide:shopping-cart'],
                                ['label' => 'HubSpot', 'icon' => 'lucide:badge-percent'],
                                ['label' => 'Zoho Campaigns', 'icon' => 'lucide:users'],
                            ] as $tech)
                                <div class="stack-tile">
                                    <span class="stack-icon"><iconify-icon icon="{{ $tech['icon'] }}"></iconify-icon></span>
                                    <span class="stack-label">{{ $tech['label'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="surface-card" data-reveal>
                        <h3 class="text-2xl font-bold text-brand-blue">Sending & infrastructure</h3>
                        <div class="mt-5 grid gap-3 sm:grid-cols-2">
                            @foreach ([
                                ['label' => 'SMTP / API sending', 'icon' => 'lucide:plug'],
                                ['label' => 'SPF/DKIM/DMARC', 'icon' => 'lucide:shield-check'],
                                ['label' => 'Tracking + events', 'icon' => 'lucide:line-chart'],
                                ['label' => 'Webhooks', 'icon' => 'lucide:webhook'],
                            ] as $tech)
                                <div class="stack-tile">
                                    <span class="stack-icon"><iconify-icon icon="{{ $tech['icon'] }}"></iconify-icon></span>
                                    <span class="stack-label">{{ $tech['label'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section-shell py-20 lg:py-24">
            <div class="grid gap-10 lg:grid-cols-2 lg:items-start">
                <div data-reveal>
                    <div class="section-kicker">FAQ</div>
                    <h2 class="mt-4 text-3xl font-bold text-white">Email automation questions</h2>
                    <p class="mt-4 text-slate-300">Deliverability, tooling, and what sequences matter most.</p>
                </div>
                <div class="space-y-3" data-reveal x-data="{ open: 0 }">
                    @foreach ([
                        ['q' => 'Can you improve deliverability?', 'a' => 'Yes. We set up domain authentication (SPF/DKIM/DMARC), fix list hygiene, and structure sending so your reputation improves over time.'],
                        ['q' => 'Do you write email copy?', 'a' => 'We create the structure, messaging, and copy direction. If you want, we can write full copy or work with your team to finalize tone and offers.'],
                        ['q' => 'Can you automate based on user actions?', 'a' => 'Yes. We trigger sequences from events like signups, purchases, inactivity, form submissions, and CRM stage changes.'],
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
                                 x-transition:enter-end="opacity=100 translate-y-0"
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
    @elseif(($service['slug'] ?? '') === 'startup-mvp-development')
        <section class="dark-band relative overflow-hidden">
            <div class="section-shell section-spacious relative pt-12 lg:pt-16">
                <div class="grid gap-10 lg:grid-cols-[1.05fr_0.95fr] lg:items-center">
                    <div data-reveal>
                        <div class="section-kicker">Startup MVP Development</div>
                        <h1 class="mt-5 headline-lg">Ship the first version without shipping chaos.</h1>
                        <p class="mt-5 body-lg text-slate-300">
                            From idea to reality—We help founders turn a product dream into a real, usable MVP with disciplined scope, clear journeys, and a build that won’t collapse the moment traction starts.
                        </p>

                        <div class="mt-7 flex flex-wrap gap-4">
                            <a href="{{ route('website.contact') }}" class="btn-primary"
                               x-on:click.prevent="$store.marketingPopup.openLead({ title: 'Startup MVP Development', source: 'service_startup_mvp_cta', context: 'Startup MVP development inquiry', submitLabel: 'Discuss MVP' })">
                                @include('website.partials.icon', ['name' => 'calendar', 'class' => 'h-4 w-4'])
                                Discuss MVP
                            </a>
                            <a href="{{ route('website.services') }}" class="btn-secondary">
                                @include('website.partials.icon', ['name' => 'layers', 'class' => 'h-4 w-4'])
                                All Services
                            </a>
                        </div>

                        <div class="mt-9 flex flex-wrap items-center gap-3 text-sm text-slate-300">
                            @foreach ([
                                ['icon' => 'lucide:target', 'label' => 'MVP scope'],
                                ['icon' => 'lucide:route', 'label' => 'User journeys'],
                                ['icon' => 'lucide:layout-dashboard', 'label' => 'Admin & ops'],
                                ['icon' => 'lucide:rocket', 'label' => 'Launch-ready'],
                            ] as $chip)
                                <div class="inline-flex items-center gap-2 rounded-2xl border border-white/10 bg-white/5 px-4 py-2">
                                    <iconify-icon icon="{{ $chip['icon'] }}" class="h-4 w-4 text-brand-green"></iconify-icon>
                                    <span>{{ $chip['label'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div data-reveal>
                        <div class="hero-media-stage">
                            <img src="{{ $mediaAssetUrl($websiteImages['services']['startup-mvp-development-hero'] ?? null, 'assets/images/startup-mvp-hero.svg') }}" alt="Startup MVP workspace" class="hero-media-image">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="page-panel py-20 lg:py-24">
            <div class="section-shell">
                <div class="mb-10 max-w-3xl" data-reveal>
                    <div class="section-kicker">Idea to reality</div>
                    <h2 class="mt-4 headline-lg text-brand-blue">From dreams to real-world product.</h2>
                    <p class="mt-4 text-slate-600">We take you from “concept” to a working MVP with a clear plan, fast iterations, and strong delivery discipline.</p>
                </div>

                <div class="grid gap-6 lg:grid-cols-3">
                    @foreach ([
                        ['step' => '01', 'title' => 'Clarify the idea', 'copy' => 'Problem, audience, promise, and the one core journey that proves value.'],
                        ['step' => '02', 'title' => 'Design the flow', 'copy' => 'Wireframes, states, admin ops, and the exact scope we will ship first.'],
                        ['step' => '03', 'title' => 'Build and launch', 'copy' => 'Sprint delivery, QA, deploy, and a data-driven plan for v2.'],
                    ] as $card)
                        <div class="surface-card premium-card" data-reveal>
                            <div class="text-sm font-semibold uppercase tracking-[0.25em] text-brand-green">{{ $card['step'] }}</div>
                            <h3 class="mt-4 text-2xl font-bold text-brand-blue">{{ $card['title'] }}</h3>
                            <p class="mt-3 text-slate-600">{{ $card['copy'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="light-band">
            <div class="section-shell section-spacious">
                <div class="mb-10 max-w-3xl" data-reveal>
                    <div class="section-kicker">What we build</div>
                    <h2 class="mt-4 headline-lg text-brand-blue">The MVP that proves the business.</h2>
                    <p class="mt-4 text-slate-600">We focus on the core journey first—then add the operational pieces founders always need: admin, roles, payments, and analytics.</p>
                </div>

                <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
                    @foreach ([
                        ['icon' => 'lucide:route', 'title' => 'Core user journey', 'copy' => 'The shortest path to value: onboarding → action → outcome.'],
                        ['icon' => 'lucide:layout-dashboard', 'title' => 'Admin & operations', 'copy' => 'Dashboards, approvals, content, and internal visibility.'],
                        ['icon' => 'lucide:users', 'title' => 'Roles & access', 'copy' => 'Role-based flows for customers, staff, and admins.'],
                        ['icon' => 'lucide:credit-card', 'title' => 'Payments & pricing', 'copy' => 'Plans, checkout, invoices, and subscription logic where needed.'],
                        ['icon' => 'lucide:plug', 'title' => 'Integrations', 'copy' => 'CRMs, email, WhatsApp, analytics, and third-party APIs.'],
                        ['icon' => 'lucide:shield-check', 'title' => 'Security basics', 'copy' => 'Auth, permissions, audit-friendly flows, and safe defaults.'],
                        ['icon' => 'lucide:line-chart', 'title' => 'Analytics-ready', 'copy' => 'Events, funnels, and dashboards to learn from real usage.'],
                        ['icon' => 'lucide:rocket', 'title' => 'Launch + iteration', 'copy' => 'Release readiness, fixes, and the next sprint plan.'],
                    ] as $item)
                        <div class="surface-card premium-card" data-reveal>
                            <div class="premium-icon inline-flex rounded-2xl bg-brand-surface p-5 text-brand-blue">
                                <iconify-icon icon="{{ $item['icon'] }}" class="h-7 w-7 text-brand-blue"></iconify-icon>
                            </div>
                            <h3 class="mt-5 text-2xl font-bold text-brand-blue">{{ $item['title'] }}</h3>
                            <p class="mt-4 text-slate-600">{{ $item['copy'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="section-shell py-20 lg:py-24">
            <div class="grid gap-8 lg:grid-cols-2">
                <div class="glass-card" data-reveal>
                    <div class="section-kicker">Deliverables</div>
                    <h2 class="mt-4 text-3xl font-bold text-white">Everything needed to launch</h2>
                    <p class="mt-4 text-slate-300">Founders don’t just need screens—they need a working system with clear ownership and a path to v2.</p>
                    <ul class="mt-6 grid gap-3 sm:grid-cols-2">
                        @foreach ([
                            ['icon' => 'lucide:map', 'label' => 'Scope + user journey map'],
                            ['icon' => 'lucide:layout-template', 'label' => 'UI system + key screens'],
                            ['icon' => 'lucide:lock', 'label' => 'Authentication + roles'],
                            ['icon' => 'lucide:database', 'label' => 'Data model + core entities'],
                            ['icon' => 'lucide:plug', 'label' => 'Integrations + APIs'],
                            ['icon' => 'lucide:check-circle-2', 'label' => 'QA + launch checklist'],
                        ] as $item)
                            <li class="flex items-start gap-3 rounded-[22px] bg-white/8 px-4 py-3 text-slate-200">
                                <span class="mt-0.5 inline-flex h-9 w-9 items-center justify-center rounded-2xl bg-white/10 text-brand-green">
                                    <iconify-icon icon="{{ $item['icon'] }}" class="h-5 w-5"></iconify-icon>
                                </span>
                                <span class="text-sm font-semibold text-white">{{ $item['label'] }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="glass-card" data-reveal>
                    <div class="section-kicker">Process</div>
                    <h2 class="mt-4 text-3xl font-bold text-white">How we ship an MVP</h2>
                    <ol class="mt-6 space-y-4">
                        @foreach ([
                            ['icon' => 'lucide:target', 'label' => 'Define MVP scope (core journey + success metric)'],
                            ['icon' => 'lucide:route', 'label' => 'Design flows (states, edge cases, admin ops)'],
                            ['icon' => 'lucide:code-2', 'label' => 'Build in sprints (weekly demos + feedback)'],
                            ['icon' => 'lucide:check-circle-2', 'label' => 'QA + release prep (stability first)'],
                            ['icon' => 'lucide:rocket', 'label' => 'Launch + iterate (data-driven v2 plan)'],
                        ] as $step)
                            <li class="flex items-start gap-3 rounded-[24px] bg-white/10 px-5 py-4 text-slate-200">
                                <span class="mt-0.5 inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-white/10 text-brand-green">
                                    <iconify-icon icon="{{ $step['icon'] }}" class="h-5 w-5"></iconify-icon>
                                </span>
                                <span class="text-sm text-slate-200">{{ $step['label'] }}</span>
                            </li>
                        @endforeach
                    </ol>
                </div>
            </div>
        </section>

        <section class="page-panel py-20 lg:py-24">
            <div class="section-shell">
                <div class="mb-10 max-w-3xl" data-reveal>
                    <div class="section-kicker">Stack</div>
                    <h2 class="mt-4 headline-lg text-brand-blue">Tech choices that are fast now and scalable later.</h2>
                </div>

                <div class="grid gap-6 lg:grid-cols-2">
                    <div class="surface-card" data-reveal>
                        <h3 class="text-2xl font-bold text-brand-blue">Product build</h3>
                        <div class="mt-5 grid gap-3 sm:grid-cols-2">
                            @foreach ([
                                ['label' => 'Laravel', 'icon' => 'simple-icons:laravel'],
                                ['label' => 'TailwindCSS', 'icon' => 'simple-icons:tailwindcss'],
                                ['label' => 'React / Next.js', 'icon' => 'simple-icons:react'],
                                ['label' => 'Vue / Nuxt', 'icon' => 'simple-icons:vuedotjs'],
                                ['label' => 'Node.js', 'icon' => 'simple-icons:nodedotjs'],
                                ['label' => 'WordPress', 'icon' => 'simple-icons:wordpress'],
                                ['label' => 'APIs + Webhooks', 'icon' => 'lucide:plug'],
                            ] as $tech)
                                <div class="stack-tile">
                                    <span class="stack-icon"><iconify-icon icon="{{ $tech['icon'] }}"></iconify-icon></span>
                                    <span class="stack-label">{{ $tech['label'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="surface-card" data-reveal>
                        <h3 class="text-2xl font-bold text-brand-blue">Infra & delivery</h3>
                        <div class="mt-5 grid gap-3 sm:grid-cols-2">
                            @foreach ([
                                ['label' => 'PostgreSQL / MySQL', 'icon' => 'lucide:database'],
                                ['label' => 'Queues + jobs', 'icon' => 'lucide:layers'],
                                ['label' => 'Redis cache', 'icon' => 'simple-icons:redis'],
                                ['label' => 'Terraform', 'icon' => 'simple-icons:terraform'],
                                ['label' => 'Logs + monitoring', 'icon' => 'lucide:bell'],
                                ['label' => 'Deployments', 'icon' => 'lucide:cloud'],
                            ] as $tech)
                                <div class="stack-tile">
                                    <span class="stack-icon"><iconify-icon icon="{{ $tech['icon'] }}"></iconify-icon></span>
                                    <span class="stack-label">{{ $tech['label'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="light-band">
            <div class="section-shell section-spacious">
                <div class="mb-10 max-w-3xl" data-reveal>
                    <div class="section-kicker">Sectors</div>
                    <h2 class="mt-4 headline-lg text-brand-blue">Built for your niche and your workflow.</h2>
                    <p class="mt-4 text-slate-600">Whether it’s astrology consultations, education platforms, sports communities, or healthcare workflows—we design the right journey and build the operations behind it.</p>
                </div>

                <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ([
                        ['icon' => 'lucide:stars', 'title' => 'Astrology', 'copy' => 'Bookings, subscriptions, reports, and WhatsApp follow-ups.'],
                        ['icon' => 'lucide:graduation-cap', 'title' => 'Education', 'copy' => 'Courses, cohorts, dashboards, assessments, and payments.'],
                        ['icon' => 'lucide:trophy', 'title' => 'Sports', 'copy' => 'Communities, memberships, scheduling, and media content flows.'],
                        ['icon' => 'lucide:heart-pulse', 'title' => 'Healthcare', 'copy' => 'Appointments, patient workflows, secure access, and reminders.'],
                        ['icon' => 'lucide:shopping-cart', 'title' => 'eCommerce', 'copy' => 'Catalog, checkout, order ops, and retention automations.'],
                        ['icon' => 'lucide:building-2', 'title' => 'Real estate', 'copy' => 'Listings, lead capture, follow-ups, and agent workflows.'],
                        ['icon' => 'lucide:car', 'title' => 'Automotive', 'copy' => 'Enquiries, service bookings, reminders, and CRM sync.'],
                        ['icon' => 'lucide:briefcase', 'title' => 'B2B services', 'copy' => 'Lead funnels, proposals, CRM pipelines, and onboarding.'],
                        ['icon' => 'lucide:plane', 'title' => 'Travel', 'copy' => 'Search, bookings, itineraries, and support flows.'],
                    ] as $ind)
                        <div class="surface-card premium-card" data-reveal>
                            <div class="flex items-start gap-4">
                                <span class="premium-icon inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-brand-surface text-brand-blue">
                                    <iconify-icon icon="{{ $ind['icon'] }}" class="h-6 w-6 text-brand-blue"></iconify-icon>
                                </span>
                                <div>
                                    <div class="text-lg font-bold text-brand-blue">{{ $ind['title'] }}</div>
                                    <div class="mt-1 text-sm text-slate-600">{{ $ind['copy'] }}</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="section-shell py-20 lg:py-24">
            <div class="grid gap-10 lg:grid-cols-2 lg:items-start">
                <div data-reveal>
                    <div class="section-kicker">FAQ</div>
                    <h2 class="mt-4 text-3xl font-bold text-white">MVP questions</h2>
                    <p class="mt-4 text-slate-300">Scope, timelines, and what founders should prioritize.</p>
                </div>
                <div class="space-y-3" data-reveal x-data="{ open: 0 }">
                    @foreach ([
                        ['q' => 'How fast can we launch an MVP?', 'a' => 'It depends on scope, but most MVPs land in 3–8 weeks for a solid core journey + admin and launch readiness.'],
                        ['q' => 'Can you help define the scope?', 'a' => 'Yes. We map the user journey and success metric first, then cut scope to what proves the business quickly.'],
                        ['q' => 'Will the MVP be scalable for v2?', 'a' => 'Yes. We keep architecture clean and add only what’s necessary now, so v2 builds on a stable foundation instead of a rewrite.'],
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
    @elseif(($service['slug'] ?? '') === 'custom-software-development')
        <section class="dark-band relative overflow-hidden">
            <div class="section-shell section-spacious relative pt-12 lg:pt-16">
                <div class="grid gap-10 lg:grid-cols-[1.05fr_0.95fr] lg:items-center">
                    <div data-reveal>
                        <div class="section-kicker">Custom Software Development</div>
                        <h1 class="mt-5 headline-lg">Custom software, built exactly for your business.</h1>
                        <p class="mt-5 body-lg text-slate-300">
                            Whatever your workflow is—CRM, operations, approvals, support, inventory, finance—we build a tailored system around it. Replace scattered spreadsheets and fragmented tools with a structured platform: dashboards, workflows, roles, and integrations built for your exact process.
                        </p>

                        <div class="mt-7 flex flex-wrap gap-4">
                            <a href="{{ route('website.contact') }}" class="btn-primary"
                               x-on:click.prevent="$store.marketingPopup.openLead({ title: 'Custom Software Development', source: 'service_custom_software_cta', context: 'Custom software development inquiry', submitLabel: 'Discuss Software' })">
                                @include('website.partials.icon', ['name' => 'calendar', 'class' => 'h-4 w-4'])
                                Discuss Software
                            </a>
                            <a href="{{ route('website.services') }}" class="btn-secondary">
                                @include('website.partials.icon', ['name' => 'layers', 'class' => 'h-4 w-4'])
                                All Services
                            </a>
                        </div>

                        <div class="mt-9 flex flex-wrap items-center gap-3 text-sm text-slate-300">
                            @foreach ([
                                ['icon' => 'lucide:layout-dashboard', 'label' => 'Dashboards'],
                                ['icon' => 'lucide:workflow', 'label' => 'Workflows'],
                                ['icon' => 'lucide:users', 'label' => 'Role-based access'],
                                ['icon' => 'lucide:plug', 'label' => 'Integrations'],
                                ['icon' => 'lucide:shield-check', 'label' => 'Security + audits'],
                            ] as $chip)
                                <div class="inline-flex items-center gap-2 rounded-2xl border border-white/10 bg-white/5 px-4 py-2">
                                    <iconify-icon icon="{{ $chip['icon'] }}" class="h-4 w-4 text-brand-green"></iconify-icon>
                                    <span>{{ $chip['label'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div data-reveal>
                        <div class="hero-media-stage">
                            <img src="{{ $mediaAssetUrl($websiteImages['services']['custom-software-development-hero'] ?? null, 'assets/images/team-collaboration.svg') }}" alt="Team collaboration dashboard" class="hero-media-image">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="light-band">
            <div class="section-shell section-spacious">
                <div class="mb-10 max-w-3xl" data-reveal>
                    <div class="section-kicker">What we build</div>
                    <h2 class="mt-4 headline-lg text-brand-blue">Whatever you need—fully customized.</h2>
                    <p class="mt-4 text-slate-600">We build custom platforms that match your exact workflow: modules, roles, dashboards, and integrations. Below are common examples—we can tailor the system to any niche, team structure, or operating style.</p>
                </div>

                <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
                    @foreach ([
                        ['icon' => 'lucide:layout-dashboard', 'title' => 'Dashboards', 'copy' => 'Role-based dashboards for leadership, ops, sales, and support.'],
                        ['icon' => 'lucide:workflow', 'title' => 'Workflows & approvals', 'copy' => 'Requests, approvals, escalations, and reminders with audit trails.'],
                        ['icon' => 'lucide:headset', 'title' => 'Support & ticketing', 'copy' => 'Ticket flows, SLAs, internal notes, and customer-facing portals.'],
                        ['icon' => 'lucide:badge-percent', 'title' => 'CRM & pipelines', 'copy' => 'Lead intake, deal stages, follow-ups, and reporting that stays clean.'],
                        ['icon' => 'lucide:package', 'title' => 'Inventory / operations', 'copy' => 'Catalogs, stock tracking, dispatch, and internal operational visibility.'],
                        ['icon' => 'lucide:file-text', 'title' => 'Documents & billing', 'copy' => 'Invoices, receipts, approvals, and structured document workflows.'],
                        ['icon' => 'lucide:plug', 'title' => 'Integrations', 'copy' => 'Connect CRMs, email, WhatsApp, payments, and third-party APIs.'],
                        ['icon' => 'lucide:bar-chart-3', 'title' => 'Reporting', 'copy' => 'Single source of truth dashboards and scheduled reporting.'],
                    ] as $item)
                        <div class="surface-card premium-card" data-reveal>
                            <div class="premium-icon inline-flex rounded-2xl bg-brand-surface p-5 text-brand-blue">
                                <iconify-icon icon="{{ $item['icon'] }}" class="h-7 w-7 text-brand-blue"></iconify-icon>
                            </div>
                            <h3 class="mt-5 text-2xl font-bold text-brand-blue">{{ $item['title'] }}</h3>
                            <p class="mt-4 text-slate-600">{{ $item['copy'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="section-shell py-20 lg:py-24">
            <div class="grid gap-8 lg:grid-cols-2">
                <div class="glass-card" data-reveal>
                    <div class="section-kicker">Deliverables</div>
                    <h2 class="mt-4 text-3xl font-bold text-white">A platform your team can actually run</h2>
                    <p class="mt-4 text-slate-300">Clear roles, clean data, and predictable behavior—built for real operational load.</p>
                    <ul class="mt-6 grid gap-3 sm:grid-cols-2">
                        @foreach ([
                            ['icon' => 'lucide:map', 'label' => 'Workflow + requirements mapping'],
                            ['icon' => 'lucide:users', 'label' => 'Roles, permissions, and access controls'],
                            ['icon' => 'lucide:database', 'label' => 'Data model + admin dashboards'],
                            ['icon' => 'lucide:plug', 'label' => 'Integrations + webhooks'],
                            ['icon' => 'lucide:shield-check', 'label' => 'Security baselines + audit trails'],
                            ['icon' => 'lucide:check-circle-2', 'label' => 'QA + deployment readiness'],
                        ] as $item)
                            <li class="flex items-start gap-3 rounded-[22px] bg-white/8 px-4 py-3 text-slate-200">
                                <span class="mt-0.5 inline-flex h-9 w-9 items-center justify-center rounded-2xl bg-white/10 text-brand-green">
                                    <iconify-icon icon="{{ $item['icon'] }}" class="h-5 w-5"></iconify-icon>
                                </span>
                                <span class="text-sm font-semibold text-white">{{ $item['label'] }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="glass-card" data-reveal>
                    <div class="section-kicker">Process</div>
                    <h2 class="mt-4 text-3xl font-bold text-white">How we deliver custom software</h2>
                    <ol class="mt-6 space-y-4">
                        @foreach ([
                            ['icon' => 'lucide:search', 'label' => 'Discovery (teams, tools, bottlenecks, data)'],
                            ['icon' => 'lucide:workflow', 'label' => 'System design (modules, roles, states, rules)'],
                            ['icon' => 'lucide:code-2', 'label' => 'Build in milestones (visible demos + feedback)'],
                            ['icon' => 'lucide:check-circle-2', 'label' => 'QA + training (edge cases, handoff, SOPs)'],
                            ['icon' => 'lucide:rocket', 'label' => 'Deploy + iterate (monitoring + improvements)'],
                        ] as $step)
                            <li class="flex items-start gap-3 rounded-[24px] bg-white/10 px-5 py-4 text-slate-200">
                                <span class="mt-0.5 inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-white/10 text-brand-green">
                                    <iconify-icon icon="{{ $step['icon'] }}" class="h-5 w-5"></iconify-icon>
                                </span>
                                <span class="text-sm text-slate-200">{{ $step['label'] }}</span>
                            </li>
                        @endforeach
                    </ol>
                </div>
            </div>
        </section>

        <section class="page-panel py-20 lg:py-24">
            <div class="section-shell">
                <div class="mb-10 max-w-3xl" data-reveal>
                    <div class="section-kicker">Stack</div>
                    <h2 class="mt-4 headline-lg text-brand-blue">Modern, maintainable, and integration-friendly.</h2>
                </div>

                <div class="grid gap-6 lg:grid-cols-2">
                    <div class="surface-card" data-reveal>
                        <h3 class="text-2xl font-bold text-brand-blue">Application</h3>
                        <div class="mt-5 grid gap-3 sm:grid-cols-2">
                            @foreach ([
                                ['label' => 'Laravel', 'icon' => 'simple-icons:laravel'],
                                ['label' => 'React / Next.js', 'icon' => 'simple-icons:react'],
                                ['label' => 'Vue', 'icon' => 'simple-icons:vuedotjs'],
                                ['label' => 'TailwindCSS', 'icon' => 'simple-icons:tailwindcss'],
                                ['label' => 'APIs + Webhooks', 'icon' => 'lucide:plug'],
                                ['label' => 'RBAC', 'icon' => 'lucide:users'],
                            ] as $tech)
                                <div class="stack-tile">
                                    <span class="stack-icon"><iconify-icon icon="{{ $tech['icon'] }}"></iconify-icon></span>
                                    <span class="stack-label">{{ $tech['label'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="surface-card" data-reveal>
                        <h3 class="text-2xl font-bold text-brand-blue">Infrastructure</h3>
                        <div class="mt-5 grid gap-3 sm:grid-cols-2">
                            @foreach ([
                                ['label' => 'PostgreSQL / MySQL', 'icon' => 'lucide:database'],
                                ['label' => 'Redis', 'icon' => 'simple-icons:redis'],
                                ['label' => 'Queues + workers', 'icon' => 'lucide:layers'],
                                ['label' => 'Terraform', 'icon' => 'simple-icons:terraform'],
                                ['label' => 'Logging + alerts', 'icon' => 'lucide:bell'],
                                ['label' => 'Cloud deploy', 'icon' => 'lucide:cloud'],
                            ] as $tech)
                                <div class="stack-tile">
                                    <span class="stack-icon"><iconify-icon icon="{{ $tech['icon'] }}"></iconify-icon></span>
                                    <span class="stack-label">{{ $tech['label'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="light-band">
            <div class="section-shell section-spacious">
                <div class="mb-10 max-w-3xl" data-reveal>
                    <div class="section-kicker">Industries</div>
                    <h2 class="mt-4 headline-lg text-brand-blue">Sector-aware systems with real operational detail.</h2>
                    <p class="mt-4 text-slate-600">We tailor workflows, permissions, and data models to your industry realities—compliance, speed, and trust signals included.</p>
                </div>

                <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ([
                        ['icon' => 'lucide:heart-pulse', 'title' => 'Healthcare', 'copy' => 'Appointments, patient flows, secure access, reminders, audit trails.'],
                        ['icon' => 'lucide:graduation-cap', 'title' => 'Education', 'copy' => 'Cohorts, dashboards, assessments, payments, admin visibility.'],
                        ['icon' => 'lucide:shopping-cart', 'title' => 'Commerce', 'copy' => 'Inventory, dispatch, returns, pricing, and reporting.'],
                        ['icon' => 'lucide:building-2', 'title' => 'Real estate', 'copy' => 'Listings, lead intake, follow-ups, agent workflows.'],
                        ['icon' => 'lucide:briefcase', 'title' => 'B2B services', 'copy' => 'Pipeline ops, proposals, onboarding, renewals, retention.'],
                        ['icon' => 'lucide:factory', 'title' => 'Manufacturing', 'copy' => 'Orders, tracking, quality checks, and internal approvals.'],
                    ] as $ind)
                        <div class="surface-card premium-card" data-reveal>
                            <div class="flex items-start gap-4">
                                <span class="premium-icon inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-brand-surface text-brand-blue">
                                    <iconify-icon icon="{{ $ind['icon'] }}" class="h-6 w-6 text-brand-blue"></iconify-icon>
                                </span>
                                <div>
                                    <div class="text-lg font-bold text-brand-blue">{{ $ind['title'] }}</div>
                                    <div class="mt-1 text-sm text-slate-600">{{ $ind['copy'] }}</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="section-shell py-20 lg:py-24">
            <div class="grid gap-10 lg:grid-cols-2 lg:items-start">
                <div data-reveal>
                    <div class="section-kicker">FAQ</div>
                    <h2 class="mt-4 text-3xl font-bold text-white">Custom software questions</h2>
                    <p class="mt-4 text-slate-300">Scope, integrations, and how we avoid “software that nobody uses”.</p>
                </div>
                <div class="space-y-3" data-reveal x-data="{ open: 0 }">
                    @foreach ([
                        ['q' => 'Can you integrate with our existing tools?', 'a' => 'Yes. We integrate with CRMs, email, WhatsApp, payments, and third-party systems via APIs and webhooks—so your new platform becomes the source of truth.'],
                        ['q' => 'How do you ensure the team actually adopts it?', 'a' => 'We design around real workflows, roles, and pain points, then ship in milestones with demos and training so adoption is built into delivery.'],
                        ['q' => 'Can you build modules incrementally?', 'a' => 'Yes. We can launch a core module first (e.g., CRM + dashboard), then add operations, support, reporting, and automation in phases.'],
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
    @elseif(($service['slug'] ?? '') === 'whatsapp-cloud-automation')
        <section class="dark-band relative overflow-hidden">
            <div class="section-shell section-spacious relative pt-12 lg:pt-16">
                <div class="grid gap-10 lg:grid-cols-[1.05fr_0.95fr] lg:items-center">
                    <div data-reveal>
                        <div class="section-kicker">WhatsApp Cloud & Automation</div>
                        <h1 class="mt-5 headline-lg">Turn WhatsApp into a real business channel.</h1>
                        <p class="mt-5 body-lg text-slate-300">
                            We implement WhatsApp Cloud API, templates, and automation flows so leads, support, and order updates run inside your system—not on scattered phones.
                        </p>

                        <div class="mt-7 flex flex-wrap gap-4">
                            <a href="{{ route('website.contact') }}" class="btn-primary"
                               x-on:click.prevent="$store.marketingPopup.openLead({ title: 'WhatsApp Cloud & Automation', source: 'service_whatsapp_cta', context: 'WhatsApp Cloud automation inquiry', submitLabel: 'Discuss WhatsApp' })">
                                @include('website.partials.icon', ['name' => 'calendar', 'class' => 'h-4 w-4'])
                                Discuss WhatsApp
                            </a>
                            <a href="{{ route('website.services') }}" class="btn-secondary">
                                @include('website.partials.icon', ['name' => 'layers', 'class' => 'h-4 w-4'])
                                All Services
                            </a>
                        </div>

                        <div class="mt-9 flex flex-wrap items-center gap-3 text-sm text-slate-300">
                            @foreach ([
                                ['icon' => 'simple-icons:whatsapp', 'label' => 'Cloud API'],
                                ['icon' => 'lucide:message-square', 'label' => 'Chatbots'],
                                ['icon' => 'lucide:shopping-cart', 'label' => 'eCommerce flows'],
                                ['icon' => 'lucide:headset', 'label' => 'Support automations'],
                                ['icon' => 'lucide:shield-check', 'label' => 'Compliance-ready'],
                            ] as $chip)
                                <div class="inline-flex items-center gap-2 rounded-2xl border border-white/10 bg-white/5 px-4 py-2">
                                    <iconify-icon icon="{{ $chip['icon'] }}" class="h-4 w-4 text-brand-green"></iconify-icon>
                                    <span>{{ $chip['label'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div data-reveal>
                        <div class="hero-media-stage">
                            <img src="{{ $mediaAssetUrl($websiteImages['services']['whatsapp-cloud-automation-hero'] ?? null, 'assets/images/whatsapp-automation-hero.svg') }}" alt="WhatsApp automation illustration" class="hero-media-image">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="light-band">
            <div class="section-shell section-spacious">
                <div class="mb-10 max-w-3xl" data-reveal>
                    <div class="section-kicker">Automation use-cases</div>
                    <h2 class="mt-4 headline-lg text-brand-blue">Chats that convert, support, and notify—automatically.</h2>
                    <p class="mt-4 text-slate-600">We design structured conversation flows with human handoff, template compliance, and the integrations needed to keep data synced.</p>
                </div>

                <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
                    @foreach ([
                        ['icon' => 'lucide:message-square-quote', 'title' => 'Lead capture chatbot', 'copy' => 'Qualify leads, collect requirements, and push into your CRM instantly.'],
                        ['icon' => 'lucide:shopping-bag', 'title' => 'Order updates', 'copy' => 'Shipping, delivery, and status notifications with template-safe messages.'],
                        ['icon' => 'lucide:repeat', 'title' => 'Abandoned cart nudges', 'copy' => 'Trigger follow-ups with guardrails and opt-out handling.'],
                        ['icon' => 'lucide:headset', 'title' => 'Support triage', 'copy' => 'Auto-route, summarize, and escalate to agents when needed.'],
                        ['icon' => 'lucide:calendar-check', 'title' => 'Bookings & reminders', 'copy' => 'Appointments, confirmations, reschedules, and no-show prevention.'],
                        ['icon' => 'lucide:badge-check', 'title' => 'KYC / verification', 'copy' => 'OTP-style flows, document requests, and “needs review” routing.'],
                        ['icon' => 'lucide:receipt', 'title' => 'Invoices & receipts', 'copy' => 'Send receipts, payment reminders, and status confirmations.'],
                        ['icon' => 'lucide:layout-dashboard', 'title' => 'Ops dashboards', 'copy' => 'Conversation status, agent performance, and failure visibility.'],
                    ] as $item)
                        <div class="surface-card premium-card" data-reveal>
                            <div class="premium-icon inline-flex rounded-2xl bg-brand-surface p-5 text-brand-blue">
                                <iconify-icon icon="{{ $item['icon'] }}" class="h-7 w-7 text-brand-blue"></iconify-icon>
                            </div>
                            <h3 class="mt-5 text-2xl font-bold text-brand-blue">{{ $item['title'] }}</h3>
                            <p class="mt-4 text-slate-600">{{ $item['copy'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="section-shell py-20 lg:py-24">
            <div class="grid gap-8 lg:grid-cols-2">
                <div class="glass-card" data-reveal>
                    <div class="section-kicker">What you get</div>
                    <h2 class="mt-4 text-3xl font-bold text-white">Production-grade WhatsApp automation</h2>
                    <p class="mt-4 text-slate-300">Built with compliance, monitoring, and predictable handoff—so it runs reliably as volume grows.</p>
                    <ul class="mt-6 grid gap-3 sm:grid-cols-2">
                        @foreach ([
                            ['icon' => 'lucide:key', 'label' => 'Cloud API setup + access'],
                            ['icon' => 'lucide:mail-check', 'label' => 'Template creation + approvals'],
                            ['icon' => 'lucide:workflow', 'label' => 'Conversation flows + states'],
                            ['icon' => 'lucide:plug', 'label' => 'Webhooks + integrations'],
                            ['icon' => 'lucide:shield-check', 'label' => 'Compliance + opt-outs'],
                            ['icon' => 'lucide:bell', 'label' => 'Retries, logs, and alerts'],
                        ] as $item)
                            <li class="flex items-start gap-3 rounded-[22px] bg-white/8 px-4 py-3 text-slate-200">
                                <span class="mt-0.5 inline-flex h-9 w-9 items-center justify-center rounded-2xl bg-white/10 text-brand-green">
                                    <iconify-icon icon="{{ $item['icon'] }}" class="h-5 w-5"></iconify-icon>
                                </span>
                                <span class="text-sm font-semibold text-white">{{ $item['label'] }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="glass-card" data-reveal>
                    <div class="section-kicker">Compatibility</div>
                    <h2 class="mt-4 text-3xl font-bold text-white">Works with your existing tools</h2>
                    <p class="mt-4 text-slate-300">We connect WhatsApp to the systems where your team already works—CRM, eCommerce, support, and operations.</p>
                    <div class="mt-6 grid gap-3 sm:grid-cols-2">
                        @foreach ([
                            ['label' => 'Shopify / WooCommerce', 'icon' => 'lucide:shopping-cart'],
                            ['label' => 'CRM (HubSpot, Zoho)', 'icon' => 'lucide:badge-percent'],
                            ['label' => 'Support (Zendesk)', 'icon' => 'lucide:headset'],
                            ['label' => 'Slack / Email', 'icon' => 'lucide:mail'],
                            ['label' => 'Google Sheets', 'icon' => 'lucide:table-2'],
                            ['label' => 'Webhooks + APIs', 'icon' => 'lucide:plug'],
                        ] as $tech)
                            <div class="stack-tile">
                                <span class="stack-icon"><iconify-icon icon="{{ $tech['icon'] }}"></iconify-icon></span>
                                <span class="stack-label">{{ $tech['label'] }}</span>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-8 rounded-[24px] border border-white/10 bg-white/5 p-5 text-slate-300">
                        <div class="text-sm font-semibold uppercase tracking-[0.22em] text-brand-green">Providers</div>
                        <p class="mt-3">We can implement on <span class="text-white font-semibold">Meta WhatsApp Cloud API</span> and also support BSP-based setups (where required) like <span class="text-white font-semibold">Twilio</span> or <span class="text-white font-semibold">360dialog</span>, depending on your region, use-case, and compliance needs.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="page-panel py-20 lg:py-24">
            <div class="section-shell">
                <div class="mb-10 max-w-3xl" data-reveal>
                    <div class="section-kicker">Process</div>
                    <h2 class="mt-4 headline-lg text-brand-blue">How we ship WhatsApp automation</h2>
                </div>
                <div class="grid gap-6 lg:grid-cols-3">
                    @foreach ([
                        ['step' => '01', 'title' => 'Map conversations', 'copy' => 'Intents, states, template boundaries, escalation rules, owners.'],
                        ['step' => '02', 'title' => 'Implement Cloud API', 'copy' => 'Webhooks, message routing, template approvals, and compliance.'],
                        ['step' => '03', 'title' => 'Launch + monitor', 'copy' => 'Retries, logs, analytics, agent handoff, and iteration from real chats.'],
                    ] as $card)
                        <div class="surface-card premium-card" data-reveal>
                            <div class="text-sm font-semibold uppercase tracking-[0.25em] text-brand-green">{{ $card['step'] }}</div>
                            <h3 class="mt-4 text-2xl font-bold text-brand-blue">{{ $card['title'] }}</h3>
                            <p class="mt-3 text-slate-600">{{ $card['copy'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="section-shell py-20 lg:py-24">
            <div class="grid gap-10 lg:grid-cols-2 lg:items-start">
                <div data-reveal>
                    <div class="section-kicker">FAQ</div>
                    <h2 class="mt-4 text-3xl font-bold text-white">WhatsApp Cloud questions</h2>
                    <p class="mt-4 text-slate-300">Templates, compliance, and what’s realistic to automate.</p>
                </div>
                <div class="space-y-3" data-reveal x-data="{ open: 0 }">
                    @foreach ([
                        ['q' => 'Can you build a WhatsApp chatbot?', 'a' => 'Yes. We build structured conversation flows with human handoff, intent routing, and safe fallbacks—plus integrations so data goes to your CRM/support system.'],
                        ['q' => 'Do you help with templates and approvals?', 'a' => 'Yes. We create compliant templates, submit for approval, and design flows that respect messaging rules and opt-outs.'],
                        ['q' => 'Can you integrate with Shopify/CRM/support?', 'a' => 'Yes. We integrate via APIs/webhooks so order updates, leads, and tickets stay synced across systems.'],
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
    @elseif(($service['slug'] ?? '') === 'ai-automation')
        <section class="dark-band relative overflow-hidden">
            <div class="section-shell section-spacious relative pt-12 lg:pt-16">
                <div class="grid gap-10 lg:grid-cols-[1.05fr_0.95fr] lg:items-center">
                    <div data-reveal>
                        <div class="section-kicker">AI Automation</div>
                        <h1 class="mt-5 headline-lg">Automations that remove busywork and run reliably.</h1>
                        <p class="mt-5 body-lg text-slate-300">
                            We automate ops, sales, support, and reporting using reliable workflows and AI where it adds leverage—so your team ships faster, responds quicker, and makes fewer manual mistakes.
                        </p>

                        <div class="mt-7 flex flex-wrap gap-4">
                            <a href="{{ route('website.contact') }}" class="btn-primary"
                               x-on:click.prevent="$store.marketingPopup.openLead({ title: 'AI Automation', source: 'service_ai_automation_cta', context: 'AI automation inquiry', submitLabel: 'Discuss Automation' })">
                                @include('website.partials.icon', ['name' => 'calendar', 'class' => 'h-4 w-4'])
                                Discuss Automation
                            </a>
                            <a href="{{ route('website.services') }}" class="btn-secondary">
                                @include('website.partials.icon', ['name' => 'layers', 'class' => 'h-4 w-4'])
                                All Services
                            </a>
                        </div>

                        <div class="mt-9 flex flex-wrap items-center gap-3 text-sm text-slate-300">
                            @foreach ([
                                ['icon' => 'lucide:workflow', 'label' => 'Workflows'],
                                ['icon' => 'lucide:bot', 'label' => 'AI assistants'],
                                ['icon' => 'lucide:plug', 'label' => 'APIs & integrations'],
                                ['icon' => 'lucide:shield-check', 'label' => 'Reliable + monitored'],
                            ] as $chip)
                                <div class="inline-flex items-center gap-2 rounded-2xl border border-white/10 bg-white/5 px-4 py-2">
                                    <iconify-icon icon="{{ $chip['icon'] }}" class="h-4 w-4 text-brand-green"></iconify-icon>
                                    <span>{{ $chip['label'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div data-reveal>
                        <div class="hero-media-stage">
                            <img src="{{ $mediaAssetUrl($websiteImages['services']['ai-automation-hero'] ?? null, 'assets/images/ai-automation-hero.svg') }}" alt="AI automation illustration" class="hero-media-image">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="light-band">
            <div class="section-shell section-spacious">
                <div class="mb-10 max-w-3xl" data-reveal>
                    <div class="section-kicker">What we automate</div>
                    <h2 class="mt-4 headline-lg text-brand-blue">Practical automation with measurable impact.</h2>
                    <p class="mt-4 text-slate-600">We start with your workflows, tools, and bottlenecks—then automate the repetitive steps with safeguards, fallbacks, and clear ownership.</p>
                </div>

                <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
                    @foreach ([
                        ['icon' => 'lucide:message-square', 'title' => 'Chatbots & copilots', 'copy' => 'Website chat, WhatsApp, or in-app assistants that answer, guide, and escalate.'],
                        ['icon' => 'lucide:shopping-cart', 'title' => 'eCommerce automations', 'copy' => 'Order updates, abandoned cart follow-ups, catalog ops, and returns workflows.'],
                        ['icon' => 'lucide:headset', 'title' => 'Support automation', 'copy' => 'Auto-triage tickets, draft replies, route to the right team, and summarize threads.'],
                        ['icon' => 'lucide:badge-percent', 'title' => 'Sales ops', 'copy' => 'Lead capture → qualification → CRM updates → follow-ups and reminders.'],
                        ['icon' => 'lucide:file-text', 'title' => 'Docs & invoices', 'copy' => 'Extract fields, validate data, generate PDFs, and push updates to your system.'],
                        ['icon' => 'lucide:clipboard-check', 'title' => 'Operations', 'copy' => 'Approvals, reminders, task creation, and handoffs that don’t slip.'],
                        ['icon' => 'lucide:shield-alert', 'title' => 'Risk checks', 'copy' => 'Fraud signals, policy checks, and “needs review” routing with audit trails.'],
                        ['icon' => 'lucide:line-chart', 'title' => 'Reporting', 'copy' => 'Dashboards, weekly reports, alerts, and anomaly detection.'],
                    ] as $item)
                        <div class="surface-card premium-card" data-reveal>
                            <div class="premium-icon inline-flex rounded-2xl bg-brand-surface p-5 text-brand-blue">
                                <iconify-icon icon="{{ $item['icon'] }}" class="h-7 w-7 text-brand-blue"></iconify-icon>
                            </div>
                            <h3 class="mt-5 text-2xl font-bold text-brand-blue">{{ $item['title'] }}</h3>
                            <p class="mt-4 text-slate-600">{{ $item['copy'] }}</p>
                        </div>
                    @endforeach
                </div>

                <div class="section-divider mt-14 mb-0"></div>
            </div>
        </section>

        <section class="page-panel py-20 lg:py-24">
            <div class="section-shell">
                <div class="mb-10 max-w-3xl" data-reveal>
                    <div class="section-kicker">AI features</div>
                    <h2 class="mt-4 headline-lg text-brand-blue">More than “a chatbot”. Real AI capabilities.</h2>
                    <p class="mt-4 text-slate-600">We use AI where it improves speed or quality—and keep it safe with guardrails, confidence checks, and approvals.</p>
                </div>

                <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
                    @foreach ([
                        ['icon' => 'lucide:library', 'title' => 'Knowledge base (RAG)', 'copy' => 'Answer from your docs with citations and “I don’t know” fallbacks.'],
                        ['icon' => 'lucide:scan-text', 'title' => 'Document AI', 'copy' => 'OCR, extraction, and validation for invoices, forms, and PDFs.'],
                        ['icon' => 'lucide:route', 'title' => 'Agentic workflows', 'copy' => 'Multi-step tasks with tools, checks, and deterministic rules.'],
                        ['icon' => 'lucide:shield-check', 'title' => 'Guardrails', 'copy' => 'Policies, redaction, approval gates, and safe output formatting.'],
                        ['icon' => 'lucide:languages', 'title' => 'Multilingual support', 'copy' => 'Serve users in multiple languages while keeping brand tone consistent.'],
                        ['icon' => 'lucide:message-square-quote', 'title' => 'Summaries & drafts', 'copy' => 'Summarize calls/tickets, draft replies, and keep human-in-the-loop.'],
                        ['icon' => 'lucide:bell', 'title' => 'Alerts & monitoring', 'copy' => 'Track failures, retry automatically, and notify owners when needed.'],
                        ['icon' => 'lucide:lock', 'title' => 'Access control', 'copy' => 'Role-based actions, data boundaries, and audit logs for compliance.'],
                    ] as $feature)
                        <div class="surface-card premium-card" data-reveal>
                            <div class="premium-icon inline-flex rounded-2xl bg-brand-surface p-5 text-brand-blue">
                                <iconify-icon icon="{{ $feature['icon'] }}" class="h-7 w-7 text-brand-blue"></iconify-icon>
                            </div>
                            <h3 class="mt-5 text-2xl font-bold text-brand-blue">{{ $feature['title'] }}</h3>
                            <p class="mt-4 text-slate-600">{{ $feature['copy'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="section-shell py-20 lg:py-24">
            <div class="grid gap-8 lg:grid-cols-2">
                <div class="glass-card" data-reveal>
                    <div class="section-kicker">Deliverables</div>
                    <h2 class="mt-4 text-3xl font-bold text-white">Automation that’s safe to rely on</h2>
                    <p class="mt-4 text-slate-300">Not just demos—production-ready workflows with monitoring, retries, and clear edge-case behavior.</p>
                    <ul class="mt-6 grid gap-3 sm:grid-cols-2">
                        @foreach ([
                            ['icon' => 'lucide:map', 'label' => 'Workflow mapping + requirements'],
                            ['icon' => 'lucide:plug', 'label' => 'Integrations (APIs, webhooks, tools)'],
                            ['icon' => 'lucide:bot', 'label' => 'AI prompts + guardrails'],
                            ['icon' => 'lucide:shield-check', 'label' => 'Validation + approval gates'],
                            ['icon' => 'lucide:bell', 'label' => 'Alerts, retries, and monitoring'],
                            ['icon' => 'lucide:book-open', 'label' => 'Runbook + handover documentation'],
                        ] as $item)
                            <li class="flex items-start gap-3 rounded-[22px] bg-white/8 px-4 py-3 text-slate-200">
                                <span class="mt-0.5 inline-flex h-9 w-9 items-center justify-center rounded-2xl bg-white/10 text-brand-green">
                                    <iconify-icon icon="{{ $item['icon'] }}" class="h-5 w-5"></iconify-icon>
                                </span>
                                <span class="text-sm font-semibold text-white">{{ $item['label'] }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="glass-card" data-reveal>
                    <div class="section-kicker">Process</div>
                    <h2 class="mt-4 text-3xl font-bold text-white">How we implement automation</h2>
                    <ol class="mt-6 space-y-4">
                        @foreach ([
                            ['icon' => 'lucide:search', 'label' => 'Discovery (systems, pain points, data, owners)'],
                            ['icon' => 'lucide:workflow', 'label' => 'Design (workflow map, states, safeguards, approvals)'],
                            ['icon' => 'lucide:wrench', 'label' => 'Build (integrations, prompts, rules, retries)'],
                            ['icon' => 'lucide:check-circle-2', 'label' => 'Test (edge cases, failure modes, logs)'],
                            ['icon' => 'lucide:monitor', 'label' => 'Deploy + monitor (alerts, dashboards, iteration)'],
                        ] as $step)
                            <li class="flex items-start gap-3 rounded-[24px] bg-white/10 px-5 py-4 text-slate-200">
                                <span class="mt-0.5 inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-white/10 text-brand-green">
                                    <iconify-icon icon="{{ $step['icon'] }}" class="h-5 w-5"></iconify-icon>
                                </span>
                                <span class="text-sm text-slate-200">{{ $step['label'] }}</span>
                            </li>
                        @endforeach
                    </ol>
                </div>
            </div>
        </section>

        <section class="page-panel py-20 lg:py-24">
            <div class="section-shell">
                <div class="mb-10 max-w-3xl" data-reveal>
                    <div class="section-kicker">Tooling</div>
                    <h2 class="mt-4 headline-lg text-brand-blue">Works with your stack.</h2>
                    <p class="mt-4 text-slate-600">We integrate into the tools you already use and keep ownership clear with logs, alerts, and handoff docs.</p>
                </div>

                <div class="grid gap-6 lg:grid-cols-2">
                    <div class="surface-card" data-reveal>
                        <h3 class="text-2xl font-bold text-brand-blue">Compatibility</h3>
                        <div class="mt-5 grid gap-3 sm:grid-cols-2">
                            @foreach ([
                                ['label' => 'Shopify / WooCommerce', 'icon' => 'lucide:shopping-cart'],
                                ['label' => 'CRM (HubSpot, Zoho)', 'icon' => 'lucide:badge-percent'],
                                ['label' => 'Support (Zendesk)', 'icon' => 'lucide:headset'],
                                ['label' => 'Slack / WhatsApp', 'icon' => 'lucide:message-square'],
                                ['label' => 'Google Sheets / Excel', 'icon' => 'lucide:table-2'],
                                ['label' => 'Email (Gmail/SMTP)', 'icon' => 'lucide:mail'],
                                ['label' => 'APIs + Webhooks', 'icon' => 'lucide:plug'],
                                ['label' => 'Databases', 'icon' => 'lucide:database'],
                            ] as $tech)
                                <div class="stack-tile">
                                    <span class="stack-icon"><iconify-icon icon="{{ $tech['icon'] }}"></iconify-icon></span>
                                    <span class="stack-label">{{ $tech['label'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="surface-card" data-reveal>
                        <h3 class="text-2xl font-bold text-brand-blue">Providers & Ops</h3>
                        <div class="mt-5 grid gap-3 sm:grid-cols-2">
                            @foreach ([
                                ['label' => 'OpenAI / Azure OpenAI', 'icon' => 'lucide:sparkles'],
                                ['label' => 'Anthropic / Gemini', 'icon' => 'lucide:brain'],
                                ['label' => 'AWS / Bedrock', 'icon' => 'lucide:cloud'],
                                ['label' => 'Self-hosted options', 'icon' => 'lucide:server'],
                                ['label' => 'Logs & Alerts', 'icon' => 'lucide:bell'],
                                ['label' => 'Rate limits + caching', 'icon' => 'lucide:gauge'],
                                ['label' => 'Prompt guardrails', 'icon' => 'lucide:shield-check'],
                                ['label' => 'Dashboards', 'icon' => 'lucide:layout-dashboard'],
                            ] as $tech)
                                <div class="stack-tile">
                                    <span class="stack-icon"><iconify-icon icon="{{ $tech['icon'] }}"></iconify-icon></span>
                                    <span class="stack-label">{{ $tech['label'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section-shell py-20 lg:py-24">
            <div class="grid gap-10 lg:grid-cols-2 lg:items-start">
                <div data-reveal>
                    <div class="section-kicker">FAQ</div>
                    <h2 class="mt-4 text-3xl font-bold text-white">AI automation questions</h2>
                    <p class="mt-4 text-slate-300">Safety, reliability, and what “automation-ready” means.</p>
                </div>
                <div class="space-y-3" data-reveal x-data="{ open: 0 }">
                    @foreach ([
                        ['q' => 'Will AI make mistakes?', 'a' => 'It can—so we add guardrails: validation rules, confidence checks, and approval gates where needed. The goal is reliable outcomes, not risky autopilot.'],
                        ['q' => 'Can you automate with our existing tools?', 'a' => 'Yes. We prefer integrating into what you already use (CRM, email, support, spreadsheets, dashboards) via APIs and webhooks.'],
                        ['q' => 'What happens when something fails?', 'a' => 'We build retries, dead-letter paths, alerting, and clear logs so failures are visible and recoverable instead of silent.'],
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
    @else
    <section class="dark-band">
        <div class="section-shell section-spacious">
            <div class="grid gap-10 lg:grid-cols-[1fr_0.9fr] lg:items-center">
                <div data-reveal>
                    <div class="section-kicker">{{ $service['title'] }}</div>
                    <h1 class="mt-5 headline-lg">{{ $service['title'] }}</h1>
                    <p class="mt-5 body-lg">{{ $service['tagline'] }}</p>
                    <div class="mt-8 flex flex-wrap gap-4">
                        <a href="{{ route('website.contact') }}" class="btn-primary" x-on:click.prevent="$store.marketingPopup.openLead({ title: @js('Discuss '.$service['title']), source: 'service_detail_cta', context: @js($service['title'].' inquiry'), submitLabel: 'Discuss Service' })">Discuss This Service</a>
                        <a href="{{ route('website.services') }}" class="btn-secondary">All Services</a>
                    </div>
                </div>
                <div class="glass-card" data-reveal>
                    <img src="{{ $mediaAssetUrl($service['image']) }}" alt="{{ $service['title'] }}" class="h-[420px] w-full rounded-[24px] object-cover">
                </div>
            </div>
        </div>
    </section>

    <section class="page-panel py-20 lg:py-24">
        <div class="section-shell grid gap-6 md:grid-cols-3">
            @foreach($service['benefits'] as $benefit)
                <div class="surface-card premium-card" data-reveal>
                    <div class="premium-icon inline-flex rounded-2xl bg-brand-surface p-4 text-brand-blue">
                        @include('website.partials.icon', ['name' => $service['icon'], 'class' => 'h-6 w-6'])
                    </div>
                    <h2 class="mt-5 text-2xl font-bold text-brand-blue">{{ $benefit }}</h2>
                    <p class="mt-4 text-slate-600">This engagement is designed to improve product quality, delivery confidence, and long-term maintainability.</p>
                </div>
            @endforeach
        </div>
    </section>

    <section class="section-shell py-20 lg:py-24">
        <div class="grid gap-8 lg:grid-cols-2">
            <div class="glass-card" data-reveal>
                <div class="section-kicker">Technology Stack</div>
                <h2 class="mt-4 text-3xl font-bold text-white">Selected tools and technologies</h2>
                <div class="mt-6 flex flex-wrap gap-3">
                    @foreach($service['technologies'] as $technology)
                        <span class="badge-chip">{{ $technology }}</span>
                    @endforeach
                </div>
                <div class="mt-8">
                    <div class="text-sm font-semibold uppercase tracking-[0.22em] text-brand-green">What is included</div>
                    <div class="mt-4 grid gap-3 sm:grid-cols-2">
                        @foreach($service['deliverables'] as $deliverable)
                            <div class="rounded-[20px] bg-white/8 px-4 py-3 text-sm text-slate-200">{{ $deliverable }}</div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="glass-card" data-reveal>
                <div class="section-kicker">Development Process</div>
                <h2 class="mt-4 text-3xl font-bold text-white">How we deliver</h2>
                <ol class="mt-6 space-y-4">
                    @foreach($service['process'] as $step)
                        <li class="rounded-[24px] bg-white/10 px-5 py-4 text-slate-200">{{ $step }}</li>
                    @endforeach
                </ol>
                <div class="mt-8 rounded-[24px] border border-white/10 bg-white/5 p-5 text-slate-300">
                    <div class="text-sm font-semibold uppercase tracking-[0.22em] text-brand-green">Example outcome</div>
                    <p class="mt-3">{{ $service['case_study'] }}</p>
                </div>
            </div>
        </div>
    </section>

    <section class="page-panel py-20 lg:py-24">
        <div class="section-shell">
            <div class="mb-12 max-w-3xl" data-reveal>
                <div class="section-kicker">Related Project Angles</div>
                <h2 class="mt-4 headline-lg text-brand-blue">Relevant examples and outcomes.</h2>
            </div>
            <div class="grid gap-6 lg:grid-cols-2">
                @foreach($projects as $project)
                    @include('website.partials.project-card', ['project' => $project, 'light' => true])
                @endforeach
            </div>
        </div>
    </section>

    @include('website.partials.cta-banner')
    @endif
@endsection
