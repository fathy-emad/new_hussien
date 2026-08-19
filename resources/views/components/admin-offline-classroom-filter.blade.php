@props([
    'action',
    'classRooms' => [],
    'searchParams' => [],
])

<div class="admin-search-filters card admin-card mb-4">
    <div class="card-body">
        <h5 class="admin-search-title mb-3">عناصر البحث</h5>
        <form method="GET" action="{{ $action }}" class="admin-search-form">
            <div class="row g-3 align-items-end">
                <div class="col-md-6">
                    <label class="form-label" for="offline_classroom">الصف الدراسي <span class="text-danger">*</span></label>
                    <select
                        name="classroom"
                        id="offline_classroom"
                        class="form-select @error('classroom') is-invalid @enderror"
                        required
                    >
                        <option value="">اختر الصف الدراسي</option>
                        @foreach ($classRooms as $key => $label)
                            <option value="{{ $key }}" @selected((string) ($searchParams['classroom'] ?? '') === (string) $key)>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('classroom')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 d-flex flex-wrap gap-2">
                    <button type="submit" class="btn btn-primary">بحث</button>
                    @if (! empty($searchParams['classroom']))
                        <a href="{{ $action }}" class="btn btn-outline-secondary">إعادة تعيين</a>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>
