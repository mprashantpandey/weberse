@extends('layouts.website', [
    'title' => 'Apply for '.$job->title.' | Weberse Infotech',
    'description' => 'Submit your application for '.$job->title.' at Weberse Infotech.',
    'robots' => 'noindex,follow',
])

@section('content')
    <section class="dark-band">
        <div class="section-shell section-spacious">
            <div class="grid gap-10 lg:grid-cols-[0.95fr_1.05fr] lg:items-center">
                <div class="max-w-3xl" data-reveal>
                    <div class="section-kicker">Apply Now</div>
                    <h1 class="mt-5 headline-lg">{{ $job->title }}</h1>
                    <p class="mt-5 max-w-2xl body-lg">Apply for this role at Weberse. We review for communication quality, technical fundamentals, and fit with the kind of systems we build.</p>
                    <div class="mt-7 flex flex-wrap gap-2">
                        <span class="badge-chip">{{ $job->department?->name ?? 'General' }}</span>
                        <span class="badge-chip">{{ str($job->employment_type)->replace('_', ' ')->title() }}</span>
                        <span class="badge-chip">{{ $job->location ?? 'Remote' }}</span>
                    </div>
                </div>

                <div class="glass-card premium-card" data-reveal>
                    <div class="grid gap-4 sm:grid-cols-3">
                        <div class="rounded-2xl border border-white/10 bg-white/5 px-4 py-4">
                            <div class="text-[0.65rem] uppercase tracking-[0.2em] text-brand-green">Department</div>
                            <div class="mt-2 font-semibold text-white">{{ $job->department?->name ?? 'General' }}</div>
                        </div>
                        <div class="rounded-2xl border border-white/10 bg-white/5 px-4 py-4">
                            <div class="text-[0.65rem] uppercase tracking-[0.2em] text-brand-green">Type</div>
                            <div class="mt-2 font-semibold text-white">{{ str($job->employment_type)->replace('_', ' ')->title() }}</div>
                        </div>
                        <div class="rounded-2xl border border-white/10 bg-white/5 px-4 py-4">
                            <div class="text-[0.65rem] uppercase tracking-[0.2em] text-brand-green">Location</div>
                            <div class="mt-2 font-semibold text-white">{{ $job->location ?? 'Remote' }}</div>
                        </div>
                    </div>
                    <div class="mt-4 grid gap-4 sm:grid-cols-3">
                        <div class="rounded-2xl border border-white/10 bg-white/5 px-4 py-4">
                            <div class="text-[0.65rem] uppercase tracking-[0.2em] text-brand-green">Salary Range</div>
                            <div class="mt-2 font-semibold text-white">
                                @if($job->salary_min || $job->salary_max)
                                    {{ $job->salary_currency ?: 'INR' }} {{ number_format((int) $job->salary_min) }} - {{ number_format((int) $job->salary_max) }}
                                @else
                                    Competitive
                                @endif
                            </div>
                        </div>
                        <div class="rounded-2xl border border-white/10 bg-white/5 px-4 py-4">
                            <div class="text-[0.65rem] uppercase tracking-[0.2em] text-brand-green">Experience</div>
                            <div class="mt-2 font-semibold text-white">
                                @if($job->experience_min !== null || $job->experience_max !== null)
                                    {{ $job->experience_min ?? 0 }} - {{ $job->experience_max ?? $job->experience_min }} years
                                @else
                                    Based on fit
                                @endif
                            </div>
                        </div>
                        <div class="rounded-2xl border border-white/10 bg-white/5 px-4 py-4">
                            <div class="text-[0.65rem] uppercase tracking-[0.2em] text-brand-green">Notice Period</div>
                            <div class="mt-2 font-semibold text-white">
                                {{ $job->notice_period ?: 'Flexible' }}
                                @if($job->immediate_joiner_preferred)
                                    <span class="mt-1 block text-xs uppercase tracking-[0.18em] text-brand-green">Immediate preferred</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="mt-6 rounded-[24px] border border-white/8 bg-white/5 p-6 text-slate-200">
                        <div class="text-sm uppercase tracking-[0.22em] text-brand-green">Role Summary</div>
                        <p class="mt-4">{{ $job->description }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="page-panel py-16 lg:py-20">
        <div class="section-shell grid gap-8 lg:grid-cols-[1.08fr_0.92fr]">
            <div class="surface-card premium-card" data-reveal>
                @if (session('status'))
                    <div class="mb-6 rounded-2xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">{{ session('status') }}</div>
                @endif

                <div class="section-kicker">Application Form</div>
                <h2 class="mt-4 text-3xl font-bold text-brand-blue">Submit your application.</h2>
                <p class="mt-4 max-w-2xl text-slate-600">Share your core details, upload your resume, and add a short note explaining why this role fits your experience.</p>

                @if(!empty($job->skills))
                    <div class="mt-6 flex flex-wrap gap-2">
                        @foreach($job->skills as $skill)
                            <span class="surface-badge">{{ $skill }}</span>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('website.careers.apply') }}" enctype="multipart/form-data" class="mt-8 grid gap-4 md:grid-cols-2">
                    @csrf
                    <input type="hidden" name="job_opening" value="{{ $job->slug }}">

                    <div class="md:col-span-2">
                        <label class="mb-2 block text-sm font-medium text-brand-blue">Applying for</label>
                        <div class="rounded-2xl border border-brand-blue/8 bg-brand-surface px-4 py-4 font-semibold text-brand-blue">
                            {{ $job->title }} - {{ $job->location ?? 'Remote' }}
                        </div>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-brand-blue">Full name</label>
                        <input class="input" name="name" placeholder="Your full name" value="{{ old('name') }}" required>
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-medium text-brand-blue">Email address</label>
                        <input class="input" name="email" type="email" placeholder="you@example.com" value="{{ old('email') }}" required>
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-medium text-brand-blue">Phone number</label>
                        <input class="input" name="phone" placeholder="+91 98xxxxxxx" value="{{ old('phone') }}">
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-medium text-brand-blue">Notice period / availability</label>
                        <input class="input" name="notice_period_response" placeholder="Immediate / 15 days / 30 days" value="{{ old('notice_period_response') }}">
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-medium text-brand-blue">Resume</label>
                        <input class="input file:mr-3 file:rounded-full file:border-0 file:bg-brand-green file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white" name="resume" type="file" accept=".pdf,.doc,.docx">
                    </div>
                    <div class="md:col-span-2">
                        <label class="mb-2 block text-sm font-medium text-brand-blue">Short note</label>
                        <textarea class="input min-h-36" name="cover_letter" placeholder="Explain your relevant experience, strengths, and why you want to work with Weberse.">{{ old('cover_letter') }}</textarea>
                    </div>
                    @foreach($job->application_questions ?? [] as $index => $question)
                        <div class="md:col-span-2">
                            <label class="mb-2 block text-sm font-medium text-brand-blue">{{ $question }}</label>
                            <textarea class="input min-h-28" name="application_answers[{{ $index }}]" placeholder="Write your answer here.">{{ old('application_answers.'.$index) }}</textarea>
                        </div>
                    @endforeach
                    <div class="md:col-span-2 flex flex-wrap items-center justify-between gap-4 border-t border-slate-200 pt-5">
                        <p class="max-w-xl text-sm text-slate-500">Shortlisted candidates hear from us directly after review.</p>
                        <button class="btn-primary">@include('website.partials.icon', ['name' => 'arrow', 'class' => 'h-4 w-4']) Submit Application</button>
                    </div>
                </form>
            </div>

            <div class="space-y-6">
                <div class="surface-card premium-card" data-reveal>
                    <div class="section-kicker">What We Look For</div>
                    <div class="mt-5 space-y-4">
                        @foreach ([
                            ['title' => 'Strong fundamentals', 'copy' => 'We care about clean thinking, sound execution, and attention to detail.'],
                            ['title' => 'Clear communication', 'copy' => 'Good updates and sensible collaboration matter as much as technical skill.'],
                            ['title' => 'Ownership mindset', 'copy' => 'We value people who think beyond tickets and understand the larger outcome.'],
                        ] as $item)
                            <div class="flex items-start gap-4 rounded-2xl border border-brand-blue/8 bg-brand-surface px-4 py-4">
                                <span class="mt-0.5 inline-flex h-9 w-9 items-center justify-center rounded-2xl bg-white text-brand-green shadow-[0_8px_18px_rgba(13,47,80,0.08)]">
                                    @include('website.partials.icon', ['name' => 'check', 'class' => 'h-4 w-4'])
                                </span>
                                <div>
                                    <h3 class="text-base font-semibold text-brand-blue">{{ $item['title'] }}</h3>
                                    <p class="mt-1 text-sm text-slate-600">{{ $item['copy'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="surface-card premium-card" data-reveal>
                    <div class="section-kicker">Other Openings</div>
                    <div class="mt-5 space-y-4">
                        @foreach ($jobs->where('id', '!=', $job->id)->take(3) as $relatedJob)
                            <a href="{{ route('website.careers.apply-page', $relatedJob) }}" class="block rounded-2xl border border-brand-blue/8 bg-brand-surface px-4 py-4 transition duration-300 hover:-translate-y-0.5 hover:border-brand-green/30 hover:shadow-[0_12px_26px_rgba(13,47,80,0.08)]">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <h3 class="text-lg font-semibold text-brand-blue">{{ $relatedJob->title }}</h3>
                                        <p class="mt-2 text-sm text-slate-600">{{ $relatedJob->department?->name ?? 'General' }} • {{ $relatedJob->location ?? 'Remote' }}</p>
                                    </div>
                                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-white text-brand-blue shadow-[0_8px_18px_rgba(13,47,80,0.08)]">
                                        @include('website.partials.icon', ['name' => 'arrow-up-right', 'class' => 'h-4 w-4'])
                                    </span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                    <div class="mt-6">
                        <a href="{{ route('website.careers') }}" class="btn-dark">Back to Careers</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
