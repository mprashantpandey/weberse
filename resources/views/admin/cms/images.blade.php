@extends('layouts.dashboard', [
    'title' => 'Website Images',
    'heading' => 'Website Images',
    'subheading' => 'Replace frontend visuals through one dedicated CMS workspace instead of editing template paths.',
    'nav' => [
        ['label' => 'Overview', 'route' => 'admin.dashboard', 'active' => 'admin.dashboard'],
        ['label' => 'CMS', 'route' => 'admin.cms.index', 'active' => 'admin.cms.*'],
        ['label' => 'CRM', 'route' => 'admin.crm.index', 'active' => 'admin.crm.*'],
        ['label' => 'HRM', 'route' => 'admin.hrm.index', 'active' => 'admin.hrm.*'],
        ['label' => 'Support', 'route' => 'admin.support.index', 'active' => 'admin.support.*'],
        ['label' => 'Analytics', 'route' => 'admin.analytics.index', 'active' => 'admin.analytics.*'],
    ],
])

@php
    $imageGroups = [
        'home' => ['label' => 'Home', 'items' => ['hero_dashboard' => 'Hero dashboard visual', 'blog_preview' => 'Blog preview image']],
        'about' => ['label' => 'About', 'items' => ['hero_team' => 'Hero team image', 'strategy_meeting' => 'Strategy meeting image', 'delivery_systems' => 'Delivery systems image']],
        'services' => ['label' => 'Services', 'items' => ['overview_hero' => 'Services page hero', 'mobile-app-development' => 'Mobile app development', 'web-development' => 'Web development', 'digital-marketing' => 'Digital marketing', 'ui-ux-design' => 'UI/UX design', 'ai-automation' => 'AI automation', 'whatsapp-cloud-automation' => 'WhatsApp Cloud & Automation', 'email-marketing-automation' => 'Email marketing & automation', 'startup-mvp-development' => 'Startup MVP development', 'custom-software-development' => 'Custom software development', 'digital-marketing-hero' => 'Digital marketing detail visual', 'ui-ux-design-hero' => 'UI/UX hero visual', 'ui-ux-design-industries' => 'UI/UX industries visual', 'email-marketing-automation-hero' => 'Email automation visual', 'startup-mvp-development-hero' => 'Startup MVP visual', 'custom-software-development-hero' => 'Custom software visual', 'whatsapp-cloud-automation-hero' => 'WhatsApp automation visual', 'ai-automation-hero' => 'AI automation visual']],
        'projects' => ['label' => 'Portfolio Projects', 'items' => ['zenflow-ops' => 'Zenflow Ops', 'nova-host' => 'Nova Host', 'pulse-mobile' => 'Pulse Mobile']],
        'case_studies' => ['label' => 'Case Studies', 'items' => ['scaling-a-modern-hosting-brand' => 'Scaling a Modern Hosting Brand', 'building-an-internal-ops-platform' => 'Building an Internal Ops Platform']],
        'portfolio' => ['label' => 'Portfolio Page', 'items' => ['hero_showcase' => 'Portfolio hero visual', 'fallback_placeholder' => 'Project fallback placeholder']],
        'blog' => ['label' => 'Blog', 'items' => ['hero_cover' => 'Blog page hero', 'post_fallback_cover' => 'Blog post fallback cover']],
        'careers' => ['label' => 'Careers', 'items' => ['hero_team' => 'Careers hero image']],
        'contact' => ['label' => 'Contact', 'items' => ['workspace' => 'Contact workspace image']],
        'hosting' => ['label' => 'Hosting', 'items' => ['hero_interface' => 'Hosting hero visual']],
        'pricing' => ['label' => 'Pricing', 'items' => ['hero_showcase' => 'Pricing hero visual']],
        'cta' => ['label' => 'Shared CTA', 'items' => ['background' => 'CTA background texture']],
    ];
@endphp

