@extends('layouts.dashboard', [
    'title' => 'Newsletter Campaigns',
    'heading' => 'Newsletter Campaigns',
    'subheading' => 'Create, edit, and send newsletter campaigns to active subscribers.',
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
        <a href="{{ route('admin.email.templates.index') }}" class="dashboard-subnav-link">Templates</a>
        <a href="{{ route('admin.email.subscribers.index') }}" class="dashboard-subnav-link">Subscribers</a>
        <a href="{{ route('admin.email.campaigns.index') }}" class="dashboard-subnav-link dashboard-subnav-link-active">Campaigns</a>
        <a href="{{ route('admin.email.compose') }}" class="dashboard-subnav-link">Compose</a>
    </div>

    <div class="card">
        <div class="flex items-center justify-between gap-4">
            <div>
                <div class="panel-title">Campaign Queue</div>
                <div class="panel-subtitle">Draft content on its own page, then trigger delivery from the list.</div>
            </div>
            <a href="{{ route('admin.email.campaigns.create') }}" class="btn-primary">Create Campaign</a>
        </div>
        <div class="mt-6 overflow-x-auto">
            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Template</th>
                        <th>Status</th>
                        <th>Sent</th>
                        <th>Delivered</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($campaigns as $campaign)
                        <tr>
                            <td>
                                <div class="font-semibold text-slate-800">{{ $campaign->title }}</div>
                                <div class="mt-1 text-xs text-slate-500">{{ $campaign->subject }}</div>
                            </td>
                            <td>{{ $campaign->template?->name ?: 'Custom' }}</td>
                            <td><span class="status-badge">{{ str($campaign->status)->replace('_', ' ')->title() }}</span></td>
                            <td>{{ $campaign->sent_at?->format('d M Y, h:i A') ?: '—' }}</td>
                            <td>{{ $campaign->sent_count }}</td>
                            <td class="text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.email.campaigns.edit', $campaign) }}" class="btn-dark px-4 py-2 text-xs">Manage</a>
                                    @if ($campaign->status !== 'sent')
                                        <form method="POST" action="{{ route('admin.email.campaigns.send', $campaign) }}">
                                            @csrf
                                            <button class="btn-primary px-4 py-2 text-xs">Send</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
