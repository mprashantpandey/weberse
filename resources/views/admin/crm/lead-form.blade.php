@extends('layouts.dashboard', [
    'title' => $mode === 'create' ? 'Create Lead' : 'Edit Lead',
    'heading' => $mode === 'create' ? 'Create Lead' : 'Edit Lead',
    'subheading' => 'Capture contact details, stage, proposal information, and ownership cleanly.',
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

    <div class="card">
        <div class="panel-title">{{ $mode === 'create' ? 'New Lead' : 'Manage Lead' }}</div>
        <div class="panel-subtitle">Basic lead capture plus proposal and follow-up fields needed by sales.</div>

        <form method="POST" action="{{ $mode === 'create' ? route('admin.crm.leads.store') : route('admin.crm.leads.update', $lead) }}" class="mt-6 grid gap-4 md:grid-cols-2">
            @csrf
            @if ($mode === 'edit')
                @method('PATCH')
            @endif

            <label class="block">
                <span class="text-sm font-medium text-slate-700">Contact name</span>
                <input class="input mt-2" name="name" value="{{ old('name', $lead->contact?->name) }}" required>
            </label>
            <label class="block">
                <span class="text-sm font-medium text-slate-700">Company</span>
                <input class="input mt-2" name="company" value="{{ old('company', $lead->contact?->company) }}">
            </label>
            <label class="block">
                <span class="text-sm font-medium text-slate-700">Email</span>
                <input class="input mt-2" type="email" name="email" value="{{ old('email', $lead->contact?->email) }}">
            </label>
            <label class="block">
                <span class="text-sm font-medium text-slate-700">Phone</span>
                <input class="input mt-2" name="phone" value="{{ old('phone', $lead->contact?->phone) }}">
            </label>
            <label class="block">
                <span class="text-sm font-medium text-slate-700">Designation</span>
                <input class="input mt-2" name="designation" value="{{ old('designation', $lead->contact?->designation) }}">
            </label>
            <label class="block">
                <span class="text-sm font-medium text-slate-700">Lead title</span>
                <input class="input mt-2" name="title" value="{{ old('title', $lead->title) }}" required>
            </label>
            <label class="block">
                <span class="text-sm font-medium text-slate-700">Source</span>
                <input class="input mt-2" name="source" value="{{ old('source', $lead->source ?: 'manual') }}" required>
            </label>
            <label class="block">
                <span class="text-sm font-medium text-slate-700">Owner</span>
                <select class="input mt-2" name="owner_id">
                    <option value="">Unassigned</option>
                    @foreach ($salesUsers as $salesUser)
                        <option value="{{ $salesUser->id }}" @selected((string) old('owner_id', $lead->owner_id) === (string) $salesUser->id)>{{ $salesUser->name }}</option>
                    @endforeach
                </select>
            </label>
            <label class="block">
                <span class="text-sm font-medium text-slate-700">Stage</span>
                <select class="input mt-2" name="stage" required>
                    @foreach ($stages as $stage)
                        <option value="{{ $stage->value }}" @selected(old('stage', $lead->stage ?: 'lead') === $stage->value)>{{ str($stage->value)->replace('_', ' ')->title() }}</option>
                    @endforeach
                </select>
            </label>
            <label class="block">
                <span class="text-sm font-medium text-slate-700">Status</span>
                <select class="input mt-2" name="status">
                    @foreach (['open', 'on_hold', 'won', 'lost'] as $status)
                        <option value="{{ $status }}" @selected(old('status', $lead->status ?: 'open') === $status)>{{ str($status)->replace('_', ' ')->title() }}</option>
                    @endforeach
                </select>
            </label>
            <label class="block">
                <span class="text-sm font-medium text-slate-700">Estimated value</span>
                <input class="input mt-2" type="number" step="0.01" min="0" name="estimated_value" value="{{ old('estimated_value', $lead->estimated_value) }}">
            </label>
            <label class="block">
                <span class="text-sm font-medium text-slate-700">Next follow-up</span>
                <input class="input mt-2" type="datetime-local" name="next_follow_up_at" value="{{ old('next_follow_up_at', $lead->next_follow_up_at?->format('Y-m-d\\TH:i')) }}">
            </label>
            <label class="block">
                <span class="text-sm font-medium text-slate-700">Last contacted</span>
                <input class="input mt-2" type="datetime-local" name="last_contacted_at" value="{{ old('last_contacted_at', $lead->last_contacted_at?->format('Y-m-d\\TH:i')) }}">
            </label>
            <label class="block">
                <span class="text-sm font-medium text-slate-700">Proposal sent</span>
                <input class="input mt-2" type="datetime-local" name="proposal_sent_at" value="{{ old('proposal_sent_at', $lead->proposal_sent_at?->format('Y-m-d\\TH:i')) }}">
            </label>
            <label class="block">
                <span class="text-sm font-medium text-slate-700">Proposal amount</span>
                <input class="input mt-2" type="number" step="0.01" min="0" name="proposal_amount" value="{{ old('proposal_amount', $lead->proposal_amount) }}">
            </label>
            <label class="block">
                <span class="text-sm font-medium text-slate-700">Proposal reference</span>
                <input class="input mt-2" name="proposal_reference" value="{{ old('proposal_reference', $lead->proposal_reference) }}">
            </label>
            <label class="block md:col-span-2">
                <span class="text-sm font-medium text-slate-700">Lead context</span>
                <textarea class="input mt-2 min-h-28" name="message">{{ old('message', $lead->message) }}</textarea>
            </label>
            <label class="block md:col-span-2">
                <span class="text-sm font-medium text-slate-700">Lost reason</span>
                <textarea class="input mt-2 min-h-24" name="lost_reason">{{ old('lost_reason', $lead->lost_reason) }}</textarea>
            </label>
            <div class="md:col-span-2 flex gap-3">
                <button class="btn-primary">{{ $mode === 'create' ? 'Create Lead' : 'Save Changes' }}</button>
                <a href="{{ route('admin.crm.leads.index') }}" class="btn-dark">Back to Leads</a>
            </div>
        </form>
    </div>
@endsection
