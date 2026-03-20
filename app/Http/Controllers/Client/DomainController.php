<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\WHMCS\WhmcsService;
use Illuminate\Http\Request;

class DomainController extends Controller
{
    public function __invoke(Request $request, WhmcsService $whmcs)
    {
        $hosting = $whmcs->clientSummary($request->user());

        return view('client.domains.index', [
            'hosting' => $hosting,
            'domains' => $hosting['domains'] ?? [],
        ]);
    }
}
