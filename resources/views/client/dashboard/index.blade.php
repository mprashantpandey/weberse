@extends('layouts.dashboard', [
    'title' => 'Client Dashboard',
    'heading' => 'Client Dashboard',
    'subheading' => 'Hosting, invoices, support, and shared documents.',
    'nav' => [
        ['label' => 'Overview', 'route' => 'client.dashboard', 'active' => 'client.dashboard'],
        ['label' => 'Hosting', 'route' => 'client.hosting.index', 'active' => 'client.hosting.*'],
        ['label' => 'Invoices', 'route' => 'client.invoices.index', 'active' => 'client.invoices.*'],
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
                    <div class="metric-label">Hosting Services</div>
                    <div class="metric-value">{{ count($hosting['services'] ?? []) }}</div>
                </div>
                <div class="metric-icon">@include('website.partials.icon', ['name' => 'server'])</div>
            </div>
        </div>
        <div class="metric-card">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <div class="metric-label">Invoices</div>
                    <div class="metric-value">{{ count($hosting['invoices'] ?? []) }}</div>
                </div>
                <div class="metric-icon">@include('website.partials.icon', ['name' => 'receipt'])</div>
            </div>
        </div>
        <div class="metric-card">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <div class="metric-label">Recent Tickets</div>
                    <div class="metric-value">{{ $tickets->count() }}</div>
                </div>
                <div class="metric-icon">@include('website.partials.icon', ['name' => 'ticket'])</div>
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
            <div class="panel-title">Billing Handoff</div>
            <div class="panel-subtitle">Sensitive hosting and billing actions stay inside WHMCS.</div>
            <div class="mt-6 rounded-[24px] border border-slate-200 bg-slate-50/90 p-5">
                <div class="text-sm text-slate-600">Use the billing workspace for invoices, renewals, hosting credentials, and service changes.</div>
                <a href="{{ $hosting['sso_url'] ?? route('billing') }}" class="btn-primary mt-6">@include('website.partials.icon', ['name' => 'server', 'class' => 'h-4 w-4']) Open Billing Portal</a>
            </div>
        </div>
    </div>
@endsection
