<article class="{{ $light ?? false ? 'surface-card' : 'glass-card' }} premium-card group relative overflow-hidden" data-reveal>
    <div class="card-pattern" aria-hidden="true"></div>
    <div class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-brand-green/60 to-transparent"></div>
    <div class="premium-icon premium-icon-animated mb-5 inline-flex rounded-2xl {{ $light ?? false ? 'bg-brand-surface text-brand-blue' : 'bg-white/10 text-brand-green' }} p-4">
        @include('website.partials.icon', ['name' => $service['icon'], 'class' => 'h-7 w-7'])
    </div>
    <h3 class="text-2xl font-bold {{ $light ?? false ? 'text-brand-blue' : 'text-white' }}">{{ $service['title'] }}</h3>
    <p class="mt-3 {{ $light ?? false ? 'text-slate-600' : 'text-slate-300' }}">{{ $service['summary'] }}</p>
    <div class="mt-6 flex flex-wrap gap-2">
        @foreach(array_slice($service['technologies'], 0, 3) as $technology)
            <span class="{{ $light ?? false ? 'surface-badge' : 'badge-chip' }}">{{ $technology }}</span>
        @endforeach
    </div>
    <a href="{{ route('website.services.show', $service['slug']) }}" class="mt-8 inline-flex items-center gap-2 text-sm font-semibold {{ $light ?? false ? 'text-brand-blue' : 'text-white' }} transition duration-300 group-hover:translate-x-1">
        Explore Service <span class="transition duration-300 group-hover:translate-x-1">@include('website.partials.icon', ['name' => 'arrow'])</span>
    </a>
</article>
