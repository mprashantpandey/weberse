<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\CMS\BlogPost;
use App\Models\CMS\CaseStudy;
use App\Models\CMS\PortfolioProject;
use App\Models\CMS\Service;
use App\Models\CMS\Testimonial;
use App\Models\HRM\JobOpening;
use App\Services\Settings\SiteSettingsService;
use Illuminate\View\View;

class WebsiteController extends Controller
{
    public function __construct(
        private readonly SiteSettingsService $settings,
    ) {
    }

    public function home(): View
    {
        $marketing = $this->settings->getMarketingContent();
        $features = $this->settings->getWebsiteFeatures();
        $dbTestimonials = Testimonial::query()->where('is_published', true)->take(6)->get();
        $marketingTestimonials = collect($marketing['testimonials'] ?? [])->map(function (array $testimonial) {
            return (object) $testimonial;
        });

        return view('website.pages.home', [
            'websiteFeatures' => $features,
            'services' => Service::query()->where('is_published', true)->orderBy('sort_order')->take(6)->get(),
            'projects' => $features['portfolio_enabled']
                ? PortfolioProject::query()->where('is_published', true)->latest()->take(3)->get()
                : collect(),
            'posts' => $features['blog_enabled']
                ? BlogPost::query()->where('is_published', true)->latest('published_at')->take(3)->get()
                : collect(),
            'testimonials' => $dbTestimonials->count() >= 4
                ? $dbTestimonials
                : $dbTestimonials->concat($marketingTestimonials)->take(5)->values(),
            'featuredProjects' => $features['portfolio_enabled']
                ? PortfolioProject::query()->where('is_published', true)->latest()->take(3)->get()
                : collect(),
            'serviceDetails' => collect($marketing['services'] ?? []),
            'industries' => $marketing['industries'] ?? [],
            'technologies' => $marketing['technologies'] ?? [],
            'techStack' => collect($marketing['tech_stack'] ?? []),
            'caseStudies' => $features['case_studies_enabled'] ?? false
                ? CaseStudy::query()->where('is_published', true)->latest()->take(2)->get()
                : collect(),
        ]);
    }

    public function about(): View
    {
        $marketing = $this->settings->getMarketingContent();

        return view('website.pages.about', [
            'serviceDetails' => collect($marketing['services'] ?? [])->take(4),
            'technologies' => $marketing['technologies'] ?? [],
        ]);
    }

    public function services(): View
    {
        $marketing = $this->settings->getMarketingContent();

        return view('website.pages.services', [
            'services' => Service::query()->where('is_published', true)->orderBy('sort_order')->get(),
            'serviceDetails' => collect($marketing['services'] ?? []),
        ]);
    }

    public function service(string $slug): View
    {
        $marketing = $this->settings->getMarketingContent();
        $service = collect($marketing['services'] ?? [])->firstWhere('slug', $slug);

        abort_unless($service, 404);

        return view('website.services.show', [
            'service' => $service,
            'projects' => collect($marketing['projects'] ?? [])->take(2),
        ]);
    }

    public function portfolio(): View
    {
        $this->ensureFeatureEnabled('portfolio_enabled');

        return view('website.pages.portfolio', [
            'projects' => PortfolioProject::query()->where('is_published', true)->latest()->get(),
            'featuredProjects' => PortfolioProject::query()->where('is_published', true)->latest()->take(3)->get(),
        ]);
    }

    public function project(string $slug): View
    {
        $this->ensureFeatureEnabled('portfolio_enabled');
        $project = PortfolioProject::query()
            ->where('slug', $slug)
            ->where('is_published', true)
            ->first();

        abort_unless($project, 404);

        return view('website.portfolio.show', [
            'project' => $project,
            'caseStudies' => CaseStudy::query()->where('is_published', true)->latest()->take(2)->get(),
        ]);
    }

    public function caseStudies(): View
    {
        $this->ensureFeatureEnabled('case_studies_enabled');

        return view('website.pages.case-studies', [
            'caseStudies' => CaseStudy::query()->where('is_published', true)->latest()->get(),
        ]);
    }

    public function caseStudy(string $slug): View
    {
        $this->ensureFeatureEnabled('case_studies_enabled');
        $caseStudy = CaseStudy::query()
            ->where('slug', $slug)
            ->where('is_published', true)
            ->first();

        abort_unless($caseStudy, 404);

        return view('website.case-studies.show', [
            'caseStudy' => $caseStudy,
            'projects' => PortfolioProject::query()->where('is_published', true)->latest()->take(2)->get(),
        ]);
    }

    public function blog(): View
    {
        $this->ensureFeatureEnabled('blog_enabled');

        return view('website.pages.blog', [
            'posts' => BlogPost::query()->where('is_published', true)->latest('published_at')->paginate(9),
        ]);
    }

    public function blogPost(BlogPost $post): View
    {
        $this->ensureFeatureEnabled('blog_enabled');
        abort_unless($post->is_published, 404);

        return view('website.blog.show', [
            'post' => $post->load('author'),
            'recentPosts' => BlogPost::query()
                ->where('is_published', true)
                ->whereKeyNot($post->getKey())
                ->latest('published_at')
                ->take(3)
                ->get(),
        ]);
    }

    public function careers(): View
    {
        $this->ensureFeatureEnabled('careers_enabled');

        return view('website.pages.careers', [
            'jobs' => JobOpening::query()
                ->with('department')
                ->where('is_published', true)
                ->latest('published_at')
                ->get(),
        ]);
    }

    public function apply(JobOpening $jobOpening): View
    {
        $this->ensureFeatureEnabled('careers_enabled');
        abort_unless($jobOpening->is_published, 404);

        return view('website.pages.apply-job', [
            'job' => $jobOpening->load('department'),
            'jobs' => JobOpening::query()
                ->with('department')
                ->where('is_published', true)
                ->latest('published_at')
                ->get(),
        ]);
    }

    public function hosting(): View
    {
        $this->ensureFeatureEnabled('hosting_enabled');

        return view('website.pages.hosting');
    }

    public function contact(): View
    {
        return view('website.pages.contact');
    }

    public function pricing(): View
    {
        $this->ensureFeatureEnabled('pricing_enabled');

        return view('website.pages.pricing');
    }

    public function privacy(): View
    {
        return view('website.pages.privacy');
    }

    public function terms(): View
    {
        return view('website.pages.terms');
    }

    private function ensureFeatureEnabled(string $feature): void
    {
        abort_unless($this->settings->featureEnabled($feature), 404);
    }
}
