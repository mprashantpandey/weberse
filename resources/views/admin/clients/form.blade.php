@extends('layouts.dashboard', [
    'title' => $mode === 'create' ? 'Create Client' : 'Edit Client',
    'heading' => $mode === 'create' ? 'Create Client' : 'Edit Client',
    'subheading' => 'Core client account and WHMCS link settings.',
    'nav' => [
        ['label' => 'Overview', 'route' => 'admin.dashboard', 'active' => 'admin.dashboard'],
        ['label' => 'Clients', 'route' => 'admin.clients.index', 'active' => 'admin.clients.*'],
        ['label' => 'CMS', 'route' => 'admin.cms.index', 'active' => 'admin.cms.*'],
        ['label' => 'CRM', 'route' => 'admin.crm.index', 'active' => 'admin.crm.*'],
        ['label' => 'HRM', 'route' => 'admin.hrm.index', 'active' => 'admin.hrm.*'],
        ['label' => 'Support', 'route' => 'admin.support.index', 'active' => 'admin.support.*'],
        ['label' => 'Analytics', 'route' => 'admin.analytics.index', 'active' => 'admin.analytics.*'],
    ],
])

@section('content')
    @if (session('status'))
        <div class="card mb-6 border border-green-200 bg-green-50 text-green-700">{{ session('status') }}</div>
    @endif

    <div class="card max-w-5xl">
        <div class="panel-title">{{ $mode === 'create' ? 'New Client Account' : 'Client Account' }}</div>
        <div class="panel-subtitle">Use one portal account per client-side billing/contact owner and link WHMCS if available.</div>

        <form method="POST" action="{{ $mode === 'create' ? route('admin.clients.store') : route('admin.clients.update', $client) }}" class="mt-6 grid gap-4 md:grid-cols-2">
            @csrf
            @if ($mode === 'edit')
                @method('PATCH')
            @endif
            <label class="block">
                <span class="text-sm font-medium text-slate-700">Name</span>
                <input class="input mt-2" name="name" value="{{ old('name', $client->name) }}" required>
            </label>
            <label class="block">
                <span class="text-sm font-medium text-slate-700">Email</span>
                <input class="input mt-2" type="email" name="email" value="{{ old('email', $client->email) }}" required>
            </label>
            <label class="block">
                <span class="text-sm font-medium text-slate-700">Phone</span>
                <input class="input mt-2" name="phone" value="{{ old('phone', $client->phone) }}">
            </label>
            <label class="block">
                <span class="text-sm font-medium text-slate-700">Role Context</span>
                <input class="input mt-2" name="job_title" value="{{ old('job_title', $client->job_title) }}" placeholder="Founder, Accounts, Operations">
            </label>
            <label class="block">
                <span class="text-sm font-medium text-slate-700">WHMCS Client ID</span>
                <input class="input mt-2" type="number" min="1" name="whmcs_client_id" value="{{ old('whmcs_client_id', $client->whmcs_client_id) }}">
            </label>
            <label class="block">
                <span class="text-sm font-medium text-slate-700">{{ $mode === 'create' ? 'Password' : 'Password (optional)' }}</span>
                <input class="input mt-2" type="password" name="password" placeholder="{{ $mode === 'create' ? 'Set portal password' : 'Leave blank to keep current password' }}">
            </label>
            <label class="dashboard-item cursor-pointer md:col-span-2">
                <div>
                    <div class="font-semibold text-slate-800">Active Portal Access</div>
                    <div class="mt-1 text-slate-500">Inactive clients can remain in the system without using the portal.</div>
                </div>
                <input type="checkbox" name="is_active" value="1" class="h-5 w-5 rounded border-slate-300 text-brand-green focus:ring-brand-green" @checked(old('is_active', $client->is_active ?? true))>
            </label>
            <div class="md:col-span-2 flex flex-wrap gap-3">
                <button class="btn-primary">{{ $mode === 'create' ? 'Create Client' : 'Save Changes' }}</button>
                @if ($mode === 'edit')
                    <a href="{{ route('admin.clients.show', $client) }}" class="btn-secondary">Back to Client</a>
                @endif
            </div>
        </form>
    </div>
@endsection
