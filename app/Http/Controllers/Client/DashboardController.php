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
        return view('client.dashboard.index', [
            'hosting' => $whmcs->clientSummary($request->user()),
            'documents' => ClientDocument::query()->where('user_id', $request->user()->id)->latest()->take(5)->get(),
            'tickets' => SupportTicket::query()->where('user_id', $request->user()->id)->latest()->take(5)->get(),
        ]);
    }
}
