<?php

namespace App\Models\HRM;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeePerk extends Model
{
    protected $fillable = [
        'employee_profile_id',
        'created_by',
        'approved_by',
        'title',
        'perk_type',
        'value',
        'status',
        'starts_on',
        'ends_on',
        'notes',
        'review_note',
        'approved_at',
    ];

    protected function casts(): array
    {
        return [
            'starts_on' => 'date',
            'ends_on' => 'date',
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
