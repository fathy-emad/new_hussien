<?php $page = 'capacitors'; ?>
@extends('layout.mainlayout')

@section('page-title', 'دروس Offline — منصة مستر حسين')

@section('content')
    <div class="breadcrumb-bar breadcrumb-bar-info">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-12">
                    <div class="breadcrumb-info">
                        <nav aria-label="breadcrumb" class="page-breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">الرئيسية</a></li>
                                <li class="breadcrumb-item active" aria-current="page">دروس Offline</li>
                            </ol>
                        </nav>
                        <h2 class="breadcrumb-title">دروس Offline</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="section home-offline-section">
        <div class="container">
            @foreach ($offlineLessonsByClassroom as $classKey => $group)
                <div class="offline-lessons-classroom-block mb-5">
                    <h4 class="offline-lessons-classroom-title mb-3">{{ $group['label'] }}</h4>

                    @if ($group['lessons']->isEmpty())
                        <p class="text-muted">لا توجد دروس في هذا الصف حالياً.</p>
                    @else
                        <div class="row g-4">
                            @foreach ($group['lessons'] as $lesson)
                                <div class="col-md-6 col-lg-4">
                                    <div class="course-box trend-box offline-lesson-card h-100">
                                        <div class="product trend-product h-100 d-flex flex-column">
                                            <div class="product-img offline-lesson-logo">
                                                <img class="img-fluid" alt="{{ $lesson->title }}" src="{{ \App\Support\WebsiteHomepage::offlineLessonLogo() }}">
                                            </div>
                                            <div class="product-content flex-grow-1 d-flex flex-column">
                                                <span class="offline-lesson-classroom">
                                                    {{ $classRooms[(int) $lesson->classroom] ?? $lesson->classroom }}
                                                </span>
                                                <h3 class="title offline-lesson-title">{{ $lesson->title }}</h3>
                                                @if ($lesson->description)
                                                    <p class="offline-lesson-desc mb-3">
                                                        {{ \Illuminate\Support\Str::limit(strip_tags($lesson->description), 90) }}
                                                    </p>
                                                @endif
                                                <button
                                                    type="button"
                                                    class="btn btn-primary btn-sm mt-auto offline-open-lesson-btn"
                                                    data-lesson-id="{{ $lesson->id }}"
                                                    data-lesson-title="{{ $lesson->title }}"
                                                >
                                                    فتح الدرس
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </section>

    @include('website.sections.offline-lesson-code-modal')
@endsection

@push('scripts')
    <script src="{{ asset('build/js/website/offline-lesson-code.js') }}"></script>
@endpush
