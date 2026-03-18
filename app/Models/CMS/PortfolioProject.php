<?php

namespace App\Models\CMS;

use Illuminate\Database\Eloquent\Model;

class PortfolioProject extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'category',
        'client_name',
        'summary',
        'body',
        'industry',
        'project_url',
        'is_published',
        'featured_image',
        'stack',
        'metrics',
        'challenge',
        'solution',
        'outcome',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'stack' => 'array',
            'metrics' => 'array',
        ];
    }
}
