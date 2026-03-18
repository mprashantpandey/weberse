<?php

namespace App\Models\Communication;

use Illuminate\Database\Eloquent\Model;

class NewsletterSubscriber extends Model
{
    protected $fillable = [
        'name',
        'email',
        'status',
        'source',
        'meta',
        'subscribed_at',
        'unsubscribed_at',
        'last_sent_at',
    ];

    protected function casts(): array
    {
        return [
            'meta' => 'array',
            'subscribed_at' => 'datetime',
            'unsubscribed_at' => 'datetime',
            'last_sent_at' => 'datetime',
        ];
    }
}
