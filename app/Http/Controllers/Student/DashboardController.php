<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\ExamStudent;
use App\Models\Student;
use App\Support\ExamStudentScoring;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        /** @var Student $student */
        $student = auth('student')->user();

        $examResults = ExamStudent::query()
            ->with('exam')
            ->where('student_id', $student->id)
            ->orderByDesc('visited')
            ->limit(20)
            ->get()
            ->filter(function (ExamStudent $attempt) {
                if (! $attempt->exam) {
                    return false;
                }

                return in_array(
                    ExamStudentScoring::resolveStatus($attempt, $attempt->exam),
                    ['time_ended', 'completed'],
                    true
                );
            })
            ->take(5)
            ->map(function (ExamStudent $attempt) {
                $exam = $attempt->exam;
                $status = ExamStudentScoring::resolveStatus($attempt, $exam);
                $exam->status = $status;
                $exam->status_label = ExamStudentScoring::statusLabel($status);
                $exam->status_badge = ExamStudentScoring::statusBadgeClass($status);
                $exam->visited_at = $attempt->visited?->format('d M Y - H:i');
                $exam->score_details = ExamStudentScoring::score($attempt);

                return $exam;
            })
            ->values();

        return view('student.dashboard', [
            'student' => $student,
            'classRooms' => getConstant('classRooms')->getArray(),
            'barcode' => studentBarcodeImage($student->code),
            'examResults' => $examResults,
        ]);
    }

    public function updatePhone(Request $request): RedirectResponse
    {
        /** @var Student $student */
        $student = auth('student')->user();

        $validated = $request->validate(
            [
                'phone' => [
                    'required',
                    'digits:11',
                    Rule::unique('students', 'phone')->ignore($student->id),
                ],
            ],
            [
                'phone.required' => 'رقم الموبايل مطلوب.',
                'phone.digits' => 'رقم الموبايل يجب أن يتكون من 11 رقماً.',
                'phone.unique' => 'رقم الموبايل مستخدم بواسطة طالب آخر.',
            ]
        );

        $student->phone = $validated['phone'];
        $student->save();

        return redirect()
            ->route('student.dashboard')
            ->with('success', 'تم تحديث رقم الموبايل بنجاح.');
    }
}
