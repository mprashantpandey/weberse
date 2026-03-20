<?php

namespace App\Models\Store;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DownloadToken extends Model
{
    protected $table = 'store_download_tokens';

    protected $fillable = [
        'user_id',
        'entitlement_id',
        'token',
        'expires_at',
        'max_downloads',
        'downloads_count',
        'last_downloaded_at',
    ];

    protected function casts(): array
    {
        return [
            'expires_at' => 'datetime',
            'max_downloads' => 'integer',
            'downloads_count' => 'integer',
            'last_downloaded_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function entitlement(): BelongsTo
    {
        return $this->belongsTo(Entitlement::class, 'entitlement_id');
    }
}

