<?php

namespace App\Support;

use App\Models\Capacitor;
use App\Support\VideoStorage;

class CapacitorAttachments
{
    public static function forCapacitor(Capacitor $capacitor): array
    {
        $images = [];
        foreach (array_filter(explode(',', (string) $capacitor->images)) as $image) {
            $meta = LessonAttachments::publicUploadMeta('uploads/capacitors/lessons/images', trim($image));
            if ($meta) {
                $images[] = $meta;
            }
        }

        $thumbnail = [];
        $thumbFile = normalizeStoredFilename($capacitor->thumbnail);
        if ($thumbFile) {
            $meta = LessonAttachments::publicUploadMeta('uploads/capacitors/lessons/images', $thumbFile);
            if ($meta) {
                $thumbnail[] = $meta;
            }
        }

        $pdfs = [];
        foreach (array_filter(explode(',', (string) $capacitor->pdf)) as $pdf) {
            $meta = LessonAttachments::publicUploadMeta('uploads/capacitors/lessons/files', trim($pdf));
            if ($meta) {
                $pdfs[] = $meta;
            }
        }

        $hasVideo = false;
        $videoFile = normalizeStoredFilename($capacitor->link);
        if ($videoFile && VideoStorage::exists(VideoStorage::FOLDER_CAPACITORS, $videoFile)) {
            $hasVideo = true;
        }

        return [
            'thumbnail' => $thumbnail,
            'images' => $images,
            'pdf' => $pdfs,
            'hasVideo' => $hasVideo,
            'videoFile' => $videoFile,
        ];
    }
}
