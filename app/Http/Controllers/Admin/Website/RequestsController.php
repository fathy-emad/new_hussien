<?php

namespace App\Http\Controllers\Admin\Website;

use App\Http\Controllers\Concerns\PaginatesAdminTables;
use App\Http\Controllers\Controller;
use App\Models\WebsiteAsks;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Str;
use Illuminate\View\View;

class RequestsController extends Controller
{
    use PaginatesAdminTables;

    public function view($id): View
    {
        $ask = WebsiteAsks::findOrFail($id);

        return view('admin.website.requests.view', [
            'ask' => $ask,
        ]);
    }

    public function index(Route $route, Request $request): View
    {
        $view = str_replace('/', '.', $route->uri());
        $asks = $this->paginateAdminTable(
            WebsiteAsks::query()->orderByDesc('id'),
            $request
        );

        $dataLables = [
            'رقم الهاتف',
            'الاستفسار',
            'وقت الإرسال',
            'مقروء',
            'إدارة',
        ];
        $dataRows = [];

        foreach ($asks as $key => $ask) {
            $dataRows[$key][] = $ask->phone ?: '—';
            $dataRows[$key][] = Str::limit($ask->content, 80);
            $dataRows[$key][] = $ask->created_at
                ? $ask->created_at->format('d M Y - H:i:s')
                : '—';
            $dataRows[$key][] = [
                'html' => view('components.admin-website-request-read-toggle', [
                    'id' => $ask->id,
                    'read' => (bool) $ask->is_read,
                ])->render(),
            ];
            $dataRows[$key][] = [
                'id' => $ask->id,
                'delete' => true,
                'view' => true,
                'edit' => false,
                'viewLabel' => 'عرض',
            ];
        }

        return view($view, [
            'dataLables' => $dataLables,
            'dataRows' => $dataRows,
            'asks' => $asks,
        ]);
    }

    public function toggleRead(Request $request, $id): RedirectResponse
    {
        $ask = WebsiteAsks::findOrFail($id);

        if ($ask->is_read) {
            return redirect()->back();
        }

        $ask->is_read = true;
        $ask->save();

        return redirect()->back()->with('success', 'تم تعليم الاستفسار كمقروء');
    }

    public function delete($id): RedirectResponse
    {
        WebsiteAsks::findOrFail($id)->delete();

        return redirect()
            ->route('admin.website.requests.index')
            ->with('success', 'تم حذف الاستفسار بنجاح');
    }
}
