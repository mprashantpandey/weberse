@extends('layouts.dashboard', [
    'title' => $mode === 'create' ? 'Create Newsletter Campaign' : 'Edit Newsletter Campaign',
    'heading' => $mode === 'create' ? 'Create Newsletter Campaign' : 'Edit Newsletter Campaign',
    'subheading' => 'Long-form newsletter content is easier to manage on a dedicated page.',
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
        <a href="{{ route('admin.email.templates.index') }}" class="dashboard-subnav-link">Templates</a>
        <a href="{{ route('admin.email.subscribers.index') }}" class="dashboard-subnav-link">Subscribers</a>
        <a href="{{ route('admin.email.campaigns.index') }}" class="dashboard-subnav-link dashboard-subnav-link-active">Campaigns</a>
        <a href="{{ route('admin.email.compose') }}" class="dashboard-subnav-link">Compose</a>
    </div>

    <div
        class="section-grid xl:grid-cols-[1fr_0.92fr]"
        x-data="{
            subject: @js(old('subject', $campaign->subject)),
            body: @js(old('body', $campaign->body)),
            tokens: {
                name: @js('{{name}}'),
                email: @js('{{email}}')
            },
            sample: {
                name: 'Ritika Jain',
                email: 'ritika@example.com'
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
        <div class="panel-title">{{ $mode === 'create' ? 'New Campaign' : 'Manage Campaign' }}</div>
        <div class="panel-subtitle">Newsletter merge tags can use <code>@{{name}}</code> and <code>@{{email}}</code>.</div>
        <form method="POST" action="{{ $mode === 'create' ? route('admin.email.campaigns.store') : route('admin.email.campaigns.update', $campaign) }}" class="mt-6 grid gap-4 md:grid-cols-2">
            @csrf
            @if ($mode === 'edit')
                @method('PATCH')
            @endif
            <input class="input" name="title" value="{{ old('title', $campaign->title) }}" placeholder="Campaign title" required>
            <select class="input" name="email_template_id">
                <option value="">Custom content</option>
                @foreach ($templates as $template)
                    <option value="{{ $template->id }}" @selected(old('email_template_id', $campaign->email_template_id) == $template->id)>{{ $template->name }}</option>
                @endforeach
            </select>
            <input class="input md:col-span-2" name="subject" x-model="subject" value="{{ old('subject', $campaign->subject) }}" placeholder="Subject line" required>
            <textarea class="input min-h-72 md:col-span-2" name="body" x-model="body" required>{{ old('body', $campaign->body) }}</textarea>
            <select class="input" name="target_segment">
                <option value="all_active" @selected(old('target_segment', $campaign->target_segment) === 'all_active')>All active subscribers</option>
            </select>
            <select class="input" name="status">
                @foreach (['draft', 'scheduled', 'sent'] as $status)
                    <option value="{{ $status }}" @selected(old('status', $campaign->status) === $status)>{{ str($status)->title() }}</option>
                @endforeach
            </select>
            <div class="md:col-span-2 flex gap-3">
                <button class="btn-primary">{{ $mode === 'create' ? 'Create Campaign' : 'Save Changes' }}</button>
                <a href="{{ route('admin.email.campaigns.index') }}" class="btn-dark">Back to Campaigns</a>
            </div>
        </form>
    </div>
    <div class="card">
        <div class="panel-title">Campaign Preview</div>
        <div class="panel-subtitle">Preview uses a sample subscriber and the shared branded email shell.</div>
        <div class="email-preview-shell mt-6 p-4">
            <div class="email-preview-hero">
                <img src="{{ asset('assets/legacy/weberse-light.svg') }}" alt="Weberse" class="h-10 w-auto">
                <div class="mt-5 text-2xl font-bold" x-text="subject || 'Campaign subject preview'"></div>
                <div class="mt-2 text-sm text-white/80">A newsletter message from Weberse Infotech.</div>
            </div>
            <div class="px-2 py-4">
                <div class="email-preview-body">
                    <div x-html="render(body || 'Newsletter content will appear here.')"></div>
                </div>
            </div>
            <div class="px-2 pb-4">
                <div class="email-preview-auth">
                    <strong class="text-brand-blue">Authenticity check:</strong>
                    Subscribers should verify the sender address and avoid sharing credentials by email.
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
