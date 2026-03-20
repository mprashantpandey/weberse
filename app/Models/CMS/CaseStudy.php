<?php

namespace App\Models\CMS;

use Illuminate\Database\Eloquent\Model;

class CaseStudy extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'summary',
        'client',
        'industry',
        'duration',
        'engagement',
        'featured_image',
        'services',
        'stack',
        'challenge',
        'solution',
        'outcome',
        'results',
        'metrics',
        'quote',
        'quote_author',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'services' => 'array',
            'stack' => 'array',
            'results' => 'array',
            'metrics' => 'array',
            'is_published' => 'boolean',
        ];
    }
}
