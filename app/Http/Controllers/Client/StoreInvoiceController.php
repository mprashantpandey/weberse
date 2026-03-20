<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Store\StoreInvoice;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StoreInvoiceController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $invoices = StoreInvoice::query()
            ->with('items')
            ->where(function ($q) use ($user) {
                $q->where('user_id', $user->id)
                    ->orWhere('buyer_email', $user->email);
            })
            ->latest('issued_at')
            ->paginate(15);

        return view('client.store-invoices.index', [
            'storeInvoices' => $invoices,
        ]);
    }

    public function show(Request $request, StoreInvoice $invoice): View
    {
        $user = $request->user();

        abort_unless($invoice->user_id === $user->id || $invoice->buyer_email === $user->email, 403);

        $invoice->load('items');

        return view('client.store-invoices.show', [
            'invoice' => $invoice,
        ]);
    }

    public function download(Request $request, StoreInvoice $invoice)
    {
        $user = $request->user();

        abort_unless($invoice->user_id === $user->id || $invoice->buyer_email === $user->email, 403);

        $invoice->load('items');

        $html = view('client.store-invoices.download', [
            'invoice' => $invoice,
        ])->render();

        $filename = 'weberse-invoice-'.$invoice->id.'.html';

        return response($html, 200, [
            'Content-Type' => 'text/html; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        ]);
    }
}

