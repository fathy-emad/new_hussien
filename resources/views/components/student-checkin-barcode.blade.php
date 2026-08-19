@props([
    'code',
    'barcode',
    'title' => 'باركود الحضور',
    'hint' => 'اعرض هذا الباركود على شاشة الموبايل عند تسجيل الحضور في السنتر',
])

@if ($barcode)
    <div {{ $attributes->merge(['class' => 'student-checkin-barcode-card']) }}>
        <h5 class="student-checkin-barcode-title mb-1">{{ $title }}</h5>
        <p class="text-muted small mb-3">{{ $hint }}</p>
        <div class="student-checkin-barcode-wrap">
            <img
                src="data:image/png;base64,{{ $barcode }}"
                alt="Barcode {{ $code }}"
                class="student-checkin-barcode"
            >
        </div>
        <p class="student-checkin-barcode-code mb-0">{{ $code }}</p>
    </div>
@endif
