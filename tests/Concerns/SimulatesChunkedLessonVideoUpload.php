<?php

namespace Tests\Concerns;

use App\Support\VideoStorage;
use Illuminate\Http\UploadedFile;
use Illuminate\Testing\TestResponse;

trait SimulatesChunkedLessonVideoUpload
{
    /**
     * Simulate Dropzone chunked upload (e.g. 300MB = 150 × 2MB chunks).
     * Uses small physical chunks for speed; metadata matches a large upload.
     *
     * @return array{fileName: string, mergedSize: int, totalChunks: int}
     */
    protected function uploadLessonVideoViaChunks(
        int $declaredTotalBytes = 314572800,
        int $totalChunks = 150,
        int $physicalChunkBytes = 4096,
        string $originalName = 'big_lesson_300mb.mp4',
    ): array {
        $uuid = 'integration-'.uniqid();
        $lastResponse = null;

        for ($chunkIndex = 0; $chunkIndex < $totalChunks; $chunkIndex++) {
            $tempPath = tempnam(sys_get_temp_dir(), 'dzchunk_');
            file_put_contents($tempPath, random_bytes($physicalChunkBytes));

            $uploadedFile = new UploadedFile(
                $tempPath,
                $originalName,
                'video/mp4',
                null,
                true
            );

            $lastResponse = $this->withHeaders([
                'STORE-PATH' => 'videos/lessons',
                'Accept' => 'application/json',
            ])->post(route('admin.fileUpload'), [
                'dzuuid' => $uuid,
                'dzchunkindex' => $chunkIndex,
                'dztotalchunkcount' => $totalChunks,
                'dzFilename' => $originalName,
                'dztotalfilesize' => $declaredTotalBytes,
                'dzchunksize' => 2 * 1024 * 1024,
                'dzFiles' => $uploadedFile,
            ]);

            $lastResponse->assertOk();

            if ($chunkIndex < $totalChunks - 1) {
                $lastResponse->assertJson([
                    'complete' => false,
                    'merged' => false,
                    'fileName' => '',
                ]);
            }
        }

        /** @var TestResponse $lastResponse */
        $lastResponse->assertJson([
            'complete' => true,
            'merged' => true,
        ]);

        $fileName = (string) $lastResponse->json('fileName');

        $this->assertNotSame('', $fileName);
        $this->assertTrue(
            VideoStorage::exists(VideoStorage::FOLDER_LESSONS, $fileName),
            "Merged video [{$fileName}] must exist on videos disk after chunk upload."
        );

        $relativePath = VideoStorage::relativePath(VideoStorage::FOLDER_LESSONS, $fileName);
        $mergedSize = (int) VideoStorage::disk()->size($relativePath);

        $this->assertSame($totalChunks * $physicalChunkBytes, $mergedSize);

        return [
            'fileName' => $fileName,
            'mergedSize' => $mergedSize,
            'totalChunks' => $totalChunks,
        ];
    }
}
