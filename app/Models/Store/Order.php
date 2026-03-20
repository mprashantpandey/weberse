<?php

namespace App\Models\Store;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    protected $table = 'store_orders';

    protected $fillable = [
        'user_id',
        'buyer_name',
        'buyer_email',
        'buyer_phone',
        'currency',
        'subtotal_paise',
        'total_paise',
        'status',
        'payment_provider',
        'provider_order_id',
        'provider_payment_id',
        'provider_signature',
        'paid_at',
        'meta',
    ];

    protected function casts(): array
    {
        return [
            'subtotal_paise' => 'integer',
            'total_paise' => 'integer',
            'paid_at' => 'datetime',
            'meta' => 'array',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function entitlements(): HasMany
    {
        return $this->hasMany(Entitlement::class, 'order_id');
    }

    public function invoice(): HasOne
    {
        return $this->hasOne(StoreInvoice::class, 'order_id');
    }
}

