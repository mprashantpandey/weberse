@extends('layouts.dashboard', [
    'title' => 'Store Orders',
    'heading' => 'Store Orders',
    'subheading' => 'Payments and purchase records for store products.',
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
    <div class="card">
        <div class="panel-title">Orders</div>
        <div class="panel-subtitle">Orders are marked paid via Razorpay webhook verification.</div>

        <div class="mt-6 overflow-x-auto">
            <table class="dashboard-table w-full" data-datatable>
                <thead>
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Order</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Buyer</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Total</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Created</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr class="border-t border-slate-200">
                            <td class="px-4 py-4">
                                <div class="font-semibold text-slate-800">#{{ $order->id }}</div>
                                <div class="mt-1 text-sm text-slate-500">{{ $order->provider_order_id ?: '—' }}</div>
                            </td>
                            <td class="px-4 py-4">
                                <div class="font-semibold text-slate-800">{{ $order->buyer_name ?: '—' }}</div>
                                <div class="mt-1 text-sm text-slate-500">{{ $order->buyer_email }}</div>
                            </td>
                            <td class="px-4 py-4">
                                <span class="status-badge">{{ $order->status }}</span>
                            </td>
                            <td class="px-4 py-4 text-sm text-slate-700">
                                {{ $order->currency }} {{ number_format(($order->total_paise ?? 0) / 100, 2) }}
                            </td>
                            <td class="px-4 py-4 text-sm text-slate-600">{{ $order->created_at?->format('d M Y') }}</td>
                            <td class="px-4 py-4 text-right">
                                <a href="{{ route('admin.store.orders.show', $order) }}" class="btn-dark !px-4 !py-2 text-xs">Open</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $orders->links() }}
        </div>
    </div>
@endsection

