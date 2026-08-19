<?php

namespace App\Support;

use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Storage;

class VideoStorage
{
    public const FOLDER_LESSONS = 'lessons';

    public const FOLDER_CAPACITORS = 'capacitors';

    public const FOLDER_WEBSITE = 'website';

    public static function disk(): FilesystemAdapter
    {
        /** @var FilesystemAdapter $disk */
        $disk = Storage::disk('videos');

        return $disk;
    }

    /** STORE-PATH header value for Dropzone uploads */
    public static function storePath(string $folder): string
    {
        return 'videos/'.$folder;
    }

    public static function relativePath(string $folder, string $fileName): string
    {
        return $folder.'/'.basename($fileName);
    }

    public static function absolutePath(string $folder, string $fileName): string
    {
        return self::disk()->path(self::relativePath($folder, $fileName));
    }

    public static function exists(string $folder, ?string $fileName): bool
    {
        $fileName = normalizeStoredFilename($fileName);

        if (! $fileName) {
            return false;
        }

        return self::disk()->exists(self::relativePath($folder, $fileName));
    }

    public static function size(string $folder, string $fileName): int
    {
        $path = self::relativePath($folder, $fileName);

        return (int) self::disk()->size($path);
    }

    public static function delete(string $folder, ?string $fileName): void
    {
        if (! $fileName) {
            return;
        }

        $path = self::relativePath($folder, $fileName);

        if (self::disk()->exists($path)) {
            self::disk()->delete($path);
        }
    }

    public static function allowedFolder(string $folder): bool
    {
        return in_array($folder, [
            self::FOLDER_LESSONS,
            self::FOLDER_CAPACITORS,
            self::FOLDER_WEBSITE,
        ], true);
    }

    public static function ensureFolder(string $folder): void
    {
        if (! self::allowedFolder($folder)) {
            return;
        }

        self::disk()->makeDirectory($folder);
    }

    public static function mimeType(string $folder, string $fileName): string
    {
        $path = self::relativePath($folder, $fileName);
        $mime = self::disk()->mimeType($path);

        return $mime ?: 'video/mp4';
    }

    public static function adminPreviewUrl(string $folder, string $fileName): string
    {
        return route('admin.video.preview', [
            'folder' => $folder,
            'file' => basename($fileName),
        ]);
    }

    /** Dropzone mock-file payload for edit forms */
    public static function dropzoneMeta(string $folder, ?string $fileName): ?array
    {
        $fileName = normalizeStoredFilename($fileName);

        if (! $fileName || ! self::exists($folder, $fileName)) {
            return null;
        }

        return [
            'name' => $fileName,
            'size' => self::size($folder, $fileName),
            'type' => self::mimeType($folder, $fileName),
            'file' => self::adminPreviewUrl($folder, $fileName),
        ];
    }
}
