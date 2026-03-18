<?php

namespace App\Services\Support;

use App\Models\Support\SupportTicket;
use App\Models\User;

class SupportTicketService
{
    public function createTicket(User $user, array $data): SupportTicket
    {
        $ticket = SupportTicket::query()->create([
            'user_id' => $user->id,
            'department_id' => $data['department_id'] ?? null,
            'subject' => $data['subject'],
            'priority' => $data['priority'],
            'status' => 'open',
            'message' => $data['message'],
        ]);

        $ticket->replies()->create([
            'user_id' => $user->id,
            'message' => $data['message'],
            'is_internal' => false,
        ]);

        activity()
            ->performedOn($ticket)
            ->causedBy($user)
            ->event('ticket.created')
            ->log('Support ticket created');

        return $ticket;
    }

    public function updateTicket(SupportTicket $ticket, array $data, ?User $actor = null): SupportTicket
    {
        $ticket->update([
            'department_id' => $data['department_id'] ?? null,
            'assigned_to' => $data['assigned_to'] ?? null,
            'priority' => $data['priority'],
            'status' => $data['status'],
        ]);

        activity()
            ->performedOn($ticket)
            ->causedBy($actor)
            ->event('ticket.updated')
            ->log('Support ticket updated');

        return $ticket->fresh(['department', 'assignee', 'user']);
    }

    public function addReply(SupportTicket $ticket, User $user, string $message, bool $internal = false): void
    {
        $ticket->replies()->create([
            'user_id' => $user->id,
            'message' => $message,
            'is_internal' => $internal,
        ]);

        if (! $internal) {
            $ticket->update([
                'status' => $user->hasRole('client') ? 'open' : 'waiting_client',
            ]);
        }

        activity()
            ->performedOn($ticket)
            ->causedBy($user)
            ->event('ticket.reply_added')
            ->log($internal ? 'Internal note added to ticket' : 'Ticket reply added');
    }
}
