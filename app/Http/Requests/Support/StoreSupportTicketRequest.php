<?php

namespace App\Http\Requests\Support;

use App\Enums\TicketPriority;
use Illuminate\Foundation\Http\FormRequest;

class StoreSupportTicketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->hasRole('client') ?? false;
    }

    public function rules(): array
    {
        return [
            'department_id' => ['nullable', 'exists:support_departments,id'],
            'subject' => ['required', 'string', 'max:255'],
            'priority' => ['required', 'string', 'in:'.implode(',', array_map(fn (TicketPriority $priority) => $priority->value, TicketPriority::cases()))],
            'message' => ['required', 'string'],
        ];
    }
}
