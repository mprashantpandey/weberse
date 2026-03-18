@extends('layouts.dashboard', [
    'title' => 'Admin Dashboard',
    'heading' => 'Admin Dashboard',
    'subheading' => 'Overview of leads, support, and WHMCS-linked sales.',
    'nav' => [
        ['label' => 'Overview', 'route' => 'admin.dashboard', 'active' => 'admin.dashboard'],
        ['label' => 'CMS', 'route' => 'admin.cms.index', 'active' => 'admin.cms.*'],
        ['label' => 'CRM', 'route' => 'admin.crm.index', 'active' => 'admin.crm.*'],
        ['label' => 'HRM', 'route' => 'admin.hrm.index', 'active' => 'admin.hrm.*'],
        ['label' => 'Support', 'route' => 'admin.support.index', 'active' => 'admin.support.*'],
        ['label' => 'Analytics', 'route' => 'admin.analytics.index', 'active' => 'admin.analytics.*'],
    ],
])

@section('quick_actions')
    <div class="grid gap-3 md:grid-cols-2 xl:grid-cols-4">
        <a href="{{ route('admin.crm.leads.create') }}"
           class="group flex items-center justify-between gap-4 rounded-[22px] border border-slate-200 bg-slate-50/90 px-4 py-4 text-left transition duration-300 hover:-translate-y-[1px] hover:border-[rgba(115,182,85,0.18)] hover:bg-[rgba(115,182,85,0.06)]">
            <span class="inline-flex h-11 w-11 items-center justify-center rounded-2xl text-brand-blue shadow-[inset_0_0_0_1px_rgba(115,182,85,0.14)]"
                  style="background: linear-gradient(135deg, rgba(115,182,85,0.16), rgba(13,47,80,0.08));">
                @include('website.partials.icon', ['name' => 'sparkles', 'class' => 'h-5 w-5'])
            </span>
            <span class="flex min-w-0 flex-1 flex-col">
                <span class="truncate text-sm font-semibold text-brand-blue">New Lead</span>
                <span class="mt-1 truncate text-xs text-slate-500">Capture a pipeline opportunity</span>
            </span>
            <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-slate-200 bg-white/90 text-brand-blue opacity-70 transition duration-300 group-hover:translate-x-[2px] group-hover:border-[rgba(115,182,85,0.24)] group-hover:bg-[rgba(115,182,85,0.10)] group-hover:opacity-100">
                @include('website.partials.icon', ['name' => 'arrow-right', 'class' => 'h-4 w-4'])
            </span>
        </a>

        <a href="{{ route('admin.support.index') }}"
           class="group flex items-center justify-between gap-4 rounded-[22px] border border-slate-200 bg-slate-50/90 px-4 py-4 text-left transition duration-300 hover:-translate-y-[1px] hover:border-[rgba(115,182,85,0.18)] hover:bg-[rgba(115,182,85,0.06)]">
            <span class="inline-flex h-11 w-11 items-center justify-center rounded-2xl text-brand-blue shadow-[inset_0_0_0_1px_rgba(115,182,85,0.14)]"
                  style="background: linear-gradient(135deg, rgba(115,182,85,0.16), rgba(13,47,80,0.08));">
                @include('website.partials.icon', ['name' => 'ticket', 'class' => 'h-5 w-5'])
            </span>
            <span class="flex min-w-0 flex-1 flex-col">
                <span class="truncate text-sm font-semibold text-brand-blue">Support Queue</span>
                <span class="mt-1 truncate text-xs text-slate-500">View tickets & reply fast</span>
            </span>
            <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-slate-200 bg-white/90 text-brand-blue opacity-70 transition duration-300 group-hover:translate-x-[2px] group-hover:border-[rgba(115,182,85,0.24)] group-hover:bg-[rgba(115,182,85,0.10)] group-hover:opacity-100">
                @include('website.partials.icon', ['name' => 'arrow-right', 'class' => 'h-4 w-4'])
            </span>
        </a>

        <a href="{{ route('admin.crm.leads.index') }}"
           class="group flex items-center justify-between gap-4 rounded-[22px] border border-slate-200 bg-slate-50/90 px-4 py-4 text-left transition duration-300 hover:-translate-y-[1px] hover:border-[rgba(115,182,85,0.18)] hover:bg-[rgba(115,182,85,0.06)]">
            <span class="inline-flex h-11 w-11 items-center justify-center rounded-2xl text-brand-blue shadow-[inset_0_0_0_1px_rgba(115,182,85,0.14)]"
                  style="background: linear-gradient(135deg, rgba(115,182,85,0.16), rgba(13,47,80,0.08));">
                @include('website.partials.icon', ['name' => 'users', 'class' => 'h-5 w-5'])
            </span>
            <span class="flex min-w-0 flex-1 flex-col">
                <span class="truncate text-sm font-semibold text-brand-blue">Pipeline</span>
                <span class="mt-1 truncate text-xs text-slate-500">Track and update stages</span>
            </span>
            <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-slate-200 bg-white/90 text-brand-blue opacity-70 transition duration-300 group-hover:translate-x-[2px] group-hover:border-[rgba(115,182,85,0.24)] group-hover:bg-[rgba(115,182,85,0.10)] group-hover:opacity-100">
                @include('website.partials.icon', ['name' => 'arrow-right', 'class' => 'h-4 w-4'])
            </span>
        </a>

        <a href="{{ route('admin.analytics.index') }}"
           class="group flex items-center justify-between gap-4 rounded-[22px] border border-slate-200 bg-slate-50/90 px-4 py-4 text-left transition duration-300 hover:-translate-y-[1px] hover:border-[rgba(115,182,85,0.18)] hover:bg-[rgba(115,182,85,0.06)]">
            <span class="inline-flex h-11 w-11 items-center justify-center rounded-2xl text-brand-blue shadow-[inset_0_0_0_1px_rgba(115,182,85,0.14)]"
                  style="background: linear-gradient(135deg, rgba(115,182,85,0.16), rgba(13,47,80,0.08));">
                @include('website.partials.icon', ['name' => 'chart', 'class' => 'h-5 w-5'])
            </span>
            <span class="flex min-w-0 flex-1 flex-col">
                <span class="truncate text-sm font-semibold text-brand-blue">Analytics</span>
                <span class="mt-1 truncate text-xs text-slate-500">View trends & performance</span>
            </span>
            <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-slate-200 bg-white/90 text-brand-blue opacity-70 transition duration-300 group-hover:translate-x-[2px] group-hover:border-[rgba(115,182,85,0.24)] group-hover:bg-[rgba(115,182,85,0.10)] group-hover:opacity-100">
                @include('website.partials.icon', ['name' => 'arrow-right', 'class' => 'h-4 w-4'])
            </span>
        </a>
    </div>
