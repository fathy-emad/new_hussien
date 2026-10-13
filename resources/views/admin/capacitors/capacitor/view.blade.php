<?php $page = 'admin-offline-capacitor-view'; ?>
@extends('layout.admin')
@section('content')
    @component('components.admin-breadcrumb')
        @slot('title')
            عرض درس Offline
        @endslot
        @slot('item1')
            الرئيسية
        @endslot
        @slot('item2')
            Offline
        @endslot
        @slot('item2Url')
            {{ route('admin.capacitors.capacitor.index', $searchParams) }}
        @endslot
        @slot('item3')
            {{ $model->title }}
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
                                    <h4 class="mb-1">{{ $model->title }}</h4>
                                    <p class="text-muted mb-0">
                                        {{ $classRooms[(int) $model->classroom] ?? '' }}
                                        — عدد مرات المشاهدة: {{ $model->watch_times ?: 1 }}
                                    </p>
                                </div>
                                <div class="d-flex flex-wrap gap-2">
                                    <a href="{{ route('admin.capacitors.capacitor.index', $searchParams) }}" class="btn btn-outline-secondary btn-sm">رجوع</a>
                                    <a href="{{ route('admin.capacitors.capacitor.edit', $model->id) }}" class="btn btn-primary btn-sm">تعديل</a>
                                </div>
                            </div>

                            @if ($model->description)
                                <div class="admin-lesson-view-section mb-4">
                                    <h5 class="mb-2">الوصف</h5>
                                    <p class="mb-0">{{ $model->description }}</p>
                                </div>
                            @endif

                            <div class="admin-lesson-view-video mb-4">
                                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                                    <h5 class="mb-0">فيديو الدرس</h5>
                                    @if ($hasVideo)
                                        <span class="badge bg-success">Vimeo</span>
                                    @else
                                        <span class="badge bg-warning text-dark">لا يوجد فيديو</span>
                                    @endif
                                </div>

                                @if ($hasVideo)
                                    <x-vimeo-embed :value="$model->link" :title="$model->title" />
                                    <p class="text-muted small mt-2 mb-0">
                                        <strong>قيمة link:</strong> <code>{{ $model->link }}</code>
                                    </p>
                                @endif
                            </div>

                            @if (count($images))
                                <div class="admin-lesson-view-section mb-4">
                                    <h5 class="mb-3">صور الدرس</h5>
                                    <div class="admin-lesson-images-grid">
                                        @foreach ($images as $image)
                                            <div class="admin-lesson-image-card">
                                                <a href="{{ $image['url'] }}" target="_blank" class="admin-lesson-image-link">
                                                    <img src="{{ $image['url'] }}" alt="{{ $image['name'] }}" class="admin-lesson-image-thumb">
                                                </a>
                                                <div class="admin-lesson-image-meta">
                                                    <span class="admin-lesson-file-name">{{ $image['name'] }}</span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if (count($pdfs))
                                <div class="admin-lesson-view-section">
                                    <h5 class="mb-3">مرفقات PDF</h5>
                                    <div class="admin-lesson-pdf-list">
                                        @foreach ($pdfs as $pdf)
                                            <div class="admin-lesson-pdf-item">
                                                <div class="admin-lesson-pdf-header">
                                                    <div class="admin-lesson-pdf-info">
                                                        <i class="bx bxs-file-pdf admin-lesson-pdf-icon"></i>
                                                        <span class="admin-lesson-pdf-name">{{ $pdf['name'] }}</span>
                                                    </div>
                                                    <a href="{{ $pdf['url'] }}" target="_blank" class="btn btn-sm btn-outline-primary">فتح</a>
                                                </div>
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
