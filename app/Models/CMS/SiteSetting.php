<?php

namespace App\Models\CMS;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = ['group', 'key', 'value', 'type', 'is_public'];

    protected function casts(): array
    {
        return [
            'value' => 'array',
            'is_public' => 'boolean',
        ];
    }
}
