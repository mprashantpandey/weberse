<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Support\StoreSupportReplyRequest;
use App\Http\Requests\Support\UpdateSupportTicketRequest;
use App\Models\Support\SupportDepartment;
use App\Models\Support\SupportTicket;
use App\Models\User;
use App\Services\Support\SupportTicketService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    public function __construct(private readonly SupportTicketService $supportTicketService) {}

    public function index(Request $request)
    {
        $tickets = SupportTicket::query()
            ->with(['user', 'department', 'assignee', 'replies.user'])
            ->latest()
            ->paginate(10);

        $activeTicket = $request->filled('ticket')
            ? SupportTicket::query()->with(['user', 'department', 'assignee', 'replies.user'])->find($request->integer('ticket'))
            : $tickets->getCollection()->first();

        return view('admin.support.index', [
            'tickets' => $tickets,
            'activeTicket' => $activeTicket,
            'departments' => SupportDepartment::query()->where('is_active', true)->orderBy('name')->get(),
            'supportUsers' => User::role(['admin', 'support'])->orderBy('name')->get(),
        ]);
    }

    public function update(UpdateSupportTicketRequest $request, SupportTicket $ticket): RedirectResponse
    {
        $this->supportTicketService->updateTicket($ticket, $request->validated(), $request->user());

        return back()->with('status', 'Ticket updated successfully.');
    }

    public function reply(StoreSupportReplyRequest $request, SupportTicket $ticket): RedirectResponse
    {
        $this->supportTicketService->addReply(
            $ticket,
            $request->user(),
            $request->validated()['message'],
            (bool) $request->boolean('is_internal')
        );

        return back()->with('status', 'Reply added successfully.');
    }
}
