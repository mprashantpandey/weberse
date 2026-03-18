@extends('layouts.dashboard', [
    'title' => $lead->title,
    'heading' => $lead->title,
    'subheading' => 'Lead detail, proposal data, notes, and follow-up management.',
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

    <div class="grid gap-6 xl:grid-cols-[0.92fr_1.08fr]">
        <div class="space-y-6">
            <div class="card">
                <div class="panel-title">Lead Snapshot</div>
                <div class="mt-6 grid gap-4 sm:grid-cols-2">
                    <div><div class="text-xs uppercase tracking-[0.2em] text-slate-400">Stage</div><div class="mt-2 text-lg font-semibold text-slate-800">{{ str($lead->stage)->replace('_', ' ')->title() }}</div></div>
                    <div><div class="text-xs uppercase tracking-[0.2em] text-slate-400">Status</div><div class="mt-2 text-lg font-semibold text-slate-800">{{ str($lead->status)->replace('_', ' ')->title() }}</div></div>
                    <div><div class="text-xs uppercase tracking-[0.2em] text-slate-400">Owner</div><div class="mt-2 text-lg font-semibold text-slate-800">{{ $lead->owner?->name ?? 'Unassigned' }}</div></div>
                    <div><div class="text-xs uppercase tracking-[0.2em] text-slate-400">Estimated value</div><div class="mt-2 text-lg font-semibold text-slate-800">{{ $lead->estimated_value ? '₹'.number_format((float) $lead->estimated_value) : '—' }}</div></div>
                    <div><div class="text-xs uppercase tracking-[0.2em] text-slate-400">Proposal</div><div class="mt-2 text-lg font-semibold text-slate-800">{{ $lead->proposal_amount ? '₹'.number_format((float) $lead->proposal_amount) : '—' }}</div></div>
                    <div><div class="text-xs uppercase tracking-[0.2em] text-slate-400">Follow-up</div><div class="mt-2 text-lg font-semibold text-slate-800">{{ $lead->next_follow_up_at?->format('d M, h:i A') ?: 'Not set' }}</div></div>
                </div>
                @if ($lead->message)
                    <div class="mt-6 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-4 text-sm text-slate-600">{{ $lead->message }}</div>
                @endif
                <div class="mt-6 flex gap-3">
                    <a href="{{ route('admin.crm.leads.edit', $lead) }}" class="btn-primary">Edit Lead</a>
                    <a href="{{ route('admin.crm.leads.index') }}" class="btn-dark">Back to Leads</a>
                </div>
            </div>

            <div class="card">
                <div class="panel-title">Contact</div>
                <div class="mt-6 space-y-3 text-sm text-slate-600">
                    <div><span class="font-semibold text-slate-800">Name:</span> {{ $lead->contact?->name ?? '—' }}</div>
                    <div><span class="font-semibold text-slate-800">Company:</span> {{ $lead->contact?->company ?: '—' }}</div>
                    <div><span class="font-semibold text-slate-800">Email:</span> {{ $lead->contact?->email ?: '—' }}</div>
                    <div><span class="font-semibold text-slate-800">Phone:</span> {{ $lead->contact?->phone ?: '—' }}</div>
                    <div><span class="font-semibold text-slate-800">Designation:</span> {{ $lead->contact?->designation ?: '—' }}</div>
                    <div><span class="font-semibold text-slate-800">Source:</span> {{ str($lead->source)->replace('_', ' ')->title() }}</div>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="card">
                <div class="panel-title">Activity Notes</div>
                <div class="panel-subtitle">Capture call outcomes, context, and proposal updates.</div>
                <div class="mt-6 space-y-3">
                    @forelse ($lead->notes as $note)
                        <div class="rounded-2xl border border-slate-200 px-4 py-3">
                            <div class="text-sm text-slate-700">{{ $note->body }}</div>
                            <div class="mt-2 text-xs text-slate-400">{{ $note->user?->name ?? 'System' }} • {{ $note->created_at->format('d M Y, h:i A') }}</div>
                        </div>
                    @empty
                        <div class="text-sm text-slate-500">No notes added yet.</div>
                    @endforelse
                </div>
                <form method="POST" action="{{ route('admin.crm.leads.notes.store', $lead) }}" class="mt-6">
                    @csrf
                    <textarea class="input min-h-28" name="body" placeholder="Add a note about the lead" required></textarea>
                    <button class="btn-dark mt-4">Add Note</button>
                </form>
            </div>

            <div class="card">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <div class="panel-title">Follow-Ups</div>
                        <div class="panel-subtitle">Track assigned reminders and completed actions.</div>
                    </div>
                    <a href="{{ route('admin.crm.follow-ups.index') }}" class="btn-secondary">Open Queue</a>
                </div>
                <div class="mt-6 overflow-x-auto">
                    <table class="dashboard-table">
                        <thead>
                            <tr>
                                <th>Due</th>
                                <th>Assignee</th>
                                <th>Status</th>
                                <th>Notes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($lead->followUps as $followUp)
                                <tr>
                                    <td>{{ $followUp->due_at?->format('d M, h:i A') }}</td>
                                    <td>{{ $followUp->assignee?->name ?? 'Unassigned' }}</td>
                                    <td><span class="status-badge">{{ str($followUp->status)->replace('_', ' ')->title() }}</span></td>
                                    <td>{{ \Illuminate\Support\Str::limit($followUp->notes, 48) ?: '—' }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-sm text-slate-500">No follow-ups added yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <form method="POST" action="{{ route('admin.crm.follow-ups.store') }}" class="mt-6 grid gap-4 md:grid-cols-2">
                    @csrf
                    <input type="hidden" name="lead_id" value="{{ $lead->id }}">
                    <label class="block">
                        <span class="text-sm font-medium text-slate-700">Assign to</span>
                        <select class="input mt-2" name="assigned_to">
                            <option value="">Unassigned</option>
                            @foreach ($salesUsers as $salesUser)
                                <option value="{{ $salesUser->id }}">{{ $salesUser->name }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label class="block">
                        <span class="text-sm font-medium text-slate-700">Due at</span>
                        <input class="input mt-2" type="datetime-local" name="due_at" required>
                    </label>
                    <label class="block">
                        <span class="text-sm font-medium text-slate-700">Status</span>
                        <select class="input mt-2" name="status">
                            @foreach (['pending', 'scheduled', 'completed', 'missed'] as $status)
                                <option value="{{ $status }}">{{ str($status)->title() }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label class="block md:col-span-2">
                        <span class="text-sm font-medium text-slate-700">Notes</span>
                        <textarea class="input mt-2 min-h-24" name="notes"></textarea>
                    </label>
                    <div class="md:col-span-2">
                        <button class="btn-primary">Create Follow-Up</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
