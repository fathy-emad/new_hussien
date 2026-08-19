<?php $page = 'student-review'; ?>
@php
    use App\Models\WebsiteReview;
@endphp
@extends('layout.student')
@section('content')
    @component('components.admin-breadcrumb')
        @slot('title')
            رأيك فى مستر حسين
        @endslot
        @slot('item1')
            لوحة الطالب
        @endslot
        @slot('item2')
            رأيك فى مستر حسين
        @endslot
    @endcomponent

    <div class="page-content">
        <div class="container">
            <div class="row">
                @include('components.student-sidebar')

                <div class="col-xl-9 col-lg-9">
                    @include('components.admin-alerts')

                    <div class="card admin-card">
                        <div class="card-body">
                            <div class="admin-card-header mb-4">
                                <h4 class="mb-1">رأيك فى مستر حسين</h4>
                                <p class="text-muted mb-0">شاركنا تجربتك مرة واحدة. سيظهر رأيك على الموقع بعد موافقة الإدارة.</p>
                            </div>

                            @if ($review)
                                @if ($review->is_approved)
                                    <div class="alert alert-success">
                                        تم اعتماد رأيك وهو ظاهر الآن على الموقع.
                                    </div>
                                @else
                                    <div class="alert alert-info">
                                        تم إرسال رأيك وهو قيد المراجعة من قبل الإدارة.
                                    </div>
                                @endif

                                <div class="input-block mb-0">
                                    <label class="form-label">رأيك</label>
                                    <div class="form-control bg-light" style="min-height: 150px; white-space: pre-wrap;">{{ $review->body }}</div>
                                    <p class="text-muted small mt-2 mb-0">لا يمكن تعديل الرأي من حساب الطالب. للتعديل تواصل مع الإدارة.</p>
                                </div>
                            @else
                                <form method="POST" action="{{ route('student.review.submit') }}">
                                    @csrf
                                    <div class="input-block mb-3">
                                        <label class="form-label" for="body">اكتب رأيك <span class="text-danger">*</span></label>
                                        <textarea
                                            class="form-control @error('body') is-invalid @enderror"
                                            id="body"
                                            name="body"
                                            rows="5"
                                            required
                                            minlength="{{ WebsiteReview::BODY_MIN }}"
                                            maxlength="{{ WebsiteReview::BODY_MAX }}"
                                        >{{ old('body') }}</textarea>
                                        <div class="d-flex justify-content-between mt-1">
                                            <small class="text-muted">اكتب رأيك باختصار — يظهر على الصفحة الرئيسية (حتى {{ WebsiteReview::BODY_MAX }} حرف).</small>
                                            <small class="text-muted" id="reviewCharCount">0 / {{ WebsiteReview::BODY_MAX }}</small>
                                        </div>
                                        @error('body')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn btn-primary">إرسال الرأي</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@if (! $review)
    @push('scripts')
        <script>
            (function () {
                var textarea = document.getElementById('body');
                var counter = document.getElementById('reviewCharCount');
                var max = {{ WebsiteReview::BODY_MAX }};

                if (!textarea || !counter) {
                    return;
                }

                function updateCount() {
                    counter.textContent = textarea.value.length + ' / ' + max;
                    counter.classList.toggle('text-danger', textarea.value.length >= max);
                }

                textarea.addEventListener('input', updateCount);
                updateCount();
            })();
        </script>
    @endpush
@endif
