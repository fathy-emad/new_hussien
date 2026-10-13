<?php $page = 'student-lesson'; ?>
@extends('layout.student')
@section('content')
    @php
        $images = $attachments['images'] ?? [];
        $pdfs = $attachments['pdf'] ?? [];
    @endphp

    <div class="page-content">
        <div class="container">
            <div class="row">
                @include('components.student-sidebar')

                <div class="col-xl-9 col-lg-9">
                    <div class="card admin-card">
                        <div class="card-body">
                            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
                                <div>
                                    <h4 class="mb-1">{{ $lesson->title }}</h4>
                                    <p class="text-muted mb-0">
                                        المشاهدات: {{ $lesson->view }} / {{ $lesson->watchTimes ?: 0 }}
                                        @if ($lesson->chapter)
                                            — {{ $lesson->chapter->title }}
                                        @endif
                                    </p>
                                </div>
                                <a href="{{ route('student.material') }}" class="btn btn-outline-secondary btn-sm">رجوع</a>
                            </div>

                            @if ($lesson->info)
                                <div class="admin-lesson-view-section mb-4">
                                    <h5 class="mb-3">وصف الدرس</h5>
                                    <div class="admin-detail-box">
                                        <p class="mb-0 text-muted">{{ $lesson->info }}</p>
                                    </div>
                                </div>
                            @endif

                            <div class="admin-lesson-view-section mb-4">
                                <h5 class="mb-3">فيديو الدرس</h5>
                                @if ($lesson->opened)
                                    <div class="admin-lesson-view-video">
                                        <x-vimeo-embed :value="$lesson->link" :title="$lesson->title" />
                                    </div>
                                @else
                                    <div class="alert alert-warning mb-0">
                                        الفيديو غير متاح للمشاهدة حالياً
                                    </div>
                                @endif
                            </div>

                            @if (count($images))
                                <div class="admin-lesson-view-section mb-4">
                                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                                        <h5 class="mb-0">صور الدرس</h5>
                                        <span class="badge bg-success">{{ count($images) }} صورة</span>
                                    </div>
                                    <div class="admin-lesson-images-grid">
                                        @foreach ($images as $image)
                                            <div class="admin-lesson-image-card">
                                                <a href="{{ $image['file'] }}" target="_blank" rel="noopener" class="admin-lesson-image-link">
                                                    <img
                                                        src="{{ $image['file'] }}"
                                                        alt="{{ $image['name'] }}"
                                                        class="admin-lesson-image-thumb"
                                                        loading="lazy"
                                                    >
                                                </a>
                                                <div class="admin-lesson-image-meta">
                                                    <span class="admin-lesson-file-name" title="{{ $image['name'] }}">{{ $image['name'] }}</span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if (count($pdfs))
                                <div class="admin-lesson-view-section mb-0">
                                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                                        <h5 class="mb-0">مرفقات الدرس</h5>
                                        <span class="badge bg-success">{{ count($pdfs) }} ملف</span>
                                    </div>
                                    <div class="admin-lesson-pdf-list">
                                        @foreach ($pdfs as $pdf)
                                            <div class="admin-lesson-pdf-item">
                                                <div class="admin-lesson-pdf-header">
                                                    <div class="admin-lesson-pdf-info">
                                                        <i class="bx bxs-file-pdf admin-lesson-pdf-icon"></i>
                                                        <div>
                                                            <strong class="admin-lesson-pdf-name">{{ $pdf['name'] }}</strong>
                                                            <span class="text-muted small d-block">{{ strtoupper($pdf['extension']) }} — {{ $pdf['sizeLabel'] }}</span>
                                                        </div>
                                                    </div>
                                                    <a
                                                        href="{{ $pdf['file'] }}"
                                                        target="_blank"
                                                        rel="noopener"
                                                        class="btn btn-outline-primary btn-sm"
                                                    >
                                                        <i class="bx bx-download"></i> فتح / تحميل
                                                    </a>
                                                </div>
                                                @if ($pdf['extension'] === 'pdf')
                                                    <iframe
                                                        src="{{ $pdf['file'] }}"
                                                        class="admin-lesson-pdf-frame"
                                                        title="معاينة {{ $pdf['name'] }}"
                                                        loading="lazy"
                                                    ></iframe>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
