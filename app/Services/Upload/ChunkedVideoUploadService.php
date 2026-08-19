<?php

namespace App\Services\Upload;

use App\Support\VideoStorage;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ChunkedVideoUploadService
{
    public function handle(Request $request, UploadTarget $target): array
    {
        if (! $target->isVideo()) {
            throw new \InvalidArgumentException('الرفع على أجزاء متاح للفيديو فقط.');
        }

        if (! VideoStorage::allowedFolder($target->folder)) {
            throw new \InvalidArgumentException('مجلد الفيديو غير مسموح.');
        }

        $uuid = $this->sanitizeUuid((string) $request->input('dzuuid'));
        $chunkIndex = (int) $request->input('dzchunkindex');
        $totalChunks = (int) $request->input('dztotalchunkcount');

        if ($uuid === '' || $totalChunks < 1 || $chunkIndex < 0 || $chunkIndex >= $totalChunks) {
            throw new \InvalidArgumentException('بيانات جزء الرفع غير صالحة.');
        }

        if ($chunkIndex === 0) {
            $this->purgeStaleChunks();
        }

        /** @var UploadedFile|null $chunk */
        $chunk = $request->file('dzFiles');

        if (! $chunk || ! $chunk->isValid()) {
            throw new \InvalidArgumentException('لم يتم استلام جزء الملف.');
        }

        $chunkDir = $this->chunkDirectory($uuid);
        File::ensureDirectoryExists($chunkDir);

        if ($chunkIndex === 0) {
            $this->storeChunkMeta($chunkDir, $request, $chunk);
        }

        $chunk->move($chunkDir, $chunkIndex.'.part');

        if ($chunkIndex < $totalChunks - 1) {
            return [
                'fileName' => '',
                'chunkIndex' => $chunkIndex,
                'totalChunks' => $totalChunks,
                'complete' => false,
                'merged' => false,
            ];
        }

        $originalName = $this->resolveOriginalName($chunkDir, $request, $chunk);
        $fileName = $this->mergeChunks($uuid, $totalChunks, $originalName, $target->folder);
        $relativePath = VideoStorage::relativePath($target->folder, $fileName);

        clearstatcache(true, VideoStorage::absolutePath($target->folder, $fileName));

        return [
            'fileName' => $fileName,
            'storedPath' => $relativePath,
            'chunkIndex' => $chunkIndex,
            'totalChunks' => $totalChunks,
            'complete' => true,
            'merged' => true,
            'size' => VideoStorage::disk()->size($relativePath),
        ];
    }

    public function remove(UploadTarget $target, string $fileName): void
    {
        VideoStorage::delete($target->folder, $fileName);
    }

    private function storeChunkMeta(string $chunkDir, Request $request, UploadedFile $chunk): void
    {
        $originalName = (string) ($request->input('dzFilename') ?: $chunk->getClientOriginalName());

        file_put_contents($chunkDir.DIRECTORY_SEPARATOR.'meta.json', json_encode([
            'originalName' => $originalName,
            'totalChunks' => (int) $request->input('dztotalchunkcount'),
            'totalSize' => (int) $request->input('dztotalfilesize'),
            'startedAt' => time(),
        ], JSON_UNESCAPED_UNICODE));
    }

    private function resolveOriginalName(string $chunkDir, Request $request, UploadedFile $chunk): string
    {
        $metaPath = $chunkDir.DIRECTORY_SEPARATOR.'meta.json';

        if (is_file($metaPath)) {
            $meta = json_decode((string) file_get_contents($metaPath), true);

            if (is_array($meta) && ! empty($meta['originalName'])) {
                return (string) $meta['originalName'];
            }
        }

        return (string) ($request->input('dzFilename') ?: $chunk->getClientOriginalName() ?: 'video.mp4');
    }

    private function mergeChunks(string $uuid, int $totalChunks, string $originalName, string $folder): string
    {
        if (function_exists('ignore_user_abort')) {
            @ignore_user_abort(true);
        }

        $chunkDir = $this->chunkDirectory($uuid);
        $extension = $this->resolveVideoExtension($originalName);
        $fileName = time().'_'.Str::random(10).'.'.$extension;

        VideoStorage::ensureFolder($folder);

        $relativePath = VideoStorage::relativePath($folder, $fileName);
        $finalPath = VideoStorage::absolutePath($folder, $fileName);

        $out = fopen($finalPath, 'wb');

        if ($out === false) {
            $this->purgeChunkWorkspace($uuid);
            throw new \RuntimeException('تعذر إنشاء ملف الفيديو النهائي.');
        }

        try {
            for ($i = 0; $i < $totalChunks; $i++) {
                $partPath = $chunkDir.DIRECTORY_SEPARATOR.$i.'.part';

                if (! is_file($partPath)) {
                    throw new \RuntimeException("جزء مفقود: {$i}");
                }

                $in = fopen($partPath, 'rb');

                if ($in === false) {
                    throw new \RuntimeException("تعذر قراءة الجزء: {$i}");
                }

                stream_copy_to_stream($in, $out);
                fclose($in);

                @unlink($partPath);
            }
        } catch (\Throwable $e) {
            fclose($out);
            @unlink($finalPath);
            $this->purgeChunkWorkspace($uuid);
            throw $e;
        }

        fclose($out);

        if (! is_file($finalPath) || filesize($finalPath) < 1) {
            @unlink($finalPath);
            $this->purgeChunkWorkspace($uuid);
            throw new \RuntimeException('ملف الفيديو النهائي فارغ أو غير موجود بعد الدمج.');
        }

        $this->purgeChunkWorkspace($uuid);
        clearstatcache(true, $finalPath);

        return basename($fileName);
    }

    private function resolveVideoExtension(string $originalName): string
    {
        $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION) ?: 'mp4');
        $allowed = config('upload.video_extensions', ['mp4', 'webm', 'mov']);

        return in_array($extension, $allowed, true) ? $extension : 'mp4';
    }

    private function sanitizeUuid(string $uuid): string
    {
        return preg_replace('/[^a-zA-Z0-9\-]/', '', $uuid) ?? '';
    }

    private function chunkDirectory(string $uuid): string
    {
        return storage_path('app/'.config('upload.chunks_path').'/'.$uuid);
    }

    private function chunksBasePath(): string
    {
        return storage_path('app/'.config('upload.chunks_path'));
    }

    /** Remove chunk dir + meta after successful merge or on failure */
    private function purgeChunkWorkspace(string $uuid): void
    {
        $chunkDir = $this->chunkDirectory($uuid);

        if (is_dir($chunkDir)) {
            File::deleteDirectory($chunkDir);
        }

        clearstatcache(false, $chunkDir);
    }

    /** Remove abandoned chunk uploads (failed/cancelled) */
    private function purgeStaleChunks(): void
    {
        $base = $this->chunksBasePath();

        if (! is_dir($base)) {
            return;
        }

        $maxAge = (int) config('upload.chunks_max_age_hours', 24) * 3600;
        $now = time();

        foreach (glob($base.DIRECTORY_SEPARATOR.'*', GLOB_ONLYDIR) ?: [] as $dir) {
            if (($now - (int) filemtime($dir)) > $maxAge) {
                File::deleteDirectory($dir);
            }
        }
    }
}
