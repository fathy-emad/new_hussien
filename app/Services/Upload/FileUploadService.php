<?php

namespace App\Services\Upload;

use Illuminate\Http\Request;

class FileUploadService
{
    public function __construct(
        private readonly UploadPathResolver $pathResolver,
        private readonly ChunkedVideoUploadService $chunkedVideoUpload,
        private readonly PublicFileUploadService $publicFileUpload,
    ) {}

    public function upload(Request $request): array
    {
        if (function_exists('set_time_limit')) {
            @set_time_limit((int) config('upload.chunk_time_limit', 600));
        }

        $target = $this->pathResolver->resolve($request->header('STORE-PATH'));

        if ($request->has('dzchunkindex')) {
            $result = $this->chunkedVideoUpload->handle($request, $target);

            if (! empty($result['merged'])) {
                if ($target->folder === 'lessons') {
                    session(['admin_pending_lesson_video' => $result['fileName']]);
                } elseif ($target->folder === 'capacitors') {
                    session(['admin_pending_capacitor_video' => $result['fileName']]);
                }
            }

            return $result;
        }

        return $this->publicFileUpload->handle($request, $target);
    }

    public function remove(string $storePath, string $fileName): void
    {
        $fileName = basename($fileName);

        if ($fileName === '') {
            return;
        }

        $target = $this->pathResolver->resolve($storePath);

        if ($target->isVideo()) {
            $this->chunkedVideoUpload->remove($target, $fileName);
        } else {
            $this->publicFileUpload->remove($target, $fileName);
        }
    }
}
