<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\StoreWebsiteReviewRequest;
use App\Models\WebsiteReview;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ReviewController extends Controller
{
    public function create(): View
    {
        $student = auth('student')->user();
        $review = WebsiteReview::query()->where('student_id', $student->id)->first();

        return view('student.review', [
            'review' => $review,
        ]);
    }

    public function store(StoreWebsiteReviewRequest $request): RedirectResponse
    {
        $student = auth('student')->user();

        if (WebsiteReview::query()->where('student_id', $student->id)->exists()) {
            return redirect()
                ->route('student.review')
                ->with('info', 'لقد أرسلت رأيك مسبقاً. لا يمكن تعديله من حساب الطالب.');
        }

        WebsiteReview::create([
            'student_id' => $student->id,
            'body' => $request->validated('body'),
            'is_approved' => false,
        ]);

        return redirect()
            ->route('student.review')
            ->with('success', 'تم إرسال رأيك بنجاح. سيظهر على الموقع بعد موافقة الإدارة.');
    }
}
