<?php

namespace App\Services\Store;

use App\Enums\UserRole;
use App\Services\Auth\AccountClaimService;
use App\Models\Store\Entitlement;
use App\Models\Store\Order;
use App\Models\Store\Product;
use App\Models\Store\StoreInvoice;
use App\Models\Store\StoreInvoiceItem;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class StoreOrderService
{
    public function __construct(
        protected readonly AccountClaimService $claims,
    ) {
    }

    public function markPaidFromWebhook(Order $order, ?string $providerPaymentId, array $webhookPayload = []): Order
    {
        return DB::transaction(function () use ($order, $providerPaymentId, $webhookPayload) {
            $order->refresh();

            if ($order->status === 'paid') {
                return $order;
            }

            $order->status = 'paid';
            $order->provider_payment_id = $providerPaymentId ?: $order->provider_payment_id;
            $order->paid_at = now();
            $order->meta = array_merge($order->meta ?? [], [
                'webhook' => $webhookPayload,
            ]);
            $order->save();

            if (! $order->user_id) {
                $user = User::query()->where('email', $order->buyer_email)->first();
                if ($user) {
                    $order->user()->associate($user);
                    $order->save();
                } else {
                    $created = User::query()->create([
                        'name' => $order->buyer_name ?: 'Store Customer',
                        'email' => $order->buyer_email,
                        'phone' => $order->buyer_phone,
                        'password' => bin2hex(random_bytes(16)),
                        'is_active' => true,
                    ]);
                    $created->assignRole(UserRole::Client->value);

                    $order->user()->associate($created);
                    $order->save();

                    $plain = $this->claims->issueForUser($created);
                    $this->claims->sendClaimEmail($created, $plain);
                }
            }

            if ($order->user_id) {
                foreach ($order->items as $item) {
                    Entitlement::query()->firstOrCreate([
                        'user_id' => $order->user_id,
                        'product_id' => $item->product_id,
                        'order_id' => $order->id,
                    ], [
                        'granted_at' => now(),
                    ]);
                }
            }

            $this->ensureInvoice($order);

            return $order;
        });
    }

    protected function ensureInvoice(Order $order): void
    {
        if ($order->invoice) {
            return;
        }

        $invoice = StoreInvoice::query()->create([
            'order_id' => $order->id,
            'user_id' => $order->user_id,
            'buyer_name' => $order->buyer_name,
            'buyer_email' => $order->buyer_email,
            'currency' => $order->currency,
            'subtotal_paise' => $order->subtotal_paise,
            'total_paise' => $order->total_paise,
            'status' => 'issued',
            'issued_at' => now(),
        ]);

        $order->loadMissing('items');

        foreach ($order->items as $item) {
            StoreInvoiceItem::query()->create([
                'invoice_id' => $invoice->id,
                'label' => $item->product_name_snapshot,
                'qty' => $item->qty,
                'unit_price_paise' => $item->unit_price_paise,
                'line_total_paise' => $item->line_total_paise,
                'meta' => [
                    'product_id' => $item->product_id,
                    'product_slug' => $item->product_slug_snapshot,
                    'version' => $item->product_version_snapshot,
                ],
            ]);
        }
    }

    public function buildSingleProductOrder(User|string|null $userOrEmail, Product $product, array $buyer): Order
    {
        return DB::transaction(function () use ($userOrEmail, $product, $buyer) {
            $email = is_string($userOrEmail) ? $userOrEmail : ($userOrEmail?->email);
            $userId = $userOrEmail instanceof User ? $userOrEmail->id : null;

            $subtotal = (int) $product->price_paise;

            $order = Order::query()->create([
                'user_id' => $userId,
                'buyer_name' => $buyer['name'] ?? null,
                'buyer_email' => (string) $email,
                'buyer_phone' => $buyer['phone'] ?? null,
                'currency' => (string) ($product->currency ?: 'INR'),
                'subtotal_paise' => $subtotal,
                'total_paise' => $subtotal,
                'status' => 'pending',
                'payment_provider' => 'razorpay',
            ]);

            $primaryFile = $product->files()->where('is_primary', true)->orderByDesc('id')->first();

            $order->items()->create([
                'product_id' => $product->id,
                'qty' => 1,
                'unit_price_paise' => $subtotal,
                'line_total_paise' => $subtotal,
                'product_name_snapshot' => $product->name,
                'product_slug_snapshot' => $product->slug,
                'product_version_snapshot' => $primaryFile?->version,
            ]);

            return $order->fresh(['items']);
        });
    }
}