@section('content')
    <div class="dashboard-subnav">
        <a href="{{ route('admin.cms.index') }}" class="dashboard-subnav-link">Overview</a>
        <a href="{{ route('admin.cms.website-details') }}" class="dashboard-subnav-link">Website Details</a>
        <a href="{{ route('admin.cms.images') }}" class="dashboard-subnav-link dashboard-subnav-link-active">Images</a>
        <a href="{{ route('admin.cms.posts.index') }}" class="dashboard-subnav-link">Blog Posts</a>
        <a href="{{ route('admin.cms.projects.index') }}" class="dashboard-subnav-link">Portfolio</a>
        <a href="{{ route('admin.cms.case-studies.index') }}" class="dashboard-subnav-link">Case Studies</a>
        <a href="{{ route('admin.cms.testimonials.index') }}" class="dashboard-subnav-link">Testimonials</a>
    </div>

    <div
        class="grid gap-6 xl:grid-cols-[1.2fr_0.9fr]"
        x-data="window.websiteImageManager(
            @js($websiteImages),
            @js(collect($imageGroups)->flatMap(fn ($group, $groupKey) => collect($group['items'])->mapWithKeys(fn ($label, $itemKey) => [$groupKey.'.'.$itemKey => $label]))->all())
        )"
    >
        <div class="space-y-6">
            @if (session('status'))
                <div class="card mb-0 border border-green-200 bg-green-50 text-green-700">
                    <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                        <div>
                            <div>{{ session('status') }}</div>
                            @if (session('uploaded_media_path'))
                                <div class="mt-1 text-xs text-green-700/80">{{ session('uploaded_media_name') }} • {{ session('uploaded_media_path') }}</div>
                            @endif
                        </div>
                        @if (session('uploaded_media_path'))
                            <button type="button" class="btn-primary shrink-0" @click="assignAsset(@js(session('uploaded_media_path')))">Use Current Upload</button>
                        @endif
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.cms.images.update') }}" class="space-y-6">
                @csrf
                @method('PATCH')

                @foreach ($imageGroups as $groupKey => $group)
                    <div class="card">
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <div class="panel-title">{{ $group['label'] }}</div>
                                <div class="panel-subtitle">Pick a managed asset for each frontend image slot in this section.</div>
                            </div>
                        </div>

                        <div class="mt-6 grid gap-4 md:grid-cols-2">
                            @foreach ($group['items'] as $itemKey => $label)
                                @php($fieldKey = $groupKey.'.'.$itemKey)
                                <div class="rounded-[24px] border border-slate-200 bg-slate-50/70 p-4">
                                    <div class="flex items-center justify-between gap-3">
                                        <div class="text-sm font-semibold text-slate-800">{{ $label }}</div>
                                        <button
                                            type="button"
                                            class="dashboard-subnav-link px-3 py-1.5 text-xs"
                                            :class="activeImageKey === @js($fieldKey) && 'dashboard-subnav-link-active'"
                                            @click="focusLibrary(@js($fieldKey))"
                                        >
                                            <span x-text="activeImageKey === @js($fieldKey) ? 'Replacing now' : 'Replace current'"></span>
                                        </button>
                                    </div>

                                    <input type="hidden" name="images[{{ $groupKey }}][{{ $itemKey }}]" :value="valueFor(@js($fieldKey))">

                                    <div class="mt-4 flex h-40 items-center justify-center rounded-[20px] border border-slate-200 bg-white p-4">
                                        <img
                                            x-show="valueFor(@js($fieldKey))"
                                            :src="resolveAsset(valueFor(@js($fieldKey)))"
                                            alt="{{ $label }}"
                                            class="max-h-32 w-auto rounded-xl object-contain"
                                            x-cloak
                                        >
                                        <div x-show="!valueFor(@js($fieldKey))" class="text-sm text-slate-500" x-cloak>No image selected.</div>
                                    </div>

                                    <div class="mt-3 break-all text-xs text-slate-500" x-text="valueFor(@js($fieldKey)) || 'No image selected'"></div>
                                    <button type="button" class="btn-secondary mt-4 w-full justify-center px-4 py-2 text-xs" @click="focusLibrary(@js($fieldKey))">Choose from Media Library</button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach

                <div class="flex gap-3">
                    <button class="btn-primary">Save Website Images</button>
                    <a href="{{ route('admin.cms.index') }}" class="btn-dark">Back to CMS</a>
                </div>
            </form>
        </div>

        <div class="space-y-6">
            <div class="card">
                <div class="panel-title">Media Upload</div>
                <div class="panel-subtitle">Upload a new image once, then assign it to any page section or service visual.</div>

                <form method="POST" action="{{ route('admin.cms.media.upload') }}" enctype="multipart/form-data" class="mt-6 flex flex-col gap-3 sm:flex-row">
                    @csrf
                    <input class="input" type="file" name="media_file" accept=".png,.jpg,.jpeg,.webp,.svg,.ico" required>
                    <button class="btn-primary shrink-0">Upload Media</button>
                </form>

                <div class="mt-4 rounded-[20px] border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-500">
                    <div>Active target</div>
                    <div class="mt-1 font-semibold text-brand-blue" x-text="targetLabels[activeImageKey] || activeImageKey"></div>
                    <div class="mt-1 text-xs text-slate-400" x-text="activeImageKey"></div>
                </div>
            </div>

            <div class="card" x-ref="mediaLibrary">
                <div class="panel-title">Media Library</div>
                <div class="panel-subtitle">Click any image below to assign it to the active target.</div>

                <div class="mt-6 grid gap-4 sm:grid-cols-2">
                    @foreach ($mediaAssets as $asset)
                        <button type="button" class="rounded-[24px] border border-slate-200 bg-slate-50 p-4 text-left transition hover:border-brand-green/30 hover:bg-brand-surface/70" @click="assignAsset(@js($asset['path']))">
                            <div class="flex h-24 items-center justify-center rounded-[18px] border border-slate-200 bg-white p-3">
                                @if (in_array($asset['extension'], ['svg', 'png', 'jpg', 'jpeg', 'webp']))
                                    <img src="{{ $asset['url'] }}" alt="{{ $asset['name'] }}" class="max-h-16 w-auto">
                                @else
                                    <div class="text-sm font-semibold text-slate-500">{{ strtoupper($asset['extension']) }}</div>
                                @endif
                            </div>
                            <div class="mt-3 text-sm font-semibold text-slate-800">{{ $asset['name'] }}</div>
                            <div class="mt-1 break-all text-xs text-slate-500">{{ $asset['path'] }}</div>
                        </button>
                    @endforeach
                </div>
            </div>
        </div>

        <div x-show="libraryOpen" x-cloak class="dashboard-modal-backdrop" @click.self="libraryOpen = false">
            <div class="dashboard-modal-card max-w-4xl">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <div class="panel-title">Media Library</div>
                        <div class="panel-subtitle">Choose a file for <span class="font-semibold text-brand-blue" x-text="targetLabels[activeImageKey] || activeImageKey"></span>.</div>
                    </div>
                    <button type="button" class="btn-dark px-4 py-2 text-xs" @click="libraryOpen = false">Close</button>
                </div>

                <form method="POST" action="{{ route('admin.cms.media.upload') }}" enctype="multipart/form-data" class="mt-6 flex flex-col gap-3 sm:flex-row">
                    @csrf
                    <input class="input" type="file" name="media_file" accept=".png,.jpg,.jpeg,.webp,.svg,.ico" required>
                    <button class="btn-primary shrink-0">Upload Media</button>
                </form>

                <div class="mt-6 grid gap-4 sm:grid-cols-2">
                    @foreach ($mediaAssets as $asset)
                        <button type="button" class="rounded-[24px] border border-slate-200 bg-slate-50 p-4 text-left transition hover:border-brand-green/30 hover:bg-brand-surface/70" @click="assignAsset(@js($asset['path']))">
                            <div class="flex h-24 items-center justify-center rounded-[18px] border border-slate-200 bg-white p-3">
                                @if (in_array($asset['extension'], ['svg', 'png', 'jpg', 'jpeg', 'webp']))
                                    <img src="{{ $asset['url'] }}" alt="{{ $asset['name'] }}" class="max-h-16 w-auto">
                                @else
                                    <div class="text-sm font-semibold text-slate-500">{{ strtoupper($asset['extension']) }}</div>
                                @endif
                            </div>
                            <div class="mt-3 text-sm font-semibold text-slate-800">{{ $asset['name'] }}</div>
                            <div class="mt-1 break-all text-xs text-slate-500">{{ $asset['path'] }}</div>
                        </button>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
