<?php

namespace App\Services\Upload;

readonly class UploadTarget
{
    public function __construct(
        public string $storePath,
        public string $type,
        public string $disk,
        public string $folder,
    ) {}

    public function isVideo(): bool
    {
        return $this->type === 'video';
    }
}
