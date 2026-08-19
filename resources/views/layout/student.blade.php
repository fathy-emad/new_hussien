@php
    $student = auth('student')->user();
    $avatarFile = normalizeStoredFilename($student?->avatar);
    $studentAvatar = $avatarFile && is_file(public_path('uploads/students/images/' . $avatarFile))
        ? asset('uploads/students/images/' . $avatarFile)
        : URL::asset('/build/img/user/user-17.jpg');
@endphp
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    @include('layout.partials.head')
    <link rel="stylesheet" href="{{ url('/build/css/admin.css') }}">
    @stack('styles')
</head>

<body class="admin-panel student-panel">
    <header class="header header-page admin-header">
        <div class="header-fixed">
            <nav class="navbar navbar-expand-lg header-nav scroll-sticky">
                <div class="container">
                    <div class="navbar-header">
                        <a id="mobile_btn" href="javascript:void(0);">
                            <span class="bar-icon">
                                <span></span>
                                <span></span>
                                <span></span>
                            </span>
                        </a>
                        <a href="{{ route('student.dashboard') }}" class="navbar-brand logo">
                            <img src="{{ URL::asset('/build/img/logo.svg') }}" class="img-fluid" alt="Logo">
                        </a>
                    </div>

                    <ul class="nav header-navbar-rht">
                        <li class="nav-item user-nav admin-user-nav">
                            <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="user-img">
                                    <img src="{{ $studentAvatar }}" alt="{{ $student?->name ?: $student?->code }}">
                                    <span class="status online"></span>
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end users admin-user-menu">
                                <div class="user-header">
                                    <div class="avatar avatar-sm">
                                        <img src="{{ $studentAvatar }}" alt="{{ $student?->name ?: $student?->code }}"
                                            class="avatar-img rounded-circle">
                                    </div>
                                    <div class="user-text">
                                        <h6>{{ $student?->name ?: $student?->code }}</h6>
                                        <p class="text-muted mb-0">حساب الطالب</p>
                                    </div>
                                </div>
                                <a href="{{ route('student.myProfile') }}" class="dropdown-item">الملف الشخصي</a>
                                <a href="{{ url('/') }}" class="dropdown-item">الموقع</a>
                                <form method="POST" action="{{ route('student.logout') }}" class="admin-logout-form">
                                    @csrf
                                    <button type="submit" class="dropdown-item admin-logout-btn">
                                        <i class="feather-log-out ms-1"></i> تسجيل الخروج
                                    </button>
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>

    <div class="main-wrapper">
        @yield('content')
    </div>

    @include('layout.partials.footer-scripts')
    @stack('scripts')
</body>

</html>
