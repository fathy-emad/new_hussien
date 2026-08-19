<?php

namespace App\Http\Controllers\Admin\permissionsAndEmployees;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PermissionsAndEmployees\CreateEditPermissionRequest;
use App\Models\Admin;
use App\Models\Permission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PermissionController extends Controller
{
    public function index(Route $route): View
    {
        $view = str_replace("/", ".", $route->uri());
        $permissions  = Permission::all()->sortByDesc("id");
        $dataLables = [ "اسم الصلاحية", "اصحاب الصلاحية", "وقت الإنشاء", "إنشاء بواسطة", "وقت التحديث", "حدث بواسطة", "إدارة" ];
        $dataRows = [];

        foreach ($permissions AS $key => $permission){
            $dataRows[$key][] = [
                'id' => $permission->id,
                'delete' => false,
                'view' => false,
                'edit' => true
            ];

            $dataRows[$key][] = $permission->updatedBy->name ?? null;
            $dataRows[$key][] = $permission->updated_at ? $permission->updated_at->format('d M Y - H:i:s') : null;
            $dataRows[$key][] = $permission->createdBy->name ?? null;
            $dataRows[$key][] = $permission->created_at ? $permission->created_at->format('d M Y - H:i:s') : null;

            $admins = [];
            foreach ($permission->admins AS $admin) $admins[] = $admin->name;
            $dataRows[$key][] = $admins ? implode(", ", $admins) : null;

            $dataRows[$key][] = $permission->title;

        }
        return view($view, ['dataLables' => array_reverse($dataLables), 'dataRows' => $dataRows]);
    }

    public function create(CreateEditPermissionRequest $request): RedirectResponse
    {
        $permission = new Permission;
        $permission->title = $request->title;
        $permission->permissions = implode(",", $request->permissions);
        $permission->created_by = Auth::guard('admin')->user()->id;
        $permission->updated_at = null;
        $permission->save();
        return redirect()->back()->with('success', __('validation.create.success'));
    }

    public function edit($id): View
    {
        $permission = Permission::find($id);
        return view('admin.permissionsAndEmployees.permission.edit', ['permission' => $permission]);
    }

    public function update(CreateEditPermissionRequest $request, $id): RedirectResponse
    {
        $permission = Permission::find($id);
        $created_at = $permission->created_at;
        $permission->title = $request->title;
        $permission->permissions = implode(",", $request->permissions);
        $permission->updated_by = Auth::guard('admin')->user()->id;
        $permission->created_at = $created_at;
        $permission->save();
        return redirect()->back()->with('success', __('validation.update.success'));
    }

}
