@props([
    'id',
    'label' => null,
    'title' => 'اضغط لرفع الملف',
    'description' => '',
    'required' => false,
])

<div {{ $attributes->merge(['class' => 'input-block']) }}>
    @if ($label)
        <label class="form-label" for="{{ $id }}">
            {{ $label }}
            @if ($required)
                <span class="text-danger">*</span>
            @endif
        </label>
    @endif

    <div class="dropzone admin-dropzone" id="{{ $id }}">
        <div class="dz-message">
            <h5 class="dropzone-msg-title">{{ $title }}</h5>
            @if ($description)
                <span class="dropzone-msg-desc">{{ $description }}</span>
            @endif
        </div>
    </div>

    {{ $slot }}
</div>
