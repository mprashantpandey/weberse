@php($marketingServices = collect($marketingContent['services'] ?? []))
@php($websiteFeatures = app(\App\Services\Settings\SiteSettingsService::class)->getWebsiteFeatures())
@php($lightLogo = filled($companyProfile['light_logo'] ?? null) ? (\Illuminate\Support\Str::startsWith($companyProfile['light_logo'], ['http://', 'https://', '/']) ? $companyProfile['light_logo'] : asset($companyProfile['light_logo'])) : asset('assets/legacy/weberse-light.svg'))
@php($darkLogo = filled($companyProfile['dark_logo'] ?? null) ? (\Illuminate\Support\Str::startsWith($companyProfile['dark_logo'], ['http://', 'https://', '/']) ? $companyProfile['dark_logo'] : asset($companyProfile['dark_logo'])) : asset('assets/legacy/weberse-dark.svg'))
<header x-data="{ open: false, aboutOpen: false, servicesOpen: false, scrolled: false }"
    x-init="scrolled = window.scrollY > 12; window.addEventListener('scroll', () => scrolled = window.scrollY > 12)"
    x-effect="open ? document.body.classList.add('overflow-hidden') : document.body.classList.remove('overflow-hidden')"
    @keydown.escape.window="open = false"
    :class="scrolled ? 'shadow-[0_16px_40px_rgba(2,12,27,0.18)] hero-nav-scrolled' : 'hero-nav-top'"
    class="sticky top-0 z-40 backdrop-blur-xl transition duration-300" style="--header-height: 65px;">
    <div class="section-shell flex items-center justify-between py-4">
        <a href="{{ route('website.home') }}" class="flex items-center gap-3">
            <img src="{{ $lightLogo }}" alt="Weberse logo" class="h-10 w-auto sm:h-11">
        </a>

        <nav class="hidden items-center gap-8 lg:flex">
            <a class="nav-link {{ request()->routeIs('website.home') ? 'nav-link-active' : '' }}" href="{{ route('website.home') }}">Home</a>

            <div class="relative" @mouseenter="aboutOpen = true" @mouseleave="aboutOpen = false">
                <a class="nav-link inline-flex items-center gap-2 {{ request()->routeIs('website.about') || request()->routeIs('website.case-studies.*') || request()->routeIs('website.careers') ? 'nav-link-active' : '' }}"
                   href="{{ route('website.about') }}"
                   :aria-expanded="aboutOpen"
                   aria-haspopup="true">
                    About
                    <span class="h-4 w-4 transition-transform duration-200" :class="aboutOpen && 'rotate-180'">
                        @include('website.partials.icon', ['name' => 'chevron', 'class' => 'h-4 w-4 transition-transform duration-200', ])
                    </span>
                </a>
                <div x-show="aboutOpen"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 -translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 -translate-y-2"
                     class="absolute left-0 top-full mt-4 w-64 rounded-[24px] border border-white/10 bg-[rgba(11,34,61,0.96)] p-3 shadow-2xl">
                    <a href="{{ route('website.about') }}" class="block rounded-2xl px-4 py-2 text-sm text-slate-200 hover:bg-white/10">Overview</a>
                    @if ($websiteFeatures['case_studies_enabled'])
                        <a href="{{ route('website.case-studies.index') }}" class="block rounded-2xl px-4 py-2 text-sm text-slate-200 hover:bg-white/10">Case Studies</a>
                    @endif
                    @if ($websiteFeatures['careers_enabled'])
                        <a href="{{ route('website.careers') }}" class="block rounded-2xl px-4 py-2 text-sm text-slate-200 hover:bg-white/10">Careers</a>
                    @endif
                </div>
            </div>
            <div class="relative" @mouseenter="servicesOpen = true" @mouseleave="servicesOpen = false">
                <a class="nav-link inline-flex items-center gap-2 {{ request()->routeIs('website.services') || request()->routeIs('website.services.*') ? 'nav-link-active' : '' }}"
                   href="{{ route('website.services') }}"
                   :aria-expanded="servicesOpen"
                   aria-haspopup="true">
                    Services
                    <span class="transition-transform duration-200" :class="servicesOpen && 'rotate-180'">
                        @include('website.partials.icon', ['name' => 'chevron', 'class' => 'h-4 w-4'])
                    </span>
                </a>
                <div x-show="servicesOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2" class="absolute left-0 top-full mt-4 w-80 rounded-[28px] border border-white/10 bg-[rgba(11,34,61,0.96)] p-4 shadow-2xl">
                    <div class="grid gap-2">
                        @foreach($marketingServices as $service)
                            <a href="{{ route('website.services.show', $service['slug']) }}" class="rounded-2xl px-4 py-3 text-sm text-slate-300 transition hover:bg-white/10 hover:text-white">{{ $service['title'] }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
            @if ($websiteFeatures['portfolio_enabled'])
                <a class="nav-link {{ request()->routeIs('website.portfolio') || request()->routeIs('website.portfolio.show') ? 'nav-link-active' : '' }}" href="{{ route('website.portfolio') }}">Portfolio</a>
            @endif
            @if ($websiteFeatures['pricing_enabled'])
                <a class="nav-link {{ request()->routeIs('website.pricing') ? 'nav-link-active' : '' }}" href="{{ route('website.pricing') }}">Pricing</a>
            @endif
            @if ($websiteFeatures['blog_enabled'])
                <a class="nav-link {{ request()->routeIs('website.blog.*') ? 'nav-link-active' : '' }}" href="{{ route('website.blog.index') }}">Blog</a>
            @endif
            <a class="nav-link {{ request()->routeIs('store.*') ? 'nav-link-active' : '' }}" href="{{ route('store.index') }}">Store</a>
            <a class="nav-link {{ request()->routeIs('website.contact') ? 'nav-link-active' : '' }}" href="{{ route('website.contact') }}">Contact</a>
        </nav>

        <div class="hidden items-center gap-3 lg:flex">
            @if ($websiteFeatures['hosting_enabled'])
                <a href="{{ route('website.hosting') }}" class="btn-secondary">@include('website.partials.icon', ['name' => 'server', 'class' => 'h-4 w-4']) Hosting</a>
            @endif
            <a href="{{ route('website.contact') }}"
               class="btn-primary"
               data-lead-popup
               data-lead-title="Get a Free Consultation"
               data-lead-source="navbar_cta"
               data-lead-context="Navbar consultation request"
               data-lead-submit="Book Free Consultation"
               x-on:click.prevent="$store.marketingPopup.openLead({ title: 'Get a Free Consultation', source: 'navbar_cta', context: 'Navbar consultation request', submitLabel: 'Book Free Consultation' })">@include('website.partials.icon', ['name' => 'calendar', 'class' => 'h-4 w-4']) Get Free Consultation</a>
        </div>

        <button type="button" class="inline-flex h-11 min-w-[44px] items-center justify-center rounded-2xl border border-white/12 bg-white/5 text-white shadow-[0_10px_28px_rgba(2,12,27,0.18)] lg:hidden" @click="open = !open" :aria-expanded="open" aria-controls="mobile-menu" id="mobile-menu-toggle" aria-label="Toggle menu">
            <span x-show="!open" x-transition:enter="transition ease-out duration-150" x-transition:leave="transition ease-in duration-100">@include('website.partials.icon', ['name' => 'menu', 'class' => 'h-5 w-5'])</span>
            <span x-show="open" x-transition:enter="transition ease-out duration-150" x-transition:leave="transition ease-in duration-100">@include('website.partials.icon', ['name' => 'close', 'class' => 'h-5 w-5'])</span>
        </button>
    </div>

    <!-- Backdrop: tap to close -->
    <div x-show="open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="mobile-menu-backdrop fixed inset-0 z-30 bg-black/50 backdrop-blur-sm lg:hidden"
         @click="open = false"
         aria-hidden="true"
         x-cloak></div>

    <div x-show="open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-x-4"
         x-transition:enter-end="opacity-100 translate-x-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-x-0"
         x-transition:leave-end="opacity-0 -translate-x-4"
         class="mobile-menu z-40 lg:hidden"
         id="mobile-menu"
         role="dialog"
         aria-label="Mobile navigation"
         x-cloak>
        <div class="mobile-menu-scroll">
            <div class="section-shell mobile-menu-inner">
                <div class="mobile-menu-header">
                    <img src="{{ $darkLogo }}" alt="Weberse logo" class="h-10 w-auto">
                    <button type="button" class="inline-flex h-11 w-11 items-center justify-center rounded-2xl border border-slate-200 bg-slate-50 text-brand-blue" @click="open = false" aria-label="Close menu">
                        @include('website.partials.icon', ['name' => 'close', 'class' => 'h-5 w-5'])
                    </button>
                </div>
                <p class="mobile-menu-label">Navigate</p>
                <nav class="mobile-menu-nav" aria-label="Mobile navigation">
                    <a class="mobile-nav-link {{ request()->routeIs('website.home') ? 'mobile-nav-link-active' : '' }}" href="{{ route('website.home') }}" @click="open = false">
                        <span class="mobile-nav-icon">@include('website.partials.icon', ['name' => 'home', 'class' => 'h-4 w-4'])</span>
                        <span>Home</span>
                    </a>
                    <div x-data="{ openGroup: {{ request()->routeIs('website.about') || request()->routeIs('website.case-studies.*') || request()->routeIs('website.careers') ? 'true' : 'false' }} }" class="mobile-accordion-group">
                        <button type="button"
                                class="mobile-nav-link mobile-nav-link-toggle border-b-0 {{ request()->routeIs('website.about') || request()->routeIs('website.case-studies.*') || request()->routeIs('website.careers') ? 'mobile-nav-link-active' : '' }}"
                                @click="openGroup = !openGroup"
                                :aria-expanded="openGroup.toString()">
                            <span class="mobile-nav-icon">@include('website.partials.icon', ['name' => 'building', 'class' => 'h-4 w-4'])</span>
                            <span class="flex-1 text-left">About</span>
                            <span class="inline-flex h-5 w-5 items-center justify-center transition-transform duration-200"
                                  :class="openGroup && 'rotate-180'">
                                @include('website.partials.icon', ['name' => 'chevron', 'class' => 'h-4 w-4'])
                            </span>
                        </button>
                        <div x-show="openGroup"
                             x-transition:enter="transition ease-out duration-150"
                             x-transition:enter-start="opacity-0 -translate-y-1"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-100"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 -translate-y-1"
                             class="mobile-services-dropdown"
                             x-cloak>
                            <a class="mobile-nav-link mobile-nav-link-nested {{ request()->routeIs('website.about') ? 'mobile-nav-link-active' : '' }}" href="{{ route('website.about') }}" @click="open = false">
                                <span class="flex-1">Overview</span>
                            </a>
                            @if ($websiteFeatures['case_studies_enabled'])
                                <a class="mobile-nav-link mobile-nav-link-nested {{ request()->routeIs('website.case-studies.*') ? 'mobile-nav-link-active' : '' }}" href="{{ route('website.case-studies.index') }}" @click="open = false">
                                    <span class="flex-1">Case Studies</span>
                                </a>
                            @endif
                            @if ($websiteFeatures['careers_enabled'])
                                <a class="mobile-nav-link mobile-nav-link-nested {{ request()->routeIs('website.careers') ? 'mobile-nav-link-active' : '' }}" href="{{ route('website.careers') }}" @click="open = false">
                                    <span class="flex-1">Careers</span>
                                </a>
                            @endif
                        </div>
                    </div>

                    <div x-data="{ openGroup: true }" class="mobile-accordion-group">
                        <button type="button"
                                class="mobile-nav-link mobile-nav-link-toggle border-b-0"
                                @click="openGroup = !openGroup"
                                :aria-expanded="openGroup.toString()">
                            <span class="mobile-nav-icon">@include('website.partials.icon', ['name' => 'layers', 'class' => 'h-4 w-4'])</span>
                            <span class="flex-1 text-left">Services</span>
                            <span class="inline-flex h-5 w-5 items-center justify-center transition-transform duration-200"
                                  :class="openGroup && 'rotate-180'">
                                @include('website.partials.icon', ['name' => 'chevron', 'class' => 'h-4 w-4'])
                            </span>
                        </button>
                        <div x-show="openGroup"
                             x-transition:enter="transition ease-out duration-150"
                             x-transition:enter-start="opacity-0 -translate-y-1"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-100"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 -translate-y-1"
                             class="mobile-services-dropdown"
                             x-cloak>
                            @foreach($marketingServices as $service)
                                <a href="{{ route('website.services.show', $service['slug']) }}"
                                   class="mobile-nav-link mobile-nav-link-nested {{ request()->routeIs('website.services.show') && request()->route('slug') === $service['slug'] ? 'mobile-nav-link-active' : '' }}"
                                   @click="open = false">
                                    <span class="flex-1">{{ $service['title'] }}</span>
                                    <span class="mobile-service-pill">Service</span>
                                </a>
                            @endforeach
                            <a href="{{ route('website.services') }}"
                               class="mobile-nav-link mobile-nav-link-nested {{ request()->routeIs('website.services') ? 'mobile-nav-link-active' : '' }}"
                               @click="open = false">
                                <span class="flex-1">View all services</span>
                                <span class="mobile-service-pill">All</span>
                            </a>
                        </div>
                    </div>

                    @if ($websiteFeatures['portfolio_enabled'])
                        <a class="mobile-nav-link {{ request()->routeIs('website.portfolio') || request()->routeIs('website.portfolio.show') ? 'mobile-nav-link-active' : '' }}" href="{{ route('website.portfolio') }}" @click="open = false">
                            <span class="mobile-nav-icon">@include('website.partials.icon', ['name' => 'briefcase', 'class' => 'h-4 w-4'])</span>
                            <span>Portfolio</span>
                        </a>
                    @endif
                    @if ($websiteFeatures['pricing_enabled'])
                        <a class="mobile-nav-link {{ request()->routeIs('website.pricing') ? 'mobile-nav-link-active' : '' }}" href="{{ route('website.pricing') }}" @click="open = false">
                            <span class="mobile-nav-icon">@include('website.partials.icon', ['name' => 'receipt', 'class' => 'h-4 w-4'])</span>
                            <span>Pricing</span>
                        </a>
                    @endif
                    @if ($websiteFeatures['blog_enabled'])
                        <a class="mobile-nav-link {{ request()->routeIs('website.blog.*') ? 'mobile-nav-link-active' : '' }}" href="{{ route('website.blog.index') }}" @click="open = false">
                            <span class="mobile-nav-icon">@include('website.partials.icon', ['name' => 'file', 'class' => 'h-4 w-4'])</span>
                            <span>Blog</span>
                        </a>
                    @endif
                    <a class="mobile-nav-link {{ request()->routeIs('store.*') ? 'mobile-nav-link-active' : '' }}" href="{{ route('store.index') }}" @click="open = false">
                        <span class="mobile-nav-icon">@include('website.partials.icon', ['name' => 'cart', 'class' => 'h-4 w-4'])</span>
                        <span>Store</span>
                    </a>
                    <a class="mobile-nav-link {{ request()->routeIs('website.contact') ? 'mobile-nav-link-active' : '' }}" href="{{ route('website.contact') }}" @click="open = false">
                        <span class="mobile-nav-icon">@include('website.partials.icon', ['name' => 'mail', 'class' => 'h-4 w-4'])</span>
                        <span>Contact</span>
                    </a>
                </nav>

                <div class="mobile-menu-divider" aria-hidden="true"></div>

                <div class="mobile-contact-card">
                    <p class="mobile-menu-label text-brand-green">Quick Contact</p>
                    <a href="mailto:{{ $companyProfile['email'] ?? config('platform.company.email') }}" class="mobile-contact-row" @click="open = false">
                        @include('website.partials.icon', ['name' => 'mail', 'class' => 'h-5 w-5 shrink-0 text-brand-green'])
                        <span class="min-w-0 break-all">{{ $companyProfile['email'] ?? config('platform.company.email') }}</span>
                    </a>
                    <a href="tel:{{ preg_replace('/\s+/', '', $companyProfile['phone'] ?? config('platform.company.phone')) }}" class="mobile-contact-row" @click="open = false">
                        @include('website.partials.icon', ['name' => 'phone', 'class' => 'h-5 w-5 shrink-0 text-brand-green'])
                        <span>{{ $companyProfile['phone'] ?? config('platform.company.phone') }}</span>
                    </a>
                    <a href="{{ route('website.contact') }}" class="mobile-contact-cta" @click.prevent="open = false; $store.marketingPopup.openLead({ title: 'Get a Free Consultation', source: 'mobile_menu_quick_contact', context: 'Mobile consultation request', submitLabel: 'Book Free Consultation' })">
                        @include('website.partials.icon', ['name' => 'calendar', 'class' => 'h-4 w-4']) Get Free Consultation
                    </a>
                </div>

                <div class="mobile-menu-divider" aria-hidden="true"></div>

                <div class="mobile-menu-actions">
                    @if ($websiteFeatures['hosting_enabled'])
                        <a href="{{ route('billing') }}" class="btn-secondary w-full justify-center" @click="open = false">@include('website.partials.icon', ['name' => 'server', 'class' => 'h-4 w-4']) Billing</a>
                    @endif
                    <a href="{{ route('website.contact') }}" class="btn-primary w-full justify-center" @click.prevent="open = false; $store.marketingPopup.openLead({ title: 'Start Your Project', source: 'mobile_menu_cta', context: 'Mobile menu project inquiry', submitLabel: 'Start Project' })">@include('website.partials.icon', ['name' => 'calendar', 'class' => 'h-4 w-4']) Start a Project</a>
                </div>
            </div>
        </div>
    </div>
</header>
