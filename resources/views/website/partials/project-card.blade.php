@php
    $title = is_array($project) ? ($project['title'] ?? '') : $project->title;
    $slug = is_array($project) ? ($project['slug'] ?? '') : $project->slug;
    $category = is_array($project) ? ($project['category'] ?? 'Project') : ($project->category ?: ($project->industry ?: 'Project'));
    $description = is_array($project) ? ($project['description'] ?? '') : ($project->summary ?? '');
    $stack = is_array($project) ? ($project['stack'] ?? []) : ($project->stack ?? []);
    $image = is_array($project)
        ? ($project['image'] ?? null)
        : ($project->featured_image ?: ($websiteImages['portfolio']['fallback_placeholder'] ?? null));
@endphp

<article class="{{ $light ?? false ? 'surface-card' : 'glass-card' }} premium-card portfolio-card overflow-hidden" data-reveal>
    <div class="card-pattern" aria-hidden="true"></div>
    <div class="portfolio-media">
        <img src="{{ $mediaAssetUrl($image, 'assets/images/map-placeholder.svg') }}" alt="{{ $title }}" class="h-64 w-full rounded-[24px] object-contain p-4">
        <div class="portfolio-overlay"></div>
    </div>
    <div class="portfolio-content-shift mt-6">
        <div class="text-sm font-semibold uppercase tracking-[0.22em] {{ $light ?? false ? 'text-brand-green' : 'text-brand-green' }}">{{ $category }}</div>
        <h3 class="mt-3 text-2xl font-bold {{ $light ?? false ? 'text-brand-blue' : 'text-white' }}">{{ $title }}</h3>
        <p class="mt-3 {{ $light ?? false ? 'text-slate-600' : 'text-slate-300' }}">{{ $description }}</p>
        <div class="mt-5 flex flex-wrap gap-2">
            @foreach($stack as $item)
                <span class="{{ $light ?? false ? 'surface-badge' : 'badge-chip' }}">{{ $item }}</span>
            @endforeach
        </div>
        <a href="{{ route('website.portfolio.show', $slug) }}" class="portfolio-action mt-6 text-sm font-semibold {{ $light ?? false ? 'text-brand-blue' : 'text-white' }}">
            View Project <span class="transition duration-300 group-hover:translate-x-1">@include('website.partials.icon', ['name' => 'arrow'])</span>
        </a>
    </div>
</article>
