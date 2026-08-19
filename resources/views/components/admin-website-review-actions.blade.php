@props([
    'id',
    'approved' => false,
])

<div class="admin-table-actions d-flex flex-wrap gap-1">
    <button
        type="button"
        class="btn btn-sm btn-outline-secondary admin-review-view-btn"
        data-review-id="{{ $id }}"
    >
        <i class="bx bx-show"></i> عرض
    </button>

    <a href="{{ route('admin.website.reviews.edit', $id) }}" class="btn btn-sm btn-outline-primary">
        <i class="bx bx-edit"></i> تعديل
    </a>

    @if (! $approved)
        <form method="POST" action="{{ route('admin.website.reviews.approve', $id) }}" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-sm btn-outline-success">
                <i class="bx bx-check"></i> اعتماد
            </button>
        </form>
    @else
        <form method="POST" action="{{ route('admin.website.reviews.reject', $id) }}" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-sm btn-outline-warning">
                <i class="bx bx-x"></i> إلغاء الاعتماد
            </button>
        </form>
    @endif

    <form
        method="POST"
        action="{{ route('admin.website.reviews.delete', $id) }}"
        class="d-inline"
        onsubmit="return confirm('هل أنت متأكد من حذف هذا الرأي؟');"
    >
        @csrf
        <button type="submit" class="btn btn-sm btn-outline-danger">
            <i class="bx bx-trash"></i> حذف
        </button>
    </form>
</div>
