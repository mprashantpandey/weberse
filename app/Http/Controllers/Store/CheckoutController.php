<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Store\Order;
use App\Models\Store\Product;
use App\Services\Store\RazorpayService;
use App\Services\Store\StoreOrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use RuntimeException;

class CheckoutController extends Controller
{
    public function create(Request $request, StoreOrderService $orders, RazorpayService $razorpay): JsonResponse
    {
        $data = $request->validate([
            'product_id' => ['required', 'integer', 'exists:store_products,id'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
        ]);

        /** @var Product $product */
        $product = Product::query()->where('status', 'published')->findOrFail((int) $data['product_id']);

        $user = $request->user();
        $order = $orders->buildSingleProductOrder($user ?: $data['email'], $product, [
            'name' => $data['name'],
            'phone' => $data['phone'] ?? null,
        ]);

        $receipt = 'wbs_store_'.$order->id.'_'.Str::random(10);
        $rpOrder = $razorpay->createOrder($order->total_paise, $order->currency, $receipt, [
            'store_order_id' => (string) $order->id,
            'product' => $product->slug,
        ]);

        $order->provider_order_id = (string) ($rpOrder['id'] ?? '');
        if ($order->provider_order_id === '') {
            throw new RuntimeException('Razorpay order ID missing.');
        }
        $order->meta = array_merge($order->meta ?? [], ['razorpay_order' => $rpOrder]);
        $order->save();

        return response()->json([
            'ok' => true,
            'order_id' => $order->id,
            'razorpay' => [
                // Razorpay Checkout expects the field name "key"
                'key' => $razorpay->publicKeyId(),
                'order_id' => $order->provider_order_id,
                'amount' => $order->total_paise,
                'currency' => $order->currency,
                'name' => 'Weberse',
                'description' => $product->name,
                'prefill' => [
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'contact' => $data['phone'] ?? '',
                ],
                'notes' => [
                    'store_order_id' => (string) $order->id,
                ],
            ],
        ]);
    }

    public function confirm(Request $request, RazorpayService $razorpay, StoreOrderService $orders): JsonResponse
    {
        $data = $request->validate([
            'order_id' => ['required', 'integer', 'exists:store_orders,id'],
            'razorpay_order_id' => ['required', 'string', 'max:100'],
            'razorpay_payment_id' => ['required', 'string', 'max:100'],
            'razorpay_signature' => ['required', 'string', 'max:255'],
        ]);

        /** @var Order $order */
        $order = Order::query()->findOrFail((int) $data['order_id']);

        if ($order->provider_order_id !== $data['razorpay_order_id']) {
            return response()->json(['ok' => false, 'message' => 'Order mismatch.'], 422);
        }

        $valid = $razorpay->verifyCheckoutSignature(
            $data['razorpay_order_id'],
            $data['razorpay_payment_id'],
            $data['razorpay_signature']
        );

        if (! $valid) {
            return response()->json(['ok' => false, 'message' => 'Invalid payment signature.'], 422);
        }

        // Fulfill immediately after verification (creates entitlements + invoice).
        // Webhook will still be idempotent if/when it arrives.
        $orders->markPaidFromWebhook($order, $data['razorpay_payment_id'], [
            'source' => 'checkout_confirm',
            'confirmed_at' => now()->toISOString(),
        ]);

        // Ensure signature and payment IDs are stored for audit trail.
        $order->provider_payment_id = $data['razorpay_payment_id'];
        $order->provider_signature = $data['razorpay_signature'];
        $order->meta = array_merge($order->meta ?? [], [
            'checkout' => [
                'confirmed_at' => now()->toISOString(),
            ],
        ]);
        $order->save();

        return response()->json([
            'ok' => true,
            'message' => 'Payment received. Finalizing your order…',
        ]);
    }
}

