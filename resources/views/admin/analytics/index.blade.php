@extends('layouts.dashboard', [
    'title' => 'Analytics',
    'heading' => 'Analytics',
    'subheading' => 'Operational metrics across lead generation, support load, and billing activity.',
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
    <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
        <div class="metric-card">
            <div class="metric-label">Lead Volume</div>
            <div class="metric-value">{{ $summary['lead_count'] }}</div>
        </div>
        <div class="metric-card">
            <div class="metric-label">Open Tickets</div>
            <div class="metric-value">{{ $summary['open_tickets'] }}</div>
        </div>
        <div class="metric-card">
            <div class="metric-label">Pipeline Stages</div>
            <div class="metric-value">{{ count($summary['lead_funnel']) }}</div>
        </div>
        <div class="metric-card">
            <div class="metric-label">Recent Orders</div>
            <div class="metric-value">{{ $summary['whmcs_sales']['total_results'] ?? 0 }}</div>
        </div>
    </div>

    <div class="section-grid lg:grid-cols-2">
        <div class="card">
            <div class="panel-title">Lead Funnel Breakdown</div>
            <div class="dashboard-list">
                @foreach($summary['lead_funnel'] as $stage => $count)
                    <div class="dashboard-item">
                        <div class="font-semibold text-slate-800">{{ str($stage)->replace('_', ' ')->title() }}</div>
                        <div class="status-badge">{{ $count }}</div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="card">
            <div class="panel-title">Recent Billing Orders</div>
            <div class="dashboard-list">
                @forelse (($summary['whmcs_sales']['recent_orders'] ?? []) as $order)
                    <div class="dashboard-item">
                        <div>
                            <div class="font-semibold text-slate-800">Order #{{ $order['id'] ?? '-' }}</div>
                            <div class="mt-1 text-slate-500">{{ $order['paymentmethod'] ?? 'WHMCS' }}</div>
                        </div>
                        <div class="status-badge">{{ $order['status'] ?? 'unknown' }}</div>
                    </div>
                @empty
                    <div class="dashboard-item-soft text-sm text-slate-500">No billing analytics available yet.</div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
