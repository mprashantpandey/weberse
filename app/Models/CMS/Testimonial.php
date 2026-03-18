<?php

namespace App\Models\CMS;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = ['name', 'company', 'quote', 'avatar', 'is_published'];

    protected function casts(): array
    {
        return ['is_published' => 'boolean'];
    }
}
