<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Support\StoreSupportReplyRequest;
use App\Http\Requests\Support\StoreSupportTicketRequest;
use App\Models\Support\SupportDepartment;
use App\Models\Support\SupportTicket;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Services\Support\SupportTicketService;

class SupportController extends Controller
{
    public function __construct(private readonly SupportTicketService $supportTicketService) {}

    public function index(Request $request)
    {
        $tickets = SupportTicket::query()
            ->where('user_id', $request->user()->id)
            ->with(['department', 'replies.user'])
            ->latest()
            ->paginate(10);

        $activeTicket = $request->filled('ticket')
            ? SupportTicket::query()
                ->where('user_id', $request->user()->id)
                ->with(['department', 'replies.user'])
                ->find($request->integer('ticket'))
            : $tickets->getCollection()->first();

        return view('client.support.index', [
            'tickets' => $tickets,
            'activeTicket' => $activeTicket,
            'departments' => SupportDepartment::query()->where('is_active', true)->get(),
        ]);
    }

    public function store(StoreSupportTicketRequest $request): RedirectResponse
    {
        $this->supportTicketService->createTicket($request->user(), $request->validated());

        return back()->with('status', 'Ticket submitted successfully.');
    }

    public function reply(StoreSupportReplyRequest $request, SupportTicket $ticket): RedirectResponse
    {
        abort_unless($ticket->user_id === $request->user()->id, 404);

        $this->supportTicketService->addReply($ticket, $request->user(), $request->validated()['message']);

        return back()->with('status', 'Reply sent successfully.');
    }
}
