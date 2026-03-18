<article class="{{ $light ?? false ? 'surface-card' : 'glass-card' }} premium-card h-full" data-reveal>
    @php($initials = collect(explode(' ', $testimonial->name))->filter()->map(fn ($part) => strtoupper(substr($part, 0, 1)))->take(2)->implode(''))
    <div class="flex items-center justify-between gap-4">
        <div class="text-sm uppercase tracking-[0.22em] text-brand-green">{{ $testimonial->company }}</div>
        <div class="flex gap-1 text-brand-green">
            @for ($i = 0; $i < 5; $i++)
                <span>★</span>
            @endfor
        </div>
    </div>
    <p class="mt-5 text-lg {{ $light ?? false ? 'text-slate-700' : 'text-slate-200' }}">“{{ $testimonial->quote }}”</p>
    <div class="mt-8 flex items-center justify-between gap-4 border-t {{ $light ?? false ? 'border-slate-200/80' : 'border-white/10' }} pt-5">
        <div class="flex items-center gap-3">
            <div class="inline-flex h-12 w-12 items-center justify-center rounded-2xl {{ $light ?? false ? 'bg-brand-blue text-white' : 'bg-white/10 text-brand-green' }} text-sm font-bold tracking-[0.16em]">
                {{ $initials ?: 'W' }}
            </div>
            <div>
                <div class="text-base font-semibold {{ $light ?? false ? 'text-brand-blue' : 'text-white' }}">{{ $testimonial->name }}</div>
                <div class="mt-1 text-xs uppercase tracking-[0.18em] {{ $light ?? false ? 'text-slate-400' : 'text-slate-400' }}">Verified Client</div>
            </div>
        </div>
        <div class="rounded-full {{ $light ?? false ? 'border border-slate-200 bg-slate-50 text-slate-500' : 'border border-white/10 bg-white/5 text-slate-300' }} px-4 py-2 text-xs font-medium">
            {{ $testimonial->company }}
        </div>
    </div>
</article>
