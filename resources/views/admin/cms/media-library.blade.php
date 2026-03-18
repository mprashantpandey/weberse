@extends('layouts.dashboard', [
    'title' => 'Media Library',
    'heading' => 'Media Library',
    'subheading' => 'Folders, tags, replacement, deletion, usage tracking, and optimized copies for frontend assets.',
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
        <a href="{{ route('admin.cms.media.index') }}" class="dashboard-subnav-link dashboard-subnav-link-active">Media Library</a>
        <a href="{{ route('admin.cms.posts.index') }}" class="dashboard-subnav-link">Blog Posts</a>
        <a href="{{ route('admin.cms.projects.index') }}" class="dashboard-subnav-link">Portfolio</a>
        <a href="{{ route('admin.cms.case-studies.index') }}" class="dashboard-subnav-link">Case Studies</a>
        <a href="{{ route('admin.cms.testimonials.index') }}" class="dashboard-subnav-link">Testimonials</a>
    </div>

    <div class="card mt-6">
        <form method="GET" class="grid gap-4 md:grid-cols-[1fr_220px_auto]">
            <input class="input" name="search" value="{{ $search }}" placeholder="Search by filename, path, or folder">
            <select class="input" name="folder">
                <option value="">All folders</option>
                @foreach ($folders as $folder)
                    <option value="{{ $folder }}" @selected($activeFolder === $folder)>{{ ucfirst($folder) }}</option>
                @endforeach
            </select>
            <button class="btn-primary">Filter</button>
        </form>
    </div>

    <div class="card mt-6 overflow-x-auto">
        <table class="dashboard-table">
            <thead>
                <tr>
                    <th>Asset</th>
                    <th>Folder / Tags</th>
                    <th>Usage</th>
                    <th>Optimization</th>
                    <th class="w-[320px]">Manage</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($assets as $asset)
                    <tr>
                        <td class="min-w-[260px]">
                            <div class="flex items-center gap-4">
                                <div class="flex h-16 w-20 items-center justify-center rounded-[18px] border border-slate-200 bg-slate-50 p-2">
                                    @if (in_array($asset->extension, ['svg', 'png', 'jpg', 'jpeg', 'webp']))
                                        <img src="{{ $asset->url }}" alt="{{ $asset->name }}" class="max-h-12 w-auto object-contain">
                                    @else
                                        <div class="text-xs font-semibold text-slate-500">{{ strtoupper($asset->extension) }}</div>
                                    @endif
                                </div>
                                <div>
                                    <div class="font-semibold text-slate-800">{{ $asset->name }}</div>
                                    <div class="mt-1 text-xs text-slate-500">{{ $asset->path }}</div>
                                    <div class="mt-1 text-xs text-slate-400">{{ $asset->mime_type ?: 'Unknown mime' }} @if($asset->size_bytes) · {{ number_format($asset->size_bytes / 1024, 1) }} KB @endif</div>
                                </div>
                            </div>
                        </td>
                        <td class="min-w-[220px]">
                            <form method="POST" action="{{ route('admin.cms.media.update', $asset) }}" class="space-y-3">
                                @csrf
                                @method('PATCH')
                                <input class="input" name="folder" value="{{ $asset->folder }}" placeholder="Folder" required>
                                <input class="input" name="tags" value="{{ implode(', ', $asset->tags ?? []) }}" placeholder="comma, separated, tags">
                                <button class="btn-dark px-4 py-2 text-xs">Save Meta</button>
                            </form>
                        </td>
                        <td class="min-w-[220px]">
                            <div class="font-semibold text-slate-800">{{ $asset->usage_count }} reference{{ $asset->usage_count === 1 ? '' : 's' }}</div>
                            <div class="mt-2 space-y-1 text-xs text-slate-500">
                                @forelse (collect($asset->usages)->take(3) as $usage)
                                    <div>{{ $usage['type'] }} · {{ $usage['label'] }}</div>
                                @empty
                                    <div>Unused</div>
                                @endforelse
                                @if ($asset->usage_count > 3)
                                    <div>+{{ $asset->usage_count - 3 }} more</div>
                                @endif
                            </div>
                        </td>
                        <td class="min-w-[220px]">
                            <div class="text-sm text-slate-700">{{ $asset->width ?: '—' }} × {{ $asset->height ?: '—' }}</div>
                            <div class="mt-2 text-xs text-slate-500">
                                @if ($asset->optimized_path)
                                    Optimized copy ready
                                @else
                                    No optimized copy
                                @endif
                            </div>
                            @if ($asset->optimized_url)
                                <a href="{{ $asset->optimized_url }}" target="_blank" class="mt-3 inline-flex text-xs font-medium text-brand-blue">View optimized</a>
                            @endif
                        </td>
                        <td class="min-w-[320px]">
                            <div class="space-y-3">
                                <form method="POST" action="{{ route('admin.cms.media.replace', $asset) }}" enctype="multipart/form-data" class="flex items-center gap-3">
                                    @csrf
                                    <input class="input" type="file" name="media_file" required>
                                    <button class="btn-primary px-4 py-2 text-xs">Replace</button>
                                </form>
                                <form method="POST" action="{{ route('admin.cms.media.destroy', $asset) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn-dark px-4 py-2 text-xs" @disabled($asset->usage_count > 0)>Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-sm text-slate-500">No media assets found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
