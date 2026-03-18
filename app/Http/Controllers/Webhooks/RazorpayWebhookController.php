<?php

namespace App\Http\Controllers\Webhooks;

use App\Http\Controllers\Controller;
use App\Models\Store\Order;
use App\Services\Store\RazorpayService;
use App\Services\Store\StoreOrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class RazorpayWebhookController extends Controller
{
    public function __invoke(Request $request, RazorpayService $razorpay, StoreOrderService $orders): Response
    {
        $signature = (string) $request->header('X-Razorpay-Signature', '');
        $raw = (string) $request->getContent();

        if (! $razorpay->verifyWebhookSignature($raw, $signature)) {
            return response('Invalid signature', 400);
        }

        $payload = $request->json()->all();
        $event = (string) ($payload['event'] ?? '');

        $providerOrderId = (string) Arr::get($payload, 'payload.payment.entity.order_id', '');
        $providerPaymentId = (string) Arr::get($payload, 'payload.payment.entity.id', '');
        $notesStoreOrderId = Arr::get($payload, 'payload.payment.entity.notes.store_order_id');

        $order = null;
        if (is_numeric($notesStoreOrderId)) {
            $order = Order::query()->find((int) $notesStoreOrderId);
        }

        if (! $order && $providerOrderId !== '') {
            $order = Order::query()->where('provider_order_id', $providerOrderId)->first();
        }

        if (! $order) {
            Log::warning('Razorpay webhook: order not found', [
                'event' => $event,
                'provider_order_id' => $providerOrderId,
                'provider_payment_id' => $providerPaymentId,
                'notes_store_order_id' => $notesStoreOrderId,
            ]);

            return response('ok', 200);
        }

        if (in_array($event, ['payment.captured', 'order.paid'], true)) {
            $orders->markPaidFromWebhook($order, $providerPaymentId, $payload);
        }

        if ($event === 'payment.failed') {
            $order->status = $order->status === 'paid' ? 'paid' : 'failed';
            $order->meta = array_merge($order->meta ?? [], ['webhook_failed' => $payload]);
            $order->save();
        }

        return response('ok', 200);
    }
}

