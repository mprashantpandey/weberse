<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Store\Order;
use Illuminate\View\View;

class StoreOrderController extends Controller
{
    public function index(): View
    {
        $orders = Order::query()->latest()->paginate(30);

        return view('admin.store.orders.index', [
            'orders' => $orders,
        ]);
    }

    public function show(Order $order): View
    {
        $order->load(['items', 'user', 'invoice.items']);

        return view('admin.store.orders.show', [
            'order' => $order,
        ]);
    }
}

