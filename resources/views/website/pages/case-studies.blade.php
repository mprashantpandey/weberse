@extends('layouts.website', [
    'title' => 'Case Studies | Weberse Infotech',
    'description' => 'Read Weberse case studies showing how better digital clarity improves trust, conversions, and operational workflows.',
])

@section('content')
    <section class="dark-band">
        <div class="section-shell section-spacious">
            <div class="grid gap-10 lg:grid-cols-[0.95fr_1.05fr] lg:items-end">
                <div class="max-w-3xl" data-reveal>
                    <div class="section-kicker">Case Studies</div>
                    <h1 class="mt-5 headline-lg">Proof behind the polish.</h1>
                    <p class="mt-5 max-w-2xl body-lg">Short stories showing how Weberse improves clarity, trust, and operational structure across digital products.</p>
                </div>
                <div class="grid gap-4 sm:grid-cols-3" data-reveal>
                    <div class="glass-card premium-card text-center">
                        <div class="text-3xl font-bold text-white">{{ $caseStudies->count() }}+</div>
                        <div class="mt-2 text-xs uppercase tracking-[0.22em] text-slate-300">Published Stories</div>
                    </div>
                    <div class="glass-card premium-card text-center">
                        <div class="text-3xl font-bold text-white">{{ $caseStudies->pluck('industry')->unique()->count() }}</div>
                        <div class="mt-2 text-xs uppercase tracking-[0.22em] text-slate-300">Industries</div>
                    </div>
                    <div class="glass-card premium-card text-center">
                        <div class="text-3xl font-bold text-white">{{ $caseStudies->flatMap(fn ($study) => $study->services ?? [])->unique()->count() }}</div>
                        <div class="mt-2 text-xs uppercase tracking-[0.22em] text-slate-300">Capability Areas</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="page-panel py-16 lg:py-20">
        <div class="section-shell">
            <div class="grid gap-8 lg:grid-cols-2">
                @foreach($caseStudies as $caseStudy)
                    <article class="surface-card premium-card overflow-hidden" data-reveal>
                        <div class="relative overflow-hidden rounded-[24px]">
                            <img src="{{ $mediaAssetUrl($caseStudy->featured_image, 'assets/images/map-placeholder.svg') }}" alt="{{ $caseStudy->title }}" class="h-72 w-full rounded-[24px] object-cover transition duration-700 hover:scale-[1.03]">
                            <div class="absolute inset-x-0 top-0 flex items-center justify-between p-5">
                                <span class="rounded-full bg-brand-dark/80 px-4 py-2 text-[0.65rem] font-semibold uppercase tracking-[0.22em] text-white backdrop-blur-md">{{ $caseStudy->industry }}</span>
                                <span class="rounded-full bg-white/85 px-4 py-2 text-[0.65rem] font-semibold uppercase tracking-[0.2em] text-brand-blue shadow-[0_10px_24px_rgba(13,47,80,0.12)]">{{ $caseStudy->duration }}</span>
                            </div>
                        </div>

                        <div class="mt-6 flex items-center justify-between gap-4">
                            <div>
                                <div class="text-sm font-semibold text-brand-green">{{ $caseStudy->client }}</div>
                                <div class="mt-1 text-sm text-slate-500">{{ $caseStudy->engagement }}</div>
                            </div>
                            <a href="{{ route('website.case-studies.show', $caseStudy->slug) }}" class="inline-flex h-11 w-11 items-center justify-center rounded-full border border-brand-blue/10 bg-white text-brand-blue transition duration-300 hover:-translate-y-0.5 hover:border-brand-green/40 hover:text-brand-green">
                                @include('website.partials.icon', ['name' => 'arrow-up-right', 'class' => 'h-5 w-5'])
                            </a>
                        </div>

                        <h2 class="mt-5 text-3xl font-bold text-brand-blue">{{ $caseStudy->title }}</h2>
                        <p class="mt-4 text-slate-600">{{ $caseStudy->summary }}</p>

                        <div class="mt-6 grid gap-3 sm:grid-cols-3">
                            @foreach(($caseStudy->metrics ?? []) as $metric)
                                <div class="rounded-2xl border border-brand-blue/8 bg-white px-4 py-4 text-sm font-medium text-slate-700 shadow-[0_10px_24px_rgba(13,47,80,0.05)]">
                                    {{ $metric }}
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6 flex flex-wrap gap-2">
                            @foreach(($caseStudy->services ?? []) as $service)
                                <span class="surface-badge">{{ $service }}</span>
                            @endforeach
                        </div>

                        <div class="mt-6 flex items-center justify-between gap-4 border-t border-slate-200 pt-5">
                            <div class="max-w-md text-sm text-slate-500">{{ $caseStudy->outcome }}</div>
                            <a href="{{ route('website.case-studies.show', $caseStudy->slug) }}" class="inline-flex items-center gap-2 text-sm font-semibold text-brand-blue">Read Case Study @include('website.partials.icon', ['name' => 'arrow', 'class' => 'h-4 w-4'])</a>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="dark-band">
        <div class="section-shell py-16 lg:py-20">
            <div class="grid gap-6 lg:grid-cols-3">
                @foreach([
                    ['title' => 'Clear challenge framing', 'copy' => 'Each story starts with the real commercial or operational problem, not just a design surface.', 'icon' => 'target'],
                    ['title' => 'Execution detail', 'copy' => 'We show the systems, pages, and workflows that were actually changed across the engagement.', 'icon' => 'workflow'],
                    ['title' => 'Measured outcomes', 'copy' => 'Every case study ends with the trust, clarity, or operational gains that mattered most.', 'icon' => 'chart'],
                ] as $item)
                    <div class="glass-card premium-card" data-reveal>
                        <div class="premium-icon inline-flex rounded-2xl bg-white/10 p-4 text-brand-green">
                            @include('website.partials.icon', ['name' => $item['icon'], 'class' => 'h-5 w-5'])
                        </div>
                        <h2 class="mt-5 text-2xl font-bold text-white">{{ $item['title'] }}</h2>
                        <p class="mt-4 text-slate-300">{{ $item['copy'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    @include('website.partials.cta-banner')
@endsection
