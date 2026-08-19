<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CapacitorCard;
use App\Models\Center;
use App\Models\Exam;
use App\Models\Lesson;
use App\Models\Student;
use App\Models\WebsiteAsks;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $classRooms = getConstant('classRooms')->getArray();
        $studentCardsByClass = [];
        $studentsByClass = [];

        foreach (array_keys($classRooms) as $classId) {
            $studentCardsTotal = $this->studentCardsQuery($classId)->count();
            $studentCardsUsed = $this->studentCardsQuery($classId)
                ->whereNotNull('center_id')
                ->count();

            $studentCardsByClass[$classId] = [
                'total' => $studentCardsTotal,
                'used' => $studentCardsUsed,
                'unused' => $studentCardsTotal - $studentCardsUsed,
            ];

            $studentsByClass[$classId] = $this->registeredStudentsQuery($classId)->count();
        }

        $capacitorCardsTotal = CapacitorCard::count();
        $capacitorCardsUsed = CapacitorCard::whereNotNull('visited')->count();

        return view('admin.dashboard', [
            'studentsCount' => Student::count(),
            'studentsByClass' => $studentsByClass,
            'centersCount' => Center::count(),
            'lessonsCount' => Lesson::count(),
            'capacitorCardsTotal' => $capacitorCardsTotal,
            'capacitorCardsUsed' => $capacitorCardsUsed,
            'capacitorCardsUnused' => $capacitorCardsTotal - $capacitorCardsUsed,
            'studentCardsByClass' => $studentCardsByClass,
            'classRooms' => $classRooms,
            'openExamsCount' => Exam::whereDate('day', Carbon::today())->count(),
            'unreadWebsiteRequests' => WebsiteAsks::where('is_read', false)->count(),
        ]);
    }

    private function studentCardsQuery(int|string $classId): Builder
    {
        return Student::query()
            ->whereNotNull('batch')
            ->where(fn ($query) => $this->applyClassroomFilter($query, $classId));
    }

    private function registeredStudentsQuery(int|string $classId): Builder
    {
        return Student::query()
            ->whereNotNull('center_id')
            ->where(fn ($query) => $this->applyClassroomFilter($query, $classId));
    }

    private function applyClassroomFilter(Builder $query, int|string $classId): void
    {
        $query->where('classroom', $classId)
            ->orWhere('classroom', (string) $classId);
    }
}
