@extends('layouts.dashboard', [
    'title' => 'Single Email Sender',
    'heading' => 'Single Email Sender',
    'subheading' => 'Send a one-off email using either freeform content or a stored template.',
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
        <a href="{{ route('admin.email.campaigns.index') }}" class="dashboard-subnav-link">Campaigns</a>
        <a href="{{ route('admin.email.compose') }}" class="dashboard-subnav-link dashboard-subnav-link-active">Compose</a>
    </div>

    <div
        class="section-grid xl:grid-cols-[1fr_0.92fr]"
        x-data="{
            subject: '',
            body: '',
            recipientName: '',
            nameToken: @js('{{name}}'),
            render(content) {
                return (content || '').replaceAll(this.nameToken, this.recipientName || 'Recipient').replace(/\\n/g, '<br>');
            }
        }"
    >
    <div class="card">
        <div class="panel-title">Compose Email</div>
        <div class="panel-subtitle">SMTP from Settings is used for delivery. Template selection is optional.</div>
        <form method="POST" action="{{ route('admin.email.compose.send') }}" class="mt-6 grid gap-4 md:grid-cols-2">
            @csrf
            <select class="input" name="template_id">
                <option value="">No template</option>
                @foreach ($templates as $template)
                    <option value="{{ $template->id }}">{{ $template->name }}</option>
                @endforeach
            </select>
            <div></div>
            <input class="input" name="recipient_name" x-model="recipientName" placeholder="Recipient name">
            <input class="input" type="email" name="recipient_email" placeholder="Recipient email" required>
            <input class="input md:col-span-2" name="subject" x-model="subject" placeholder="Subject" required>
            <textarea class="input min-h-80 md:col-span-2" name="body" x-model="body" placeholder="Email content" required></textarea>
            <div class="md:col-span-2 flex gap-3">
                <button class="btn-primary">Send Email</button>
                <a href="{{ route('admin.email.index') }}" class="btn-dark">Back to Email Center</a>
            </div>
        </form>
    </div>
    <div class="card">
        <div class="panel-title">Send Preview</div>
        <div class="panel-subtitle">Preview shows how the message will appear inside the common Weberse email shell.</div>
        <div class="email-preview-shell mt-6 p-4">
            <div class="email-preview-hero">
                <img src="{{ asset('assets/legacy/weberse-light.svg') }}" alt="Weberse" class="h-10 w-auto">
                <div class="mt-5 text-2xl font-bold" x-text="subject || 'Single email preview'"></div>
                <div class="mt-2 text-sm text-white/80">A direct message from Weberse Infotech.</div>
            </div>
            <div class="px-2 py-4">
                <div class="email-preview-body">
                    <div x-html="render(body || 'Compose content to preview it here.')"></div>
                </div>
            </div>
            <div class="px-2 pb-4">
                <div class="email-preview-auth">
                    <strong class="text-brand-blue">Authenticity check:</strong>
                    This preview uses the same authenticity helper included in live Weberse emails.
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
