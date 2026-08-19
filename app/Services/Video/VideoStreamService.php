<?php

namespace App\Services\Video;

use App\Support\VideoStorage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class VideoStreamService
{
    /**
     * Stream video with byte-range support (required for 500MB+ seek in HTML5 player).
     */
    public function stream(string $folder, ?string $fileName): BinaryFileResponse
    {
        if (! VideoStorage::allowedFolder($folder)) {
            abort(404);
        }

        $fileName = normalizeStoredFilename($fileName) ?? basename((string) $fileName);

        if ($fileName === '' || ! VideoStorage::exists($folder, $fileName)) {
            abort(404);
        }

        $absolutePath = VideoStorage::absolutePath($folder, $fileName);

        if (! is_file($absolutePath)) {
            abort(404);
        }

        $response = new BinaryFileResponse($absolutePath);
        $response->setContentDisposition(
            ResponseHeaderBag::DISPOSITION_INLINE,
            basename($fileName)
        );
        $response->headers->set('Content-Type', VideoStorage::mimeType($folder, $fileName));
        $response->headers->set('Accept-Ranges', 'bytes');
        $response->headers->set('Cache-Control', 'private, no-cache');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->setAutoEtag();
        $response->setAutoLastModified();

        return $response;
    }
}
