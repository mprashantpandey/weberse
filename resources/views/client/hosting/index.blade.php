@extends('layouts.dashboard', [
    'title' => 'Hosting Services',
    'heading' => 'Hosting Services',
    'subheading' => 'WHMCS-linked products and service overview.',
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
    <div class="card">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <div class="panel-title">WHMCS Hosting Services</div>
                <div class="panel-subtitle">View synced products here and use the billing portal for sensitive service actions.</div>
            </div>
            <a href="{{ $hosting['sso_url'] ?? route('billing') }}" class="btn-primary">@include('website.partials.icon', ['name' => 'server', 'class' => 'h-4 w-4']) Open Billing Portal</a>
        </div>
    </div>
    <div class="dashboard-list">
        @forelse(($hosting['services'] ?? []) as $service)
            <div class="card">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <div class="text-xl font-semibold text-brand-blue">{{ $service['name'] ?? 'Service' }}</div>
                        <div class="mt-2 text-sm text-slate-500">Domain: {{ $service['domain'] ?? 'Not provided' }}</div>
                    </div>
                    <div class="status-badge">{{ $service['status'] ?? 'unknown' }}</div>
                </div>
            </div>
        @empty
            <div class="card text-sm text-slate-500">No hosting data available yet. Configure WHMCS API credentials to populate this panel.</div>
        @endforelse
    </div>
@endsection
