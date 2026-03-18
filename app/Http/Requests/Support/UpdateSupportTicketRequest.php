<?php

namespace App\Http\Requests\Support;

use App\Enums\TicketPriority;
use App\Enums\TicketStatus;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSupportTicketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->hasAnyRole(['admin', 'support']) ?? false;
    }

    public function rules(): array
    {
        return [
            'department_id' => ['nullable', 'exists:support_departments,id'],
            'assigned_to' => ['nullable', 'exists:users,id'],
            'priority' => ['required', 'string', 'in:'.implode(',', array_map(fn (TicketPriority $priority) => $priority->value, TicketPriority::cases()))],
            'status' => ['required', 'string', 'in:'.implode(',', array_map(fn (TicketStatus $status) => $status->value, TicketStatus::cases()))],
        ];
    }
}
