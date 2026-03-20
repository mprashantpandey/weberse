@extends('layouts.dashboard', [
    'title' => 'Email Center',
    'heading' => 'Email Center',
    'subheading' => 'Templates, newsletter operations, and one-off sending from one backend workspace.',
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
        <a href="{{ route('admin.email.index') }}" class="dashboard-subnav-link dashboard-subnav-link-active">Overview</a>
        <a href="{{ route('admin.email.templates.index') }}" class="dashboard-subnav-link">Templates</a>
        <a href="{{ route('admin.email.subscribers.index') }}" class="dashboard-subnav-link">Subscribers</a>
        <a href="{{ route('admin.email.campaigns.index') }}" class="dashboard-subnav-link">Campaigns</a>
        <a href="{{ route('admin.email.compose') }}" class="dashboard-subnav-link">Compose</a>
    </div>

    <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
        <div class="metric-card"><div class="metric-label">Templates</div><div class="metric-value">{{ $summary['templates'] }}</div></div>
        <div class="metric-card"><div class="metric-label">Active Subscribers</div><div class="metric-value">{{ $summary['subscribers'] }}</div></div>
        <div class="metric-card"><div class="metric-label">Campaigns</div><div class="metric-value">{{ $summary['campaigns'] }}</div></div>
        <div class="metric-card"><div class="metric-label">Sent Emails</div><div class="metric-value">{{ $summary['sent'] }}</div></div>
    </div>

    <div class="section-grid mt-6 xl:grid-cols-[1fr_1fr]">
        <div class="card">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <div class="panel-title">Recent Campaigns</div>
                    <div class="panel-subtitle">Newsletter campaigns and their delivery status.</div>
                </div>
                <a href="{{ route('admin.email.campaigns.index') }}" class="btn-dark">Open Campaigns</a>
            </div>
            <div class="dashboard-list">
                @forelse ($recentCampaigns as $campaign)
                    <div class="dashboard-item">
                        <div>
                            <div class="font-semibold text-slate-800">{{ $campaign->title }}</div>
                            <div class="mt-1 text-slate-500">{{ $campaign->subject }}</div>
                        </div>
                        <div class="status-badge">{{ str($campaign->status)->replace('_', ' ')->title() }}</div>
                    </div>
                @empty
                    <div class="dashboard-item-soft text-sm text-slate-500">No campaigns created yet.</div>
                @endforelse
            </div>
        </div>

        <div class="card">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <div class="panel-title">Recent Deliveries</div>
                    <div class="panel-subtitle">Single sends, HR notifications, and newsletter dispatch logs.</div>
                </div>
                <a href="{{ route('admin.email.compose') }}" class="btn-primary">Send Email</a>
            </div>
            <div class="dashboard-list">
                @forelse ($recentEmails as $email)
                    <div class="dashboard-item">
                        <div>
                            <div class="font-semibold text-slate-800">{{ $email->recipient_email }}</div>
                            <div class="mt-1 text-slate-500">{{ $email->subject }}</div>
                        </div>
                        <div class="status-badge">{{ str($email->status)->replace('_', ' ')->title() }}</div>
                    </div>
                @empty
                    <div class="dashboard-item-soft text-sm text-slate-500">No outbound emails logged yet.</div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