@endsection

@section('content')
    <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
        <div class="metric-card">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <div class="metric-label">Leads</div>
                    <div class="metric-value">{{ $summary['lead_count'] }}</div>
                </div>
                <div class="metric-icon">@include('website.partials.icon', ['name' => 'users'])</div>
            </div>
        </div>
        <div class="metric-card">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <div class="metric-label">Open Tickets</div>
                    <div class="metric-value">{{ $summary['open_tickets'] }}</div>
                </div>
                <div class="metric-icon">@include('website.partials.icon', ['name' => 'ticket'])</div>
            </div>
        </div>
        <div class="metric-card">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <div class="metric-label">Pipeline Stages</div>
                    <div class="metric-value">{{ count($summary['lead_funnel']) }}</div>
                </div>
                <div class="metric-icon">@include('website.partials.icon', ['name' => 'chart'])</div>
            </div>
        </div>
        <div class="metric-card">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <div class="metric-label">WHMCS Orders</div>
                    <div class="metric-value">{{ $summary['whmcs_sales']['total_results'] ?? 0 }}</div>
                </div>
                <div class="metric-icon">@include('website.partials.icon', ['name' => 'receipt'])</div>
            </div>
        </div>
    </div>

    <div class="section-grid xl:grid-cols-[1.1fr_0.9fr]">
        <div class="card">
            <div class="panel-title">Lead Funnel</div>
            <div class="panel-subtitle">Current opportunity distribution across the sales pipeline.</div>
            <div class="dashboard-chart mt-6">
                <canvas id="leadFunnelChart"></canvas>
            </div>
        </div>
        <div class="card">
            <div class="panel-title">Recent WHMCS Orders</div>
            <div class="panel-subtitle">Latest billing-side order activity synced from WHMCS.</div>
            <div class="dashboard-list">
                @forelse (($summary['whmcs_sales']['recent_orders'] ?? []) as $order)
                    <div class="dashboard-item">
                        <div>
                            <div class="font-semibold text-slate-800">Order #{{ $order['id'] ?? '-' }}</div>
                            <div class="mt-1 text-slate-500">{{ $order['paymentmethod'] ?? 'Billing portal' }}</div>
                        </div>
                        <div class="status-badge">{{ $order['status'] ?? 'unknown' }}</div>
                    </div>
                @empty
                    <div class="dashboard-item-soft text-sm text-slate-500">WHMCS metrics will appear once credentials are configured.</div>
                @endforelse
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const canvas = document.getElementById('leadFunnelChart');
            if (!canvas || !window.Chart) return;
            new window.Chart(canvas, {
                type: 'bar',
                data: {
                    labels: JSON.parse('{!! json_encode(array_keys($summary["lead_funnel"])) !!}'),
                    datasets: [{
                        label: 'Leads',
                        data: JSON.parse('{!! json_encode(array_values($summary["lead_funnel"])) !!}'),
                        backgroundColor: '#73B655',
                        borderRadius: 12,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        x: { grid: { display: false } },
                        y: { beginAtZero: true, ticks: { precision: 0 } }
                    }
                }
            });
        });
    </script>
@endsection
