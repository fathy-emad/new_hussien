<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\UpdateProfileRequest;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function myProfile(): View
    {
        $id = auth()->guard('student')->user()->id;
        $student = Student::find($id);
        $avatar = [];
        $avatarFile = normalizeStoredFilename($student->avatar);
        if ($avatarFile) {
            $file = public_path("uploads/students/images/{$avatarFile}");
            if (file_exists($file) && is_file($file)) {
                $avatar[] = [
                    'file' => asset("uploads/students/images/{$avatarFile}"),
                    'name' => $avatarFile,
                    'size' => filesize($file),
                    'type' => mime_content_type($file),
                ];
            }
        }

        $barcode = studentBarcodeImage($student->code);

        return view('student.profile', [
            'student' => $student,
            'attachments' => ['avatar' => $avatar],
            'barcode' => $barcode,
        ]);
    }

    public function updateProfile(UpdateProfileRequest $request, $id): RedirectResponse
    {
        $student = Student::find($id);

        if ($request->filled('password')) {
            $request->passMatches();
            $student->password = $request->password;
        }

        $student->email = $request->email;
        $student->name = $request->name;

        $avatar = resolveUploadedFilename($request->avatar);
        if ($avatar !== null) {
            $student->avatar = $avatar;
        }

        $student->save();

        return redirect()->back()->with('success', 'تم تعديل البروفايل بنجاح');
    }
}
