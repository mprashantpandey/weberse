@extends('layouts.dashboard', [
    'title' => 'Documents',
    'heading' => 'Documents',
    'subheading' => 'Shared files and contracts available to the client.',
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
        <div class="panel-title">Shared Documents</div>
        <div class="panel-subtitle">Contracts, agreements, and files shared with your Weberse account.</div>
    </div>
    <div class="dashboard-list">
        @foreach($documents as $document)
            <div class="card">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <div class="text-lg font-semibold text-brand-blue">{{ $document->title }}</div>
                        <div class="mt-2 text-sm text-slate-500">{{ $document->notes }}</div>
                    </div>
                    <div class="metric-icon h-10 w-10">@include('website.partials.icon', ['name' => 'file', 'class' => 'h-4 w-4'])</div>
                </div>
            </div>
        @endforeach
        <div>{{ $documents->links() }}</div>
    </div>
@endsection
