<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Store\Product;
use App\Models\Store\ProductFile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class StoreProductController extends Controller
{
    public function index(): View
    {
        $products = Product::query()->latest()->paginate(20);

        return view('admin.store.products.index', [
            'products' => $products,
        ]);
    }

    public function create(): View
    {
        return view('admin.store.products.form', [
            'product' => new Product(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255'],
            'short_description' => ['nullable', 'string', 'max:500'],
            'description' => ['nullable', 'string'],
            'cover_image' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:draft,published,archived'],
            'currency' => ['required', 'string', 'size:3'],
            'price_paise' => ['required', 'integer', 'min:0'],
        ]);

        $data['slug'] = filled($data['slug'] ?? null) ? $data['slug'] : Str::slug($data['name']);

        $product = Product::query()->create($data);

        return redirect()->route('admin.store.products.edit', $product)->with('status', 'Product created.');
    }

    public function edit(Product $product): View
    {
        $product->load('files');

        return view('admin.store.products.form', [
            'product' => $product,
        ]);
    }

    public function update(Product $product, Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255'],
            'short_description' => ['nullable', 'string', 'max:500'],
            'description' => ['nullable', 'string'],
            'cover_image' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:draft,published,archived'],
            'currency' => ['required', 'string', 'size:3'],
            'price_paise' => ['required', 'integer', 'min:0'],
        ]);

        $product->update($data);

        return back()->with('status', 'Product updated.');
    }

    public function storeFile(Product $product, Request $request): RedirectResponse
    {
        $data = $request->validate([
            'file' => ['required', 'file', 'max:512000'], // 500MB
            'version' => ['nullable', 'string', 'max:50'],
            'is_primary' => ['nullable'],
        ]);

        $uploaded = $request->file('file');
        $original = $uploaded->getClientOriginalName();
        $safeName = now()->format('YmdHis').'_'.Str::random(6).'_'.Str::slug(pathinfo($original, PATHINFO_FILENAME));
        $ext = $uploaded->getClientOriginalExtension();
        $filename = $ext ? ($safeName.'.'.$ext) : $safeName;

        $dir = 'store/products/'.$product->id;
        $path = Storage::disk('local')->putFileAs($dir, $uploaded, $filename);

        if (($data['is_primary'] ?? null) !== null) {
            ProductFile::query()->where('product_id', $product->id)->update(['is_primary' => false]);
        }

        $fullPath = Storage::disk('local')->path($path);
        $checksum = is_file($fullPath) ? hash_file('sha256', $fullPath) : null;

        ProductFile::query()->create([
            'product_id' => $product->id,
            'version' => $data['version'] ?? null,
            'original_name' => $original,
            'storage_path' => $path,
            'size_bytes' => (int) $uploaded->getSize(),
            'checksum_sha256' => $checksum,
            'is_primary' => ($data['is_primary'] ?? null) !== null,
        ]);

        return back()->with('status', 'File uploaded.');
    }
}

