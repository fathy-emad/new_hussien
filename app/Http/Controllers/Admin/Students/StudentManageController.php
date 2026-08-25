<?php

namespace App\Http\Controllers\Admin\Students;

use App\Http\Controllers\Concerns\PaginatesAdminTables;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Student\CreateEditStudentManageRequest;
use App\Models\Center;
use App\Models\Exam;
use App\Models\ExamStudent;
use App\Models\Student;
use App\Models\StudentAttendance;
use App\Support\ExamStudentScoring;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class StudentManageController extends Controller
{
    use PaginatesAdminTables;

    public function view($id): View
    {
        $tz = 'Africa/Cairo';

        $student = Student::with('center')->findOrFail($id);

        $attendances = StudentAttendance::with('center')
            ->where('student_id', $student->id)
            ->orderByDesc('created_at')
            ->get()
            ->map(function ($a) use ($tz) {
                $a->created_at_eg = $a->created_at?->copy()->timezone($tz);
                $a->created_label = $a->created_at_eg?->format('d M Y - H:i:s');
                $a->month_key = $a->created_at_eg?->format('Y-m');

                return $a;
            });

        $monthBlocks = $attendances
            ->groupBy('month_key')
            ->sortKeysDesc()
            ->map(function ($items, $ym) {
                $first = $items->first();

                return [
                    'label' => $first->created_at_eg?->format('n / Y'),
                    'items' => $items,
                ];
            });

        $exams = Exam::where('classroom', $student->classroom)
            ->orderByDesc('day')
            ->get();

        $examStudents = ExamStudent::where('student_id', $student->id)
            ->whereIn('exam_id', $exams->pluck('id'))
            ->get()
            ->keyBy('exam_id');

        $examRows = $exams->map(function (Exam $exam) use ($examStudents) {
            $examStudent = $examStudents->get($exam->id);

            $status = ExamStudentScoring::resolveStatus($examStudent, $exam);

            $row = [
                'exam_id' => $exam->id,
                'title' => $exam->title,
                'day' => $exam->day?->format('d M Y'),
                'time' => $exam->time,
                'status' => $status,
                'status_label' => ExamStudentScoring::statusLabel($status),
                'status_badge' => ExamStudentScoring::statusBadgeClass($status),
                'degree_label' => 'لم يحضر',
                'percentage' => null,
                'visited_at' => null,
                'result_url' => null,
            ];

            if ($examStudent && ! empty($examStudent->questionsAnswers)) {
                $score = ExamStudentScoring::score($examStudent);
                $row['degree_label'] = $score['degree_label'];
                $row['percentage'] = $score['percentage'];
                $row['visited_at'] = $examStudent->visited?->format('d M Y - H:i:s');
                $row['result_url'] = route('admin.exams.result.view', $examStudent->id);
            }

            return $row;
        });

        return view('admin.students.studentManage.view', [
            'student' => $student,
            'monthBlocks' => $monthBlocks,
            'examRows' => $examRows,
            'classRooms' => getConstant('classRooms')->getArray(),
            'genders' => getConstant('genders')->getArray(),
            'searchParams' => $this->searchParamsFromStudent($student),
        ]);
    }

    public function index(Route $route, Request $request): View
    {
        $view = str_replace('/', '.', $route->uri());
        $classRooms = getConstant('classRooms')->getArray();
        $academicYears = getAcademicYears();
        $centers = Center::orderBy('title')->get();

        $searchParams = [
            'classroom' => $request->input('classroom'),
            'academic_year' => $request->input('academic_year'),
            'center_id' => $request->input('center_id'),
            'keyword' => trim((string) $request->input('keyword', '')),
        ];

        $hasSearch = $request->filled('academic_year')
            && $request->filled('classroom')
            && $request->filled('center_id');

        $data = [
            'classRooms' => $classRooms,
            'academicYears' => $academicYears,
            'centers' => $centers,
            'searchParams' => $searchParams,
            'hasSearch' => $hasSearch,
            'dataLables' => [],
            'dataRows' => [],
            'students' => null,
        ];

        if ($hasSearch) {
            $query = Student::with(['center', 'createdBy', 'updatedBy'])
                ->where('classroom', $searchParams['classroom'])
                ->where('academic_year', $searchParams['academic_year']);

            if ($searchParams['center_id'] === 'none') {
                $query->whereNull('center_id');
            } else {
                $query->where('center_id', $searchParams['center_id']);
            }

            if ($searchParams['keyword'] !== '') {
                $keyword = $searchParams['keyword'];
                $query->where(function ($builder) use ($keyword) {
                    $builder->where('name', 'like', '%'.$keyword.'%')
                        ->orWhere('code', 'like', '%'.$keyword.'%')
                        ->orWhere('phone', 'like', '%'.$keyword.'%');
                });
            }

            $students = $this->paginateAdminTable(
                $query->orderBy('name'),
                $request
            );

            $dataLables = [
                'الكود',
                'الاسم',
                'رقم الموبايل',
                'رقم ولى الامر',
                'وقت الإنشاء',
                'أنشئ بواسطة',
                'وقت التحديث',
                'حدث بواسطة',
                'إدارة',
            ];
            $dataRows = [];

            foreach ($students as $key => $student) {
                $dataRows[$key][] = $student->code;
                $dataRows[$key][] = $student->name;
                $dataRows[$key][] = $student->phone;
                $dataRows[$key][] = $student->father_phone;
                $dataRows[$key][] = $student->created_at
                    ? $student->created_at->format('d M Y - H:i:s')
                    : '—';
                $dataRows[$key][] = $student->createdBy->name ?? '—';
                $dataRows[$key][] = $student->updated_at
                    ? $student->updated_at->format('d M Y - H:i:s')
                    : '—';
                $dataRows[$key][] = $student->updatedBy->name ?? '—';
                $dataRows[$key][] = [
                    'id' => $student->id,
                    'delete' => true,
                    'view' => true,
                    'edit' => true,
                ];
            }

            $data['students'] = $students;
            $data['dataLables'] = $dataLables;
            $data['dataRows'] = $dataRows;
        }

        return view($view, $data);
    }

    public function showCreate(Request $request): View
    {
        return view('admin.students.studentManage.create', [
            'centers' => Center::orderBy('title')->get(),
            'classRooms' => getConstant('classRooms')->getArray(),
            'academicYears' => getAcademicYears(),
            'genders' => getConstant('genders')->getArray(),
            'searchParams' => [
                'classroom' => $request->input('classroom'),
                'academic_year' => $request->input('academic_year'),
                'center_id' => $request->input('center_id'),
            ],
        ]);
    }

    public function create(CreateEditStudentManageRequest $request): RedirectResponse
    {
        $lastRecord = DB::table('students')->orderByDesc('id')->first();

        $student = new Student;
        $student->center_id = $request->center_id;
        $student->gender = $request->gender;
        $student->academic_year = $request->academic_year;
        $student->classroom = $request->classroom;
        $student->name = $request->name;
        $student->phone = $request->phone;
        $student->email = $request->email;
        $student->whatsApp = $request->whatsApp;
        $student->father_phone = $request->father_phone;
        $student->password = $request->password;
        $student->avatar = resolveUploadedFilename($request->avatar) ?? '';
        $student->material_one = $request->material_one ?? 0;
        $student->material_two = $request->material_two ?? 0;
        $student->material_three = $request->material_three ?? 0;
        $student->material_four = $request->material_four ?? 0;
        $student->created_by = Auth::guard('admin')->user()->id;
        $student->updated_at = null;

        $code = $request->classroom.'000-'.($lastRecord ? $lastRecord->id + 1 : 1).'-'.$request->academic_year;
        $student->code = $code;
        $student->save();

        return redirect()->route('admin.students.studentManage.index', [
            'academic_year' => $request->academic_year,
            'classroom' => $request->classroom,
            'center_id' => $request->center_id,
        ])->with('success', 'تم إنشاء طالب بنجاح — '.$code);
    }

    public function edit($id): View
    {
        $student = Student::with('center')->findOrFail($id);
        $avatar = [];
        $avatarFile = normalizeStoredFilename($student->avatar);
        $file = $avatarFile ? public_path('uploads/students/images/'.$avatarFile) : null;

        if ($file && is_file($file)) {
            $avatar[] = [
                'file' => asset('uploads/students/images/'.$avatarFile),
                'name' => $avatarFile,
                'size' => filesize($file),
                'type' => mime_content_type($file),
            ];
        }

        return view('admin.students.studentManage.edit', [
            'student' => $student,
            'centers' => Center::orderBy('title')->get(),
            'classRooms' => getConstant('classRooms')->getArray(),
            'academicYears' => getAcademicYears(),
            'genders' => getConstant('genders')->getArray(),
            'searchParams' => $this->searchParamsFromStudent($student),
            'attachments' => ['avatar' => $avatar],
        ]);
    }

    public function update(CreateEditStudentManageRequest $request, $id): RedirectResponse
    {
        $student = Student::findOrFail($id);
        $created_at = $student->created_at;

        $student->center_id = $request->center_id;
        $student->gender = $request->gender;
        $student->academic_year = $request->academic_year;
        $student->classroom = $request->classroom;
        $student->name = $request->name;
        $student->phone = $request->phone;
        $student->email = $request->email;
        $student->whatsApp = $request->whatsApp;
        $student->father_phone = $request->father_phone;
        $student->material_one = $request->material_one ?? 0;
        $student->material_two = $request->material_two ?? 0;
        $student->material_three = $request->material_three ?? 0;
        $student->material_four = $request->material_four ?? 0;

        $avatar = resolveUploadedFilename($request->avatar);
        if ($avatar !== null) {
            $student->avatar = $avatar;
        }

        if ($request->filled('password')) {
            $student->password = $request->password;
        }

        $student->updated_by = Auth::guard('admin')->user()->id;
        $student->created_at = $created_at;
        $student->save();

        return redirect()->route('admin.students.studentManage.index', [
            'academic_year' => $request->academic_year,
            'classroom' => $request->classroom,
            'center_id' => $request->center_id,
        ])->with('success', __('validation.update.success'));
    }

    public function delete($id): RedirectResponse
    {
        $student = Student::findOrFail($id);
        $searchParams = $this->searchParamsFromStudent($student);

        DB::transaction(function () use ($student) {
            DB::table('exam_students')->where('student_id', $student->id)->delete();
            DB::table('student_attendances')->where('student_id', $student->id)->delete();
            DB::table('views')->where('student_id', $student->id)->delete();
            DB::table('website_reviews')->where('student_id', $student->id)->delete();
            $student->delete();
        });

        return redirect()->route('admin.students.studentManage.index', $searchParams)
            ->with('success', 'تم حذف الطالب وبياناته التابعة بنجاح');
    }

    private function searchParamsFromStudent(Student $student): array
    {
        return [
            'classroom' => $student->classroom,
            'academic_year' => $student->academic_year,
            'center_id' => $student->center_id ?? 'none',
        ];
    }
}
