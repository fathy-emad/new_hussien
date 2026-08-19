<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\StudentAttendance;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AttendanceController extends Controller
{
    // Make sure this route uses middleware('auth:student')
    public function attendance(): View
    {
        $tz = 'Africa/Cairo';

        /** @var \App\Models\Student $student */
        $student = Auth::guard('student')->user(); // or Auth::user() if default guard = student
        abort_unless($student instanceof Student, 403);

        // get all attendances for this student (newest first)
        $attendances = StudentAttendance::with('center')
            ->where('student_id', $student->id)
            ->orderByDesc('created_at')
            ->get()
            ->map(function ($a) use ($tz) {
                $a->created_at_eg = $a->created_at?->copy()->timezone($tz);
                $a->created_label = $a->created_at_eg?->format('d M Y - H:i:s'); // 19 Aug 2025 - 23:54:29
                $a->month_key     = $a->created_at_eg?->format('Y-m');           // 2025-08
                return $a;
            });

        // group ONLY existing months; newest month first
        $grouped = $attendances->groupBy('month_key')->sortKeysDesc();

        // build month blocks: label like "8 / 2025"
        $monthBlocks = $grouped->map(function ($items) {
            $first = $items->first();
            return [
                'label' => $first->created_at_eg?->format('n / Y'),
                'items' => $items,
            ];
        });

        return view('student.attendance', [
            'student'     => $student,
            'monthBlocks' => $monthBlocks,
        ]);
    }
}
