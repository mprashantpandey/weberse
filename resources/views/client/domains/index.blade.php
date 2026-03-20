@extends('layouts.dashboard', [
    'title' => 'Domains',
    'heading' => 'Domains',
    'subheading' => 'Registered domains and renewal visibility from WHMCS.',
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
                <div class="panel-title">WHMCS Domain Records</div>
                <div class="panel-subtitle">Domain lifecycle visibility stays here, while DNS and registrar actions remain in the billing portal.</div>
            </div>
            <a href="{{ route('client.billing.portal') }}" class="btn-primary">@include('website.partials.icon', ['name' => 'globe', 'class' => 'h-4 w-4']) Open Billing Portal</a>
        </div>
    </div>

    <div class="card mt-6 overflow-x-auto">
        <table class="dashboard-table">
            <thead>
                <tr>
                    <th>Domain</th>
                    <th>Registration</th>
                    <th>Next Due</th>
                    <th>Expiry</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($domains as $domain)
                    <tr>
                        <td class="font-semibold text-slate-800">{{ $domain['domain'] ?? '-' }}</td>
                        <td>{{ $domain['registration_date'] ?? '-' }}</td>
                        <td>{{ $domain['next_due_date'] ?? '-' }}</td>
                        <td>{{ $domain['expiry_date'] ?? '-' }}</td>
                        <td><span class="status-badge">{{ $domain['status'] ?? 'unknown' }}</span></td>
                        <td class="text-right">
                            @if (!empty($domain['id']))
                                <a href="{{ route('client.billing.domain', $domain['id']) }}" class="btn-dark px-4 py-2 text-xs">Manage</a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-sm text-slate-500">No domain data available yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
