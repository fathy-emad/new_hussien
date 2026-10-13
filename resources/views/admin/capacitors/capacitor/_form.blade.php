@php
    $model = $model ?? null;
    $classRooms = $classRooms ?? [];
    $searchParams = $searchParams ?? [];
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
                        @selected((string) old('classroom', $model?->classroom ?? $searchParams['classroom'] ?? '') === (string) $key)
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
            <label class="form-label" for="watch_times">عدد مرات المشاهدة <span class="text-danger">*</span></label>
            <input
                type="number"
                class="form-control @error('watch_times') is-invalid @enderror"
                name="watch_times"
                id="watch_times"
                value="{{ old('watch_times', $model?->watch_times ?? 1) }}"
                min="1"
                required
            >
            @error('watch_times')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-12">
        <div class="input-block mb-3">
            <label class="form-label" for="title">اسم الدرس <span class="text-danger">*</span></label>
            <input
                type="text"
                class="form-control @error('title') is-invalid @enderror"
                name="title"
                id="title"
                value="{{ old('title', $model?->title) }}"
                required
            >
            @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-12">
        <x-admin-vimeo-field :value="$model?->link" required />
    </div>
    <div class="col-12">
        <div class="input-block mb-3">
            <label class="form-label" for="description">وصف الدرس</label>
            <textarea
                class="form-control @error('description') is-invalid @enderror"
                name="description"
                id="description"
                rows="4"
            >{{ old('description', $model?->description) }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-12">
        <x-admin-dropzone
            id="offline_images"
            label="صور الدرس"
            title="اضغط لإضافة صور"
            description="يمكن رفع عدة صور"
        >
            @error('images')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </x-admin-dropzone>
    </div>
    <div class="col-12">
        @php
            $storedPdfCsv = implodeUploadedFilenames(old('pdf', $model?->pdf ?? []));
        @endphp
        <x-admin-dropzone
            id="offline_pdf"
            label="مرفقات الدرس (PDF)"
            title="اضغط لإضافة الملفات"
            description="ملفات PDF أو DOC"
        >
            @error('pdf')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
            <div class="mt-2">
                <input
                    type="text"
                    class="form-control form-control-sm admin-csv-display"
                    id="offline_pdf_csv_display"
                    value="{{ $storedPdfCsv }}"
                    readonly
                >
            </div>
        </x-admin-dropzone>
    </div>
    <div class="col-md-6">
        <div class="form-check mt-2">
            <input
                type="checkbox"
                class="form-check-input"
                name="active"
                id="active"
                value="1"
                @checked(old('active', $model?->active ?? 1))
            >
            <label class="form-check-label" for="active">نشط</label>
        </div>
    </div>
</div>
