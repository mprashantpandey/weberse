<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @php
        $seoTitle = $title ?? ($companyProfile['name'] ?? config('platform.company.name'));
        $seoDescription = $description ?? 'Weberse Infotech builds premium websites, software systems, automation workflows, and digital products.';
        $seoRobots = $robots ?? 'index,follow,max-image-preview:large,max-snippet:-1,max-video-preview:-1';
        $canonicalUrl = $canonical ?? url()->current();
        $seoType = $seoType ?? 'website';
        $defaultSeoImage = $mediaAssetUrl($companyProfile['dark_logo'] ?? null, 'assets/images/og-cover.svg');
        $seoImage = $seoImage ?? $defaultSeoImage;
        $seoImageWidth = $seoImageWidth ?? 1200;
        $seoImageHeight = $seoImageHeight ?? 630;
        $seoImageType = $seoImageType ?? match (strtolower(pathinfo(parse_url($seoImage, PHP_URL_PATH) ?: '', PATHINFO_EXTENSION))) {
            'png' => 'image/png',
            'jpg', 'jpeg' => 'image/jpeg',
            'webp' => 'image/webp',
            default => 'image/svg+xml',
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
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
    @php($integrationSettings = app(\App\Services\Settings\SiteSettingsService::class)->getIntegrationSettings())
    @if (!empty($integrationSettings['google_analytics_id']))
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $integrationSettings['google_analytics_id'] }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '{{ $integrationSettings['google_analytics_id'] }}');
        </script>
    @endif
    @if (!empty($integrationSettings['google_tag_manager_id']))
        <script>
            (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
            new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
            })(window,document,'script','dataLayer','{{ $integrationSettings['google_tag_manager_id'] }}');
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
    @if (!empty($integrationSettings['footer_snippet']))
        {!! $integrationSettings['footer_snippet'] !!}
    @endif
    @if (!empty($integrationSettings['tawk_enabled']) && !empty($integrationSettings['tawk_property_id']) && !empty($integrationSettings['tawk_widget_id']))
        <script type="text/javascript">
            var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
            (function(){
            var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
            s1.async=true;
            s1.src='https://embed.tawk.to/{{ $integrationSettings['tawk_property_id'] }}/{{ $integrationSettings['tawk_widget_id'] }}';
            s1.charset='UTF-8';
            s1.setAttribute('crossorigin','*');
            s0.parentNode.insertBefore(s1,s0);
            })();
        </script>
    @endif
</body>
</html>
