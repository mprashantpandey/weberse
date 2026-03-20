<?php

namespace App\Services\CMS;

use App\Models\CMS\BlogPost;
use App\Models\CMS\CaseStudy;
use App\Models\CMS\MediaAsset;
use App\Models\CMS\PortfolioProject;
use App\Models\CMS\SiteSetting;
use App\Models\CMS\Testimonial;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MediaLibraryService
{
    public function all(?string $folder = null, ?string $search = null): Collection
    {
        $this->syncFilesystemAssets();
        $usageMap = $this->usageMap();

        return MediaAsset::query()
            ->when($folder, fn ($query) => $query->where('folder', $folder))
            ->when($search, function ($query) use ($search) {
                $query->where(function ($sub) use ($search) {
                    $sub->where('name', 'like', "%{$search}%")
                        ->orWhere('path', 'like', "%{$search}%")
                        ->orWhere('folder', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->get()
            ->map(fn (MediaAsset $asset) => $this->decorate($asset, $usageMap));
    }

    public function upload(UploadedFile $file, string $folder = 'branding'): MediaAsset
    {
        $directory = public_path('uploads/'.trim($folder, '/'));

        if (! File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        $extension = strtolower($file->getClientOriginalExtension() ?: $file->guessExtension() ?: 'png');
        $filename = now()->format('YmdHis').'-'.Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)).'.'.$extension;
        $absolutePath = $directory.DIRECTORY_SEPARATOR.$filename;
        $file->move($directory, $filename);

        return $this->persistAsset($absolutePath, 'uploads/'.trim($folder, '/'));
    }

    public function replace(MediaAsset $asset, UploadedFile $file): MediaAsset
    {
        $absolutePath = public_path($asset->path);
        $directory = dirname($absolutePath);

        if (! File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        if (File::exists($absolutePath)) {
            File::delete($absolutePath);
        }

        $optimizedPath = $asset->optimized_path ? public_path($asset->optimized_path) : null;
        if ($optimizedPath && File::exists($optimizedPath)) {
            File::delete($optimizedPath);
        }

        $file->move($directory, basename($absolutePath));

        return $this->refreshAsset($asset);
    }

    public function updateMeta(MediaAsset $asset, array $data): MediaAsset
    {
        $asset->update([
            'folder' => $data['folder'] ?? $asset->folder,
            'tags' => collect(explode(',', (string) ($data['tags'] ?? '')))
                ->map(fn ($tag) => trim($tag))
                ->filter()
                ->values()
                ->all(),
        ]);

        return $this->decorate($asset->fresh(), $this->usageMap());
    }

    public function delete(MediaAsset $asset): bool
    {
        if (($this->decorate($asset, $this->usageMap())->usage_count ?? 0) > 0) {
            return false;
        }

        $path = public_path($asset->path);
        if (File::exists($path)) {
            File::delete($path);
        }

        if ($asset->optimized_path && File::exists(public_path($asset->optimized_path))) {
            File::delete(public_path($asset->optimized_path));
        }

        $asset->delete();

        return true;
    }

    public function folderOptions(): array
    {
        return MediaAsset::query()
            ->distinct()
            ->orderBy('folder')
            ->pluck('folder')
            ->filter()
            ->values()
            ->all();
    }

    public function usageMap(): array
    {
        $paths = [];

        BlogPost::query()->select(['id', 'title', 'cover_image'])->whereNotNull('cover_image')->get()
            ->each(function (BlogPost $post) use (&$paths) {
                $paths[$post->cover_image][] = ['type' => 'Blog Post', 'label' => $post->title];
            });

        PortfolioProject::query()->select(['id', 'title', 'featured_image'])->whereNotNull('featured_image')->get()
            ->each(function (PortfolioProject $project) use (&$paths) {
                $paths[$project->featured_image][] = ['type' => 'Project', 'label' => $project->title];
            });

        CaseStudy::query()->select(['id', 'title', 'featured_image'])->whereNotNull('featured_image')->get()
            ->each(function (CaseStudy $caseStudy) use (&$paths) {
                $paths[$caseStudy->featured_image][] = ['type' => 'Case Study', 'label' => $caseStudy->title];
            });

        Testimonial::query()->select(['id', 'name', 'avatar'])->whereNotNull('avatar')->get()
            ->each(function (Testimonial $testimonial) use (&$paths) {
                $paths[$testimonial->avatar][] = ['type' => 'Testimonial', 'label' => $testimonial->name];
            });

        SiteSetting::query()->whereIn('key', ['company_profile', 'website_image_settings'])->get()
            ->each(function (SiteSetting $setting) use (&$paths) {
                foreach ($this->extractPaths($setting->value ?? []) as $path) {
                    $paths[$path][] = ['type' => 'Site Setting', 'label' => $setting->key];
                }
            });

        return $paths;
    }

    public function syncFilesystemAssets(): void
    {
        $directories = [
            public_path('uploads/branding'),
            public_path('uploads/media'),
            public_path('assets/legacy'),
            public_path('assets/images'),
        ];

        foreach ($directories as $directory) {
            if (! File::exists($directory)) {
                continue;
            }

            $relativeFolder = str_replace(public_path().DIRECTORY_SEPARATOR, '', $directory);
            $relativeFolder = str_replace(DIRECTORY_SEPARATOR, '/', $relativeFolder);

            collect(File::files($directory))
                ->filter(fn ($file) => in_array(strtolower($file->getExtension()), ['png', 'jpg', 'jpeg', 'webp', 'svg', 'ico']))
                ->each(fn ($file) => $this->persistAsset($file->getPathname(), $relativeFolder));
        }
    }

    private function persistAsset(string $absolutePath, string $folder): MediaAsset
    {
        $relativePath = str_replace(public_path().DIRECTORY_SEPARATOR, '', $absolutePath);
        $relativePath = str_replace(DIRECTORY_SEPARATOR, '/', $relativePath);
        $stats = $this->imageStats($absolutePath);
        $optimizedPath = $this->optimizedCopy($absolutePath, $relativePath, $stats['mime_type']);

        return MediaAsset::query()->updateOrCreate(
            ['path' => $relativePath],
            [
                'name' => basename($absolutePath),
                'folder' => Str::contains($folder, '/') ? Str::afterLast($folder, '/') : $folder,
                'mime_type' => $stats['mime_type'],
                'size_bytes' => File::size($absolutePath),
                'width' => $stats['width'],
                'height' => $stats['height'],
                'optimized_path' => $optimizedPath,
                'hash' => @hash_file('sha256', $absolutePath) ?: null,
            ]
        );
    }

    private function refreshAsset(MediaAsset $asset): MediaAsset
    {
        $absolutePath = public_path($asset->path);
        $stats = $this->imageStats($absolutePath);
        $optimizedPath = $this->optimizedCopy($absolutePath, $asset->path, $stats['mime_type']);

        $asset->update([
            'name' => basename($asset->path),
            'mime_type' => $stats['mime_type'],
            'size_bytes' => File::exists($absolutePath) ? File::size($absolutePath) : null,
            'width' => $stats['width'],
            'height' => $stats['height'],
            'optimized_path' => $optimizedPath,
            'hash' => File::exists($absolutePath) ? (@hash_file('sha256', $absolutePath) ?: null) : null,
        ]);

        return $this->decorate($asset->fresh(), $this->usageMap());
    }

    private function imageStats(string $absolutePath): array
    {
        $size = @getimagesize($absolutePath);

        return [
            'width' => $size[0] ?? null,
            'height' => $size[1] ?? null,
            'mime_type' => $size['mime'] ?? File::mimeType($absolutePath),
        ];
    }

    private function optimizedCopy(string $absolutePath, string $relativePath, ?string $mime): ?string
    {
        if (! function_exists('imagewebp') || ! in_array($mime, ['image/jpeg', 'image/png', 'image/webp'], true)) {
            return null;
        }

        try {
            $resource = match ($mime) {
                'image/jpeg' => @imagecreatefromjpeg($absolutePath),
                'image/png' => @imagecreatefrompng($absolutePath),
                'image/webp' => @imagecreatefromwebp($absolutePath),
                default => null,
            };

            if (! $resource) {
                return null;
            }

            $optimizedRelative = preg_replace('/\.[^.]+$/', '.webp', $relativePath);
            $optimizedAbsolute = public_path($optimizedRelative);
            $optimizedDirectory = dirname($optimizedAbsolute);

            if (! File::exists($optimizedDirectory)) {
                File::makeDirectory($optimizedDirectory, 0755, true);
            }

            imagepalettetotruecolor($resource);
            imagealphablending($resource, true);
            imagesavealpha($resource, true);
            imagewebp($resource, $optimizedAbsolute, 82);
            imagedestroy($resource);

            return str_replace(DIRECTORY_SEPARATOR, '/', $optimizedRelative);
        } catch (\Throwable) {
            return null;
        }
    }

    private function decorate(MediaAsset $asset, array $usageMap): MediaAsset
    {
        $usage = $usageMap[$asset->path] ?? [];
        $asset->setAttribute('url', asset($asset->path));
        $asset->setAttribute('optimized_url', $asset->optimized_path ? asset($asset->optimized_path) : null);
        $asset->setAttribute('extension', strtolower(pathinfo($asset->path, PATHINFO_EXTENSION)));
        $asset->setAttribute('usage_count', count($usage));
        $asset->setAttribute('usages', $usage);

        return $asset;
    }

    private function extractPaths(array $value): array
    {
        $paths = [];

        array_walk_recursive($value, function ($item) use (&$paths) {
            if (is_string($item) && preg_match('/\.(png|jpg|jpeg|webp|svg|ico)$/i', $item)) {
                $paths[] = ltrim($item, '/');
            }
        });

        return array_unique($paths);
    }
}
