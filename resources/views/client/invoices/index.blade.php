@extends('layouts.dashboard', [
    'title' => 'Invoices',
    'heading' => 'Invoices',
    'subheading' => 'WHMCS billing invoices plus Weberse Store invoices.',
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
                <div class="panel-title">Invoices</div>
                <div class="panel-subtitle">Hosting/billing invoices from WHMCS and purchases from the Weberse Store.</div>
            </div>
            <a href="{{ route('client.billing.portal') }}" class="btn-primary">@include('website.partials.icon', ['name' => 'receipt', 'class' => 'h-4 w-4']) Open Billing Portal</a>
        </div>
    </div>
    <div class="card mt-6 overflow-x-auto">
        <table class="dashboard-table">
            <thead>
                <tr>
                    <th>Invoice</th>
                    <th>Date</th>
                    <th>Source</th>
                    <th>Total / Method</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
        @forelse($invoices as $invoice)
            <tr>
                <td>
                    <div class="font-semibold text-slate-800">#{{ $invoice['number'] ?? $invoice['id'] ?? '-' }}</div>
                    @if (!empty($invoice['due_date']))
                        <div class="mt-1 text-xs text-slate-500">Due {{ $invoice['due_date'] }}</div>
                    @endif
                </td>
                <td>{{ $invoice['date'] ?? '-' }}</td>
                <td>
                    <span class="status-badge">
                        {{ $invoice['source'] === 'Store' ? 'Store' : 'WHMCS' }}
                    </span>
                </td>
                <td>
                    <div class="font-semibold text-slate-800">
                        {{ $invoice['total'] ?? 'Unavailable' }}
                    </div>
                    <div class="mt-1 text-xs text-slate-500">
                        {{ $invoice['payment_method'] ?? '-' }}
                    </div>
                </td>
                <td><span class="status-badge">{{ $invoice['status'] ?? 'unknown' }}</span></td>
                <td class="text-right">
                    @if (!empty($invoice['link']) && $invoice['source'] === 'Store')
                        <a href="{{ $invoice['link'] }}" class="btn-dark px-4 py-2 text-xs">Open</a>
                    @elseif (!empty($invoice['id']) && $invoice['source'] === 'WHMCS')
                        <a href="{{ route('client.billing.invoice', $invoice['id']) }}" class="btn-dark px-4 py-2 text-xs">Open</a>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-sm text-slate-500">No invoice data available yet.</td>
            </tr>
        @endforelse
            </tbody>
        </table>
    </div>
@endsection
