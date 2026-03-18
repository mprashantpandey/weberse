@extends('layouts.dashboard', [
    'title' => 'Invoices',
    'heading' => 'Invoices',
    'subheading' => 'Invoice summary synced from WHMCS.',
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
                <div class="panel-title">Invoice Summary</div>
                <div class="panel-subtitle">Synced invoice records from WHMCS. Payments and downloads stay in the billing portal.</div>
            </div>
            <a href="{{ route('billing') }}" class="btn-primary">@include('website.partials.icon', ['name' => 'receipt', 'class' => 'h-4 w-4']) Open Billing Portal</a>
        </div>
    </div>
    <div class="dashboard-list">
        @forelse($invoices as $invoice)
            <div class="card">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <div class="text-lg font-semibold text-brand-blue">Invoice #{{ $invoice['id'] ?? '-' }}</div>
                        <div class="mt-2 text-sm text-slate-500">Total: {{ $invoice['total'] ?? ($invoice['amount'] ?? 'Unavailable') }}</div>
                    </div>
                    <div class="status-badge">{{ $invoice['status'] ?? 'unknown' }}</div>
                </div>
            </div>
        @empty
            <div class="card text-sm text-slate-500">No invoice data available yet.</div>
        @endforelse
    </div>
@endsection
