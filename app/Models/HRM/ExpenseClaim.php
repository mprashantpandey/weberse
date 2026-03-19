<?php

namespace App\Models\HRM;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExpenseClaim extends Model
{
    protected $fillable = [
        'employee_profile_id',
        'submitted_by',
        'approved_by',
        'title',
        'category',
        'amount',
        'currency',
        'expense_date',
        'status',
        'receipt_path',
        'notes',
        'review_note',
        'processed_at',
    ];

    protected function casts(): array
    {
        return [
            'expense_date' => 'date',
            'processed_at' => 'datetime',
            'amount' => 'decimal:2',
        ];
    }

    public function employeeProfile(): BelongsTo
    {
        return $this->belongsTo(EmployeeProfile::class);
    }

    public function submitter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'submitted_by');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
