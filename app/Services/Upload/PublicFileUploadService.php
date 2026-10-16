<?php

namespace App\Services\Upload;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PublicFileUploadService
{
    public function handle(Request $request, UploadTarget $target): array
    {
        /** @var UploadedFile|null $file */
        $file = $request->file('dzFiles');

        if (! $file || ! $file->isValid()) {
            throw new \InvalidArgumentException('لم يتم استلام الملف.');
        }

        $extension = strtolower($file->getClientOriginalExtension() ?: $file->extension() ?: 'bin');
        $fileName = time().'_'.Str::random(10).'.'.$extension;

        $disk = Storage::disk($target->disk);
        $disk->makeDirectory($target->folder);
        $disk->putFileAs($target->folder, $file, $fileName);

        return ['fileName' => $fileName];
    }

    public function remove(UploadTarget $target, string $fileName): void
    {
        $fileName = basename($fileName);
        $path = $target->folder.'/'.$fileName;

        if (Storage::disk($target->disk)->exists($path)) {
            Storage::disk($target->disk)->delete($path);
        }
    }
}
