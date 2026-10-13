<?php

namespace App\Http\Controllers;

use App\Services\Video\VideoStreamService;
use App\Support\VideoStorage;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class VideoStreamController extends Controller
{
    public function __construct(
        private readonly VideoStreamService $videoStreamService,
    ) {}

    /** Public website hero videos */
    public function website(string $file): BinaryFileResponse
    {
        return $this->videoStreamService->stream(VideoStorage::FOLDER_WEBSITE, $file);
    }

    /** Admin preview — website videos only */
    public function adminPreview(Request $request): BinaryFileResponse
    {
        $request->validate([
            'folder' => 'required|string|in:website',
            'file' => 'required|string',
        ]);

        return $this->videoStreamService->stream($request->folder, $request->file);
    }
}
