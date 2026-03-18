@extends('layouts.dashboard', [
    'title' => 'Hosting Services',
    'heading' => 'Hosting Services',
    'subheading' => 'WHMCS-linked products and service overview.',
    'nav' => [
        ['label' => 'Overview', 'route' => 'client.dashboard', 'active' => 'client.dashboard'],
        ['label' => 'Hosting', 'route' => 'client.hosting.index', 'active' => 'client.hosting.*'],
        ['label' => 'Domains', 'route' => 'client.domains.index', 'active' => 'client.domains.*'],
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
                <div class="panel-subtitle">View synced hosting products, billing cycle, and due dates. Sensitive service actions still stay in WHMCS.</div>
            </div>
            <a href="{{ route('client.billing.portal') }}" class="btn-primary">@include('website.partials.icon', ['name' => 'server', 'class' => 'h-4 w-4']) Open Billing Portal</a>
        </div>
    </div>
    <div class="card mt-6 overflow-x-auto">
        <table class="dashboard-table">
            <thead>
                <tr>
                    <th>Service</th>
                    <th>Domain</th>
                    <th>Billing Cycle</th>
                    <th>Amount</th>
                    <th>Next Due</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
        @forelse(($hosting['services'] ?? []) as $service)
            <tr>
                <td>
                    <div class="font-semibold text-slate-800">{{ $service['name'] ?? 'Service' }}</div>
                    <div class="mt-1 text-xs text-slate-500">{{ $service['group_name'] ?? 'Hosting' }}</div>
                </td>
                <td>{{ $service['domain'] ?? 'Not linked' }}</td>
                <td>{{ $service['billing_cycle'] ?? '-' }}</td>
                <td>{{ $service['amount'] ?? '-' }}</td>
                <td>{{ $service['next_due_date'] ?? '-' }}</td>
                <td><span class="status-badge">{{ $service['status'] ?? 'unknown' }}</span></td>
                <td class="text-right">
                    @if (!empty($service['id']))
                        <a href="{{ route('client.billing.service', $service['id']) }}" class="btn-dark px-4 py-2 text-xs">Manage</a>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-sm text-slate-500">No hosting data available yet. Configure WHMCS API credentials to populate this panel.</td>
            </tr>
        @endforelse
            </tbody>
        </table>
    </div>
@endsection
