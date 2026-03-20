<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFollowUpRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->hasAnyRole(['admin', 'sales']) ?? false;
    }

    public function rules(): array
    {
        return [
            'assigned_to' => ['nullable', 'exists:users,id'],
            'due_at' => ['required', 'date'],
            'status' => ['required', 'string', 'max:50'],
            'notes' => ['nullable', 'string'],
        ];
    }
}
