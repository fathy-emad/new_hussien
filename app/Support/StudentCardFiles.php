<?php

namespace App\Support;

class StudentCardFiles
{
    public function latestReadyZip(string|int $batch): ?string
    {
        $matches = [];

        foreach (glob(public_path('cards'.DIRECTORY_SEPARATOR."batch_{$batch}_*.zip")) ?: [] as $file) {
            if ($this->isReadyZip($file)) {
                $matches[] = $file;
            }
        }

        if (! $matches) {
            return null;
        }

        usort($matches, fn ($a, $b) => filemtime($b) <=> filemtime($a));

        return $matches[0];
    }

    public function isReadyZip(string $file): bool
    {
        if (! is_file($file) || filesize($file) < 100) {
            return false;
        }

        if (! class_exists(\ZipArchive::class)) {
            return true;
        }

        $zip = new \ZipArchive();
        if ($zip->open($file) !== true) {
            return false;
        }

        $hasCardImage = false;
        for ($i = 0; $i < $zip->numFiles; $i++) {
            $name = (string) $zip->getNameIndex($i);
            if (str_ends_with(strtolower($name), '.png')) {
                $hasCardImage = true;
                break;
            }
        }

        $zip->close();

        return $hasCardImage;
    }

    public function purgeOldBatchFiles(string|int $batch): void
    {
        foreach (glob(public_path("cards/batch_{$batch}_*.zip")) ?: [] as $zip) {
            @unlink($zip);
        }

        foreach (glob(storage_path("app/tmp/cards/batch_{$batch}_*"), GLOB_ONLYDIR) ?: [] as $dir) {
            $this->removeDirectory($dir);
        }
    }

    public function removeDirectory(string $dir): void
    {
        if (! is_dir($dir)) {
            return;
        }

        $it = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($dir, \FilesystemIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::CHILD_FIRST
        );

        foreach ($it as $fs) {
            $path = $fs->getPathname();
            $fs->isDir() ? @rmdir($path) : @unlink($path);
        }

        @rmdir($dir);
    }
}
