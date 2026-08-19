@php
    $authLayoutRoutes = [
        'login', 'register',
        'admin.login', 'student.login',
        'forgot-password', 'new-password', 'verification-code',
        'register-step-one', 'register-step-two', 'register-step-three',
        'register-step-four', 'register-step-five',
        'coming-soon', 'error-404', 'error-500', 'under-construction', 'view-invoice',
    ];
    $isAuthLayout = Route::is($authLayoutRoutes);
@endphp
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    @include('layout.partials.head')
</head>

<body>
    @if (Route::is(['index-two']))

        <body class="home-two">
    @endif
    @if (Route::is(['index-three']))

        <body class="home-three">
    @endif
    @if (Route::is(['index-four']))

        <body class="home-five">
    @endif
    
    @if (Route::is(['coming-soon', 'error-404', 'error-500', 'under-construction']))

        <body class="error-page">
    @endif
    @if (Route::is(['student-messages','instructor-chat']))
    <body class="chat-page main-chat-blk">
    @endif
    @if (Route::is(['student-messages','instructor-chat']))
    <div class="main-wrapper chat-wrapper">
        @endif
    <!-- Main Wrapper -->
    @if (! $isAuthLayout && ! Route::is(['student-messages', 'instructor-chat']))
        <div class="main-wrapper">
    @endif
    @if ($isAuthLayout)
        <div class="main-wrapper log-wrap">
    @endif
    @if (! $isAuthLayout)
        @include('layout.partials.header')
    @endif
    @yield('content')
    @if (! $isAuthLayout)
        @include('layout.partials.footer')
    @endif
    </div>
    <!-- /Main Wrapper -->
    @include('layout.partials.footer-scripts')

</body>

</html>
