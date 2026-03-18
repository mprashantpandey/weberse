<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\ClientDocument;
use App\Models\Support\SupportTicket;
use App\Services\WHMCS\WhmcsService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request, WhmcsService $whmcs)
    {
        $hosting = $whmcs->clientSummary($request->user());

        return view('client.dashboard.index', [
            'hosting' => $hosting,
            'documents' => ClientDocument::query()->where('user_id', $request->user()->id)->latest()->take(5)->get(),
            'tickets' => SupportTicket::query()->where('user_id', $request->user()->id)->latest()->take(5)->get(),
            'upcomingInvoice' => collect($hosting['invoices'] ?? [])
                ->first(fn (array $invoice) => in_array(strtolower((string) ($invoice['status'] ?? '')), ['unpaid', 'payment pending'], true)),
        ]);
    }
}
