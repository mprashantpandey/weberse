@extends('layouts.website')

@section('content')
    @php
        $items = $products->getCollection();
        $categories = $items
            ->pluck('meta.category')
            ->filter()
            ->unique()
            ->values()
            ->all();
    @endphp

    <section class="dark-band relative overflow-hidden">
        <div class="section-shell section-spacious relative pt-10 lg:pt-12">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                <div class="max-w-3xl" data-reveal>
                    <div class="section-kicker">Weberse Store</div>
                    <h1 class="mt-4 headline-lg">Browse, buy, download.</h1>
                    <p class="mt-4 body-lg text-slate-300">Digital products built by Weberse — modules, templates, and operational tooling.</p>
                </div>
                <div class="flex flex-wrap gap-3" data-reveal>
                    <a href="{{ route('client.downloads.index') }}" class="btn-secondary">
                        @include('website.partials.icon', ['name' => 'download', 'class' => 'h-4 w-4'])
                        My downloads
                    </a>
                    <a href="{{ route('website.contact') }}"
                       class="btn-primary"
                       data-lead-popup
                       data-lead-title="Store Inquiry"
                       data-lead-source="store_cta"
                       data-lead-context="Store listing inquiry"
                       data-lead-submit="Send inquiry">
                        @include('website.partials.icon', ['name' => 'mail', 'class' => 'h-4 w-4'])
                        Ask support
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="page-panel py-14 lg:py-16"
             data-checkout-create="{{ route('store.checkout.create', [], false) }}"
             data-checkout-confirm="{{ route('store.checkout.confirm', [], false) }}"
             data-buyer-name="{{ auth()->user()?->name ?? '' }}"
             data-buyer-email="{{ auth()->user()?->email ?? '' }}"
             data-buyer-phone="{{ auth()->user()?->phone ?? '' }}"
             x-data="window.weberseStoreQuickBuy && window.weberseStoreQuickBuy($el)"
             @keydown.escape.window="quickBuyOpen && closeQuickBuy()">
        <div class="section-shell">
            <div class="rounded-[24px] border border-slate-200 bg-white/80 p-4 shadow-[0_16px_44px_rgba(13,47,80,0.08)] backdrop-blur-md" data-reveal>
                <div class="grid gap-3 lg:grid-cols-[1fr_auto_auto] lg:items-center">
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-4 flex items-center text-slate-400">
                            @include('website.partials.icon', ['name' => 'search', 'class' => 'h-4 w-4'])
                        </div>
                        <input type="text"
                               x-model="query"
                               placeholder="Search products…"
                               class="w-full rounded-2xl border border-slate-200 bg-white px-11 py-3 text-sm text-slate-800 shadow-sm outline-none focus:border-brand-blue/40 focus:ring-2 focus:ring-brand-blue/10">
                    </div>
                    <div class="flex flex-wrap items-center gap-2">
                        <button type="button"
                                class="rounded-full border px-4 py-2 text-xs font-semibold transition"
                                :class="category === 'All' ? 'border-brand-green/40 bg-brand-green/10 text-brand-blue' : 'border-slate-200 bg-white text-slate-700'"
                                @click="category = 'All'">
                            All
                        </button>
                        @foreach($categories as $cat)
                            <button type="button"
                                    class="rounded-full border px-4 py-2 text-xs font-semibold transition"
                                    :class="category === @js($cat) ? 'border-brand-green/40 bg-brand-green/10 text-brand-blue' : 'border-slate-200 bg-white text-slate-700'"
                                    @click="category = @js($cat)">
                                {{ $cat }}
                            </button>
                        @endforeach
                    </div>
                    <div class="flex items-center justify-between gap-3 rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700">
                        <span class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Sort</span>
                        <select x-model="sort" class="bg-transparent text-sm font-semibold text-brand-blue outline-none">
                            <option value="newest">Newest</option>
                            <option value="priceAsc">Price: Low</option>
                            <option value="priceDesc">Price: High</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="mt-6 grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                @forelse ($products as $product)
                    @php
                        $haystack = strtolower(trim(($product->name ?? '').' '.($product->short_description ?? '').' '.((string) data_get($product->meta, 'category', '')).' '.implode(' ', (array) data_get($product->meta, 'tags', []))));
                        $category = (string) data_get($product->meta, 'category', '');
                        $price = (int) ($product->price_paise ?? 0);
                        $cover = $product->cover_image ?: null;
                        $coverUrl = $cover
                            ? (\Illuminate\Support\Str::startsWith($cover, ['http://', 'https://', '/']) ? $cover : asset($cover))
                            : asset('assets/images/blog-cover.svg');
                    @endphp
                    <article class="surface-card premium-card p-5" data-reveal
                             x-data="{ haystack: @js($haystack), categoryValue: @js($category), price: {{ $price }} }"
                             x-show="(!query || haystack.includes(query.toLowerCase())) && (category === 'All' || categoryValue === category)"
                             :style="sort === 'priceAsc' ? `order:${price}` : (sort === 'priceDesc' ? `order:${1000000000 - price}` : `order:${-price}`)">
                        <a href="{{ route('store.show', $product) }}" class="group block">
                            <img src="{{ $coverUrl }}" alt="{{ $product->name }}" class="h-44 w-full rounded-[22px] object-cover shadow-[0_14px_40px_rgba(13,47,80,0.14)]">
                        </a>
                        <div class="mt-4 flex flex-wrap items-center gap-2">
                            <span class="badge-chip !bg-brand-blue/10 !text-brand-blue">{{ $category ?: 'Digital' }}</span>
                            <span class="badge-chip">Instant download</span>
                        </div>

                        <a href="{{ route('store.show', $product) }}" class="mt-3 block">
                            <h3 class="text-xl font-bold text-brand-blue leading-snug">
                                {{ $product->name }}
                            </h3>
                        </a>
                        <p class="mt-2 text-sm leading-6 text-slate-600">
                            {{ $product->short_description }}
                        </p>

                        <div class="mt-5 flex items-end justify-between gap-3">
                            <div>
                                <div class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Price</div>
                                <div class="mt-2 text-xl font-semibold text-brand-blue">
                                    {{ $product->currency }} {{ number_format(($product->price_paise ?? 0) / 100, 2) }}
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <a href="{{ route('store.show', $product) }}" class="btn-secondary !px-4 !py-2 text-xs">Details</a>
                                <button type="button"
                                        class="btn-primary !px-4 !py-2 text-xs"
                                        @click="openQuickBuy({
                                            id: {{ (int) $product->id }},
                                            name: @js($product->name),
                                            priceLabel: @js($product->currency.' '.number_format(($product->price_paise ?? 0) / 100, 2)),
                                            cover: @js($coverUrl),
                                        })">
                                    Buy
                                </button>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="surface-card md:col-span-2 xl:col-span-3" data-reveal>
                        <div class="panel-title">No products yet</div>
                        <div class="panel-subtitle">Add products from the admin dashboard to show them here.</div>
                    </div>
                @endforelse
            </div>

            <div class="mt-10">{{ $products->links() }}</div>
        </div>

        <!-- Quick Buy modal -->
        <div x-show="quickBuyOpen" x-transition.opacity class="fixed inset-0 z-[60]" x-cloak>
            <div class="absolute inset-0 bg-black/55 backdrop-blur-sm" @click="closeQuickBuy()" aria-hidden="true"></div>
            <div class="absolute inset-0 overflow-y-auto">
                <div class="min-h-full px-4 py-10 sm:px-6">
                    <div class="mx-auto w-full max-w-2xl rounded-[28px] border border-white/10 bg-white shadow-[0_30px_80px_rgba(2,12,27,0.35)]">
                        <div class="flex items-start justify-between gap-4 border-b border-slate-200 px-6 py-5">
                            <div class="min-w-0">
                                <div class="text-xs font-semibold uppercase tracking-[0.22em] text-brand-green">Quick Buy</div>
                                <div class="mt-2 text-2xl font-bold text-brand-blue" x-text="product?.name || 'Product'"></div>
                                <div class="mt-2 text-sm text-slate-600">Pay securely via Razorpay and unlock downloads.</div>
                            </div>
                            <button type="button" class="inline-flex h-11 w-11 items-center justify-center rounded-2xl border border-slate-200 bg-slate-50 text-brand-blue" @click="closeQuickBuy()" aria-label="Close">
                                @include('website.partials.icon', ['name' => 'close', 'class' => 'h-5 w-5'])
                            </button>
                        </div>

                        <div class="grid gap-6 px-6 py-6 lg:grid-cols-[0.9fr_1.1fr]">
                            <div class="rounded-[24px] border border-slate-200 bg-slate-50/90 p-4">
                                <img :src="product?.cover || ''" alt="" class="h-44 w-full rounded-[18px] object-cover">
                                <div class="mt-4 flex items-center justify-between gap-4">
                                    <div>
                                        <div class="text-xs uppercase tracking-[0.18em] text-slate-500">Price</div>
                                        <div class="mt-2 text-lg font-semibold text-brand-blue" x-text="product?.priceLabel || ''"></div>
                                    </div>
                                    <span class="badge-chip">Instant download</span>
                                </div>
                            </div>

                            <div>
                                <div class="grid gap-4 sm:grid-cols-2">
                                    <label class="block">
                                        <span class="text-sm font-medium text-slate-700">Name</span>
                                        <input class="input mt-2" x-model="buyer.name" placeholder="Your name">
                                    </label>
                                    <label class="block">
                                        <span class="text-sm font-medium text-slate-700">Phone (optional)</span>
                                        <input class="input mt-2" x-model="buyer.phone" placeholder="+91 ...">
                                    </label>
                                </div>
                                <label class="mt-4 block">
                                    <span class="text-sm font-medium text-slate-700">Email</span>
                                    <input class="input mt-2" type="email" x-model="buyer.email" placeholder="you@example.com">
                                </label>

                                <button type="button" class="btn-primary mt-5 w-full justify-center" :disabled="busy" @click="buyNow()">
                                    <span x-show="!busy">@include('website.partials.icon', ['name' => 'sparkles', 'class' => 'h-4 w-4']) Pay now</span>
                                    <span x-show="busy">Preparing…</span>
                                </button>

                                <div x-show="statusMsg" class="mt-4 rounded-[20px] border px-4 py-3 text-sm"
                                     :class="statusTone === 'error' ? 'border-red-200 bg-red-50 text-red-700' : (statusTone === 'success' ? 'border-green-200 bg-green-50 text-green-700' : 'border-slate-200 bg-white text-slate-600')"
                                     x-text="statusMsg"></div>

                                <div class="mt-3 text-xs text-slate-500">
                                    Guest checkout is allowed. If you don’t have an account, we’ll create one and email a password setup link.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Checkout result alert -->
        <div x-show="alertOpen" x-transition.opacity class="fixed inset-0 z-[70]" x-cloak>
            <div class="absolute inset-0 bg-black/55 backdrop-blur-sm" @click="closeAlert()" aria-hidden="true"></div>
            <div class="absolute inset-0 overflow-y-auto">
                <div class="min-h-full px-4 py-10 sm:px-6">
                    <div class="mx-auto w-full max-w-xl rounded-[28px] border border-white/10 bg-white shadow-[0_30px_80px_rgba(2,12,27,0.35)]">
                        <div class="flex items-start justify-between gap-4 border-b border-slate-200 px-6 py-5">
                            <div class="min-w-0">
                                <div class="text-xs font-semibold uppercase tracking-[0.22em] text-brand-green">Checkout</div>
                                <div class="mt-2 text-2xl font-bold text-brand-blue" x-text="alertTitle"></div>
                                <div class="mt-2 text-sm text-slate-600" x-text="alertMessage"></div>
                            </div>
                            <button type="button" class="inline-flex h-11 w-11 items-center justify-center rounded-2xl border border-slate-200 bg-slate-50 text-brand-blue" @click="closeAlert()" aria-label="Close">
                                @include('website.partials.icon', ['name' => 'close', 'class' => 'h-5 w-5'])
                            </button>
                        </div>
                        <div class="px-6 py-6 flex flex-wrap gap-3 justify-end">
                            <a href="{{ route('client.downloads.index') }}" class="btn-primary" x-show="alertTone === 'success'">
                                @include('website.partials.icon', ['name' => 'download', 'class' => 'h-4 w-4'])
                                Go to downloads
                            </a>
                            <button type="button" class="btn-secondary" @click="closeAlert()">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        window.weberseStoreQuickBuy = function (rootEl) {
            const getDataset = (key) => rootEl?.dataset?.[key] || '';

            return {
                query: '',
                category: 'All',
                sort: 'newest',
                quickBuyOpen: false,
                alertOpen: false,
                alertTone: 'info',
                alertTitle: 'Status',
                alertMessage: '',
                product: null,
                buyer: {
                    name: getDataset('buyerName'),
                    email: getDataset('buyerEmail'),
                    phone: getDataset('buyerPhone'),
                },
                busy: false,
                statusMsg: '',
                statusTone: 'info',
                openAlert(tone, title, message) {
                    this.alertTone = tone || 'info';
                    this.alertTitle = title || 'Status';
                    this.alertMessage = message || '';
                    this.alertOpen = true;
                    document.body.classList.add('overflow-hidden');
                },
                closeAlert() {
                    this.alertOpen = false;
                    if (!this.quickBuyOpen) {
                        document.body.classList.remove('overflow-hidden');
                    }
                },
                openQuickBuy(p) {
                    this.product = p;
                    this.statusMsg = '';
                    this.statusTone = 'info';
                    this.quickBuyOpen = true;
                    document.body.classList.add('overflow-hidden');
                },
                closeQuickBuy() {
                    this.quickBuyOpen = false;
                    document.body.classList.remove('overflow-hidden');
                },
                async buyNow() {
                    if (!this.product) return;
                    if (!this.buyer.name || !this.buyer.email) {
                        this.statusMsg = 'Please enter your name and email to continue.';
                        this.statusTone = 'error';
                        return;
                    }

                    const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
                    const checkoutCreateUrl = getDataset('checkoutCreate');
                    const checkoutConfirmUrl = getDataset('checkoutConfirm');

                    this.busy = true;
                    this.statusMsg = 'Preparing checkout…';
                    this.statusTone = 'info';

                    try {
                        const res = await fetch(checkoutCreateUrl, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': csrf,
                            },
                            credentials: 'same-origin',
                            body: JSON.stringify({
                                product_id: this.product.id,
                                name: this.buyer.name,
                                email: this.buyer.email,
                                phone: this.buyer.phone,
                            }),
                        });

                        const payload = await res.json();
                        if (!res.ok || !payload.ok) {
                            throw new Error(payload?.message || 'Checkout initialization failed.');
                        }

                        const rzp = new window.Razorpay({
                            ...payload.razorpay,
                            modal: {
                                ondismiss: () => {
                                    this.openAlert('error', 'Payment cancelled', 'You cancelled the payment. You can try again anytime.');
                                }
                            },
                            handler: async (response) => {
                                try {
                                    const confirmRes = await fetch(checkoutConfirmUrl, {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'Accept': 'application/json',
                                            'X-CSRF-TOKEN': csrf,
                                        },
                                        credentials: 'same-origin',
                                        body: JSON.stringify({
                                            order_id: payload.order_id,
                                            razorpay_order_id: response.razorpay_order_id,
                                            razorpay_payment_id: response.razorpay_payment_id,
                                            razorpay_signature: response.razorpay_signature,
                                        }),
                                    });
                                    const confirmJson = await confirmRes.json();
                                    if (!confirmRes.ok || !confirmJson.ok) {
                                        throw new Error(confirmJson?.message || 'Payment confirmation failed.');
                                    }
                                    this.closeQuickBuy();
                                    this.openAlert('success', 'Payment successful', 'Your purchase is confirmed. Open Client Dashboard → Downloads to access your files.');
                                } catch (e) {
                                    this.openAlert('error', 'Payment failed', e?.message || 'Payment confirmation failed.');
                                }
                            },
                        });

                        rzp.open();
                    } catch (e) {
                        this.openAlert('error', 'Checkout failed', e?.message || 'Checkout failed. Please try again.');
                    } finally {
                        this.busy = false;
                    }
                },
            };
        };
    </script>
    <script src="https://checkout.razorpay.com/v1/checkout.js" defer></script>
@endsection

