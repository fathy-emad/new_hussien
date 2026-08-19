@props([
    'action',
    'classRooms' => [],
    'academicYears' => [],
    'searchParams' => [],
])

<div class="admin-search-filters card admin-card mb-4">
    <div class="card-body">
        <h5 class="admin-search-title mb-3">عناصر البحث</h5>
        <form method="GET" action="{{ $action }}" class="admin-search-form">
            <div class="row g-3 align-items-end">
                <div class="col-md-5">
                    <label class="form-label" for="academic_year">السنة الدراسية</label>
                    <select
                        name="academic_year"
                        id="academic_year"
                        class="form-select @error('academic_year') is-invalid @enderror"
                        required
                    >
                        <option value="">اختر السنة الدراسية</option>
                        @foreach ($academicYears as $year => $label)
                            <option value="{{ $year }}"
                                @selected((string) old('academic_year', $searchParams['academic_year'] ?? '') === (string) $year)>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-5">
                    <label class="form-label" for="classroom">الصف الدراسي</label>
                    <select
                        name="classroom"
                        id="classroom"
                        class="form-select @error('classroom') is-invalid @enderror"
                        required
                    >
                        <option value="">اختر الصف الدراسي</option>
                        @foreach ($classRooms as $key => $label)
                            <option value="{{ $key }}"
                                @selected((string) old('classroom', $searchParams['classroom'] ?? '') === (string) $key)>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bx bx-search"></i> بحث
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
