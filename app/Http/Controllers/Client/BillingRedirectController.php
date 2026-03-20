<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\WHMCS\WhmcsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BillingRedirectController extends Controller
{
    public function portal(Request $request, WhmcsService $whmcs): RedirectResponse
    {
        return redirect()->away($whmcs->buildSsoUrl($request->user()) ?: route('billing'));
    }

    public function invoice(Request $request, WhmcsService $whmcs, int $invoiceId): RedirectResponse
    {
        return redirect()->away($whmcs->invoiceUrl($request->user(), $invoiceId) ?: route('billing'));
    }

    public function domain(Request $request, WhmcsService $whmcs, int $domainId): RedirectResponse
    {
        return redirect()->away($whmcs->domainUrl($request->user(), $domainId) ?: route('billing'));
    }

    public function service(Request $request, WhmcsService $whmcs, int $serviceId): RedirectResponse
    {
        return redirect()->away($whmcs->serviceUrl($request->user(), $serviceId) ?: route('billing'));
    }
}
