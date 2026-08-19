<?php

namespace App\Http\Controllers\Admin\Website;

use App\Http\Controllers\Concerns\PaginatesAdminTables;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Website\UpdateWebsiteReviewRequest;
use App\Models\WebsiteReview;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ReviewsController extends Controller
{
    use PaginatesAdminTables;

    public function index(Route $route, Request $request): View
    {
        $view = str_replace('/', '.', $route->uri());
        $classRooms = getConstant('classRooms')->getArray();

        $reviews = $this->paginateAdminTable(
            WebsiteReview::query()
                ->with('student.center')
                ->orderByDesc('id'),
            $request
        );

        $dataLables = [
            'الطالب',
            'الصف',
            'السنة',
            'الرأي',
            'الحالة',
            'إدارة',
        ];
        $dataRows = [];
        $reviewDetails = [];

        foreach ($reviews as $key => $review) {
            $student = $review->student;
            $classroomKey = (int) ($student?->classroom ?? 0);
            $studentName = $student?->name ?: ($student?->code ?? '—');
            $classroom = $classRooms[$classroomKey] ?? ($student?->classroom ?? '—');

            $reviewDetails[$review->id] = [
                'student' => $studentName,
                'classroom' => $classroom,
                'year' => $student?->academic_year ?? '—',
                'body' => $review->body,
                'status' => $review->is_approved ? 'معتمد' : 'قيد المراجعة',
                'submitted_at' => $review->created_at?->format('d M Y - H:i') ?? '—',
            ];

            $dataRows[$key][] = $studentName;
            $dataRows[$key][] = $classroom;
            $dataRows[$key][] = $student?->academic_year ?? '—';
            $dataRows[$key][] = [
                'html' => view('components.admin-website-review-excerpt', [
                    'id' => $review->id,
                    'excerpt' => Str::limit($review->body, 50),
                ])->render(),
            ];
            $statusLabel = $review->is_approved ? 'معتمد' : 'قيد المراجعة';
            if (mb_strlen($review->body) > WebsiteReview::BODY_MAX) {
                $statusLabel = 'طويل — يحتاج تعديل';
            }

            $dataRows[$key][] = $statusLabel;
            $dataRows[$key][] = [
                'html' => view('components.admin-website-review-actions', [
                    'id' => $review->id,
                    'approved' => (bool) $review->is_approved,
                ])->render(),
            ];
        }

        return view($view, [
            'dataLables' => $dataLables,
            'dataRows' => $dataRows,
            'reviews' => $reviews,
            'reviewDetails' => $reviewDetails,
        ]);
    }

    public function approve(int $id): RedirectResponse
    {
        $review = WebsiteReview::findOrFail($id);

        $review->update([
            'is_approved' => true,
            'approved_by' => auth('admin')->id(),
            'approved_at' => now(),
        ]);

        return redirect()->back()->with('success', 'تم اعتماد الرأي ونشره على الموقع');
    }

    public function edit(int $id): View
    {
        $review = WebsiteReview::with('student.center')->findOrFail($id);
        $classRooms = getConstant('classRooms')->getArray();
        $student = $review->student;
        $classroomKey = (int) ($student?->classroom ?? 0);

        return view('admin.website.reviews.edit', [
            'review' => $review,
            'studentName' => $student?->name ?: ($student?->code ?? '—'),
            'classroom' => $classRooms[$classroomKey] ?? ($student?->classroom ?? '—'),
            'year' => $student?->academic_year ?? '—',
        ]);
    }

    public function update(UpdateWebsiteReviewRequest $request, int $id): RedirectResponse
    {
        $review = WebsiteReview::findOrFail($id);

        $review->update([
            'body' => $request->validated('body'),
            'is_approved' => false,
            'approved_by' => null,
            'approved_at' => null,
        ]);

        return redirect()
            ->route('admin.website.reviews.index')
            ->with('success', 'تم تحديث الرأي. يحتاج اعتماداً جديداً قبل الظهور على الموقع.');
    }

    public function reject(int $id): RedirectResponse
    {
        $review = WebsiteReview::findOrFail($id);

        $review->update([
            'is_approved' => false,
            'approved_by' => null,
            'approved_at' => null,
        ]);

        return redirect()->back()->with('success', 'تم إلغاء اعتماد الرأي');
    }

    public function delete(int $id): RedirectResponse
    {
        WebsiteReview::findOrFail($id)->delete();

        return redirect()
            ->route('admin.website.reviews.index')
            ->with('success', 'تم حذف الرأي بنجاح');
    }
}
