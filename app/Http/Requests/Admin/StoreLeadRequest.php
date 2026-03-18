<?php

namespace App\Http\Requests\Admin;

use App\Enums\LeadStage;
use Illuminate\Foundation\Http\FormRequest;

class StoreLeadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->hasAnyRole(['admin', 'sales']) ?? false;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'company' => ['nullable', 'string', 'max:255'],
            'designation' => ['nullable', 'string', 'max:255'],
            'title' => ['required', 'string', 'max:255'],
            'source' => ['required', 'string', 'max:100'],
            'stage' => ['required', 'string', 'in:'.implode(',', LeadStage::values())],
            'owner_id' => ['nullable', 'exists:users,id'],
            'estimated_value' => ['nullable', 'numeric', 'min:0'],
            'next_follow_up_at' => ['nullable', 'date'],
            'last_contacted_at' => ['nullable', 'date'],
            'proposal_sent_at' => ['nullable', 'date'],
            'proposal_amount' => ['nullable', 'numeric', 'min:0'],
            'proposal_reference' => ['nullable', 'string', 'max:255'],
            'lost_reason' => ['nullable', 'string'],
            'message' => ['nullable', 'string'],
        ];
    }
}
