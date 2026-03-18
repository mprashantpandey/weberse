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
            return $this->emptySummary();
        }

        try {
            return Cache::remember("whmcs-client-{$user->whmcs_client_id}", config('whmcs.cache_ttl'), function () use ($user) {
                $client = $this->getClient($user->whmcs_client_id);
                $services = $this->normalizeServices($this->getClientsProducts($user->whmcs_client_id));
                $invoices = $this->normalizeInvoices($this->getInvoices($user->whmcs_client_id));
                $domains = $this->normalizeDomains($this->getClientsDomains($user->whmcs_client_id));

                return [
                    'client' => $client,
                    'services' => $services,
                    'invoices' => $invoices,
                    'domains' => $domains,
                    'sso_url' => $this->buildSsoUrl($user),
                    'summary' => [
                        'services_count' => count($services),
                        'active_services' => count(array_filter($services, fn (array $service) => strtolower((string) ($service['status'] ?? '')) === 'active')),
                        'invoice_count' => count($invoices),
                        'open_invoices' => count(array_filter($invoices, fn (array $invoice) => in_array(strtolower((string) ($invoice['status'] ?? '')), ['unpaid', 'payment pending'], true))),
                        'domains_count' => count($domains),
                    ],
                ];
            });
        } catch (Throwable) {
            return array_merge($this->emptySummary(), ['sso_url' => $this->buildSsoUrl($user)]);
        }
    }

    public function clientSummaryById(int $whmcsClientId): array
    {
        $user = new User(['whmcs_client_id' => $whmcsClientId]);

        return $this->clientSummary($user);
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

    protected function getClientsDomains(int $clientId): array
    {
        $response = $this->request([
            'action' => 'GetClientsDomains',
            'clientid' => $clientId,
            'limitnum' => 50,
        ]);

        return data_get($response, 'domains.domain', []);
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

    protected function getClient(int $clientId): array
    {
        $response = $this->request([
            'action' => 'GetClientsDetails',
            'clientid' => $clientId,
            'stats' => true,
        ]);

        return [
            'id' => (int) data_get($response, 'id', $clientId),
            'first_name' => data_get($response, 'firstname'),
            'last_name' => data_get($response, 'lastname'),
            'company_name' => data_get($response, 'companyname'),
            'email' => data_get($response, 'email'),
            'status' => data_get($response, 'status'),
            'currency_code' => data_get($response, 'currency_code'),
            'country' => data_get($response, 'country'),
        ];
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

    protected function normalizeServices(array $services): array
    {
        return collect($services)
            ->map(fn (array $service) => [
                'id' => $service['id'] ?? null,
                'name' => $service['name'] ?? 'Service',
                'group_name' => $service['groupname'] ?? null,
                'domain' => $service['domain'] ?? null,
                'username' => $service['username'] ?? null,
                'billing_cycle' => $service['billingcycle'] ?? null,
                'amount' => $service['recurringamount'] ?? ($service['amount'] ?? null),
                'next_due_date' => $service['nextduedate'] ?? null,
                'registration_date' => $service['regdate'] ?? null,
                'status' => $service['status'] ?? 'Unknown',
            ])
            ->values()
            ->all();
    }

    protected function normalizeInvoices(array $invoices): array
    {
        return collect($invoices)
            ->map(fn (array $invoice) => [
                'id' => $invoice['id'] ?? null,
                'number' => $invoice['invoicenum'] ?? ($invoice['id'] ?? null),
                'date' => $invoice['date'] ?? null,
                'due_date' => $invoice['duedate'] ?? null,
                'date_paid' => $invoice['datepaid'] ?? null,
                'total' => $invoice['total'] ?? ($invoice['amount'] ?? null),
                'status' => $invoice['status'] ?? 'Unknown',
                'payment_method' => $invoice['paymentmethod'] ?? null,
            ])
            ->values()
            ->all();
    }

    protected function normalizeDomains(array $domains): array
    {
        return collect($domains)
            ->map(fn (array $domain) => [
                'id' => $domain['id'] ?? null,
                'domain' => $domain['domainname'] ?? ($domain['domain'] ?? null),
                'registration_date' => $domain['regdate'] ?? null,
                'next_due_date' => $domain['nextduedate'] ?? null,
                'expiry_date' => $domain['expirydate'] ?? null,
                'status' => $domain['status'] ?? 'Unknown',
                'type' => $domain['type'] ?? null,
                'auto_renew' => $domain['donotrenew'] ?? null,
            ])
            ->values()
            ->all();
    }

    protected function emptySummary(): array
    {
        return [
            'client' => [],
            'services' => [],
            'invoices' => [],
            'domains' => [],
            'sso_url' => null,
            'summary' => [
                'services_count' => 0,
                'active_services' => 0,
                'invoice_count' => 0,
                'open_invoices' => 0,
                'domains_count' => 0,
            ],
        ];
    }
}
