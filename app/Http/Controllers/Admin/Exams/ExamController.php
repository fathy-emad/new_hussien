<?php

namespace App\Http\Controllers\Admin\Exams;

use App\Http\Controllers\Concerns\PaginatesAdminTables;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Exams\CreateEditExamRequest;
use App\Models\BankQuestion;
use App\Models\Exam;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ExamController extends Controller
{
    use PaginatesAdminTables;

    public function view($id): View
    {
        $exam = Exam::findOrFail($id);
        $classRooms = getConstant('classRooms')->getArray();
        $bankQuestions = BankQuestion::whereIn('id', $exam->questions ?? [])->get()->keyBy('id');

        return view('admin.exams.exam.view', [
            'exam' => $exam,
            'classRooms' => $classRooms,
            'searchParams' => ['classroom' => $exam->classroom],
            'bankQuestions' => $bankQuestions,
        ]);
    }

    public function index(Route $route, Request $request): View
    {
        $view = str_replace('/', '.', $route->uri());
        $classRooms = getConstant('classRooms')->getArray();
        $searchParams = ['classroom' => $request->classroom];

        if (empty($request->classroom)) {
            return view($view, [
                'classRooms' => $classRooms,
                'searchParams' => [],
                'hasSearch' => false,
            ]);
        }

        $exams = $this->paginateAdminTable(
            Exam::query()
                ->with(['createdBy', 'updatedBy'])
                ->where('classroom', $request->classroom)
                ->orderByDesc('day')
                ->orderByDesc('id'),
            $request
        );

        $dataLables = [
            'العنوان',
            'اليوم',
            'الوقت (دقيقة)',
            'عدد الأسئلة',
            'وقت الإنشاء',
            'إنشاء بواسطة',
            'وقت التحديث',
            'حدث بواسطة',
            'إدارة',
        ];
        $dataRows = [];

        foreach ($exams as $key => $exam) {
            $dataRows[$key][] = $exam->title;
            $dataRows[$key][] = $exam->day ? $exam->day->format('d M Y') : '—';
            $dataRows[$key][] = $exam->time;
            $dataRows[$key][] = is_array($exam->questions) ? count($exam->questions) : 0;
            $dataRows[$key][] = $exam->created_at ? $exam->created_at->format('d M Y - H:i:s') : '—';
            $dataRows[$key][] = $exam->createdBy->name ?? '—';
            $dataRows[$key][] = $exam->updated_at ? $exam->updated_at->format('d M Y - H:i:s') : '—';
            $dataRows[$key][] = $exam->updatedBy->name ?? '—';
            $dataRows[$key][] = [
                'id' => $exam->id,
                'delete' => true,
                'view' => true,
                'edit' => true,
            ];
        }

        return view($view, [
            'dataLables' => $dataLables,
            'dataRows' => $dataRows,
            'exams' => $exams,
            'classRooms' => $classRooms,
            'searchParams' => $searchParams,
            'hasSearch' => true,
        ]);
    }

    public function showCreate(Request $request): View
    {
        $classroom = $request->classroom;
        $bankQuestions = $classroom
            ? BankQuestion::where('classroom', $classroom)->orderByDesc('id')->get()
            : collect();

        return view('admin.exams.exam.create', [
            'classRooms' => getConstant('classRooms')->getArray(),
            'searchParams' => ['classroom' => $classroom],
            'bankQuestions' => $bankQuestions,
        ]);
    }

    public function create(CreateEditExamRequest $request): RedirectResponse
    {
        $model = new Exam;
        $model->classroom = $request->classroom;
        $model->title = $request->title;
        $model->day = Carbon::parse($request->day)->startOfDay();
        $model->time = $request->time;
        $model->questions = array_values($request->questions);
        $model->created_by = Auth::guard('admin')->user()->id;
        $model->updated_at = null;
        $model->save();

        return redirect()
            ->route('admin.exams.exam.index', ['classroom' => $request->classroom])
            ->with('success', 'تم إنشاء الامتحان بنجاح');
    }

    public function edit($id): View
    {
        $exam = Exam::findOrFail($id);
        $bankQuestions = BankQuestion::where('classroom', $exam->classroom)->orderByDesc('id')->get();

        return view('admin.exams.exam.edit', [
            'exam' => $exam,
            'classRooms' => getConstant('classRooms')->getArray(),
            'searchParams' => ['classroom' => $exam->classroom],
            'bankQuestions' => $bankQuestions,
        ]);
    }

    public function update(CreateEditExamRequest $request, $id): RedirectResponse
    {
        $model = Exam::findOrFail($id);
        $created_at = $model->created_at;
        $model->classroom = $request->classroom;
        $model->title = $request->title;
        $model->day = Carbon::parse($request->day)->startOfDay();
        $model->time = $request->time;
        $model->questions = array_values($request->questions);
        $model->updated_by = Auth::guard('admin')->user()->id;
        $model->created_at = $created_at;
        $model->save();

        return redirect()
            ->route('admin.exams.exam.index', ['classroom' => $model->classroom])
            ->with('success', 'تم تعديل الامتحان بنجاح');
    }

    public function delete($id): RedirectResponse
    {
        $model = Exam::findOrFail($id);
        $classroom = $model->classroom;
        $model->delete();

        return redirect()
            ->route('admin.exams.exam.index', ['classroom' => $classroom])
            ->with('success', 'تم حذف الامتحان بنجاح');
    }
}
