<section class="section-shell py-12 lg:py-14">
    <div class="glass-card glow-ring relative overflow-hidden bg-[linear-gradient(135deg,rgba(115,182,85,0.24),rgba(11,29,47,0.92)_40%,rgba(17,76,128,0.9))]">
        <div class="card-pattern card-pattern-strong" aria-hidden="true"></div>
        <img src="{{ $mediaAssetUrl($websiteImages['cta']['background'] ?? null, 'assets/legacy/cta-bg.svg') }}" alt="" class="absolute inset-0 h-full w-full object-cover opacity-10">
        <div class="hero-orb -left-10 top-8 h-40 w-40 bg-brand-green/30"></div>
        <div class="hero-orb right-0 top-0 h-56 w-56 bg-cyan-400/20 animate-float-delay"></div>
        <div class="floating-dot-cluster floating-dot-cluster-right" aria-hidden="true"></div>
        <div class="floating-dot-cluster floating-dot-cluster-left" aria-hidden="true"></div>
        <div class="scroll-beam"></div>
        <div class="relative grid gap-6 lg:grid-cols-[1.1fr_0.9fr] lg:items-center">
            <div>
                <div class="section-kicker">Let’s Build</div>
                <h2 class="mt-3 max-w-2xl text-3xl font-bold leading-[1.08] text-white md:text-4xl xl:text-5xl">Need a premium website or platform that converts?</h2>
                <p class="mt-3 max-w-xl text-base leading-7 text-slate-300 md:text-lg">We build modern digital experiences for ambitious brands.</p>
            </div>
            <div class="flex flex-wrap gap-4 lg:justify-end">
                <a href="{{ route('website.contact') }}"
                   class="btn-primary animate-pulse-soft"
                   data-lead-popup
                   data-lead-title="Start Your Project"
                   data-lead-source="cta_banner"
                   data-lead-context="CTA banner inquiry"
                   data-lead-submit="Start Project"
                   x-on:click.prevent="$store.marketingPopup.openLead({ title: 'Start Your Project', source: 'cta_banner', context: 'CTA banner inquiry', submitLabel: 'Start Project' })">@include('website.partials.icon', ['name' => 'calendar', 'class' => 'h-4 w-4']) Start Your Project</a>
                <a href="{{ route('website.services') }}" class="btn-secondary">@include('website.partials.icon', ['name' => 'layers', 'class' => 'h-4 w-4']) Explore Services</a>
            </div>
        </div>
    </div>
</section>
