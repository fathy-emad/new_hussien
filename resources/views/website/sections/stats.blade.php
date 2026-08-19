<section id="stats" class="section student-course home-stats-separator">
    <div class="container">
        <div class="course-widget">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="course-full-width">
                        <div class="blur-border course-radius align-items-center aos" data-aos="fade-up">
                            <div class="online-course d-flex align-items-center">
                                <div class="course-img">
                                    <img src="{{ URL::asset('/build/img/icon/master-skill-icon-1.svg') }}" alt="Img">
                                </div>
                                <div class="course-inner-content">
                                    <h4><span>{{ number_format($stats['students']) }}</span></h4>
                                    <p>عدد الطلاب</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 d-flex">
                    <div class="course-full-width">
                        <div class="blur-border course-radius aos" data-aos="fade-up">
                            <div class="online-course d-flex align-items-center">
                                <div class="course-img">
                                    <img src="{{ URL::asset('/build/img/icon/master-skill-icon-2.svg') }}" alt="Img">
                                </div>
                                <div class="course-inner-content">
                                    <h4><span>{{ number_format($stats['centers']) }}</span></h4>
                                    <p>عدد السناتر</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 d-flex">
                    <div class="course-full-width">
                        <div class="blur-border course-radius aos" data-aos="fade-up">
                            <div class="online-course d-flex align-items-center">
                                <div class="course-img">
                                    <img src="{{ URL::asset('/build/img/icon/master-skill-icon-3.svg') }}" alt="Img">
                                </div>
                                <div class="course-inner-content">
                                    <h4><span>{{ number_format($stats['offline']) }}</span></h4>
                                    <p>دروس Offline</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 d-flex">
                    <div class="course-full-width">
                        <div class="blur-border course-radius aos" data-aos="fade-up">
                            <div class="online-course d-flex align-items-center">
                                <div class="course-img">
                                    <img src="{{ URL::asset('/build/img/icon/master-skill-icon-4.svg') }}" alt="Img">
                                </div>
                                <div class="course-inner-content">
                                    <h4><span>{{ number_format($stats['lessons']) }}</span></h4>
                                    <p>عدد الدروس</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
