<?php

namespace App\Models\Store;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StoreInvoiceItem extends Model
{
    protected $table = 'store_invoice_items';

    protected $fillable = [
        'invoice_id',
        'label',
        'qty',
        'unit_price_paise',
        'line_total_paise',
        'meta',
    ];

    protected function casts(): array
    {
        return [
            'qty' => 'integer',
            'unit_price_paise' => 'integer',
            'line_total_paise' => 'integer',
            'meta' => 'array',
        ];
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(StoreInvoice::class, 'invoice_id');
    }
}

