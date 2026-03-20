<?php

namespace App\Models\Store;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    protected $table = 'store_order_items';

    protected $fillable = [
        'order_id',
        'product_id',
        'qty',
        'unit_price_paise',
        'line_total_paise',
        'product_name_snapshot',
        'product_slug_snapshot',
        'product_version_snapshot',
    ];

    protected function casts(): array
    {
        return [
            'qty' => 'integer',
            'unit_price_paise' => 'integer',
            'line_total_paise' => 'integer',
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}

