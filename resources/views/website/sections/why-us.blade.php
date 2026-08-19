@php
    $whyUs = \App\Support\WebsiteHomepage::section($sections, 'why_us');
    $points = $whyUs?->extra['points'] ?? [];
    $sideImage = \App\Support\WebsiteHomepage::sectionImage($whyUs?->extra['side_image'] ?? null)
        ?: URL::asset('/build/img/master-hussien-why-us.png');
    $icons = ['master-skill-icon-1.svg', 'master-skill-icon-2.svg', 'master-skill-icon-3.svg', 'master-skill-icon-4.svg'];
@endphp

<section id="why-us" class="section master-skill home-why-us-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 col-md-12">
                <div class="section-header aos" data-aos="fade-up">
                    <div class="section-sub-head">
                        <span>لماذا نحن</span>
                        <h2>{{ $whyUs?->title ?: 'لماذا تختار مستر حسين؟' }}</h2>
                    </div>
                </div>
                <div class="section-text aos" data-aos="fade-up">
                    <p>{{ $whyUs?->description }}</p>
                </div>
                <div class="career-group aos" data-aos="fade-up">
                    <div class="row">
                        @foreach ($points as $index => $point)
                            @if (trim((string) $point) !== '')
                                <div class="col-lg-6 col-md-6 d-flex">
                                    <div class="certified-group blur-border d-flex">
                                        <div class="get-certified d-flex align-items-center">
                                            <div class="blur-box">
                                                <div class="certified-img">
                                                    <img src="{{ URL::asset('/build/img/icon/' . ($icons[$index] ?? 'master-skill-icon-1.svg')) }}" alt="Img" class="img-fluid">
                                                </div>
                                            </div>
                                            <p>{{ $point }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-lg-5 col-md-12 d-flex align-items-end">
                <div class="career-img aos" data-aos="fade-up">
                    <img src="{{ $sideImage }}" alt="مستر حسين" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
</section>
