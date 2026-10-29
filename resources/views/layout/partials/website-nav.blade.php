@php
    $homeSection = fn (string $id) => Route::is('home') ? "#{$id}" : route('home') . "#{$id}";
@endphp
<ul class="main-nav website-main-nav">
    <li class="{{ Route::is('home') ? 'active' : '' }}">
        <a href="{{ route('home') }}">الرئيسية</a>
    </li>
    <li>
        <a href="{{ $homeSection('why-us') }}">لماذا نحن</a>
    </li>
    <li class="{{ Route::is(['capacitors', 'capacitor_lesson']) ? 'active' : '' }}">
        <a href="{{ route('capacitors') }}">دروس Offline</a>
    </li>
    <li>
        <a href="{{ $homeSection('featured-students') }}">طلابنا</a>
    </li>
    <li>
        <a href="{{ $homeSection('reviews') }}">آراء الطلاب</a>
    </li>
    <li>
        <a href="{{ $homeSection('centers') }}">سناترنا</a>
    </li>
    <li class="{{ Route::is('contact') ? 'active' : '' }}">
        <a href="{{ route('contact') }}">تواصل معنا</a>
    </li>
    <li class="login-link d-lg-none">
        <a href="{{ route('student.login') }}">دخول الطلاب</a>
    </li>
</ul>
