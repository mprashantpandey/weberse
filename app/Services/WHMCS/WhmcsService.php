<?php

namespace App\Services\WHMCS;

use App\Models\User;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use RuntimeException;
use Throwable;

class WhmcsService
{
    public function clientSummary(User $user): array
    {
        if (! $user->whmcs_client_id) {
            return ['services' => [], 'invoices' => [], 'sso_url' => null];
        }

        try {
            return Cache::remember("whmcs-client-{$user->whmcs_client_id}", config('whmcs.cache_ttl'), function () use ($user) {
                return [
                    'services' => $this->getClientsProducts($user->whmcs_client_id),
                    'invoices' => $this->getInvoices($user->whmcs_client_id),
                    'sso_url' => $this->buildSsoUrl($user),
                ];
            });
        } catch (Throwable) {
            return ['services' => [], 'invoices' => [], 'sso_url' => $this->buildSsoUrl($user)];
        }
    }

    public function getSalesMetrics(): array
    {
        try {
            return Cache::remember('whmcs-sales-metrics', config('whmcs.cache_ttl'), function () {
                $orders = $this->request([
                    'action' => 'GetOrders',
                    'limitnum' => 20,
                ]);

                return [
                    'recent_orders' => data_get($orders, 'orders.order', []),
                    'total_results' => (int) data_get($orders, 'totalresults', 0),
                ];
            });
        } catch (Throwable) {
            return ['recent_orders' => [], 'total_results' => 0];
        }
    }

    public function buildSsoUrl(User $user): ?string
    {
        if (! $user->whmcs_client_id) {
            return null;
        }

        return rtrim(config('whmcs.base_url'), '/').config('whmcs.sso_redirect');
    }

    protected function getClientsProducts(int $clientId): array
    {
        $response = $this->request([
            'action' => 'GetClientsProducts',
            'clientid' => $clientId,
            'stats' => true,
        ]);

        return data_get($response, 'products.product', []);
    }

    protected function getInvoices(int $clientId): array
    {
        $response = $this->request([
            'action' => 'GetInvoices',
            'userid' => $clientId,
            'limitnum' => 10,
        ]);

        return data_get($response, 'invoices.invoice', []);
    }

    protected function request(array $payload): array
    {
        $response = $this->client()
            ->asForm()
            ->post('/includes/api.php', array_merge($payload, [
                'identifier' => config('whmcs.identifier'),
                'secret' => config('whmcs.secret'),
                'accesskey' => config('whmcs.access_key'),
                'responsetype' => 'json',
            ]))
            ->throw()
            ->json();

        if (($response['result'] ?? null) !== 'success') {
            throw new RuntimeException('WHMCS API request failed.');
        }

        return $response;
    }

    protected function client(): PendingRequest
    {
        return Http::baseUrl(rtrim(config('whmcs.base_url'), '/'))
            ->acceptJson()
            ->timeout(config('whmcs.timeout'));
    }
}
