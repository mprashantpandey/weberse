<?php

namespace App\Services\Settings;

use App\Models\CMS\SiteSetting;

class SiteSettingsService
{
    private ?array $companyProfileCache = null;
    private ?array $integrationSettingsCache = null;
    private ?array $websiteFeaturesCache = null;
    private ?array $generalMailSettingsCache = null;
    private ?array $hrMailSettingsCache = null;
    private ?array $websiteImagesCache = null;
    private ?array $storePaymentSettingsCache = null;
    private ?array $whmcsSettingsCache = null;
    private ?array $systemHealthCache = null;

    public function getCompanyProfile(): array
    {
        if ($this->companyProfileCache !== null) {
            return $this->companyProfileCache;
        }

        $defaults = array_merge(config('platform.company', []), [
            'light_logo' => 'assets/legacy/weberse-light.svg',
            'dark_logo' => 'assets/legacy/weberse-dark.svg',
            'favicon' => 'favicon.ico',
            'address_line_1' => config('platform.company.location'),
            'address_line_2' => '',
        ]);

        $stored = SiteSetting::query()
            ->where('key', 'company_profile')
            ->first()?->value;

        return $this->companyProfileCache = array_merge($defaults, is_array($stored) ? $stored : []);
    }

    public function putCompanyProfile(array $profile): void
    {
        $this->companyProfileCache = $profile;

        SiteSetting::query()->updateOrCreate(
            ['key' => 'company_profile'],
            [
                'group' => 'branding',
                'value' => $profile,
                'type' => 'json',
                'is_public' => true,
            ]
        );
    }

    public function getIntegrationSettings(): array
    {
        if ($this->integrationSettingsCache !== null) {
            return $this->integrationSettingsCache;
        }

        $defaults = [
            'tawk_enabled' => false,
            'tawk_property_id' => '',
            'tawk_widget_id' => '',
            'google_analytics_id' => '',
            'google_tag_manager_id' => '',
            'head_snippet' => '',
            'footer_snippet' => '',
        ];

        $stored = SiteSetting::query()
            ->where('key', 'website_integration_settings')
            ->first()?->value;

        return $this->integrationSettingsCache = array_merge($defaults, is_array($stored) ? $stored : []);
    }

    public function putIntegrationSettings(array $settings): void
    {
        $this->integrationSettingsCache = $settings;

        SiteSetting::query()->updateOrCreate(
            ['key' => 'website_integration_settings'],
            [
                'group' => 'website',
                'value' => $settings,
                'type' => 'json',
                'is_public' => false,
            ]
        );
    }

    public function getStorePaymentSettings(): array
    {
        if ($this->storePaymentSettingsCache !== null) {
            return $this->storePaymentSettingsCache;
        }

        $defaults = [
            'razorpay_key_id' => (string) config('razorpay.key_id', ''),
            'razorpay_key_secret' => (string) config('razorpay.key_secret', ''),
            'razorpay_webhook_secret' => (string) config('razorpay.webhook_secret', ''),
        ];

        $stored = SiteSetting::query()
            ->where('key', 'store_payment_settings')
            ->first()?->value;

        return $this->storePaymentSettingsCache = array_merge($defaults, is_array($stored) ? $stored : []);
    }

    public function getWhmcsSettings(): array
    {
        if ($this->whmcsSettingsCache !== null) {
            return $this->whmcsSettingsCache;
        }

        $defaults = [
            'base_url' => (string) config('whmcs.base_url', ''),
            'identifier' => (string) config('whmcs.identifier', ''),
            'secret' => (string) config('whmcs.secret', ''),
            'access_key' => (string) config('whmcs.access_key', ''),
            'sso_redirect' => (string) config('whmcs.sso_redirect', '/clientarea.php'),
            'timeout' => (int) config('whmcs.timeout', 10),
            'cache_ttl' => (int) config('whmcs.cache_ttl', 300),
        ];

        $stored = SiteSetting::query()
            ->where('key', 'whmcs_settings')
            ->first()?->value;

        return $this->whmcsSettingsCache = array_merge($defaults, is_array($stored) ? $stored : []);
    }

    public function putWhmcsSettings(array $settings): void
    {
        $current = $this->getWhmcsSettings();
        $merged = $this->preserveSecretFields($current, $settings, ['secret', 'access_key']);
        $this->whmcsSettingsCache = $merged;

        SiteSetting::query()->updateOrCreate(
            ['key' => 'whmcs_settings'],
            [
                'group' => 'integrations',
                'value' => $merged,
                'type' => 'json',
                'is_public' => false,
            ]
        );
    }

    public function putStorePaymentSettings(array $settings): void
    {
        $current = $this->getStorePaymentSettings();
        $merged = $this->preserveSecretFields($current, $settings, ['razorpay_key_secret', 'razorpay_webhook_secret']);
        $this->storePaymentSettingsCache = $merged;

        SiteSetting::query()->updateOrCreate(
            ['key' => 'store_payment_settings'],
            [
                'group' => 'store',
                'value' => $merged,
                'type' => 'json',
                'is_public' => false,
            ]
        );
    }

