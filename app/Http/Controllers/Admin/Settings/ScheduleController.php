<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Settings\CreateEditScheduleRequest;
use App\Models\Schedule;
use App\Models\ScheduleCount;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ScheduleController extends Controller
{
    public function index(Route $route, Request $request): View
    {
        $view = str_replace("/", ".", $route->uri());

        if (! $request->academic_year || ! $request->classroom) return view($view);

        $sessions = Schedule::all()
            ->where('classroom', $request->classroom)
            ->where('academic_year', $request->academic_year);
        $dataLables = ["العنوان", "من", "إلى", "اليوم", "السنتر", "الصف الدراسي", "السنة الدراسية", "وقت الإنشاء", "إنشاء بواسطة", "وقت التحديث", "حدث بواسطة", "إدارة" ];
        $dataRows = [];
        foreach ($sessions AS $key => $session){
            $dataRows[$key][] = [
                'id' => $session->id,
                'delete' => true,
                'view' => false,
                'edit' => true
            ];
            $dataRows[$key][] = $session->updatedBy->name ?? null;
            $dataRows[$key][] = $session->updated_at ? $session->updated_at->format('d M Y - H:i:s') : null;
            $dataRows[$key][] = $session->createdBy->name ?? null;
            $dataRows[$key][] = $session->created_at ? $session->created_at->format('d M Y - H:i:s') : null;
            $dataRows[$key][] = $session->academic_year;
            $dataRows[$key][] = getConstant('classRooms')->getValue($session->classroom);
            $dataRows[$key][] = $session->center->title;
            $dataRows[$key][] = getConstant('days')->getValue($session->day);
            $dataRows[$key][] = $session->to . "  " . $session->to_type;
            $dataRows[$key][] = $session->from . "  " . $session->from_type;
            $dataRows[$key][] = $session->title ?? null;
        }
        return view($view, [
            'dataLables' => array_reverse($dataLables),
            'dataRows' => $dataRows,
            'searchParams' => [
                'classroom' => $request->classroom,
                'academic_year' => $request->academic_year
            ]
        ]);
    }

    public function create(CreateEditScheduleRequest $request, $fromUpdate = false): RedirectResponse|Schedule
    {

        $session = $this->saveSchedule(new Schedule, $request, 0, 'add');
        if ($session->id) $this->setCounts($request, $session->id);
        if ($fromUpdate) return $session;
        return redirect()->back()->with('success', 'تم إنشاء جدول الحصة بنجاح');
    }

    public function edit($id): View
    {
        $session = Schedule::find($id);
        return view('admin.settings.schedule.edit', ['session' => $session]);
    }

    public function update(CreateEditScheduleRequest $request, $id): RedirectResponse|View
    {
        $session = Schedule::find($id);

        $changeTime = $request->day != $session->day || $request->from != $session->from ||$request->from_to != $session->from_to;
        $changeCenter = $request->center_id != $session->center_id;
        $newSchedule = $changeTime || $changeCenter;

        //if change time or center
        if ($newSchedule) {

            //schedule have counts
            if (array_sum(array_column($session->counts->toArray(), 'count')))
            {
                //delete all after now
                ScheduleCount::where('schedule_id', $session->id)->where('notificationTime', '>=', time())->delete();

                //change in time only
                if ($changeTime && !$changeCenter) {

                    //Set New Counts
                    $this->setCounts($request, $session->id);
                    $status = 2;
                }

                //change in center
                else {

                    $session->canceled = 1;
                    $session->save();
                    $newSession = $this->create($request, true);
                    return redirect("admin/settings/schedule/edit/$newSession->id")->with('success', 'تم تعديل جدول الحصة بنجاح');
                }
            }


            //schedule have not counts
            else
            {
                //case in change time only
                if ($changeTime){

                    //Delete All Counts And Set New Counts
                    ScheduleCount::where('schedule_id', $session->id)->delete();

                    //set new counts
                    $this->setCounts($request, $session->id);
                }
                $status = 0;
            }
        }

        //if not change time or center
        else
        {
            $status = 0;
        }


        $this->saveSchedule($session, $request, $status, 'edit');
        return redirect()->back()->with('success', 'تم تعديل جدول الحصة بنجاح');
    }

    public function delete($id): RedirectResponse
    {
        DB::table('schedules')->where('id', $id)->delete();
        DB::table('schedule_counts')->where('schedule_id', $id)->delete();
        return redirect()->back()->with('success', 'تم حذف جدول الحصة بنجاح');
    }

    public function setCounts($request, $schedule_id): void
    {
        switch ($request->day){
            case 1 : $day = 'Saturday'; break;
            case 2 : $day = 'Sunday'; break;
            case 3 : $day = 'Monday'; break;
            case 4 : $day = 'Tuesday'; break;
            case 5 : $day = 'Wednesday'; break;
            case 6 : $day = 'Thursday'; break;
            case 7 : $day = 'Friday'; break;
        }
        $firstOfPeriod = new Carbon("first $day of Now" . $request->academic_year - 1);
        $lastOfPeriod = new Carbon("last $day of July ". $request->academic_year);
        $period = CarbonPeriod::create($firstOfPeriod->startOfDay(),'7 days', $lastOfPeriod->startOfDay());
        $factor = $request->from_type == "AM" ? 0 : 12;
        foreach ($period as $date) {
            $count = new ScheduleCount;
            $count->schedule_id = $schedule_id;
            $count->notificationTime = $date->getTimestamp() + (($request->from + $factor) * 3600);
            $count->save();
        }
    }

    public function saveSchedule($session, $request, $status, $saveType = "add"): Schedule
    {
        $session->title = $request->title;
        $session->academic_year = $request->academic_year;
        $session->classroom = $request->classroom;
        $session->center_id = $request->center_id;
        $session->day = $request->day;
        $session->from = $request->from;
        $session->from_type = $request->from_type;
        $session->to = $request->to;
        $session->to_type = $request->to_type;
        $session->canceled = $status;
        if ($saveType != 'add'){
            $created_at = $session->created_at;
            $session->updated_by = Auth::guard('admin')->user()->id;
            $session->created_at = $created_at;
        } else {
            $session->created_by = Auth::guard('admin')->user()->id;
            $session->updated_at = null;
        }

        $session->save();

       return $session;
    }
}
