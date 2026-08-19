@props([
    'id',
    'read' => false,
    'showLabel' => true,
])

@if ($read)
    <div class="form-check mb-0">
        <input
            type="checkbox"
            class="form-check-input"
            id="website_ask_read_{{ $id }}"
            checked
            disabled
        >
        @if ($showLabel)
            <label class="form-check-label text-muted" for="website_ask_read_{{ $id }}">مقروء</label>
        @endif
    </div>
@else
    <form
        method="POST"
        action="{{ route('admin.website.requests.toggle-read', $id) }}"
        class="admin-read-toggle-form d-inline-block"
    >
        @csrf
        <input type="hidden" name="is_read" value="1">
        <div class="form-check mb-0">
            <input
                type="checkbox"
                class="form-check-input"
                id="website_ask_read_{{ $id }}"
                value="1"
                onchange="this.form.submit()"
            >
            @if ($showLabel)
                <label class="form-check-label" for="website_ask_read_{{ $id }}">مقروء</label>
            @endif
        </div>
    </form>
@endif
