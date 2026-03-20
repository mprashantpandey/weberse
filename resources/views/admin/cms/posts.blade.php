@extends('layouts.dashboard', [
    'title' => 'CMS Blog Posts',
    'heading' => 'Blog Posts',
    'subheading' => 'Table-first list with dedicated editing for larger content.',
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
        <a href="{{ route('admin.cms.posts.index') }}" class="dashboard-subnav-link dashboard-subnav-link-active">Blog Posts</a>
        <a href="{{ route('admin.cms.projects.index') }}" class="dashboard-subnav-link">Portfolio</a>
        <a href="{{ route('admin.cms.testimonials.index') }}" class="dashboard-subnav-link">Testimonials</a>
    </div>

    <div class="card">
        <div class="flex items-center justify-between gap-4">
            <div>
                <div class="panel-title">All Blog Posts</div>
                <div class="panel-subtitle">Create and edit longer content on dedicated pages.</div>
            </div>
            <a href="{{ route('admin.cms.posts.create') }}" class="btn-primary">Create Post</a>
        </div>

        <div class="mt-6 overflow-x-auto">
            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Published</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($posts as $post)
                        <tr>
                            <td>
                                <div class="font-semibold text-slate-800">{{ $post->title }}</div>
                                <div class="mt-1 text-xs text-slate-500">{{ $post->excerpt }}</div>
                            </td>
                            <td>{{ $post->author?->name ?? '—' }}</td>
                            <td>{{ optional($post->published_at)->format('d M Y') ?: '—' }}</td>
                            <td><span class="status-badge">{{ $post->is_published ? 'Published' : 'Draft' }}</span></td>
                            <td class="text-right"><a href="{{ route('admin.cms.posts.edit', $post) }}" class="btn-dark px-4 py-2 text-xs">Manage</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
