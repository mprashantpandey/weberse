<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Weberse Infotech Private Limited' }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{ $description ?? 'Weberse Infotech builds premium websites, software systems, automation workflows, and digital products.' }}">
    <meta property="og:title" content="{{ $title ?? 'Weberse Infotech Private Limited' }}">
    <meta property="og:description" content="{{ $description ?? 'Innovating Intelligence. Building the Future.' }}">
    <meta property="og:type" content="website">
    <meta property="og:image" content="{{ asset('assets/images/og-cover.svg') }}">
    <link rel="icon" href="{{ asset('assets/legacy/favicon.png') }}">
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
