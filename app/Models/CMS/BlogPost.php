<?php

namespace App\Models\CMS;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BlogPost extends Model
{
    protected $fillable = ['title', 'slug', 'excerpt', 'body', 'cover_image', 'is_published', 'published_at', 'author_id', 'seo_title', 'seo_description'];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'author_id');
    }
}
