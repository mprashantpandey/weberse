<?php

namespace App\Models\Communication;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OutboundEmail extends Model
{
    protected $fillable = [
        'email_template_id',
        'newsletter_campaign_id',
        'user_id',
        'recipient_name',
        'recipient_email',
        'subject',
        'body',
        'status',
        'sent_at',
        'error_message',
        'meta',
    ];

    protected function casts(): array
    {
        return [
            'meta' => 'array',
            'sent_at' => 'datetime',
        ];
    }

    public function template(): BelongsTo
    {
        return $this->belongsTo(EmailTemplate::class, 'email_template_id');
    }

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(NewsletterCampaign::class, 'newsletter_campaign_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
