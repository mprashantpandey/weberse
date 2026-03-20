<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Store\Product;
use Illuminate\View\View;

class StorefrontController extends Controller
{
    public function index(): View
    {
        $products = Product::query()
            ->where('status', 'published')
            ->latest()
            ->paginate(12);

        return view('website.store.index', [
            'title' => 'Store',
            'description' => 'Weberse digital products: templates, modules, and business tooling.',
            'products' => $products,
        ]);
    }

    public function show(Product $product): View
    {
        abort_if($product->status !== 'published', 404);

        $product->load('files');

        return view('website.store.show', [
            'title' => $product->name.' · Store',
            'description' => $product->short_description ?: 'Weberse digital product',
            'product' => $product,
        ]);
    }
}

