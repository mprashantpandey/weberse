<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Store\StoreInvoice;
use App\Services\WHMCS\WhmcsService;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function __invoke(Request $request, WhmcsService $whmcs)
    {
        $user = $request->user();

        $storeInvoices = StoreInvoice::query()
            ->where(function ($q) use ($user) {
                $q->where('user_id', $user->id)
                    ->orWhere('buyer_email', $user->email);
            })
            ->latest('issued_at')
            ->limit(10)
            ->get();

        $whmcsInvoices = $whmcs->clientSummary($user)['invoices'];

        $merged = collect($whmcsInvoices)
            ->map(function (array $invoice) {
                return [
                    'source' => 'WHMCS',
                    'id' => $invoice['id'] ?? null,
                    'number' => $invoice['number'] ?? ($invoice['id'] ?? null),
                    'date' => $invoice['date'] ?? null,
                    'due_date' => $invoice['due_date'] ?? null,
                    'total' => $invoice['total'] ?? null,
                    'status' => $invoice['status'] ?? 'unknown',
                    'payment_method' => $invoice['payment_method'] ?? null,
                    'link' => $invoice['id'] ?? null,
                ];
            })
            ->merge(
                $storeInvoices->map(function (StoreInvoice $invoice) {
                    return [
                        'source' => 'Store',
                        'id' => $invoice->id,
                        'number' => $invoice->id,
                        'date' => optional($invoice->issued_at)->format('Y-m-d'),
                        'due_date' => null,
                        'total' => $invoice->currency.' '.number_format(($invoice->total_paise ?? 0) / 100, 2),
                        'status' => $invoice->status,
                        'payment_method' => 'Weberse Store',
                        'link' => route('client.store-invoices.show', $invoice),
                    ];
                })
            )
            ->sortByDesc('date')
            ->values();

        return view('client.invoices.index', [
            'invoices' => $merged,
        ]);
    }
}
