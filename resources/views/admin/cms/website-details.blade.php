@extends('layouts.dashboard', [
    'title' => 'Website Details',
    'heading' => 'Website Details',
    'subheading' => 'Manage logos, company profile, contact details, address, and social media links.',
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
    $logoPreview = fn (?string $path) => filled($path)
        ? (\Illuminate\Support\Str::startsWith($path, ['http://', 'https://', '/']) ? $path : asset($path))
        : null;
@endphp

@section('content')
    <div class="dashboard-subnav">
        <a href="{{ route('admin.cms.index') }}" class="dashboard-subnav-link">Overview</a>
        <a href="{{ route('admin.cms.website-details') }}" class="dashboard-subnav-link dashboard-subnav-link-active">Website Details</a>
        <a href="{{ route('admin.cms.images') }}" class="dashboard-subnav-link">Images</a>
        <a href="{{ route('admin.cms.posts.index') }}" class="dashboard-subnav-link">Blog Posts</a>
        <a href="{{ route('admin.cms.projects.index') }}" class="dashboard-subnav-link">Portfolio</a>
        <a href="{{ route('admin.cms.case-studies.index') }}" class="dashboard-subnav-link">Case Studies</a>
        <a href="{{ route('admin.cms.testimonials.index') }}" class="dashboard-subnav-link">Testimonials</a>
    </div>

    <div
        class="grid gap-6 xl:grid-cols-[1fr_0.84fr]"
        x-data="window.targetedMediaPicker(
            {
                light_logo: @js(old('light_logo', $profile['light_logo'] ?? '')),
                dark_logo: @js(old('dark_logo', $profile['dark_logo'] ?? '')),
                favicon: @js(old('favicon', $profile['favicon'] ?? ''))
            },
            {
                light_logo: 'Light logo',
                dark_logo: 'Dark logo',
                favicon: 'Favicon'
            },
            'light_logo'
        )"
    >
        @if (session('status'))
            <div class="xl:col-span-2 card mb-0 border border-green-200 bg-green-50 text-green-700">
                <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                    <div>
                        <div>{{ session('status') }}</div>
                        @if (session('uploaded_media_path'))
                            <div class="mt-1 text-xs text-green-700/80">{{ session('uploaded_media_name') }} • {{ session('uploaded_media_path') }}</div>
                        @endif
                    </div>
                    @if (session('uploaded_media_path'))
                        <button
                            type="button"
                            class="btn-primary shrink-0"
                            @click="assignAsset(@js(session('uploaded_media_path')))"
                        >
                            Use Current Upload
                        </button>
                    @endif
                </div>
            </div>
        @endif

        <div class="card">
            <div class="panel-title">Company Profile</div>
            <div class="panel-subtitle">Use public asset paths like <code>assets/legacy/weberse-light.svg</code> or full URLs for logos.</div>

            <form method="POST" action="{{ route('admin.cms.website-details.update') }}" class="mt-6 grid gap-4 md:grid-cols-2">
                @csrf
                @method('PATCH')

                <input class="input" name="name" value="{{ old('name', $profile['name'] ?? '') }}" placeholder="Company name" required>
                <input class="input" name="tagline" value="{{ old('tagline', $profile['tagline'] ?? '') }}" placeholder="Tagline">
                <input class="input" type="email" name="email" value="{{ old('email', $profile['email'] ?? '') }}" placeholder="Primary email">
                <input class="input" name="phone" value="{{ old('phone', $profile['phone'] ?? '') }}" placeholder="Primary phone">
                <input class="input" name="whatsapp" value="{{ old('whatsapp', $profile['whatsapp'] ?? '') }}" placeholder="WhatsApp number">
                <input class="input" name="skype" value="{{ old('skype', $profile['skype'] ?? '') }}" placeholder="Skype ID">
                <input class="input md:col-span-2" name="billing_url" value="{{ old('billing_url', $profile['billing_url'] ?? '') }}" placeholder="Billing / WHMCS URL">
                <div class="space-y-2">
                    <div class="flex items-center justify-between gap-3">
                        <span class="text-sm font-medium text-slate-700">Light logo</span>
                        <button
                            type="button"
                            class="dashboard-subnav-link px-3 py-1.5 text-xs"
                            :class="activeTarget === 'light_logo' && 'dashboard-subnav-link-active'"
                            @click="focusLibrary('light_logo')"
                        >
                            <span x-text="activeTarget === 'light_logo' ? 'Replacing now' : 'Replace current'"></span>
                        </button>
                    </div>
                    <input type="hidden" x-model="values.light_logo" name="light_logo" value="{{ old('light_logo', $profile['light_logo'] ?? '') }}">
                    <div class="rounded-[20px] border border-slate-200 bg-slate-50 px-4 py-3 text-xs text-slate-500" x-text="values.light_logo || 'No light logo selected'"></div>
                    <button type="button" class="btn-secondary px-4 py-2 text-xs" @click="focusLibrary('light_logo')">Choose from Media Library</button>
                </div>
                <div class="space-y-2">
                    <div class="flex items-center justify-between gap-3">
                        <span class="text-sm font-medium text-slate-700">Dark logo</span>
                        <button
                            type="button"
                            class="dashboard-subnav-link px-3 py-1.5 text-xs"
                            :class="activeTarget === 'dark_logo' && 'dashboard-subnav-link-active'"
                            @click="focusLibrary('dark_logo')"
                        >
                            <span x-text="activeTarget === 'dark_logo' ? 'Replacing now' : 'Replace current'"></span>
                        </button>
                    </div>
                    <input type="hidden" x-model="values.dark_logo" name="dark_logo" value="{{ old('dark_logo', $profile['dark_logo'] ?? '') }}">
                    <div class="rounded-[20px] border border-slate-200 bg-slate-50 px-4 py-3 text-xs text-slate-500" x-text="values.dark_logo || 'No dark logo selected'"></div>
                    <button type="button" class="btn-secondary px-4 py-2 text-xs" @click="focusLibrary('dark_logo')">Choose from Media Library</button>
                </div>
                <div class="space-y-2 md:col-span-2">
                    <div class="flex items-center justify-between gap-3">
                        <span class="text-sm font-medium text-slate-700">Favicon</span>
                        <button
                            type="button"
                            class="dashboard-subnav-link px-3 py-1.5 text-xs"
                            :class="activeTarget === 'favicon' && 'dashboard-subnav-link-active'"
                            @click="focusLibrary('favicon')"
                        >
                            <span x-text="activeTarget === 'favicon' ? 'Replacing now' : 'Replace current'"></span>
                        </button>
                    </div>
                    <input type="hidden" x-model="values.favicon" name="favicon" value="{{ old('favicon', $profile['favicon'] ?? '') }}">
                    <div class="rounded-[20px] border border-slate-200 bg-slate-50 px-4 py-3 text-xs text-slate-500" x-text="values.favicon || 'No favicon selected'"></div>
                    <button type="button" class="btn-secondary px-4 py-2 text-xs" @click="focusLibrary('favicon')">Choose from Media Library</button>
                </div>
                <input class="input md:col-span-2" name="location" value="{{ old('location', $profile['location'] ?? '') }}" placeholder="Short location">
                <input class="input md:col-span-2" name="address_line_1" value="{{ old('address_line_1', $profile['address_line_1'] ?? '') }}" placeholder="Address line 1">
                <input class="input md:col-span-2" name="address_line_2" value="{{ old('address_line_2', $profile['address_line_2'] ?? '') }}" placeholder="Address line 2">

                <div class="md:col-span-2 mt-2">
                    <div class="panel-title">Social Media</div>
                </div>
                <input class="input" name="socials[facebook]" value="{{ old('socials.facebook', $profile['socials']['facebook'] ?? '') }}" placeholder="Facebook URL">
                <input class="input" name="socials[instagram]" value="{{ old('socials.instagram', $profile['socials']['instagram'] ?? '') }}" placeholder="Instagram URL">
                <input class="input" name="socials[twitter]" value="{{ old('socials.twitter', $profile['socials']['twitter'] ?? '') }}" placeholder="Twitter URL">
                <input class="input" name="socials[linkedin]" value="{{ old('socials.linkedin', $profile['socials']['linkedin'] ?? '') }}" placeholder="LinkedIn URL">
                <input class="input md:col-span-2" name="socials[youtube]" value="{{ old('socials.youtube', $profile['socials']['youtube'] ?? '') }}" placeholder="YouTube URL">

                <div class="md:col-span-2">
                    <button class="btn-primary">Save Website Details</button>
                </div>
            </form>
        </div>

        <div class="space-y-6">
            <div class="card">
                <div class="panel-title">Logo Preview</div>
                <div class="panel-subtitle">Preview updates immediately as you pick media, before saving.</div>
                <div class="mt-6 space-y-4">
                    <div class="rounded-[24px] border border-slate-200 bg-[#081a2e] p-6">
                        <div class="text-xs uppercase tracking-[0.2em] text-slate-400">Light Logo</div>
                        <img
                            x-show="values.light_logo"
                            :src="resolveAsset(values.light_logo)"
                            alt="Light logo"
                            class="mt-4 h-12 w-auto"
                            x-cloak
                        >
                        <div x-show="!values.light_logo" class="mt-4 text-sm text-slate-500" x-cloak>No light logo selected.</div>
                    </div>
                    <div class="rounded-[24px] border border-slate-200 bg-white p-6">
                        <div class="text-xs uppercase tracking-[0.2em] text-slate-400">Dark Logo</div>
                        <img
                            x-show="values.dark_logo"
                            :src="resolveAsset(values.dark_logo)"
                            alt="Dark logo"
                            class="mt-4 h-12 w-auto"
                            x-cloak
                        >
                        <div x-show="!values.dark_logo" class="mt-4 text-sm text-slate-500" x-cloak>No dark logo selected.</div>
                    </div>
                    <div class="rounded-[24px] border border-slate-200 bg-slate-50 p-6">
                        <div class="text-xs uppercase tracking-[0.2em] text-slate-400">Favicon</div>
                        <div class="mt-4 flex items-center gap-4">
                            <img
                                x-show="values.favicon"
                                :src="resolveAsset(values.favicon)"
                                alt="Favicon"
                                class="h-10 w-10 rounded-xl border border-slate-200 bg-white object-contain p-1"
                                x-cloak
                            >
                            <div x-show="!values.favicon" class="text-sm text-slate-500" x-cloak>No favicon selected.</div>
                            <div class="min-w-0">
                                <div class="text-sm font-semibold text-slate-800">Current favicon path</div>
                                <div class="mt-1 break-all text-xs text-slate-500" x-text="values.favicon || 'Not set'"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="panel-title">Current Public Details</div>
                <div class="mt-6 space-y-3 text-sm text-slate-600">
                    <div><span class="font-semibold text-slate-800">Email:</span> {{ $profile['email'] ?? '—' }}</div>
                    <div><span class="font-semibold text-slate-800">Phone:</span> {{ $profile['phone'] ?? '—' }}</div>
                    <div><span class="font-semibold text-slate-800">WhatsApp:</span> {{ $profile['whatsapp'] ?? '—' }}</div>
                    <div><span class="font-semibold text-slate-800">Address:</span> {{ $profile['address_line_1'] ?? '—' }}{{ filled($profile['address_line_2'] ?? null) ? ', '.$profile['address_line_2'] : '' }}</div>
                    <div><span class="font-semibold text-slate-800">Location:</span> {{ $profile['location'] ?? '—' }}</div>
                </div>
            </div>

            <div class="card" x-ref="mediaLibrary">
                <div class="panel-title">Media Library</div>
                <div class="panel-subtitle">Upload logos or favicon files, then click any asset to assign it to the selected field.</div>

                <form method="POST" action="{{ route('admin.cms.website-details.media.upload') }}" enctype="multipart/form-data" class="mt-6 flex flex-col gap-3 sm:flex-row">
                    @csrf
                    <input class="input" type="file" name="media_file" accept=".png,.jpg,.jpeg,.webp,.svg,.ico" required>
                    <button class="btn-primary shrink-0">Upload Media</button>
                </form>

                <div class="mt-6 flex flex-wrap gap-2">
                    <button type="button" class="dashboard-subnav-link" :class="activeTarget === 'light_logo' && 'dashboard-subnav-link-active'" @click="focusLibrary('light_logo')">Assign to Light Logo</button>
                    <button type="button" class="dashboard-subnav-link" :class="activeTarget === 'dark_logo' && 'dashboard-subnav-link-active'" @click="focusLibrary('dark_logo')">Assign to Dark Logo</button>
                    <button type="button" class="dashboard-subnav-link" :class="activeTarget === 'favicon' && 'dashboard-subnav-link-active'" @click="focusLibrary('favicon')">Assign to Favicon</button>
                </div>

                <div class="mt-4 rounded-[20px] border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-500">
                    <div>Active target</div>
                    <div class="mt-1 font-semibold text-brand-blue" x-text="targetLabels[activeTarget]"></div>
                </div>

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
                        <div class="panel-subtitle">Choose a file for <span class="font-semibold text-brand-blue" x-text="targetLabels[activeTarget]"></span>.</div>
                    </div>
                    <button type="button" class="btn-dark px-4 py-2 text-xs" @click="libraryOpen = false">Close</button>
                </div>

                <form method="POST" action="{{ route('admin.cms.website-details.media.upload') }}" enctype="multipart/form-data" class="mt-6 flex flex-col gap-3 sm:flex-row">
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
