<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\CMS\BlogPost;
use App\Models\CMS\CaseStudy;
use App\Models\CMS\PortfolioProject;
use App\Models\HRM\JobOpening;
use App\Services\Settings\SiteSettingsService;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;

class SeoController extends Controller
{
    public function __construct(
        private readonly SiteSettingsService $settings,
    ) {
    }

    public function robots(): Response
    {
        $baseUrl = rtrim(config('app.url'), '/');
        $content = implode("\n", [
            'User-agent: *',
            'Allow: /',
            '',
            'Disallow: /admin/',
            'Disallow: /client/',
            'Disallow: /employee/',
            'Disallow: /login',
            'Disallow: /security',
            'Disallow: /two-factor-challenge',
            '',
            'Sitemap: '.$baseUrl.'/sitemap.xml',
        ]);

        return response($content, 200, ['Content-Type' => 'text/plain; charset=UTF-8']);
    }

    public function sitemap(): Response
    {
        $features = $this->settings->getWebsiteFeatures();
        $marketing = $this->settings->getMarketingContent();
        $now = now();

        $urls = collect([
            $this->urlItem(route('website.home'), $now, 'daily', '1.0'),
            $this->urlItem(route('website.about'), $now, 'monthly', '0.8'),
            $this->urlItem(route('website.services'), $now, 'weekly', '0.9'),
            $this->urlItem(route('website.contact'), $now, 'monthly', '0.8'),
            $this->urlItem(route('website.privacy'), $now, 'yearly', '0.3'),
            $this->urlItem(route('website.terms'), $now, 'yearly', '0.3'),
        ]);

        foreach (collect($marketing['services'] ?? []) as $service) {
            if (! empty($service['slug'])) {
                $urls->push($this->urlItem(
                    route('website.services.show', $service['slug']),
                    $now,
                    'monthly',
                    '0.8'
                ));
            }
        }

        if ($features['portfolio_enabled'] ?? false) {
            $urls->push($this->urlItem(route('website.portfolio'), $now, 'weekly', '0.8'));

            PortfolioProject::query()
                ->where('is_published', true)
                ->get()
                ->each(function (PortfolioProject $project) use ($urls) {
                    $urls->push($this->urlItem(
                        route('website.portfolio.show', $project->slug),
                        $project->updated_at ?? $project->created_at,
                        'monthly',
                        '0.7'
                    ));
                });
        }

        if ($features['case_studies_enabled'] ?? false) {
            $urls->push($this->urlItem(route('website.case-studies.index'), $now, 'weekly', '0.8'));

            CaseStudy::query()
                ->where('is_published', true)
                ->get()
                ->each(function (CaseStudy $caseStudy) use ($urls) {
                    $urls->push($this->urlItem(
                        route('website.case-studies.show', $caseStudy->slug),
                        $caseStudy->updated_at ?? $caseStudy->created_at,
                        'monthly',
                        '0.7'
                    ));
                });
        }

        if ($features['blog_enabled'] ?? false) {
            $urls->push($this->urlItem(route('website.blog.index'), $now, 'weekly', '0.8'));

            BlogPost::query()
                ->where('is_published', true)
                ->get()
                ->each(function (BlogPost $post) use ($urls) {
                    $urls->push($this->urlItem(
                        route('website.blog.show', $post->slug),
                        $post->published_at ?? $post->updated_at ?? $post->created_at,
                        'monthly',
                        '0.7'
                    ));
                });
        }

        if ($features['careers_enabled'] ?? false) {
            $urls->push($this->urlItem(route('website.careers'), $now, 'weekly', '0.7'));

            JobOpening::query()
                ->where('is_published', true)
                ->get()
                ->each(function (JobOpening $job) use ($urls) {
                    $urls->push($this->urlItem(
                        route('website.careers.apply-page', $job->slug),
                        $job->published_at ?? $job->updated_at ?? $job->created_at,
                        'weekly',
                        '0.5'
                    ));
                });
        }

        if ($features['hosting_enabled'] ?? false) {
            $urls->push($this->urlItem(route('website.hosting'), $now, 'weekly', '0.7'));
        }

        if ($features['pricing_enabled'] ?? false) {
            $urls->push($this->urlItem(route('website.pricing'), $now, 'monthly', '0.6'));
        }

        return response()
            ->view('website.seo.sitemap', ['urls' => $urls->values()])
            ->header('Content-Type', 'application/xml; charset=UTF-8');
    }

    private function urlItem(string $loc, Carbon|string|null $lastmod = null, string $changefreq = 'monthly', string $priority = '0.5'): array
    {
        return [
            'loc' => $loc,
            'lastmod' => $lastmod instanceof Carbon ? $lastmod->toAtomString() : ($lastmod ? Carbon::parse($lastmod)->toAtomString() : null),
            'changefreq' => $changefreq,
            'priority' => $priority,
        ];
    }
}
