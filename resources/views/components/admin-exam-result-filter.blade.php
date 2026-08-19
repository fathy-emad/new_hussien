@props([
    'action',
    'classRooms' => [],
    'examsForClassroom' => [],
    'searchParams' => [],
])

<div class="admin-search-filters card admin-card mb-4">
    <div class="card-body">
        <h5 class="admin-search-title mb-3">عناصر البحث</h5>
        <form method="GET" action="{{ $action }}" class="admin-search-form">
            <div class="row g-3 align-items-end">
                <div class="col-md-5">
                    <label class="form-label" for="result_classroom">الصف الدراسي <span class="text-danger">*</span></label>
                    <select
                        name="classroom"
                        id="result_classroom"
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
                <div class="col-md-5">
                    <label class="form-label" for="result_exam_id">الامتحان <span class="text-danger">*</span></label>
                    <select
                        name="exam_id"
                        id="result_exam_id"
                        class="form-select @error('exam_id') is-invalid @enderror"
                        required
                        @disabled(empty($searchParams['classroom']))
                    >
                        <option value="">اختر الامتحان</option>
                        @foreach ($examsForClassroom as $examItem)
                            <option
                                value="{{ $examItem->id }}"
                                @selected((string) ($searchParams['exam_id'] ?? '') === (string) $examItem->id)
                            >
                                {{ $examItem->title }}
                                @if ($examItem->day)
                                    — {{ $examItem->day->format('d M Y') }}
                                @endif
                            </option>
                        @endforeach
                    </select>
                    @error('exam_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-2 d-flex flex-wrap gap-2">
                    <button type="submit" class="btn btn-primary">بحث</button>
                    @if (! empty($searchParams['classroom']) || ! empty($searchParams['exam_id']))
                        <a href="{{ $action }}" class="btn btn-outline-secondary">إعادة تعيين</a>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const classroomSelect = document.getElementById('result_classroom');
            if (! classroomSelect) {
                return;
            }

            classroomSelect.addEventListener('change', function () {
                const classroom = classroomSelect.value;
                const url = new URL(@json($action), window.location.origin);
                if (classroom) {
                    url.searchParams.set('classroom', classroom);
                }
                window.location.href = url.toString();
            });
        });
    </script>
@endpush
