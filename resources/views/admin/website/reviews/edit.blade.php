<?php $page = 'admin-website-reviews-edit'; ?>
@php
    use App\Models\WebsiteReview;
@endphp
@extends('layout.admin')
@section('content')
    @component('components.admin-breadcrumb')
        @slot('title')
            تعديل رأي طالب
        @endslot
        @slot('item1')
            الرئيسية
        @endslot
        @slot('item2')
            آراء الطلاب
        @endslot
        @slot('item2Url')
            {{ route('admin.website.reviews.index') }}
        @endslot
        @slot('item3')
            تعديل الرأي
        @endslot
    @endcomponent

    <div class="page-content">
        <div class="container">
            <div class="row">
                @include('components.admin-sidebar')

                <div class="col-xl-9 col-lg-9">
                    @include('components.admin-alerts')

                    <div class="card admin-card">
                        <div class="card-body">
                            <div class="admin-card-header mb-4">
                                <h4 class="mb-1">تعديل رأي الطالب</h4>
                                <p class="text-muted mb-0">
                                    {{ $studentName }} — {{ $classroom }} — {{ $year }}
                                </p>
                            </div>

                            @if (mb_strlen($review->body) > WebsiteReview::BODY_MAX)
                                <div class="alert alert-warning">
                                    هذا الرأي أطول من الحد المسموح ({{ WebsiteReview::BODY_MAX }} حرف). قصّه قبل الاعتماد حتى يظهر بشكل صحيح على الموقع.
                                </div>
                            @endif

                            <form method="POST" action="{{ route('admin.website.reviews.update', $review->id) }}">
                                @csrf
                                <div class="input-block mb-3">
                                    <label class="form-label" for="body">نص الرأي <span class="text-danger">*</span></label>
                                    <textarea
                                        class="form-control @error('body') is-invalid @enderror"
                                        id="body"
                                        name="body"
                                        rows="5"
                                        required
                                        minlength="{{ WebsiteReview::BODY_MIN }}"
                                        maxlength="{{ WebsiteReview::BODY_MAX }}"
                                    >{{ old('body', $review->body) }}</textarea>
                                    <div class="d-flex justify-content-between mt-1">
                                        <small class="text-muted">الحد الأقصى {{ WebsiteReview::BODY_MAX }} حرفاً ليتناسب مع عرض الموقع.</small>
                                        <small class="text-muted" id="adminReviewCharCount">0 / {{ WebsiteReview::BODY_MAX }}</small>
                                    </div>
                                    @error('body')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <p class="text-muted small">
                                    عند الحفظ سيتم إلغاء الاعتماد تلقائياً حتى تعيد اعتماد الرأي من قائمة آراء الطلاب.
                                </p>

                                <div class="d-flex flex-wrap gap-2">
                                    <button type="submit" class="btn btn-primary">حفظ التعديل</button>
                                    <a href="{{ route('admin.website.reviews.index') }}" class="btn btn-outline-secondary">إلغاء</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        (function () {
            var textarea = document.getElementById('body');
            var counter = document.getElementById('adminReviewCharCount');
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
