@extends('layouts.website', [
    'title' => 'Contact | Weberse Infotech',
    'description' => 'Contact Weberse Infotech for premium websites, custom platforms, AI automation, hosting, and digital growth systems.',
])

@section('content')
    <section class="dark-band relative overflow-hidden">
        <div class="section-shell section-spacious">
            <div class="grid gap-10 lg:grid-cols-[1.05fr_0.95fr] lg:items-center">
                <div class="space-y-7" data-reveal>
                    <div class="section-kicker">Contact</div>
                    <h1 class="headline-lg">Tell us what you need.</h1>
                    <p class="body-lg text-slate-300">Share the project or challenge and we’ll recommend the best next step—scope, timeline, and what to build first.</p>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div class="glass-card">
                            <div class="text-sm font-semibold uppercase tracking-[0.22em] text-brand-green">Email</div>
                            <div class="mt-3 flex items-center gap-3 text-slate-200">
                                @include('website.partials.icon', ['name' => 'mail', 'class' => 'h-5 w-5'])
                                <span class="font-semibold text-white">{{ $companyProfile['email'] ?? config('platform.company.email') }}</span>
                            </div>
                            <div class="mt-3 text-sm text-slate-300">Best for detailed requirements and attachments.</div>
                        </div>
                        <div class="glass-card">
                            <div class="text-sm font-semibold uppercase tracking-[0.22em] text-brand-green">Call</div>
                            <div class="mt-3 flex items-center gap-3 text-slate-200">
                                @include('website.partials.icon', ['name' => 'phone', 'class' => 'h-5 w-5'])
                                <span class="font-semibold text-white">{{ $companyProfile['phone'] ?? config('platform.company.phone') }}</span>
                            </div>
                            <div class="mt-3 text-sm text-slate-300">Best for quick scope clarity and timelines.</div>
                        </div>
                        <div class="glass-card sm:col-span-2">
                            <div class="text-sm font-semibold uppercase tracking-[0.22em] text-brand-green">Location</div>
                            <div class="mt-3 flex items-center gap-3 text-slate-200">
                                @include('website.partials.icon', ['name' => 'map-pin', 'class' => 'h-5 w-5'])
                                <span class="font-semibold text-white">{{ ($companyProfile['address_line_1'] ?? null) ?: ($companyProfile['location'] ?? config('platform.company.location')) }}</span>
                            </div>
                            <div class="mt-3 text-sm text-slate-300">Remote-friendly delivery with structured communication.</div>
                        </div>
                    </div>

                    <div class="mt-2 flex flex-wrap gap-3 text-sm text-slate-300">
                        @foreach ([
                            ['icon' => 'calendar', 'label' => 'Fast response'],
                            ['icon' => 'layers', 'label' => 'Clear scoping'],
                            ['icon' => 'shield', 'label' => 'Practical guidance'],
                            ['icon' => 'chart', 'label' => 'Delivery clarity'],
                        ] as $chip)
                            <div class="inline-flex items-center gap-2 rounded-2xl border border-white/10 bg-white/5 px-4 py-2">
                                @include('website.partials.icon', ['name' => $chip['icon'], 'class' => 'h-4 w-4'])
                                <span>{{ $chip['label'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="hero-media-stage" data-reveal>
                    <img src="{{ $mediaAssetUrl($websiteImages['contact']['workspace'] ?? null, 'assets/legacy/office-meeting.jpg') }}" alt="Weberse workspace" class="hero-media-image">
                </div>
            </div>
        </div>
    </section>

    <section class="page-panel py-20 lg:py-24">
        <div class="section-shell grid gap-8 lg:grid-cols-[1fr_0.42fr] lg:items-start">
            <div class="surface-card premium-card" data-reveal>
                @if (session('status'))
                    <div class="mb-6 rounded-2xl bg-green-50 px-4 py-3 text-sm text-green-700">{{ session('status') }}</div>
                @endif

                @if ($errors->any())
                    <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                        Please fix the highlighted fields and try again.
                    </div>
                @endif

                <div class="section-kicker">Send an inquiry</div>
                <h2 class="mt-4 text-3xl font-bold text-brand-blue">We’ll reply with next steps.</h2>
                <p class="mt-4 text-slate-600">Tell us your goals, timeline, and what “success” looks like. If you have links (website/app), include them.</p>

                <form method="POST" action="{{ route('website.contact.submit') }}" class="mt-8 grid gap-4 md:grid-cols-2">
                    @csrf
                    <input type="hidden" name="source" value="contact_page">

                    <div class="md:col-span-1">
                        <input class="input @error('name') !border-red-300 !ring-red-100 @enderror" name="name" value="{{ old('name') }}" placeholder="Your name" required>
                        @error('name')<div class="mt-2 text-xs font-semibold text-red-600">{{ $message }}</div>@enderror
                    </div>
                    <div class="md:col-span-1">
                        <input class="input @error('email') !border-red-300 !ring-red-100 @enderror" name="email" value="{{ old('email') }}" type="email" placeholder="Email address" required>
                        @error('email')<div class="mt-2 text-xs font-semibold text-red-600">{{ $message }}</div>@enderror
                    </div>
                    <div class="md:col-span-1">
                        <input class="input @error('company') !border-red-300 !ring-red-100 @enderror" name="company" value="{{ old('company') }}" placeholder="Company name">
                        @error('company')<div class="mt-2 text-xs font-semibold text-red-600">{{ $message }}</div>@enderror
                    </div>
                    <div class="md:col-span-1">
                        <input class="input @error('phone') !border-red-300 !ring-red-100 @enderror" name="phone" value="{{ old('phone') }}" placeholder="Phone number">
                        @error('phone')<div class="mt-2 text-xs font-semibold text-red-600">{{ $message }}</div>@enderror
                    </div>

                    <div class="md:col-span-2">
                        <select class="input @error('title') !border-red-300 !ring-red-100 @enderror" name="title">
                            @foreach ([
                                'Project inquiry',
                                'Website redesign',
                                'Startup MVP',
                                'Custom software',
                                'AI automation',
                                'WhatsApp Cloud automation',
                                'Email marketing automation',
                            ] as $topic)
                                <option value="{{ $topic }}" @selected(old('title', 'Project inquiry') === $topic)>{{ $topic }}</option>
                            @endforeach
                        </select>
                        @error('title')<div class="mt-2 text-xs font-semibold text-red-600">{{ $message }}</div>@enderror
                    </div>

                    <div class="md:col-span-2">
                        <textarea class="input min-h-44 @error('message') !border-red-300 !ring-red-100 @enderror" name="message" placeholder="Tell us about your goals, timeline, and current challenges" required>{{ old('message') }}</textarea>
                        @error('message')<div class="mt-2 text-xs font-semibold text-red-600">{{ $message }}</div>@enderror
                    </div>

                    <div class="md:col-span-2 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <div class="text-sm text-slate-600">By submitting, you agree we can contact you about this inquiry.</div>
                        <button class="btn-primary w-full justify-center sm:w-auto">Send Inquiry</button>
                    </div>
                </form>
            </div>

            <aside class="space-y-6" data-reveal>
                <div class="surface-card">
                    <div class="section-kicker">Typical response</div>
                    <h3 class="mt-4 text-2xl font-bold text-brand-blue">Within 24 hours</h3>
                    <p class="mt-3 text-slate-600">We’ll reply with a quick scope question list or a call suggestion, depending on what you need.</p>
                    <div class="mt-6 grid gap-3">
                        @foreach ([
                            ['icon' => 'calendar', 'label' => 'Scope questions'],
                            ['icon' => 'layers', 'label' => 'Suggested plan'],
                            ['icon' => 'shield', 'label' => 'Risks + dependencies'],
                        ] as $item)
                            <div class="flex items-center gap-3 rounded-[20px] border border-slate-200 bg-white px-4 py-3">
                                <span class="inline-flex h-9 w-9 items-center justify-center rounded-2xl bg-brand-surface text-brand-blue">
                                    @include('website.partials.icon', ['name' => $item['icon'], 'class' => 'h-4 w-4'])
                                </span>
                                <span class="text-sm font-semibold text-slate-700">{{ $item['label'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="surface-card">
                    <div class="section-kicker">FAQ</div>
                    <div class="mt-5 space-y-3" x-data="{ open: 0 }">
                        @foreach ([
                            ['q' => 'Can you work with our existing team?', 'a' => 'Yes. We can collaborate with your designer/dev/team, or deliver end-to-end depending on the engagement.'],
                            ['q' => 'Do you offer fixed-price projects?', 'a' => 'Yes—when scope is clear. We define deliverables and milestones first, then quote for a fixed scope and timeline.'],
                            ['q' => 'What do you need to start?', 'a' => 'A short description of your goal, timeline, current stack (if any), and any links/screenshots. We’ll handle the rest.'],
                        ] as $faq)
                            <div class="rounded-[22px] border border-slate-200 bg-white">
                                <button type="button"
                                        class="flex w-full items-center justify-between gap-4 px-5 py-4 text-left"
                                        @click="open = open === {{ $loop->index }} ? -1 : {{ $loop->index }}"
                                        :aria-expanded="(open === {{ $loop->index }}).toString()">
                                    <span class="text-sm font-semibold text-brand-blue">{{ $faq['q'] }}</span>
                                    <span class="inline-flex h-9 w-9 items-center justify-center rounded-2xl bg-brand-surface text-brand-blue">
                                        <span class="transition-transform duration-200" :class="open === {{ $loop->index }} && 'rotate-180'">
                                            @include('website.partials.icon', ['name' => 'chevron', 'class' => 'h-4 w-4'])
                                        </span>
                                    </span>
                                </button>
                                <div x-show="open === {{ $loop->index }}"
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="opacity-0 -translate-y-1"
                                     x-transition:enter-end="opacity-100 translate-y-0"
                                     x-transition:leave="transition ease-in duration-150"
                                     x-transition:leave-start="opacity-100 translate-y-0"
                                     x-transition:leave-end="opacity-0 -translate-y-1"
                                     class="px-5 pb-5 text-sm text-slate-600"
                                     x-cloak>
                                    {{ $faq['a'] }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </aside>
        </div>
    </section>

    @include('website.partials.cta-banner')
@endsection
