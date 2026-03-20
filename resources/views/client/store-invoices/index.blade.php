@extends('layouts.dashboard', [
    'title' => 'Store Invoices',
    'heading' => 'Store Invoices',
    'subheading' => 'Invoices for Weberse Store digital product purchases.',
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
    <div class="card">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <div class="panel-title">Weberse Store Invoices</div>
                <div class="panel-subtitle">Invoices for purchases made in the public store.</div>
            </div>
            <a href="{{ route('store.index') }}" class="btn-secondary">@include('website.partials.icon', ['name' => 'cart', 'class' => 'h-4 w-4']) Open Store</a>
        </div>
    </div>

    <div class="card mt-6 overflow-x-auto">
        <table class="dashboard-table w-full">
            <thead>
                <tr>
                    <th>Invoice</th>
                    <th>Issued</th>
                    <th>Status</th>
                    <th>Total</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($storeInvoices as $invoice)
                    <tr>
                        <td>
                            <div class="font-semibold text-slate-800">#{{ $invoice->id }}</div>
                            <div class="mt-1 text-xs text-slate-500">{{ $invoice->buyer_email }}</div>
                        </td>
                        <td>{{ $invoice->issued_at?->format('d M Y') ?? '-' }}</td>
                        <td><span class="status-badge">{{ $invoice->status }}</span></td>
                        <td>{{ $invoice->currency }} {{ number_format(($invoice->total_paise ?? 0) / 100, 2) }}</td>
                        <td class="text-right">
                            <a href="{{ route('client.store-invoices.show', $invoice) }}" class="btn-dark !px-4 !py-2 text-xs">Open</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-sm text-slate-500">No store invoices yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-10">{{ $storeInvoices->links() }}</div>
@endsection

