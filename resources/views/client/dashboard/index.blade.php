@extends('layouts.dashboard', [
    'title' => 'Client Dashboard',
    'heading' => 'Client Dashboard',
    'subheading' => 'Hosting, invoices, support, and shared documents.',
    'nav' => [
        ['label' => 'Overview', 'route' => 'client.dashboard', 'active' => 'client.dashboard'],
        ['label' => 'Hosting', 'route' => 'client.hosting.index', 'active' => 'client.hosting.*'],
        ['label' => 'Domains', 'route' => 'client.domains.index', 'active' => 'client.domains.*'],
        ['label' => 'Invoices', 'route' => 'client.invoices.index', 'active' => 'client.invoices.*'],
        ['label' => 'Downloads', 'route' => 'client.downloads.index', 'active' => 'client.downloads.*'],
        ['label' => 'Support', 'route' => 'client.support.index', 'active' => 'client.support.*'],
        ['label' => 'Documents', 'route' => 'client.documents.index', 'active' => 'client.documents.*'],
        ['label' => 'Profile', 'route' => 'client.profile.edit', 'active' => 'client.profile.*'],
    ],
])

@section('content')
    <div class="grid gap-6 md:grid-cols-3">
        <div class="metric-card">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <div class="metric-label">Active Services</div>
                    <div class="metric-value">{{ $hosting['summary']['active_services'] ?? 0 }}</div>
                </div>
                <div class="metric-icon">@include('website.partials.icon', ['name' => 'server'])</div>
            </div>
        </div>
        <div class="metric-card">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <div class="metric-label">Open Invoices</div>
                    <div class="metric-value">{{ $hosting['summary']['open_invoices'] ?? 0 }}</div>
                </div>
                <div class="metric-icon">@include('website.partials.icon', ['name' => 'receipt'])</div>
            </div>
        </div>
        <div class="metric-card">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <div class="metric-label">Domains</div>
                    <div class="metric-value">{{ $hosting['summary']['domains_count'] ?? 0 }}</div>
                </div>
                <div class="metric-icon">@include('website.partials.icon', ['name' => 'globe'])</div>
            </div>
        </div>
    </div>

    <div class="section-grid xl:grid-cols-[1.1fr_0.9fr]">
        <div class="card">
            <div class="panel-title">Recent Documents</div>
            <div class="panel-subtitle">Contracts and files shared with your account.</div>
            <div class="dashboard-list">
                @forelse($documents as $document)
                    <div class="dashboard-item">
                        <div>
                            <div class="font-semibold text-slate-800">{{ $document->title }}</div>
                            <div class="mt-1 text-slate-500">{{ $document->notes ?: 'Shared from Weberse' }}</div>
                        </div>
                        <div class="metric-icon h-10 w-10">@include('website.partials.icon', ['name' => 'file', 'class' => 'h-4 w-4'])</div>
                    </div>
                @empty
                    <div class="dashboard-item-soft text-sm text-slate-500">No shared documents available yet.</div>
                @endforelse
            </div>
        </div>
        <div class="card">
            <div class="panel-title">Account & Billing</div>
            <div class="panel-subtitle">Live billing and hosting information from WHMCS.</div>
            <div class="mt-6 grid gap-4 md:grid-cols-2">
                <div class="dashboard-item-soft">
                    <div class="text-xs uppercase tracking-[0.18em] text-slate-500">Client record</div>
                    <div class="mt-2 text-lg font-semibold text-brand-blue">{{ $hosting['client']['company_name'] ?? auth()->user()->name }}</div>
                    <div class="mt-1 text-sm text-slate-500">{{ $hosting['client']['email'] ?? auth()->user()->email }}</div>
                </div>
                <div class="dashboard-item-soft">
                    <div class="text-xs uppercase tracking-[0.18em] text-slate-500">Next invoice</div>
                    <div class="mt-2 text-lg font-semibold text-brand-blue">{{ $upcomingInvoice['total'] ?? 'No unpaid invoices' }}</div>
                    <div class="mt-1 text-sm text-slate-500">{{ $upcomingInvoice['due_date'] ?? 'Up to date' }}</div>
                </div>
            </div>
            <div class="mt-5 grid gap-3 sm:grid-cols-3">
                <a href="{{ route('client.hosting.index') }}" class="dashboard-item-soft block text-sm font-medium text-brand-blue">View Hosting</a>
                <a href="{{ route('client.domains.index') }}" class="dashboard-item-soft block text-sm font-medium text-brand-blue">View Domains</a>
                <a href="{{ route('client.invoices.index') }}" class="dashboard-item-soft block text-sm font-medium text-brand-blue">View Invoices</a>
            </div>
        </div>
        <div class="card">
            <div class="panel-title">Billing Handoff</div>
            <div class="panel-subtitle">Sensitive hosting and billing actions stay inside WHMCS.</div>
            <div class="mt-6 rounded-[24px] border border-slate-200 bg-slate-50/90 p-5">
                <div class="text-sm text-slate-600">Use the billing workspace for invoices, renewals, hosting credentials, and service changes.</div>
                <a href="{{ $hosting['sso_url'] ?? route('billing') }}" class="btn-primary mt-6">@include('website.partials.icon', ['name' => 'server', 'class' => 'h-4 w-4']) Open Billing Portal</a>
            </div>
        </div>
    </div>

    <div class="card mt-6">
        <div class="panel-title">Recent Tickets</div>
        <div class="panel-subtitle">Latest support activity on your account.</div>
        <div class="dashboard-list">
            @forelse($tickets as $ticket)
                <div class="dashboard-item">
                    <div>
                        <div class="font-semibold text-slate-800">{{ $ticket->subject }}</div>
                        <div class="mt-1 text-slate-500">{{ str($ticket->status)->replace('_', ' ')->title() }} • {{ ucfirst($ticket->priority) }}</div>
                    </div>
                    <a href="{{ route('client.support.index', ['ticket' => $ticket->id]) }}" class="btn-dark !px-4 !py-2 text-xs">Open</a>
                </div>
            @empty
                <div class="dashboard-item-soft text-sm text-slate-500">No support tickets yet.</div>
            @endforelse
        </div>
    </div>
@endsection
