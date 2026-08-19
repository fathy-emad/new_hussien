<?php

namespace App\Http\Controllers\Admin\Website;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Website\UpdateWebsitePageRequest;
use App\Models\WebsitePageSection;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PageController extends Controller
{
    private const SECTION_KEYS = [
        'hero',
        'why_us',
        'trending_offline',
        'featured_students',
        'reviews',
        'centers',
    ];

    public function edit(): View
    {
        $sections = WebsitePageSection::query()
            ->whereIn('section_key', self::SECTION_KEYS)
            ->get()
            ->keyBy('section_key');

        foreach (self::SECTION_KEYS as $key) {
            if (! $sections->has($key)) {
                $sections->put($key, WebsitePageSection::create([
                    'section_key' => $key,
                    'extra' => $key === 'featured_students' ? ['images' => []] : null,
                ]));
            }
        }

        $whyUs = $sections->get('why_us');
        $featured = $sections->get('featured_students');

        $attachments = [
            'why_us_side_image' => $this->buildSingleImageAttachment($whyUs?->extra['side_image'] ?? null),
            'featured_students_images' => $this->buildMultiImageAttachments(
                $this->normalizeSectionImages($featured?->extra['images'] ?? [])
            ),
        ];

        return view('admin.website.page.edit', [
            'sections' => $sections,
            'attachments' => $attachments,
        ]);
    }

    public function update(UpdateWebsitePageRequest $request): RedirectResponse
    {
        $this->updateSimpleSection('hero', $request->input('hero_title'), $request->input('hero_description'));
        $this->updateSimpleSection(
            'trending_offline',
            $request->input('trending_offline_title'),
            $request->input('trending_offline_description')
        );
        $this->updateSimpleSection(
            'reviews',
            $request->input('reviews_title'),
            $request->input('reviews_description')
        );
        $this->updateSimpleSection(
            'centers',
            $request->input('centers_title'),
            $request->input('centers_description')
        );

        $whyUs = WebsitePageSection::firstOrCreate(['section_key' => 'why_us']);
        $whyExtra = $whyUs->extra ?? [];
        $whyExtra['points'] = array_slice(array_pad($request->input('why_us_points', []), 4, ''), 0, 4);

        $sideImage = implodeUploadedFilenames($request->input('why_us_side_image', []));
        if ($sideImage !== '') {
            $whyExtra['side_image'] = explode(',', $sideImage)[0];
        }

        $whyUs->update([
            'title' => $request->input('why_us_title'),
            'description' => $request->input('why_us_description'),
            'extra' => $whyExtra,
        ]);

        $featured = WebsitePageSection::firstOrCreate(['section_key' => 'featured_students']);
        $featuredExtra = $featured->extra ?? ['images' => []];
        $featuredExtra['images'] = $this->normalizeSectionImages(
            $request->input('featured_students_images', [])
        );

        $featured->update([
            'title' => $request->input('featured_students_title'),
            'description' => $request->input('featured_students_description'),
            'extra' => $featuredExtra,
        ]);

        return redirect()
            ->back()
            ->with('success', 'تم تحديث محتوى الموقع بنجاح');
    }

    private function updateSimpleSection(string $key, ?string $title, ?string $description): void
    {
        WebsitePageSection::updateOrCreate(
            ['section_key' => $key],
            [
                'title' => $title,
                'description' => $description,
            ]
        );
    }

    private function buildSingleImageAttachment(?string $filename): array
    {
        $file = normalizeStoredFilename($filename);
        if (! $file) {
            return [];
        }

        $path = public_path("uploads/website/images/{$file}");
        if (! is_file($path)) {
            return [];
        }

        return [[
            'file' => asset("uploads/website/images/{$file}"),
            'name' => $file,
            'size' => filesize($path),
            'type' => mime_content_type($path),
        ]];
    }

    private function buildMultiImageAttachments(array $filenames): array
    {
        $attachments = [];

        foreach ($filenames as $filename) {
            $file = normalizeStoredFilename((string) $filename);
            if (! $file) {
                continue;
            }

            $path = public_path("uploads/website/images/{$file}");
            if (! is_file($path)) {
                continue;
            }

            $attachments[] = [
                'file' => asset("uploads/website/images/{$file}"),
                'name' => $file,
                'size' => filesize($path),
                'type' => mime_content_type($path),
            ];
        }

        return $attachments;
    }

    private function normalizeSectionImages(mixed $value): array
    {
        if (is_string($value)) {
            return explodeUploadedFilenames($value);
        }

        if (! is_array($value)) {
            return [];
        }

        $flat = [];
        foreach ($value as $item) {
            if (is_string($item) && str_contains($item, ',')) {
                foreach (explodeUploadedFilenames($item) as $name) {
                    $flat[] = $name;
                }
                continue;
            }

            $flat[] = $item;
        }

        return explodeUploadedFilenames($flat);
    }
}
