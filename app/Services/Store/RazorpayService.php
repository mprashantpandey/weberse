<?php

namespace App\Services\Store;

use App\Services\Settings\SiteSettingsService;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class RazorpayService
{
    public function __construct(
        protected readonly SiteSettingsService $settings,
    ) {
    }

    public function createOrder(int $amountPaise, string $currency, string $receipt, array $notes = []): array
    {
        $response = $this->client()->post('/v1/orders', [
            'amount' => $amountPaise,
            'currency' => $currency,
            'receipt' => $receipt,
            'notes' => (object) $notes,
        ]);

        if (! $response->successful()) {
            throw new RuntimeException('Failed to create Razorpay order.');
        }

        return $response->json();
    }

    public function verifyCheckoutSignature(string $razorpayOrderId, string $razorpayPaymentId, string $razorpaySignature): bool
    {
        $secret = $this->secret();
        $payload = $razorpayOrderId.'|'.$razorpayPaymentId;
        $expected = hash_hmac('sha256', $payload, $secret);

        return hash_equals($expected, $razorpaySignature);
    }

    public function verifyWebhookSignature(string $rawPayload, string $providedSignature): bool
    {
        $secret = (string) ($this->settings->getStorePaymentSettings()['razorpay_webhook_secret'] ?? config('razorpay.webhook_secret'));
        if ($secret === '') {
            return false;
        }

        $expected = hash_hmac('sha256', $rawPayload, $secret);

        return hash_equals($expected, $providedSignature);
    }

    public function publicKeyId(): string
    {
        $keyId = (string) ($this->settings->getStorePaymentSettings()['razorpay_key_id'] ?? config('razorpay.key_id'));
        if ($keyId === '') {
            throw new RuntimeException('Razorpay key ID is not configured.');
        }

        return $keyId;
    }

    protected function client(): PendingRequest
    {
        $keyId = $this->publicKeyId();
        $secret = $this->secret();

        return Http::baseUrl(rtrim((string) config('razorpay.api_base'), '/'))
            ->withBasicAuth($keyId, $secret)
            ->acceptJson()
            ->asJson()
            ->timeout((int) config('razorpay.timeout', 15));
    }

    protected function secret(): string
    {
        $secret = (string) ($this->settings->getStorePaymentSettings()['razorpay_key_secret'] ?? config('razorpay.key_secret'));
        if ($secret === '') {
            throw new RuntimeException('Razorpay secret is not configured.');
        }

        return $secret;
    }
}

