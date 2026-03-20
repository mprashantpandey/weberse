@extends('layouts.dashboard', [
    'title' => 'CRM Contacts',
    'heading' => 'Contacts',
    'subheading' => 'People and companies connected to your leads and proposals.',
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
    @include('admin.crm._subnav')

    @if (session('status'))
        <div class="card mb-6 border border-green-200 bg-green-50 text-green-700">{{ session('status') }}</div>
    @endif

    <div class="card">
        <form method="GET" class="grid gap-4 md:grid-cols-[1fr_auto]">
            <input class="input" name="q" value="{{ request('q') }}" placeholder="Search name, company, email">
            <div class="flex gap-3">
                <button class="btn-dark">Filter</button>
                <a href="{{ route('admin.crm.contacts.index') }}" class="btn-secondary">Reset</a>
            </div>
        </form>
    </div>

    <div class="card mt-6">
        <div class="panel-title">All Contacts</div>
        <div class="panel-subtitle">Small contact changes are handled inline without a separate page.</div>
        <div class="mt-6 overflow-x-auto">
            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th>Contact</th>
                        <th>Company</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Leads</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($contacts as $contact)
                        <tr x-data="{ open: false }">
                            <td>
                                <div class="font-semibold text-slate-800">{{ $contact->name }}</div>
                                <div class="mt-1 text-xs text-slate-500">{{ $contact->designation ?: 'No designation' }}</div>
                            </td>
                            <td>{{ $contact->company ?: '—' }}</td>
                            <td>{{ $contact->email ?: '—' }}</td>
                            <td>{{ $contact->phone ?: '—' }}</td>
                            <td>{{ $contact->leads_count }}</td>
                            <td class="text-right">
                                <button type="button" class="btn-dark px-4 py-2 text-xs" @click="open = true">Edit</button>
                                <div x-show="open" x-transition class="dashboard-modal-backdrop items-start overflow-y-auto py-10" @click.self="open = false">
                                    <div class="dashboard-modal-card max-w-2xl">
                                        <div class="flex items-center justify-between gap-4">
                                            <div>
                                                <div class="panel-title">Edit Contact</div>
                                                <div class="panel-subtitle">Quick updates for contact records.</div>
                                            </div>
                                            <button type="button" class="btn-secondary px-4 py-2" @click="open = false">Close</button>
                                        </div>
                                        <form method="POST" action="{{ route('admin.crm.contacts.update', $contact) }}" class="mt-6 grid gap-4 md:grid-cols-2">
                                            @csrf
                                            @method('PATCH')
                                            <input class="input" name="name" value="{{ $contact->name }}" required>
                                            <input class="input" name="designation" value="{{ $contact->designation }}" placeholder="Designation">
                                            <input class="input" name="company" value="{{ $contact->company }}" placeholder="Company">
                                            <input class="input" type="email" name="email" value="{{ $contact->email }}" placeholder="Email">
                                            <input class="input" name="phone" value="{{ $contact->phone }}" placeholder="Phone">
                                            <div></div>
                                            <div class="md:col-span-2">
                                                <button class="btn-primary">Save Contact</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-6">{{ $contacts->links() }}</div>
    </div>
@endsection
