<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CMS\BlogPost;
use App\Models\CMS\CaseStudy;
use App\Models\CMS\MediaAsset;
use App\Models\CMS\PortfolioProject;
use App\Models\CMS\Testimonial;
use App\Services\CMS\MediaLibraryService;
use App\Services\Settings\SiteSettingsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CmsController extends Controller
{
    public function index(): View
    {
        return view('admin.cms.index', [
            'summary' => [
                'website_details' => 1,
                'website_images' => 1,
                'media_assets' => MediaAsset::query()->count(),
                'posts' => BlogPost::query()->count(),
                'projects' => PortfolioProject::query()->count(),
                'case_studies' => CaseStudy::query()->count(),
                'testimonials' => Testimonial::query()->count(),
            ],
            'latestPosts' => BlogPost::query()->latest()->take(4)->get(),
            'latestProjects' => PortfolioProject::query()->latest()->take(4)->get(),
            'latestCaseStudies' => CaseStudy::query()->latest()->take(4)->get(),
        ]);
    }

    public function websiteDetails(SiteSettingsService $settings, MediaLibraryService $mediaLibrary): View
    {
        return view('admin.cms.website-details', [
            'profile' => $settings->getCompanyProfile(),
            'mediaAssets' => $mediaLibrary->all(),
        ]);
    }

    public function posts(): View
    {
        return view('admin.cms.posts', [
            'posts' => BlogPost::query()->with('author')->latest()->get(),
        ]);
    }

    public function images(SiteSettingsService $settings, MediaLibraryService $mediaLibrary): View
    {
        return view('admin.cms.images', [
            'websiteImages' => $settings->getWebsiteImages(),
            'mediaAssets' => $mediaLibrary->all(),
        ]);
    }

    public function mediaLibrary(Request $request, MediaLibraryService $mediaLibrary): View
    {
        return view('admin.cms.media-library', [
            'assets' => $mediaLibrary->all($request->string('folder')->toString() ?: null, $request->string('search')->toString() ?: null),
            'folders' => $mediaLibrary->folderOptions(),
            'activeFolder' => $request->string('folder')->toString(),
            'search' => $request->string('search')->toString(),
        ]);
    }

    public function createPost(MediaLibraryService $mediaLibrary): View
    {
        return view('admin.cms.post-form', [
            'post' => new BlogPost(['is_published' => true]),
            'mode' => 'create',
            'mediaAssets' => $mediaLibrary->all(),
        ]);
    }

    public function editPost(BlogPost $post, MediaLibraryService $mediaLibrary): View
    {
        return view('admin.cms.post-form', [
            'post' => $post->load('author'),
            'mode' => 'edit',
            'mediaAssets' => $mediaLibrary->all(),
        ]);
    }

    public function projects(): View
    {
        return view('admin.cms.projects', [
            'projects' => PortfolioProject::query()->latest()->get(),
        ]);
    }

    public function createProject(MediaLibraryService $mediaLibrary): View
    {
        return view('admin.cms.project-form', [
            'project' => new PortfolioProject(['is_published' => true]),
            'mode' => 'create',
            'mediaAssets' => $mediaLibrary->all(),
        ]);
    }

    public function editProject(PortfolioProject $project, MediaLibraryService $mediaLibrary): View
    {
        return view('admin.cms.project-form', [
            'project' => $project,
            'mode' => 'edit',
            'mediaAssets' => $mediaLibrary->all(),
        ]);
    }

    public function caseStudies(): View
    {
        return view('admin.cms.case-studies', [
            'caseStudies' => CaseStudy::query()->latest()->get(),
        ]);
    }

    public function createCaseStudy(MediaLibraryService $mediaLibrary): View
    {
        return view('admin.cms.case-study-form', [
            'caseStudy' => new CaseStudy(['is_published' => true]),
            'mode' => 'create',
            'mediaAssets' => $mediaLibrary->all(),
        ]);
    }

    public function editCaseStudy(CaseStudy $caseStudy, MediaLibraryService $mediaLibrary): View
    {
        return view('admin.cms.case-study-form', [
            'caseStudy' => $caseStudy,
            'mode' => 'edit',
            'mediaAssets' => $mediaLibrary->all(),
        ]);
    }

    public function testimonials(MediaLibraryService $mediaLibrary): View
    {
        return view('admin.cms.testimonials', [
            'testimonials' => Testimonial::query()->latest()->get(),
            'mediaAssets' => $mediaLibrary->all(),
        ]);
    }

    public function storePost(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'body' => ['nullable', 'string'],
            'cover_image' => ['nullable', 'string', 'max:255'],
            'seo_title' => ['nullable', 'string', 'max:255'],
            'seo_description' => ['nullable', 'string', 'max:320'],
            'is_published' => ['nullable'],
        ]);

        BlogPost::query()->create([
            ...$data,
            'slug' => $this->uniqueSlug(BlogPost::class, $data['title']),
            'author_id' => $request->user()->id,
            'is_published' => array_key_exists('is_published', $data),
            'published_at' => array_key_exists('is_published', $data) ? now() : null,
        ]);

        return back()->with('status', 'Blog post created.');
    }

    public function updatePost(Request $request, BlogPost $post): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'body' => ['nullable', 'string'],
            'cover_image' => ['nullable', 'string', 'max:255'],
            'seo_title' => ['nullable', 'string', 'max:255'],
            'seo_description' => ['nullable', 'string', 'max:320'],
            'is_published' => ['nullable'],
        ]);

        $post->update([
            ...$data,
            'is_published' => array_key_exists('is_published', $data),
            'published_at' => array_key_exists('is_published', $data) ? ($post->published_at ?? now()) : null,
        ]);

        return back()->with('status', 'Blog post updated.');
    }

    public function storeProject(Request $request): RedirectResponse
    {
        $data = $this->validatedProjectData($request);

        PortfolioProject::query()->create([
            ...$data,
            'slug' => $this->uniqueSlug(PortfolioProject::class, $data['title']),
        ]);

        return back()->with('status', 'Project created.');
    }

    public function updateProject(Request $request, PortfolioProject $project): RedirectResponse
    {
        $project->update($this->validatedProjectData($request));

        return back()->with('status', 'Project updated.');
    }

    public function storeCaseStudy(Request $request): RedirectResponse
    {
        $data = $this->validatedCaseStudyData($request);

        CaseStudy::query()->create([
            ...$data,
            'slug' => $this->uniqueSlug(CaseStudy::class, $data['title']),
        ]);

        return back()->with('status', 'Case study created.');
    }

    public function updateCaseStudy(Request $request, CaseStudy $caseStudy): RedirectResponse
    {
        $caseStudy->update($this->validatedCaseStudyData($request));

        return back()->with('status', 'Case study updated.');
    }

    public function storeTestimonial(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'company' => ['nullable', 'string', 'max:255'],
            'quote' => ['required', 'string'],
            'avatar' => ['nullable', 'string', 'max:255'],
            'is_published' => ['nullable'],
        ]);

        Testimonial::query()->create([
            ...$data,
            'is_published' => array_key_exists('is_published', $data),
        ]);

        return back()->with('status', 'Testimonial created.');
    }

    public function updateTestimonial(Request $request, Testimonial $testimonial): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'company' => ['nullable', 'string', 'max:255'],
            'quote' => ['required', 'string'],
            'avatar' => ['nullable', 'string', 'max:255'],
            'is_published' => ['nullable'],
        ]);

        $testimonial->update([
            ...$data,
            'is_published' => array_key_exists('is_published', $data),
        ]);

        return back()->with('status', 'Testimonial updated.');
    }

    public function updateWebsiteDetails(Request $request, SiteSettingsService $settings): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'tagline' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:100'],
            'whatsapp' => ['nullable', 'string', 'max:100'],
            'skype' => ['nullable', 'string', 'max:255'],
            'billing_url' => ['nullable', 'url', 'max:255'],
            'light_logo' => ['nullable', 'string', 'max:255'],
            'dark_logo' => ['nullable', 'string', 'max:255'],
            'favicon' => ['nullable', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'address_line_1' => ['nullable', 'string', 'max:255'],
            'address_line_2' => ['nullable', 'string', 'max:255'],
            'socials.facebook' => ['nullable', 'url', 'max:255'],
            'socials.instagram' => ['nullable', 'url', 'max:255'],
            'socials.twitter' => ['nullable', 'url', 'max:255'],
            'socials.linkedin' => ['nullable', 'url', 'max:255'],
            'socials.youtube' => ['nullable', 'url', 'max:255'],
        ]);

        $settings->putCompanyProfile(array_merge(
            $settings->getCompanyProfile(),
            $data,
            ['socials' => array_merge($settings->getCompanyProfile()['socials'] ?? [], $data['socials'] ?? [])]
        ));

        return back()->with('status', 'Website details updated.');
    }

    public function updateImages(Request $request, SiteSettingsService $settings): RedirectResponse
    {
        $request->validate([
            'images' => ['required', 'array'],
        ]);

        $settings->putWebsiteImages($this->filterImageMap(
            $request->input('images', []),
            $settings->getWebsiteImages()
        ));

        return back()->with('status', 'Website images updated.');
    }

    public function uploadMedia(Request $request, MediaLibraryService $mediaLibrary): RedirectResponse
    {
        return $this->handleMediaUpload($request, $mediaLibrary);
    }

    public function uploadWebsiteMedia(Request $request, MediaLibraryService $mediaLibrary): RedirectResponse
    {
        return $this->handleMediaUpload($request, $mediaLibrary);
    }

    public function updateMediaAsset(Request $request, MediaAsset $asset, MediaLibraryService $mediaLibrary): RedirectResponse
    {
        $data = $request->validate([
            'folder' => ['required', 'string', 'max:100'],
            'tags' => ['nullable', 'string', 'max:500'],
        ]);

        $mediaLibrary->updateMeta($asset, $data);

        activity()
            ->causedBy($request->user())
            ->performedOn($asset)
            ->event('media_updated')
            ->withProperties($data)
            ->log('Media asset updated');

        return back()->with('status', 'Media asset updated.');
    }

    public function replaceMediaAsset(Request $request, MediaAsset $asset, MediaLibraryService $mediaLibrary): RedirectResponse
    {
        $data = $request->validate([
            'media_file' => ['required', 'file', 'max:8192', 'mimetypes:image/png,image/jpeg,image/webp,image/svg+xml,image/x-icon,image/vnd.microsoft.icon'],
        ]);

        $mediaLibrary->replace($asset, $data['media_file']);

        activity()
            ->causedBy($request->user())
            ->performedOn($asset)
            ->event('media_replaced')
            ->log('Media asset replaced');

        return back()->with('status', 'Media asset replaced.');
    }

    public function destroyMediaAsset(Request $request, MediaAsset $asset, MediaLibraryService $mediaLibrary): RedirectResponse
    {
        if (! $mediaLibrary->delete($asset)) {
            return back()->with('status', 'This asset is still in use and cannot be deleted yet.');
        }

        activity()
            ->causedBy($request->user())
            ->event('media_deleted')
            ->withProperties(['path' => $asset->path])
            ->log('Media asset deleted');

        return back()->with('status', 'Media asset deleted.');
    }

    private function handleMediaUpload(Request $request, MediaLibraryService $mediaLibrary): RedirectResponse
    {
        $data = $request->validate([
            'media_file' => ['required', 'file', 'max:8192', 'mimetypes:image/png,image/jpeg,image/webp,image/svg+xml,image/x-icon,image/vnd.microsoft.icon'],
        ]);

        $asset = $mediaLibrary->upload($data['media_file'], 'media');

        activity()
            ->causedBy($request->user())
            ->performedOn($asset)
            ->event('media_uploaded')
            ->log('Media asset uploaded');

        return back()
            ->with('status', 'Media uploaded successfully.')
            ->with('uploaded_media_path', $asset->path)
            ->with('uploaded_media_name', $asset->name);
    }

    private function uniqueSlug(string $modelClass, string $title): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $counter = 2;

        while ($modelClass::query()->where('slug', $slug)->exists()) {
            $slug = $base.'-'.$counter;
            $counter++;
        }

        return $slug;
    }

    private function filterImageMap(array $submitted, array $current): array
    {
        foreach ($current as $key => $value) {
            if (is_array($value)) {
                $current[$key] = $this->filterImageMap(Arr::get($submitted, $key, []), $value);
                continue;
            }

            $next = Arr::get($submitted, $key);

            if (is_string($next) && strlen(trim($next)) <= 255) {
                $current[$key] = trim($next);
            }
        }

        return $current;
    }

    private function validatedProjectData(Request $request): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:255'],
            'client_name' => ['nullable', 'string', 'max:255'],
            'industry' => ['nullable', 'string', 'max:255'],
            'featured_image' => ['nullable', 'string', 'max:255'],
            'project_url' => ['nullable', 'url', 'max:255'],
            'summary' => ['nullable', 'string', 'max:500'],
            'body' => ['nullable', 'string'],
            'challenge' => ['nullable', 'string'],
            'solution' => ['nullable', 'string'],
            'outcome' => ['nullable', 'string'],
            'stack_list' => ['nullable', 'string'],
            'metrics_list' => ['nullable', 'string'],
            'is_published' => ['nullable'],
        ]);

        return [
            'title' => $data['title'],
            'category' => $data['category'] ?? null,
            'client_name' => $data['client_name'] ?? null,
            'industry' => $data['industry'] ?? null,
            'featured_image' => $data['featured_image'] ?? null,
            'project_url' => $data['project_url'] ?? null,
            'summary' => $data['summary'] ?? null,
            'body' => $data['body'] ?? null,
            'challenge' => $data['challenge'] ?? null,
            'solution' => $data['solution'] ?? null,
            'outcome' => $data['outcome'] ?? null,
            'stack' => $this->parseList($data['stack_list'] ?? null),
            'metrics' => $this->parseList($data['metrics_list'] ?? null),
            'is_published' => array_key_exists('is_published', $data),
        ];
    }

    private function validatedCaseStudyData(Request $request): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'summary' => ['nullable', 'string', 'max:500'],
            'client' => ['nullable', 'string', 'max:255'],
            'industry' => ['nullable', 'string', 'max:255'],
            'duration' => ['nullable', 'string', 'max:255'],
            'engagement' => ['nullable', 'string', 'max:255'],
            'featured_image' => ['nullable', 'string', 'max:255'],
            'services_list' => ['nullable', 'string'],
            'stack_list' => ['nullable', 'string'],
            'challenge' => ['nullable', 'string'],
            'solution' => ['nullable', 'string'],
            'outcome' => ['nullable', 'string'],
            'results_list' => ['nullable', 'string'],
            'metrics_list' => ['nullable', 'string'],
            'quote' => ['nullable', 'string'],
            'quote_author' => ['nullable', 'string', 'max:255'],
            'is_published' => ['nullable'],
        ]);

        return [
            'title' => $data['title'],
            'summary' => $data['summary'] ?? null,
            'client' => $data['client'] ?? null,
            'industry' => $data['industry'] ?? null,
            'duration' => $data['duration'] ?? null,
            'engagement' => $data['engagement'] ?? null,
            'featured_image' => $data['featured_image'] ?? null,
            'services' => $this->parseList($data['services_list'] ?? null),
            'stack' => $this->parseList($data['stack_list'] ?? null),
            'challenge' => $data['challenge'] ?? null,
            'solution' => $data['solution'] ?? null,
            'outcome' => $data['outcome'] ?? null,
            'results' => $this->parseList($data['results_list'] ?? null),
            'metrics' => $this->parseList($data['metrics_list'] ?? null),
            'quote' => $data['quote'] ?? null,
            'quote_author' => $data['quote_author'] ?? null,
            'is_published' => array_key_exists('is_published', $data),
        ];
    }

    private function parseList(?string $value): array
    {
        return collect(preg_split('/\r\n|\r|\n|,/', (string) $value))
            ->map(fn ($item) => trim($item))
            ->filter()
            ->values()
            ->all();
    }
}
