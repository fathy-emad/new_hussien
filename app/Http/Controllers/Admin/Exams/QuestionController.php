<?php

namespace App\Http\Controllers\Admin\Exams;

use App\Http\Controllers\Concerns\PaginatesAdminTables;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Exams\CreateEditQuestionRequest;
use App\Models\BankQuestion;
use App\Models\Exam;
use App\Models\ExamStudent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class QuestionController extends Controller
{
    use PaginatesAdminTables;

    public function view($id): View
    {
        $question = BankQuestion::findOrFail($id);
        $classRooms = getConstant('classRooms')->getArray();
        $images = $this->questionImages($question);

        return view('admin.exams.question.view', [
            'question' => $question,
            'classRooms' => $classRooms,
            'searchParams' => ['classroom' => $question->classroom],
            'images' => $images,
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

        $questions = $this->paginateAdminTable(
            BankQuestion::query()
                ->with(['createdBy', 'updatedBy'])
                ->where('classroom', $request->classroom)
                ->orderByDesc('id'),
            $request
        );

        $dataLables = [
            'السؤال',
            'عدد الإجابات',
            'وقت الإنشاء',
            'إنشاء بواسطة',
            'وقت التحديث',
            'حدث بواسطة',
            'إدارة',
        ];
        $dataRows = [];

        foreach ($questions as $key => $question) {
            $answers = is_array($question->answers) ? $question->answers : [];
            $dataRows[$key][] = Str::limit($question->question, 80);
            $dataRows[$key][] = count($answers);
            $dataRows[$key][] = $question->created_at ? $question->created_at->format('d M Y - H:i:s') : '—';
            $dataRows[$key][] = $question->createdBy->name ?? '—';
            $dataRows[$key][] = $question->updated_at ? $question->updated_at->format('d M Y - H:i:s') : '—';
            $dataRows[$key][] = $question->updatedBy->name ?? '—';
            $dataRows[$key][] = [
                'id' => $question->id,
                'delete' => true,
                'view' => true,
                'edit' => true,
            ];
        }

        return view($view, [
            'dataLables' => $dataLables,
            'dataRows' => $dataRows,
            'questions' => $questions,
            'classRooms' => $classRooms,
            'searchParams' => $searchParams,
            'hasSearch' => true,
        ]);
    }

    public function showCreate(Request $request): View
    {
        return view('admin.exams.question.create', [
            'classRooms' => getConstant('classRooms')->getArray(),
            'searchParams' => ['classroom' => $request->classroom],
        ]);
    }

    public function create(CreateEditQuestionRequest $request): RedirectResponse
    {
        $model = new BankQuestion;
        $model->classroom = $request->classroom;
        $model->question = $request->question;
        $model->answers = array_values($request->answers);
        $model->correct_answer = (int) $request->correct_answer;
        $model->image = implodeUploadedFilenames($request->image ?? []);
        $model->created_by = Auth::guard('admin')->user()->id;
        $model->updated_at = null;
        $model->save();

        return redirect()
            ->route('admin.exams.question.index', ['classroom' => $request->classroom])
            ->with('success', 'تم إنشاء السؤال بنجاح');
    }

    public function edit($id): View
    {
        $question = BankQuestion::findOrFail($id);
        $images = [];
        foreach (explodeUploadedFilenames($question->image) as $img) {
            $file = public_path("uploads/exams/questions/images/$img");
            if (is_file($file)) {
                $images[] = [
                    'file' => asset("uploads/exams/questions/images/$img"),
                    'name' => $img,
                    'size' => filesize($file),
                    'type' => mime_content_type($file),
                ];
            }
        }

        return view('admin.exams.question.edit', [
            'question' => $question,
            'classRooms' => getConstant('classRooms')->getArray(),
            'searchParams' => ['classroom' => $question->classroom],
            'attachments' => ['image' => $images],
        ]);
    }

    public function update(CreateEditQuestionRequest $request, $id): RedirectResponse
    {
        $model = BankQuestion::findOrFail($id);
        $created_at = $model->created_at;
        $model->classroom = $request->classroom;
        $model->question = $request->question;
        $model->answers = array_values($request->answers);
        $model->correct_answer = (int) $request->correct_answer;
        $model->image = implodeUploadedFilenames($request->image ?? []);
        $model->updated_by = Auth::guard('admin')->user()->id;
        $model->created_at = $created_at;
        $model->save();

        return redirect()
            ->route('admin.exams.question.index', ['classroom' => $model->classroom])
            ->with('success', 'تم تعديل السؤال بنجاح');
    }

    public function delete($id): RedirectResponse
    {
        $question = BankQuestion::findOrFail($id);

        $usedByExam = Exam::query()
            ->whereJsonContains('questions', (int) $question->id)
            ->orWhereJsonContains('questions', (string) $question->id)
            ->exists();

        $usedByResult = ExamStudent::query()
            ->select(['id', 'questionsAnswers'])
            ->cursor()
            ->contains(function (ExamStudent $result) use ($question) {
                return collect($result->questionsAnswers ?? [])->contains(
                    fn ($answer) => (string) ($answer['question'] ?? '') === (string) $question->id
                );
            });

        if ($usedByExam || $usedByResult) {
            return redirect()
                ->route('admin.exams.question.index', ['classroom' => $question->classroom])
                ->with('error', 'لا يمكن حذف السؤال لأنه مستخدم في امتحان أو نتيجة طالب.');
        }

        $images = explodeUploadedFilenames($question->image);
        $question->delete();

        foreach ($images as $image) {
            $path = 'exams/questions/images/'.basename($image);
            if (Storage::disk('uploads')->exists($path)) {
                Storage::disk('uploads')->delete($path);
            }
        }

        return redirect()
            ->route('admin.exams.question.index', ['classroom' => $question->classroom])
            ->with('success', 'تم حذف السؤال بنجاح');
    }

    private function questionImages(BankQuestion $question): array
    {
        $items = [];
        foreach (explodeUploadedFilenames($question->image) as $filename) {
            $file = public_path("uploads/exams/questions/images/$filename");
            if (! is_file($file)) {
                continue;
            }
            $items[] = [
                'name' => $filename,
                'url' => asset("uploads/exams/questions/images/$filename"),
            ];
        }

        return $items;
    }
}
