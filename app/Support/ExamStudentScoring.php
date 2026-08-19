<?php

namespace App\Support;

use App\Models\BankQuestion;
use App\Models\Exam;
use App\Models\ExamStudent;
use App\Models\Student;
use Carbon\Carbon;

class ExamStudentScoring
{
    public static function score(ExamStudent $examStudent): array
    {
        $degree = 0;
        $questionsAnswers = $examStudent->questionsAnswers ?? [];
        $total = count($questionsAnswers);
        $details = [];

        foreach ($questionsAnswers as $qa) {
            $bankQuestion = BankQuestion::find($qa['question'] ?? null);
            $answers = is_array($bankQuestion?->answers) ? $bankQuestion->answers : [];
            $answerIndex = $qa['answer'] ?? null;
            $correctIndex = $bankQuestion?->correct_answer ?? null;
            $isCorrect = $bankQuestion && (string) $correctIndex === (string) $answerIndex;

            if ($isCorrect) {
                $degree++;
            }

            $images = [];
            foreach (explodeUploadedFilenames($bankQuestion?->image ?? '') as $image) {
                $images[] = asset('uploads/exams/questions/images/'.$image);
            }

            $details[] = [
                'question' => $bankQuestion?->question ?? '—',
                'images' => $images,
                'student_answer' => self::answerLabel($answers, $answerIndex),
                'student_answer_index' => $answerIndex,
                'correct_answer' => self::answerLabel($answers, $correctIndex),
                'correct_answer_index' => $correctIndex,
                'is_correct' => $isCorrect,
            ];
        }

        $percentage = $total > 0 ? round(($degree / $total) * 100, 1) : 0;

        return [
            'degree' => $degree,
            'total' => $total,
            'degree_label' => $degree.' / '.$total,
            'percentage' => $percentage,
            'details' => $details,
        ];
    }

    public static function answerLabel(array $answers, mixed $index): string
    {
        if ($index === null || $index === '') {
            return '—';
        }

        return $answers[(int) $index] ?? '—';
    }

    public static function resolveStatus(?ExamStudent $examStudent, Exam $exam): string
    {
        if (! $examStudent || empty($examStudent->questionsAnswers)) {
            return 'not_attended';
        }

        if (Carbon::now()->gt(Carbon::parse($exam->day)->endOfDay())) {
            return 'completed';
        }

        if ($examStudent->finished && Carbon::now()->gte($examStudent->finished)) {
            return 'time_ended';
        }

        if ($examStudent->visited) {
            return 'in_progress';
        }

        return 'not_attended';
    }

    public static function statusLabel(string $status): string
    {
        return match ($status) {
            'not_attended' => 'لم يحضر',
            'in_progress' => 'جاري الامتحان',
            'time_ended' => 'انتهى الوقت',
            'completed' => 'تم التصحيح',
            default => '—',
        };
    }

    public static function statusBadgeClass(string $status): string
    {
        return match ($status) {
            'not_attended' => 'bg-secondary',
            'in_progress' => 'bg-primary',
            'time_ended' => 'bg-warning text-dark',
            'completed' => 'bg-success',
            default => 'bg-secondary',
        };
    }

    public static function remainingMinutes(ExamStudent $examStudent): int
    {
        if (! $examStudent->finished) {
            return 0;
        }

        if (now()->getTimestamp() >= $examStudent->finished->getTimestamp()) {
            return 0;
        }

        return (int) now()->diffInMinutes($examStudent->finished) + 1;
    }

    /**
     * Exam-wide stats for all students in a classroom (not paginated).
     */
    public static function examClassStatistics(Exam $exam, string $classroom): array
    {
        $passThreshold = (int) config('admin.exam_pass_percentage', 50);
        $studentIds = Student::where('classroom', $classroom)->pluck('id');
        $total = $studentIds->count();

        $examStudents = ExamStudent::where('exam_id', $exam->id)
            ->whereIn('student_id', $studentIds)
            ->get()
            ->keyBy('student_id');

        $attended = 0;
        $passed = 0;
        $failed = 0;

        foreach ($studentIds as $studentId) {
            $examStudent = $examStudents->get($studentId);

            if (! $examStudent || empty($examStudent->questionsAnswers)) {
                continue;
            }

            $attended++;
            $score = self::score($examStudent);

            if ($score['percentage'] >= $passThreshold) {
                $passed++;
            } else {
                $failed++;
            }
        }

        $absent = max(0, $total - $attended);

        return [
            'total' => $total,
            'attended' => $attended,
            'absent' => $absent,
            'passed' => $passed,
            'failed' => $failed,
            'attended_label' => $attended.' / '.$total,
            'absent_percent' => $total > 0 ? round($absent / $total * 100, 1) : 0,
            'success_percent' => $total > 0 ? round($passed / $total * 100, 1) : 0,
            'fail_percent' => $total > 0 ? round($failed / $total * 100, 1) : 0,
            'pass_threshold' => $passThreshold,
        ];
    }
}
