<?php

namespace App\Models\CMS;

use Illuminate\Database\Eloquent\Model;

class MediaAsset extends Model
{
    protected $fillable = [
        'name',
        'path',
        'folder',
        'tags',
        'mime_type',
        'size_bytes',
        'width',
        'height',
        'optimized_path',
        'hash',
    ];

    protected function casts(): array
    {
        return [
            'tags' => 'array',
            'size_bytes' => 'integer',
            'width' => 'integer',
            'height' => 'integer',
        ];
    }
}
