@extends('layouts.dashboard', [
    'title' => 'Store Entitlements',
    'heading' => 'Store Entitlements',
    'subheading' => 'Who owns which products (download access).',
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
        <div class="panel-title">Entitlements</div>
        <div class="panel-subtitle">Entitlements are created when an order is marked paid.</div>

        <div class="mt-6 overflow-x-auto">
            <table class="dashboard-table w-full" data-datatable>
                <thead>
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">User</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Product</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Order</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Granted</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($entitlements as $entitlement)
                        <tr class="border-t border-slate-200">
                            <td class="px-4 py-4">
                                <div class="font-semibold text-slate-800">{{ $entitlement->user?->name ?? '—' }}</div>
                                <div class="mt-1 text-sm text-slate-500">{{ $entitlement->user?->email ?? '—' }}</div>
                            </td>
                            <td class="px-4 py-4">
                                <div class="font-semibold text-slate-800">{{ $entitlement->product?->name ?? '—' }}</div>
                                <div class="mt-1 text-sm text-slate-500">{{ $entitlement->product?->slug ?? '—' }}</div>
                            </td>
                            <td class="px-4 py-4 text-sm text-slate-700">
                                <a class="text-brand-blue underline" href="{{ route('admin.store.orders.show', $entitlement->order_id) }}">#{{ $entitlement->order_id }}</a>
                            </td>
                            <td class="px-4 py-4 text-sm text-slate-600">{{ $entitlement->granted_at?->format('d M Y') }}</td>
                            <td class="px-4 py-4">
                                <span class="status-badge">{{ $entitlement->revoked_at ? 'revoked' : 'active' }}</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $entitlements->links() }}
        </div>
    </div>
@endsection

