@extends('layouts.dashboard', [
    'title' => $product->exists ? 'Edit Product' : 'Create Product',
    'heading' => $product->exists ? 'Edit Product' : 'Create Product',
    'subheading' => 'Manage product details and uploads.',
    'nav' => [
        ['label' => 'Overview', 'route' => 'admin.dashboard', 'active' => 'admin.dashboard'],
        ['label' => 'CMS', 'route' => 'admin.cms.index', 'active' => 'admin.cms.*'],
        ['label' => 'CRM', 'route' => 'admin.crm.index', 'active' => 'admin.crm.*'],
        ['label' => 'HRM', 'route' => 'admin.hrm.index', 'active' => 'admin.hrm.*'],
        ['label' => 'Support', 'route' => 'admin.support.index', 'active' => 'admin.support.*'],
        ['label' => 'Analytics', 'route' => 'admin.analytics.index', 'active' => 'admin.analytics.*'],
    ],
])

@section('content')
    @if (session('status'))
        <div class="card mb-6 border border-green-200 bg-green-50 text-green-700">
            {{ session('status') }}
        </div>
    @endif

    <div class="section-grid xl:grid-cols-[1fr_0.9fr]">
        <div class="card">
            <div class="panel-title">Product details</div>
            <div class="panel-subtitle">Draft products are hidden from checkout.</div>

            <form
                method="POST"
                action="{{ $product->exists ? route('admin.store.products.update', $product) : route('admin.store.products.store') }}"
                class="mt-6 grid gap-4 md:grid-cols-2"
            >
                @csrf
                @if ($product->exists)
                    @method('PATCH')
                @endif

                <label class="block md:col-span-2">
                    <span class="text-sm font-medium text-slate-700">Name</span>
                    <input class="input mt-2" name="name" value="{{ old('name', $product->name) }}" required>
                    @error('name')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </label>

                <label class="block md:col-span-2">
                    <span class="text-sm font-medium text-slate-700">Slug</span>
                    <input class="input mt-2" name="slug" value="{{ old('slug', $product->slug) }}" placeholder="auto-generated if blank on create" {{ $product->exists ? 'required' : '' }}>
                    @error('slug')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </label>

                <label class="block md:col-span-2">
                    <span class="text-sm font-medium text-slate-700">Short description</span>
                    <textarea class="input mt-2 min-h-24" name="short_description" placeholder="One-line value proposition">{{ old('short_description', $product->short_description) }}</textarea>
                </label>

                <label class="block md:col-span-2">
                    <span class="text-sm font-medium text-slate-700">Description</span>
                    <textarea class="input mt-2 min-h-40" name="description" placeholder="Full description, features, requirements">{{ old('description', $product->description) }}</textarea>
                </label>

                <label class="block md:col-span-2">
                    <span class="text-sm font-medium text-slate-700">Cover image (path or URL)</span>
                    <input class="input mt-2" name="cover_image" value="{{ old('cover_image', $product->cover_image) }}" placeholder="assets/images/... or https://...">
                </label>

                <label class="block">
                    <span class="text-sm font-medium text-slate-700">Status</span>
                    <select class="input mt-2" name="status" required>
                        @foreach (['draft' => 'Draft', 'published' => 'Published', 'archived' => 'Archived'] as $value => $label)
                            <option value="{{ $value }}" @selected(old('status', $product->status ?: 'draft') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </label>

                <label class="block">
                    <span class="text-sm font-medium text-slate-700">Currency</span>
                    <input class="input mt-2" name="currency" value="{{ old('currency', $product->currency ?: 'INR') }}" required>
                </label>

                <label class="block">
                    <span class="text-sm font-medium text-slate-700">Price (paise)</span>
                    <input class="input mt-2" type="number" min="0" name="price_paise" value="{{ old('price_paise', $product->price_paise ?? 0) }}" required>
                </label>

                <div class="md:col-span-2">
                    <button class="btn-primary">{{ $product->exists ? 'Save changes' : 'Create product' }}</button>
                    <a href="{{ route('admin.store.products.index') }}" class="btn-secondary ml-2">Back</a>
                </div>
            </form>
        </div>

        <div class="space-y-6">
            <div class="card">
                <div class="panel-title">Files</div>
                <div class="panel-subtitle">Upload the ZIP/file customers will download.</div>

                @if (! $product->exists)
                    <div class="mt-5 dashboard-item-soft text-sm text-slate-600">
                        Create the product first to upload files.
                    </div>
                @else
                    <form method="POST" action="{{ route('admin.store.products.files.store', $product) }}" enctype="multipart/form-data" class="mt-6 grid gap-4">
                        @csrf
                        <label class="block">
                            <span class="text-sm font-medium text-slate-700">File</span>
                            <input class="input mt-2" type="file" name="file" required>
                            @error('file')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </label>
                        <label class="block">
                            <span class="text-sm font-medium text-slate-700">Version (optional)</span>
                            <input class="input mt-2" name="version" placeholder="1.0.0">
                        </label>
                        <label class="flex items-center gap-3 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-medium text-slate-700">
                            <input type="checkbox" name="is_primary" value="1">
                            Set as primary download
                        </label>
                        <button class="btn-primary">Upload file</button>
                    </form>

                    <div class="dashboard-list mt-6">
                        @forelse($product->files as $file)
                            <div class="dashboard-item">
                                <div class="min-w-0">
                                    <div class="flex flex-wrap items-center gap-3">
                                        <div class="font-semibold text-slate-800">{{ $file->original_name }}</div>
                                        @if ($file->is_primary)
                                            <span class="status-badge">Primary</span>
                                        @endif
                                        @if ($file->version)
                                            <span class="status-badge">v{{ $file->version }}</span>
                                        @endif
                                    </div>
                                    <div class="mt-1 text-slate-500">{{ $file->storage_path }}</div>
                                </div>
                                <div class="text-sm text-slate-600">{{ number_format(($file->size_bytes ?? 0) / 1024 / 1024, 2) }} MB</div>
                            </div>
                        @empty
                            <div class="dashboard-item-soft text-sm text-slate-500">No files uploaded yet.</div>
                        @endforelse
                    </div>
                @endif
            </div>

            <div class="card">
                <div class="panel-title">Next</div>
                <div class="panel-subtitle">Review orders and entitlements.</div>
                <div class="mt-5 grid gap-3 sm:grid-cols-2">
                    <a href="{{ route('admin.store.orders.index') }}" class="dashboard-item-soft block text-sm font-medium text-brand-blue">View Orders</a>
                    <a href="{{ route('admin.store.entitlements.index') }}" class="dashboard-item-soft block text-sm font-medium text-brand-blue">View Entitlements</a>
                </div>
            </div>
        </div>
    </div>
@endsection

