@extends('layouts.dashboard', [
    'title' => 'Support Tickets',
    'heading' => 'Support Tickets',
    'subheading' => 'Client-visible ticket history and department routing.',
    'nav' => [
        ['label' => 'Overview', 'route' => 'client.dashboard', 'active' => 'client.dashboard'],
        ['label' => 'Hosting', 'route' => 'client.hosting.index', 'active' => 'client.hosting.*'],
        ['label' => 'Invoices', 'route' => 'client.invoices.index', 'active' => 'client.invoices.*'],
        ['label' => 'Support', 'route' => 'client.support.index', 'active' => 'client.support.*'],
        ['label' => 'Documents', 'route' => 'client.documents.index', 'active' => 'client.documents.*'],
        ['label' => 'Profile', 'route' => 'client.profile.edit', 'active' => 'client.profile.*'],
    ],
])

@section('content')
    <div class="grid gap-6 lg:grid-cols-[1.1fr_0.9fr]">
        <div class="space-y-4">
            @foreach($tickets as $ticket)
                <a href="{{ route('client.support.index', ['ticket' => $ticket->id]) }}" class="card block border {{ optional($activeTicket)->id === $ticket->id ? 'border-[rgba(115,182,85,0.3)]' : 'border-transparent' }}">
                    <div class="text-lg font-semibold">{{ $ticket->subject }}</div>
                    <div class="mt-2 text-sm text-slate-500">{{ $ticket->department?->name }} • {{ ucfirst($ticket->priority) }} • {{ str($ticket->status)->replace('_', ' ')->title() }}</div>
                </a>
            @endforeach
            <div>{{ $tickets->links() }}</div>
        </div>
        <div class="space-y-6">
            @if (session('status'))
                <div class="rounded-2xl bg-green-50 px-4 py-3 text-sm text-green-700">{{ session('status') }}</div>
            @endif
            @if ($activeTicket)
                <div class="card">
                    <div class="border-b border-slate-100 pb-4">
                        <h2 class="text-xl font-semibold">{{ $activeTicket->subject }}</h2>
                        <div class="mt-2 text-sm text-slate-500">{{ $activeTicket->department?->name }} • {{ ucfirst($activeTicket->priority) }} • {{ str($activeTicket->status)->replace('_', ' ')->title() }}</div>
                    </div>
                    <div class="mt-5 space-y-3">
                        @foreach ($activeTicket->replies->where('is_internal', false) as $reply)
                            <div class="rounded-2xl {{ $reply->user_id === auth()->id() ? 'bg-slate-50' : 'bg-brand-green/5' }} px-4 py-3">
                                <div class="text-sm text-slate-700">{{ $reply->message }}</div>
                                <div class="mt-2 text-xs text-slate-400">{{ $reply->user?->name ?? 'Support' }} • {{ $reply->created_at->diffForHumans() }}</div>
                            </div>
                        @endforeach
                    </div>
                    <form method="POST" action="{{ route('client.support.reply', $activeTicket) }}" class="mt-5 space-y-3">
                        @csrf
                        <textarea class="input min-h-28" name="message" placeholder="Reply to support" required></textarea>
                        <button class="btn-dark">Send Reply</button>
                    </form>
                </div>
            @endif
            <div class="card">
                <h2 class="text-xl font-semibold">Create Ticket</h2>
                <form method="POST" action="{{ route('client.support.store') }}" class="mt-4 space-y-4">
                    @csrf
                    <select name="department_id" class="input">
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                        @endforeach
                    </select>
                    <input class="input" name="subject" placeholder="Subject" required>
                    <select name="priority" class="input">
                        <option value="low">Low</option>
                        <option value="medium" selected>Medium</option>
                        <option value="high">High</option>
                        <option value="urgent">Urgent</option>
                    </select>
                    <textarea class="input min-h-32" name="message" placeholder="Describe the issue" required></textarea>
                    <button class="btn-primary">Submit Ticket</button>
                </form>
            </div>
        </div>
    </div>
@endsection
