@extends('layouts.dashboard', [
    'title' => $mode === 'create' ? 'Create Email Template' : 'Edit Email Template',
    'heading' => $mode === 'create' ? 'Create Email Template' : 'Edit Email Template',
    'subheading' => 'Structured templates for HR, newsletters, and direct sends.',
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
        <div class="card mb-6 border border-green-200 bg-green-50 text-green-700">{{ session('status') }}</div>
    @endif

    <div class="dashboard-subnav">
        <a href="{{ route('admin.email.index') }}" class="dashboard-subnav-link">Overview</a>
        <a href="{{ route('admin.email.templates.index') }}" class="dashboard-subnav-link dashboard-subnav-link-active">Templates</a>
        <a href="{{ route('admin.email.subscribers.index') }}" class="dashboard-subnav-link">Subscribers</a>
        <a href="{{ route('admin.email.campaigns.index') }}" class="dashboard-subnav-link">Campaigns</a>
        <a href="{{ route('admin.email.compose') }}" class="dashboard-subnav-link">Compose</a>
    </div>

    <div
        class="section-grid xl:grid-cols-[1fr_0.92fr]"
        x-data="{
            subject: @js(old('subject', $template->subject)),
            body: @js(old('body', $template->body)),
            tokens: {
                name: @js('{{name}}'),
                email: @js('{{email}}'),
                job_title: @js('{{job_title}}'),
                candidate_name: @js('{{candidate_name}}'),
                interview_date: @js('{{interview_date}}'),
                meeting_link: @js('{{meeting_link}}')
            },
            sample: {
                name: 'Aarav Sharma',
                email: 'aarav@example.com',
                job_title: 'Laravel Developer',
                candidate_name: 'Aarav Sharma',
                interview_date: '22 Mar 2026, 03:00 PM',
                meeting_link: 'https://meet.google.com/weberse-demo'
            },
            render(content) {
                let output = content || '';
                Object.entries(this.sample).forEach(([key, value]) => {
                    output = output.replaceAll(this.tokens[key], value);
                });
                return output.replace(/\\n/g, '<br>');
            }
        }"
    >
    <div class="card">
        <div class="panel-title">{{ $mode === 'create' ? 'New Template' : 'Manage Template' }}</div>
        <div class="panel-subtitle">For HR emails, keep placeholders aligned with candidate, role, and interview fields.</div>
        <form method="POST" action="{{ $mode === 'create' ? route('admin.email.templates.store') : route('admin.email.templates.update', $template) }}" class="mt-6 grid gap-4 md:grid-cols-2">
            @csrf
            @if ($mode === 'edit')
                @method('PATCH')
            @endif
            <input class="input" name="name" value="{{ old('name', $template->name) }}" placeholder="Template name" required>
            <select class="input" name="category">
                @foreach (['general', 'hr', 'newsletter', 'sales'] as $category)
                    <option value="{{ $category }}" @selected(old('category', $template->category) === $category)>{{ str($category)->title() }}</option>
                @endforeach
            </select>
            <input class="input md:col-span-2" name="subject" x-model="subject" value="{{ old('subject', $template->subject) }}" placeholder="Email subject" required>
            <textarea class="input min-h-72 md:col-span-2" name="body" x-model="body" required>{{ old('body', $template->body) }}</textarea>
            <textarea class="input min-h-28 md:col-span-2" name="description" placeholder="Internal notes / placeholder guide">{{ old('description', $template->description) }}</textarea>
            <label class="flex items-center gap-3 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-medium text-slate-700 md:col-span-2">
                <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $template->is_active))>
                Template is active
            </label>
            <div class="md:col-span-2 flex gap-3">
                <button class="btn-primary">{{ $mode === 'create' ? 'Create Template' : 'Save Changes' }}</button>
                <a href="{{ route('admin.email.templates.index') }}" class="btn-dark">Back to Templates</a>
            </div>
        </form>
    </div>
    <div class="card">
        <div class="panel-title">Live Preview</div>
        <div class="panel-subtitle">Preview uses the common Weberse email layout with sample variable values.</div>
        <div class="email-preview-shell mt-6 p-4">
            <div class="email-preview-hero">
                <img src="{{ asset('assets/legacy/weberse-light.svg') }}" alt="Weberse" class="h-10 w-auto">
                <div class="mt-5 text-2xl font-bold" x-text="subject || 'Email subject preview'"></div>
                <div class="mt-2 text-sm text-white/80">A branded message from Weberse Infotech.</div>
            </div>
            <div class="px-2 py-4">
                <div class="email-preview-body">
                    <div x-html="render(body || 'Template content will appear here.')"></div>
                </div>
            </div>
            <div class="px-2 pb-4">
                <div class="email-preview-auth">
                    <strong class="text-brand-blue">Authenticity check:</strong>
                    Weberse emails come from official addresses and will never ask for passwords, OTPs, or payment credentials by email.
                </div>
            </div>
            <div class="px-2 pb-2">
                <div class="email-preview-footer">
                    <div class="font-semibold text-white">{{ config('platform.company.name') }}</div>
                    <div>{{ config('platform.company.tagline') }}</div>
                    <div class="mt-3">
                        Email: {{ config('platform.company.email') }}<br>
                        Phone: {{ config('platform.company.phone') }}<br>
                        Location: {{ config('platform.company.location') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