    public function getWebsiteFeatures(): array
    {
        if ($this->websiteFeaturesCache !== null) {
            return $this->websiteFeaturesCache;
        }

        $defaults = [
            'portfolio_enabled' => true,
            'case_studies_enabled' => true,
            'blog_enabled' => true,
            'careers_enabled' => true,
            'hosting_enabled' => true,
            'pricing_enabled' => true,
            'testimonials_enabled' => true,
        ];

        $stored = SiteSetting::query()
            ->where('key', 'website_feature_settings')
            ->first()?->value;

        return $this->websiteFeaturesCache = array_merge($defaults, is_array($stored) ? $stored : []);
    }

    public function putWebsiteFeatures(array $features): void
    {
        $this->websiteFeaturesCache = $features;

        SiteSetting::query()->updateOrCreate(
            ['key' => 'website_feature_settings'],
            [
                'group' => 'website',
                'value' => $features,
                'type' => 'json',
                'is_public' => false,
            ]
        );
    }

    public function featureEnabled(string $feature): bool
    {
        return (bool) ($this->getWebsiteFeatures()[$feature] ?? false);
    }

    public function getGeneralMailSettings(): array
    {
        if ($this->generalMailSettingsCache !== null) {
            return $this->generalMailSettingsCache;
        }

        $defaults = [
            'mailer' => 'smtp',
            'host' => '',
            'port' => 587,
            'username' => '',
            'password' => '',
            'encryption' => 'tls',
            'from_address' => '',
            'from_name' => 'Weberse Infotech',
        ];

        $stored = SiteSetting::query()
            ->where('key', 'general_mail_settings')
            ->first()?->value;

        if (! is_array($stored)) {
            $legacy = SiteSetting::query()
                ->where('key', 'system_mail_settings')
                ->first()?->value;

            $stored = is_array($legacy) ? $legacy : [];
        }

        return $this->generalMailSettingsCache = array_merge($defaults, is_array($stored) ? $stored : []);
    }

    public function putGeneralMailSettings(array $settings): void
    {
        $current = $this->getGeneralMailSettings();
        $merged = $this->preserveSecretFields($current, $settings, ['password']);
        $this->generalMailSettingsCache = $merged;

        SiteSetting::query()->updateOrCreate(
            ['key' => 'general_mail_settings'],
            [
                'group' => 'system',
                'value' => $merged,
                'type' => 'json',
                'is_public' => false,
            ]
        );
    }

    public function getHrMailSettings(): array
    {
        if ($this->hrMailSettingsCache !== null) {
            return $this->hrMailSettingsCache;
        }

        $defaults = [
            'mailer' => 'smtp',
            'host' => '',
            'port' => 587,
            'username' => '',
            'password' => '',
            'encryption' => 'tls',
            'from_address' => '',
            'from_name' => 'Weberse HR',
            'hr_recruitment_email' => '',
            'admin_alert_email' => '',
        ];

        $stored = SiteSetting::query()
            ->where('key', 'hr_mail_settings')
            ->first()?->value;

        if (! is_array($stored)) {
            $legacy = SiteSetting::query()
                ->where('key', 'system_mail_settings')
                ->first()?->value;

            $stored = is_array($legacy) ? $legacy : [];
        }

        return $this->hrMailSettingsCache = array_merge($defaults, is_array($stored) ? $stored : []);
    }

    public function putHrMailSettings(array $settings): void
    {
        $current = $this->getHrMailSettings();
        $merged = $this->preserveSecretFields($current, $settings, ['password']);
        $this->hrMailSettingsCache = $merged;

        SiteSetting::query()->updateOrCreate(
            ['key' => 'hr_mail_settings'],
            [
                'group' => 'system',
                'value' => $merged,
                'type' => 'json',
                'is_public' => false,
            ]
        );
    }

    public function getMailSettings(): array
    {
        return $this->getGeneralMailSettings();
    }

    public function putMailSettings(array $settings): void
    {
        $this->putGeneralMailSettings($settings);
    }

