@extends('layouts.dashboard', [
    'title' => 'Settings',
    'heading' => 'Settings',
    'subheading' => 'Platform-level operational configuration.',
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
        <div class="card mb-6 border border-green-200 bg-green-50 text-green-700">
            {{ session('status') }}
        </div>
    @endif

    <div
        x-data="{
            activeSection: 'general-email-settings',
            init() {
                const sections = this.$root.querySelectorAll('[data-settings-section]');
                const observer = new IntersectionObserver((entries) => {
                    const visible = entries
                        .filter(entry => entry.isIntersecting)
                        .sort((a, b) => b.intersectionRatio - a.intersectionRatio);

                    if (visible.length) {
                        this.activeSection = visible[0].target.id;
                    }
                }, { rootMargin: '-20% 0px -55% 0px', threshold: [0.2, 0.4, 0.7] });

                sections.forEach(section => observer.observe(section));
            },
            jumpTo(id) {
                this.activeSection = id;
                document.getElementById(id)?.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }"
        class="section-grid xl:grid-cols-[280px_1fr]"
    >
        <div class="card settings-nav-card xl:sticky xl:top-6">
            <div class="panel-title">Settings Tabs</div>
            <div class="mt-5 space-y-3">
                <button type="button" class="settings-nav-item" :class="activeSection === 'general-email-settings' ? 'settings-nav-item-active' : ''" @click="jumpTo('general-email-settings')">
                    <div>
                        <div class="font-semibold text-slate-800">General Email</div>
                        <div class="mt-1 text-slate-500">Outbound SMTP for newsletters, campaigns, and one-off emails.</div>
                    </div>
                    <div class="status-badge">Active</div>
                </button>
                <button type="button" class="settings-nav-item" :class="activeSection === 'hr-email-settings' ? 'settings-nav-item-active' : ''" @click="jumpTo('hr-email-settings')">
                    <div>
                        <div class="font-semibold text-slate-800">HR Email</div>
                        <div class="mt-1 text-slate-500">Recruitment SMTP plus HR and admin notification recipients.</div>
                    </div>
                    <div class="status-badge">Active</div>
                </button>
                <button type="button" class="settings-nav-item" :class="activeSection === 'website-features' ? 'settings-nav-item-active' : ''" @click="jumpTo('website-features')">
                    <div>
                        <div class="font-semibold text-slate-800">Website Features</div>
                        <div class="mt-1 text-slate-500">Turn selected website sections on or off without touching templates.</div>
                    </div>
                    <div class="status-badge">Active</div>
                </button>
                <button type="button" class="settings-nav-item" :class="activeSection === 'integration-settings' ? 'settings-nav-item-active' : ''" @click="jumpTo('integration-settings')">
                    <div>
                        <div class="font-semibold text-slate-800">Integrations & Snippets</div>
                        <div class="mt-1 text-slate-500">Tawk.to, analytics IDs, and custom head/footer snippets.</div>
                    </div>
                    <div class="status-badge">Active</div>
                </button>
                <button type="button" class="settings-nav-item" :class="activeSection === 'whmcs-settings' ? 'settings-nav-item-active' : ''" @click="jumpTo('whmcs-settings')">
                    <div>
                        <div class="font-semibold text-slate-800">WHMCS API</div>
                        <div class="mt-1 text-slate-500">Billing subdomain, API credentials, SSO redirect, timeout, and cache settings.</div>
                    </div>
                    <div class="status-badge">Active</div>
                </button>
                <button type="button" class="settings-nav-item" :class="activeSection === 'store-payments' ? 'settings-nav-item-active' : ''" @click="jumpTo('store-payments')">
                    <div>
                        <div class="font-semibold text-slate-800">Store Payments</div>
                        <div class="mt-1 text-slate-500">Configure Razorpay keys and webhook secret for the Weberse store.</div>
                    </div>
                    <div class="status-badge">Active</div>
                </button>
            </div>
        </div>

        <div class="space-y-6">
            <div class="card settings-section-card scroll-mt-28" id="general-email-settings" data-settings-section>
                <div class="panel-title">General Email Settings</div>
                <div class="panel-subtitle">Used for newsletters, campaigns, template sends, and one-off emails from the Email Center.</div>

                <form method="POST" action="{{ route('admin.settings.mail.update') }}" class="mt-6 grid gap-4 md:grid-cols-2">
                    @csrf
                    @method('PATCH')
                    <label class="block">
                        <span class="text-sm font-medium text-slate-700">Mailer</span>
                        <input class="input mt-2" name="mailer" value="{{ old('mailer', $generalMailSettings['mailer']) }}" placeholder="smtp" required>
                    </label>
                    <label class="block">
                        <span class="text-sm font-medium text-slate-700">Host</span>
                        <input class="input mt-2" name="host" value="{{ old('host', $generalMailSettings['host']) }}" placeholder="smtp.gmail.com">
                    </label>
                    <label class="block">
                        <span class="text-sm font-medium text-slate-700">Port</span>
                        <input class="input mt-2" type="number" min="1" name="port" value="{{ old('port', $generalMailSettings['port']) }}" placeholder="587">
                    </label>
                    <label class="block">
                        <span class="text-sm font-medium text-slate-700">Encryption</span>
                        <input class="input mt-2" name="encryption" value="{{ old('encryption', $generalMailSettings['encryption']) }}" placeholder="tls">
                    </label>
                    <label class="block">
                        <span class="text-sm font-medium text-slate-700">Username</span>
                        <input class="input mt-2" name="username" value="{{ old('username', $generalMailSettings['username']) }}" placeholder="SMTP username">
                    </label>
                    <label class="block">
                        <span class="text-sm font-medium text-slate-700">Password</span>
                        <input class="input mt-2" type="password" name="password" placeholder="Leave blank to keep the current password">
                    </label>
                    <label class="block">
                        <span class="text-sm font-medium text-slate-700">From address</span>
                        <input class="input mt-2" type="email" name="from_address" value="{{ old('from_address', $generalMailSettings['from_address']) }}" placeholder="hello@weberse.com">
                    </label>
                    <label class="block">
                        <span class="text-sm font-medium text-slate-700">From name</span>
                        <input class="input mt-2" name="from_name" value="{{ old('from_name', $generalMailSettings['from_name']) }}" placeholder="Weberse Infotech">
                    </label>
                    <label class="block md:col-span-2">
                        <span class="text-sm font-medium text-slate-700">Current password</span>
                        <input class="input mt-2" type="password" name="current_password" placeholder="Required to save email settings" required>
                    </label>
                    <div class="md:col-span-2 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-600">
                        Leaving the password blank keeps the currently saved SMTP password.
                    </div>
                    <div class="md:col-span-2">
                        <button class="btn-primary">Save General Email Settings</button>
                    </div>
                </form>
            </div>

            <div class="card settings-section-card scroll-mt-28" id="hr-email-settings" data-settings-section>
                <div class="panel-title">HR Email Settings</div>
                <div class="panel-subtitle">Used for job applications, interview invites, candidate confirmations, and internal recruitment alerts.</div>

                <form method="POST" action="{{ route('admin.settings.hr-mail.update') }}" class="mt-6 grid gap-4 md:grid-cols-2">
                    @csrf
                    @method('PATCH')
                    <label class="block">
                        <span class="text-sm font-medium text-slate-700">Mailer</span>
                        <input class="input mt-2" name="mailer" value="{{ old('mailer', $hrMailSettings['mailer']) }}" placeholder="smtp" required>
                    </label>
                    <label class="block">
                        <span class="text-sm font-medium text-slate-700">Host</span>
                        <input class="input mt-2" name="host" value="{{ old('host', $hrMailSettings['host']) }}" placeholder="smtp.gmail.com">
                    </label>
                    <label class="block">
                        <span class="text-sm font-medium text-slate-700">Port</span>
                        <input class="input mt-2" type="number" min="1" name="port" value="{{ old('port', $hrMailSettings['port']) }}" placeholder="587">
                    </label>
                    <label class="block">
                        <span class="text-sm font-medium text-slate-700">Encryption</span>
                        <input class="input mt-2" name="encryption" value="{{ old('encryption', $hrMailSettings['encryption']) }}" placeholder="tls">
                    </label>
                    <label class="block">
                        <span class="text-sm font-medium text-slate-700">Username</span>
                        <input class="input mt-2" name="username" value="{{ old('username', $hrMailSettings['username']) }}" placeholder="SMTP username">
                    </label>
                    <label class="block">
                        <span class="text-sm font-medium text-slate-700">Password</span>
                        <input class="input mt-2" type="password" name="password" placeholder="Leave blank to keep the current password">
                    </label>
                    <label class="block">
                        <span class="text-sm font-medium text-slate-700">From address</span>
                        <input class="input mt-2" type="email" name="from_address" value="{{ old('from_address', $hrMailSettings['from_address']) }}" placeholder="careers@weberse.com">
                    </label>
                    <label class="block">
                        <span class="text-sm font-medium text-slate-700">From name</span>
                        <input class="input mt-2" name="from_name" value="{{ old('from_name', $hrMailSettings['from_name']) }}" placeholder="Weberse HR">
                    </label>
                    <label class="block">
                        <span class="text-sm font-medium text-slate-700">HR recruitment email</span>
                        <input class="input mt-2" type="email" name="hr_recruitment_email" value="{{ old('hr_recruitment_email', $hrMailSettings['hr_recruitment_email']) }}" placeholder="hr@weberse.com">
                    </label>
                    <label class="block">
                        <span class="text-sm font-medium text-slate-700">Admin alert email</span>
                        <input class="input mt-2" type="email" name="admin_alert_email" value="{{ old('admin_alert_email', $hrMailSettings['admin_alert_email']) }}" placeholder="admin@weberse.com">
                    </label>
                    <label class="block md:col-span-2">
                        <span class="text-sm font-medium text-slate-700">Current password</span>
                        <input class="input mt-2" type="password" name="current_password" placeholder="Required to save HR email settings" required>
                    </label>
                    <div class="md:col-span-2 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-600">
                        Leaving the password blank keeps the currently saved HR SMTP password.
                    </div>
                    <div class="md:col-span-2">
                        <button class="btn-primary">Save HR Email Settings</button>
                    </div>
                </form>
            </div>

            <div class="card settings-section-card scroll-mt-28" id="website-features" data-settings-section>
                <div class="panel-title">Website Feature Controls</div>
                <div class="panel-subtitle">Disable sections you do not want visible yet. Routes are hidden from navigation and return 404 when switched off.</div>

                <form method="POST" action="{{ route('admin.settings.website.update') }}" class="mt-6">
                    @csrf
                    @method('PATCH')
                    <div class="grid gap-4 md:grid-cols-2">
                        @foreach ([
                            'portfolio_enabled' => ['label' => 'Portfolio', 'copy' => 'Show portfolio list and project detail pages.'],
                            'case_studies_enabled' => ['label' => 'Case Studies', 'copy' => 'Show case study navigation and detail pages.'],
                            'blog_enabled' => ['label' => 'Blog', 'copy' => 'Show articles and blog previews across the site.'],
                            'careers_enabled' => ['label' => 'Careers', 'copy' => 'Allow public hiring pages and job apply flow.'],
                            'hosting_enabled' => ['label' => 'Hosting', 'copy' => 'Show hosting and billing entry points.'],
                            'pricing_enabled' => ['label' => 'Pricing', 'copy' => 'Show pricing page in the public navigation.'],
                            'testimonials_enabled' => ['label' => 'Testimonials', 'copy' => 'Show the testimonial section on the homepage.'],
                        ] as $key => $feature)
                            <label class="dashboard-item cursor-pointer">
                                <div>
                                    <div class="font-semibold text-slate-800">{{ $feature['label'] }}</div>
                                    <div class="mt-1 text-slate-500">{{ $feature['copy'] }}</div>
                                </div>
                                <input type="checkbox" name="{{ $key }}" value="1" class="h-5 w-5 rounded border-slate-300 text-brand-green focus:ring-brand-green" @checked(old($key, $websiteFeatures[$key] ?? false))>
                            </label>
                        @endforeach
                    </div>
                    <div class="mt-6">
                        <button class="btn-primary">Save Website Features</button>
                    </div>
                </form>
            </div>

            <div class="card settings-section-card scroll-mt-28" id="integration-settings" data-settings-section>
                <div class="panel-title">Integrations & Code Snippets</div>
                <div class="panel-subtitle">Control live chat, analytics, and custom code injection without changing templates.</div>

                <form method="POST" action="{{ route('admin.settings.integrations.update') }}" class="mt-6 grid gap-4 md:grid-cols-2">
                    @csrf
                    @method('PATCH')
                    <label class="flex items-center gap-3 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-medium text-slate-700 md:col-span-2">
                        <input type="checkbox" name="tawk_enabled" value="1" @checked(old('tawk_enabled', $integrationSettings['tawk_enabled'] ?? false))>
                        Enable Tawk.to live chat
                    </label>
                    <label class="block">
                        <span class="text-sm font-medium text-slate-700">Tawk property ID</span>
                        <input class="input mt-2" name="tawk_property_id" value="{{ old('tawk_property_id', $integrationSettings['tawk_property_id'] ?? '') }}" placeholder="688dd4f9ca1507191323872f">
                    </label>
                    <label class="block">
                        <span class="text-sm font-medium text-slate-700">Tawk widget ID</span>
                        <input class="input mt-2" name="tawk_widget_id" value="{{ old('tawk_widget_id', $integrationSettings['tawk_widget_id'] ?? '') }}" placeholder="1j1hh0jgg">
                    </label>
                    <label class="block">
                        <span class="text-sm font-medium text-slate-700">Google Analytics ID</span>
                        <input class="input mt-2" name="google_analytics_id" value="{{ old('google_analytics_id', $integrationSettings['google_analytics_id'] ?? '') }}" placeholder="G-XXXXXXXXXX">
                    </label>
                    <label class="block">
                        <span class="text-sm font-medium text-slate-700">Google Tag Manager ID</span>
                        <input class="input mt-2" name="google_tag_manager_id" value="{{ old('google_tag_manager_id', $integrationSettings['google_tag_manager_id'] ?? '') }}" placeholder="GTM-XXXXXXX">
                    </label>
                    <label class="block md:col-span-2">
                        <span class="text-sm font-medium text-slate-700">Current password</span>
                        <input class="input mt-2" type="password" name="current_password" placeholder="Required to save integration settings" required>
                    </label>
                    <label class="block md:col-span-2">
                        <span class="text-sm font-medium text-slate-700">Head snippet</span>
                        <textarea class="input mt-2 min-h-40" name="head_snippet" placeholder="Script or meta tags to inject before </head>">{{ old('head_snippet', $integrationSettings['head_snippet'] ?? '') }}</textarea>
                    </label>
                    <label class="block md:col-span-2">
                        <span class="text-sm font-medium text-slate-700">Footer snippet</span>
                        <textarea class="input mt-2 min-h-40" name="footer_snippet" placeholder="Script to inject before </body>">{{ old('footer_snippet', $integrationSettings['footer_snippet'] ?? '') }}</textarea>
                    </label>
                    <div class="md:col-span-2">
                        <button class="btn-primary">Save Integration Settings</button>
                    </div>
                </form>
            </div>

            <div class="card settings-section-card scroll-mt-28" id="whmcs-settings" data-settings-section>
                <div class="panel-title">WHMCS API Settings</div>
                <div class="panel-subtitle">This is where the platform connects to your WHMCS billing install for services, invoices, domains, and client lookups.</div>

                <form method="POST" action="{{ route('admin.settings.whmcs.update') }}" class="mt-6 grid gap-4 md:grid-cols-2">
                    @csrf
                    @method('PATCH')
                    <label class="block md:col-span-2">
                        <span class="text-sm font-medium text-slate-700">WHMCS Base URL</span>
                        <input class="input mt-2" type="url" name="base_url" value="{{ old('base_url', $whmcsSettings['base_url']) }}" placeholder="https://billing.weberse.com" required>
                    </label>
                    <label class="block">
                        <span class="text-sm font-medium text-slate-700">API Identifier</span>
                        <input class="input mt-2" name="identifier" value="{{ old('identifier', $whmcsSettings['identifier']) }}" placeholder="WHMCS API identifier">
                    </label>
                    <label class="block">
                        <span class="text-sm font-medium text-slate-700">API Secret</span>
                        <input class="input mt-2" type="password" name="secret" placeholder="Leave blank to keep the current secret">
                    </label>
                    <label class="block">
                        <span class="text-sm font-medium text-slate-700">Access Key</span>
                        <input class="input mt-2" type="password" name="access_key" placeholder="Leave blank to keep the current access key">
                    </label>
                    <label class="block">
                        <span class="text-sm font-medium text-slate-700">SSO Redirect Path</span>
                        <input class="input mt-2" name="sso_redirect" value="{{ old('sso_redirect', $whmcsSettings['sso_redirect']) }}" placeholder="/clientarea.php">
                    </label>
                    <label class="block">
                        <span class="text-sm font-medium text-slate-700">Timeout (seconds)</span>
                        <input class="input mt-2" type="number" min="1" max="60" name="timeout" value="{{ old('timeout', $whmcsSettings['timeout']) }}" placeholder="10">
                    </label>
                    <label class="block">
                        <span class="text-sm font-medium text-slate-700">Cache TTL (seconds)</span>
                        <input class="input mt-2" type="number" min="0" max="86400" name="cache_ttl" value="{{ old('cache_ttl', $whmcsSettings['cache_ttl']) }}" placeholder="300">
                    </label>
                    <label class="block md:col-span-2">
                        <span class="text-sm font-medium text-slate-700">Current password</span>
                        <input class="input mt-2" type="password" name="current_password" placeholder="Required to save WHMCS settings" required>
                    </label>
                    <div class="md:col-span-2 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-600">
                        Leave the secret and access key blank to preserve the currently saved values.
                    </div>
                    <div class="md:col-span-2 flex flex-wrap gap-3">
                        <button class="btn-primary">Save WHMCS Settings</button>
                    </div>
                </form>
                <form method="POST" action="{{ route('admin.settings.whmcs.test') }}" class="mt-4">
                    @csrf
                    <button class="btn-dark">Test Connection</button>
                </form>
            </div>

            <div class="card settings-section-card scroll-mt-28" id="store-payments" data-settings-section>
                <div class="panel-title">Store Payment Settings</div>
                <div class="panel-subtitle">Used for checkout and webhook verification. Leave secrets blank to keep saved values.</div>

                <form method="POST" action="{{ route('admin.settings.store-payments.update') }}" class="mt-6 grid gap-4 md:grid-cols-2">
                    @csrf
                    @method('PATCH')
                    <label class="block md:col-span-2">
                        <span class="text-sm font-medium text-slate-700">Razorpay key ID</span>
                        <input class="input mt-2" name="razorpay_key_id" value="{{ old('razorpay_key_id', $storePaymentSettings['razorpay_key_id'] ?? '') }}" placeholder="rzp_test_...">
                    </label>
                    <label class="block">
                        <span class="text-sm font-medium text-slate-700">Razorpay key secret</span>
                        <input class="input mt-2" type="password" name="razorpay_key_secret" placeholder="Leave blank to keep the current secret">
                    </label>
                    <label class="block">
                        <span class="text-sm font-medium text-slate-700">Webhook secret</span>
                        <input class="input mt-2" type="password" name="razorpay_webhook_secret" placeholder="Leave blank to keep the current webhook secret">
                    </label>
                    <label class="block md:col-span-2">
                        <span class="text-sm font-medium text-slate-700">Current password</span>
                        <input class="input mt-2" type="password" name="current_password" placeholder="Required to save payment settings" required>
                    </label>
                    <div class="md:col-span-2">
                        <button class="btn-primary">Save Store Payment Settings</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
