<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Concerns\PaginatesAdminTables;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Settings\CreateEditCenterRequest;
use App\Models\Admin;
use App\Models\Center AS Place;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CenterController extends Controller
{
    use PaginatesAdminTables;

    public function index(Route $route, Request $request): View
    {
        $view = str_replace("/", ".", $route->uri());

        $centers = $this->paginateAdminTable(
            Place::with(['createdBy', 'updatedBy'])->orderByDesc('id'),
            $request
        );
        // RTL: first column (right) = اسم السنتر, last column (left) = وقت الإنشاء
        $dataLables = [
            'اسم السنتر',
            'رقم الموبايل',
            'العنوان',
            'إنشاء بواسطة',
            'حدث بواسطة',
            'وقت التحديث',
            'إدارة',
            'وقت الإنشاء',
        ];
        $dataRows = [];
        foreach ($centers as $key => $center) {
            $dataRows[$key][] = $center->title;
            $dataRows[$key][] = $center->phone;
            $dataRows[$key][] = $center->address;
            $dataRows[$key][] = $center->createdBy->name ?? null;
            $dataRows[$key][] = $center->updatedBy->name ?? null;
            $dataRows[$key][] = $center->updated_at ? $center->updated_at->format('d M Y - H:i:s') : null;
            $dataRows[$key][] = [
                'id' => $center->id,
                'delete' => true,
                'view' => false,
                'edit' => true,
            ];
            $dataRows[$key][] = $center->created_at ? $center->created_at->format('d M Y - H:i:s') : null;
        }

        return view($view, [
            'dataLables' => $dataLables,
            'dataRows' => $dataRows,
            'centers' => $centers,
        ]);
    }

    public function showCreate(): View
    {
        return view('admin.settings.center.create');
    }

    public function create(CreateEditCenterRequest $request): RedirectResponse
    {
        $center = new Place;
        $center->title = $request->title;
        $center->address = $request->address;
        $center->phone = $request->phone;
        $center->created_by = Auth::guard('admin')->user()->id;
        $center->updated_at = null;
        $center->save();
        return redirect()->route('admin.settings.center.index')->with('success', __('validation.create.success'));
    }

    public function edit($id): View
    {
        $center = Place::find($id);
        return view('admin.settings.center.edit', ['center' => $center]);
    }

    public function update(CreateEditCenterRequest $request, $id): RedirectResponse
    {
        $center = Place::find($id);
        $created_at = $center->created_at;
        $center->title = $request->title;
        $center->address = $request->address;
        $center->phone = $request->phone;
        $center->updated_by = Auth::guard('admin')->user()->id;
        $center->created_at = $created_at;
        $center->save();
        return redirect()->route('admin.settings.center.index')->with('success', __('validation.update.success'));
    }

    public function delete($id): RedirectResponse
    {
        $center = Place::findOrFail($id);
        $hasStudents = DB::table('students')->where('center_id', $center->id)->exists();
        $hasSchedules = DB::table('schedules')->where('center_id', $center->id)->exists();
        $hasAttendance = DB::table('student_attendances')->where('center_id', $center->id)->exists();

        if ($hasStudents || $hasSchedules || $hasAttendance) {
            return redirect()->back()->with(
                'error',
                'لا يمكن حذف السنتر لأنه مرتبط بطلاب أو جداول حصص أو سجلات حضور. انقل البيانات المرتبطة أولاً.'
            );
        }

        $center->delete();

        return redirect()
            ->route('admin.settings.center.index')
            ->with('success', 'تم حذف السنتر بنجاح');
    }
}
