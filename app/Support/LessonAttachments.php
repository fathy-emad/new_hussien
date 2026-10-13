<?php

namespace App\Support;

use App\Models\Lesson;

class LessonAttachments
{
    public static function forLesson(Lesson $lesson, bool $includeVideo = false): array
    {
        $images = [];
        foreach (explodeUploadedFilenames($lesson->images) as $image) {
            $meta = self::publicUploadMeta('uploads/lessons/images', $image);
            if ($meta) {
                $images[] = $meta;
            }
        }

        $pdfs = [];
        foreach (explodeUploadedFilenames($lesson->pdf) as $pdf) {
            $meta = self::publicUploadMeta('uploads/lessons/files', $pdf);
            if ($meta) {
                $pdfs[] = $meta;
            }
        }

        $attachments = [
            'images' => $images,
            'pdf' => $pdfs,
        ];

        if ($includeVideo) {
            $lessonVideo = [];
            $videoMeta = VideoStorage::dropzoneMeta(VideoStorage::FOLDER_LESSONS, $lesson->link);
            if ($videoMeta) {
                $lessonVideo[] = $videoMeta;
            }
            $attachments['lessonVideo'] = $lessonVideo;
        }

        return $attachments;
    }

    public static function publicUploadMeta(string $webDir, string $fileName): ?array
    {
        $fileName = basename(trim($fileName));
        if ($fileName === '') {
            return null;
        }

        $file = public_path($webDir.'/'.$fileName);
        if (! is_file($file)) {
            return null;
        }

        $size = filesize($file);

        return [
            'file' => asset($webDir.'/'.$fileName),
            'name' => $fileName,
            'size' => $size,
            'sizeLabel' => self::formatFileSize($size),
            'type' => mime_content_type($file),
            'extension' => strtolower(pathinfo($fileName, PATHINFO_EXTENSION)),
        ];
    }

    public static function formatFileSize(int $bytes): string
    {
        if ($bytes >= 1048576) {
            return round($bytes / 1048576, 1).' MB';
        }

        if ($bytes >= 1024) {
            return round($bytes / 1024, 1).' KB';
        }

        return $bytes.' B';
    }
}
