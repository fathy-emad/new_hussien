@php
    $lesson = $lesson ?? null;
    $chapter = $chapter ?? null;
    $searchParams = $searchParams ?? [];
    $selectedChapterId = old('chapter_id', $lesson?->chapter_id ?? $searchParams['chapter_id'] ?? $chapter?->id ?? '');
    $lockContext = $lesson !== null || ! empty($selectedChapterId);
    $chapterLabel = $chapter
        ? $chapter->title.' ('.$chapter->academic_year.')'
        : '—';
    $classroomLabel = $chapter && isset($classRooms[(int) $chapter->classroom])
        ? $classRooms[(int) $chapter->classroom]
        : '—';
@endphp

@if ($lockContext)
    <input type="hidden" name="chapter_id" value="{{ $selectedChapterId }}">

    <x-admin-lesson-context
        :chapter-label="$chapterLabel"
        :classroom-label="$classroomLabel"
        :mode="$lesson ? 'edit' : 'create'"
    />
@endif

<div class="row">
    <div class="col-md-4">
        <div class="input-block">
            <label class="form-label" for="NO">رقم الدرس <span class="text-danger">*</span></label>
            <input
                type="number"
                class="form-control @error('NO') is-invalid @enderror"
                name="NO"
                id="NO"
                value="{{ old('NO', $lesson?->NO) }}"
                required
                min="1"
            >
            @error('NO')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-8">
        <div class="input-block">
            <label class="form-label" for="title">اسم الدرس <span class="text-danger">*</span></label>
            <input
                type="text"
                class="form-control @error('title') is-invalid @enderror"
                name="title"
                id="title"
                value="{{ old('title', $lesson?->title) }}"
                required
            >
            @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-4">
        <div class="input-block">
            <label class="form-label" for="watchTimes">عدد مرات المشاهدة <span class="text-danger">*</span></label>
            <input
                type="number"
                class="form-control @error('watchTimes') is-invalid @enderror"
                name="watchTimes"
                id="watchTimes"
                value="{{ old('watchTimes', $lesson?->watchTimes ?? 0) }}"
                required
                min="0"
                placeholder="مثال: 3"
            >
            @error('watchTimes')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-12">
        <x-admin-vimeo-field :value="$lesson?->link" />
    </div>
    <div class="col-12">
        <div class="input-block">
            <label class="form-label" for="info">وصف الدرس</label>
            <textarea
                class="form-control @error('info') is-invalid @enderror"
                name="info"
                id="info"
                rows="5"
                placeholder="وصف الدرس"
            >{{ old('info', $lesson?->info) }}</textarea>
            @error('info')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-12">
        <x-admin-dropzone
            id="images"
            label="صور الدرس"
            title="اضغط لإضافة صور"
            description="يمكن رفع عدة صور (قيم مفصولة بفاصلة عند الحفظ)"
        >
            @error('images')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </x-admin-dropzone>
    </div>
    <div class="col-12">
        @php
            $storedPdfCsv = implodeUploadedFilenames(old('pdf', $lesson?->pdf ?? []));
        @endphp
        <x-admin-dropzone
            id="pdf"
            label="مرفقات الدرس (PDF)"
            title="اضغط لإضافة الملفات"
            description="ملفات PDF أو DOC — تُحفظ في قاعدة البيانات كقيم مفصولة بفاصلة"
        >
            @error('pdf')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
            <div class="mt-2">
                <label class="form-label small mb-1" for="lesson_pdf_csv_display">القيمة المحفوظة (pdf — مفصولة بفاصلة)</label>
                <input
                    type="text"
                    class="form-control form-control-sm admin-csv-display"
                    id="lesson_pdf_csv_display"
                    value="{{ $storedPdfCsv }}"
                    readonly
                    placeholder="سيظهر هنا بعد رفع الملفات — مثال: 1710000001_abc.pdf,1710000002_def.pdf"
                >
                <p id="lesson_pdf_csv_display_hint" class="text-muted small mt-1 mb-0 {{ $storedPdfCsv ? '' : 'd-none' }}">
                    @if ($storedPdfCsv)
                        سيتم حفظ {{ count(explodeUploadedFilenames($storedPdfCsv)) }} ملف في عمود pdf: {{ $storedPdfCsv }}
                    @endif
                </p>
            </div>
        </x-admin-dropzone>
    </div>
</div>
