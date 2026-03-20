<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Communication\OutboundEmail;
use App\Services\WHMCS\WhmcsService;
use App\Services\Settings\SiteSettingsService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingsController extends Controller
{
    public function index(SiteSettingsService $settings): View
    {
        return view('admin.settings.index', [
            'generalMailSettings' => $settings->getGeneralMailSettings(),
            'hrMailSettings' => $settings->getHrMailSettings(),
            'websiteFeatures' => $settings->getWebsiteFeatures(),
            'integrationSettings' => $settings->getIntegrationSettings(),
            'whmcsSettings' => $settings->getWhmcsSettings(),
            'storePaymentSettings' => $settings->getStorePaymentSettings(),
        ]);
    }

    public function health(SiteSettingsService $settings): View
    {
        $health = $settings->getSystemHealth();
        $schedulerLastRanAt = ! empty($health['scheduler_last_ran_at']) ? Carbon::parse($health['scheduler_last_ran_at']) : null;
        $queueLastStartedAt = ! empty($health['queue_last_started_at']) ? Carbon::parse($health['queue_last_started_at']) : null;
        $queueLastFinishedAt = ! empty($health['queue_last_finished_at']) ? Carbon::parse($health['queue_last_finished_at']) : null;

        $schedulerHealthy = $schedulerLastRanAt?->gt(now()->subMinutes(3)) ?? false;
        $queueHealthy = $queueLastFinishedAt?->gt(now()->subMinutes(5)) ?? false;

        return view('admin.settings.health', [
            'cronCommand' => '* * * * * php '.base_path('artisan').' schedule:run >> /dev/null 2>&1',
            'schedulerLastRanAt' => $schedulerLastRanAt,
            'queueLastStartedAt' => $queueLastStartedAt,
            'queueLastFinishedAt' => $queueLastFinishedAt,
            'schedulerHealthy' => $schedulerHealthy,
            'queueHealthy' => $queueHealthy,
            'jobsPending' => DB::table('jobs')->count(),
            'jobsReserved' => DB::table('jobs')->whereNotNull('reserved_at')->count(),
            'failedJobs' => DB::table('failed_jobs')->count(),
            'failedEmails' => OutboundEmail::query()->where('status', 'failed')->count(),
            'queuedEmails' => OutboundEmail::query()->where('status', 'queued')->count(),
        ]);
    }

    public function updateMail(Request $request, SiteSettingsService $settings): RedirectResponse
    {
        $data = $request->validate([
            'current_password' => ['required', 'current_password'],
            'mailer' => ['required', 'string', 'max:20'],
            'host' => ['nullable', 'string', 'max:255'],
            'port' => ['nullable', 'integer', 'min:1'],
            'username' => ['nullable', 'string', 'max:255'],
            'password' => ['nullable', 'string', 'max:255'],
            'encryption' => ['nullable', 'string', 'max:20'],
            'from_address' => ['nullable', 'email'],
            'from_name' => ['nullable', 'string', 'max:255'],
        ]);

        unset($data['current_password']);
        $settings->putGeneralMailSettings($data);

        activity()->causedBy($request->user())->event('settings_updated')->withProperties(['scope' => 'general_mail'])->log('General email settings updated');

        return back()->with('status', 'General email settings updated.');
    }

    public function updateHrMail(Request $request, SiteSettingsService $settings): RedirectResponse
    {
        $data = $request->validate([
            'current_password' => ['required', 'current_password'],
            'mailer' => ['required', 'string', 'max:20'],
            'host' => ['nullable', 'string', 'max:255'],
            'port' => ['nullable', 'integer', 'min:1'],
            'username' => ['nullable', 'string', 'max:255'],
            'password' => ['nullable', 'string', 'max:255'],
            'encryption' => ['nullable', 'string', 'max:20'],
            'from_address' => ['nullable', 'email'],
            'from_name' => ['nullable', 'string', 'max:255'],
            'hr_recruitment_email' => ['nullable', 'email'],
            'admin_alert_email' => ['nullable', 'email'],
        ]);

        unset($data['current_password']);
        $settings->putHrMailSettings($data);

        activity()->causedBy($request->user())->event('settings_updated')->withProperties(['scope' => 'hr_mail'])->log('HR email settings updated');

        return back()->with('status', 'HR email settings updated.');
    }

    public function updateWebsite(Request $request, SiteSettingsService $settings): RedirectResponse
    {
        $features = [
            'portfolio_enabled' => $request->boolean('portfolio_enabled'),
            'case_studies_enabled' => $request->boolean('case_studies_enabled'),
            'blog_enabled' => $request->boolean('blog_enabled'),
            'careers_enabled' => $request->boolean('careers_enabled'),
            'hosting_enabled' => $request->boolean('hosting_enabled'),
            'pricing_enabled' => $request->boolean('pricing_enabled'),
            'testimonials_enabled' => $request->boolean('testimonials_enabled'),
        ];

        $settings->putWebsiteFeatures($features);

        activity()->causedBy($request->user())->event('settings_updated')->withProperties(['scope' => 'website_features', 'features' => $features])->log('Website features updated');

        return back()->with('status', 'Website feature settings updated.');
    }

    public function updateIntegrations(Request $request, SiteSettingsService $settings): RedirectResponse
    {
        $data = $request->validate([
            'current_password' => ['required', 'current_password'],
            'tawk_property_id' => ['nullable', 'string', 'max:255'],
            'tawk_widget_id' => ['nullable', 'string', 'max:255'],
            'google_analytics_id' => ['nullable', 'string', 'max:50'],
            'google_tag_manager_id' => ['nullable', 'string', 'max:50'],
            'head_snippet' => ['nullable', 'string'],
            'footer_snippet' => ['nullable', 'string'],
        ]);

        unset($data['current_password']);
        $settings->putIntegrationSettings([
            ...$data,
            'tawk_enabled' => $request->boolean('tawk_enabled'),
        ]);

        activity()->causedBy($request->user())->event('settings_updated')->withProperties(['scope' => 'integrations'])->log('Integration settings updated');

        return back()->with('status', 'Integration settings updated.');
    }

    public function updateWhmcs(Request $request, SiteSettingsService $settings): RedirectResponse
    {
        $data = $request->validate([
            'current_password' => ['required', 'current_password'],
            'base_url' => ['required', 'url'],
            'identifier' => ['nullable', 'string', 'max:255'],
            'secret' => ['nullable', 'string', 'max:255'],
            'access_key' => ['nullable', 'string', 'max:255'],
            'sso_redirect' => ['nullable', 'string', 'max:255'],
            'timeout' => ['nullable', 'integer', 'min:1', 'max:60'],
            'cache_ttl' => ['nullable', 'integer', 'min:0', 'max:86400'],
        ]);

        unset($data['current_password']);
        $settings->putWhmcsSettings($data);

        activity()->causedBy($request->user())->event('settings_updated')->withProperties(['scope' => 'whmcs'])->log('WHMCS settings updated');

        return back()->with('status', 'WHMCS API settings updated.');
    }

    public function updateStorePayments(Request $request, SiteSettingsService $settings): RedirectResponse
    {
        $data = $request->validate([
            'current_password' => ['required', 'current_password'],
            'razorpay_key_id' => ['nullable', 'string', 'max:255'],
            'razorpay_key_secret' => ['nullable', 'string', 'max:255'],
            'razorpay_webhook_secret' => ['nullable', 'string', 'max:255'],
        ]);

        unset($data['current_password']);
        $settings->putStorePaymentSettings($data);

        activity()->causedBy($request->user())->event('settings_updated')->withProperties(['scope' => 'store_payments'])->log('Store payment settings updated');

        return back()->with('status', 'Store payment settings updated.');
    }

    public function testWhmcs(WhmcsService $whmcs): RedirectResponse
    {
        $result = $whmcs->testConnection();

        return back()->with(
            $result['ok'] ? 'status' : 'status',
            $result['ok']
                ? 'WHMCS connection successful. System URL: '.($result['system_url'] ?: 'Unavailable')
                : 'WHMCS connection failed: '.$result['message']
        );
    }
}
