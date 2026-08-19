<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\ScheduleCount;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\View\View;

class StudentReportsController extends Controller
{
    public function getCounts(Route $route, Request $request): View
    {
        $view = str_replace("/", ".", $route->uri());

        if (! $request->academic_year ||
            ! $request->classroom ||
            ! $request->center_id ||
            ! $request->dateFrom ||
            ! $request->dateTo) { return view($view, ['error' => 'يجب ان تدخل كل الحقول']); }

        $dateFrom = Carbon::parse($request->dateFrom, 'Africa/Cairo')->startOfDay()->getTimestamp();
        $dateTo = Carbon::parse($request->dateTo, 'Africa/Cairo')->endOfDay()->getTimestamp();


        $data = [];
        foreach ($request->center_id AS $id)
        {
            
            $schedules = Schedule::where('academic_year', $request->academic_year)
                ->where('classroom', $request->classroom)->where('center_id', $id)->orderBy('day', 'ASC')
                ->get();

            if ($schedules->count())
            {
                foreach ($schedules AS $schedule)
                {
                    $counts = ScheduleCount::where('schedule_id', $schedule->id)->where('notificationTime', '>=' , $dateFrom)
                        ->where('notificationTime', '<=' , $dateTo)->orderBy('notificationTime', 'ASC')->get();

                    if ($counts->count())
                    {
                        $data[$schedule->center->title][] = [
                            'schedule' => $schedule,
                            'counts' => $counts->toArray()
                        ];
                    }

                }
            }

        }
        
        return view($view, [
            'data' => $data,
            'searchParams' => [
                'classroom' => $request->classroom,
                'academic_year' => $request->academic_year,
                'center_id' => $request->center_id,
                'dateFrom' => $request->dateFrom,
                'dateTo' => $request->dateTo,
                'edit' => $request->edit ?: null
            ]
        ]);
    }


    public function editCount(Request $request, $id): RedirectResponse
    {
        $count = ScheduleCount::find($id);
        $count->count = $request->count;
        $count->save();
        return redirect()->back()->with('success', 'تم نعديل العدد بنجاح');
    }
}
