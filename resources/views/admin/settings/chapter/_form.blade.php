@php
    $chapter = $chapter ?? null;
    $searchParams = $searchParams ?? [];
    $selectedClassroom = old('classroom', $chapter?->classroom ?? $searchParams['classroom'] ?? '');
    $selectedYear = old('academic_year', $chapter?->academic_year ?? $searchParams['academic_year'] ?? '');
    $lockContext = $chapter !== null
        || (! empty($selectedYear) && $selectedClassroom !== '' && $selectedClassroom !== null);
    $classroomLabel = $lockContext && isset($classRooms[(int) $selectedClassroom])
        ? $classRooms[(int) $selectedClassroom]
        : ($selectedClassroom ?: '—');
@endphp

@if ($lockContext)
    <input type="hidden" name="academic_year" value="{{ $selectedYear }}">
    <input type="hidden" name="classroom" value="{{ $selectedClassroom }}">

    <x-admin-chapter-context
        :academic-year="$selectedYear"
        :classroom-label="$classroomLabel"
        :mode="$chapter ? 'edit' : 'create'"
    />
@endif

<div class="row">
    <div class="col-md-6">
        <div class="input-block">
            <label class="form-label" for="chapterNo">رقم الفصل <span class="text-danger">*</span></label>
            <input
                type="number"
                class="form-control @error('chapterNo') is-invalid @enderror"
                name="chapterNo"
                id="chapterNo"
                value="{{ old('chapterNo', $chapter?->chapterNo) }}"
                required
                min="1"
            >
            @error('chapterNo')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="input-block">
            <label class="form-label" for="title">اسم الفصل <span class="text-danger">*</span></label>
            <input
                type="text"
                class="form-control @error('title') is-invalid @enderror"
                name="title"
                id="title"
                value="{{ old('title', $chapter?->title) }}"
                required
            >
            @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    @unless ($lockContext)
        <div class="col-md-6">
            <div class="input-block">
                <label class="form-label" for="academic_year">السنة الدراسية <span class="text-danger">*</span></label>
                <select
                    name="academic_year"
                    id="academic_year"
                    class="form-select @error('academic_year') is-invalid @enderror"
                    required
                >
                    <option value="">اختر السنة الدراسية</option>
                    @foreach ($academicYears as $year => $label)
                        <option value="{{ $year }}" @selected((string) $selectedYear === (string) $year)>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
                @error('academic_year')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="input-block">
                <label class="form-label" for="classroom">الصف الدراسي <span class="text-danger">*</span></label>
                <select
                    name="classroom"
                    id="classroom"
                    class="form-select @error('classroom') is-invalid @enderror"
                    required
                >
                    <option value="">اختر الصف الدراسي</option>
                    @foreach ($classRooms as $key => $label)
                        <option value="{{ $key }}" @selected((string) $selectedClassroom === (string) $key)>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
                @error('classroom')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    @endunless
</div>
