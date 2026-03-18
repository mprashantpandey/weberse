@extends('layouts.website', ['title' => 'Careers | Weberse Infotech'])

@section('content')
    <section class="dark-band">
        <div class="section-shell section-spacious">
            <div class="grid gap-10 lg:grid-cols-[0.95fr_1.05fr] lg:items-center">
                <div class="max-w-3xl" data-reveal>
                    <div class="section-kicker">Careers</div>
                    <h1 class="mt-5 headline-lg">Join a team that builds with clarity.</h1>
                    <p class="mt-5 max-w-2xl body-lg">Weberse brings design, engineering, and practical business thinking together. We look for people who care about execution quality, communication, and maintainable work.</p>
                    <div class="mt-7 flex flex-wrap gap-3">
                        <span class="badge-chip">Remote-friendly</span>
                        <span class="badge-chip">Product + client work</span>
                        <span class="badge-chip">Design-aware engineering</span>
                    </div>
                </div>

                <div class="hero-media-stage" data-reveal>
                    <img src="{{ $mediaAssetUrl($websiteImages['careers']['hero_team'] ?? null, 'assets/legacy/team.jpg') }}" alt="Careers at Weberse" class="hero-media-image">
                </div>
            </div>

            <div class="mt-10 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                @foreach ([
                    ['icon' => 'users', 'title' => 'Collaborative team', 'copy' => 'Design and engineering work closely instead of operating in silos.'],
                    ['icon' => 'briefcase', 'title' => 'Practical delivery', 'copy' => 'Projects are shaped around outcomes, not unnecessary process overhead.'],
                    ['icon' => 'palette', 'title' => 'Quality-minded design', 'copy' => 'Interfaces are expected to feel credible, clear, and conversion-aware.'],
                    ['icon' => 'cpu', 'title' => 'Maintainable systems', 'copy' => 'We prefer clean architecture, stable tooling, and disciplined execution.'],
                ] as $item)
                    <div class="glass-card premium-card" data-reveal>
                        <div class="premium-icon inline-flex rounded-2xl bg-white/10 p-3 text-brand-green">
                            @include('website.partials.icon', ['name' => $item['icon'], 'class' => 'h-5 w-5'])
                        </div>
                        <h2 class="mt-5 text-xl font-bold text-white">{{ $item['title'] }}</h2>
                        <p class="mt-3 text-sm text-slate-300">{{ $item['copy'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="page-panel py-16 lg:py-20">
        <div
            class="section-shell"
            x-data="{
                query: '',
                department: 'all',
                employment: 'all',
                location: 'all',
                matches(job) {
                    const q = this.query.toLowerCase().trim();
                    const haystack = [job.title, job.description, job.department, job.location, job.employment]
                        .join(' ')
                        .toLowerCase();

                    return (!q || haystack.includes(q))
                        && (this.department === 'all' || job.department === this.department)
                        && (this.employment === 'all' || job.employment === this.employment)
                        && (this.location === 'all' || job.location === this.location);
                }
            }"
        >
            <div class="grid gap-8 lg:grid-cols-[0.82fr_1.18fr]">
                <div class="space-y-6">
                    <div class="surface-card premium-card" data-reveal>
                        <div class="section-kicker">How We Work</div>
                        <h2 class="mt-4 text-3xl font-bold text-brand-blue">A culture built on clarity and execution.</h2>
                        <p class="mt-4 text-slate-600">We prefer straightforward communication, accountable delivery, and systems that are built to last. That applies to both internal collaboration and client work.</p>
                    </div>

                    <div class="surface-card premium-card" data-reveal>
                        <div class="space-y-4">
                            @foreach ([
                                ['title' => 'Direct communication', 'copy' => 'Clear updates, honest timelines, and low ambiguity.'],
                                ['title' => 'Ownership mindset', 'copy' => 'Team members are expected to think beyond isolated tasks.'],
                                ['title' => 'Strong fundamentals', 'copy' => 'Good UX, reliable engineering, and usable systems matter equally.'],
                            ] as $point)
                                <div class="flex items-start gap-4 rounded-2xl border border-brand-blue/8 bg-brand-surface px-4 py-4">
                                    <span class="mt-0.5 inline-flex h-9 w-9 items-center justify-center rounded-2xl bg-white text-brand-green shadow-[0_8px_18px_rgba(13,47,80,0.08)]">
                                        @include('website.partials.icon', ['name' => 'check', 'class' => 'h-4 w-4'])
                                    </span>
                                    <div>
                                        <h3 class="text-base font-semibold text-brand-blue">{{ $point['title'] }}</h3>
                                        <p class="mt-1 text-sm text-slate-600">{{ $point['copy'] }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="surface-card premium-card" data-reveal>
                        <div class="section-kicker">Hiring Snapshot</div>
                        <div class="mt-5 grid gap-3 sm:grid-cols-3 lg:grid-cols-1">
                            <div class="rounded-2xl border border-brand-blue/8 bg-white px-4 py-4 shadow-[0_10px_24px_rgba(13,47,80,0.05)]">
                                <div class="text-xs uppercase tracking-[0.18em] text-slate-500">Open roles</div>
                                <div class="mt-2 text-2xl font-bold text-brand-blue">{{ $jobs->count() }}</div>
                            </div>
                            <div class="rounded-2xl border border-brand-blue/8 bg-white px-4 py-4 shadow-[0_10px_24px_rgba(13,47,80,0.05)]">
                                <div class="text-xs uppercase tracking-[0.18em] text-slate-500">Primary mode</div>
                                <div class="mt-2 text-lg font-bold text-brand-blue">Remote / Hybrid</div>
                            </div>
                            <div class="rounded-2xl border border-brand-blue/8 bg-white px-4 py-4 shadow-[0_10px_24px_rgba(13,47,80,0.05)]">
                                <div class="text-xs uppercase tracking-[0.18em] text-slate-500">Focus areas</div>
                                <div class="mt-2 text-lg font-bold text-brand-blue">Design, product, systems</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="mb-8" data-reveal>
                        <div class="section-kicker">Open Roles</div>
                        <h2 class="mt-4 text-3xl font-bold text-brand-blue">Current opportunities at Weberse.</h2>
                        <p class="mt-4 max-w-2xl text-slate-600">Filter the openings below and apply through email for the role that fits your background.</p>
                    </div>

                    <div class="surface-card premium-card mb-8" data-reveal>
                        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                            <div class="xl:col-span-1">
                                <label class="mb-2 block text-sm font-medium text-brand-blue">Search roles</label>
                                <input x-model="query" class="input" type="text" placeholder="Search title, department, location">
                            </div>
                            <div>
                                <label class="mb-2 block text-sm font-medium text-brand-blue">Department</label>
                                <select x-model="department" class="input">
                                    <option value="all">All departments</option>
                                    @foreach ($jobs->pluck('department.name')->filter()->unique()->values() as $department)
                                        <option value="{{ $department }}">{{ $department }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="mb-2 block text-sm font-medium text-brand-blue">Employment</label>
                                <select x-model="employment" class="input">
                                    <option value="all">All types</option>
                                    @foreach ($jobs->pluck('employment_type')->filter()->unique()->values() as $type)
                                        <option value="{{ $type }}">{{ str($type)->replace('_', ' ')->title() }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="mb-2 block text-sm font-medium text-brand-blue">Location</label>
                                <select x-model="location" class="input">
                                    <option value="all">All locations</option>
                                    @foreach ($jobs->pluck('location')->filter()->unique()->values() as $location)
                                        <option value="{{ $location }}">{{ $location }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        @forelse ($jobs as $job)
                            <article
                                class="surface-card premium-card"
                                data-reveal
                                x-show="matches({
                                    title: @js($job->title),
                                    description: @js($job->description),
                                    department: @js($job->department?->name ?? 'General'),
                                    location: @js($job->location ?? 'Remote'),
                                    employment: @js($job->employment_type),
                                })"
                                x-transition.opacity.duration.250ms
                            >
                                <div class="flex flex-col gap-6 xl:flex-row xl:items-start xl:justify-between">
                                    <div class="max-w-3xl">
                                        <div class="flex flex-wrap items-center gap-2">
                                            <span class="surface-badge">{{ $job->department?->name ?? 'General' }}</span>
                                            <span class="surface-badge">{{ str($job->employment_type)->replace('_', ' ')->title() }}</span>
                                            <span class="surface-badge">{{ $job->location ?? 'Remote' }}</span>
                                            @if($job->experience_min !== null || $job->experience_max !== null)
                                                <span class="surface-badge">{{ $job->experience_min ?? 0 }}-{{ $job->experience_max ?? $job->experience_min }} yrs</span>
                                            @endif
                                        </div>
                                        <h3 class="mt-4 text-3xl font-bold text-brand-blue">{{ $job->title }}</h3>
                                        <p class="mt-4 text-slate-600">{{ $job->description }}</p>
                                        @if(!empty($job->skills))
                                            <div class="mt-4 flex flex-wrap gap-2">
                                                @foreach(array_slice($job->skills, 0, 5) as $skill)
                                                    <span class="surface-badge">{{ $skill }}</span>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                    <div class="grid gap-3 sm:grid-cols-2 xl:grid-cols-1 xl:min-w-[13rem]">
                                        <div class="rounded-2xl border border-brand-blue/8 bg-brand-surface px-4 py-4">
                                            <div class="text-xs uppercase tracking-[0.18em] text-slate-500">Department</div>
                                            <div class="mt-2 font-semibold text-brand-blue">{{ $job->department?->name ?? 'General' }}</div>
                                        </div>
                                        <div class="rounded-2xl border border-brand-blue/8 bg-brand-surface px-4 py-4">
                                            <div class="text-xs uppercase tracking-[0.18em] text-slate-500">Published</div>
                                            <div class="mt-2 font-semibold text-brand-blue">{{ optional($job->published_at)->format('d M Y') ?? 'Now' }}</div>
                                        </div>
                                        <div class="rounded-2xl border border-brand-blue/8 bg-brand-surface px-4 py-4">
                                            <div class="text-xs uppercase tracking-[0.18em] text-slate-500">Salary</div>
                                            <div class="mt-2 font-semibold text-brand-blue">
                                                @if($job->salary_min || $job->salary_max)
                                                    {{ $job->salary_currency ?: 'INR' }} {{ number_format((int) $job->salary_min) }} - {{ number_format((int) $job->salary_max) }}
                                                @else
                                                    Competitive
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-8 flex flex-wrap items-center justify-between gap-4 border-t border-slate-200 pt-5">
                                    <div class="max-w-xl text-sm text-slate-500">
                                        View the role details and submit your application from the dedicated apply page.
                                    </div>
                                    <a
                                        href="{{ route('website.careers.apply-page', $job) }}"
                                        class="btn-primary"
                                    >
                                        @include('website.partials.icon', ['name' => 'arrow', 'class' => 'h-4 w-4'])
                                        Apply for Role
                                    </a>
                                </div>
                            </article>
                        @empty
                            <div class="surface-card premium-card" data-reveal>
                                <div class="section-kicker">No Active Openings</div>
                                <h3 class="mt-4 text-3xl font-bold text-brand-blue">We are not hiring for a specific role right now.</h3>
                                <p class="mt-4 max-w-2xl text-slate-600">If your work aligns with product design, Laravel engineering, frontend systems, or digital operations, reach out through the contact page and share your profile.</p>
                                <div class="mt-6">
                                    <a href="{{ route('website.contact') }}"
                                       class="btn-dark"
                                       x-on:click.prevent="$store.marketingPopup.openLead({ title: 'Careers inquiry', source: 'careers_no_openings_cta', context: 'Careers inquiry', submitLabel: 'Send Inquiry' })">
                                        Contact Weberse
                                    </a>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('website.partials.cta-banner')
@endsection
