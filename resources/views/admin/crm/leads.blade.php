@extends('layouts.dashboard', [
    'title' => 'CRM Leads',
    'heading' => 'Lead Pipeline',
    'subheading' => 'Manage deal stages, proposal details, owners, and follow-up readiness.',
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
        <form method="GET" class="grid gap-4 md:grid-cols-5">
            <input class="input md:col-span-2" name="q" value="{{ request('q') }}" placeholder="Search lead, contact, company, email">
            <select class="input" name="stage">
                <option value="">All stages</option>
                @foreach ($stages as $stage)
                    <option value="{{ $stage->value }}" @selected(request('stage') === $stage->value)>{{ str($stage->value)->replace('_', ' ')->title() }}</option>
                @endforeach
            </select>
            <select class="input" name="owner">
                <option value="">All owners</option>
                @foreach ($salesUsers as $salesUser)
                    <option value="{{ $salesUser->id }}" @selected((string) request('owner') === (string) $salesUser->id)>{{ $salesUser->name }}</option>
                @endforeach
            </select>
            <div class="flex gap-3">
                <button class="btn-dark">Filter</button>
                <a href="{{ route('admin.crm.leads.index') }}" class="btn-secondary">Reset</a>
            </div>
        </form>
    </div>

    <div class="card mt-6">
        <div class="flex items-center justify-between gap-4">
            <div>
                <div class="panel-title">All Leads</div>
                <div class="panel-subtitle">Use the lead page for notes, follow-ups, and full deal management.</div>
            </div>
            <a href="{{ route('admin.crm.leads.create') }}" class="btn-primary">Create Lead</a>
        </div>

        <div class="mt-6 overflow-x-auto">
            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th>Lead</th>
                        <th>Contact</th>
                        <th>Owner</th>
                        <th>Stage</th>
                        <th>Value</th>
                        <th>Next Follow-Up</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($leads as $lead)
                        <tr>
                            <td>
                                <div class="font-semibold text-slate-800">{{ $lead->title }}</div>
                                <div class="mt-1 text-xs text-slate-500">{{ str($lead->source)->replace('_', ' ')->title() }} • {{ str($lead->status)->replace('_', ' ')->title() }}</div>
                            </td>
                            <td>
                                <div class="font-medium text-slate-700">{{ $lead->contact?->name ?? 'No contact' }}</div>
                                <div class="mt-1 text-xs text-slate-500">{{ $lead->contact?->company ?: ($lead->contact?->email ?: '—') }}</div>
                            </td>
                            <td>{{ $lead->owner?->name ?? 'Unassigned' }}</td>
                            <td><span class="status-badge">{{ str($lead->stage)->replace('_', ' ')->title() }}</span></td>
                            <td>{{ $lead->estimated_value ? '₹'.number_format((float) $lead->estimated_value) : '—' }}</td>
                            <td>{{ $lead->next_follow_up_at?->format('d M, h:i A') ?: '—' }}</td>
                            <td class="text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.crm.leads.show', $lead) }}" class="btn-dark px-4 py-2 text-xs">Open</a>
                                    <a href="{{ route('admin.crm.leads.edit', $lead) }}" class="btn-secondary px-4 py-2 text-xs">Edit</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">{{ $leads->links() }}</div>
    </div>
@endsection
