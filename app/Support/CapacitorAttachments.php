<?php

namespace App\Support;

use App\Models\Capacitor;

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

        $pdfs = [];
        foreach (array_filter(explode(',', (string) $capacitor->pdf)) as $pdf) {
            $meta = LessonAttachments::publicUploadMeta('uploads/capacitors/lessons/files', trim($pdf));
            if ($meta) {
                $pdfs[] = $meta;
            }
        }

        return [
            'images' => $images,
            'pdf' => $pdfs,
            'hasVideo' => VimeoVideo::hasVideo($capacitor->link),
        ];
    }
}
