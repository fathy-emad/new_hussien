@php
    $centersSection = \App\Support\WebsiteHomepage::section($sections, 'centers');
@endphp

<section id="centers" class="section home-centers-section">
    <div class="container">
        <div class="section-header aos" data-aos="fade-up">
            <div class="section-sub-head feature-head text-center mb-0">
                <span>أماكننا</span>
                <h2>{{ $centersSection?->title ?: 'سناترنا' }}</h2>
                @if ($centersSection?->description)
                    <div class="section-text aos" data-aos="fade-up">
                        <p class="mb-0">{{ $centersSection->description }}</p>
                    </div>
                @endif
            </div>
        </div>

        @if ($centers->isNotEmpty())
            <div class="owl-carousel blogs-slide owl-theme aos home-centers-carousel" data-aos="fade-up">
                @foreach ($centers as $center)
                    <div class="instructors-widget blog-widget home-center-card">
                        <div class="instructors-img d-flex align-items-center justify-content-center bg-light" style="min-height: 180px;">
                            <i class="fa-solid fa-location-dot fa-3x text-primary"></i>
                        </div>
                        <div class="instructors-content text-center">
                            <h5>{{ $center->title }}</h5>
                            <p>{{ $center->address ?: '—' }}</p>
                            @if ($center->phone)
                                @php
                                    $phoneDial = preg_replace('/[^\d+]/', '', (string) $center->phone);
                                @endphp
                                @if ($phoneDial !== '')
                                    <a
                                        href="tel:{{ $phoneDial }}"
                                        class="student-count home-center-phone d-inline-flex justify-content-center align-items-center"
                                    >
                                        <i class="fa-solid fa-phone" aria-hidden="true"></i>
                                        <span dir="ltr">{{ $center->phone }}</span>
                                    </a>
                                @else
                                    <div class="student-count home-center-phone d-inline-flex justify-content-center align-items-center">
                                        <i class="fa-solid fa-phone" aria-hidden="true"></i>
                                        <span dir="ltr">{{ $center->phone }}</span>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-muted text-center py-4 mb-0">لا توجد سناتر مسجّلة حالياً.</p>
        @endif
    </div>
</section>
