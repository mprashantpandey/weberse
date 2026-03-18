@extends('layouts.dashboard', [
    'title' => 'Email Templates',
    'heading' => 'Email Templates',
    'subheading' => 'Use database-backed templates for HR communication, one-off emails, and newsletter content.',
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
        <a href="{{ route('admin.email.index') }}" class="dashboard-subnav-link">Overview</a>
        <a href="{{ route('admin.email.templates.index') }}" class="dashboard-subnav-link dashboard-subnav-link-active">Templates</a>
        <a href="{{ route('admin.email.subscribers.index') }}" class="dashboard-subnav-link">Subscribers</a>
        <a href="{{ route('admin.email.campaigns.index') }}" class="dashboard-subnav-link">Campaigns</a>
        <a href="{{ route('admin.email.compose') }}" class="dashboard-subnav-link">Compose</a>
    </div>

    <div class="card">
        <div class="flex items-center justify-between gap-4">
            <div>
                <div class="panel-title">Template Library</div>
                <div class="panel-subtitle">Use placeholders like <code>@{{name}}</code>, <code>@{{job_title}}</code>, <code>@{{candidate_name}}</code>, <code>@{{interview_date}}</code>, and <code>@{{meeting_link}}</code>.</div>
            </div>
            <a href="{{ route('admin.email.templates.create') }}" class="btn-primary">Create Template</a>
        </div>
        <div class="mt-6 overflow-x-auto">
            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Subject</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($templates as $template)
                        <tr>
                            <td>
                                <div class="font-semibold text-slate-800">{{ $template->name }}</div>
                                <div class="mt-1 text-xs text-slate-500">{{ $template->slug }}</div>
                            </td>
                            <td>{{ str($template->category)->replace('_', ' ')->title() }}</td>
                            <td>{{ $template->subject }}</td>
                            <td><span class="status-badge">{{ $template->is_active ? 'Active' : 'Inactive' }}</span></td>
                            <td class="text-right"><a href="{{ route('admin.email.templates.edit', $template) }}" class="btn-dark px-4 py-2 text-xs">Manage</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
