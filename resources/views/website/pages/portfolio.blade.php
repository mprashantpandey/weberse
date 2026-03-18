@extends('layouts.website', [
    'title' => 'Portfolio | Weberse Infotech',
    'description' => 'See recent Weberse portfolio projects across websites, internal systems, hosting journeys, client portals, and branded product experiences.',
    'seoImage' => $mediaAssetUrl($websiteImages['portfolio']['hero_showcase'] ?? null, 'assets/images/project-dashboard.svg'),
])

@section('content')
    <section class="dark-band relative overflow-hidden">
        <div class="section-shell section-spacious relative pt-12 lg:pt-16">
            <div class="grid gap-10 lg:grid-cols-[1.05fr_0.95fr] lg:items-center">
                <div class="max-w-3xl" data-reveal>
                    <div class="section-kicker">Portfolio</div>
                    <h1 class="mt-5 headline-lg">Work that ships, scales, and stays maintainable.</h1>
                    <p class="mt-5 body-lg text-slate-300">Web platforms, mobile products, automation layers, and custom internal systems—built with delivery discipline.</p>
                    <div class="mt-7 flex flex-wrap gap-4">
                        <a href="{{ route('website.contact') }}" class="btn-primary"
                           x-on:click.prevent="$store.marketingPopup.openLead({ title: 'Portfolio Inquiry', source: 'portfolio_cta', context: 'Portfolio inquiry', submitLabel: 'Discuss a Project' })">
                            @include('website.partials.icon', ['name' => 'calendar', 'class' => 'h-4 w-4'])
                            Discuss a Project
                        </a>
                        <a href="{{ route('website.services') }}" class="btn-secondary">
                            @include('website.partials.icon', ['name' => 'layers', 'class' => 'h-4 w-4'])
                            View Services
                        </a>
                    </div>
                </div>
                <div class="hero-media-stage" data-reveal>
                    <img src="{{ $mediaAssetUrl($websiteImages['portfolio']['hero_showcase'] ?? null, 'assets/images/project-dashboard.svg') }}" alt="Portfolio showcase" class="hero-media-image">
                </div>
            </div>

            <div class="mt-10 grid gap-4 sm:grid-cols-3">
                @foreach ([
                    ['icon' => 'briefcase', 'label' => 'Operational Platforms', 'meta' => 'Dashboards, roles, workflows'],
                    ['icon' => 'server', 'label' => 'Hosting Journeys', 'meta' => 'WHMCS + branded funnels'],
                    ['icon' => 'smartphone', 'label' => 'Mobile Experiences', 'meta' => 'Apps with disciplined UX'],
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

    <section class="page-panel py-20 lg:py-24" x-data="{
        tab: 'featured',
        featuredCategory: 'All',
        industry: 'All',
        query: '',
    }">
        <div class="section-shell">
            <div class="mb-10 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between" data-reveal>
                <div class="max-w-3xl">
                    <div class="section-kicker">Projects</div>
                    <h2 class="mt-4 headline-lg text-brand-blue">Browse featured work and client projects.</h2>
                </div>
                <div class="flex flex-wrap items-center gap-3">
                    <button type="button"
                            class="rounded-2xl border px-4 py-2 text-sm font-semibold transition"
                            :class="tab === 'featured' ? 'border-brand-blue bg-brand-blue text-white' : 'border-slate-200 bg-white text-brand-blue'"
                            @click="tab = 'featured'">
                        Featured
                    </button>
                    <button type="button"
                            class="rounded-2xl border px-4 py-2 text-sm font-semibold transition"
                            :class="tab === 'client' ? 'border-brand-blue bg-brand-blue text-white' : 'border-slate-200 bg-white text-brand-blue'"
                            @click="tab = 'client'">
                        Client Projects
                    </button>
                </div>
            </div>

            <div class="rounded-[28px] border border-slate-200 bg-white/80 p-5 shadow-[0_16px_44px_rgba(13,47,80,0.08)] backdrop-blur-md" data-reveal>
                <div class="grid gap-4 lg:grid-cols-[1fr_auto] lg:items-center">
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-4 flex items-center text-slate-400">
                            @include('website.partials.icon', ['name' => 'search', 'class' => 'h-4 w-4'])
                        </div>
                        <input type="text"
                               x-model="query"
                               placeholder="Search by title, client, or industry…"
                               class="w-full rounded-2xl border border-slate-200 bg-white px-11 py-3 text-sm text-slate-800 shadow-sm outline-none focus:border-brand-blue/40 focus:ring-2 focus:ring-brand-blue/10">
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <template x-if="tab === 'featured'">
                            <div class="flex flex-wrap gap-2">
                                <button type="button"
                                        class="rounded-full border px-4 py-2 text-xs font-semibold transition"
                                        :class="featuredCategory === 'All' ? 'border-brand-green/40 bg-brand-green/10 text-brand-blue' : 'border-slate-200 bg-white text-slate-700'"
                                        @click="featuredCategory = 'All'">
                                    All categories
                                </button>
                                @foreach(collect($featuredProjects)->pluck('category')->filter()->unique()->values() as $cat)
                                    <button type="button"
                                            class="rounded-full border px-4 py-2 text-xs font-semibold transition"
                                            :class="featuredCategory === @js($cat) ? 'border-brand-green/40 bg-brand-green/10 text-brand-blue' : 'border-slate-200 bg-white text-slate-700'"
                                            @click="featuredCategory = @js($cat)">
                                        {{ $cat }}
                                    </button>
                                @endforeach
                            </div>
                        </template>

                        <template x-if="tab === 'client'">
                            <div class="flex flex-wrap gap-2">
                                <button type="button"
                                        class="rounded-full border px-4 py-2 text-xs font-semibold transition"
                                        :class="industry === 'All' ? 'border-brand-green/40 bg-brand-green/10 text-brand-blue' : 'border-slate-200 bg-white text-slate-700'"
                                        @click="industry = 'All'">
                                    All industries
                                </button>
                                @foreach(collect($projects)->pluck('industry')->filter()->unique()->values() as $ind)
                                    <button type="button"
                                            class="rounded-full border px-4 py-2 text-xs font-semibold transition"
                                            :class="industry === @js($ind) ? 'border-brand-green/40 bg-brand-green/10 text-brand-blue' : 'border-slate-200 bg-white text-slate-700'"
                                            @click="industry = @js($ind)">
                                        {{ $ind }}
                                    </button>
                                @endforeach
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <div class="mt-10" x-show="tab === 'featured'" x-cloak>
                <div class="grid gap-6 lg:grid-cols-3">
                    @foreach ($featuredProjects as $project)
                        @php
                            $featureHaystack = strtolower(trim(($project['title'] ?? '').' '.($project['category'] ?? '').' '.($project['description'] ?? '').' '.implode(' ', $project['stack'] ?? [])));
                        @endphp
                        <div x-data="{ haystack: @js($featureHaystack) }"
                             x-show="(featuredCategory === 'All' || @js($project['category'] ?? '') === featuredCategory) && (!query || haystack.includes(query.toLowerCase()))">
                            @include('website.partials.project-card', ['project' => $project, 'light' => true])
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="mt-10" x-show="tab === 'client'" x-cloak>
                @if($projects->count() === 0)
                    <div class="surface-card" data-reveal>
                        <div class="section-kicker">No projects yet</div>
                        <h3 class="mt-4 text-2xl font-bold text-brand-blue">Your portfolio items will appear here.</h3>
                        <p class="mt-3 text-slate-600">Once you publish portfolio projects from the admin panel, they’ll show up in this section.</p>
                    </div>
                @else
                    <div class="grid gap-6 lg:grid-cols-3">
                        @foreach ($projects as $project)
                            @php
                                $img = $project->featured_image
                                    ? $mediaAssetUrl($project->featured_image)
                                    : $mediaAssetUrl($websiteImages['portfolio']['fallback_placeholder'] ?? null, 'assets/images/map-placeholder.svg');
                                $clientHaystack = strtolower(trim(($project->title ?? '').' '.($project->client_name ?? '').' '.($project->industry ?? '').' '.($project->summary ?? '')));
                            @endphp
                            <article class="surface-card premium-card" data-reveal x-data="{ haystack: @js($clientHaystack) }"
                                     x-show="(industry === 'All' || @js($project->industry ?? '') === industry) && (!query || haystack.includes(query.toLowerCase()))">
                                <img src="{{ $img }}" alt="{{ $project->title }}" class="h-52 w-full rounded-[24px] object-cover">
                                <div class="mt-5 flex items-center justify-between gap-3">
                                    <div class="text-sm font-semibold uppercase tracking-[0.22em] text-brand-green">{{ $project->industry ?? 'Project' }}</div>
                                    @if($project->project_url)
                                        <a href="{{ $project->project_url }}" target="_blank" rel="noopener noreferrer" class="btn-dark !px-4 !py-2">Visit</a>
                                    @endif
                                </div>
                                <h3 class="mt-3 text-2xl font-bold text-brand-blue">{{ $project->title }}</h3>
                                @if($project->client_name)
                                    <div class="mt-2 text-sm font-semibold text-slate-600">{{ $project->client_name }}</div>
                                @endif
                                <p class="mt-3 text-slate-600">{{ $project->summary }}</p>
                            </article>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </section>
    @include('website.partials.cta-banner')
@endsection
