<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    @include('layout.partials.head')
</head>

<body class="auth-page">
    <div class="main-wrapper log-wrap">
        @yield('content')
    </div>
    @include('layout.partials.footer-scripts')
</body>

</html>
