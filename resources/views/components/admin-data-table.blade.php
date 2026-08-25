@props([
    'dataLables' => [],
    'dataRows' => [],
    'editRoute' => null,
    'viewRoute' => null,
    'deleteRoute' => null,
    'downloadRoute' => null,
    'deleteConfirm' => 'هل أنت متأكد من حذف هذا السجل؟',
    'viewConfirm' => 'سيتم توليد كروت هذا الباتش. قد يستغرق بعض الوقت. هل تريد المتابعة؟',
    'emptyMessage' => 'لا توجد سجلات حالياً.',
    /** LengthAwarePaginator — pass from controller via paginateAdminTable() */
    'paginator' => null,
    'perPageOptions' => null,
])

<div class="instructor-course-table admin-data-table">
    <div class="admin-table-scroll-wrap">
        <div class="admin-table-scroll-top" tabindex="-1" aria-hidden="true">
            <div class="admin-table-scroll-top-inner"></div>
        </div>
        <div class="table-responsive custom-table admin-table-scroll-body">
            <table class="table table-nowrap mb-0">
            <thead>
                <tr>
                    @foreach ($dataLables as $label)
                        <th>{{ $label }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @forelse ($dataRows as $row)
                    <tr>
                        @foreach ($row as $cell)
                            <td>
                                @if (is_array($cell) && array_key_exists('id', $cell))
                                    <div class="admin-table-actions d-flex flex-wrap gap-1">
                                        @if ($downloadRoute && (($cell['download'] ?? false) || ($cell['awaitDownload'] ?? false)))
                                            <a href="{{ route($downloadRoute, $cell['id']) }}"
                                                class="btn btn-sm btn-outline-success {{ ($cell['download'] ?? false) ? '' : 'd-none' }}"
                                                @if ($cell['awaitDownload'] ?? false) data-card-download="{{ $cell['id'] }}" @endif>
                                                <i class="bx bx-download"></i> تحميل
                                            </a>
                                        @endif
                                        @if (($cell['view'] ?? false) && $viewRoute)
                                            <a href="{{ route($viewRoute, $cell['id']) }}"
                                                class="btn btn-sm btn-outline-secondary"
                                                @if ($viewConfirm)
                                                    onclick="return confirm(@json($viewConfirm));"
                                                @endif>
                                                <i class="bx bx-id-card"></i> {{ $cell['viewLabel'] ?? 'عرض' }}
                                            </a>
                                        @endif
                                        @if (($cell['edit'] ?? false) && $editRoute)
                                            <a href="{{ route($editRoute, $cell['id']) }}"
                                                class="btn btn-sm btn-outline-primary">
                                                <i class="bx bx-edit"></i> تعديل
                                            </a>
                                        @endif
                                        @if (($cell['delete'] ?? false) && $deleteRoute)
                                            <form
                                                method="POST"
                                                action="{{ route($deleteRoute, $cell['id']) }}"
                                                class="d-inline"
                                                onsubmit="return confirm(@json($deleteConfirm));"
                                            >
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="bx bx-trash"></i> حذف
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                @elseif (is_array($cell) && array_key_exists('html', $cell))
                                    <div class="admin-table-html">{!! $cell['html'] !!}</div>
                                @else
                                    {{ $cell ?? '—' }}
                                @endif
                            </td>
                        @endforeach
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ max(count($dataLables), 1) }}" class="text-center text-muted py-4">
                            {{ $emptyMessage }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        </div>
    </div>

    @if ($paginator)
        <x-admin-pagination :paginator="$paginator" :per-page-options="$perPageOptions" />
    @endif
</div>

@once
    @push('scripts')
        <script src="{{ asset('build/js/admin/admin-table-scroll.js') }}"></script>
    @endpush
@endonce
