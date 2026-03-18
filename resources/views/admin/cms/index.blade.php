@extends('layouts.dashboard', [
    'title' => 'CMS',
    'heading' => 'CMS Overview',
    'subheading' => 'Manage public-facing content through cleaner dedicated workspaces.',
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
        <a href="{{ route('admin.cms.index') }}" class="dashboard-subnav-link dashboard-subnav-link-active">Overview</a>
        <a href="{{ route('admin.cms.website-details') }}" class="dashboard-subnav-link">Website Details</a>
        <a href="{{ route('admin.cms.images') }}" class="dashboard-subnav-link">Images</a>
        <a href="{{ route('admin.cms.posts.index') }}" class="dashboard-subnav-link">Blog Posts</a>
        <a href="{{ route('admin.cms.projects.index') }}" class="dashboard-subnav-link">Portfolio</a>
        <a href="{{ route('admin.cms.case-studies.index') }}" class="dashboard-subnav-link">Case Studies</a>
        <a href="{{ route('admin.cms.testimonials.index') }}" class="dashboard-subnav-link">Testimonials</a>
    </div>

    <div class="grid gap-6 md:grid-cols-6">
        <div class="metric-card"><div class="metric-label">Website Details</div><div class="metric-value">{{ $summary['website_details'] }}</div></div>
        <div class="metric-card"><div class="metric-label">Website Images</div><div class="metric-value">{{ $summary['website_images'] }}</div></div>
        <div class="metric-card"><div class="metric-label">Posts</div><div class="metric-value">{{ $summary['posts'] }}</div></div>
        <div class="metric-card"><div class="metric-label">Projects</div><div class="metric-value">{{ $summary['projects'] }}</div></div>
        <div class="metric-card"><div class="metric-label">Case Studies</div><div class="metric-value">{{ $summary['case_studies'] }}</div></div>
        <div class="metric-card"><div class="metric-label">Testimonials</div><div class="metric-value">{{ $summary['testimonials'] }}</div></div>
    </div>

    <div class="section-grid mt-6 xl:grid-cols-2">
        <div class="card">
            <div class="panel-title">Recent Blog Posts</div>
            <div class="dashboard-list">
                @foreach($latestPosts as $item)
                    <div class="dashboard-item">
                        <div>
                            <div class="font-semibold text-slate-800">{{ $item->title }}</div>
                            <div class="mt-1 text-slate-500">{{ $item->excerpt }}</div>
                        </div>
                        <div class="status-badge">{{ $item->is_published ? 'Published' : 'Draft' }}</div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="card">
            <div class="panel-title">Recent Portfolio Projects</div>
            <div class="dashboard-list">
                @foreach($latestProjects as $item)
                    <div class="dashboard-item">
                        <div>
                            <div class="font-semibold text-slate-800">{{ $item->title }}</div>
                            <div class="mt-1 text-slate-500">{{ $item->industry }}</div>
                        </div>
                        <div class="status-badge">{{ $item->is_published ? 'Visible' : 'Hidden' }}</div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="card">
            <div class="panel-title">Recent Case Studies</div>
            <div class="dashboard-list">
                @foreach($latestCaseStudies as $item)
                    <div class="dashboard-item">
                        <div>
                            <div class="font-semibold text-slate-800">{{ $item->title }}</div>
                            <div class="mt-1 text-slate-500">{{ $item->client }}</div>
                        </div>
                        <div class="status-badge">{{ $item->is_published ? 'Visible' : 'Hidden' }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
