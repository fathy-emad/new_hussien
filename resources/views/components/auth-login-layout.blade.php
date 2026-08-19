@props([
    'title',
    'subtitle' => null,
    'backUrl' => null,
    'backLabel' => 'العودة للرئيسية',
    'formAction',
    'showForgotPassword' => false,
    'forgotPasswordUrl' => null,
    'showRemember' => true,
])

<div class="row g-0 align-items-stretch min-vh-100 auth-login-row">
    <div class="col-md-6 login-wrap-bg order-md-1 order-1">
        <div class="login-wrapper">
            <div class="loginbox">
                <div class="w-100">
                    <div class="img-logo">
                        <img src="{{ URL::asset('/build/img/logo.svg') }}" class="img-fluid" alt="Logo">
                        @if ($backUrl)
                            <div class="back-home">
                                <a href="{{ $backUrl }}">{{ $backLabel }}</a>
                            </div>
                        @endif
                    </div>
                    <h1>{{ $title }}</h1>
                    @if ($subtitle)
                        <p class="text-muted mb-4">{{ $subtitle }}</p>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ $formAction }}">
                        @csrf
                        {{ $slot }}

                        @if ($showRemember)
                            <div class="remember-me mt-3">
                                <label class="custom_check mr-2 mb-0 d-inline-flex remember-me">
                                    تذكرني
                                    <input type="checkbox" name="remember" value="1" {{ old('remember') ? 'checked' : '' }}>
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                        @endif
                        <div class="d-grid mt-3">
                            <button class="btn btn-primary btn-start" type="submit">تسجيل الدخول</button>
                        </div>
                    </form>
                </div>
            </div>
            @if ($showForgotPassword && $forgotPasswordUrl)
                <div class="forgot text-center mt-3">
                    <a class="forgot-link" href="{{ $forgotPasswordUrl }}">نسيت كلمة المرور؟</a>
                </div>
            @endif
            @isset($footer)
                <div class="google-bg text-center mt-3">
                    {{ $footer }}
                </div>
            @endisset
        </div>
    </div>
    <div class="col-md-6 login-bg order-md-2 order-2 d-none d-md-block">
        <div class="owl-carousel login-slide owl-theme h-100">
            <div class="welcome-login">
                <div class="login-banner">
                    <img src="{{ URL::asset('/build/img/login-img.png') }}" class="img-fluid" alt="Logo">
                </div>
                <div class="mentor-course text-center">
                    <h2>مرحباً بك<br>في منصة التعلم</h2>
                    <p>تعلم بسهولة من أي مكان وفي أي وقت</p>
                </div>
            </div>
        </div>
    </div>
</div>
