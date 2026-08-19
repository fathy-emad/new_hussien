@php
    $exam = $exam ?? null;
    $classRooms = $classRooms ?? [];
    $searchParams = $searchParams ?? [];
    $bankQuestions = $bankQuestions ?? collect();
    $selectedQuestions = old('questions', $exam?->questions ?? []);
    if (! is_array($selectedQuestions)) {
        $selectedQuestions = [];
    }
    $selectedQuestions = array_map('strval', $selectedQuestions);
@endphp

<div class="row">
    <div class="col-md-6">
        <div class="input-block mb-3">
            <label class="form-label" for="classroom">الصف الدراسي <span class="text-danger">*</span></label>
            <select
                name="classroom"
                id="classroom"
                class="form-select @error('classroom') is-invalid @enderror"
                required
            >
                <option value="">اختر الصف الدراسي</option>
                @foreach ($classRooms as $key => $label)
                    <option
                        value="{{ $key }}"
                        @selected((string) old('classroom', $exam?->classroom ?? $searchParams['classroom'] ?? '') === (string) $key)
                    >
                        {{ $label }}
                    </option>
                @endforeach
            </select>
            @error('classroom')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="input-block mb-3">
            <label class="form-label" for="title">عنوان الامتحان <span class="text-danger">*</span></label>
            <input
                type="text"
                class="form-control @error('title') is-invalid @enderror"
                name="title"
                id="title"
                value="{{ old('title', $exam?->title) }}"
                required
            >
            @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="input-block mb-3">
            <label class="form-label" for="day">يوم الامتحان <span class="text-danger">*</span></label>
            <input
                type="date"
                class="form-control @error('day') is-invalid @enderror"
                name="day"
                id="day"
                value="{{ old('day', $exam?->day ? $exam->day->format('Y-m-d') : '') }}"
                required
            >
            @error('day')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="input-block mb-3">
            <label class="form-label" for="time">مدة الامتحان (بالدقائق) <span class="text-danger">*</span></label>
            <input
                type="number"
                class="form-control @error('time') is-invalid @enderror"
                name="time"
                id="time"
                value="{{ old('time', $exam?->time) }}"
                min="1"
                required
            >
            @error('time')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-12">
        <div class="input-block mb-3">
            <label class="form-label">أسئلة الامتحان <span class="text-danger">*</span></label>
            @if ($bankQuestions->isEmpty())
                <div class="alert alert-warning mb-0">
                    لا توجد أسئلة في بنك الأسئلة لهذا الصف.
                    <a href="{{ route('admin.exams.question.create', $searchParams) }}">أضف سؤالاً أولاً</a>
                </div>
            @else
                <div class="border rounded p-3 admin-exam-questions-list">
                    @foreach ($bankQuestions as $bankQuestion)
                        <div class="form-check mb-2">
                            <input
                                type="checkbox"
                                class="form-check-input @error('questions') is-invalid @enderror"
                                name="questions[]"
                                id="question_{{ $bankQuestion->id }}"
                                value="{{ $bankQuestion->id }}"
                                @checked(in_array((string) $bankQuestion->id, $selectedQuestions, true))
                            >
                            <label class="form-check-label" for="question_{{ $bankQuestion->id }}">
                                {{ Str::limit($bankQuestion->question, 120) }}
                            </label>
                        </div>
                    @endforeach
                </div>
            @endif
            @error('questions')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
            @error('questions.*')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const classroomSelect = document.getElementById('classroom');
            if (! classroomSelect) {
                return;
            }

            classroomSelect.addEventListener('change', function () {
                const classroom = classroomSelect.value;
                if (! classroom) {
                    return;
                }
                const url = new URL(window.location.href);
                url.searchParams.set('classroom', classroom);
                window.location.href = url.toString();
            });
        });
    </script>
@endpush
