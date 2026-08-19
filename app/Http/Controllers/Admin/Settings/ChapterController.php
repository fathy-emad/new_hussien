<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Concerns\PaginatesAdminTables;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Settings\CreateEditChapterRequest;
use App\Models\Chapter as LessonsHeader;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ChapterController extends Controller
{
    use PaginatesAdminTables;

    public function index(Route $route, Request $request): View
    {
        $view = str_replace('/', '.', $route->uri());
        $classRooms = getConstant('classRooms')->getArray();
        $academicYears = getAcademicYears();
        $searchParams = [
            'classroom' => $request->input('classroom'),
            'academic_year' => $request->input('academic_year'),
        ];
        $hasSearch = $request->filled('academic_year') && $request->filled('classroom');

        $data = [
            'classRooms' => $classRooms,
            'academicYears' => $academicYears,
            'searchParams' => $searchParams,
            'hasSearch' => $hasSearch,
            'dataLables' => [],
            'dataRows' => [],
            'chapters' => null,
        ];

        if ($hasSearch) {
            $chapters = $this->paginateAdminTable(
                LessonsHeader::with(['createdBy', 'updatedBy'])
                    ->where('classroom', $searchParams['classroom'])
                    ->where('academic_year', $searchParams['academic_year'])
                    ->orderBy('chapterNo'),
                $request
            );

            $dataLables = [
                'رقم الفصل',
                'اسم الفصل',
                'الصف الدراسي',
                'السنة الدراسية',
                'وقت الإنشاء',
                'أنشئ بواسطة',
                'وقت التحديث',
                'حدث بواسطة',
                'إدارة',
            ];
            $dataRows = [];

            foreach ($chapters as $key => $chapter) {
                $dataRows[$key][] = $chapter->chapterNo;
                $dataRows[$key][] = $chapter->title;
                $dataRows[$key][] = getConstant('classRooms')->getValue((int) $chapter->classroom);
                $dataRows[$key][] = $chapter->academic_year;
                $dataRows[$key][] = $chapter->created_at
                    ? $chapter->created_at->format('d M Y - H:i:s')
                    : 'لا يوجد';
                $dataRows[$key][] = $chapter->createdBy->name ?? 'لا يوجد';
                $dataRows[$key][] = $chapter->updated_at
                    ? $chapter->updated_at->format('d M Y - H:i:s')
                    : 'لا يوجد';
                $dataRows[$key][] = $chapter->updatedBy->name ?? 'لا يوجد';
                $dataRows[$key][] = [
                    'id' => $chapter->id,
                    'delete' => false,
                    'view' => false,
                    'edit' => true,
                ];
            }

            $data['chapters'] = $chapters;
            $data['dataLables'] = $dataLables;
            $data['dataRows'] = $dataRows;
        }

        return view($view, $data);
    }

    public function showCreate(Request $request): View
    {
        return view('admin.settings.chapter.create', [
            'classRooms' => getConstant('classRooms')->getArray(),
            'academicYears' => getAcademicYears(),
            'searchParams' => [
                'classroom' => $request->input('classroom'),
                'academic_year' => $request->input('academic_year'),
            ],
        ]);
    }

    public function create(CreateEditChapterRequest $request): RedirectResponse
    {
        $chapter = new LessonsHeader;
        $chapter->title = $request->title;
        $chapter->classroom = $request->classroom;
        $chapter->academic_year = $request->academic_year;
        $chapter->chapterNo = $request->chapterNo;
        $chapter->created_by = Auth::guard('admin')->user()->id;
        $chapter->updated_at = null;
        $chapter->save();

        return redirect()->route('admin.settings.chapter.index', [
            'academic_year' => $request->academic_year,
            'classroom' => $request->classroom,
        ])->with('success', 'تم إنشاء الفصل بنجاح');
    }

    public function edit($id): View
    {
        $chapter = LessonsHeader::findOrFail($id);

        return view('admin.settings.chapter.edit', [
            'chapter' => $chapter,
            'classRooms' => getConstant('classRooms')->getArray(),
            'academicYears' => getAcademicYears(),
        ]);
    }

    public function update(CreateEditChapterRequest $request, $id): RedirectResponse
    {
        $chapter = LessonsHeader::findOrFail($id);
        $created_at = $chapter->created_at;
        $chapter->title = $request->title;
        $chapter->classroom = $request->classroom;
        $chapter->academic_year = $request->academic_year;
        $chapter->chapterNo = $request->chapterNo;
        $chapter->updated_by = Auth::guard('admin')->user()->id;
        $chapter->created_at = $created_at;
        $chapter->save();

        return redirect()->route('admin.settings.chapter.index', [
            'academic_year' => $request->academic_year,
            'classroom' => $request->classroom,
        ])->with('success', 'تم تعديل الفصل بنجاح');
    }
}