    public function getWebsiteImages(): array
    {
        if ($this->websiteImagesCache !== null) {
            return $this->websiteImagesCache;
        }

        $defaults = [
            'home' => [
                'hero_dashboard' => 'assets/images/dashboard-mockup.svg',
                'blog_preview' => 'assets/legacy/hero-1.jpg',
            ],
            'about' => [
                'hero_team' => 'assets/legacy/team.jpg',
                'strategy_meeting' => 'assets/legacy/office-meeting.jpg',
                'delivery_systems' => 'assets/legacy/work-1.jpg',
            ],
            'services' => [
                'overview_hero' => 'assets/legacy/web-development.png',
                'mobile-app-development' => 'assets/legacy/app-mockup.png',
                'web-development' => 'assets/legacy/web-development.png',
                'digital-marketing' => 'assets/legacy/marketing.jpg',
                'ui-ux-design' => 'assets/legacy/uiux-design.jpg',
                'ai-automation' => 'assets/images/service-showcase.svg',
                'whatsapp-cloud-automation' => 'assets/legacy/whatsapp-cloud.png',
                'email-marketing-automation' => 'assets/legacy/email-marketing.jpg',
                'startup-mvp-development' => 'assets/legacy/office-meeting.jpg',
                'custom-software-development' => 'assets/legacy/software.png',
                'digital-marketing-hero' => 'assets/images/hero-market-analysis.svg',
                'ui-ux-design-hero' => 'assets/images/uiux-hero.svg',
                'ui-ux-design-industries' => 'assets/images/uiux-industries.svg',
                'email-marketing-automation-hero' => 'assets/images/email-automation-hero.svg',
                'startup-mvp-development-hero' => 'assets/images/startup-mvp-hero.svg',
                'custom-software-development-hero' => 'assets/images/team-collaboration.svg',
                'whatsapp-cloud-automation-hero' => 'assets/images/whatsapp-automation-hero.svg',
                'ai-automation-hero' => 'assets/images/ai-automation-hero.svg',
            ],
            'portfolio' => [
                'hero_showcase' => 'assets/images/project-dashboard.svg',
                'fallback_placeholder' => 'assets/images/map-placeholder.svg',
            ],
            'case_studies' => [
                'scaling-a-modern-hosting-brand' => 'assets/legacy/work-2.jpg',
                'building-an-internal-ops-platform' => 'assets/legacy/software.png',
            ],
            'projects' => [
                'zenflow-ops' => 'assets/legacy/work-1.jpg',
                'nova-host' => 'assets/legacy/work-2.jpg',
                'pulse-mobile' => 'assets/legacy/work-3.jpg',
            ],
            'blog' => [
                'hero_cover' => 'assets/images/blog-cover.svg',
                'post_fallback_cover' => 'assets/images/blog-cover.svg',
            ],
            'careers' => [
                'hero_team' => 'assets/legacy/team.jpg',
            ],
            'contact' => [
                'workspace' => 'assets/legacy/office-meeting.jpg',
            ],
            'hosting' => [
                'hero_interface' => 'assets/images/project-hosting.svg',
            ],
            'pricing' => [
                'hero_showcase' => 'assets/images/service-showcase.svg',
            ],
            'cta' => [
                'background' => 'assets/legacy/cta-bg.svg',
            ],
        ];

        $stored = SiteSetting::query()
            ->where('key', 'website_image_settings')
            ->first()?->value;

        return $this->websiteImagesCache = $this->mergeNested($defaults, is_array($stored) ? $stored : []);
    }

    public function putWebsiteImages(array $images): void
    {
        $this->websiteImagesCache = $images;

        SiteSetting::query()->updateOrCreate(
            ['key' => 'website_image_settings'],
            [
                'group' => 'website',
                'value' => $images,
                'type' => 'json',
                'is_public' => false,
            ]
        );
    }

    public function getMarketingContent(): array
    {
        $marketing = config('marketing');
        $websiteImages = $this->getWebsiteImages();

        $marketing['services'] = collect($marketing['services'] ?? [])
            ->map(function (array $service) use ($websiteImages) {
                $service['image'] = $websiteImages['services'][$service['slug']] ?? $service['image'];

                return $service;
            })
            ->all();

        $marketing['projects'] = collect($marketing['projects'] ?? [])
            ->map(function (array $project) use ($websiteImages) {
                $project['image'] = $websiteImages['projects'][$project['slug']] ?? $project['image'];

                return $project;
            })
            ->all();

        $marketing['case_studies'] = collect($marketing['case_studies'] ?? [])
            ->map(function (array $caseStudy) use ($websiteImages) {
                $caseStudy['image'] = $websiteImages['case_studies'][$caseStudy['slug']] ?? $caseStudy['image'];

                return $caseStudy;
            })
            ->all();

        return $marketing;
    }

    public function getSystemHealth(): array
    {
        if ($this->systemHealthCache !== null) {
            return $this->systemHealthCache;
        }

        $defaults = [
            'scheduler_last_ran_at' => null,
            'queue_last_started_at' => null,
            'queue_last_finished_at' => null,
        ];

        $stored = SiteSetting::query()
            ->where('key', 'system_health')
            ->first()?->value;

        return $this->systemHealthCache = array_merge($defaults, is_array($stored) ? $stored : []);
    }

    public function putSystemHealth(array $health): void
    {
        $merged = array_merge($this->getSystemHealth(), $health);
        $this->systemHealthCache = $merged;

        SiteSetting::query()->updateOrCreate(
            ['key' => 'system_health'],
            [
                'group' => 'system',
                'value' => $merged,
                'type' => 'json',
                'is_public' => false,
            ]
        );
    }

    private function mergeNested(array $defaults, array $stored): array
    {
        foreach ($stored as $key => $value) {
            if (is_array($value) && is_array($defaults[$key] ?? null)) {
                $defaults[$key] = $this->mergeNested($defaults[$key], $value);
                continue;
            }

            $defaults[$key] = $value;
        }

        return $defaults;
    }

    private function preserveSecretFields(array $current, array $incoming, array $secretKeys): array
    {
        foreach ($secretKeys as $key) {
            if (($incoming[$key] ?? '') === '' && ! empty($current[$key])) {
                $incoming[$key] = $current[$key];
            }
        }

        return array_merge($current, $incoming);
    }
}
