@php
    $reviewsSection = \App\Support\WebsiteHomepage::section($sections, 'reviews');
@endphp

@if ($reviewsSection && ($reviews->isNotEmpty() || $reviewsSection->title))
    <section id="reviews" class="section home-reviews-section">
        <div class="container">
            <div class="section-header aos" data-aos="fade-up">
                <div class="section-sub-head feature-head text-center">
                    <span>آراء حقيقية</span>
                    <h2>{{ $reviewsSection->title ?: 'آراء الطلاب' }}</h2>
                    @if ($reviewsSection->description)
                        <p class="mb-0 mt-2">{{ $reviewsSection->description }}</p>
                    @endif
                </div>
            </div>

            @if ($reviews->isNotEmpty())
                <div class="home-reviews-carousel aos" data-aos="fade-up">
                    <div @class([
                        'mentor-testimonial',
                        'lazy',
                        'slider',
                        'home-reviews-single' => $reviews->count() <= 1,
                    ]) data-sizes="50vw">
                        @foreach ($reviews as $review)
                            <div class="home-review-slide">
                                <div class="home-review-card">
                                    <div class="home-review-quote">
                                        <img src="{{ URL::asset('/build/img/qute-01.png') }}" alt="">
                                    </div>
                                    <p class="home-review-text">{{ $review['body'] }}</p>
                                    <div class="home-review-author">
                                        <img src="{{ $review['avatar'] }}" alt="{{ $review['name'] }}" class="img-fluid">
                                        <div>
                                            <h3>{{ $review['name'] }}</h3>
                                            <span>{{ $review['classroom'] }} — {{ $review['year'] }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <p class="text-muted text-center py-4 mb-0">لا توجد آراء معتمدة حالياً.</p>
            @endif
        </div>
    </section>
@endif
