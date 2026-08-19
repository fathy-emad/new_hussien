<?php $page = 'admin-lesson-view'; ?>
@extends('layout.admin')
@section('content')
    @component('components.admin-breadcrumb')
        @slot('title')
            عرض الدرس
        @endslot
        @slot('item1')
            الرئيسية
        @endslot
        @slot('item2')
            إدارة الدروس
        @endslot
        @slot('item2Url')
            {{ route('admin.settings.lesson.index', $searchParams) }}
        @endslot
        @slot('item3')
            {{ $lesson->title }}
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
                            <div class="admin-card-header mb-4 d-flex flex-wrap justify-content-between align-items-start gap-2">
                                <div>
                                    <h4 class="mb-1">{{ $lesson->title }}</h4>
                                    <p class="text-muted mb-0">
                                        رقم الدرس: {{ $lesson->NO }}
                                        @if ($lesson->chapter)
                                            — {{ $lesson->chapter->title }} ({{ $lesson->chapter->academic_year }})
                                        @endif
                                    </p>
                                </div>
                                <div class="d-flex flex-wrap gap-2">
                                    <a href="{{ route('admin.settings.lesson.index', $searchParams) }}" class="btn btn-outline-secondary btn-sm">رجوع</a>
                                    <a href="{{ route('admin.settings.lesson.edit', $lesson->id) }}" class="btn btn-primary btn-sm">تعديل الدرس</a>
                                </div>
                            </div>

                            <div class="admin-lesson-view-video mb-4">
                                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                                    <h5 class="mb-0">فيديو الدرس</h5>
                                    @if ($hasVideo)
                                        <span class="badge bg-success">تم رفع الفيديو بنجاح</span>
                                    @else
                                        <span class="badge bg-warning text-dark">لا يوجد فيديو</span>
                                    @endif
                                </div>

                                @if ($hasVideo)
                                    <div class="admin-lesson-video-player">
                                        <video
                                            class="w-100 rounded admin-lesson-video-element"
                                            controls
                                            controlsList="nodownload"
                                            preload="metadata"
                                            playsinline
                                            src="{{ $videoUrl }}"
                                        >
                                            متصفحك لا يدعم تشغيل الفيديو.
                                        </video>
                                    </div>
                                    <div class="admin-lesson-video-meta mt-2">
                                        <p class="text-muted small mb-1">
                                            <strong>ملف الفيديو:</strong>
                                            <code>{{ $videoFile }}</code>
                                        </p>
                                        <p class="text-muted small mb-0">
                                            <strong>الحجم:</strong> {{ $videoSizeMb }} MB
                                            — <strong>محفوظ في:</strong> <code>storage/app/videos/lessons/</code>
                                        </p>
                                    </div>
                                @else
                                    <div class="alert alert-warning mb-0">
                                        لم يُحفظ فيديو لهذا الدرس في عمود <code>link</code>.
                                        <a href="{{ route('admin.settings.lesson.edit', $lesson->id) }}" class="alert-link">ارفع فيديو من صفحة التعديل</a>.
                                    </div>
                                @endif
                            </div>

                            @php
                                $thumbnail = $attachments['thumbnail'][0] ?? null;
                                $images = $attachments['images'] ?? [];
                                $pdfs = $attachments['pdf'] ?? [];
                            @endphp

                            <div class="admin-lesson-view-attachments mb-4">
                                <div class="admin-lesson-view-section mb-4">
                                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                                        <h5 class="mb-0">صورة الغلاف (Thumbnail)</h5>
                                        @if ($thumbnail)
                                            <span class="badge bg-success">متوفرة</span>
                                        @else
                                            <span class="badge bg-warning text-dark">لا توجد صورة</span>
                                        @endif
                                    </div>

                                    @if ($thumbnail)
                                        <div class="admin-lesson-thumbnail-preview">
                                            <a href="{{ $thumbnail['file'] }}" target="_blank" rel="noopener">
                                                <img
                                                    src="{{ $thumbnail['file'] }}"
                                                    alt="{{ $thumbnail['name'] }}"
                                                    class="img-fluid rounded admin-lesson-thumbnail-img"
                                                >
                                            </a>
                                        </div>
                                        <p class="text-muted small mt-2 mb-0">
                                            <strong>الملف:</strong> <code>{{ $thumbnail['name'] }}</code>
                                            — <strong>الحجم:</strong> {{ $thumbnail['sizeLabel'] }}
                                        </p>
                                    @else
                                        <div class="alert alert-warning mb-0">
                                            لم تُرفع صورة غلاف لهذا الدرس.
                                            <a href="{{ route('admin.settings.lesson.edit', $lesson->id) }}" class="alert-link">أضف صورة من صفحة التعديل</a>.
                                        </div>
                                    @endif
                                </div>

                                <div class="admin-lesson-view-section mb-4">
                                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                                        <h5 class="mb-0">صور الدرس</h5>
                                        @if (count($images))
                                            <span class="badge bg-success">{{ count($images) }} صورة</span>
                                        @else
                                            <span class="badge bg-warning text-dark">لا توجد صور</span>
                                        @endif
                                    </div>

                                    @if (count($images))
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
                                                        <span class="admin-lesson-file-size">{{ $image['sizeLabel'] }}</span>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="alert alert-warning mb-0">
                                            لا توجد صور إضافية لهذا الدرس.
                                        </div>
                                    @endif
                                </div>

                                <div class="admin-lesson-view-section mb-0">
                                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                                        <h5 class="mb-0">مرفقات الدرس (PDF)</h5>
                                        @if (count($pdfs))
                                            <span class="badge bg-success">{{ count($pdfs) }} ملف</span>
                                        @else
                                            <span class="badge bg-warning text-dark">لا توجد مرفقات</span>
                                        @endif
                                    </div>

                                    @if ($lesson->pdf)
                                        <p class="text-muted small mb-3">
                                            <strong>قيمة قاعدة البيانات (pdf):</strong>
                                            <code class="admin-lesson-csv-value">{{ $lesson->pdf }}</code>
                                        </p>
                                    @endif

                                    @if (count($pdfs))
                                        <div class="admin-lesson-pdf-list">
                                            @foreach ($pdfs as $pdf)
                                                <div class="admin-lesson-pdf-item">
                                                    <div class="admin-lesson-pdf-header">
                                                        <div class="admin-lesson-pdf-info">
                                                            <i class="feather-file-text admin-lesson-pdf-icon"></i>
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
                                                            <i class="feather-download"></i> فتح / تحميل
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
                                    @else
                                        <div class="alert alert-warning mb-0">
                                            لا توجد ملفات PDF أو DOC مرفقة بهذا الدرس.
                                        </div>
                                    @endif
                                </div>
                            </div>

                            @if ($lesson->info)
                                <div class="mb-4">
                                    <h6>وصف الدرس</h6>
                                    <p class="mb-0 text-muted">{{ $lesson->info }}</p>
                                </div>
                            @endif

                            <div class="row g-3 admin-lesson-view-details">
                                <div class="col-md-4">
                                    <div class="admin-detail-box">
                                        <span class="admin-detail-label">فترة المشاهدة</span>
                                        <span class="admin-detail-value">{{ $lesson->watchIntervalTime ? $lesson->watchIntervalTime.' يوم' : 'غير محدد' }}</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="admin-detail-box">
                                        <span class="admin-detail-label">عدد مرات المشاهدة</span>
                                        <span class="admin-detail-value">{{ $lesson->watchTimes ?? 0 }}</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="admin-detail-box">
                                        <span class="admin-detail-label">تاريخ الإنشاء</span>
                                        <span class="admin-detail-value">{{ $lesson->created_at?->format('d M Y - H:i') ?? '—' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
