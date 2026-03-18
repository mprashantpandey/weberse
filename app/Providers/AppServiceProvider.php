<?php

namespace App\Providers;

use App\Services\Settings\SiteSettingsService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Throwable;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        try {
            $settings = app(SiteSettingsService::class);
            $companyProfile = $settings->getCompanyProfile();
            $websiteImages = $settings->getWebsiteImages();
            $marketingContent = $settings->getMarketingContent();
        } catch (Throwable) {
            $companyProfile = array_merge(config('platform.company', []), [
                'light_logo' => 'assets/legacy/weberse-light.svg',
                'dark_logo' => 'assets/legacy/weberse-dark.svg',
                'favicon' => 'favicon.ico',
                'address_line_1' => config('platform.company.location'),
                'address_line_2' => '',
            ]);
            $websiteImages = [];
            $marketingContent = config('marketing');
        }

        View::share('companyProfile', $companyProfile);
        View::share('websiteImages', $websiteImages);
        View::share('marketingContent', $marketingContent);
        View::share('mediaAssetUrl', function (?string $path, ?string $fallback = null): string {
            $resolved = blank($path) ? $fallback : $path;

            if (blank($resolved)) {
                return '';
            }

            if (str_starts_with($resolved, 'http://') || str_starts_with($resolved, 'https://') || str_starts_with($resolved, '/')) {
                return $resolved;
            }

            return asset(ltrim($resolved, '/'));
        });
    }
}
