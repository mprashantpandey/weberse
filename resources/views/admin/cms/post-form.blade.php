@extends('layouts.dashboard', [
    'title' => $mode === 'create' ? 'Create Blog Post' : 'Edit Blog Post',
    'heading' => $mode === 'create' ? 'Create Blog Post' : 'Edit Blog Post',
    'subheading' => 'Long-form content should be managed on a dedicated page.',
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
    <div class="dashboard-subnav">
        <a href="{{ route('admin.cms.index') }}" class="dashboard-subnav-link">Overview</a>
        <a href="{{ route('admin.cms.website-details') }}" class="dashboard-subnav-link">Website Details</a>
        <a href="{{ route('admin.cms.images') }}" class="dashboard-subnav-link">Images</a>
        <a href="{{ route('admin.cms.posts.index') }}" class="dashboard-subnav-link dashboard-subnav-link-active">Blog Posts</a>
        <a href="{{ route('admin.cms.projects.index') }}" class="dashboard-subnav-link">Portfolio</a>
        <a href="{{ route('admin.cms.case-studies.index') }}" class="dashboard-subnav-link">Case Studies</a>
        <a href="{{ route('admin.cms.testimonials.index') }}" class="dashboard-subnav-link">Testimonials</a>
    </div>

    <div class="grid gap-6 xl:grid-cols-[1fr_0.82fr]" x-data="window.singleMediaPicker(@js(old('cover_image', $post->cover_image)))">
        <div class="card">
            <div class="panel-title">{{ $mode === 'create' ? 'New Blog Post' : 'Manage Blog Post' }}</div>
            <form method="POST" action="{{ $mode === 'create' ? route('admin.cms.posts.store') : route('admin.cms.posts.update', $post) }}" class="mt-6 grid gap-4">
            @csrf
            @if($mode === 'edit')
                @method('PATCH')
            @endif
                <input class="input" name="title" value="{{ old('title', $post->title) }}" placeholder="Post title" required>
                <input type="hidden" name="cover_image" x-model="selectedImage">
                <textarea class="input min-h-24" name="excerpt" placeholder="Excerpt">{{ old('excerpt', $post->excerpt) }}</textarea>
                <textarea class="input min-h-56" name="body" placeholder="Body content">{{ old('body', $post->body) }}</textarea>
                <input class="input" name="seo_title" value="{{ old('seo_title', $post->seo_title) }}" placeholder="SEO title">
                <textarea class="input min-h-24" name="seo_description" placeholder="SEO description">{{ old('seo_description', $post->seo_description) }}</textarea>
                <label class="flex items-center gap-3 text-sm text-slate-700"><input type="checkbox" name="is_published" value="1" @checked(old('is_published', $post->is_published))> Published</label>
                <div class="flex gap-3">
                    <button class="btn-primary">{{ $mode === 'create' ? 'Create Post' : 'Save Changes' }}</button>
                    <a href="{{ route('admin.cms.posts.index') }}" class="btn-dark">Back to Posts</a>
                </div>
            </form>
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
                <div class="panel-title">Cover Image</div>
                <div class="panel-subtitle">Upload or pick a managed image instead of pasting a public path.</div>
                <div class="mt-6 flex h-52 items-center justify-center rounded-[24px] border border-slate-200 bg-slate-50 p-4">
                    <img x-show="selectedImage" :src="resolveAsset(selectedImage)" alt="Cover preview" class="max-h-44 w-auto rounded-[20px] object-contain" x-cloak>
                    <div x-show="!selectedImage" class="text-sm text-slate-500" x-cloak>No cover image selected.</div>
                </div>
                <div class="mt-3 break-all text-xs text-slate-500" x-text="selectedImage || 'No cover image selected'"></div>
                <button type="button" class="btn-secondary mt-4 px-4 py-2 text-xs" @click="focusLibrary()">Choose from Media Library</button>
            </div>

            <div class="card">
                <div class="panel-title">Upload Media</div>
                <form method="POST" action="{{ route('admin.cms.media.upload') }}" enctype="multipart/form-data" class="mt-6 flex flex-col gap-3 sm:flex-row">
                    @csrf
                    <input class="input" type="file" name="media_file" accept=".png,.jpg,.jpeg,.webp,.svg,.ico" required>
                    <button class="btn-primary shrink-0">Upload Media</button>
                </form>
            </div>

            <div class="card" x-ref="mediaLibrary">
                <div class="panel-title">Media Library</div>
                <div class="panel-subtitle">Click an asset to assign it to this blog post.</div>
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
                        <div class="panel-subtitle">Choose a cover image for this blog post.</div>
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
                        <button type="button" class="rounded-[24px] border border-slate-200 bg-slate-50 p-4 text-left transition hover:border-brand-green/30 hover:bg-brand-surface/70" @click="selectedImage = @js($asset['path']); libraryOpen = false">
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
