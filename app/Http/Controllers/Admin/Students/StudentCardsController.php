<?php

namespace App\Http\Controllers\Admin\Students;

use App\Http\Controllers\Concerns\PaginatesAdminTables;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Student\CreateStudentsCardsRequest;
use App\Jobs\CreateStudentCardsJob;
use App\Models\Student;
use App\Support\StudentCardFiles;
use App\Support\StudentCardQueue;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class StudentCardsController extends Controller
{
    use PaginatesAdminTables;

    public function download(string $batch, StudentCardFiles $files): BinaryFileResponse
    {
        $zip = $files->latestReadyZip($batch);

        if (! $zip) {
            abort(404, "No ZIP found for batch {$batch}.");
        }

        return response()->download(
            $zip,
            basename($zip),
            [
                'Content-Type' => 'application/zip',
                'Content-Disposition' => 'attachment; filename="'.basename($zip).'"',
                'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
                'Pragma' => 'no-cache',
            ]
        )->deleteFileAfterSend(false);
    }

    public function index(Route $route, Request $request, StudentCardFiles $files): View
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
                'view' => false,
                'edit' => false,
                'download' => (bool) $files->latestReadyZip($model->batch),
                'awaitDownload' => true,
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
        $adminId = (int) auth('admin')->id();
        $count = (int) $request->count;
        $title = (string) $request->title;
        $academicYear = (string) $request->academic_year;
        $classroom = (string) $request->classroom;

        $batch = Cache::lock('student-cards-next-batch', 15)->block(10, function () use ($count, $title, $academicYear, $classroom, $adminId) {
            $batch = (int) (Student::max('batch') ?? 0) + 1;

            StudentCardQueue::dispatchAndWork(new CreateStudentCardsJob(
                $count,
                $title,
                $academicYear,
                $classroom,
                $batch,
                $adminId,
            ));

            return $batch;
        });

        return redirect()
            ->route('admin.students.studentCards.index')
            ->with('success', 'سيتم إشعارك بعد تجهيز ملف التحميل.');
    }

    public function delete($batch, StudentCardFiles $files): RedirectResponse
    {
        $studentIds = DB::table('students')->where('batch', $batch)->pluck('id');
        $hasDependentData = DB::table('exam_students')->whereIn('student_id', $studentIds)->exists()
            || DB::table('student_attendances')->whereIn('student_id', $studentIds)->exists()
            || DB::table('views')->whereIn('student_id', $studentIds)->exists()
            || DB::table('website_reviews')->whereIn('student_id', $studentIds)->exists();

        if ($hasDependentData) {
            return redirect()->back()->with(
                'error',
                'لا يمكن حذف الباتش لأن بعض الطلاب لديهم امتحانات أو حضور أو مشاهدات أو آراء مسجلة.'
            );
        }

        $files->purgeOldBatchFiles($batch);
        DB::table('students')->where('batch', $batch)->delete();

        return redirect()
            ->route('admin.students.studentCards.index')
            ->with('success', 'تم حذف الكروت بنجاح');
    }

    public function zipStatus(Request $request, StudentCardFiles $files): \Illuminate\Http\JsonResponse
    {
        $batches = array_filter(array_map('strval', (array) $request->input('batches', [])));
        $ready = [];

        foreach ($batches as $batch) {
            if ($files->latestReadyZip($batch)) {
                $ready[] = $batch;
            }
        }

        return response()->json(['ready' => $ready]);
    }
}
