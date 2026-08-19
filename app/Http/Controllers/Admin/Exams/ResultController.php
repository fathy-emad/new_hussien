<?php

namespace App\Http\Controllers\Admin\Exams;

use App\Http\Controllers\Concerns\PaginatesAdminTables;
use App\Http\Controllers\Controller;
use App\Models\BankQuestion;
use App\Models\Exam;
use App\Models\ExamStudent;
use App\Models\Student;
use App\Support\ExamStudentScoring;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\View\View;

class ResultController extends Controller
{
    use PaginatesAdminTables;

    public function view($id): View
    {
        $examStudent = ExamStudent::with(['exam'])->findOrFail($id);
        $student = Student::find($examStudent->student_id);
        $details = [];

        foreach ($examStudent->questionsAnswers ?? [] as $qa) {
            $bankQuestion = BankQuestion::find($qa['question'] ?? null);
            $answers = is_array($bankQuestion?->answers) ? $bankQuestion->answers : [];
            $answerIndex = $qa['answer'] ?? null;
            $correctIndex = $bankQuestion?->correct_answer;

            $details[] = [
                'question' => $this->displayValue($bankQuestion?->question ?? '—'),
                'student_answer' => $this->displayAnswer($answers, $answerIndex),
                'correct_answer' => $this->displayAnswer($answers, $correctIndex),
                'is_correct' => $bankQuestion && (string) $correctIndex === (string) $answerIndex,
            ];
        }

        return view('admin.exams.result.view', [
            'examStudent' => $examStudent,
            'student' => $student,
            'exam' => $examStudent->exam,
            'details' => $details,
            'searchParams' => [
                'classroom' => $student?->classroom,
                'exam_id' => $examStudent->exam_id,
            ],
        ]);
    }

    public function index(Route $route, Request $request): View
    {
        $view = str_replace('/', '.', $route->uri());
        $classRooms = getConstant('classRooms')->getArray();
        $searchParams = [
            'classroom' => $request->classroom,
            'exam_id' => $request->exam_id,
            'code' => trim((string) $request->input('code', '')),
        ];

        $examsForClassroom = $request->classroom
            ? Exam::where('classroom', $request->classroom)->orderByDesc('day')->get()
            : collect();

        if (empty($request->classroom) || empty($request->exam_id)) {
            return view($view, [
                'classRooms' => $classRooms,
                'examsForClassroom' => $examsForClassroom,
                'searchParams' => $searchParams,
                'hasSearch' => false,
            ]);
        }

        $exam = Exam::findOrFail($request->exam_id);
        $examStats = ExamStudentScoring::examClassStatistics($exam, (string) $request->classroom);

        $examStudents = ExamStudent::where('exam_id', $request->exam_id)
            ->get()
            ->keyBy('student_id');

        $studentQuery = Student::query()
            ->where('classroom', $request->classroom)
            ->orderBy('name');

        if ($searchParams['code'] !== '') {
            $studentQuery->where('code', 'like', '%'.$searchParams['code'].'%');
        }

        $students = $this->paginateAdminTable($studentQuery, $request);

        $dataLables = [
            'الطالب',
            'الكود',
            'النتيجة',
            'وقت دخول الامتحان',
            'إدارة',
        ];
        $dataRows = [];

        foreach ($students as $key => $student) {
            $studentExam = $examStudents->get($student->id);

            if ($studentExam && ! empty($studentExam->questionsAnswers)) {
                $score = ExamStudentScoring::score($studentExam);
                $degreeLabel = $score['degree_label'];
                $attended = $studentExam->visited
                    ? $studentExam->visited->format('d M Y - H:i:s')
                    : '—';
                $viewId = $studentExam->id;
            } else {
                $degreeLabel = 'لم يحضر';
                $attended = '—';
                $viewId = null;
            }

            $dataRows[$key][] = $this->displayValue($student->name ?: $student->code);
            $dataRows[$key][] = $this->displayValue($student->code);
            $dataRows[$key][] = $degreeLabel;
            $dataRows[$key][] = $attended;
            $dataRows[$key][] = [
                'id' => $viewId,
                'delete' => false,
                'view' => (bool) $viewId,
                'edit' => false,
                'viewLabel' => 'عرض',
            ];
        }

        return view($view, [
            'dataLables' => $dataLables,
            'dataRows' => $dataRows,
            'students' => $students,
            'classRooms' => $classRooms,
            'examsForClassroom' => $examsForClassroom,
            'searchParams' => $searchParams,
            'hasSearch' => true,
            'exam' => $exam,
            'examStats' => $examStats,
        ]);
    }

    private function displayAnswer(array $answers, mixed $index): string
    {
        if ($index === null || ! array_key_exists($index, $answers)) {
            return '—';
        }

        return $this->displayValue($answers[$index]);
    }

    private function displayValue(mixed $value): string
    {
        if (is_array($value)) {
            return implode(' ', array_map(fn ($item) => $this->displayValue($item), $value));
        }

        if ($value === null || $value === '') {
            return '—';
        }

        return (string) $value;
    }
}
