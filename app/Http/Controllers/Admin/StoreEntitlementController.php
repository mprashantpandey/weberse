<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Store\Entitlement;
use Illuminate\View\View;

class StoreEntitlementController extends Controller
{
    public function index(): View
    {
        $entitlements = Entitlement::query()
            ->with(['user', 'product', 'order'])
            ->latest('granted_at')
            ->paginate(40);

        return view('admin.store.entitlements.index', [
            'entitlements' => $entitlements,
        ]);
    }
}

