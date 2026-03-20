<?php

namespace App\Services\CRM;

use App\Models\CRM\Contact;
use App\Models\CRM\FollowUp;
use App\Models\CRM\Lead;
use App\Models\User;

class LeadPipelineService
{
    public function createLead(array $data, ?User $actor = null): Lead
    {
        $contact = filled($data['email'] ?? null)
            ? Contact::query()->firstOrNew(['email' => $data['email']])
            : new Contact();

        $contact->fill([
            'name' => $data['name'],
            'email' => $data['email'] ?? null,
            'phone' => $data['phone'] ?? null,
            'company' => $data['company'] ?? null,
            'designation' => $data['designation'] ?? null,
        ]);
        $contact->save();

        $lead = Lead::query()->create([
            'contact_id' => $contact->id,
            'owner_id' => $data['owner_id'] ?? null,
            'title' => $data['title'],
            'source' => $data['source'],
            'stage' => $data['stage'],
            'status' => $data['status'] ?? 'open',
            'estimated_value' => $data['estimated_value'] ?? null,
            'message' => $data['message'] ?? null,
            'next_follow_up_at' => $data['next_follow_up_at'] ?? null,
            'last_contacted_at' => $data['last_contacted_at'] ?? null,
            'proposal_sent_at' => $data['proposal_sent_at'] ?? null,
            'proposal_amount' => $data['proposal_amount'] ?? null,
            'proposal_reference' => $data['proposal_reference'] ?? null,
            'lost_reason' => $data['lost_reason'] ?? null,
        ]);

        activity()
            ->performedOn($lead)
            ->causedBy($actor)
            ->event('lead.created')
            ->log('Lead created');

        return $lead;
    }

    public function updateLead(Lead $lead, array $data, ?User $actor = null): Lead
    {
        $lead->update([
            'title' => $data['title'] ?? $lead->title,
            'source' => $data['source'] ?? $lead->source,
            'owner_id' => $data['owner_id'] ?? null,
            'stage' => $data['stage'],
            'status' => $data['status'] ?? $lead->status,
            'estimated_value' => $data['estimated_value'] ?? null,
            'next_follow_up_at' => $data['next_follow_up_at'] ?? null,
            'last_contacted_at' => $data['last_contacted_at'] ?? null,
            'proposal_sent_at' => $data['proposal_sent_at'] ?? null,
            'proposal_amount' => $data['proposal_amount'] ?? null,
            'proposal_reference' => $data['proposal_reference'] ?? null,
            'lost_reason' => $data['lost_reason'] ?? null,
        ]);

        activity()
            ->performedOn($lead)
            ->causedBy($actor)
            ->event('lead.updated')
            ->log('Lead pipeline updated');

        return $lead->fresh(['contact', 'owner']);
    }

    public function updateContact(Contact $contact, array $data, ?User $actor = null): Contact
    {
        $contact->update($data);

        activity()
            ->performedOn($contact)
            ->causedBy($actor)
            ->event('contact.updated')
            ->log('CRM contact updated');

        return $contact->fresh();
    }

    public function addNote(Lead $lead, string $body, ?User $actor = null): void
    {
        $lead->notes()->create([
            'user_id' => $actor?->id,
            'body' => $body,
        ]);

        activity()
            ->performedOn($lead)
            ->causedBy($actor)
            ->event('lead.note_added')
            ->log('Lead note added');
    }

    public function createFollowUp(array $data, ?User $actor = null): FollowUp
    {
        $followUp = FollowUp::query()->create([
            'lead_id' => $data['lead_id'],
            'assigned_to' => $data['assigned_to'] ?? null,
            'due_at' => $data['due_at'],
            'status' => $data['status'] ?? 'pending',
            'notes' => $data['notes'] ?? null,
            'completed_at' => ($data['status'] ?? 'pending') === 'completed' ? now() : null,
        ]);

        activity()
            ->performedOn($followUp)
            ->causedBy($actor)
            ->event('follow_up.created')
            ->log('CRM follow-up created');

        return $followUp;
    }

    public function updateFollowUp(FollowUp $followUp, array $data, ?User $actor = null): FollowUp
    {
        $status = $data['status'] ?? $followUp->status;

        $followUp->update([
            'assigned_to' => $data['assigned_to'] ?? null,
            'due_at' => $data['due_at'],
            'status' => $status,
            'notes' => $data['notes'] ?? null,
            'completed_at' => $status === 'completed' ? ($followUp->completed_at ?? now()) : null,
        ]);

        activity()
            ->performedOn($followUp)
            ->causedBy($actor)
            ->event('follow_up.updated')
            ->log('CRM follow-up updated');

        return $followUp->fresh(['lead', 'assignee']);
    }
}
