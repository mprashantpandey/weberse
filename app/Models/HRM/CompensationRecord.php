<?php

namespace App\Models\HRM;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompensationRecord extends Model
{
    protected $fillable = [
        'employee_profile_id',
        'created_by',
        'approved_by',
        'title',
        'pay_type',
        'amount',
        'currency',
        'effective_from',
        'effective_to',
        'status',
        'notes',
        'review_note',
        'approved_at',
    ];

    protected function casts(): array
    {
        return [
            'effective_from' => 'date',
            'effective_to' => 'date',
            'amount' => 'decimal:2',
            'approved_at' => 'datetime',
        ];
    }

    public function employeeProfile(): BelongsTo
    {
        return $this->belongsTo(EmployeeProfile::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
