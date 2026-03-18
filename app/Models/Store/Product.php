<?php

namespace App\Models\Store;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $table = 'store_products';

    protected $fillable = [
        'name',
        'slug',
        'short_description',
        'description',
        'cover_image',
        'status',
        'currency',
        'price_paise',
        'meta',
    ];

    protected function casts(): array
    {
        return [
            'meta' => 'array',
            'price_paise' => 'integer',
        ];
    }

    public function files(): HasMany
    {
        return $this->hasMany(ProductFile::class, 'product_id');
    }
}

