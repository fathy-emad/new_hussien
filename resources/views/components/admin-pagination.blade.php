@props([
    'paginator',
    'perPageOptions' => null,
])

@php
    $perPageOptions = $perPageOptions ?? config('admin.per_page_options', [5, 10, 15, 25, 50]);
@endphp

@if ($paginator->total() > 0)
    <div class="dash-pagination admin-pagination">
        <div class="row align-items-center g-3">
            <div class="col-lg-4 col-md-12">
                <p class="mb-0 admin-pagination-summary">
                    عرض {{ $paginator->firstItem() }} - {{ $paginator->lastItem() }}
                    من {{ $paginator->total() }} سجل
                    @if ($paginator->hasPages())
                        (صفحة {{ $paginator->currentPage() }} من {{ $paginator->lastPage() }})
                    @endif
                </p>
            </div>

            <div class="col-lg-4 col-md-6">
                <form method="GET" action="{{ url()->current() }}" class="admin-per-page-form d-flex align-items-center gap-2">
                    @foreach (request()->except(['per_page', 'page']) as $name => $value)
                        @if (is_array($value))
                            @foreach ($value as $item)
                                <input type="hidden" name="{{ $name }}[]" value="{{ $item }}">
                            @endforeach
                        @else
                            <input type="hidden" name="{{ $name }}" value="{{ $value }}">
                        @endif
                    @endforeach
                    <label for="admin_per_page_{{ $paginator->currentPage() }}" class="mb-0 text-nowrap">عدد الصفوف:</label>
                    <select
                        id="admin_per_page_{{ $paginator->currentPage() }}"
                        name="per_page"
                        class="form-select form-select-sm admin-per-page-select"
                        onchange="this.form.submit()"
                    >
                        @foreach ($perPageOptions as $size)
                            <option value="{{ $size }}" @selected($paginator->perPage() === $size)>{{ $size }}</option>
                        @endforeach
                    </select>
                </form>
            </div>

            @if ($paginator->hasPages())
                <div class="col-lg-4 col-md-6">
                    <div class="d-flex justify-content-lg-end">
                        {{ $paginator->links('vendor.pagination.admin') }}
                    </div>
                </div>
            @else
                <div class="col-lg-4 col-md-6"></div>
            @endif
        </div>
    </div>
@endif
