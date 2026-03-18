<?php

namespace App\Models\HRM;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EmployeeProfile extends Model
{
    protected $fillable = ['user_id', 'department_id', 'employee_code', 'join_date', 'employment_status', 'emergency_contact', 'documents'];

    protected function casts(): array
    {
        return [
            'join_date' => 'date',
            'documents' => 'array',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function leaveRequests(): HasMany
    {
        return $this->hasMany(LeaveRequest::class);
    }

    public function attendanceRecords(): HasMany
    {
        return $this->hasMany(AttendanceRecord::class);
    }

    public function compensationRecords(): HasMany
    {
        return $this->hasMany(CompensationRecord::class);
    }

    public function expenseClaims(): HasMany
    {
        return $this->hasMany(ExpenseClaim::class);
    }

    public function perks(): HasMany
    {
        return $this->hasMany(EmployeePerk::class);
    }
}
