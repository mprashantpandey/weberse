<?php

namespace App\Models\HRM;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobOpening extends Model
{
    protected $fillable = [
        'department_id',
        'title',
        'slug',
        'location',
        'employment_type',
        'description',
        'salary_min',
        'salary_max',
        'salary_currency',
        'experience_min',
        'experience_max',
        'notice_period',
        'immediate_joiner_preferred',
        'skills',
        'application_questions',
        'is_published',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'published_at' => 'datetime',
            'immediate_joiner_preferred' => 'boolean',
            'skills' => 'array',
            'application_questions' => 'array',
        ];
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function applications(): HasMany
    {
        return $this->hasMany(JobApplication::class);
    }
}
