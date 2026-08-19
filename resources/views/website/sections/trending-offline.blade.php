@php
    $trending = \App\Support\WebsiteHomepage::section($sections, 'trending_offline');
    $logoUrl = \App\Support\WebsiteHomepage::offlineLessonLogo();
@endphp

<section id="offline" class="section trend-course home-offline-section">
    <div class="container">
        <div class="section-header aos home-offline-section-header" data-aos="fade-up">
            <div class="section-sub-head">
                <span>Offline</span>
                <h2>{{ $trending?->title ?: 'دروس Offline المتاحة' }}</h2>
            </div>
            @if ($offlineLessons->isNotEmpty())
                <div class="all-btn all-category d-flex align-items-center">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#offlineLessonsModal">
                        جميع الدروس
                    </button>
                </div>
            @endif
        </div>
        @if ($trending?->description)
            <div class="section-text aos" data-aos="fade-up">
                <p class="mb-0">{{ $trending->description }}</p>
            </div>
        @endif

        @if ($offlineLessons->isNotEmpty())
            <div class="owl-carousel trending-course owl-theme aos" data-aos="fade-up">
                @foreach ($offlineLessons as $lesson)
                    <div class="course-box trend-box offline-lesson-card">
                        <div class="product trend-product">
                            <div class="product-img offline-lesson-logo">
                                <img class="img-fluid" alt="{{ $lesson->title }}" src="{{ $logoUrl }}">
                            </div>
                            <div class="product-content">
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
                                    class="btn btn-primary btn-sm offline-open-lesson-btn"
                                    data-lesson-id="{{ $lesson->id }}"
                                    data-lesson-title="{{ $lesson->title }}"
                                >
                                    فتح الدرس
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-muted text-center py-4 mb-0">لا توجد دروس Offline مفعّلة حالياً.</p>
        @endif
    </div>
</section>

@include('website.sections.offline-lessons-modal')
@include('website.sections.offline-lesson-code-modal')

@push('scripts')
    <script src="{{ asset('build/js/website/offline-lesson-code.js') }}"></script>
@endpush
