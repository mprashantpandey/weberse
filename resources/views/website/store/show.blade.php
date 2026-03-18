@extends('layouts.website')

@section('content')
    @php($user = auth()->user())
    <section class="dark-band relative overflow-hidden">
        <div class="section-shell section-spacious relative pt-12 lg:pt-16">
            <div class="grid gap-10 lg:grid-cols-[1.05fr_0.95fr] lg:items-start">
                <div class="max-w-3xl" data-reveal>
                    <div class="section-kicker">Weberse Store</div>
                    <h1 class="mt-5 headline-lg">{{ $product->name }}</h1>
                    <p class="mt-5 body-lg text-slate-300">{{ $product->short_description }}</p>

                    <div class="mt-7 flex flex-wrap gap-4">
                        <a href="{{ route('store.index') }}" class="btn-secondary">
                            @include('website.partials.icon', ['name' => 'layers', 'class' => 'h-4 w-4'])
                            Back to store
                        </a>
                        <a href="{{ route('client.downloads.index') }}" class="btn-dark">
                            @include('website.partials.icon', ['name' => 'download', 'class' => 'h-4 w-4'])
                            My downloads
                        </a>
                    </div>

                    @if (!empty($product->meta['highlights'] ?? null))
                        <div class="mt-10 grid gap-4 sm:grid-cols-3">
                            @foreach (array_slice(($product->meta['highlights'] ?? []), 0, 3) as $item)
                                <div class="glass-card premium-card flex items-center gap-4 p-5" data-reveal>
                                    <div class="premium-icon inline-flex rounded-2xl bg-white/10 p-3 text-brand-green">
                                        @include('website.partials.icon', ['name' => 'check', 'class' => 'h-5 w-5'])
                                    </div>
                                    <div class="text-sm font-semibold text-white">{{ $item }}</div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="surface-card premium-card" data-reveal>
                    <div class="panel-title">Checkout</div>
                    <div class="panel-subtitle">Pay securely via Razorpay. Downloads unlock after confirmation.</div>

                    <div class="mt-6 rounded-[24px] border border-slate-200 bg-slate-50/90 px-5 py-4">
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <div class="text-xs uppercase tracking-[0.18em] text-slate-500">Price</div>
                                <div class="mt-2 text-2xl font-semibold text-brand-blue">
                                    {{ $product->currency }} {{ number_format(($product->price_paise ?? 0) / 100, 2) }}
                                </div>
                            </div>
                            <span class="badge-chip !bg-brand-green/10 !text-brand-blue">Digital</span>
                        </div>
                    </div>

                    <div class="mt-6 space-y-3" id="store-checkout-form">
                        <div class="grid gap-3 sm:grid-cols-2">
                            <label class="block">
                                <span class="text-sm font-medium text-slate-700">Name</span>
                                <input class="input mt-2" id="buyerName" value="{{ $user?->name ?? '' }}" placeholder="Your name" required>
                            </label>
                            <label class="block">
                                <span class="text-sm font-medium text-slate-700">Phone (optional)</span>
                                <input class="input mt-2" id="buyerPhone" value="{{ $user?->phone ?? '' }}" placeholder="+91 ...">
                            </label>
                        </div>
                        <label class="block">
                            <span class="text-sm font-medium text-slate-700">Email</span>
                            <input class="input mt-2" id="buyerEmail" type="email" value="{{ $user?->email ?? '' }}" placeholder="you@example.com" required>
                        </label>

                        <button
                            class="btn-primary w-full justify-center"
                            id="buyNowBtn"
                            type="button"
                            data-checkout-create="{{ route('store.checkout.create', [], false) }}"
                            data-checkout-confirm="{{ route('store.checkout.confirm', [], false) }}"
                            data-product-id="{{ (int) $product->id }}"
                        >
                            @include('website.partials.icon', ['name' => 'sparkles', 'class' => 'h-4 w-4'])
                            Pay & unlock downloads
                        </button>

                        <div class="rounded-[20px] border border-slate-200 bg-white/80 px-4 py-3 text-sm text-slate-600" id="storeStatus" style="display:none;"></div>
                        <div class="text-xs text-slate-500">
                            Guest purchase is allowed. If you don’t have an account, we’ll create one and email a password setup link.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Checkout result alert -->
    <div id="storeAlert" class="fixed inset-0 z-[70]" style="display:none;">
        <div class="absolute inset-0 bg-black/55 backdrop-blur-sm" data-alert-close aria-hidden="true"></div>
        <div class="absolute inset-0 overflow-y-auto">
            <div class="min-h-full px-4 py-10 sm:px-6">
                <div class="mx-auto w-full max-w-xl rounded-[28px] border border-white/10 bg-white shadow-[0_30px_80px_rgba(2,12,27,0.35)]">
                    <div class="flex items-start justify-between gap-4 border-b border-slate-200 px-6 py-5">
                        <div class="min-w-0">
                            <div class="text-xs font-semibold uppercase tracking-[0.22em] text-brand-green">Checkout</div>
                            <div class="mt-2 text-2xl font-bold text-brand-blue" id="storeAlertTitle">Status</div>
                            <div class="mt-2 text-sm text-slate-600" id="storeAlertMessage"></div>
                        </div>
                        <button type="button" class="inline-flex h-11 w-11 items-center justify-center rounded-2xl border border-slate-200 bg-slate-50 text-brand-blue" data-alert-close aria-label="Close">
                            @include('website.partials.icon', ['name' => 'close', 'class' => 'h-5 w-5'])
                        </button>
                    </div>
                    <div class="px-6 py-6 flex flex-wrap gap-3 justify-end">
                        <a href="{{ route('client.downloads.index') }}" class="btn-primary" id="storeAlertDownloads" style="display:none;">
                            @include('website.partials.icon', ['name' => 'download', 'class' => 'h-4 w-4'])
                            Go to downloads
                        </a>
                        <button type="button" class="btn-secondary" data-alert-close>Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="page-panel py-20 lg:py-24">
        <div class="section-shell">
            <div class="grid gap-10 lg:grid-cols-[1.2fr_0.8fr]">
                <div class="surface-card premium-card" data-reveal>
                    <div class="panel-title">About this product</div>
                    <div class="panel-subtitle">Details, features, and requirements.</div>
                    <div class="prose prose-slate max-w-none mt-6">
                        {!! nl2br(e($product->description ?: '')) !!}
                    </div>
                </div>
                <div class="space-y-6">
                    <div class="surface-card premium-card" data-reveal>
                        <div class="panel-title">Requirements</div>
                        <div class="panel-subtitle">Basic environment needs.</div>
                        <div class="mt-6 space-y-3 text-sm text-slate-600">
                            @forelse (($product->meta['requirements'] ?? []) as $req)
                                <div class="flex items-center gap-3">
                                    <span class="mt-0.5 inline-flex h-8 w-8 items-center justify-center rounded-2xl bg-brand-surface text-brand-blue">
                                        @include('website.partials.icon', ['name' => 'check', 'class' => 'h-4 w-4'])
                                    </span>
                                    <span class="font-semibold text-slate-700">{{ $req }}</span>
                                </div>
                            @empty
                                <div class="text-slate-500">No requirements listed.</div>
                            @endforelse
                        </div>
                    </div>
                    <div class="surface-card premium-card" data-reveal>
                        <div class="panel-title">Support</div>
                        <div class="panel-subtitle">Need help with setup?</div>
                        <div class="mt-6">
                            <a href="{{ route('website.contact') }}"
                               class="btn-secondary w-full justify-center"
                               data-lead-popup
                               data-lead-title="Store Support"
                               data-lead-source="store_support"
                               data-lead-context="Support request for {{ $product->slug }}"
                               data-lead-submit="Send request">
                                @include('website.partials.icon', ['name' => 'mail', 'class' => 'h-4 w-4'])
                                Contact Weberse
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://checkout.razorpay.com/v1/checkout.js" defer></script>
    <script>
        (function () {
            const btn = document.getElementById('buyNowBtn');
            const statusEl = document.getElementById('storeStatus');
            const alertEl = document.getElementById('storeAlert');
            const alertTitleEl = document.getElementById('storeAlertTitle');
            const alertMessageEl = document.getElementById('storeAlertMessage');
            const alertDownloadsEl = document.getElementById('storeAlertDownloads');
            const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
            const checkoutCreateUrl = btn?.dataset?.checkoutCreate || '';
            const checkoutConfirmUrl = btn?.dataset?.checkoutConfirm || '';
            const productId = Number(btn?.dataset?.productId || 0);

            const openAlert = (tone, title, message) => {
                if (!alertEl) return;
                if (alertTitleEl) alertTitleEl.textContent = title || 'Status';
                if (alertMessageEl) alertMessageEl.textContent = message || '';
                if (alertDownloadsEl) {
                    alertDownloadsEl.style.display = tone === 'success' ? 'inline-flex' : 'none';
                }
                alertEl.style.display = 'block';
                document.body.classList.add('overflow-hidden');
            };
            const closeAlert = () => {
                if (!alertEl) return;
                alertEl.style.display = 'none';
                document.body.classList.remove('overflow-hidden');
            };
            alertEl?.querySelectorAll('[data-alert-close]')?.forEach((el) => el.addEventListener('click', closeAlert));

            const setStatus = (msg, tone = 'info') => {
                if (!statusEl) return;
                statusEl.style.display = 'block';
                statusEl.textContent = msg;
                statusEl.style.borderColor = tone === 'error' ? 'rgba(239,68,68,0.25)' : 'rgba(13,47,80,0.12)';
                statusEl.style.background = tone === 'error' ? 'rgba(239,68,68,0.08)' : 'rgba(255,255,255,0.8)';
                statusEl.style.color = tone === 'error' ? '#b91c1c' : '#475569';
            };

            const getValue = (id) => (document.getElementById(id)?.value || '').trim();

            btn?.addEventListener('click', async () => {
                const name = getValue('buyerName');
                const email = getValue('buyerEmail');
                const phone = getValue('buyerPhone');

                if (!name || !email) {
                    setStatus('Please enter your name and email to continue.', 'error');
                    return;
                }

                btn.disabled = true;
                setStatus('Preparing checkout…');

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
                            product_id: productId,
                            name,
                            email,
                            phone,
                        }),
                    });

                    const payload = await res.json();
                    if (!res.ok || !payload.ok) {
                        throw new Error(payload?.message || 'Checkout initialization failed.');
                    }

                    const rzp = new window.Razorpay({
                        ...payload.razorpay,
                        modal: {
                            ondismiss: function () {
                                openAlert('error', 'Payment cancelled', 'You cancelled the payment. You can try again anytime.');
                            }
                        },
                        handler: async function (response) {
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
                                openAlert('success', 'Payment successful', 'Your purchase is confirmed. Open Client Dashboard → Downloads to access your files.');
                            } catch (e) {
                                openAlert('error', 'Payment failed', e?.message || 'Payment confirmation failed.');
                            }
                        },
                    });

                    rzp.open();
                } catch (e) {
                    openAlert('error', 'Checkout failed', e?.message || 'Checkout failed. Please try again.');
                } finally {
                    btn.disabled = false;
                }
            });
        })();
    </script>
@endsection

