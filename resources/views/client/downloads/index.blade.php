@extends('layouts.dashboard', [
    'title' => 'Downloads',
    'heading' => 'Downloads',
    'subheading' => 'Your purchased digital products and files.',
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
        <div class="panel-title">Your purchases</div>
        <div class="panel-subtitle">Download the latest available file for each product.</div>

        <div class="dashboard-list mt-6">
            @forelse($entitlements as $entitlement)
                @php
                    $product = $entitlement->product;
                    $file = ($product?->files?->firstWhere('is_primary', true)) ?: ($product?->files?->sortByDesc('id')->first());
                @endphp
                <div class="dashboard-item">
                    <div class="min-w-0">
                        <div class="flex flex-wrap items-center gap-3">
                            <div class="font-semibold text-slate-800">{{ $product?->name ?? 'Product' }}</div>
                            @if ($file?->version)
                                <span class="status-badge">v{{ $file->version }}</span>
                            @endif
                        </div>
                        <div class="mt-1 text-slate-500">
                            Purchased {{ optional($entitlement->granted_at)->format('d M Y') }}
                            @if ($file?->original_name)
                                • File: {{ $file->original_name }}
                            @endif
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        @if ($file)
                            <a href="{{ route('client.downloads.download', $entitlement) }}" class="btn-primary !px-4 !py-2 text-xs">
                                @include('website.partials.icon', ['name' => 'download', 'class' => 'h-4 w-4'])
                                Download
                            </a>
                        @else
                            <span class="text-sm text-slate-500">No file attached yet</span>
                        @endif
                    </div>
                </div>
            @empty
                <div class="dashboard-item-soft text-sm text-slate-500">
                    No purchases yet. Once you buy a product, it will appear here.
                </div>
            @endforelse
        </div>
    </div>
@endsection

