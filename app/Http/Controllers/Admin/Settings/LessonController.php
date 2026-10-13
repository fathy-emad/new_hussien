<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Concerns\PaginatesAdminTables;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Settings\CreateEditLessonRequest;
use App\Models\Chapter;
use App\Models\Lesson;
use App\Support\LessonAttachments;
use App\Support\VideoStorage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class LessonController extends Controller
{
    use PaginatesAdminTables;

    public function view($id): View
    {
        $lesson = Lesson::with('chapter')->findOrFail($id);
        $videoFile = normalizeStoredFilename($lesson->link);
        $hasVideo = $videoFile && (
            VideoStorage::exists(VideoStorage::FOLDER_LESSONS, $videoFile)
            || is_file(VideoStorage::absolutePath(VideoStorage::FOLDER_LESSONS, $videoFile))
        );

        return view('admin.settings.lesson.view', [
            'lesson' => $lesson,
            'videoFile' => $videoFile,
            'hasVideo' => $hasVideo,
            'videoUrl' => $hasVideo
                ? VideoStorage::adminPreviewUrl(VideoStorage::FOLDER_LESSONS, $videoFile)
                : null,
            'videoSizeMb' => $hasVideo
                ? round(VideoStorage::size(VideoStorage::FOLDER_LESSONS, $videoFile) / (1024 * 1024), 1)
                : null,
            'attachments' => LessonAttachments::forLesson($lesson),
            'searchParams' => [
                'chapter_id' => $lesson->chapter_id,
                'classroom' => $lesson->chapter?->classroom,
            ],
        ]);
    }

    public function index(Route $route, Request $request): View
    {
        $view = str_replace('/', '.', $route->uri());
        $classRooms = getConstant('classRooms')->getArray();
        $chaptersByClassroom = Chapter::orderBy('chapterNo')
            ->get()
            ->groupBy(fn ($chapter) => (string) $chapter->classroom)
            ->map(fn ($group) => $group->map(fn ($chapter) => [
                'id' => $chapter->id,
                'label' => $chapter->title.' ('.$chapter->academic_year.')',
            ])->values());

        $searchParams = [
            'classroom' => $request->input('classroom'),
            'chapter_id' => $request->input('chapter_id'),
        ];
        $hasSearch = $request->filled('chapter_id');
        $chapter = null;

        $data = [
            'classRooms' => $classRooms,
            'chaptersByClassroom' => $chaptersByClassroom,
            'searchParams' => $searchParams,
            'hasSearch' => $hasSearch,
            'chapter' => null,
            'dataLables' => [],
            'dataRows' => [],
            'lessons' => null,
        ];

        if ($hasSearch) {
            $chapter = Chapter::with(['createdBy', 'updatedBy'])->findOrFail($request->chapter_id);
            $searchParams['classroom'] = $searchParams['classroom'] ?? $chapter->classroom;
            $data['searchParams'] = $searchParams;
            $data['chapter'] = $chapter;

            $lessons = $this->paginateAdminTable(
                Lesson::with(['createdBy', 'updatedBy'])
                    ->where('chapter_id', $chapter->id)
                    ->orderBy('NO'),
                $request
            );

            $dataLables = [
                'رقم الدرس',
                'اسم الدرس',
                'عدد مرات المشاهدة',
                'وقت الإنشاء',
                'أنشئ بواسطة',
                'وقت التحديث',
                'حدث بواسطة',
                'إدارة',
            ];
            $dataRows = [];

            foreach ($lessons as $key => $lesson) {
                $dataRows[$key][] = $lesson->NO;
                $dataRows[$key][] = $lesson->title;
                $dataRows[$key][] = $lesson->watchTimes ?? 0;
                $dataRows[$key][] = $lesson->created_at
                    ? $lesson->created_at->format('d M Y - H:i:s')
                    : 'لا يوجد';
                $dataRows[$key][] = $lesson->createdBy->name ?? 'لا يوجد';
                $dataRows[$key][] = $lesson->updated_at
                    ? $lesson->updated_at->format('d M Y - H:i:s')
                    : 'لا يوجد';
                $dataRows[$key][] = $lesson->updatedBy->name ?? 'لا يوجد';
                $dataRows[$key][] = [
                    'id' => $lesson->id,
                    'delete' => true,
                    'view' => true,
                    'edit' => true,
                ];
            }

            $data['lessons'] = $lessons;
            $data['dataLables'] = $dataLables;
            $data['dataRows'] = $dataRows;
        }

        return view($view, $data);
    }

    public function showCreate(Request $request): View
    {
        $chapter = $request->filled('chapter_id')
            ? Chapter::findOrFail($request->chapter_id)
            : null;

        return view('admin.settings.lesson.create', [
            'chapter' => $chapter,
            'classRooms' => getConstant('classRooms')->getArray(),
            'searchParams' => [
                'classroom' => $request->input('classroom', $chapter?->classroom),
                'chapter_id' => $request->input('chapter_id', $chapter?->id),
            ],
        ]);
    }

    public function create(CreateEditLessonRequest $request): RedirectResponse
    {
        $lesson = new Lesson;
        $lesson->title = $request->title;
        $lesson->chapter_id = $request->chapter_id;
        $lesson->link = $this->resolveLessonVideoLink($request);

        if ($lesson->link === '' && $this->submittedLinkLooksLikeVideo($request)) {
            throw ValidationException::withMessages([
                'link' => 'ملف الفيديو غير موجود على السيرفر. أعد رفع الفيديو ثم احفظ.',
            ]);
        }

        $lesson->NO = $request->NO;
        $lesson->watchTimes = $request->watchTimes ?? 0;
        $lesson->info = $request->info;
        $lesson->images = $this->resolveLessonCommaSeparatedFiles($request->images ?? [], 'lessons/images', 'images');
        $lesson->pdf = $this->resolveLessonCommaSeparatedFiles($request->pdf ?? [], 'lessons/files', 'pdf');
        $lesson->created_by = Auth::guard('admin')->user()->id;
        $lesson->updated_at = null;
        $lesson->save();

        $chapter = Chapter::find($request->chapter_id);

        $success = 'تم إنشاء الدرس بنجاح';
        if ($lesson->link !== '') {
            $success .= ' — تم حفظ الفيديو: '.$lesson->link;
        }

        return redirect()->route('admin.settings.lesson.index', [
            'chapter_id' => $request->chapter_id,
            'classroom' => $chapter?->classroom,
        ])->with('success', $success);
    }

    public function edit($id): View
    {
        $lesson = Lesson::with('chapter')->findOrFail($id);

        return view('admin.settings.lesson.edit', [
            'lesson' => $lesson,
            'chapter' => $lesson->chapter,
            'classRooms' => getConstant('classRooms')->getArray(),
            'searchParams' => [
                'classroom' => $lesson->chapter?->classroom,
                'chapter_id' => $lesson->chapter_id,
            ],
            'attachments' => LessonAttachments::forLesson($lesson, includeVideo: true),
        ]);
    }

    public function update(CreateEditLessonRequest $request, $id): RedirectResponse
    {
        $lesson = Lesson::findOrFail($id);
        $created_at = $lesson->created_at;
        $lesson->title = $request->title;
        $lesson->chapter_id = $request->chapter_id;
        if ($request->has('link')) {
            $submittedLink = trim((string) $request->input('link'));
            $newVideo = $this->resolveLessonVideoLink($request);

            if ($newVideo === '' && $this->submittedLinkLooksLikeVideo($request)) {
                throw ValidationException::withMessages([
                    'link' => 'ملف الفيديو غير موجود على السيرفر. أعد رفع الفيديو ثم احفظ.',
                ]);
            }

            $oldVideo = normalizeStoredFilename($lesson->link);

            if ($oldVideo && $newVideo !== '' && $oldVideo !== $newVideo) {
                VideoStorage::delete(VideoStorage::FOLDER_LESSONS, $oldVideo);
            }

            $lesson->link = $newVideo;
        }
        $lesson->NO = $request->NO;
        $lesson->watchTimes = $request->watchTimes ?? $lesson->watchTimes;
        $lesson->info = $request->info;

        $newImages = $this->resolveLessonCommaSeparatedFiles($request->images ?? [], 'lessons/images', 'images');
        $newPdfs = $this->resolveLessonCommaSeparatedFiles($request->pdf ?? [], 'lessons/files', 'pdf');

        $this->deleteRemovedPublicUploads('lessons/images', $lesson->images, $newImages);
        $this->deleteRemovedPublicUploads('lessons/files', $lesson->pdf, $newPdfs);

        $lesson->images = $newImages;
        $lesson->pdf = $newPdfs;
        $lesson->updated_by = Auth::guard('admin')->user()->id;
        $lesson->created_at = $created_at;
        $lesson->save();

        $chapter = Chapter::find($request->chapter_id);

        $success = 'تم تعديل الدرس بنجاح';
        if ($lesson->link !== '') {
            $success .= ' — الفيديو: '.$lesson->link;
        }

        return redirect()->route('admin.settings.lesson.index', [
            'chapter_id' => $request->chapter_id,
            'classroom' => $chapter?->classroom,
        ])->with('success', $success);
    }

    private function resolveLessonVideoLink(Request $request): string
    {
        $submitted = trim((string) $request->input('link'));

        if ($submitted === '') {
            session()->forget('admin_pending_lesson_video');

            return '';
        }

        $fileName = basename(resolveUploadedFilename($request->input('link')) ?? '');

        if ($fileName !== '' && $this->lessonVideoExistsOnDisk($fileName)) {
            session()->forget('admin_pending_lesson_video');

            return $fileName;
        }

        $pending = session('admin_pending_lesson_video');

        if (is_string($pending) && $pending !== '') {
            $pending = basename($pending);

            if ($this->lessonVideoExistsOnDisk($pending)) {
                session()->forget('admin_pending_lesson_video');

                return $pending;
            }
        }

        return '';
    }

    private function submittedLinkLooksLikeVideo(Request $request): bool
    {
        return trim((string) $request->input('link')) !== '';
    }

    private function lessonVideoExistsOnDisk(string $fileName): bool
    {
        return VideoStorage::exists(VideoStorage::FOLDER_LESSONS, $fileName)
            || is_file(VideoStorage::absolutePath(VideoStorage::FOLDER_LESSONS, $fileName));
    }

    private function resolveLessonCommaSeparatedFiles(mixed $value, string $diskFolder, string $field): string
    {
        $csv = implodeUploadedFilenames($value);

        if ($csv === '') {
            return '';
        }

        foreach (explodeUploadedFilenames($csv) as $fileName) {
            if (! $this->publicUploadExists($diskFolder, $fileName)) {
                throw ValidationException::withMessages([
                    $field => 'بعض الملفات غير موجودة على السيرفر. أعد رفع الملفات ثم احفظ.',
                ]);
            }
        }

        return $csv;
    }

    private function publicUploadExists(string $diskFolder, string $fileName): bool
    {
        $fileName = basename($fileName);

        return Storage::disk('uploads')->exists($diskFolder.'/'.$fileName)
            || is_file(public_path('uploads/'.$diskFolder.'/'.$fileName));
    }

    private function deleteRemovedPublicUploads(string $diskFolder, ?string $oldCsv, string $newCsv): void
    {
        $removed = array_diff(
            explodeUploadedFilenames($oldCsv),
            explodeUploadedFilenames($newCsv)
        );

        foreach ($removed as $fileName) {
            $path = $diskFolder.'/'.$fileName;
            if (Storage::disk('uploads')->exists($path)) {
                Storage::disk('uploads')->delete($path);
            }
        }
    }

    public function resetViews($chapter_id): RedirectResponse
    {
        $chapter = Chapter::findOrFail($chapter_id);
        $chapter->lessons()->update(['watchTimes' => 0]);
        $chapter->views()->delete();

        return redirect()->route('admin.settings.lesson.index', [
            'chapter_id' => $chapter->id,
            'classroom' => $chapter->classroom,
        ])->with('success', 'تم ضبط مصنع المشاهدات لفصل '.$chapter->title.' بنجاح');
    }

    public function delete($id): RedirectResponse
    {
        $lesson = Lesson::with('chapter')->findOrFail($id);
        $searchParams = [
            'chapter_id' => $lesson->chapter_id,
            'classroom' => $lesson->chapter?->classroom,
        ];

        DB::transaction(function () use ($lesson) {
            $lesson->views()->delete();
            $lesson->delete();
        });

        $video = normalizeStoredFilename($lesson->link);
        if ($video) {
            VideoStorage::delete(VideoStorage::FOLDER_LESSONS, $video);
        }

        $this->deleteLessonUploads('lessons/images', explodeUploadedFilenames($lesson->images));
        $this->deleteLessonUploads('lessons/files', explodeUploadedFilenames($lesson->pdf));

        return redirect()
            ->route('admin.settings.lesson.index', $searchParams)
            ->with('success', 'تم حذف الدرس وملفاته المرتبطة بنجاح');
    }

    private function deleteLessonUploads(string $folder, array $files): void
    {
        foreach (array_unique($files) as $fileName) {
            $path = $folder.'/'.basename($fileName);
            if (Storage::disk('uploads')->exists($path)) {
                Storage::disk('uploads')->delete($path);
            }
        }
    }
}
