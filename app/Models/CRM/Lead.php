<?php

namespace App\Models\CRM;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lead extends Model
{
    protected $fillable = [
        'contact_id',
        'owner_id',
        'title',
        'source',
        'stage',
        'status',
        'estimated_value',
        'message',
        'next_follow_up_at',
        'last_contacted_at',
        'proposal_sent_at',
        'proposal_amount',
        'proposal_reference',
        'lost_reason',
    ];

    protected function casts(): array
    {
        return [
            'estimated_value' => 'decimal:2',
            'proposal_amount' => 'decimal:2',
            'next_follow_up_at' => 'datetime',
            'last_contacted_at' => 'datetime',
            'proposal_sent_at' => 'datetime',
        ];
    }

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function notes(): HasMany
    {
        return $this->hasMany(LeadNote::class);
    }

    public function followUps(): HasMany
    {
        return $this->hasMany(FollowUp::class);
    }
}
