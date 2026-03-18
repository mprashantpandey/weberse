@extends('layouts.website', ['title' => 'Services | Weberse Infotech'])

@section('content')
    <section class="dark-band">
        <div class="section-shell section-spacious">
            <div class="grid gap-10 lg:grid-cols-[0.95fr_1.05fr] lg:items-center">
                <div class="max-w-4xl" data-reveal>
                    <div class="section-kicker">Services</div>
                    <h1 class="mt-5 headline-lg">Services built for digital growth.</h1>
                    <p class="mt-5 body-lg">Clear delivery across websites, systems, design, and automation.</p>
                </div>
                <div class="hero-media-stage" data-reveal>
                    <img src="{{ $mediaAssetUrl($websiteImages['services']['overview_hero'] ?? null, 'assets/legacy/web-development.png') }}" alt="Weberse services overview" class="hero-media-image">
                </div>
            </div>
            <div class="mt-10 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ([
                    ['icon' => 'globe', 'label' => 'Web Platforms'],
                    ['icon' => 'smartphone', 'label' => 'Mobile Products'],
                    ['icon' => 'sparkles', 'label' => 'AI Workflows'],
                    ['icon' => 'cpu', 'label' => 'Custom Systems'],
                ] as $item)
                    <div class="glass-card premium-card flex items-center gap-4 p-5" data-reveal>
                        <div class="premium-icon inline-flex rounded-2xl bg-white/10 p-3 text-brand-green">
                            @include('website.partials.icon', ['name' => $item['icon'], 'class' => 'h-5 w-5'])
                        </div>
                        <div class="text-sm font-semibold text-white">{{ $item['label'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <section class="page-panel py-20 lg:py-24">
        <div class="section-shell">
            <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                @foreach ($serviceDetails as $service)
                    @include('website.partials.service-card', ['service' => $service, 'light' => true])
                @endforeach
            </div>
        </div>
    </section>
    @include('website.partials.cta-banner')
@endsection
