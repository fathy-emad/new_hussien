<?php

namespace App\Http\Controllers;

use App\Services\Upload\FileUploadService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\File\Exception\IniSizeFileException;

class FilesUpload
{
    public function __construct(
        private readonly FileUploadService $fileUploadService,
    ) {}

    public function fileUpload(Request $request): JsonResponse
    {
        try {
            $result = $this->fileUploadService->upload($request);

            return response()->json($result);
        } catch (IniSizeFileException) {
            return response()->json([
                'message' => 'حجم جزء الرفع أكبر من حد PHP (upload_max_filesize). استخدم serve.bat أو ارفع upload_max_filesize في php.ini.',
            ], 413);
        } catch (\InvalidArgumentException $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        } catch (\RuntimeException $e) {
            report($e);

            return response()->json([
                'message' => 'فشل دمج ملف الفيديو. أعد المحاولة.',
            ], 500);
        }
    }

    public function removeFileUploaded(Request $request): JsonResponse
    {
        $fileName = basename((string) $request->fileName);
        $path = (string) $request->header('STORE-PATH');

        $this->fileUploadService->remove($path, $fileName);

        return response()->json(['success' => true]);
    }
}
