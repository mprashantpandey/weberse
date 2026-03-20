@extends('layouts.dashboard', [
    'title' => $client->name,
    'heading' => 'Client Detail',
    'subheading' => 'Portal identity, documents, support history, and WHMCS-linked billing visibility.',
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
    @if (session('status'))
        <div class="card mb-6 border border-green-200 bg-green-50 text-green-700">{{ session('status') }}</div>
    @endif

    <div class="grid gap-6 xl:grid-cols-[1.1fr_0.9fr]">
        <div class="card">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <div class="panel-title">{{ $client->name }}</div>
                    <div class="panel-subtitle">{{ $client->email }} · {{ $client->phone ?: 'No phone set' }}</div>
                </div>
                <a href="{{ route('admin.clients.edit', $client) }}" class="btn-primary">Edit Client</a>
            </div>
            <div class="mt-6 grid gap-4 md:grid-cols-2">
                <div class="info-pair"><div class="info-label">WHMCS Client ID</div><div class="info-value">{{ $client->whmcs_client_id ?: 'Not linked' }}</div></div>
                <div class="info-pair"><div class="info-label">Status</div><div class="info-value">{{ $client->is_active ? 'Active' : 'Inactive' }}</div></div>
                <div class="info-pair"><div class="info-label">Last Login</div><div class="info-value">{{ optional($client->last_login_at)->format('d M Y, h:i A') ?: 'Never' }}</div></div>
                <div class="info-pair"><div class="info-label">Support Tickets</div><div class="info-value">{{ $client->support_tickets_count }}</div></div>
            </div>
        </div>

        <div class="card">
            <div class="panel-title">WHMCS Summary</div>
            <div class="panel-subtitle">Billing-linked account visibility for this client.</div>
            @if ($whmcsSummary)
                <div class="mt-6 grid gap-3 sm:grid-cols-2">
                    <div class="dashboard-item-soft"><div class="text-xs uppercase tracking-[0.18em] text-slate-500">Services</div><div class="mt-2 text-xl font-semibold text-brand-blue">{{ $whmcsSummary['summary']['services_count'] }}</div></div>
                    <div class="dashboard-item-soft"><div class="text-xs uppercase tracking-[0.18em] text-slate-500">Open Invoices</div><div class="mt-2 text-xl font-semibold text-brand-blue">{{ $whmcsSummary['summary']['open_invoices'] }}</div></div>
                    <div class="dashboard-item-soft"><div class="text-xs uppercase tracking-[0.18em] text-slate-500">Domains</div><div class="mt-2 text-xl font-semibold text-brand-blue">{{ $whmcsSummary['summary']['domains_count'] }}</div></div>
                    <div class="dashboard-item-soft"><div class="text-xs uppercase tracking-[0.18em] text-slate-500">WHMCS Status</div><div class="mt-2 text-xl font-semibold text-brand-blue">{{ $whmcsSummary['client']['status'] ?? 'Linked' }}</div></div>
                </div>
            @else
                <div class="dashboard-item-soft mt-6 text-sm text-slate-500">No WHMCS link is configured for this client account.</div>
            @endif
        </div>
    </div>

    <div class="grid gap-6 mt-6 xl:grid-cols-[1fr_1fr]">
        <div class="card">
            <div class="panel-title">Shared Documents</div>
            <div class="panel-subtitle">Files currently available in the client portal.</div>
            <div class="dashboard-list mt-6">
                @forelse($documents as $document)
                    <div class="dashboard-item">
                        <div>
                            <div class="font-semibold text-slate-800">{{ $document->title }}</div>
                            <div class="mt-1 text-slate-500">{{ $document->notes ?: 'Shared from Weberse' }}</div>
                        </div>
                        <div class="status-badge">{{ ucfirst($document->visibility) }}</div>
                    </div>
                @empty
                    <div class="dashboard-item-soft text-sm text-slate-500">No documents have been shared yet.</div>
                @endforelse
            </div>

            <form method="POST" action="{{ route('admin.clients.documents.store', $client) }}" enctype="multipart/form-data" class="mt-6 grid gap-4 md:grid-cols-2">
                @csrf
                <input class="input md:col-span-2" name="title" placeholder="Document title" required>
                <select class="input" name="visibility">
                    <option value="client">Client</option>
                    <option value="internal">Internal</option>
                </select>
                <input class="input" type="file" name="file">
                <textarea class="input md:col-span-2 min-h-28" name="notes" placeholder="Notes"></textarea>
                <div class="md:col-span-2"><button class="btn-primary">Add Document</button></div>
            </form>
        </div>

        <div class="card">
            <div class="panel-title">Recent Support Activity</div>
            <div class="panel-subtitle">Latest tickets raised by this client.</div>
            <div class="dashboard-list mt-6">
                @forelse($tickets as $ticket)
                    <div class="dashboard-item">
                        <div>
                            <div class="font-semibold text-slate-800">{{ $ticket->subject }}</div>
                            <div class="mt-1 text-slate-500">{{ $ticket->department?->name }} · {{ ucfirst($ticket->priority) }} · {{ str($ticket->status)->replace('_', ' ')->title() }}</div>
                        </div>
                        <div class="status-badge">{{ $ticket->assignee?->name ?: 'Unassigned' }}</div>
                    </div>
                @empty
                    <div class="dashboard-item-soft text-sm text-slate-500">No tickets from this client yet.</div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
