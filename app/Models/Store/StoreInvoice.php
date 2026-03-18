<?php

namespace App\Models\Store;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StoreInvoice extends Model
{
    protected $table = 'store_invoices';

    protected $fillable = [
        'order_id',
        'user_id',
        'buyer_name',
        'buyer_email',
        'currency',
        'subtotal_paise',
        'total_paise',
        'status',
        'issued_at',
        'meta',
    ];

    protected function casts(): array
    {
        return [
            'subtotal_paise' => 'integer',
            'total_paise' => 'integer',
            'issued_at' => 'datetime',
            'meta' => 'array',
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(StoreInvoiceItem::class, 'invoice_id');
    }
}

