@props([
    'value' => null,
    'name' => 'link',
    'required' => false,
    'label' => 'فيديو Vimeo',
])

@php
    $stored = old($name, $value);
@endphp

<div class="input-block">
    <label class="form-label" for="{{ $name }}">
        {{ $label }}
        @if ($required)
            <span class="text-danger">*</span>
        @endif
    </label>
    <input
        type="text"
        class="form-control @error($name) is-invalid @enderror"
        name="{{ $name }}"
        id="{{ $name }}"
        value="{{ $stored }}"
        @if ($required) required @endif
        placeholder="123456789 أو https://vimeo.com/123456789 أو كود embed"
        dir="ltr"
    >
    <p class="text-muted small mt-1 mb-0">
        الصق رقم فيديو Vimeo أو الرابط أو كود embed. يُحفظ في قاعدة البيانات كرقم الفيديو (ومع رمز الخصوصية إن وُجد).
        الفيديو مضبوط على Embed only — أضف نطاق الموقع في إعدادات Vimeo.
    </p>
    @error($name)
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>
