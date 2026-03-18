@extends('layouts.website', ['title' => $project->title.' | Project Details'])

@section('content')
    <section class="dark-band">
        <div class="section-shell section-spacious">
            <div class="grid gap-10 lg:grid-cols-[1fr_0.95fr] lg:items-center">
                <div data-reveal>
                    <div class="section-kicker">{{ $project->category ?: ($project->industry ?: 'Project') }}</div>
                    <h1 class="mt-5 headline-lg">{{ $project->title }}</h1>
                    <p class="mt-5 body-lg">{{ $project->summary ?: (($project->category ?: 'Project').' with a clear product and system focus.') }}</p>
                    <div class="mt-6 flex flex-wrap gap-3">
                        @foreach(($project->stack ?? []) as $item)
                            <span class="badge-chip">{{ $item }}</span>
                        @endforeach
                    </div>
                    <div class="mt-8 grid gap-3 sm:grid-cols-3">
                        @foreach(($project->metrics ?? []) as $metric)
                            <div class="glass-card p-4 text-sm font-semibold text-white">{{ $metric }}</div>
                        @endforeach
                    </div>
                </div>
                <div class="glass-card" data-reveal>
                    <img src="{{ $mediaAssetUrl($project->featured_image, 'assets/images/map-placeholder.svg') }}" alt="{{ $project->title }}" class="w-full rounded-[24px] object-cover">
                </div>
            </div>
        </div>
    </section>

    <section class="page-panel py-20 lg:py-24">
        <div class="section-shell grid gap-6 md:grid-cols-3">
            @foreach([
                ['title' => 'Challenge', 'copy' => $project->challenge, 'icon' => 'chart'],
                ['title' => 'Solution', 'copy' => $project->solution, 'icon' => 'layers'],
                ['title' => 'Outcome', 'copy' => $project->outcome, 'icon' => 'sparkles'],
            ] as $column)
                <div class="surface-card premium-card" data-reveal>
                    <div class="premium-icon inline-flex rounded-2xl bg-brand-surface p-4 text-brand-blue">
                        @include('website.partials.icon', ['name' => $column['icon'], 'class' => 'h-6 w-6'])
                    </div>
                    <h2 class="mt-5 text-2xl font-bold text-brand-blue">{{ $column['title'] }}</h2>
                    <p class="mt-4 text-slate-600">{{ $column['copy'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    @include('website.partials.cta-banner')
@endsection
