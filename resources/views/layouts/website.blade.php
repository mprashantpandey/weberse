<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @php
        $seoImageMetadata = function (?string $imageUrl): array {
            if (empty($imageUrl)) {
                return ['width' => null, 'height' => null, 'type' => null];
            }

            $imagePath = parse_url($imageUrl, PHP_URL_PATH);
            $publicBasePath = parse_url(rtrim(config('app.url'), '/'), PHP_URL_PATH) ?: '';

            if ($publicBasePath !== '' && str_starts_with($imagePath ?? '', $publicBasePath)) {
                $imagePath = substr((string) $imagePath, strlen($publicBasePath)) ?: '/';
            }

            $absolutePath = public_path(ltrim((string) $imagePath, '/'));

            if (! is_file($absolutePath)) {
                return ['width' => null, 'height' => null, 'type' => null];
            }

            $size = @getimagesize($absolutePath);

            return [
                'width' => $size[0] ?? null,
                'height' => $size[1] ?? null,
                'type' => $size['mime'] ?? null,
            ];
        };

        $seoTitle = $title ?? ($companyProfile['name'] ?? config('platform.company.name'));
        $seoDescription = $description ?? 'Weberse Infotech builds premium websites, software systems, automation workflows, and digital products.';
        $seoRobots = $robots ?? 'index,follow,max-image-preview:large,max-snippet:-1,max-video-preview:-1';
        $canonicalUrl = $canonical ?? url()->current();
        $seoType = $seoType ?? 'website';
        $defaultSeoImage = $mediaAssetUrl(null, 'assets/legacy/hero-1.jpg');
        $seoImage = $seoImage ?? $defaultSeoImage;
        $seoImageInfo = $seoImageMetadata($seoImage);
        $seoImageWidth = $seoImageWidth ?? $seoImageInfo['width'] ?? 1200;
        $seoImageHeight = $seoImageHeight ?? $seoImageInfo['height'] ?? 630;
        $seoImageType = $seoImageType ?? $seoImageInfo['type'] ?? match (strtolower(pathinfo(parse_url($seoImage, PHP_URL_PATH) ?: '', PATHINFO_EXTENSION))) {
            'png' => 'image/png',
            'jpg', 'jpeg' => 'image/jpeg',
            'webp' => 'image/webp',
            'svg' => 'image/svg+xml',
            default => 'image/jpeg',
        };
        $seoPublishedTime = $publishedTime ?? null;
        $seoModifiedTime = $modifiedTime ?? null;
        $socials = $companyProfile['socials'] ?? config('platform.company.socials', []);

        $organizationSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => $companyProfile['name'] ?? config('platform.company.name'),
            'url' => rtrim(config('app.url'), '/'),
            'logo' => $mediaAssetUrl($companyProfile['dark_logo'] ?? null, 'assets/legacy/weberse-dark.svg'),
            'description' => $seoDescription,
            'email' => $companyProfile['email'] ?? config('platform.company.email'),
            'telephone' => $companyProfile['phone'] ?? config('platform.company.phone'),
            'address' => [
                '@type' => 'PostalAddress',
                'addressLocality' => $companyProfile['location'] ?? config('platform.company.location'),
                'streetAddress' => trim(($companyProfile['address_line_1'] ?? '').' '.($companyProfile['address_line_2'] ?? '')),
                'addressCountry' => 'IN',
            ],
            'sameAs' => array_values(array_filter($socials)),
        ];

        $websiteSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'name' => $companyProfile['name'] ?? config('platform.company.name'),
            'url' => rtrim(config('app.url'), '/'),
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => route('website.blog.index').'?q={search_term_string}',
                'query-input' => 'required name=search_term_string',
            ],
        ];

        $pageSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'WebPage',
            'name' => $seoTitle,
            'description' => $seoDescription,
            'url' => $canonicalUrl,
        ];

        if (request()->routeIs('website.blog.show') && isset($post)) {
            $pageSchema = [
                '@context' => 'https://schema.org',
                '@type' => 'Article',
                'headline' => $post->title,
                'description' => $post->seo_description ?: $post->excerpt,
                'image' => [$post->cover_image ? $mediaAssetUrl($post->cover_image) : $defaultSeoImage],
                'datePublished' => optional($post->published_at)->toAtomString(),
                'dateModified' => optional($post->updated_at)->toAtomString(),
                'author' => [
                    '@type' => 'Person',
                    'name' => $post->author?->name ?: ($companyProfile['name'] ?? config('platform.company.name')),
                ],
                'publisher' => [
                    '@type' => 'Organization',
                    'name' => $companyProfile['name'] ?? config('platform.company.name'),
                    'logo' => [
                        '@type' => 'ImageObject',
                        'url' => $mediaAssetUrl($companyProfile['dark_logo'] ?? null, 'assets/legacy/weberse-dark.svg'),
                    ],
                ],
                'mainEntityOfPage' => $canonicalUrl,
            ];
        } elseif (request()->routeIs('website.portfolio.show') && isset($project)) {
            $pageSchema = [
                '@context' => 'https://schema.org',
                '@type' => 'CreativeWork',
                'name' => $project->title,
                'description' => $project->summary,
                'image' => $project->featured_image ? $mediaAssetUrl($project->featured_image) : $defaultSeoImage,
                'creator' => $companyProfile['name'] ?? config('platform.company.name'),
                'url' => $canonicalUrl,
            ];
        } elseif (request()->routeIs('website.case-studies.show') && isset($caseStudy)) {
            $pageSchema = [
                '@context' => 'https://schema.org',
                '@type' => 'CreativeWork',
                'name' => $caseStudy->title,
                'description' => $caseStudy->summary,
                'image' => $caseStudy->featured_image ? $mediaAssetUrl($caseStudy->featured_image) : $defaultSeoImage,
                'about' => $caseStudy->client,
                'creator' => $companyProfile['name'] ?? config('platform.company.name'),
                'url' => $canonicalUrl,
            ];
        } elseif (request()->routeIs('website.services.show') && isset($service)) {
            $pageSchema = [
                '@context' => 'https://schema.org',
                '@type' => 'Service',
                'name' => $service['title'] ?? 'Weberse Service',
                'description' => $service['summary'] ?? $seoDescription,
                'provider' => [
                    '@type' => 'Organization',
                    'name' => $companyProfile['name'] ?? config('platform.company.name'),
                ],
                'url' => $canonicalUrl,
            ];
        }
    @endphp
    <title>{{ $seoTitle }}</title>
    @if (!empty($includeCsrfToken ?? false))
        <meta name="csrf-token" content="{{ csrf_token() }}">
    @endif
    <meta name="description" content="{{ $seoDescription }}">
    <meta name="robots" content="{{ $seoRobots }}">
    <meta name="author" content="{{ $companyProfile['name'] ?? config('platform.company.name') }}">
    <meta name="theme-color" content="{{ config('platform.company.primary_blue') }}">
    <link rel="canonical" href="{{ $canonicalUrl }}">
    <meta property="og:title" content="{{ $seoTitle }}">
    <meta property="og:description" content="{{ $seoDescription }}">
    <meta property="og:type" content="{{ $seoType }}">
    <meta property="og:url" content="{{ $canonicalUrl }}">
    <meta property="og:site_name" content="{{ $companyProfile['name'] ?? config('platform.company.name') }}">
    <meta property="og:locale" content="en_IN">
    <meta property="og:image" content="{{ $seoImage }}">
    <meta property="og:image:width" content="{{ $seoImageWidth }}">
    <meta property="og:image:height" content="{{ $seoImageHeight }}">
    <meta property="og:image:type" content="{{ $seoImageType }}">
    <meta property="og:image:alt" content="{{ $seoTitle }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $seoTitle }}">
    <meta name="twitter:description" content="{{ $seoDescription }}">
    <meta name="twitter:image" content="{{ $seoImage }}">
    <meta name="twitter:image:alt" content="{{ $seoTitle }}">
    @if($seoPublishedTime)
        <meta property="article:published_time" content="{{ $seoPublishedTime }}">
    @endif
    @if($seoModifiedTime)
        <meta property="article:modified_time" content="{{ $seoModifiedTime }}">
    @endif
    <link rel="icon" href="{{ $mediaAssetUrl($companyProfile['favicon'] ?? null, 'favicon.ico') }}">
    <link rel="sitemap" type="application/xml" title="Sitemap" href="{{ route('seo.sitemap') }}">
    @php
        $integrationSettings = app(\App\Services\Settings\SiteSettingsService::class)->getIntegrationSettings();
    @endphp
    @if (!empty($integrationSettings['google_analytics_id']))
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $integrationSettings['google_analytics_id'] }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '{{ $integrationSettings["google_analytics_id"] }}');
        </script>
    @endif
    @if (!empty($integrationSettings['google_tag_manager_id']))
        <script>
            (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
            new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
            })(window,document,'script','dataLayer','{{ $integrationSettings["google_tag_manager_id"] }}');
        </script>
    @endif
    @if (!empty($integrationSettings['head_snippet']))
        {!! $integrationSettings['head_snippet'] !!}
    @endif
    <script type="application/ld+json">{!! json_encode($organizationSchema, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE) !!}</script>
    <script type="application/ld+json">{!! json_encode($websiteSchema, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE) !!}</script>
    <script type="application/ld+json">{!! json_encode($pageSchema, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE) !!}</script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="site-shell">
    @if (!empty($integrationSettings['google_tag_manager_id']))
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ $integrationSettings['google_tag_manager_id'] }}"
        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    @endif
    <a href="#main-content" class="absolute left-[-9999px] top-6 z-[100] rounded-2xl bg-brand-green px-4 py-2 text-sm font-semibold text-white shadow-lg transition-[left] focus:left-6 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-brand-dark">Skip to content</a>
    <div class="site-ambient" aria-hidden="true">
        <span class="site-ambient-blob site-ambient-blob-a"></span>
        <span class="site-ambient-blob site-ambient-blob-b"></span>
        <span class="site-ambient-blob site-ambient-blob-c"></span>
        <span class="site-ambient-ring site-ambient-ring-a"></span>
        <span class="site-ambient-ring site-ambient-ring-b"></span>
        <span class="site-ambient-line site-ambient-line-a"></span>
        <span class="site-ambient-line site-ambient-line-b"></span>
    </div>
    <div class="grid-pattern absolute inset-0" aria-hidden="true"></div>
    @include('website.partials.navbar')
    <main id="main-content">
        @yield('content')
    </main>
    @include('website.partials.footer')
    @include('website.partials.marketing-popups')
    @php
        $quickPhone = (string) ($companyProfile['phone'] ?? config('platform.company.phone', ''));
        $quickEmail = (string) ($companyProfile['email'] ?? config('platform.company.email', ''));
        $quickWhatsapp = (string) ($companyProfile['whatsapp'] ?? config('platform.company.whatsapp', $quickPhone));
        $quickWhatsappDigits = preg_replace('/\D+/', '', $quickWhatsapp) ?: preg_replace('/\D+/', '', $quickPhone);
        $quickCallDigits = preg_replace('/\D+/', '', $quickPhone);
        $teamsLink = (string) ($companyProfile['teams_link'] ?? '');
    @endphp
    <div
        x-data="{ open: false }"
        x-on:keydown.escape.window="open = false"
        class="quick-actions-widget"
    >
        <button
            type="button"
            class="quick-actions-fab"
            aria-label="Open quick contact options"
            x-on:click="open = !open"
            x-bind:aria-expanded="open.toString()"
        >
            <span class="quick-actions-fab-ping" aria-hidden="true"></span>
            <span class="quick-actions-fab-icon" x-show="!open" x-cloak>
                @include('website.partials.icon', ['name' => 'messages-square', 'class' => 'h-5 w-5'])
            </span>
            <span class="quick-actions-fab-icon" x-show="open" x-cloak>
                @include('website.partials.icon', ['name' => 'close', 'class' => 'h-5 w-5'])
            </span>
        </button>

        <div class="quick-actions-panel" x-show="open" x-cloak x-transition.origin.bottom.left>
            <div class="quick-actions-title">Need Help Fast?</div>
            <p class="quick-actions-subtitle">Pick your preferred channel and our team will respond quickly.</p>
            <div class="quick-actions-grid">
                <a
                    class="quick-actions-item"
                    href="{{ !empty($quickWhatsappDigits ?? null) ? 'https://wa.me/'.$quickWhatsappDigits : '#' }}"
                    target="_blank"
                    rel="noopener"
                >
                    <span class="quick-actions-item-icon">
                        @include('website.partials.icon', ['name' => 'whatsapp', 'class' => 'h-4 w-4'])
                    </span>
                    <span class="quick-actions-item-label">WhatsApp Chat</span>
                </a>

                <a class="quick-actions-item" href="{{ !empty($quickCallDigits ?? null) ? 'tel:+'.$quickCallDigits : '#' }}">
                    <span class="quick-actions-item-icon">
                        @include('website.partials.icon', ['name' => 'phone', 'class' => 'h-4 w-4'])
                    </span>
                    <span class="quick-actions-item-label">Call Us</span>
                </a>

                @if (!empty($teamsLink ?? null))
                    <a class="quick-actions-item" href="{{ $teamsLink }}" target="_blank" rel="noopener">
                        <span class="quick-actions-item-icon">
                            @include('website.partials.icon', ['name' => 'teams', 'class' => 'h-4 w-4'])
                        </span>
                        <span class="quick-actions-item-label">Teams Meeting</span>
                    </a>
                @else
                    <a
                        href="{{ route('website.contact') }}"
                        class="quick-actions-item"
                        data-lead-popup
                        data-lead-title="Schedule a Teams Call"
                        data-lead-source="quick_actions_teams"
                        data-lead-context="Quick actions widget"
                        data-lead-submit="Request Teams Call"
                    >
                        <span class="quick-actions-item-icon">
                            @include('website.partials.icon', ['name' => 'teams', 'class' => 'h-4 w-4'])
                        </span>
                        <span class="quick-actions-item-label">Teams Meeting</span>
                    </a>
                @endif

                <a
                    class="quick-actions-item"
                    href="{{ !empty($quickEmail ?? null) ? 'mailto:'.$quickEmail.'?subject='.rawurlencode('Project Inquiry').'&body='.rawurlencode('Hi Weberse, I would like to discuss a project.') : '#' }}"
                >
                    <span class="quick-actions-item-icon">
                        @include('website.partials.icon', ['name' => 'mail', 'class' => 'h-4 w-4'])
                    </span>
                    <span class="quick-actions-item-label">Email Us</span>
                </a>
            </div>
        </div>

        <div class="quick-actions-backdrop" x-show="open" x-cloak x-on:click="open = false"></div>
    </div>
    @if (!empty($integrationSettings['footer_snippet']))
        {!! $integrationSettings['footer_snippet'] !!}
    @endif
    @if (!empty($integrationSettings['tawk_enabled']) && !empty($integrationSettings['tawk_property_id']) && !empty($integrationSettings['tawk_widget_id']))
        <script type="text/javascript">
            var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
            (function(){
            var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
            s1.async=true;
            s1.src='https://embed.tawk.to/{{ $integrationSettings["tawk_property_id"] }}/{{ $integrationSettings["tawk_widget_id"] }}';
            s1.charset='UTF-8';
            s1.setAttribute('crossorigin','*');
            s0.parentNode.insertBefore(s1,s0);
            })();
        </script>
    @endif
</body>
</html>
