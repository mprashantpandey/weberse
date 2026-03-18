@extends('layouts.dashboard', [
    'title' => $mode === 'create' ? 'Create Case Study' : 'Edit Case Study',
    'heading' => $mode === 'create' ? 'Create Case Study' : 'Edit Case Study',
    'subheading' => 'Case studies are edited on dedicated pages for richer structured content.',
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
    <div class="dashboard-subnav">
        <a href="{{ route('admin.cms.index') }}" class="dashboard-subnav-link">Overview</a>
        <a href="{{ route('admin.cms.website-details') }}" class="dashboard-subnav-link">Website Details</a>
        <a href="{{ route('admin.cms.images') }}" class="dashboard-subnav-link">Images</a>
        <a href="{{ route('admin.cms.posts.index') }}" class="dashboard-subnav-link">Blog Posts</a>
        <a href="{{ route('admin.cms.projects.index') }}" class="dashboard-subnav-link">Portfolio</a>
        <a href="{{ route('admin.cms.case-studies.index') }}" class="dashboard-subnav-link dashboard-subnav-link-active">Case Studies</a>
        <a href="{{ route('admin.cms.testimonials.index') }}" class="dashboard-subnav-link">Testimonials</a>
    </div>

    <div class="grid gap-6 xl:grid-cols-[1fr_0.82fr]" x-data="window.singleMediaPicker(@js(old('featured_image', $caseStudy->featured_image)))">
        <div class="card">
            <div class="panel-title">{{ $mode === 'create' ? 'New Case Study' : 'Manage Case Study' }}</div>
            <form method="POST" action="{{ $mode === 'create' ? route('admin.cms.case-studies.store') : route('admin.cms.case-studies.update', $caseStudy) }}" class="mt-6 grid gap-4">
                @csrf
                @if($mode === 'edit')
                    @method('PATCH')
                @endif

                <input class="input" name="title" value="{{ old('title', $caseStudy->title) }}" placeholder="Case study title" required>
                <textarea class="input min-h-24" name="summary" placeholder="Short summary">{{ old('summary', $caseStudy->summary) }}</textarea>

                <div class="grid gap-4 md:grid-cols-2">
                    <input class="input" name="client" value="{{ old('client', $caseStudy->client) }}" placeholder="Client">
                    <input class="input" name="industry" value="{{ old('industry', $caseStudy->industry) }}" placeholder="Industry">
                    <input class="input" name="duration" value="{{ old('duration', $caseStudy->duration) }}" placeholder="Duration">
                    <input class="input" name="engagement" value="{{ old('engagement', $caseStudy->engagement) }}" placeholder="Engagement">
                </div>

                <input type="hidden" name="featured_image" x-model="selectedImage">
                <textarea class="input min-h-24" name="services_list" placeholder="Services, one per line">{{ old('services_list', implode(PHP_EOL, $caseStudy->services ?? [])) }}</textarea>
                <textarea class="input min-h-24" name="stack_list" placeholder="Tech stack, one per line">{{ old('stack_list', implode(PHP_EOL, $caseStudy->stack ?? [])) }}</textarea>
                <textarea class="input min-h-32" name="challenge" placeholder="Challenge">{{ old('challenge', $caseStudy->challenge) }}</textarea>
                <textarea class="input min-h-32" name="solution" placeholder="Solution">{{ old('solution', $caseStudy->solution) }}</textarea>
                <textarea class="input min-h-32" name="outcome" placeholder="Outcome">{{ old('outcome', $caseStudy->outcome) }}</textarea>
                <textarea class="input min-h-24" name="results_list" placeholder="Results, one per line">{{ old('results_list', implode(PHP_EOL, $caseStudy->results ?? [])) }}</textarea>
                <textarea class="input min-h-24" name="metrics_list" placeholder="Impact metrics, one per line">{{ old('metrics_list', implode(PHP_EOL, $caseStudy->metrics ?? [])) }}</textarea>
                <textarea class="input min-h-24" name="quote" placeholder="Client quote">{{ old('quote', $caseStudy->quote) }}</textarea>
                <input class="input" name="quote_author" value="{{ old('quote_author', $caseStudy->quote_author) }}" placeholder="Quote author">
                <label class="flex items-center gap-3 text-sm text-slate-700"><input type="checkbox" name="is_published" value="1" @checked(old('is_published', $caseStudy->is_published))> Visible on website</label>

                <div class="flex gap-3">
                    <button class="btn-primary">{{ $mode === 'create' ? 'Create Case Study' : 'Save Changes' }}</button>
                    <a href="{{ route('admin.cms.case-studies.index') }}" class="btn-dark">Back to Case Studies</a>
                </div>
            </form>
        </div>

        <div class="space-y-6">
            @if (session('uploaded_media_path'))
                <div class="card border border-green-200 bg-green-50 text-green-700">
                    <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                        <div>
                            <div>{{ session('status') }}</div>
                            <div class="mt-1 text-xs text-green-700/80">{{ session('uploaded_media_name') }} • {{ session('uploaded_media_path') }}</div>
                        </div>
                        <button type="button" class="btn-primary shrink-0" @click="assignAsset(@js(session('uploaded_media_path')))">Use Current Upload</button>
                    </div>
                </div>
            @endif

            <div class="card">
                <div class="panel-title">Featured Image</div>
                <div class="panel-subtitle">Pick a case-study visual from the shared media library.</div>
                <div class="mt-6 flex h-52 items-center justify-center rounded-[24px] border border-slate-200 bg-slate-50 p-4">
                    <img x-show="selectedImage" :src="resolveAsset(selectedImage)" alt="Featured preview" class="max-h-44 w-auto rounded-[20px] object-contain" x-cloak>
                    <div x-show="!selectedImage" class="text-sm text-slate-500" x-cloak>No featured image selected.</div>
                </div>
                <div class="mt-3 break-all text-xs text-slate-500" x-text="selectedImage || 'No featured image selected'"></div>
                <button type="button" class="btn-secondary mt-4 px-4 py-2 text-xs" @click="focusLibrary()">Choose from Media Library</button>
            </div>

            <div class="card">
                <div class="panel-title">Upload Media</div>
                <form method="POST" action="{{ route('admin.cms.media.upload') }}" enctype="multipart/form-data" class="mt-6 flex flex-col gap-3 sm:flex-row">
                    @csrf
                    <input class="input" type="file" name="media_file" accept=".png,.jpg,.jpeg,.webp,.svg,.ico" required>
                    <button class="btn-primary shrink-0">Upload Media</button>
                </form>
            </div>

            <div class="card">
                <div class="panel-title">Media Library</div>
                <div class="panel-subtitle">Click an asset to assign it to this case study.</div>
                <div class="mt-6 grid gap-4 sm:grid-cols-2">
                    @foreach ($mediaAssets as $asset)
                        <button type="button" class="rounded-[24px] border border-slate-200 bg-slate-50 p-4 text-left transition hover:border-brand-green/30 hover:bg-brand-surface/70" @click="assignAsset(@js($asset['path']))">
                            <div class="flex h-24 items-center justify-center rounded-[18px] border border-slate-200 bg-white p-3">
                                @if (in_array($asset['extension'], ['svg', 'png', 'jpg', 'jpeg', 'webp']))
                                    <img src="{{ $asset['url'] }}" alt="{{ $asset['name'] }}" class="max-h-16 w-auto">
                                @else
                                    <div class="text-sm font-semibold text-slate-500">{{ strtoupper($asset['extension']) }}</div>
                                @endif
                            </div>
                            <div class="mt-3 text-sm font-semibold text-slate-800">{{ $asset['name'] }}</div>
                            <div class="mt-1 break-all text-xs text-slate-500">{{ $asset['path'] }}</div>
                        </button>
                    @endforeach
                </div>
            </div>
        </div>

        <div x-show="libraryOpen" x-cloak class="dashboard-modal-backdrop" @click.self="libraryOpen = false">
            <div class="dashboard-modal-card max-w-4xl">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <div class="panel-title">Media Library</div>
                        <div class="panel-subtitle">Choose a featured image for this case study.</div>
                    </div>
                    <button type="button" class="btn-dark px-4 py-2 text-xs" @click="libraryOpen = false">Close</button>
                </div>

                <form method="POST" action="{{ route('admin.cms.media.upload') }}" enctype="multipart/form-data" class="mt-6 flex flex-col gap-3 sm:flex-row">
                    @csrf
                    <input class="input" type="file" name="media_file" accept=".png,.jpg,.jpeg,.webp,.svg,.ico" required>
                    <button class="btn-primary shrink-0">Upload Media</button>
                </form>

                <div class="mt-6 grid gap-4 sm:grid-cols-2">
                    @foreach ($mediaAssets as $asset)
                        <button type="button" class="rounded-[24px] border border-slate-200 bg-slate-50 p-4 text-left transition hover:border-brand-green/30 hover:bg-brand-surface/70" @click="assignAsset(@js($asset['path']))">
                            <div class="flex h-24 items-center justify-center rounded-[18px] border border-slate-200 bg-white p-3">
                                @if (in_array($asset['extension'], ['svg', 'png', 'jpg', 'jpeg', 'webp']))
                                    <img src="{{ $asset['url'] }}" alt="{{ $asset['name'] }}" class="max-h-16 w-auto">
                                @else
                                    <div class="text-sm font-semibold text-slate-500">{{ strtoupper($asset['extension']) }}</div>
                                @endif
                            </div>
                            <div class="mt-3 text-sm font-semibold text-slate-800">{{ $asset['name'] }}</div>
                            <div class="mt-1 break-all text-xs text-slate-500">{{ $asset['path'] }}</div>
                        </button>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
