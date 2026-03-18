@extends('layouts.dashboard', [
    'title' => 'CMS Portfolio',
    'heading' => 'Portfolio Projects',
    'subheading' => 'Table-first project management with dedicated edit pages.',
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
        <a href="{{ route('admin.cms.posts.index') }}" class="dashboard-subnav-link">Blog Posts</a>
        <a href="{{ route('admin.cms.projects.index') }}" class="dashboard-subnav-link dashboard-subnav-link-active">Portfolio</a>
        <a href="{{ route('admin.cms.case-studies.index') }}" class="dashboard-subnav-link">Case Studies</a>
        <a href="{{ route('admin.cms.testimonials.index') }}" class="dashboard-subnav-link">Testimonials</a>
    </div>

    <div class="card">
        <div class="flex items-center justify-between gap-4">
            <div>
                <div class="panel-title">All Portfolio Projects</div>
                <div class="panel-subtitle">Create and edit project content on dedicated pages.</div>
            </div>
            <a href="{{ route('admin.cms.projects.create') }}" class="btn-primary">Create Project</a>
        </div>

        <div class="mt-6 overflow-x-auto">
            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th>Project</th>
                        <th>Client</th>
                        <th>Industry</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($projects as $project)
                        <tr>
                            <td>
                                <div class="font-semibold text-slate-800">{{ $project->title }}</div>
                                <div class="mt-1 text-xs text-slate-500">{{ $project->summary }}</div>
                            </td>
                            <td>{{ $project->client_name ?: '—' }}</td>
                            <td>{{ $project->industry ?: '—' }}</td>
                            <td><span class="status-badge">{{ $project->is_published ? 'Visible' : 'Hidden' }}</span></td>
                            <td class="text-right"><a href="{{ route('admin.cms.projects.edit', $project) }}" class="btn-dark px-4 py-2 text-xs">Manage</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
