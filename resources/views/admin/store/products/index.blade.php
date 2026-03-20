@extends('layouts.dashboard', [
    'title' => 'Store Products',
    'heading' => 'Store Products',
    'subheading' => 'Manage Weberse digital products and files.',
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
    @if (session('status'))
        <div class="card mb-6 border border-green-200 bg-green-50 text-green-700">
            {{ session('status') }}
        </div>
    @endif

    <div class="card">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <div class="panel-title">Products</div>
                <div class="panel-subtitle">Published products can be purchased via the store checkout.</div>
            </div>
            <a href="{{ route('admin.store.products.create') }}" class="btn-primary">
                @include('website.partials.icon', ['name' => 'sparkles', 'class' => 'h-4 w-4'])
                New product
            </a>
        </div>

        <div class="mt-6 overflow-x-auto">
            <table class="dashboard-table w-full" data-datatable>
                <thead>
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Name</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Price</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Updated</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr class="border-t border-slate-200">
                            <td class="px-4 py-4">
                                <div class="font-semibold text-slate-800">{{ $product->name }}</div>
                                <div class="mt-1 text-sm text-slate-500">{{ $product->slug }}</div>
                            </td>
                            <td class="px-4 py-4">
                                <span class="status-badge">{{ $product->status }}</span>
                            </td>
                            <td class="px-4 py-4 text-sm text-slate-700">
                                {{ $product->currency }} {{ number_format(($product->price_paise ?? 0) / 100, 2) }}
                            </td>
                            <td class="px-4 py-4 text-sm text-slate-600">{{ $product->updated_at?->format('d M Y') }}</td>
                            <td class="px-4 py-4 text-right">
                                <a href="{{ route('admin.store.products.edit', $product) }}" class="btn-dark !px-4 !py-2 text-xs">Edit</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $products->links() }}
        </div>
    </div>
@endsection

