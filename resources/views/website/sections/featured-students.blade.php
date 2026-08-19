@php
    $featured = \App\Support\WebsiteHomepage::section($sections, 'featured_students');
    $rawImages = $featured?->extra['images'] ?? [];
    if (is_string($rawImages)) {
        $images = array_filter(explode(',', $rawImages));
    } elseif (is_array($rawImages)) {
        $images = [];
        foreach ($rawImages as $image) {
            if (is_string($image) && str_contains($image, ',')) {
                foreach (explode(',', $image) as $part) {
                    $part = trim($part);
                    if ($part !== '') {
                        $images[] = $part;
                    }
                }
            } elseif (is_string($image) && trim($image) !== '') {
                $images[] = trim($image);
            }
        }
    } else {
        $images = [];
    }
@endphp

@if ($featured && ($featured->title || $featured->description || count($images)))
    <section id="featured-students" class="section trend-course">
        <div class="container">
            <div class="feature-instructors">
                <div class="section-header aos" data-aos="fade-up">
                    <div class="section-sub-head feature-head text-center">
                        <h2>{{ $featured->title ?: 'طلاب متميزون' }}</h2>
                        @if ($featured->description)
                            <div class="section-text aos" data-aos="fade-up">
                                <p class="mb-0">{{ $featured->description }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                @if (count($images))
                    <div class="owl-carousel instructors-course owl-theme aos" data-aos="fade-up">
                        @foreach ($images as $image)
                            @php
                                $url = \App\Support\WebsiteHomepage::sectionImage($image);
                            @endphp
                            @if ($url)
                                <div class="instructors-widget">
                                    <div class="instructors-img">
                                        <img class="img-fluid" alt="طالب" src="{{ $url }}">
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </section>
@endif
