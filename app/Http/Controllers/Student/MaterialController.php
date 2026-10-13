<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\Lesson;
use App\Models\View AS Watch;
use App\Support\LessonAttachments;
use Illuminate\View\View;

class MaterialController extends Controller
{
    /**
     * @throws \Exception
     */
    public function material(): View
    {
        $student = auth()->guard('student')->user();
        $student_id = $student->id;
        $student_academic_year = $student->academic_year;
        $student_classroom = $student->classroom;
        $student_code = $student->code;
        $chapters = Chapter::orderBy('chapterNo', 'asc')
            ->where('classroom', $student_classroom)
            ->where('academic_year', $student_academic_year)
            ->get();
        $materials = [];
        foreach ($chapters AS $chapter) {
            foreach ($chapter->lessons AS $lesson) {
                $student_views = Watch::where('student_id', $student_id)->where('lesson_id', $lesson->id)->first();
                $view = $student_views ? $student_views->times : 0;
                $materials[$chapter->title][] = [
                    'id' => $lesson['id'],
                    'link' => $lesson->link,
                    'lessonNo' => $lesson->NO,
                    'title' => $lesson->title,
                    'watchTimes' => $lesson->watchTimes ?: 0,
                    'views' => $view,
                    'opened' => $lesson->link && $view < $lesson->watchTimes
                ];
            }
        }
        return view('student.material', ['materials' => $materials]);
    }

    public function lesson($id): View
    {
        $student = auth()->guard('student')->user();
        $student_id = $student->id;
        $lesson = Lesson::with('chapter')->findOrFail($id);

        if ($lesson->chapter) {
            if ((string) $lesson->chapter->classroom !== (string) $student->classroom
                || (string) $lesson->chapter->academic_year !== (string) $student->academic_year) {
                abort(403);
            }
        }

        $student_views = Watch::where('student_id', $student_id)->where('lesson_id', $lesson->id)->first();
        $view = $student_views ? $student_views->times : 0;
        $lesson->view = $view;
        $lesson->opened = $lesson->link && $view < $lesson->watchTimes;

        if ($student_views && $view < $lesson->watchTimes){
            $student_views->times = $view + 1;
            $student_views->save();

        } elseif (! $student_views && $view < $lesson->watchTimes){
            $watch = new Watch;
            $watch->student_id = $student_id;
            $watch->lesson_id = $lesson->id;
            $watch->times = $view + 1;
            $watch->save();
        }

        return view('student.lesson', [
            'lesson' => $lesson,
            'attachments' => LessonAttachments::forLesson($lesson),
        ]);
    }
}
