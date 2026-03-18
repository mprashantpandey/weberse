<?php

namespace App\Models\Store;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductFile extends Model
{
    protected $table = 'store_product_files';

    protected $fillable = [
        'product_id',
        'version',
        'original_name',
        'storage_path',
        'size_bytes',
        'checksum_sha256',
        'is_primary',
    ];

    protected function casts(): array
    {
        return [
            'size_bytes' => 'integer',
            'is_primary' => 'boolean',
        ];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}

