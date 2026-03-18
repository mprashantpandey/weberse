@extends('layouts.dashboard', [
    'title' => 'Documents',
    'heading' => 'Documents',
    'subheading' => 'Shared files and contracts available to the client.',
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
        <div class="panel-title">Shared Documents</div>
        <div class="panel-subtitle">Contracts, agreements, and files shared with your Weberse account.</div>
    </div>
    <div class="card mt-6 overflow-x-auto">
        <table class="dashboard-table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Visibility</th>
                    <th>Notes</th>
                    <th>File</th>
                </tr>
            </thead>
            <tbody>
                @forelse($documents as $document)
                    <tr>
                        <td class="font-semibold text-slate-800">{{ $document->title }}</td>
                        <td><span class="status-badge">{{ ucfirst($document->visibility) }}</span></td>
                        <td>{{ $document->notes ?: 'Shared from Weberse' }}</td>
                        <td>
                            @if ($document->file_path)
                                <span class="text-xs text-slate-500">{{ $document->file_path }}</span>
                            @else
                                <span class="text-xs text-slate-400">No file attached</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-sm text-slate-500">No shared documents available yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $documents->links() }}</div>
@endsection
