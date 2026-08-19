<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\BankQuestion;
use App\Models\Exam;
use App\Models\ExamStudent;
use App\Support\ExamStudentScoring;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ExamController extends Controller
{
    public function exams(): View
    {
        $student = Auth::guard('student')->user();

        $openedExams = Exam::where('classroom', $student->classroom)
            ->whereDate('day', Carbon::today())
            ->get()
            ->each(fn (Exam $exam) => $this->enrichExamForStudent($exam, $student->id, true));

        $futureExams = Exam::where('classroom', $student->classroom)
            ->whereDate('day', '>', Carbon::today())
            ->get();

        $oldExams = Exam::where('classroom', $student->classroom)
            ->whereDate('day', '<', Carbon::today())
            ->orderByDesc('day')
            ->get()
            ->each(fn (Exam $exam) => $this->enrichExamForStudent($exam, $student->id, true));

        return view('student.exams', [
            'openedExams' => $openedExams,
            'futureExams' => $futureExams,
            'oldExams' => $oldExams,
        ]);
    }

    public function examOpen($exam_id): View
    {
        $student = Auth::guard('student')->user();

        $exam = Exam::where('id', $exam_id)
            ->where('classroom', $student->classroom)
            ->whereDate('day', Carbon::today())
            ->firstOrFail();

        $examStudent = ExamStudent::where('exam_id', $exam_id)
            ->where('student_id', $student->id)
            ->first();

        if (! $examStudent) {
            $visited = now();
            $finished = $visited->copy()->addMinutes((int) $exam->time);

            $questionsAnswers = [];
            foreach ($exam->questions ?? [] as $questionId) {
                $questionsAnswers[] = [
                    'question' => $questionId,
                    'answer' => null,
                ];
            }

            shuffle($questionsAnswers);

            $examStudent = ExamStudent::create([
                'exam_id' => $exam_id,
                'student_id' => $student->id,
                'visited' => $visited,
                'finished' => $finished,
                'questionsAnswers' => $questionsAnswers,
            ]);
        }

        $status = ExamStudentScoring::resolveStatus($examStudent, $exam);
        $tested = $status === 'completed';
        $readonly = in_array($status, ['time_ended', 'completed'], true);
        $remainingMinutes = ExamStudentScoring::remainingMinutes($examStudent);

        $questionCards = [];
        foreach ($examStudent->questionsAnswers ?? [] as $key => $qa) {
            $question = BankQuestion::find($qa['question'] ?? null);
            if (! $question) {
                continue;
            }

            $images = [];
            foreach (explodeUploadedFilenames($question->image ?? '') as $image) {
                $images[] = asset('uploads/exams/questions/images/'.$image);
            }

            $questionCards[] = [
                'key' => $key,
                'question_id' => $qa['question'],
                'selected_answer' => $qa['answer'] ?? null,
                'question' => $question,
                'images' => $images,
            ];
        }

        return view('student.exam', [
            'exam' => $exam,
            'examStudent' => $examStudent,
            'examStudentId' => $examStudent->id,
            'questionCards' => $questionCards,
            'remainingMinutes' => $remainingMinutes,
            'tested' => $tested,
            'readonly' => $readonly,
            'status' => $status,
        ]);
    }

    public function examSubmit(Request $request): JsonResponse
    {
        $request->validate([
            'exam_id' => ['required', 'integer'],
            'questionsAnswers' => ['nullable', 'array'],
            'final' => ['nullable'],
        ]);

        $studentId = Auth::guard('student')->id();

        $examStudent = ExamStudent::where('id', $request->exam_id)
            ->where('student_id', $studentId)
            ->firstOrFail();

        $exam = Exam::findOrFail($examStudent->exam_id);

        if ((string) $exam->classroom !== (string) Auth::guard('student')->user()->classroom) {
            abort(403);
        }

        $canEdit = now()->lt($examStudent->finished) || $request->boolean('final');

        if (! $canEdit) {
            return response()->json(['message' => 'انتهى وقت الامتحان'], 403);
        }

        $submitted = collect($request->input('questionsAnswers', []))
            ->keyBy(fn ($qa) => (string) ($qa['question'] ?? ''));

        $questionsAnswers = [];
        foreach ($examStudent->questionsAnswers ?? [] as $qa) {
            $questionId = (string) ($qa['question'] ?? '');
            $questionsAnswers[] = [
                'question' => $qa['question'],
                'answer' => $submitted->has($questionId)
                    ? ($submitted[$questionId]['answer'] ?? null)
                    : ($qa['answer'] ?? null),
            ];
        }

        $examStudent->questionsAnswers = $questionsAnswers;
        $score = ExamStudentScoring::score($examStudent);
        $examStudent->mark = $score['degree_label'];
        $examStudent->save();

        return response()->json([
            'success' => true,
            'score' => $score,
        ]);
    }

    private function enrichExamForStudent(Exam $exam, int $studentId, bool $withDetails = false): Exam
    {
        $examStudent = ExamStudent::where('exam_id', $exam->id)
            ->where('student_id', $studentId)
            ->first();

        $status = ExamStudentScoring::resolveStatus($examStudent, $exam);
        $exam->status = $status;
        $exam->status_label = ExamStudentScoring::statusLabel($status);
        $exam->status_badge = ExamStudentScoring::statusBadgeClass($status);

        if ($examStudent && ! empty($examStudent->questionsAnswers)) {
            $score = ExamStudentScoring::score($examStudent);
            $exam->degree = $score['degree_label'];
            $exam->percentage = $score['percentage'];
            $exam->attended = true;
            $exam->exam_student_id = $examStudent->id;
            $exam->visited_at = $examStudent->visited?->format('d M Y - H:i');

            if ($withDetails) {
                $exam->score_details = $score;
            }
        } else {
            $exam->degree = 'لم يحضر';
            $exam->percentage = null;
            $exam->attended = false;
            $exam->exam_student_id = null;
            $exam->visited_at = null;
            $exam->score_details = null;
        }

        return $exam;
    }
}
