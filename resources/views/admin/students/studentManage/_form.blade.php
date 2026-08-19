@php
    $student = $student ?? null;
    $searchParams = $searchParams ?? [];
    $isEdit = $student !== null;
@endphp

<div class="row">
    <div class="col-md-4">
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
                    <option value="{{ $year }}"
                        @selected((string) old('academic_year', $student?->academic_year ?? $searchParams['academic_year'] ?? '') === (string) $year)>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
            @error('academic_year')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-4">
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
                    <option value="{{ $key }}"
                        @selected((string) old('classroom', $student?->classroom ?? $searchParams['classroom'] ?? '') === (string) $key)>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
            @error('classroom')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-4">
        <div class="input-block">
            <label class="form-label" for="center_id">السنتر <span class="text-danger">*</span></label>
            <select
                name="center_id"
                id="center_id"
                class="form-select @error('center_id') is-invalid @enderror"
                required
            >
                <option value="">اختر السنتر</option>
                @foreach ($centers as $center)
                    <option value="{{ $center->id }}"
                        @selected((string) old('center_id', $student?->center_id ?? $searchParams['center_id'] ?? '') === (string) $center->id)>
                        {{ $center->title }}
                    </option>
                @endforeach
            </select>
            @error('center_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-8">
        <div class="input-block">
            <label class="form-label" for="name">اسم الطالب <span class="text-danger">*</span></label>
            <input
                type="text"
                class="form-control @error('name') is-invalid @enderror"
                name="name"
                id="name"
                value="{{ old('name', $student?->name) }}"
                required
            >
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-4">
        <div class="input-block">
            <label class="form-label" for="gender">النوع</label>
            <select name="gender" id="gender" class="form-select @error('gender') is-invalid @enderror">
                <option value="">—</option>
                @foreach ($genders as $key => $label)
                    <option value="{{ $key }}"
                        @selected((string) old('gender', $student?->gender ?? '') === (string) $key)>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
            @error('gender')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-4">
        <div class="input-block">
            <label class="form-label" for="phone">رقم الموبايل <span class="text-danger">*</span></label>
            <input
                type="text"
                class="form-control @error('phone') is-invalid @enderror"
                name="phone"
                id="phone"
                value="{{ old('phone', $student?->phone) }}"
                required
                maxlength="11"
            >
            @error('phone')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-4">
        <div class="input-block">
            <label class="form-label" for="father_phone">رقم ولى الأمر <span class="text-danger">*</span></label>
            <input
                type="text"
                class="form-control @error('father_phone') is-invalid @enderror"
                name="father_phone"
                id="father_phone"
                value="{{ old('father_phone', $student?->father_phone) }}"
                required
                maxlength="11"
            >
            @error('father_phone')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-4">
        <div class="input-block">
            <label class="form-label" for="whatsApp">واتساب</label>
            <input
                type="text"
                class="form-control @error('whatsApp') is-invalid @enderror"
                name="whatsApp"
                id="whatsApp"
                value="{{ old('whatsApp', $student?->whatsApp) }}"
                maxlength="11"
            >
            @error('whatsApp')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="input-block">
            <label class="form-label" for="email">البريد الإلكتروني</label>
            <input
                type="email"
                class="form-control @error('email') is-invalid @enderror"
                name="email"
                id="email"
                value="{{ old('email', $student?->email) }}"
            >
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="input-block">
            <label class="form-label" for="password">
                كلمة المرور
                @if (! $isEdit)
                    <span class="text-danger">*</span>
                @endif
            </label>
            <input
                type="password"
                class="form-control @error('password') is-invalid @enderror"
                name="password"
                id="password"
                @if (! $isEdit) required @endif
                minlength="6"
                autocomplete="new-password"
            >
            @if ($isEdit)
                <small class="text-muted">اتركه فارغاً إذا لم ترد تغيير كلمة المرور</small>
            @endif
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    @if ($isEdit)
        <div class="col-12">
            <div class="alert alert-info mb-0">
                <strong>كود الطالب:</strong> <code>{{ $student->code }}</code>
            </div>
        </div>
    @endif
    <div class="col-12">
        <label class="form-label d-block">المطبوعات</label>
        <div class="d-flex flex-wrap gap-3">
            @foreach ([
                'material_one' => 'المطبوعات الأولى',
                'material_two' => 'المطبوعات الثانية',
                'material_three' => 'المطبوعات الثالثة',
                'material_four' => 'المطبوعات الرابعة',
            ] as $field => $label)
                <div class="form-check">
                    <input
                        type="checkbox"
                        class="form-check-input"
                        name="{{ $field }}"
                        id="{{ $field }}"
                        value="1"
                        @checked(old($field, $student?->$field ?? 0))
                    >
                    <label class="form-check-label" for="{{ $field }}">{{ $label }}</label>
                </div>
            @endforeach
        </div>
    </div>
    <div class="col-12">
        <x-admin-dropzone
            id="avatar"
            label="صورة الطالب"
            title="اضغط لرفع الصورة"
            description="صورة شخصية للطالب"
        >
            @error('avatar')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </x-admin-dropzone>
    </div>
</div>
