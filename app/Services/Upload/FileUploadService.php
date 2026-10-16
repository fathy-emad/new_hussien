<?php

namespace App\Services\Upload;

use Illuminate\Http\Request;

class FileUploadService
{
    public function __construct(
        private readonly UploadPathResolver $pathResolver,
        private readonly PublicFileUploadService $publicFileUpload,
    ) {}

    public function upload(Request $request): array
    {
        $target = $this->pathResolver->resolve($request->header('STORE-PATH'));

        return $this->publicFileUpload->handle($request, $target);
    }

    public function remove(string $storePath, string $fileName): void
    {
        $fileName = basename($fileName);

        if ($fileName === '') {
            return;
        }

        $target = $this->pathResolver->resolve($storePath);
        $this->publicFileUpload->remove($target, $fileName);
    }
}
