@extends('layouts.dashboard', [
    'title' => 'Order #'.$order->id,
    'heading' => 'Order #'.$order->id,
    'subheading' => 'Store purchase details and invoice.',
    'nav' => [
        ['label' => 'Overview', 'route' => 'admin.dashboard', 'active' => 'admin.dashboard'],
        ['label' => 'CMS', 'route' => 'admin.cms.index', 'active' => 'admin.cms.*'],
        ['label' => 'CRM', 'route' => 'admin.crm.index', 'active' => 'admin.crm.*'],
        ['label' => 'HRM', 'route' => 'admin.hrm.index', 'active' => 'admin.hrm.*'],
        ['label' => 'Support', 'route' => 'admin.support.index', 'active' => 'admin.support.*'],
        ['label' => 'Analytics', 'route' => 'admin.analytics.index', 'active' => 'admin.analytics.*'],
    ],
])

@section('content')
    <div class="section-grid xl:grid-cols-[1fr_0.9fr]">
        <div class="card">
            <div class="panel-title">Items</div>
            <div class="panel-subtitle">Purchased products in this order.</div>

            <div class="dashboard-list mt-6">
                @foreach($order->items as $item)
                    <div class="dashboard-item">
                        <div>
                            <div class="font-semibold text-slate-800">{{ $item->product_name_snapshot }}</div>
                            <div class="mt-1 text-slate-500">{{ $item->product_slug_snapshot }} @if($item->product_version_snapshot) • v{{ $item->product_version_snapshot }} @endif</div>
                        </div>
                        <div class="text-sm text-slate-700">
                            {{ $order->currency }} {{ number_format(($item->line_total_paise ?? 0) / 100, 2) }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="space-y-6">
            <div class="card">
                <div class="panel-title">Order</div>
                <div class="panel-subtitle">Payment and buyer metadata.</div>

                <div class="mt-6 grid gap-3">
                    <div class="dashboard-item-soft">
                        <div class="text-xs uppercase tracking-[0.18em] text-slate-500">Status</div>
                        <div class="mt-2 text-lg font-semibold text-brand-blue">{{ $order->status }}</div>
                    </div>
                    <div class="dashboard-item-soft">
                        <div class="text-xs uppercase tracking-[0.18em] text-slate-500">Buyer</div>
                        <div class="mt-2 text-lg font-semibold text-brand-blue">{{ $order->buyer_name ?: '—' }}</div>
                        <div class="mt-1 text-sm text-slate-500">{{ $order->buyer_email }}</div>
                    </div>
                    <div class="dashboard-item-soft">
                        <div class="text-xs uppercase tracking-[0.18em] text-slate-500">Total</div>
                        <div class="mt-2 text-lg font-semibold text-brand-blue">{{ $order->currency }} {{ number_format(($order->total_paise ?? 0) / 100, 2) }}</div>
                        <div class="mt-1 text-sm text-slate-500">Paid at: {{ $order->paid_at?->format('d M Y H:i') ?: '—' }}</div>
                    </div>
                    <div class="dashboard-item-soft">
                        <div class="text-xs uppercase tracking-[0.18em] text-slate-500">Razorpay IDs</div>
                        <div class="mt-2 text-sm text-slate-600">Order: {{ $order->provider_order_id ?: '—' }}</div>
                        <div class="mt-1 text-sm text-slate-600">Payment: {{ $order->provider_payment_id ?: '—' }}</div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="panel-title">Invoice</div>
                <div class="panel-subtitle">Automatically issued on successful payment.</div>

                @if($order->invoice)
                    <div class="dashboard-list mt-6">
                        <div class="dashboard-item">
                            <div>
                                <div class="font-semibold text-slate-800">Invoice #{{ $order->invoice->id }}</div>
                                <div class="mt-1 text-slate-500">{{ $order->invoice->buyer_email }}</div>
                            </div>
                            <div class="text-sm text-slate-700">{{ $order->invoice->currency }} {{ number_format(($order->invoice->total_paise ?? 0) / 100, 2) }}</div>
                        </div>
                        @foreach($order->invoice->items as $invItem)
                            <div class="dashboard-item">
                                <div class="text-slate-700">{{ $invItem->label }}</div>
                                <div class="text-sm text-slate-700">{{ $order->invoice->currency }} {{ number_format(($invItem->line_total_paise ?? 0) / 100, 2) }}</div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="mt-5 dashboard-item-soft text-sm text-slate-600">
                        No invoice yet (order not paid).
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

