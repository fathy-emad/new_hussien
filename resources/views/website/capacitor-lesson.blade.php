<?php $page = 'capacitor-lesson'; ?>
@extends('layout.mainlayout')
@section('content')
    @php
        $images = $attachments['images'] ?? [];
        $pdfs = $attachments['pdf'] ?? [];
        $classLabel = $classRooms[(int) $lesson->classroom] ?? $lesson->classroom;
        $hasVideo = $attachments['hasVideo'] ?? \App\Support\VimeoVideo::hasVideo($lesson->link);
    @endphp

    <div class="breadcrumb-bar breadcrumb-bar-info">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-12">
                    <div class="breadcrumb-info">
                        <nav aria-label="breadcrumb" class="page-breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">الرئيسية</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('capacitors') }}">دروس Offline</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ $lesson->title }}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="card admin-card">
                        <div class="card-body p-4">
                            <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
                                <div>
                                    <span class="offline-lesson-classroom d-inline-block mb-2">{{ $classLabel }}</span>
                                    <h3 class="mb-2">{{ $lesson->title }}</h3>
                                    <p class="text-muted mb-0 small">
                                        المشاهدات المتبقية: {{ $remainingViews }}
                                    </p>
                                </div>
                                <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-sm">رجوع</a>
                            </div>

                            @if ($lesson->description)
                                <div class="mb-4">
                                    <h5 class="mb-2">وصف الدرس</h5>
                                    <p class="text-muted mb-0">{{ strip_tags($lesson->description) }}</p>
                                </div>
                            @endif

                            @if ($hasVideo)
                                <div class="mb-4">
                                    <h5 class="mb-3">فيديو الدرس</h5>
                                    <x-vimeo-embed :value="$lesson->link" :title="$lesson->title" />
                                </div>
                            @endif

                            @if (count($images))
                                <div class="mb-4">
                                    <h5 class="mb-3">صور الدرس</h5>
                                    <div class="row g-3">
                                        @foreach ($images as $image)
                                            <div class="col-md-4 col-6">
                                                <a href="{{ $image['file'] }}" target="_blank" rel="noopener">
                                                    <img src="{{ $image['file'] }}" alt="" class="img-fluid rounded w-100">
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if (count($pdfs))
                                <div class="mb-0">
                                    <h5 class="mb-3">ملفات PDF</h5>
                                    <ul class="list-unstyled mb-0">
                                        @foreach ($pdfs as $pdf)
                                            <li class="mb-2">
                                                <a href="{{ $pdf['file'] }}" target="_blank" rel="noopener" class="btn btn-outline-primary btn-sm">
                                                    <i class="fa-solid fa-file-pdf me-1"></i> {{ $pdf['name'] }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
