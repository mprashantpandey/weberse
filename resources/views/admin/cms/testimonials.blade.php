@extends('layouts.dashboard', [
    'title' => 'CMS Testimonials',
    'heading' => 'Testimonials',
    'subheading' => 'Small records are easier to manage through table + modal editing.',
    'nav' => [
        ['label' => 'Overview', 'route' => 'admin.dashboard', 'active' => 'admin.dashboard'],
        ['label' => 'CMS', 'route' => 'admin.cms.index', 'active' => 'admin.cms.*'],
        ['label' => 'CRM', 'route' => 'admin.crm.index', 'active' => 'admin.crm.*'],
        ['label' => 'HRM', 'route' => 'admin.hrm.index', 'active' => 'admin.hrm.*'],
        ['label' => 'Support', 'route' => 'admin.support.index', 'active' => 'admin.support.*'],
        ['label' => 'Analytics', 'route' => 'admin.analytics.index', 'active' => 'admin.analytics.*'],
    ],
])

@section('content')
    @if (session('status'))
        <div class="card mb-6 border border-green-200 bg-green-50 text-green-700">{{ session('status') }}</div>
    @endif

    <div class="dashboard-subnav">
        <a href="{{ route('admin.cms.index') }}" class="dashboard-subnav-link">Overview</a>
        <a href="{{ route('admin.cms.website-details') }}" class="dashboard-subnav-link">Website Details</a>
        <a href="{{ route('admin.cms.images') }}" class="dashboard-subnav-link">Images</a>
        <a href="{{ route('admin.cms.media.index') }}" class="dashboard-subnav-link">Media Library</a>
        <a href="{{ route('admin.cms.posts.index') }}" class="dashboard-subnav-link">Blog Posts</a>
        <a href="{{ route('admin.cms.projects.index') }}" class="dashboard-subnav-link">Portfolio</a>
        <a href="{{ route('admin.cms.case-studies.index') }}" class="dashboard-subnav-link">Case Studies</a>
        <a href="{{ route('admin.cms.testimonials.index') }}" class="dashboard-subnav-link dashboard-subnav-link-active">Testimonials</a>
    </div>

    <div class="grid gap-6 xl:grid-cols-[1fr_0.82fr]" x-data="{
        ...targetedMediaPicker(
            {
                create: '',
                @foreach($testimonials as $item)
                    '{{ $item->id }}': @js($item->avatar),
                @endforeach
            },
            {
                create: 'Create Testimonial',
                @foreach($testimonials as $item)
                    '{{ $item->id }}': 'Edit Testimonial #{{ $item->id }}',
                @endforeach
            },
            'create'
        ),
        createOpen: false,
        activeEdit: null,
    }">
    <div class="card card-modal-host">
        <div class="flex items-center justify-between gap-4">
            <div>
                <div class="panel-title">Testimonials</div>
                <div class="panel-subtitle">Create and edit short social-proof records in modal dialogs.</div>
            </div>
            <button type="button" class="btn-primary" @click="createOpen = true">Create Testimonial</button>
        </div>

        <div class="mt-6 overflow-x-auto">
            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Company</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($testimonials as $item)
                        <tr>
                            <td>
                                <div class="font-semibold text-slate-800">{{ $item->name }}</div>
                                <div class="mt-1 text-xs text-slate-500">{{ \Illuminate\Support\Str::limit($item->quote, 90) }}</div>
                            </td>
                            <td>{{ $item->company ?: '—' }}</td>
                            <td><span class="status-badge">{{ $item->is_published ? 'Live' : 'Draft' }}</span></td>
                            <td class="text-right">
                                <button type="button" class="btn-dark px-4 py-2 text-xs" @click="activeEdit = {{ $item->id }}">Edit</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div x-show="createOpen" x-cloak class="dashboard-modal-backdrop" @click.self="createOpen = false">
            <div class="dashboard-modal-card">
                <div class="flex items-center justify-between gap-4">
                    <div class="panel-title">Create Testimonial</div>
                    <button type="button" class="btn-dark px-4 py-2 text-xs" @click="createOpen = false">Close</button>
                </div>
                <form method="POST" action="{{ route('admin.cms.testimonials.store') }}" class="mt-6 grid gap-4">
                    @csrf
                    <input class="input" name="name" placeholder="Client name" required>
                    <input class="input" name="company" placeholder="Company">
                    <input type="hidden" name="avatar" x-model="values.create">
                    <div class="rounded-[20px] border border-slate-200 bg-slate-50 p-4">
                        <div class="text-xs uppercase tracking-[0.2em] text-slate-400">Avatar</div>
                        <div class="mt-4 flex h-28 items-center justify-center rounded-[18px] border border-slate-200 bg-white p-3">
                            <img x-show="values.create" :src="resolveAsset(values.create)" alt="Avatar preview" class="max-h-20 w-auto rounded-full object-cover" x-cloak>
                            <div x-show="!values.create" class="text-sm text-slate-500" x-cloak>No avatar selected.</div>
                        </div>
                        <button type="button" class="btn-secondary mt-4 px-4 py-2 text-xs" @click="focusLibrary('create')">Choose Avatar</button>
                    </div>
                    <textarea class="input min-h-36" name="quote" placeholder="Client quote" required></textarea>
                    <label class="flex items-center gap-3 text-sm text-slate-700"><input type="checkbox" name="is_published" value="1" checked> Published</label>
                    <div class="flex gap-3">
                        <button class="btn-primary">Create Testimonial</button>
                        <button type="button" class="btn-dark" @click="createOpen = false">Cancel</button>
                    </div>
                </form>
            </div>
        </div>

        @foreach($testimonials as $item)
            <div x-show="activeEdit === {{ $item->id }}" x-cloak class="dashboard-modal-backdrop" @click.self="activeEdit = null">
                <div class="dashboard-modal-card">
                    <div class="flex items-center justify-between gap-4">
                        <div class="panel-title">Edit Testimonial</div>
                        <button type="button" class="btn-dark px-4 py-2 text-xs" @click="activeEdit = null">Close</button>
                    </div>
                    <form method="POST" action="{{ route('admin.cms.testimonials.update', $item) }}" class="mt-6 grid gap-4">
                        @csrf
                        @method('PATCH')
                        <input class="input" name="name" value="{{ $item->name }}" required>
                        <input class="input" name="company" value="{{ $item->company }}" placeholder="Company">
                        <input type="hidden" name="avatar" x-model="values['{{ $item->id }}']">
                        <div class="rounded-[20px] border border-slate-200 bg-slate-50 p-4">
                            <div class="text-xs uppercase tracking-[0.2em] text-slate-400">Avatar</div>
                            <div class="mt-4 flex h-28 items-center justify-center rounded-[18px] border border-slate-200 bg-white p-3">
                                <img x-show="values['{{ $item->id }}']" :src="resolveAsset(values['{{ $item->id }}'])" alt="Avatar preview" class="max-h-20 w-auto rounded-full object-cover" x-cloak>
                                <div x-show="!values['{{ $item->id }}']" class="text-sm text-slate-500" x-cloak>No avatar selected.</div>
                            </div>
                            <button type="button" class="btn-secondary mt-4 px-4 py-2 text-xs" @click="focusLibrary('{{ $item->id }}')">Choose Avatar</button>
                        </div>
                        <textarea class="input min-h-36" name="quote" required>{{ $item->quote }}</textarea>
                        <label class="flex items-center gap-3 text-sm text-slate-700"><input type="checkbox" name="is_published" value="1" @checked($item->is_published)> Published</label>
                        <div class="flex gap-3">
                            <button class="btn-primary">Save Changes</button>
                            <button type="button" class="btn-dark" @click="activeEdit = null">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        @endforeach
    </div>

    <div class="space-y-6">
        @if (session('uploaded_media_path'))
            <div class="card border border-green-200 bg-green-50 text-green-700">
                <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                    <div>
                        <div>{{ session('status') }}</div>
                        <div class="mt-1 text-xs text-green-700/80">{{ session('uploaded_media_name') }} • {{ session('uploaded_media_path') }}</div>
                    </div>
                    <button type="button" class="btn-primary shrink-0" @click="assignAsset(@js(session('uploaded_media_path')))">Use Current Upload</button>
                </div>
            </div>
        @endif

        <div class="card">
            <div class="panel-title">Upload Media</div>
            <div class="panel-subtitle">Upload an avatar once, then assign it to the active testimonial modal.</div>
            <form method="POST" action="{{ route('admin.cms.media.upload') }}" enctype="multipart/form-data" class="mt-6 flex flex-col gap-3 sm:flex-row">
                @csrf
                <input class="input" type="file" name="media_file" accept=".png,.jpg,.jpeg,.webp,.svg,.ico" required>
                <button class="btn-primary shrink-0">Upload Media</button>
            </form>
            <div class="mt-4 text-sm text-slate-500">
                Active target:
                <span class="font-semibold text-brand-blue" x-text="targetLabels[activeTarget]"></span>
            </div>
        </div>

        <div class="card" x-ref="mediaLibrary">
            <div class="panel-title">Media Library</div>
            <div class="panel-subtitle">Click any image to assign it to the active testimonial.</div>
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
                    <div class="panel-subtitle">Choose an avatar for <span class="font-semibold text-brand-blue" x-text="targetLabels[activeTarget]"></span>.</div>
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
