<?php

namespace App\Http\Controllers\Admin\Capacitors;

use App\Http\Controllers\Concerns\PaginatesAdminTables;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Capacitors\CreateEditCapacitorRequest;
use App\Models\Capacitor;
use App\Support\VimeoVideo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CapacitorController extends Controller
{
    use PaginatesAdminTables;

    public function view($id): View
    {
        $model = Capacitor::findOrFail($id);
        $classRooms = getConstant('classRooms')->getArray();
        $hasVideo = VimeoVideo::hasVideo($model->link);

        $images = $this->buildAttachmentList($model->images, 'uploads/capacitors/lessons/images');
        $pdfs = $this->buildAttachmentList($model->pdf, 'uploads/capacitors/lessons/files');

        return view('admin.capacitors.capacitor.view', [
            'model' => $model,
            'classRooms' => $classRooms,
            'searchParams' => ['classroom' => $model->classroom],
            'hasVideo' => $hasVideo,
            'images' => $images,
            'pdfs' => $pdfs,
        ]);
    }

    public function index(Route $route, Request $request): View
    {
        $view = str_replace('/', '.', $route->uri());
        $classRooms = getConstant('classRooms')->getArray();
        $searchParams = ['classroom' => $request->classroom];

        if (empty($request->classroom)) {
            return view($view, [
                'classRooms' => $classRooms,
                'searchParams' => [],
                'hasSearch' => false,
            ]);
        }

        $capacitors = $this->paginateAdminTable(
            Capacitor::query()
                ->with(['createdBy', 'updatedBy'])
                ->where('classroom', $request->classroom)
                ->orderByDesc('id'),
            $request
        );

        $dataLables = [
            'اسم الدرس',
            'عدد مرات المشاهدة',
            'وقت الإنشاء',
            'إنشاء بواسطة',
            'وقت التحديث',
            'حدث بواسطة',
            'إدارة',
        ];
        $dataRows = [];

        foreach ($capacitors as $key => $model) {
            $dataRows[$key][] = $model->title;
            $dataRows[$key][] = $model->watch_times ?: 1;
            $dataRows[$key][] = $model->created_at ? $model->created_at->format('d M Y - H:i:s') : '—';
            $dataRows[$key][] = $model->createdBy->name ?? '—';
            $dataRows[$key][] = $model->updated_at ? $model->updated_at->format('d M Y - H:i:s') : '—';
            $dataRows[$key][] = $model->updatedBy->name ?? '—';
            $dataRows[$key][] = [
                'id' => $model->id,
                'delete' => true,
                'view' => true,
                'edit' => true,
            ];
        }

        return view($view, [
            'dataLables' => $dataLables,
            'dataRows' => $dataRows,
            'capacitors' => $capacitors,
            'classRooms' => $classRooms,
            'searchParams' => $searchParams,
            'hasSearch' => true,
        ]);
    }

    public function showCreate(Request $request): View
    {
        $classRooms = getConstant('classRooms')->getArray();

        return view('admin.capacitors.capacitor.create', [
            'classRooms' => $classRooms,
            'searchParams' => ['classroom' => $request->classroom],
        ]);
    }

    public function create(CreateEditCapacitorRequest $request): RedirectResponse
    {
        $model = new Capacitor;
        $model->title = $request->title;
        $model->link = VimeoVideo::normalize($request->input('link')) ?? '';

        $model->watch_times = $request->watch_times;
        $model->description = $request->description;
        $model->classroom = $request->classroom;
        $model->images = implodeUploadedFilenames($request->images ?? []);
        $model->pdf = implodeUploadedFilenames($request->pdf ?? []);
        $model->active = $request->active ?? 0;
        $model->created_by = Auth::guard('admin')->user()->id;
        $model->updated_at = null;
        $model->save();

        return redirect()
            ->route('admin.capacitors.capacitor.index', ['classroom' => $request->classroom])
            ->with('success', 'تم إنشاء درس Offline بنجاح — تم حفظ الفيديو: '.$model->link);
    }

    public function edit($id): View
    {
        $model = Capacitor::findOrFail($id);
        $classRooms = getConstant('classRooms')->getArray();
        $images = [];
        foreach (explode(',', (string) $model->images) as $image) {
            $image = trim($image);
            if ($image === '') {
                continue;
            }
            $file = public_path("uploads/capacitors/lessons/images/$image");
            if (is_file($file)) {
                $images[] = [
                    'file' => asset("uploads/capacitors/lessons/images/$image"),
                    'name' => $image,
                    'size' => filesize($file),
                    'type' => mime_content_type($file),
                ];
            }
        }

        $pdfs = [];
        foreach (explode(',', (string) $model->pdf) as $pdf) {
            $pdf = trim($pdf);
            if ($pdf === '') {
                continue;
            }
            $file = public_path("uploads/capacitors/lessons/files/$pdf");
            if (is_file($file)) {
                $pdfs[] = [
                    'file' => asset("uploads/capacitors/lessons/files/$pdf"),
                    'name' => $pdf,
                    'size' => filesize($file),
                    'type' => mime_content_type($file),
                ];
            }
        }

        return view('admin.capacitors.capacitor.edit', [
            'model' => $model,
            'classRooms' => $classRooms,
            'searchParams' => ['classroom' => $model->classroom],
            'attachments' => [
                'images' => $images,
                'pdf' => $pdfs,
            ],
        ]);
    }

    public function update(CreateEditCapacitorRequest $request, $id): RedirectResponse
    {
        $model = Capacitor::findOrFail($id);
        $created_at = $model->created_at;
        $model->title = $request->title;
        $model->link = VimeoVideo::normalize($request->input('link')) ?? $model->link;

        $model->watch_times = $request->watch_times;
        $model->description = $request->description;
        $model->classroom = $request->classroom;
        $model->images = implodeUploadedFilenames($request->images ?? []);
        $model->pdf = implodeUploadedFilenames($request->pdf ?? []);
        $model->active = $request->active ?? 0;
        $model->updated_by = Auth::guard('admin')->user()->id;
        $model->created_at = $created_at;
        $model->save();

        return redirect()
            ->route('admin.capacitors.capacitor.index', ['classroom' => $model->classroom])
            ->with('success', 'تم تعديل درس Offline بنجاح');
    }

    public function delete($id): RedirectResponse
    {
        $model = Capacitor::findOrFail($id);
        $classroom = $model->classroom;
        DB::table('capacitors')->where('id', $id)->delete();

        return redirect()
            ->route('admin.capacitors.capacitor.index', ['classroom' => $classroom])
            ->with('success', 'تم حذف درس Offline بنجاح');
    }

    private function buildAttachmentList(?string $csv, string $publicSubPath): array
    {
        $items = [];
        foreach (explodeUploadedFilenames($csv) as $filename) {
            $file = public_path("$publicSubPath/$filename");
            if (! is_file($file)) {
                continue;
            }
            $items[] = [
                'name' => $filename,
                'url' => asset("$publicSubPath/$filename"),
                'size' => filesize($file),
            ];
        }

        return $items;
    }

}
