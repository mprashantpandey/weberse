<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\WHMCS\WhmcsService;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function __invoke(Request $request, WhmcsService $whmcs)
    {
        return view('client.invoices.index', [
            'invoices' => $whmcs->clientSummary($request->user())['invoices'],
        ]);
    }
}
