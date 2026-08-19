@php
    $admin = auth('admin')->user();
    $adminAvatar = ! empty($admin?->avatar)
        ? asset('uploads/admins/images/' . $admin->avatar)
        : URL::asset('/build/img/user/user-17.jpg');
@endphp
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    @include('layout.partials.head')
    <link rel="stylesheet" href="{{ url('/build/css/admin.css') }}">
    @stack('styles')
</head>

<body class="admin-panel">
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
                        <a href="{{ route('admin.dashboard') }}" class="navbar-brand logo">
                            <img src="{{ URL::asset('/build/img/logo.svg') }}" class="img-fluid" alt="Logo">
                        </a>
                    </div>

                    <ul class="nav header-navbar-rht">
                        <li class="nav-item user-nav admin-user-nav">
                            <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="user-img">
                                    <img src="{{ $adminAvatar }}" alt="{{ $admin?->name }}">
                                    <span class="status online"></span>
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end users admin-user-menu">
                                <div class="user-header">
                                    <div class="avatar avatar-sm">
                                        <img src="{{ $adminAvatar }}" alt="{{ $admin?->name }}"
                                            class="avatar-img rounded-circle">
                                    </div>
                                    <div class="user-text">
                                        <h6>{{ $admin?->name }}</h6>
                                        <p class="text-muted mb-0">حساب المدير</p>
                                    </div>
                                </div>
                                <form method="POST" action="{{ route('admin.logout') }}" class="admin-logout-form">
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
