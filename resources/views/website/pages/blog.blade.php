@extends('layouts.website', [
    'title' => 'Blog | Weberse Infotech',
    'description' => 'Insights from Weberse on websites, client portals, growth systems, automation, UX, and practical digital execution.',
])

@section('content')
    <section class="dark-band relative overflow-hidden">
        <div class="section-shell section-spacious relative pt-12 lg:pt-16">
            <div class="grid gap-10 lg:grid-cols-[1.05fr_0.95fr] lg:items-center">
                <div class="max-w-3xl" data-reveal>
                    <div class="section-kicker">Blog</div>
                    <h1 class="mt-5 headline-lg">Notes on products and systems.</h1>
                    <p class="mt-5 body-lg text-slate-300">Short practical insights from the work we build and ship.</p>
                    <div class="mt-7 flex flex-wrap gap-4">
                        <a href="{{ route('website.contact') }}" class="btn-primary"
                           x-on:click.prevent="$store.marketingPopup.openLead({ title: 'Blog inquiry', source: 'blog_cta', context: 'Blog consultation request', submitLabel: 'Discuss Project' })">
                            @include('website.partials.icon', ['name' => 'calendar', 'class' => 'h-4 w-4'])
                            Discuss a project
                        </a>
                        <a href="{{ route('website.services') }}" class="btn-secondary">
                            @include('website.partials.icon', ['name' => 'layers', 'class' => 'h-4 w-4'])
                            View services
                        </a>
                    </div>
                </div>

                <div class="hero-media-stage" data-reveal>
                    <img src="{{ $mediaAssetUrl($websiteImages['blog']['hero_cover'] ?? null, 'assets/images/blog-cover.svg') }}" alt="Blog cover" class="hero-media-image">
                </div>
            </div>

            <div class="mt-10 grid gap-4 sm:grid-cols-3">
                @foreach ([
                    ['icon' => 'globe', 'label' => 'Web Strategy'],
                    ['icon' => 'cpu', 'label' => 'Systems & Delivery'],
                    ['icon' => 'sparkles', 'label' => 'Automation & AI'],
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

    <section class="page-panel py-20 lg:py-24" x-data="{ query: '' }">
        <div class="section-shell">
            <div class="mb-10 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between" data-reveal>
                <div class="max-w-3xl">
                    <div class="section-kicker">Latest posts</div>
                    <h2 class="mt-4 headline-lg text-brand-blue">Browse and search articles.</h2>
                </div>

                <div class="relative w-full max-w-md">
                    <div class="pointer-events-none absolute inset-y-0 left-4 flex items-center text-slate-400">
                        @include('website.partials.icon', ['name' => 'search', 'class' => 'h-4 w-4'])
                    </div>
                    <input type="text"
                           x-model="query"
                           placeholder="Search posts on this page…"
                           class="w-full rounded-2xl border border-slate-200 bg-white px-11 py-3 text-sm text-slate-800 shadow-sm outline-none focus:border-brand-blue/40 focus:ring-2 focus:ring-brand-blue/10">
                </div>
            </div>

            <div class="grid gap-6 lg:grid-cols-3">
                @foreach ($posts as $post)
                    @php
                        $img = $post->cover_image
                            ? $mediaAssetUrl($post->cover_image)
                            : $mediaAssetUrl($websiteImages['blog']['post_fallback_cover'] ?? null, 'assets/images/blog-cover.svg');
                        $haystack = strtolower(trim(($post->title ?? '').' '.($post->excerpt ?? '')));
                    @endphp
                    <article class="surface-card premium-card" data-reveal x-data="{ haystack: @js($haystack) }"
                             x-show="!query || haystack.includes(query.toLowerCase())">
                        <a href="{{ route('website.blog.show', $post->slug) }}" class="block">
                            <img src="{{ $img }}" alt="{{ $post->title }}" class="h-56 w-full rounded-[24px] object-cover">
                            <div class="mt-5 flex items-center justify-between gap-3">
                                <div class="text-sm font-semibold uppercase tracking-[0.22em] text-brand-green">{{ optional($post->published_at)->format('d M Y') }}</div>
                                <span class="btn-dark !px-4 !py-2 text-xs">Read</span>
                            </div>
                            <h2 class="mt-3 text-2xl font-bold text-brand-blue">{{ $post->title }}</h2>
                            <p class="mt-3 text-slate-600">{{ $post->excerpt }}</p>
                        </a>
                    </article>
                @endforeach
            </div>

            <div class="mt-10">{{ $posts->links() }}</div>
        </div>
    </section>

    @include('website.partials.cta-banner')
@endsection
