@extends('layouts.dashboard', [
    'title' => 'Newsletter Subscribers',
    'heading' => 'Newsletter Subscribers',
    'subheading' => 'Manage audience records used by newsletter campaigns.',
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
        <div class="card mb-6 border border-green-200 bg-green-50 text-green-700">{{ session('status') }}</div>
    @endif

    <div class="dashboard-subnav">
        <a href="{{ route('admin.email.index') }}" class="dashboard-subnav-link">Overview</a>
        <a href="{{ route('admin.email.templates.index') }}" class="dashboard-subnav-link">Templates</a>
        <a href="{{ route('admin.email.subscribers.index') }}" class="dashboard-subnav-link dashboard-subnav-link-active">Subscribers</a>
        <a href="{{ route('admin.email.campaigns.index') }}" class="dashboard-subnav-link">Campaigns</a>
        <a href="{{ route('admin.email.compose') }}" class="dashboard-subnav-link">Compose</a>
    </div>

    <div class="card card-modal-host" x-data="{ createOpen: false, activeEdit: null }">
        <div class="flex items-center justify-between gap-4">
            <div>
                <div class="panel-title">Subscriber List</div>
                <div class="panel-subtitle">Footer signups appear here automatically. Small edits stay in modal dialogs.</div>
            </div>
            <button type="button" class="btn-primary" @click="createOpen = true">Add Subscriber</button>
        </div>
        <div class="mt-6 overflow-x-auto">
            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th>Email</th>
                        <th>Name</th>
                        <th>Source</th>
                        <th>Status</th>
                        <th>Last Sent</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($subscribers as $subscriber)
                        <tr>
                            <td class="font-semibold text-slate-800">{{ $subscriber->email }}</td>
                            <td>{{ $subscriber->name ?: '—' }}</td>
                            <td>{{ $subscriber->source }}</td>
                            <td><span class="status-badge">{{ str($subscriber->status)->replace('_', ' ')->title() }}</span></td>
                            <td>{{ $subscriber->last_sent_at?->format('d M Y') ?: '—' }}</td>
                            <td class="text-right"><button type="button" class="btn-dark px-4 py-2 text-xs" @click="activeEdit = {{ $subscriber->id }}">Edit</button></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div x-show="createOpen" x-cloak class="dashboard-modal-backdrop" @click.self="createOpen = false">
            <div class="dashboard-modal-card">
                <div class="flex items-center justify-between gap-4">
                    <div class="panel-title">Add Subscriber</div>
                    <button type="button" class="btn-dark px-4 py-2 text-xs" @click="createOpen = false">Close</button>
                </div>
                <form method="POST" action="{{ route('admin.email.subscribers.store') }}" class="mt-6 grid gap-4">
                    @csrf
                    <input class="input" name="email" type="email" placeholder="Email address" required>
                    <input class="input" name="name" placeholder="Name">
                    <input class="input" name="source" placeholder="Source" value="admin">
                    <select class="input" name="status">
                        @foreach (['active', 'unsubscribed'] as $status)
                            <option value="{{ $status }}">{{ str($status)->replace('_', ' ')->title() }}</option>
                        @endforeach
                    </select>
                    <div class="flex gap-3">
                        <button class="btn-primary">Save Subscriber</button>
                        <button type="button" class="btn-dark" @click="createOpen = false">Cancel</button>
                    </div>
                </form>
            </div>
        </div>

        @foreach ($subscribers as $subscriber)
            <div x-show="activeEdit === {{ $subscriber->id }}" x-cloak class="dashboard-modal-backdrop" @click.self="activeEdit = null">
                <div class="dashboard-modal-card">
                    <div class="flex items-center justify-between gap-4">
                        <div class="panel-title">Edit Subscriber</div>
                        <button type="button" class="btn-dark px-4 py-2 text-xs" @click="activeEdit = null">Close</button>
                    </div>
                    <form method="POST" action="{{ route('admin.email.subscribers.update', $subscriber) }}" class="mt-6 grid gap-4">
                        @csrf
                        @method('PATCH')
                        <div class="input bg-slate-50">{{ $subscriber->email }}</div>
                        <input class="input" name="name" value="{{ $subscriber->name }}" placeholder="Name">
                        <input class="input" name="source" value="{{ $subscriber->source }}" placeholder="Source">
                        <select class="input" name="status">
                            @foreach (['active', 'unsubscribed'] as $status)
                                <option value="{{ $status }}" @selected($subscriber->status === $status)>{{ str($status)->replace('_', ' ')->title() }}</option>
                            @endforeach
                        </select>
                        <div class="flex gap-3">
                            <button class="btn-primary">Save Changes</button>
                            <button type="button" class="btn-dark" @click="activeEdit = null">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
@endsection
