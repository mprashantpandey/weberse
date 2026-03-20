<?php

namespace App\Models\Communication;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NewsletterCampaign extends Model
{
    protected $fillable = [
        'email_template_id',
        'title',
        'subject',
        'body',
        'status',
        'target_segment',
        'sent_at',
        'sent_count',
        'last_error',
    ];

    protected function casts(): array
    {
        return [
            'sent_at' => 'datetime',
        ];
    }

    public function template(): BelongsTo
    {
        return $this->belongsTo(EmailTemplate::class, 'email_template_id');
    }

    public function deliveries(): HasMany
    {
        return $this->hasMany(OutboundEmail::class);
    }
}
