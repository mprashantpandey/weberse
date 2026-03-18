@extends('layouts.dashboard', [
    'title' => 'Profile',
    'heading' => 'Profile Settings',
    'subheading' => 'Core account details for the logged-in client.',
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
    <div class="card max-w-4xl">
        <div class="panel-title">Account Snapshot</div>
        <div class="panel-subtitle">Primary identity details currently available in the platform.</div>
        <div class="mt-6 grid gap-4 md:grid-cols-2">
            <div class="info-pair">
                <div class="info-label">Name</div>
                <div class="info-value">{{ $user->name }}</div>
            </div>
            <div class="info-pair">
                <div class="info-label">Email</div>
                <div class="info-value">{{ $user->email }}</div>
            </div>
            <div class="info-pair">
                <div class="info-label">Phone</div>
                <div class="info-value">{{ $user->phone ?: 'Not set' }}</div>
            </div>
            <div class="info-pair">
                <div class="info-label">WHMCS Client ID</div>
                <div class="info-value">{{ $user->whmcs_client_id ?: 'Not linked' }}</div>
            </div>
        </div>
    </div>
@endsection
