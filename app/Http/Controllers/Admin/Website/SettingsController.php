<?php

namespace App\Http\Controllers\Admin\Website;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Website\EditWelcomeRequest;
use App\Support\VideoStorage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class SettingsController extends Controller
{
    public function edit_welcome(): View
    {
        $settings = DB::table('website_settings')->get();
        $attachments = [];

        foreach ($settings as $setting) {
            $sectionId = (int) $setting->id;
            $images = [];
            $videoLimit = websiteSectionIsVideo($sectionId) ? websiteSectionVideoMaxFiles($sectionId) : 0;

            foreach (array_filter(explode(',', (string) $setting->images)) as $file) {
                $file = trim($file);
                if ($file === '') {
                    continue;
                }

                if (websiteSectionIsVideo($sectionId) && VideoStorage::exists(VideoStorage::FOLDER_WEBSITE, $file)) {
                    $path = VideoStorage::relativePath(VideoStorage::FOLDER_WEBSITE, $file);
                    $images[] = [
                        'file' => route('admin.video.preview', ['folder' => 'website', 'file' => $file]),
                        'name' => $file,
                        'size' => VideoStorage::disk()->size($path),
                        'type' => VideoStorage::mimeType(VideoStorage::FOLDER_WEBSITE, $file),
                    ];
                    if (count($images) >= $videoLimit) {
                        break;
                    }
                    continue;
                }

                if (websiteSectionIsVideo($sectionId)) {
                    continue;
                }

                $imagePath = public_path("uploads/website/images/$file");
                if (file_exists($imagePath) && is_file($imagePath)) {
                    $images[] = [
                        'file' => asset("uploads/website/images/$file"),
                        'name' => $file,
                        'size' => filesize($imagePath),
                        'type' => mime_content_type($imagePath),
                    ];
                }
            }

            $attachments['images_' . $setting->id] = $images;
        }

        return view('admin.website.settings.edit-welcome', [
            'settings' => $settings,
            'attachments' => $attachments,
        ]);
    }

    public function update_welcome(EditWelcomeRequest $request): RedirectResponse
    {
        foreach ($request->id as $id) {
            $sectionId = (int) $id;
            $row = DB::table('website_settings')->where('id', $id)->first();
            $imagesInput = $request->{"images_$id"} ?? [];

            if (websiteSectionIsVideo($sectionId)) {
                $images = $this->saveWebsiteVideos($row, $imagesInput, websiteSectionVideoMaxFiles($sectionId));
            } elseif (websiteSectionAllowsMultipleImages($sectionId)) {
                $images = implodeUploadedFilenames($imagesInput);
            } else {
                $images = implodeUploadedFilenames($imagesInput);
            }

            DB::table('website_settings')->where('id', $id)->update([
                'title' => $request->{"title_$id"},
                'content' => $request->{"content_$id"},
                'images' => $images,
                'active' => $request->{"active_$id"} ?: 0,
            ]);
        }

        return redirect()->back()->with('success', 'تم نعديل السكاشن بنجاح');
    }

    private function saveWebsiteVideos(object $row, array $imagesInput, int $maxFiles): string
    {
        $oldFiles = array_filter(array_map('trim', explode(',', (string) ($row->images ?? ''))));
        $newVideos = implodeUploadedFilenamesMax($imagesInput, $maxFiles);

        if ($newVideos !== '') {
            $images = $newVideos;
        } else {
            $images = implode(',', array_slice($oldFiles, 0, $maxFiles));
        }

        $kept = array_filter(array_map('trim', explode(',', $images)));

        foreach ($oldFiles as $oldFile) {
            if (! in_array($oldFile, $kept, true) && VideoStorage::exists(VideoStorage::FOLDER_WEBSITE, $oldFile)) {
                VideoStorage::delete(VideoStorage::FOLDER_WEBSITE, $oldFile);
            }
        }

        return $images;
    }
}
