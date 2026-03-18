@php($marketingServices = collect($marketingContent['services'] ?? [])->take(5))
@php($websiteFeatures = app(\App\Services\Settings\SiteSettingsService::class)->getWebsiteFeatures())
@php($lightLogo = filled($companyProfile['light_logo'] ?? null) ? (\Illuminate\Support\Str::startsWith($companyProfile['light_logo'], ['http://', 'https://', '/']) ? $companyProfile['light_logo'] : asset($companyProfile['light_logo'])) : asset('assets/legacy/weberse-light.svg'))
<footer class="relative border-t border-white/10 bg-[#020c18] text-white footer-shell">
    <div class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-brand-green to-transparent"></div>
    <div class="relative">
        <div class="section-shell py-14 sm:py-16 lg:py-20">
            <div class="footer-top-grid">
                <div class="footer-news-column">
                    <div class="footer-heading-row">
                        <span class="footer-heading-icon">@include('website.partials.icon', ['name' => 'mail', 'class' => 'h-4 w-4'])</span>
                        <h3 class="footer-heading">Newsletter</h3>
                    </div>
                    <p class="mt-4 max-w-md text-sm leading-7 text-slate-300 sm:text-base">Keep up with product launches, case studies, and practical insights on building stronger digital systems.</p>
                    <form method="POST" action="{{ route('website.newsletter.subscribe') }}" class="footer-subscribe-form mt-6">
                        @csrf
                        <input class="footer-subscribe-input" name="email" type="email" placeholder="Email Address" required>
                        <button type="submit" class="footer-subscribe-button">
                            Subscribe
                        </button>
                    </form>
                </div>

                <div class="footer-link-column">
                    <div class="footer-heading-row">
                        <span class="footer-heading-icon">@include('website.partials.icon', ['name' => 'layers', 'class' => 'h-4 w-4'])</span>
                        <h3 class="footer-heading">Services</h3>
                    </div>
                    <div class="mt-5 space-y-3">
                        @foreach($marketingServices as $service)
                            <a href="{{ route('website.services.show', $service['slug']) }}" class="footer-plain-link">
                                <span class="footer-link-icon">@include('website.partials.icon', ['name' => 'layers', 'class' => 'h-4 w-4'])</span>
                                <span>{{ $service['title'] }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="footer-link-column">
                    <div class="footer-heading-row">
                        <span class="footer-heading-icon">@include('website.partials.icon', ['name' => 'home', 'class' => 'h-4 w-4'])</span>
                        <h3 class="footer-heading">All Pages</h3>
                    </div>
                    <div class="mt-5 space-y-3">
                        <a href="{{ route('website.home') }}" class="footer-plain-link"><span class="footer-link-icon">@include('website.partials.icon', ['name' => 'home', 'class' => 'h-4 w-4'])</span><span>Home</span></a>
                        <a href="{{ route('website.about') }}" class="footer-plain-link"><span class="footer-link-icon">@include('website.partials.icon', ['name' => 'user', 'class' => 'h-4 w-4'])</span><span>About</span></a>
                        @if ($websiteFeatures['portfolio_enabled'])
                            <a href="{{ route('website.portfolio') }}" class="footer-plain-link"><span class="footer-link-icon">@include('website.partials.icon', ['name' => 'briefcase', 'class' => 'h-4 w-4'])</span><span>Portfolio</span></a>
                        @endif
                        @if ($websiteFeatures['blog_enabled'])
                            <a href="{{ route('website.blog.index') }}" class="footer-plain-link"><span class="footer-link-icon">@include('website.partials.icon', ['name' => 'file', 'class' => 'h-4 w-4'])</span><span>Blog</span></a>
                        @endif
                        @if ($websiteFeatures['careers_enabled'])
                            <a href="{{ route('website.careers') }}" class="footer-plain-link"><span class="footer-link-icon">@include('website.partials.icon', ['name' => 'briefcase', 'class' => 'h-4 w-4'])</span><span>Careers</span></a>
                        @endif
                        <a href="{{ route('website.contact') }}"
                           class="footer-plain-link"
                           x-on:click.prevent="$store.marketingPopup.openLead({ title: 'Start Your Project', source: 'footer_contact_link', context: 'Footer contact link', submitLabel: 'Send Inquiry' })">
                            <span class="footer-link-icon">@include('website.partials.icon', ['name' => 'mail', 'class' => 'h-4 w-4'])</span>
                            <span>Contact</span>
                        </a>
                    </div>
                </div>

                <div class="footer-link-column">
                    <div class="footer-heading-row">
                        <span class="footer-heading-icon">@include('website.partials.icon', ['name' => 'linkedin', 'class' => 'h-4 w-4'])</span>
                        <h3 class="footer-heading">Social Media</h3>
                    </div>
                    <div class="mt-5 space-y-3">
                        <a href="{{ $companyProfile['socials']['facebook'] ?? config('platform.company.socials.facebook') }}" class="footer-plain-link"><span class="footer-link-icon">@include('website.partials.icon', ['name' => 'facebook', 'class' => 'h-4 w-4'])</span><span>Facebook</span></a>
                        <a href="{{ $companyProfile['socials']['instagram'] ?? config('platform.company.socials.instagram') }}" class="footer-plain-link"><span class="footer-link-icon">@include('website.partials.icon', ['name' => 'instagram', 'class' => 'h-4 w-4'])</span><span>Instagram</span></a>
                        <a href="{{ $companyProfile['socials']['twitter'] ?? config('platform.company.socials.twitter') }}" class="footer-plain-link"><span class="footer-link-icon">@include('website.partials.icon', ['name' => 'twitter', 'class' => 'h-4 w-4'])</span><span>Twitter</span></a>
                        <a href="{{ $companyProfile['socials']['linkedin'] ?? config('platform.company.socials.linkedin') }}" class="footer-plain-link"><span class="footer-link-icon">@include('website.partials.icon', ['name' => 'linkedin', 'class' => 'h-4 w-4'])</span><span>LinkedIn</span></a>
                        <a href="{{ $companyProfile['socials']['youtube'] ?? config('platform.company.socials.youtube') }}" class="footer-plain-link"><span class="footer-link-icon">@include('website.partials.icon', ['name' => 'youtube', 'class' => 'h-4 w-4'])</span><span>YouTube</span></a>
                    </div>
                </div>

                <div class="footer-contact-column">
                    <a href="mailto:{{ $companyProfile['email'] ?? config('platform.company.email') }}" class="footer-contact-pill">{{ $companyProfile['email'] ?? config('platform.company.email') }}</a>
                    <div class="mt-5 space-y-3">
                        <div class="footer-contact-row">@include('website.partials.icon', ['name' => 'phone']) <span>{{ $companyProfile['phone'] ?? config('platform.company.phone') }}</span></div>
                        <div class="footer-contact-row">@include('website.partials.icon', ['name' => 'map-pin']) <span>{{ ($companyProfile['address_line_1'] ?? null) ?: ($companyProfile['location'] ?? config('platform.company.location')) }}</span></div>
                        @if ($websiteFeatures['hosting_enabled'])
                            <a href="{{ route('billing') }}" class="footer-plain-link">
                                <span class="footer-link-icon">@include('website.partials.icon', ['name' => 'server', 'class' => 'h-4 w-4'])</span>
                                <span>Client Area / Billing</span>
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="footer-brand-stage">
                <div class="footer-brand-orb footer-brand-orb-left"></div>
                <div class="footer-brand-orb footer-brand-orb-right"></div>
                <div class="footer-brand-inner">
                    <img src="{{ $lightLogo }}" alt="Weberse logo" class="footer-brand-logo">
                    <p class="footer-brand-copy">High-conviction engineering for websites, systems, automation, and client-facing platforms.</p>
                        <div class="mt-6 flex flex-wrap gap-3">
                            <a href="{{ route('website.contact') }}"
                               class="btn-primary"
                               data-lead-popup
                               data-lead-title="Start Your Project"
                               data-lead-source="footer_cta"
                               data-lead-context="Footer CTA"
                               data-lead-submit="Start Project"
                               x-on:click.prevent="$store.marketingPopup.openLead({ title: 'Start Your Project', source: 'footer_cta', context: 'Footer CTA', submitLabel: 'Start Project' })">
                                @include('website.partials.icon', ['name' => 'calendar', 'class' => 'h-4 w-4'])
                                Start a Project
                            </a>
                            @if ($websiteFeatures['portfolio_enabled'])
                                <a href="{{ route('website.portfolio') }}" class="btn-secondary">
                                    @include('website.partials.icon', ['name' => 'layers', 'class' => 'h-4 w-4'])
                                    Portfolio
                                </a>
                            @endif
                        </div>
                </div>
            </div>
        </div>
        <div class="section-shell flex flex-col items-start justify-between gap-4 border-t border-white/10 py-6 text-xs text-slate-400 sm:flex-row sm:items-center">
            <p>© {{ now()->year }} Weberse Infotech Private Limited. All rights reserved.</p>
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('website.privacy') }}" class="footer-legal-link">
                    <span class="footer-link-icon">@include('website.partials.icon', ['name' => 'shield', 'class' => 'h-4 w-4'])</span>
                    <span>Privacy Policy</span>
                </a>
                <a href="{{ route('website.terms') }}" class="footer-legal-link">
                    <span class="footer-link-icon">@include('website.partials.icon', ['name' => 'file', 'class' => 'h-4 w-4'])</span>
                    <span>Terms & Conditions</span>
                </a>
            </div>
        </div>
    </div>
</footer>
