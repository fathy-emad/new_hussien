@php
    $hero = \App\Support\WebsiteHomepage::section($sections, 'hero');
@endphp

<section id="hero" class="home-slide d-flex align-items-center">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <div class="home-slide-face aos" data-aos="fade-up">
                    <div class="home-slide-text">
                        <h5>منصة مستر حسين</h5>
                        <h1>{{ $hero?->title ?: 'منصة مستر حسين التعليمية' }}</h1>
                        <p>{{ $hero?->description ?: 'دروس أونلاين و Offline، امتحانات، ومتابعة مستمرة لمساعدتك على التفوق.' }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-5 d-flex align-items-center">
                <div class="girl-slide-img aos" data-aos="fade-up">
                    <img src="{{ URL::asset('/build/img/object.png') }}" alt="Img">
                </div>
            </div>
        </div>
    </div>
</section>
