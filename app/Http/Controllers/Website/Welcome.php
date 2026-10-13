<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Requests\GetCapacitorLessonRequest;
use App\Models\Capacitor;
use App\Models\CapacitorCard;
use App\Models\WebsiteAsks;
use App\Support\CapacitorAttachments;
use App\Support\CapacitorOfflineAccess;
use App\Support\WebsiteHomepage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class Welcome extends Controller
{
    public function homepage(): View
    {
        return view('website.home', WebsiteHomepage::data());
    }

    public function contact(): View
    {
        return view('website.contact');
    }

    public function website_asks(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'phone' => ['required', 'string', 'max:20'],
            'content' => ['required', 'string', 'max:5000'],
        ]);

        WebsiteAsks::create($validated);

        return redirect()->back()->with('success', 'تم إرسال استفسارك بنجاح');
    }

    public function capacitors(Request $request): View
    {
        $classRooms = getConstant('classRooms')->getArray();

        return view('website.capacitors', [
            'offlineLessons' => WebsiteHomepage::offlineLessons(),
            'offlineLessonsByClassroom' => WebsiteHomepage::offlineLessonsByClassroom($classRooms),
            'classRooms' => $classRooms,
        ]);
    }

    public function capacitor(GetCapacitorLessonRequest $request): JsonResponse|RedirectResponse
    {
        $code = CapacitorCard::where('code', $request->code)->firstOrFail();
        $lesson = Capacitor::query()
            ->where('id', $request->lesson_id)
            ->where('active', true)
            ->firstOrFail();

        if (! CapacitorOfflineAccess::canWatch($code, $lesson)) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'errors' => ['code' => ['تم استنفاذ عدد مرات المشاهدة لهذا الدرس']],
                ], 422);
            }

            return back()->withErrors(['code' => 'تم استنفاذ عدد مرات المشاهدة لهذا الدرس']);
        }

        $url = route('capacitor_lesson', [
            'lesson_id' => $lesson->id,
            'code' => $code->code,
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'redirect' => $url,
            ]);
        }

        return redirect($url);
    }

    public function get_Capacitor(Request $request): View
    {
        $request->validate([
            'lesson_id' => 'required|integer|exists:capacitors,id',
            'code' => 'required|exists:capacitor_cards,code',
        ]);

        $lesson = Capacitor::query()
            ->where('id', $request->lesson_id)
            ->where('active', true)
            ->firstOrFail();

        $code = CapacitorCard::where('code', $request->code)->firstOrFail();

        if (! CapacitorOfflineAccess::canWatch($code, $lesson)) {
            abort(403, 'تم استنفاذ عدد مرات المشاهدة لهذا الدرس');
        }

        CapacitorOfflineAccess::recordView($code, $lesson);

        $classRooms = getConstant('classRooms')->getArray();
        $attachments = CapacitorAttachments::forCapacitor($lesson);
        $remainingViews = CapacitorOfflineAccess::remainingViews($code, $lesson);

        return view('website.capacitor-lesson', [
            'lesson' => $lesson,
            'code' => $code->code,
            'classRooms' => $classRooms,
            'attachments' => $attachments,
            'remainingViews' => $remainingViews,
        ]);
    }
}
