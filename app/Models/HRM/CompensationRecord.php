<?php

namespace App\Models\HRM;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompensationRecord extends Model
{
    protected $fillable = [
        'employee_profile_id',
        'title',
        'pay_type',
        'amount',
        'currency',
        'effective_from',
        'effective_to',
        'status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'effective_from' => 'date',
            'effective_to' => 'date',
            'amount' => 'decimal:2',
        ];
    }

    public function employeeProfile(): BelongsTo
    {
        return $this->belongsTo(EmployeeProfile::class);
    }
}
