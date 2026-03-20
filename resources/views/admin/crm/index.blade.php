@extends('layouts.dashboard', [
    'title' => 'CRM Overview',
    'heading' => 'CRM Overview',
    'subheading' => 'Lead intake, deal movement, contacts, and follow-up execution in one place.',
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

    <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
        <div class="metric-card"><div class="metric-label">Open Leads</div><div class="metric-value">{{ $summary['open_leads'] }}</div></div>
        <div class="metric-card"><div class="metric-label">Pipeline Value</div><div class="metric-value">₹{{ number_format((float) $summary['pipeline_value']) }}</div></div>
        <div class="metric-card"><div class="metric-label">Due Follow-Ups</div><div class="metric-value">{{ $summary['due_follow_ups'] }}</div></div>
        <div class="metric-card"><div class="metric-label">Won This Month</div><div class="metric-value">{{ $summary['won_this_month'] }}</div></div>
    </div>

    <div class="mt-6 grid gap-6 xl:grid-cols-[1.1fr_0.9fr]">
        <div class="card">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <div class="panel-title">Pipeline Snapshot</div>
                    <div class="panel-subtitle">Current lead volume and value by stage.</div>
                </div>
                <a href="{{ route('admin.crm.leads.index') }}" class="btn-dark">Open Leads</a>
            </div>
            <div class="mt-6 space-y-4">
                @foreach ($stageSummary as $item)
                    <div class="dashboard-item">
                        <div>
                            <div class="font-semibold text-slate-800">{{ $item['label'] }}</div>
                            <div class="mt-1 text-sm text-slate-500">{{ $item['count'] }} leads</div>
                        </div>
                        <div class="status-badge">₹{{ number_format((float) $item['value']) }}</div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="card">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <div class="panel-title">Follow-Up Queue</div>
                    <div class="panel-subtitle">Immediate reminders and assigned actions.</div>
                </div>
                <a href="{{ route('admin.crm.follow-ups.index') }}" class="btn-primary">Manage Follow-Ups</a>
            </div>
            <div class="dashboard-list">
                @forelse ($dueFollowUps as $followUp)
                    <div class="dashboard-item">
                        <div>
                            <div class="font-semibold text-slate-800">{{ $followUp->lead?->title ?? 'Lead follow-up' }}</div>
                            <div class="mt-1 text-sm text-slate-500">
                                {{ $followUp->assignee?->name ?? 'Unassigned' }} • due {{ $followUp->due_at?->format('d M, h:i A') }}
                            </div>
                        </div>
                        <div class="status-badge">{{ str($followUp->status)->replace('_', ' ')->title() }}</div>
                    </div>
                @empty
                    <div class="dashboard-item-soft text-sm text-slate-500">No follow-ups due right now.</div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="mt-6 grid gap-6 xl:grid-cols-[1fr_1fr]">
        <div class="card">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <div class="panel-title">Recent Leads</div>
                    <div class="panel-subtitle">Fresh lead intake and stage movement.</div>
                </div>
                <a href="{{ route('admin.crm.leads.create') }}" class="btn-primary">Create Lead</a>
            </div>
            <div class="dashboard-list">
                @foreach ($recentLeads as $lead)
                    <a href="{{ route('admin.crm.leads.show', $lead) }}" class="dashboard-item">
                        <div>
                            <div class="font-semibold text-slate-800">{{ $lead->title }}</div>
                            <div class="mt-1 text-sm text-slate-500">{{ $lead->contact?->name ?? 'No contact' }} • {{ str($lead->source)->replace('_', ' ')->title() }}</div>
                        </div>
                        <div class="status-badge">{{ str($lead->stage)->replace('_', ' ')->title() }}</div>
                    </a>
                @endforeach
            </div>
        </div>

        <div class="card">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <div class="panel-title">Recent Contacts</div>
                    <div class="panel-subtitle">Company and contact records feeding the pipeline.</div>
                </div>
                <a href="{{ route('admin.crm.contacts.index') }}" class="btn-dark">Open Contacts</a>
            </div>
            <div class="dashboard-list">
                @foreach ($recentContacts as $contact)
                    <div class="dashboard-item">
                        <div>
                            <div class="font-semibold text-slate-800">{{ $contact->name }}</div>
                            <div class="mt-1 text-sm text-slate-500">{{ $contact->company ?: 'No company' }} • {{ $contact->email ?: 'No email' }}</div>
                        </div>
                        <div class="status-badge">{{ $contact->leads_count }} leads</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
