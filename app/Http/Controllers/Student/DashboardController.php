<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        /** @var Student $student */
        $student = auth('student')->user();

        return view('student.dashboard', [
            'student' => $student,
            'classRooms' => getConstant('classRooms')->getArray(),
            'barcode' => studentBarcodeImage($student->code),
        ]);
    }
}
