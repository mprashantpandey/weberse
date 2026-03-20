@extends('layouts.dashboard', [
    'title' => 'Support',
    'heading' => 'Support',
    'subheading' => 'Shared ticket queue for staff handling.',
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
    <div class="grid gap-6 xl:grid-cols-[0.9fr_1.1fr]">
        <div class="space-y-4">
            @if (session('status'))
                <div class="rounded-2xl bg-green-50 px-4 py-3 text-sm text-green-700">{{ session('status') }}</div>
            @endif
            @foreach($tickets as $ticket)
                <a href="{{ route('admin.support.index', ['ticket' => $ticket->id]) }}" class="card block border {{ optional($activeTicket)->id === $ticket->id ? 'border-[rgba(115,182,85,0.3)]' : 'border-transparent' }}">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <div class="text-lg font-semibold text-slate-900">{{ $ticket->subject }}</div>
                            <div class="mt-1 text-sm text-slate-500">{{ $ticket->user?->name }} • {{ $ticket->department?->name ?? 'General' }}</div>
                        </div>
                        <div class="rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-600">{{ str($ticket->status)->replace('_', ' ')->title() }}</div>
                    </div>
                    <div class="mt-3 text-sm text-slate-500">Priority: {{ ucfirst($ticket->priority) }}</div>
                </a>
            @endforeach
            <div>{{ $tickets->links() }}</div>
        </div>

        <div class="card">
            @if ($activeTicket)
                <div class="flex items-start justify-between gap-4 border-b border-slate-100 pb-4">
                    <div>
                        <h2 class="text-xl font-semibold text-slate-900">{{ $activeTicket->subject }}</h2>
                        <div class="mt-1 text-sm text-slate-500">{{ $activeTicket->user?->name }} • {{ $activeTicket->user?->email }}</div>
                    </div>
                    <div class="rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-600">{{ str($activeTicket->status)->replace('_', ' ')->title() }}</div>
                </div>

                <form method="POST" action="{{ route('admin.support.update', $activeTicket) }}" class="mt-5 grid gap-3 md:grid-cols-2">
                    @csrf
                    @method('PATCH')
                    <select class="input" name="department_id">
                        <option value="">No department</option>
                        @foreach ($departments as $department)
                            <option value="{{ $department->id }}" @selected($activeTicket->department_id === $department->id)>{{ $department->name }}</option>
                        @endforeach
                    </select>
                    <select class="input" name="assigned_to">
                        <option value="">Unassigned</option>
                        @foreach ($supportUsers as $supportUser)
                            <option value="{{ $supportUser->id }}" @selected($activeTicket->assigned_to === $supportUser->id)>{{ $supportUser->name }}</option>
                        @endforeach
                    </select>
                    <select class="input" name="priority">
                        @foreach (['low', 'medium', 'high', 'urgent'] as $priority)
                            <option value="{{ $priority }}" @selected($activeTicket->priority === $priority)>{{ ucfirst($priority) }}</option>
                        @endforeach
                    </select>
                    <select class="input" name="status">
                        @foreach (['open', 'in_progress', 'waiting_client', 'resolved', 'closed'] as $status)
                            <option value="{{ $status }}" @selected($activeTicket->status === $status)>{{ str($status)->replace('_', ' ')->title() }}</option>
                        @endforeach
                    </select>
                    <button class="btn-primary justify-center md:col-span-2">Update Ticket</button>
                </form>

                <div class="mt-6 space-y-3">
                    @foreach ($activeTicket->replies as $reply)
                        <div class="rounded-2xl {{ $reply->is_internal ? 'bg-amber-50 border border-amber-200' : 'bg-slate-50' }} px-4 py-3">
                            <div class="text-sm text-slate-700">{{ $reply->message }}</div>
                            <div class="mt-2 text-xs text-slate-400">
                                {{ $reply->user?->name ?? 'System' }} • {{ $reply->created_at->diffForHumans() }}
                                @if ($reply->is_internal)
                                    • Internal note
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <form method="POST" action="{{ route('admin.support.reply', $activeTicket) }}" class="mt-6 space-y-3">
                    @csrf
                    <textarea class="input min-h-28" name="message" placeholder="Add a reply or internal note" required></textarea>
                    <label class="flex items-center gap-2 text-sm text-slate-600">
                        <input type="checkbox" name="is_internal" value="1">
                        Save as internal note
                    </label>
                    <button class="btn-dark">Post Update</button>
                </form>
            @else
                <div class="text-sm text-slate-500">No tickets available.</div>
            @endif
        </div>
    </div>
@endsection
