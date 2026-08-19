<?php

namespace App\Http\Controllers\Admin\Students;

use App\Http\Controllers\Controller;
use App\Models\Center;
use App\Models\Student;
use App\Models\StudentAttendance;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\View\View;

class StudentAttendanceController extends Controller
{
    public function index(Route $route): View
    {
        $view = str_replace('/', '.', $route->uri());
        $centers = Center::select('id', 'title')->orderBy('title')->get();

        return view($view, compact('centers'));
    }

    public function create(Request $request): JsonResponse
    {
        $data = $request->validate([
            'center_id' => ['required', 'exists:centers,id'],
            'code' => ['required', 'string', 'max:255'],
        ], [
            'center_id.required' => 'السنتر مطلوب.',
            'center_id.exists' => 'السنتر غير موجود.',
            'code.required' => 'كود الطالب مطلوب.',
        ]);

        $code = trim($data['code']);

        $student = Student::where('code', $code)->first();
        if (! $student) {
            return response()->json([
                'ok' => false,
                'message' => 'لم يتم العثور على طالب بهذا الكود.',
            ], 404);
        }

        $attendance = StudentAttendance::create([
            'student_id' => $student->id,
            'center_id' => (int) $data['center_id'],
        ]);

        $attendance->load('center');

        $tz = 'Africa/Cairo';

        return response()->json([
            'ok' => true,
            'student' => [
                'id' => $student->id,
                'name' => $student->name ?? '',
                'code' => $student->code,
            ],
            'center' => [
                'id' => $attendance->center_id,
                'title' => $attendance->center?->title,
            ],
            'at_iso' => $attendance->created_at->toIso8601String(),
            'at_eg' => $attendance->created_at->copy()->timezone($tz)->format('d M Y - H:i:s'),
        ], 201);
    }
}
