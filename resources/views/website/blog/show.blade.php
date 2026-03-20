@extends('layouts.website', [
    'title' => ($post->seo_title ?: $post->title).' | Weberse Blog',
    'description' => $post->seo_description ?: $post->excerpt,
    'seoType' => 'article',
    'seoImage' => $post->cover_image ? $mediaAssetUrl($post->cover_image) : $mediaAssetUrl($websiteImages['blog']['post_fallback_cover'] ?? null, 'assets/images/blog-og.jpg'),
    'publishedTime' => optional($post->published_at)->toAtomString(),
    'modifiedTime' => optional($post->updated_at)->toAtomString(),
])

@section('content')
    <section class="dark-band relative overflow-hidden">
        <div class="section-shell section-spacious relative pt-12 lg:pt-16">
            <div class="grid gap-10 lg:grid-cols-[1.05fr_0.95fr] lg:items-center">
                <div data-reveal>
                    <div class="section-kicker">Blog</div>
                    <h1 class="mt-5 headline-lg">{{ $post->title }}</h1>
                    <div class="mt-5 flex flex-wrap items-center gap-3 text-sm text-slate-300">
                        <span class="inline-flex items-center gap-2 rounded-2xl border border-white/10 bg-white/5 px-4 py-2">
                            @include('website.partials.icon', ['name' => 'calendar', 'class' => 'h-4 w-4'])
                            {{ optional($post->published_at)->format('d M Y') }}
                        </span>
                        @if($post->author?->name)
                            <span class="inline-flex items-center gap-2 rounded-2xl border border-white/10 bg-white/5 px-4 py-2">
                                @include('website.partials.icon', ['name' => 'user', 'class' => 'h-4 w-4'])
                                {{ $post->author->name }}
                            </span>
                        @endif
                        <a href="{{ route('website.blog.index') }}" class="inline-flex items-center gap-2 rounded-2xl border border-white/10 bg-white/5 px-4 py-2 hover:bg-white/10">
                            @include('website.partials.icon', ['name' => 'layers', 'class' => 'h-4 w-4'])
                            All posts
                        </a>
                    </div>

                    @if($post->excerpt)
                        <p class="mt-6 body-lg text-slate-300">{{ $post->excerpt }}</p>
                    @endif
                </div>

                <div data-reveal>
                    <div class="glass-card relative overflow-hidden">
                        <img src="{{ $post->cover_image ? $mediaAssetUrl($post->cover_image) : $mediaAssetUrl($websiteImages['blog']['post_fallback_cover'] ?? null, 'assets/images/blog-cover.svg') }}"
                             alt="{{ $post->title }}"
                             class="h-[420px] w-full rounded-[24px] object-cover">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="page-panel py-20 lg:py-24">
        <div class="section-shell grid gap-8 lg:grid-cols-[1fr_0.38fr]">
            <article class="surface-card premium-card prose prose-slate max-w-none" data-reveal>
                {!! nl2br(e($post->body)) !!}
            </article>

            <aside class="space-y-6" data-reveal>
                <div class="surface-card">
                    <div class="section-kicker">Need help with this?</div>
                    <h3 class="mt-4 text-2xl font-bold text-brand-blue">Let’s apply it to your product.</h3>
                    <p class="mt-3 text-slate-600">We can scope a plan and implement the system with measurable outcomes.</p>
                    <div class="mt-6">
                        <a href="{{ route('website.contact') }}" class="btn-primary w-full justify-center"
                           x-on:click.prevent="$store.marketingPopup.openLead({ title: 'Blog inquiry', source: 'blog_post_cta', context: @js('Blog post: '.$post->title), submitLabel: 'Discuss Project' })">
                            Discuss Project
                        </a>
                    </div>
                </div>

                @if(($recentPosts ?? collect())->count())
                    <div class="surface-card">
                        <div class="section-kicker">More posts</div>
                        <div class="mt-5 space-y-4">
                            @foreach($recentPosts as $p)
                                <a href="{{ route('website.blog.show', $p->slug) }}" class="block rounded-[20px] border border-slate-200 bg-white px-4 py-4 shadow-sm transition hover:shadow-md">
                                    <div class="text-xs font-semibold uppercase tracking-[0.22em] text-brand-green">{{ optional($p->published_at)->format('d M Y') }}</div>
                                    <div class="mt-2 text-base font-bold text-brand-blue">{{ $p->title }}</div>
                                    @if($p->excerpt)
                                        <div class="mt-2 text-sm text-slate-600">{{ $p->excerpt }}</div>
                                    @endif
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </aside>
        </div>
    </section>

    @include('website.partials.cta-banner')
@endsection
