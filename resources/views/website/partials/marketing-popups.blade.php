<div
    x-data
    x-init="
        @if(old('popup_form') || ($errors->any() && old('source')))
            $store.marketingPopup.openLead({
                title: @js(old('title', 'Start Your Project')),
                source: @js(old('source', 'website_popup')),
                context: @js(old('title', 'General inquiry')),
                submitLabel: 'Send Inquiry'
            });
        @elseif(session('status') && old('popup_form'))
            $store.marketingPopup.openLead({
                title: @js(old('title', 'Start Your Project')),
                source: @js(old('source', 'website_popup')),
                context: @js(old('title', 'General inquiry')),
                submitLabel: 'Send Inquiry'
            });
        @endif
    "
    x-show="$store.marketingPopup.open"
    x-transition.opacity
    x-effect="$store.marketingPopup.open ? document.body.classList.add('overflow-hidden') : document.body.classList.remove('overflow-hidden')"
    @keydown.escape.window="$store.marketingPopup.close()"
    class="marketing-popup-root"
    x-cloak
>
    <div class="marketing-popup-backdrop" @click="$store.marketingPopup.close()"></div>

    <div class="marketing-popup-shell">
        <div class="marketing-popup-card">
            <button type="button" class="marketing-popup-close" @click="$store.marketingPopup.close()" aria-label="Close popup">
                @include('website.partials.icon', ['name' => 'close', 'class' => 'h-5 w-5'])
            </button>

            <div class="grid gap-6 lg:grid-cols-[0.88fr_1.12fr] lg:items-stretch">
                <div class="marketing-popup-brand">
                    <div class="section-kicker">Weberse Lead Intake</div>
                    <h2 class="mt-4 text-3xl font-bold text-white md:text-4xl" x-text="$store.marketingPopup.title"></h2>
                    <p class="mt-4 text-sm leading-7 text-slate-300" x-text="$store.marketingPopup.description"></p>

                    <div class="mt-8 space-y-3">
                        <div class="marketing-popup-point">
                            <span class="marketing-popup-point-icon">@include('website.partials.icon', ['name' => 'calendar', 'class' => 'h-4 w-4'])</span>
                            <span>Fast project scoping and requirement review</span>
                        </div>
                        <div class="marketing-popup-point">
                            <span class="marketing-popup-point-icon">@include('website.partials.icon', ['name' => 'shield', 'class' => 'h-4 w-4'])</span>
                            <span>Clear next-step response from the Weberse team</span>
                        </div>
                        <div class="marketing-popup-point">
                            <span class="marketing-popup-point-icon">@include('website.partials.icon', ['name' => 'layers', 'class' => 'h-4 w-4'])</span>
                            <span>Website, platform, hosting, and growth inquiries supported</span>
                        </div>
                    </div>
                </div>

                <div class="marketing-popup-form">
                    @if (session('status'))
                        <div class="marketing-popup-success">{{ session('status') }}</div>
                    @endif

                    @if ($errors->any() && old('popup_form'))
                        <div class="mb-4 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                            Please fix the highlighted fields and try again.
                        </div>
                    @endif

                    <form method="POST" action="{{ route('website.contact.submit') }}" class="grid gap-4 md:grid-cols-2">
                        @csrf
                        <input type="hidden" name="source" :value="$store.marketingPopup.source">
                        <input type="hidden" name="title" :value="$store.marketingPopup.context">
                        <input type="hidden" name="popup_form" value="1">

                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700">Name</label>
                            <input class="input @error('name') !border-red-300 !ring-red-100 @enderror" name="name" value="{{ old('name') }}" placeholder="Your name" required>
                            @error('name')<div class="mt-2 text-xs font-semibold text-red-600">{{ $message }}</div>@enderror
                        </div>
                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700">Email</label>
                            <input class="input @error('email') !border-red-300 !ring-red-100 @enderror" type="email" name="email" value="{{ old('email') }}" placeholder="Email address" required>
                            @error('email')<div class="mt-2 text-xs font-semibold text-red-600">{{ $message }}</div>@enderror
                        </div>
                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700">Phone</label>
                            <input class="input @error('phone') !border-red-300 !ring-red-100 @enderror" name="phone" value="{{ old('phone') }}" placeholder="Phone number">
                            @error('phone')<div class="mt-2 text-xs font-semibold text-red-600">{{ $message }}</div>@enderror
                        </div>
                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700">Company</label>
                            <input class="input @error('company') !border-red-300 !ring-red-100 @enderror" name="company" value="{{ old('company') }}" placeholder="Company name">
                            @error('company')<div class="mt-2 text-xs font-semibold text-red-600">{{ $message }}</div>@enderror
                        </div>
                        <div class="md:col-span-2">
                            <label class="mb-2 block text-sm font-medium text-slate-700">How can we help?</label>
                            <textarea class="input min-h-36 @error('message') !border-red-300 !ring-red-100 @enderror" name="message" placeholder="Tell us about the project, problem, or outcome you want to achieve." required>{{ old('message') }}</textarea>
                            @error('message')<div class="mt-2 text-xs font-semibold text-red-600">{{ $message }}</div>@enderror
                        </div>
                        <button class="btn-primary md:col-span-2 justify-center" type="submit" x-text="$store.marketingPopup.submitLabel"></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
