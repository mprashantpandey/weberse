<?php

namespace App\Models\HRM;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobApplication extends Model
{
    protected $fillable = [
        'job_opening_id',
        'name',
        'email',
        'phone',
        'notice_period_response',
        'resume_path',
        'cover_letter',
        'application_answers',
        'status',
        'interview_status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'application_answers' => 'array',
        ];
    }

    public function jobOpening(): BelongsTo
    {
        return $this->belongsTo(JobOpening::class);
    }

    public function interviews(): HasMany
    {
        return $this->hasMany(InterviewSchedule::class, 'job_application_id');
    }
}
