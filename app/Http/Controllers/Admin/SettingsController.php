<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Settings\SiteSettingsService;
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
        ]);
    }

    public function updateMail(Request $request, SiteSettingsService $settings): RedirectResponse
    {
        $data = $request->validate([
            'mailer' => ['required', 'string', 'max:20'],
            'host' => ['nullable', 'string', 'max:255'],
            'port' => ['nullable', 'integer', 'min:1'],
            'username' => ['nullable', 'string', 'max:255'],
            'password' => ['nullable', 'string', 'max:255'],
            'encryption' => ['nullable', 'string', 'max:20'],
            'from_address' => ['nullable', 'email'],
            'from_name' => ['nullable', 'string', 'max:255'],
        ]);

        $settings->putGeneralMailSettings($data);

        return back()->with('status', 'General email settings updated.');
    }

    public function updateHrMail(Request $request, SiteSettingsService $settings): RedirectResponse
    {
        $data = $request->validate([
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

        $settings->putHrMailSettings($data);

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

        return back()->with('status', 'Website feature settings updated.');
    }

    public function updateIntegrations(Request $request, SiteSettingsService $settings): RedirectResponse
    {
        $data = $request->validate([
            'tawk_property_id' => ['nullable', 'string', 'max:255'],
            'tawk_widget_id' => ['nullable', 'string', 'max:255'],
            'google_analytics_id' => ['nullable', 'string', 'max:50'],
            'google_tag_manager_id' => ['nullable', 'string', 'max:50'],
            'head_snippet' => ['nullable', 'string'],
            'footer_snippet' => ['nullable', 'string'],
        ]);

        $settings->putIntegrationSettings([
            ...$data,
            'tawk_enabled' => $request->boolean('tawk_enabled'),
        ]);

        return back()->with('status', 'Integration settings updated.');
    }
}
