@extends('layouts.dashboard', [
    'title' => 'Clients',
    'heading' => 'Client Management',
    'subheading' => 'Client accounts, WHMCS links, documents, and support visibility.',
    'nav' => [
        ['label' => 'Overview', 'route' => 'admin.dashboard', 'active' => 'admin.dashboard'],
        ['label' => 'Clients', 'route' => 'admin.clients.index', 'active' => 'admin.clients.*'],
        ['label' => 'CMS', 'route' => 'admin.cms.index', 'active' => 'admin.cms.*'],
        ['label' => 'CRM', 'route' => 'admin.crm.index', 'active' => 'admin.crm.*'],
        ['label' => 'HRM', 'route' => 'admin.hrm.index', 'active' => 'admin.hrm.*'],
        ['label' => 'Support', 'route' => 'admin.support.index', 'active' => 'admin.support.*'],
        ['label' => 'Analytics', 'route' => 'admin.analytics.index', 'active' => 'admin.analytics.*'],
    ],
])

@section('content')
    <div class="card">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <div class="panel-title">Client Accounts</div>
                <div class="panel-subtitle">Manage portal users and validate which accounts are linked to WHMCS.</div>
            </div>
            <a href="{{ route('admin.clients.create') }}" class="btn-primary">Add Client</a>
        </div>
    </div>

    <div class="card mt-6 overflow-x-auto">
        <table class="dashboard-table">
            <thead>
                <tr>
                    <th>Client</th>
                    <th>Phone</th>
                    <th>WHMCS ID</th>
                    <th>Tickets</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($clients as $client)
                    <tr>
                        <td>
                            <div class="font-semibold text-slate-800">{{ $client->name }}</div>
                            <div class="mt-1 text-xs text-slate-500">{{ $client->email }}</div>
                        </td>
                        <td>{{ $client->phone ?: '-' }}</td>
                        <td>{{ $client->whmcs_client_id ?: 'Not linked' }}</td>
                        <td>{{ $client->support_tickets_count }}</td>
                        <td><span class="status-badge">{{ $client->is_active ? 'Active' : 'Inactive' }}</span></td>
                        <td><a href="{{ route('admin.clients.show', $client) }}" class="btn-dark !px-4 !py-2 text-xs">Manage</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
