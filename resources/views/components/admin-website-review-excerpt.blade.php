@props([
    'id',
    'excerpt',
])

<button
    type="button"
    class="btn btn-link p-0 text-start text-body admin-review-view-btn text-truncate d-inline-block"
    style="max-width: 220px;"
    data-review-id="{{ $id }}"
    title="عرض الرأي كاملاً"
>
    {{ $excerpt }}
</button>
