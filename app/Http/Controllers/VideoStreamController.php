<?php

namespace App\Http\Controllers;

use App\Models\Capacitor;
use App\Models\CapacitorCard;
use App\Models\Lesson;
use App\Models\View;
use App\Support\CapacitorOfflineAccess;
use App\Services\Video\VideoStreamService;
use App\Support\VideoStorage;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class VideoStreamController extends Controller
{
    public function __construct(
        private readonly VideoStreamService $videoStreamService,
    ) {}

    /** Student lesson video — checks watch window and view count */
    public function lesson(int $id): BinaryFileResponse
    {
        $student = auth()->guard('student')->user();
        $lesson = Lesson::findOrFail($id);

        $fileName = normalizeStoredFilename($lesson->link);

        if (! $fileName || ! VideoStorage::exists(VideoStorage::FOLDER_LESSONS, $fileName)) {
            abort(404);
        }

        $studentViews = View::where('student_id', $student->id)
            ->where('lesson_id', $lesson->id)
            ->first();

        $viewCount = $studentViews ? (int) $studentViews->times : 0;
        $maxViews = (int) ($lesson->watchTimes ?? 0);
        $opened = $viewCount <= $maxViews;

        if (! $opened) {
            abort(403);
        }

        return $this->videoStreamService->stream(VideoStorage::FOLDER_LESSONS, $fileName);
    }

    /** Capacitor lesson video — requires valid card code */
    public function capacitor(Request $request, int $id): BinaryFileResponse
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        $lesson = Capacitor::findOrFail($id);
        $code = CapacitorCard::where('code', $request->code)->firstOrFail();

        $fileName = normalizeStoredFilename($lesson->link);

        if (! $fileName || ! VideoStorage::exists(VideoStorage::FOLDER_CAPACITORS, $fileName)) {
            abort(404);
        }

        if (! CapacitorOfflineAccess::canWatch($code, $lesson)) {
            abort(403, 'تم استنفاذ عدد مرات المشاهدة');
        }

        CapacitorOfflineAccess::recordView($code, $lesson);

        return $this->videoStreamService->stream(VideoStorage::FOLDER_CAPACITORS, $fileName);
    }

    /** Public website hero videos */
    public function website(string $file): BinaryFileResponse
    {
        return $this->videoStreamService->stream(VideoStorage::FOLDER_WEBSITE, $file);
    }

    /** Admin preview — used by Dropzone edit + lesson view page */
    public function adminPreview(Request $request): BinaryFileResponse
    {
        $request->validate([
            'folder' => 'required|string|in:lessons,capacitors,website',
            'file' => 'required|string',
        ]);

        return $this->videoStreamService->stream($request->folder, $request->file);
    }
}
