<?php

namespace App\Http\Controllers\Admin\Students;

use App\Http\Controllers\Concerns\PaginatesAdminTables;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Student\CreateStudentsCardsRequest;
use App\Jobs\MakeCard;
use App\Jobs\ZipCards;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class StudentCardsController extends Controller
{
    use PaginatesAdminTables;

    public function download(string $batch): BinaryFileResponse
    {
        $dir = public_path('cards');
        $matches = [];

        foreach (glob($dir.DIRECTORY_SEPARATOR."batch_{$batch}_*.zip") ?: [] as $file) {
            $matches[] = $file;
        }

        if (! $matches) {
            abort(404, "No ZIP found for batch {$batch}.");
        }

        usort($matches, fn ($a, $b) => filemtime($b) <=> filemtime($a));

        return response()->download(
            $matches[0],
            basename($matches[0]),
            [
                'Content-Type' => 'application/zip',
                'Content-Disposition' => 'attachment; filename="'.basename($matches[0]).'"',
                'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
                'Pragma' => 'no-cache',
            ]
        )->deleteFileAfterSend(false);
    }

    public function index(Route $route, Request $request): View
    {
        $view = str_replace('/', '.', $route->uri());
        $classRooms = getConstant('classRooms')->getArray();
        $academicYears = getAcademicYears();

        $summaryQuery = Student::query()
            ->select('batch', 'title', 'academic_year', 'classroom')
            ->selectRaw('COUNT(batch) as total')
            ->selectRaw('MIN(created_at) as batch_created_at')
            ->whereNotNull('batch')
            ->groupBy('batch', 'title', 'academic_year', 'classroom');

        $batches = $this->paginateAdminTable(
            DB::query()->fromSub($summaryQuery, 'card_batches')->orderByDesc('batch'),
            $request
        );

        $dataLables = [
            'العنوان',
            'الصف الدراسي',
            'السنة الدراسية',
            'عدد الكروت',
            'وقت الإنشاء',
            'إدارة',
        ];
        $dataRows = [];

        foreach ($batches as $key => $model) {
            $dataRows[$key][] = $model->title;
            $dataRows[$key][] = getConstant('classRooms')->getValue((int) $model->classroom);
            $dataRows[$key][] = $model->academic_year;
            $dataRows[$key][] = $model->total;
            $dataRows[$key][] = $model->batch_created_at
                ? date('d M Y - H:i:s', strtotime($model->batch_created_at))
                : '—';
            $dataRows[$key][] = [
                'id' => $model->batch,
                'delete' => true,
                'view' => true,
                'edit' => false,
                'download' => ! empty(glob(public_path("cards/batch_{$model->batch}_*.zip"))),
                'viewLabel' => 'توليد',
            ];
        }

        return view($view, [
            'dataLables' => $dataLables,
            'dataRows' => $dataRows,
            'batches' => $batches,
            'classRooms' => $classRooms,
            'academicYears' => $academicYears,
        ]);
    }

    public function create(CreateStudentsCardsRequest $request): RedirectResponse
    {
        $total = 0;
        $batch = (Student::max('batch') ?? 0) + 1;
        $createdBy = auth('admin')->user()->id;

        for ($i = 0; $i < $request->count; $i++) {
            $lastRecord = DB::table('students')->orderByDesc('id')->first();
            $code = $request->classroom.'000-'.($lastRecord ? $lastRecord->id + 1 : 1).'-'.$request->academic_year;

            if (Student::where('code', $code)->exists()) {
                continue;
            }

            $created = Student::create([
                'title' => $request->title,
                'code' => $code,
                'batch' => $batch,
                'academic_year' => $request->academic_year,
                'classroom' => $request->classroom,
                'password' => Hash::make($code),
                'created_by' => $createdBy,
            ]);

            if ($created) {
                $total += 1;
            }
        }

        return redirect()
            ->route('admin.students.studentCards.index')
            ->with('success', "تم إنشاء ({$total}) كارت بنجاح — Batch #{$batch}");
    }

    public function delete($batch): RedirectResponse
    {
        $this->purgeOldBatchFiles($batch);
        DB::table('students')->where('batch', $batch)->delete();

        return redirect()
            ->route('admin.students.studentCards.index')
            ->with('success', 'تم حذف الكروت بنجاح');
    }

    public function view(string $batch): RedirectResponse
    {
        if (! class_exists('\DNS1D')) {
            return back()->withErrors(['msg' => 'حزمة milon/barcode غير مثبتة.']);
        }

        if (! class_exists(\Intervention\Image\ImageManager::class)) {
            return back()->withErrors(['msg' => 'حزمة intervention/image غير مثبتة.']);
        }

        if (! Student::where('batch', $batch)->exists()) {
            return back()->withErrors(['msg' => "لا يوجد كروت في Batch {$batch}."]);
        }

        $template = public_path('assets/images/back-card.png');
        if (! is_file($template)) {
            return back()->withErrors(['msg' => "قالب الكارت غير موجود: {$template}"]);
        }

        File::ensureDirectoryExists(public_path('cards'));

        $this->purgeOldBatchFiles($batch);

        $stamp = now()->format('Ymd_His');
        $cardsDir = storage_path("app/tmp/cards/batch_{$batch}_{$stamp}");
        $zipName = "batch_{$batch}_{$stamp}.zip";
        $publicZip = public_path("cards/{$zipName}");
        $zipUrl = asset("cards/{$zipName}");

        File::ensureDirectoryExists($cardsDir);

        $fontPath = public_path('fonts/Inter-Bold.ttf');
        if (! is_file($fontPath)) {
            $fontPath = null;
        }

        set_time_limit(0);

        $generated = 0;
        Student::where('batch', $batch)
            ->select('id')
            ->orderBy('id')
            ->chunkById(500, function ($chunk) use ($template, $cardsDir, $fontPath, &$generated) {
                foreach ($chunk as $row) {
                    (new MakeCard($row->id, $template, $cardsDir, $fontPath))->handle();
                    $generated++;
                }
            });

        if ($generated === 0) {
            return back()->withErrors(['msg' => "لا يوجد كروت في Batch {$batch}."]);
        }

        (new ZipCards($cardsDir, $publicZip))->handle();

        if (! is_file($publicZip)) {
            return back()->withErrors(['msg' => 'فشل إنشاء ملف التحميل.']);
        }

        return back()
            ->with('success', "تم توليد ({$generated}) كارت بنجاح.")
            ->with('success_url', $zipUrl);
    }

    private function purgeOldBatchFiles(string|int $batch): void
    {
        foreach (glob(public_path("cards/batch_{$batch}_*.zip")) ?: [] as $zip) {
            @unlink($zip);
        }

        foreach (glob(storage_path("app/tmp/cards/batch_{$batch}_*"), GLOB_ONLYDIR) ?: [] as $dir) {
            $this->rrmdir($dir);
        }
    }

    private function rrmdir(string $dir): void
    {
        if (! is_dir($dir)) {
            return;
        }

        $it = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($dir, \FilesystemIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::CHILD_FIRST
        );

        foreach ($it as $fs) {
            $path = $fs->getPathname();
            $fs->isDir() ? @rmdir($path) : @unlink($path);
        }

        @rmdir($dir);
    }
}
