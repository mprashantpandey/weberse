@extends('layouts.dashboard', [
    'title' => 'Store Invoice #'.$invoice->id,
    'heading' => 'Store Invoice #'.$invoice->id,
    'subheading' => 'Invoice for Weberse Store purchase.',
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
    <div class="section-grid xl:grid-cols-[1fr_0.9fr]">
        <div class="card">
            <div class="panel-title">Line items</div>
            <div class="panel-subtitle">Products included in this invoice.</div>

            <div class="dashboard-list mt-6">
                @foreach($invoice->items as $item)
                    <div class="dashboard-item">
                        <div class="min-w-0">
                            <div class="font-semibold text-slate-800">{{ $item->label }}</div>
                            <div class="mt-1 text-slate-500">Qty {{ $item->qty }}</div>
                        </div>
                        <div class="text-sm text-slate-700">
                            {{ $invoice->currency }} {{ number_format(($item->line_total_paise ?? 0) / 100, 2) }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="space-y-6">
            <div class="card">
                <div class="panel-title">Invoice</div>
                <div class="panel-subtitle">Billing details for this purchase.</div>

                <div class="mt-6 grid gap-3">
                    <div class="dashboard-item-soft">
                        <div class="text-xs uppercase tracking-[0.18em] text-slate-500">Status</div>
                        <div class="mt-2 text-lg font-semibold text-brand-blue">{{ $invoice->status }}</div>
                    </div>
                    <div class="dashboard-item-soft">
                        <div class="text-xs uppercase tracking-[0.18em] text-slate-500">Issued</div>
                        <div class="mt-2 text-lg font-semibold text-brand-blue">{{ $invoice->issued_at?->format('d M Y') ?? '-' }}</div>
                        <div class="mt-1 text-sm text-slate-500">{{ $invoice->buyer_email }}</div>
                    </div>
                    <div class="dashboard-item-soft">
                        <div class="text-xs uppercase tracking-[0.18em] text-slate-500">Total</div>
                        <div class="mt-2 text-lg font-semibold text-brand-blue">{{ $invoice->currency }} {{ number_format(($invoice->total_paise ?? 0) / 100, 2) }}</div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="panel-title">Next</div>
                <div class="panel-subtitle">Access your purchased files.</div>
                <div class="mt-5 space-y-3">
                    <a href="{{ route('client.store-invoices.download', $invoice) }}" class="btn-secondary w-full justify-center">
                        @include('website.partials.icon', ['name' => 'receipt', 'class' => 'h-4 w-4'])
                        Download invoice
                    </a>
                    <a href="{{ route('client.downloads.index') }}" class="btn-primary w-full justify-center">
                        @include('website.partials.icon', ['name' => 'download', 'class' => 'h-4 w-4'])
                        Go to downloads
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

