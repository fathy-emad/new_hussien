<?php

namespace App\Services\Upload;

class UploadPathResolver
{
    public function resolve(?string $storePath): UploadTarget
    {
        $storePath = trim(str_replace('\\', '/', (string) $storePath), '/');

        if ($storePath === '') {
            throw new \InvalidArgumentException('مسار التخزين غير محدد (STORE-PATH).');
        }

        $paths = config('upload.paths', []);

        if (! isset($paths[$storePath])) {
            throw new \InvalidArgumentException('مسار التخزين غير مسموح.');
        }

        $config = $paths[$storePath];

        return new UploadTarget(
            storePath: $storePath,
            type: $config['type'],
            disk: $config['disk'],
            folder: $config['folder'],
        );
    }
}
