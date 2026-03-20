<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Store\Entitlement;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DownloadsController extends Controller
{
    public function __invoke(): View
    {
        $entitlements = Entitlement::query()
            ->with(['product.files'])
            ->where('user_id', Auth::id())
            ->whereNull('revoked_at')
            ->latest('granted_at')
            ->get();

        return view('client.downloads.index', [
            'entitlements' => $entitlements,
        ]);
    }
}

