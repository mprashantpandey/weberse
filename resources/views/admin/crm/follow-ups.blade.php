@extends('layouts.dashboard', [
    'title' => 'CRM Follow-Ups',
    'heading' => 'Follow-Ups',
    'subheading' => 'Assigned reminders, due actions, and completion tracking for the sales team.',
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

    <div class="grid gap-6 xl:grid-cols-[0.9fr_1.1fr]">
        <div class="card">
            <div class="panel-title">Create Follow-Up</div>
            <div class="panel-subtitle">Assign a reminder to a lead and keep it visible in the queue.</div>
            <form method="POST" action="{{ route('admin.crm.follow-ups.store') }}" class="mt-6 grid gap-4">
                @csrf
                <select class="input" name="lead_id" required>
                    <option value="">Select lead</option>
                    @foreach ($leadOptions as $leadOption)
                        <option value="{{ $leadOption->id }}">{{ $leadOption->title }} — {{ $leadOption->contact?->name ?? 'No contact' }}</option>
                    @endforeach
                </select>
                <select class="input" name="assigned_to">
                    <option value="">Unassigned</option>
                    @foreach ($salesUsers as $salesUser)
                        <option value="{{ $salesUser->id }}">{{ $salesUser->name }}</option>
                    @endforeach
                </select>
                <input class="input" type="datetime-local" name="due_at" required>
                <select class="input" name="status">
                    @foreach (['pending', 'scheduled', 'completed', 'missed'] as $status)
                        <option value="{{ $status }}">{{ str($status)->title() }}</option>
                    @endforeach
                </select>
                <textarea class="input min-h-28" name="notes" placeholder="Reminder context"></textarea>
                <button class="btn-primary justify-center">Create Follow-Up</button>
            </form>
        </div>

        <div class="card">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <div class="panel-title">Follow-Up Queue</div>
                    <div class="panel-subtitle">Edit due dates, assignees, and completion state inline.</div>
                </div>
                <div class="status-badge">{{ $followUps->total() }} items</div>
            </div>
            <div class="mt-6 overflow-x-auto">
                <table class="dashboard-table">
                    <thead>
                        <tr>
                            <th>Lead</th>
                            <th>Assignee</th>
                            <th>Due</th>
                            <th>Status</th>
                            <th>Notes</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($followUps as $followUp)
                            <tr x-data="{ open: false }">
                                <td>
                                    <a href="{{ route('admin.crm.leads.show', $followUp->lead) }}" class="font-semibold text-slate-800 hover:text-brand-blue">{{ $followUp->lead?->title ?? 'Lead follow-up' }}</a>
                                </td>
                                <td>{{ $followUp->assignee?->name ?? 'Unassigned' }}</td>
                                <td>{{ $followUp->due_at?->format('d M, h:i A') }}</td>
                                <td><span class="status-badge">{{ str($followUp->status)->replace('_', ' ')->title() }}</span></td>
                                <td>{{ \Illuminate\Support\Str::limit($followUp->notes, 40) ?: '—' }}</td>
                                <td class="text-right">
                                    <button type="button" class="btn-dark px-4 py-2 text-xs" @click="open = true">Manage</button>
                                    <div x-show="open" x-transition class="dashboard-modal-backdrop items-start overflow-y-auto py-10" @click.self="open = false">
                                        <div class="dashboard-modal-card max-w-2xl">
                                            <div class="flex items-center justify-between gap-4">
                                                <div>
                                                    <div class="panel-title">Manage Follow-Up</div>
                                                    <div class="panel-subtitle">{{ $followUp->lead?->title ?? 'Lead follow-up' }}</div>
                                                </div>
                                                <button type="button" class="btn-secondary px-4 py-2" @click="open = false">Close</button>
                                            </div>
                                            <form method="POST" action="{{ route('admin.crm.follow-ups.update', $followUp) }}" class="mt-6 grid gap-4 md:grid-cols-2">
                                                @csrf
                                                @method('PATCH')
                                                <select class="input" name="assigned_to">
                                                    <option value="">Unassigned</option>
                                                    @foreach ($salesUsers as $salesUser)
                                                        <option value="{{ $salesUser->id }}" @selected($followUp->assigned_to === $salesUser->id)>{{ $salesUser->name }}</option>
                                                    @endforeach
                                                </select>
                                                <input class="input" type="datetime-local" name="due_at" value="{{ $followUp->due_at?->format('Y-m-d\\TH:i') }}" required>
                                                <select class="input" name="status">
                                                    @foreach (['pending', 'scheduled', 'completed', 'missed'] as $status)
                                                        <option value="{{ $status }}" @selected($followUp->status === $status)>{{ str($status)->title() }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-500">
                                                    Completed: {{ $followUp->completed_at?->format('d M Y, h:i A') ?: 'No' }}
                                                </div>
                                                <textarea class="input min-h-28 md:col-span-2" name="notes">{{ $followUp->notes }}</textarea>
                                                <div class="md:col-span-2">
                                                    <button class="btn-primary">Save Follow-Up</button>
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
            <div class="mt-6">{{ $followUps->links() }}</div>
        </div>
    </div>
@endsection
