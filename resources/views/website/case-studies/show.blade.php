@extends('layouts.website', [
    'title' => $caseStudy->title.' | Case Study',
    'description' => $caseStudy->summary,
    'seoImage' => $caseStudy->featured_image ? $mediaAssetUrl($caseStudy->featured_image) : $mediaAssetUrl($websiteImages['case_studies']['hero_story'] ?? null, 'assets/images/case-study-og.jpg'),
])

@section('content')
    <section class="dark-band">
        <div class="section-shell section-spacious">
            <div class="grid gap-10 lg:grid-cols-[0.95fr_1.05fr] lg:items-center">
                <div class="max-w-3xl" data-reveal>
                    <div class="section-kicker">Case Study</div>
                    <h1 class="mt-5 headline-lg">{{ $caseStudy->title }}</h1>
                    <p class="mt-5 max-w-2xl body-lg">{{ $caseStudy->summary }}</p>

                    <div class="mt-7 grid gap-3 sm:grid-cols-3">
                        @foreach([
                            ['label' => 'Client', 'value' => $caseStudy->client],
                            ['label' => 'Industry', 'value' => $caseStudy->industry],
                            ['label' => 'Duration', 'value' => $caseStudy->duration],
                        ] as $meta)
                            <div class="glass-card premium-card p-4">
                                <div class="text-[0.65rem] uppercase tracking-[0.2em] text-brand-green">{{ $meta['label'] }}</div>
                                <div class="mt-2 text-sm font-semibold text-white">{{ $meta['value'] }}</div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-6 flex flex-wrap gap-2">
                        @foreach(($caseStudy->services ?? []) as $service)
                            <span class="badge-chip">{{ $service }}</span>
                        @endforeach
                    </div>
                </div>

                <div class="glass-card overflow-hidden" data-reveal>
                    <img src="{{ $mediaAssetUrl($caseStudy->featured_image, 'assets/images/map-placeholder.svg') }}" alt="{{ $caseStudy->title }}" class="h-[420px] w-full rounded-[24px] object-cover">
                </div>
            </div>
        </div>
    </section>

    <section class="page-panel py-16 lg:py-20">
        <div class="section-shell grid gap-8 lg:grid-cols-[1.15fr_0.85fr]">
            <div class="space-y-6">
                <div class="surface-card premium-card" data-reveal>
                    <div class="premium-icon inline-flex rounded-2xl bg-brand-surface p-4 text-brand-blue">
                        @include('website.partials.icon', ['name' => 'target', 'class' => 'h-5 w-5'])
                    </div>
                    <div class="mt-5 section-kicker">The Challenge</div>
                    <h2 class="mt-4 text-3xl font-bold text-brand-blue">What needed to change</h2>
                    <p class="mt-4 text-slate-600">{{ $caseStudy->challenge }}</p>
                </div>

                <div class="surface-card premium-card" data-reveal>
                    <div class="premium-icon inline-flex rounded-2xl bg-brand-surface p-4 text-brand-blue">
                        @include('website.partials.icon', ['name' => 'workflow', 'class' => 'h-5 w-5'])
                    </div>
                    <div class="mt-5 section-kicker">The Solution</div>
                    <h2 class="mt-4 text-3xl font-bold text-brand-blue">How we structured the work</h2>
                    <p class="mt-4 text-slate-600">{{ $caseStudy->solution }}</p>

                    @if(!empty($caseStudy->stack))
                        <div class="mt-6 flex flex-wrap gap-2">
                            @foreach($caseStudy->stack as $item)
                                <span class="surface-badge">{{ $item }}</span>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="surface-card premium-card" data-reveal>
                    <div class="premium-icon inline-flex rounded-2xl bg-brand-surface p-4 text-brand-blue">
                        @include('website.partials.icon', ['name' => 'check', 'class' => 'h-5 w-5'])
                    </div>
                    <div class="mt-5 section-kicker">The Outcome</div>
                    <h2 class="mt-4 text-3xl font-bold text-brand-blue">What improved after launch</h2>
                    <p class="mt-4 text-slate-600">{{ $caseStudy->outcome }}</p>

                    <ul class="mt-6 grid gap-3">
                        @foreach(($caseStudy->results ?? []) as $result)
                            <li class="flex items-start gap-3 rounded-2xl border border-brand-blue/8 bg-white px-4 py-4 text-slate-700 shadow-[0_8px_20px_rgba(13,47,80,0.05)]">
                                <span class="mt-0.5 inline-flex h-6 w-6 items-center justify-center rounded-full bg-brand-green/10 text-brand-green">
                                    @include('website.partials.icon', ['name' => 'check', 'class' => 'h-4 w-4'])
                                </span>
                                <span>{{ $result }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="space-y-6">
                <div class="surface-card premium-card" data-reveal>
                    <div class="section-kicker">Engagement Snapshot</div>
                    <h2 class="mt-4 text-2xl font-bold text-brand-blue">{{ $caseStudy->engagement }}</h2>
                    <div class="mt-6 space-y-4">
                        <div class="flex items-center justify-between gap-4 rounded-2xl bg-brand-surface px-4 py-4">
                            <div class="flex items-center gap-3">
                                <span class="inline-flex h-11 w-11 items-center justify-center rounded-2xl bg-white text-brand-blue shadow-[0_8px_18px_rgba(13,47,80,0.08)]">
                                    @include('website.partials.icon', ['name' => 'briefcase', 'class' => 'h-5 w-5'])
                                </span>
                                <div>
                                    <div class="text-xs uppercase tracking-[0.18em] text-slate-500">Client</div>
                                    <div class="mt-1 font-semibold text-brand-blue">{{ $caseStudy->client }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center justify-between gap-4 rounded-2xl bg-brand-surface px-4 py-4">
                            <div class="flex items-center gap-3">
                                <span class="inline-flex h-11 w-11 items-center justify-center rounded-2xl bg-white text-brand-blue shadow-[0_8px_18px_rgba(13,47,80,0.08)]">
                                    @include('website.partials.icon', ['name' => 'clock', 'class' => 'h-5 w-5'])
                                </span>
                                <div>
                                    <div class="text-xs uppercase tracking-[0.18em] text-slate-500">Delivery Window</div>
                                    <div class="mt-1 font-semibold text-brand-blue">{{ $caseStudy->duration }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center justify-between gap-4 rounded-2xl bg-brand-surface px-4 py-4">
                            <div class="flex items-center gap-3">
                                <span class="inline-flex h-11 w-11 items-center justify-center rounded-2xl bg-white text-brand-blue shadow-[0_8px_18px_rgba(13,47,80,0.08)]">
                                    @include('website.partials.icon', ['name' => 'layers', 'class' => 'h-5 w-5'])
                                </span>
                                <div>
                                    <div class="text-xs uppercase tracking-[0.18em] text-slate-500">Capability Areas</div>
                                    <div class="mt-1 font-semibold text-brand-blue">{{ count($caseStudy->services ?? []) }} integrated tracks</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="surface-card premium-card" data-reveal>
                    <div class="section-kicker">Impact Highlights</div>
                    <div class="mt-5 grid gap-3">
                        @foreach(($caseStudy->metrics ?? []) as $metric)
                            <div class="rounded-2xl border border-brand-green/12 bg-[linear-gradient(180deg,rgba(255,255,255,0.98),rgba(245,248,251,1))] px-4 py-4 text-sm font-semibold text-brand-blue shadow-[0_10px_24px_rgba(115,182,85,0.06)]">
                                {{ $metric }}
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="surface-card premium-card" data-reveal>
                    <div class="premium-icon inline-flex rounded-2xl bg-brand-surface p-4 text-brand-blue">
                        @include('website.partials.icon', ['name' => 'quote', 'class' => 'h-5 w-5'])
                    </div>
                    <blockquote class="mt-5 text-xl font-semibold leading-9 text-brand-blue">“{{ $caseStudy->quote }}”</blockquote>
                    <div class="mt-5 text-sm uppercase tracking-[0.18em] text-slate-500">{{ $caseStudy->quote_author }}</div>
                </div>
            </div>
        </div>
    </section>

    <section class="page-panel py-16 lg:py-20">
        <div class="section-shell">
            <div class="mb-10" data-reveal>
                <div class="section-kicker">Related Work</div>
                <h2 class="mt-4 headline-lg text-brand-blue">Projects with a similar transformation angle.</h2>
            </div>
            <div class="grid gap-6 lg:grid-cols-2">
                @foreach($projects as $project)
                    @include('website.partials.project-card', ['project' => $project, 'light' => true])
                @endforeach
            </div>
        </div>
    </section>

    @include('website.partials.cta-banner')
@endsection
