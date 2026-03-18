@extends('layouts.dashboard', [
    'title' => 'Profile',
    'heading' => 'Profile Settings',
    'subheading' => 'Core account details for the logged-in client.',
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
    @if (session('status'))
        <div class="card mb-6 border border-green-200 bg-green-50 text-green-700">{{ session('status') }}</div>
    @endif

    <div class="card max-w-4xl">
        <div class="panel-title">Account Details</div>
        <div class="panel-subtitle">Update the core contact details tied to your client workspace.</div>
        <form method="POST" action="{{ route('client.profile.update') }}" class="mt-6 grid gap-4 md:grid-cols-2">
            @csrf
            @method('PATCH')
            <label class="block">
                <span class="text-sm font-medium text-slate-700">Name</span>
                <input class="input mt-2" name="name" value="{{ old('name', $user->name) }}" required>
            </label>
            <label class="block">
                <span class="text-sm font-medium text-slate-700">Email</span>
                <input class="input mt-2 bg-slate-50" value="{{ $user->email }}" disabled>
            </label>
            <label class="block">
                <span class="text-sm font-medium text-slate-700">Phone</span>
                <input class="input mt-2" name="phone" value="{{ old('phone', $user->phone) }}">
            </label>
            <label class="block">
                <span class="text-sm font-medium text-slate-700">Title / Context</span>
                <input class="input mt-2" name="job_title" value="{{ old('job_title', $user->job_title) }}" placeholder="Founder, Ops Lead, Billing Contact">
            </label>
            <div class="dashboard-item-soft md:col-span-2">
                <div>
                    <div class="text-xs uppercase tracking-[0.18em] text-slate-500">WHMCS Client ID</div>
                    <div class="mt-2 text-lg font-semibold text-brand-blue">{{ $user->whmcs_client_id ?: 'Not linked' }}</div>
                </div>
            </div>
            <div class="md:col-span-2">
                <button class="btn-primary">Save Profile</button>
            </div>
        </form>
    </div>
@endsection
