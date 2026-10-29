<!-- Header -->
@if (!Route::is(['index-two', 'index-three', 'index-four']))
    @if (
        !Route::is([
            'instructor-list',
            'instructor-grid',
            'instructor-dashboard',
            'instructor-profile',
            'instructor-course',
            'instructor-wishlist',
            'instructor-reviews',
            'instructor-quiz',
            'instructor-orders',
            'instructor-qa',
            'instructor-referral',
            'instructor-chat',
            'instructor-tickets',
            'instructor-notifications',
            'instructor-settings',
            'students-list',
            'students-grid',
            'student-dashboard',
            'student-profile',
            'student-courses',
            'student-wishlist',
            'student-reviews',
            'student-quiz',
            'student-order-history',
            'student-qa',
            'student-referral',
            'student-messages',
            'student-tickets',
            'student-settings',
            'instructor-enrolled-course',
            'instructor-announcements',
            'instructor-withdraw',
            'instructor-quiz-attempts',
            'instructor-assignment',
            'instructor-earnings',
            'instructor-change-password',
            'instructor-setting-notifications',
            'instructor-setting-withdraw',
            'instructor-delete-account',
            'student-change-password',
            'student-setting-notifications',
            'student-setting-social-profile',
            'student-linked-accounts',
            'notifications',
            'pricing-plan',
            'wishlist',
            'course-list',
            'course-grid',
            'course-details',
            'faq',
            'support',
            'job-category',
            'cart',
            'checkout',
            'blog-list',
            'blog-grid',
            'blog-masonry',
            'blog-modern',
            'blog-details',
            'instructor-quiz-details',
            'student-quiz-details',
            'instructor-quiz-attempts-details',
            'add-course',
            'course-lesson',
            'help-center',
            'instructor-edit',
            'privacy-policy',
            'setting-student-subscription',
            'student-notifications',
            'student-social-profile',
            'term-condition',
        ]))
        <header class="header">
    @endif
    @if (Route::is([
            'instructor-list',
            'instructor-grid',
            'instructor-dashboard',
            'instructor-profile',
            'instructor-course',
            'instructor-wishlist',
            'instructor-reviews',
            'instructor-quiz',
            'instructor-orders',
            'instructor-qa',
            'instructor-referral',
            'instructor-chat',
            'instructor-tickets',
            'instructor-notifications',
            'instructor-settings',
            'students-list',
            'students-grid',
            'student-dashboard',
            'student-profile',
            'student-courses',
            'student-wishlist',
            'student-reviews',
            'student-quiz',
            'student-order-history',
            'student-qa',
            'student-referral',
            'student-messages',
            'student-tickets',
            'student-settings',
            'instructor-enrolled-course',
            'instructor-announcements',
            'instructor-withdraw',
            'instructor-quiz-attempts',
            'instructor-assignment',
            'instructor-earnings',
            'instructor-change-password',
            'instructor-setting-notifications',
            'instructor-setting-withdraw',
            'instructor-delete-account',
            'student-change-password',
            'student-setting-notifications',
            'student-setting-social-profile',
            'student-linked-accounts',
            'notifications',
            'pricing-plan',
            'wishlist',
            'course-list',
            'course-grid',
            'course-details',
            'faq',
            'support',
            'job-category',
            'cart',
            'checkout',
            'blog-list',
            'blog-grid',
            'blog-masonry',
            'blog-modern',
            'blog-details',
            'instructor-quiz-details',
            'student-quiz-details',
            'instructor-quiz-attempts-details',
            'add-course',
            'course-lesson',
            'help-center',
            'instructor-edit',
            'privacy-policy',
            'setting-student-subscription',
            'student-notifications',
            'student-social-profile',
            'term-condition',
        ]))
        <header class="header header-page">
    @endif
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
                    <a href="{{ route('home') }}" class="navbar-brand logo">
                        <img src="{{ \App\Support\WebsiteHomepage::siteLogo() }}" class="img-fluid" alt="حسين فايز">
                    </a>
                </div>
                <div class="main-menu-wrapper">
                    <div class="menu-header">
                        <a href="{{ route('home') }}" class="menu-logo">
                            <img src="{{ \App\Support\WebsiteHomepage::siteLogo() }}" class="img-fluid" alt="حسين فايز">
                        </a>
                        <a id="menu_close" class="menu-close" href="javascript:void(0);">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>
                    @if (Route::is(['home', 'capacitors', 'contact', 'capacitor_lesson']))
                        @include('layout.partials.website-nav')
                    @else
                    <ul class="main-nav">
                        <li
                            class="has-submenu {{ Request::is('index', 'index-two', 'index-three', 'index-four', '/') ? 'active' : '' }}">
                            <a class="" href="#">Home <i class="fas fa-chevron-down"></i></a>
                            <ul class="submenu">
                                <li class="{{ Request::is('index', '/') ? 'active' : '' }}"><a
                                        href="{{ url('index') }}">Home</a></li>
                                <li class="{{ Request::is('index-two') ? 'active' : '' }}"><a
                                        href="{{ url('index-two') }}">Home Two</a></li>
                                <li class="{{ Request::is('index-three') ? 'active' : '' }}"><a
                                        href="{{ url('index-three') }}">Home Three</a></li>
                                <li class="{{ Request::is('index-four') ? 'active' : '' }}"><a
                                        href="{{ url('index-four') }}">Home Four</a></li>
                            </ul>
                        </li>
                        <li
                            class="has-submenu {{ Request::is('instructor-list', 'instructor-grid', 'instructor-dashboard', 'instructor-profile', 'instructor-course', 'instructor-wishlist', 'instructor-reviews', 'instructor-quiz', 'instructor-orders', 'instructor-qa', 'instructor-referral', 'instructor-chat', 'instructor-tickets', 'instructor-notifications', 'instructor-settings', 'instructor-enrolled-course', 'instructor-announcements', 'instructor-withdraw', 'instructor-quiz-attempts', 'instructor-assignment', 'instructor-earnings', 'instructor-change-password', 'instructor-setting-notifications', 'instructor-setting-withdraw', 'instructor-delete-account', 'instructor-quiz-details', 'instructor-quiz-attempts-details') ? 'active' : '' }}">
                            <a href="#">Instructor <i class="fas fa-chevron-down"></i></a>
                            <ul class="submenu">
                                <li
                                    class="has-submenu {{ Request::is('instructor-list', 'instructor-grid') ? 'active' : '' }}">
                                    <a href="{{ url('instructor-list') }}"
                                        class="{{ Request::is('instructor-list') ? 'active' : '' }}">Instructor</a>
                                    <ul class="submenu">
                                        <li class="{{ Request::is('instructor-list') ? 'active' : '' }}"><a
                                                href="{{ url('instructor-list') }}">List</a></li>
                                        <li class="{{ Request::is('instructor-grid') ? 'active' : '' }}"><a
                                                href="{{ url('instructor-grid') }}">Grid</a></li>
                                    </ul>
                                </li>
                                <li class="{{ Request::is('instructor-dashboard') ? 'active' : '' }}"><a
                                        href="{{ url('instructor-dashboard') }}">Dashboard</a></li>
                                <li class="{{ Request::is('instructor-profile') ? 'active' : '' }}"><a
                                        href="{{ url('instructor-profile') }}">My Profile</a></li>
                                <li
                                    class="{{ Request::is('instructor-course', 'instructor-enrolled-course') ? 'active' : '' }}">
                                    <a href="{{ url('instructor-course') }}">My Course</a>
                                </li>
                                <li class="{{ Request::is('instructor-wishlist') ? 'active' : '' }}"><a
                                        href="{{ url('instructor-wishlist') }}">Wishlist</a></li>
                                <li class="{{ Request::is('instructor-reviews') ? 'active' : '' }}"><a
                                        href="{{ url('instructor-reviews') }}">Reviews</a></li>
                                <li
                                    class="{{ Request::is('instructor-quiz', 'instructor-quiz-details', 'instructor-quiz-attempts-details') ? 'active' : '' }}">
                                    <a href="{{ url('instructor-quiz') }}">My Quiz Attempts</a>
                                </li>
                                <li class="{{ Request::is('instructor-orders') ? 'active' : '' }}"><a
                                        href="{{ url('instructor-orders') }}">Orders</a></li>
                                <li class="{{ Request::is('instructor-qa') ? 'active' : '' }}"><a
                                        href="{{ url('instructor-qa') }}">Question & Answer</a></li>
                                <li class="{{ Request::is('instructor-referral') ? 'active' : '' }}"><a
                                        href="{{ url('instructor-referral') }}">Referrals</a></li>
                                <li class="{{ Request::is('instructor-chat') ? 'active' : '' }}"><a
                                        href="{{ url('instructor-chat') }}">Messages</a></li>
                                <li class="{{ Request::is('instructor-tickets') ? 'active' : '' }}"><a
                                        href="{{ url('instructor-tickets') }}">Support Ticket</a></li>
                                <li class="{{ Request::is('instructor-notifications') ? 'active' : '' }}"><a
                                        href="{{ url('instructor-notifications') }}">Notifications</a></li>
                                <li class="{{ Request::is('instructor-settings') ? 'active' : '' }}"><a
                                        href="{{ url('instructor-settings') }}">Settings</a></li>
                            </ul>
                        </li>
                        <li
                            class="has-submenu {{ Request::is(
                                'students-list',
                                'students-grid',
                                'student-dashboard',
                                'student-profile',
                                'student-courses',
                                'student-wishlist',
                                'student-reviews',
                                'student-quiz',
                                'student-order-history',
                                'student-qa',
                                'student-referral',
                                'student-messages',
                                'student-tickets',
                                'student-settings',
                                'student-change-password',
                                'student-setting-notifications',
                                'student-setting-social-profile',
                                'student-linked-accounts',
                                'student-quiz-details',
                                'setting-student-subscription',
                                'student-notifications',
                                'student-social-profile',
                            )
                                ? 'active'
                                : '' }}">
                            <a href="#">Student <i class="fas fa-chevron-down"></i></a>
                            <ul class="submenu first-submenu">
                                <li
                                    class="has-submenu {{ Request::is('students-list', 'students-grid') ? 'active' : '' }}">
                                    <a class="{{ Request::is('students-list') ? 'active' : '' }}"
                                        href="{{ url('students-list') }}">Student</a>
                                    <ul class="submenu">
                                        <li class="{{ Request::is('students-list') ? 'active' : '' }}"><a
                                                href="{{ url('students-list') }}">List</a></li>
                                        <li class="{{ Request::is('students-grid') ? 'active' : '' }}"><a
                                                href="{{ url('students-grid') }}">Grid</a></li>
                                    </ul>
                                </li>
                                <li class="{{ Request::is('student-dashboard') ? 'active' : '' }}"><a
                                        href="{{ url('student-dashboard') }}">Student Dashboard</a></li>
                                <li class="{{ Request::is('student-profile') ? 'active' : '' }}"><a
                                        href="{{ url('student-profile') }}">My Profile</a></li>
                                <li class="{{ Request::is('student-courses') ? 'active' : '' }}"><a
                                        href="{{ url('student-courses') }}">Enrolled Courses</a></li>
                                <li class="{{ Request::is('student-wishlist') ? 'active' : '' }}"><a
                                        href="{{ url('student-wishlist') }}">Wishlist</a></li>
                                <li class="{{ Request::is('student-reviews') ? 'active' : '' }}"><a
                                        href="{{ url('student-reviews') }}">Reviews</a></li>
                                <li class="{{ Request::is('student-quiz') ? 'active' : '' }}"><a
                                        href="{{ url('student-quiz') }}">My Quiz Attempts</a></li>
                                <li class="{{ Request::is('student-order-history') ? 'active' : '' }}"><a
                                        href="{{ url('student-order-history') }}">Orders</a></li>
                                <li class="{{ Request::is('student-qa') ? 'active' : '' }}"><a
                                        href="{{ url('student-qa') }}">Question & Answer</a></li>
                                <li class="{{ Request::is('student-referral') ? 'active' : '' }}"><a
                                        href="{{ url('student-referral') }}">Referrals</a></li>
                                <li class="{{ Request::is('student-messages') ? 'active' : '' }}"><a
                                        href="{{ url('student-messages') }}">Messages</a></li>
                                <li class="{{ Request::is('student-tickets') ? 'active' : '' }}"><a
                                        href="{{ url('student-tickets') }}">Support Ticket</a></li>
                                <li class="{{ Request::is('student-settings') ? 'active' : '' }}"><a
                                        href="{{ url('student-settings') }}">Settings</a></li>
                            </ul>
                        </li>
                        <li
                            class="has-submenu {{ Request::is(
                                'notifications',
                                'privacy-policy',
                                'pricing-plan',
                                'wishlist',
                                'coming-soon',
                                'error-404',
                                'error-500',
                                'under-construction',
                                'faq',
                                'support',
                                'job-category',
                                'cart',
                                'checkout',
                                'login',
                                'register',
                                'forgot-password',
                                'add-course',
                                'course-list',
                                'course-grid',
                                'course-details',
                                'course-lesson',
                                'term-condition',
                            )
                                ? 'active'
                                : '' }}">
                            <a href="#">Pages <i class="fas fa-chevron-down"></i></a>
                            <ul class="submenu">
                                <li class="{{ Request::is('notifications') ? 'active' : '' }}"><a
                                        href="{{ url('notifications') }}">Notification</a></li>
                                <li class="{{ Request::is('pricing-plan') ? 'active' : '' }}"><a
                                        href="{{ url('pricing-plan') }}">Pricing Plan</a></li>
                                <li class="{{ Request::is('wishlist') ? 'active' : '' }}"><a
                                        href="{{ url('wishlist') }}">Wishlist</a></li>
                                <li
                                    class="has-submenu {{ Request::is('add-course', 'course-list', 'course-grid', 'course-details') ? 'active' : '' }}">
                                    <a href="{{ url('course-list') }}">Course</a>
                                    <ul class="submenu">
                                        <li class="{{ Request::is('add-course') ? 'active' : '' }}"><a
                                                href="{{ url('add-course') }}">Add Course</a></li>
                                        <li class="{{ Request::is('course-list') ? 'active' : '' }}"><a
                                                href="{{ url('course-list') }}">Course List</a></li>
                                        <li class="{{ Request::is('course-grid') ? 'active' : '' }}"><a
                                                href="{{ url('course-grid') }}">Course Grid</a></li>
                                        <li class="{{ Request::is('course-details') ? 'active' : '' }}"><a
                                                href="{{ url('course-details') }}">Course Details</a></li>
                                    </ul>
                                </li>
                                <li
                                    class="has-submenu {{ Request::is('coming-soon', 'error-404', 'error-500', 'under-construction') ? 'active' : '' }}">
                                    <a href="{{ url('coming-soon') }}">Error</a>
                                    <ul class="submenu">
                                        <li><a {{ Request::is('coming-soon') ? 'active' : '' }}
                                                href="{{ url('coming-soon') }}">Coming Soon</a></li>
                                        <li><a {{ Request::is('error-404') ? 'active' : '' }}
                                                href="{{ url('error-404') }}">404</a></li>
                                        <li><a {{ Request::is('error-500') ? 'active' : '' }}
                                                href="{{ url('error-500') }}">500</a></li>
                                        <li><a {{ Request::is('under-construction') ? 'active' : '' }}
                                                href="{{ url('under-construction') }}">Under Construction</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="{{ Request::is('faq') ? 'active' : '' }}"><a
                                        href="{{ url('faq') }}">FAQ</a>
                                </li>
                                <li class="{{ Request::is('support') ? 'active' : '' }}"><a
                                        href="{{ url('support') }}">Support</a></li>
                                <li class="{{ Request::is('job-category') ? 'active' : '' }}"><a
                                        href="{{ url('job-category') }}">Category</a></li>
                                <li class="{{ Request::is('cart') ? 'active' : '' }}"><a
                                        href="{{ url('cart') }}">Cart</a></li>
                                <li class="{{ Request::is('checkout') ? 'active' : '' }}"><a
                                        href="{{ url('checkout') }}">Checkout</a></li>
                                <li class="{{ Request::routeIs('student.login') ? 'active' : '' }}"><a
                                        href="{{ route('student.login') }}">Login</a></li>
                                <li class="{{ Request::is('forgot-password') ? 'active' : '' }}"><a
                                        href="{{ url('forgot-password') }}">Forgot Password</a></li>
                            </ul>
                        </li>
                        <li
                            class="has-submenu {{ Request::is('blog-list', 'blog-grid', 'blog-masonry', 'blog-modern', 'blog-details') ? 'active' : '' }}">
                            <a href="#">Blog <i class="fas fa-chevron-down"></i></a>
                            <ul class="submenu">
                                <li class="{{ Request::is('blog-list') ? 'active' : '' }}"><a
                                        href="{{ url('blog-list') }}">Blog List</a></li>
                                <li class="{{ Request::is('blog-grid') ? 'active' : '' }}"><a
                                        href="{{ url('blog-grid') }}">Blog Grid</a></li>
                                <li class="{{ Request::is('blog-masonry') ? 'active' : '' }}"><a
                                        href="{{ url('blog-masonry') }}">Blog Masonry</a></li>
                                <li class="{{ Request::is('blog-modern') ? 'active' : '' }}"><a
                                        href="{{ url('blog-modern') }}">Blog Modern</a></li>
                                <li class="{{ Request::is('blog-details') ? 'active' : '' }}"><a
                                        href="{{ url('blog-details') }}">Blog Details</a></li>
                            </ul>
                        </li>
                        <li class="login-link">
                            <a href="{{ route('student.login') }}">Signin</a>
                        </li>
                    </ul>
                    @endif
                </div>
                <ul class="nav header-navbar-rht">
                    @if (
                        !Route::is([
                            'instructor-list',
                            'instructor-grid',
                            'instructor-dashboard',
                            'instructor-profile',
                            'instructor-course',
                            'instructor-wishlist',
                            'instructor-reviews',
                            'instructor-quiz',
                            'instructor-orders',
                            'instructor-qa',
                            'instructor-referral',
                            'instructor-chat',
                            'instructor-tickets',
                            'instructor-notifications',
                            'instructor-settings',
                            'instructor-enrolled-course',
                            'students-list',
                            'students-grid',
                            'student-dashboard',
                            'student-profile',
                            'student-courses',
                            'student-wishlist',
                            'student-reviews',
                            'student-quiz',
                            'student-order-history',
                            'student-qa',
                            'student-referral',
                            'student-messages',
                            'student-tickets',
                            'student-settings',
                            'instructor-announcements',
                            'instructor-withdraw',
                            'instructor-quiz-attempts',
                            'instructor-assignment',
                            'instructor-earnings',
                            'instructor-change-password',
                            'instructor-setting-notifications',
                            'instructor-setting-withdraw',
                            'instructor-delete-account',
                            'student-change-password',
                            'student-setting-notifications',
                            'student-setting-social-profile',
                            'student-linked-accounts',
                            'checkout',
                            'course-details',
                            'instructor-quiz-details',
                            'student-quiz-details',
                            'add-course',
                            'cart',
                            'course-grid',
                            'course-list',
                            'student-notifications',
                            'student-social-profile',
                            'add-course',
                        ]))
                        <li class="nav-item">
                            <div>
                                <a href="#" id="dark-mode-toggle" class="dark-mode-toggle  ">
                                    <i class="fa-solid fa-moon"></i>
                                </a>
                                <a href="#" id="light-mode-toggle" class="dark-mode-toggle ">
                                    <i class="fa-solid fa-sun"></i>
                                </a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link header-sign" href="{{ route('student.login') }}">دخول الطلاب</a>
                        </li>
                    @endif
                    @if (Route::is([
                            'instructor-list',
                            'instructor-grid',
                            'instructor-dashboard',
                            'instructor-profile',
                            'instructor-course',
                            'instructor-wishlist',
                            'instructor-reviews',
                            'instructor-quiz',
                            'instructor-orders',
                            'instructor-qa',
                            'instructor-referral',
                            'instructor-chat',
                            'instructor-tickets',
                            'instructor-notifications',
                            'instructor-settings',
                            'instructor-enrolled-course',
                            'students-list',
                            'students-grid',
                            'student-dashboard',
                            'student-profile',
                            'student-courses',
                            'student-wishlist',
                            'student-reviews',
                            'student-quiz',
                            'student-order-history',
                            'student-qa',
                            'student-referral',
                            'student-messages',
                            'student-tickets',
                            'student-settings',
                            'instructor-announcements',
                            'instructor-withdraw',
                            'instructor-quiz-attempts',
                            'instructor-assignment',
                            'instructor-earnings',
                            'instructor-change-password',
                            'instructor-setting-notifications',
                            'instructor-setting-withdraw',
                            'instructor-delete-account',
                            'student-change-password',
                            'student-setting-notifications',
                            'student-setting-social-profile',
                            'student-linked-accounts',
                            'instructor-quiz-details',
                            'student-quiz-details',
                            'student-notifications',
                            'student-social-profile',
                            'add-course',
                        ]))
                        <li class="nav-item user-nav">
                            <div>
                                <a href="#" id="dark-mode-toggle" class="dark-mode-toggle  ">
                                    <i class="fa-solid fa-moon"></i>
                                </a>
                                <a href="#" id="light-mode-toggle" class="dark-mode-toggle ">
                                    <i class="fa-solid fa-sun"></i>
                                </a>
                            </div>
                        </li>
                        <li class="nav-item user-nav">
                            <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">
                                <span class="user-img">
                                    @if (
                                        !Route::is([
                                            'students-list',
                                            'students-grid',
                                            'student-dashboard',
                                            'student-profile',
                                            'student-courses',
                                            'student-wishlist',
                                            'student-reviews',
                                            'student-quiz',
                                            'student-order-history',
                                            'student-qa',
                                            'student-referral',
                                            'student-messages',
                                            'student-tickets',
                                            'student-settings',
                                            'student-change-password',
                                            'student-setting-notifications',
                                            'student-setting-social-profile',
                                            'student-linked-accounts',
                                            'student-quiz-details',
                                            'student-notifications',
                                            'student-social-profile',
                                        ]))
                                        <img src="{{ URL::asset('/build/img/user/user-17.jpg') }}" alt="Img">
                                        <span class="status online"></span>
                                    @endif
                                    @if (Route::is([
                                            'students-list',
                                            'students-grid',
                                            'student-dashboard',
                                            'student-profile',
                                            'student-courses',
                                            'student-wishlist',
                                            'student-reviews',
                                            'student-quiz',
                                            'student-order-history',
                                            'student-qa',
                                            'student-referral',
                                            'student-messages',
                                            'student-tickets',
                                            'student-settings',
                                            'student-change-password',
                                            'student-setting-notifications',
                                            'student-setting-social-profile',
                                            'student-linked-accounts',
                                            'student-quiz-details',
                                            'student-notifications',
                                            'student-social-profile',
                                        ]))
                                        <img src="{{ URL::asset('/build/img/user/user16.jpg') }}" alt="Img">
                                        <span class="status online"></span>
                                    @endif
                                </span>
                            </a>
                            <div class="users dropdown-menu dropdown-menu-right" data-popper-placement="bottom-end">
                                @if (
                                    !Route::is([
                                        'students-list',
                                        'students-grid',
                                        'student-dashboard',
                                        'student-profile',
                                        'student-courses',
                                        'student-wishlist',
                                        'student-reviews',
                                        'student-quiz',
                                        'student-order-history',
                                        'student-qa',
                                        'student-referral',
                                        'student-messages',
                                        'student-tickets',
                                        'student-settings',
                                        'student-notifications',
                                        'student-social-profile',
                                    ]))
                                    <div class="user-header">
                                        <div class="avatar avatar-sm">
                                            <img src="{{ URL::asset('build/img/user/user-17.jpg') }}"
                                                alt="User Image" class="avatar-img rounded-circle">
                                        </div>
                                        <div class="user-text">
                                            <h6>Eugene Andre</h6>
                                            <p class="text-muted mb-0">Instructor</p>
                                        </div>
                                    </div>
                                    <a class="dropdown-item" href="{{ url('instructor-dashboard') }}"><i
                                            class="feather-home me-1"></i> Dashboard</a>
                                    <a class="dropdown-item" href="{{ url('instructor-settings') }}"><i
                                            class="feather-star me-1"></i> Edit Profile</a>
                                    <div class="dropdown-item night-mode">
                                        <span><i class="feather-moon me-1"></i> Night Mode </span>
                                        <div class="form-check form-switch check-on m-0">
                                            <input class="form-check-input" type="checkbox" id="night-mode">
                                        </div>
                                    </div>
                                @endif
                                @if (Route::is([
                                        'students-list',
                                        'students-grid',
                                        'student-dashboard',
                                        'student-profile',
                                        'student-courses',
                                        'student-wishlist',
                                        'student-reviews',
                                        'student-quiz',
                                        'student-order-history',
                                        'student-qa',
                                        'student-referral',
                                        'student-messages',
                                        'student-tickets',
                                        'student-settings',
                                        'student-notifications',
                                        'student-social-profile',
                                    ]))
                                    <div class="user-header">
                                        <div class="avatar avatar-sm">
                                            <img src="{{ URL::asset('build/img/user/user16.jpg') }}"
                                                alt="User Image" class="avatar-img rounded-circle">
                                        </div>
                                        <div class="user-text">
                                            <h6>Rolands R</h6>
                                            <p class="text-muted mb-0">Student</p>
                                        </div>
                                    </div>
                                    <a class="dropdown-item" href="{{ url('student-dashboard') }}"><i
                                            class="feather-home me-1"></i> Dashboard</a>
                                    <a class="dropdown-item" href="{{ url('student-settings') }}"><i
                                            class="feather-user me-1"></i> Profile</a>
                                    <a class="dropdown-item" href="{{ url('setting-student-subscription') }}"><i
                                            class="feather-star me-1"></i> Subscription</a>
                                    <div class="dropdown-item night-mode">
                                        <span><i class="feather-moon me-1"></i> Night Mode </span>
                                        <div class="form-check form-switch check-on m-0">
                                            <input class="form-check-input" type="checkbox" id="night-mode">
                                        </div>
                                    </div>
                                @endif

                                <a class="dropdown-item" href="{{ url('index') }}"><i
                                        class="feather-log-out me-1"></i> Logout</a>
                            </div>
                        </li>
                    @endif
                    @if (Route::is(['checkout', 'course-details', 'cart', 'course-grid', 'course-list']))
                        <li class="nav-item">
                            <div>
                                <a href="#" id="dark-mode-toggle" class="dark-mode-toggle  ">
                                    <i class="fa-solid fa-moon"></i>
                                </a>
                                <a href="#" id="light-mode-toggle" class="dark-mode-toggle ">
                                    <i class="fa-solid fa-sun"></i>
                                </a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('student-messages') }}"><img
                                    src="{{ URL::asset('/build/img/icon/messages.svg') }}" alt="img"></a>
                        </li>
                        <li class="nav-item cart-nav">
                            <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">
                                <img src="{{ URL::asset('/build/img/icon/cart.svg') }}" alt="img">
                            </a>
                            <div class="wishes-list dropdown-menu dropdown-menu-right">
                                <div class="wish-header">
                                    <a href="#">View Cart</a>
                                    <a href="javascript:void(0)" class="float-end">Checkout</a>
                                </div>
                                <div class="wish-content">
                                    <ul>
                                        <li>
                                            <div class="media">
                                                <div class="d-flex media-wide">
                                                    <div class="avatar">
                                                        <a href="{{ url('course-details') }}">
                                                            <img alt="Img"
                                                                src="{{ URL::asset('/build/img/course/course-04.jpg') }}">
                                                        </a>
                                                    </div>
                                                    <div class="media-body">
                                                        <h6><a href="{{ url('course-details') }}">Learn
                                                                Angular...</a></h6>
                                                        <p>By Dave Franco</p>
                                                        <h5>$200 <span>$99.00</span></h5>
                                                    </div>
                                                </div>
                                                <div class="remove-btn">
                                                    <a href="#" class="btn">Remove</a>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="media">
                                                <div class="d-flex media-wide">
                                                    <div class="avatar">
                                                        <a href="{{ url('course-details') }}">
                                                            <img alt="Img"
                                                                src="{{ URL::asset('/build/img/course/course-14.jpg') }}">
                                                        </a>
                                                    </div>
                                                    <div class="media-body">
                                                        <h6><a href="{{ url('course-details') }}">Build Responsive
                                                                Real...</a>
                                                        </h6>
                                                        <p>Jenis R.</p>
                                                        <h5>$200 <span>$99.00</span></h5>
                                                    </div>
                                                </div>
                                                <div class="remove-btn">
                                                    <a href="#" class="btn">Remove</a>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="media">
                                                <div class="d-flex media-wide">
                                                    <div class="avatar">
                                                        <a href="{{ url('course-details') }}">
                                                            <img alt="Img"
                                                                src="{{ URL::asset('/build/img/course/course-15.jpg') }}">
                                                        </a>
                                                    </div>
                                                    <div class="media-body">
                                                        <h6><a href="{{ url('course-details') }}">C# Developers
                                                                Double ...</a>
                                                        </h6>
                                                        <p>Jesse Stevens</p>
                                                        <h5>$200 <span>$99.00</span></h5>
                                                    </div>
                                                </div>
                                                <div class="remove-btn">
                                                    <a href="#" class="btn">Remove</a>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                    <div class="total-item">
                                        <h6>Subtotal : $ 600</h6>
                                        <h5>Total : $ 600</h5>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item wish-nav">
                            <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">
                                <img src="{{ URL::asset('/build/img/icon/wish.svg') }}" alt="img">
                            </a>
                            <div class="wishes-list dropdown-menu dropdown-menu-right">
                                <div class="wish-content">
                                    <ul>
                                        <li>
                                            <div class="media">
                                                <div class="d-flex media-wide">
                                                    <div class="avatar">
                                                        <a href="{{ url('course-details') }}">
                                                            <img alt="Img"
                                                                src="{{ URL::asset('/build/img/course/course-04.jpg') }}">
                                                        </a>
                                                    </div>
                                                    <div class="media-body">
                                                        <h6><a href="{{ url('course-details') }}">Learn
                                                                Angular...</a></h6>
                                                        <p>By Dave Franco</p>
                                                        <h5>$200 <span>$99.00</span></h5>
                                                        <div class="remove-btn">
                                                            <a href="#" class="btn">Add to cart</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="media">
                                                <div class="d-flex media-wide">
                                                    <div class="avatar">
                                                        <a href="{{ url('course-details') }}">
                                                            <img alt="Img"
                                                                src="{{ URL::asset('/build/img/course/course-14.jpg') }}">
                                                        </a>
                                                    </div>
                                                    <div class="media-body">
                                                        <h6><a href="{{ url('course-details') }}">Build Responsive
                                                                Real...</a>
                                                        </h6>
                                                        <p>Jenis R.</p>
                                                        <h5>$200 <span>$99.00</span></h5>
                                                        <div class="remove-btn">
                                                            <a href="#" class="btn">Add to cart</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="media">
                                                <div class="d-flex media-wide">
                                                    <div class="avatar">
                                                        <a href="{{ url('course-details') }}">
                                                            <img alt="Img"
                                                                src="{{ URL::asset('/build/img/course/course-15.jpg') }}">
                                                        </a>
                                                    </div>
                                                    <div class="media-body">
                                                        <h6><a href="{{ url('course-details') }}">C# Developers
                                                                Double ...</a>
                                                        </h6>
                                                        <p>Jesse Stevens</p>
                                                        <h5>$200 <span>$99.00</span></h5>
                                                        <div class="remove-btn">
                                                            <a href="#" class="btn">Remove</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item noti-nav">
                            <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">
                                <img src="{{ URL::asset('/build/img/icon/notification.svg') }}" alt="img">
                            </a>
                            <div class="notifications dropdown-menu dropdown-menu-right">
                                <div class="topnav-dropdown-header">
                                    <span class="notification-title">Notifications
                                        <select>
                                            <option>All</option>
                                            <option>Unread</option>
                                        </select>
                                    </span>
                                    <a href="javascript:void(0)" class="clear-noti">Mark all as read <i
                                            class="fa-solid fa-circle-check"></i></a>
                                </div>
                                <div class="noti-content">
                                    <ul class="notification-list">
                                        <li class="notification-message">
                                            <div class="media d-flex">
                                                <div>
                                                    <a href="{{ url('notifications') }}" class="avatar">
                                                        <img class="avatar-img" alt="Img"
                                                            src="{{ URL::asset('/build/img/user/user1.jpg') }}">
                                                    </a>
                                                </div>
                                                <div class="media-body">
                                                    <h6><a href="{{ url('notifications') }}">Lex Murphy requested
                                                            <span>access
                                                                to</span> UNIX directory tree hierarchy </a></h6>
                                                    <button class="btn btn-accept">Accept</button>
                                                    <button class="btn btn-reject">Reject</button>
                                                    <p>Today at 9:42 AM</p>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="notification-message">
                                            <div class="media d-flex">
                                                <div>
                                                    <a href="{{ url('notifications') }}" class="avatar">
                                                        <img class="avatar-img" alt="Img"
                                                            src="{{ URL::asset('/build/img/user/user2.jpg') }}">
                                                    </a>
                                                </div>
                                                <div class="media-body">
                                                    <h6><a href="{{ url('notifications') }}">Ray Arnold left 6
                                                            <span>comments
                                                                on</span> Isla Nublar SOC2 compliance report</a></h6>
                                                    <p>Yesterday at 11:42 PM</p>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="notification-message">
                                            <div class="media d-flex">
                                                <div>
                                                    <a href="{{ url('notifications') }}" class="avatar">
                                                        <img class="avatar-img" alt="Img"
                                                            src="{{ URL::asset('/build/img/user/user3.jpg') }}">
                                                    </a>
                                                </div>
                                                <div class="media-body">
                                                    <h6><a href="{{ url('notifications') }}">Dennis Nedry
                                                            <span>commented
                                                                on</span> Isla Nublar SOC2 compliance report</a></h6>
                                                    <p class="noti-details">“Oh, I finished de-bugging the phones, but
                                                        the system's compiling for eighteen minutes, or twenty. So, some
                                                        minor systems may go on and off for a while.”</p>
                                                    <p>Yesterday at 5:42 PM</p>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="notification-message">
                                            <div class="media d-flex">
                                                <div>
                                                    <a href="{{ url('notifications') }}" class="avatar">
                                                        <img class="avatar-img" alt="Img"
                                                            src="{{ URL::asset('/build/img/user/user1.jpg') }}">
                                                    </a>
                                                </div>
                                                <div class="media-body">
                                                    <h6><a href="{{ url('notifications') }}">John Hammond
                                                            <span>created</span>
                                                            Isla Nublar SOC2 compliance report </a></h6>
                                                    <p>Last Wednesday at 11:15 AM</p>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item user-nav">
                            <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">
                                <span class="user-img">
                                    <img src="{{ URL::asset('/build/img/user/user11.jpg') }}" alt="Img">
                                    <span class="status online"></span>
                                </span>
                            </a>
                            <div class="users dropdown-menu dropdown-menu-right" data-popper-placement="bottom-end">
                                <div class="user-header">
                                    <div class="avatar avatar-sm">
                                        <img src="{{ URL::asset('/build/img/user/user11.jpg') }}" alt="User Image"
                                            class="avatar-img rounded-circle">
                                    </div>
                                    <div class="user-text">
                                        <h6>Rolands R</h6>
                                        <p class="text-muted mb-0">Student</p>
                                    </div>
                                </div>
                                <a class="dropdown-item" href="{{ url('student-profile') }}"><i
                                        class="feather-user me-1"></i> Profile</a>
                                <a class="dropdown-item" href="{{ url('setting-student-subscription') }}"><i
                                        class="feather-star me-1"></i> Subscription</a>
                                <div class="dropdown-item night-mode">
                                    <span><i class="feather-moon me-1"></i> Night Mode </span>
                                    <div class="form-check form-switch check-on m-0">
                                        <input class="form-check-input" type="checkbox" id="night-mode">
                                    </div>
                                </div>
                                <a class="dropdown-item" href="{{ url('index') }}"><i
                                        class="feather-log-out me-1"></i>
                                    Logout</a>
                            </div>
                        </li>
                    @endif
                </ul>
            </div>
        </nav>
    </div>
    </header>
@endif
<!-- /Header -->

@if (Route::is(['index-two']))
    <!-- Header -->
    <header class="header header-two">
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
                        <a href="{{ url('/') }}" class="navbar-brand logo">
                            <img src="{{ URL::asset('/build/img/logo.svg') }}" class="img-fluid" alt="Logo">
                        </a>
                    </div>
                    <div class="main-menu-wrapper">
                        <div class="menu-header">
                            <a href="{{ url('/') }}" class="menu-logo">
                                <img src="{{ URL::asset('/build/img/logo.svg') }}" class="img-fluid"
                                    alt="Logo">
                            </a>
                            <a id="menu_close" class="menu-close" href="javascript:void(0);">
                                <i class="fas fa-times"></i>
                            </a>
                        </div>
                        <ul class="main-nav">
                            <li
                                class="has-submenu menu-effect {{ Request::is('index', 'index-two', 'index-three', 'index-four', '/') ? 'active' : '' }}">
                                <a href="#">Home <i class="fas fa-chevron-down"></i></a>
                                <ul class="submenu">
                                    <li class="{{ Request::is('index', '/') ? 'active' : '' }}"><a
                                            href="{{ url('index') }}">Home</a></li>
                                    <li class="{{ Request::is('index-two') ? 'active' : '' }}"><a
                                            href="{{ url('index-two') }}">Home Two</a></li>
                                    <li class="{{ Request::is('index-three') ? 'active' : '' }}"><a
                                            href="{{ url('index-three') }}">Home Three</a></li>
                                    <li class="{{ Request::is('index-four') ? 'active' : '' }}"><a
                                            href="{{ url('index-four') }}">Home Four</a></li>
                                </ul>
                            </li>
                            <li
                                class="has-submenu {{ Request::is('instructor-list', 'instructor-grid', 'instructor-dashboard', 'instructor-profile', 'instructor-course', 'instructor-wishlist', 'instructor-reviews', 'instructor-quiz', 'instructor-orders', 'instructor-qa', 'instructor-referral', 'instructor-chat', 'instructor-tickets', 'instructor-notifications', 'instructor-settings', 'instructor-enrolled-course', 'instructor-announcements', 'instructor-withdraw', 'instructor-quiz-attempts', 'instructor-assignment', 'instructor-earnings', 'instructor-change-password', 'instructor-setting-notifications', 'instructor-setting-withdraw', 'instructor-delete-account', 'instructor-quiz-details', 'instructor-quiz-attempts-details') ? 'active' : '' }}">
                                <a href="#">Instructor <i class="fas fa-chevron-down"></i></a>
                                <ul class="submenu">
                                    <li
                                        class="has-submenu {{ Request::is('instructor-list', 'instructor-grid') ? 'active' : '' }}">
                                        <a href="{{ url('instructor-list') }}"
                                            class="{{ Request::is('instructor-list') ? 'active' : '' }}">Instructor</a>
                                        <ul class="submenu">
                                            <li class="{{ Request::is('instructor-list') ? 'active' : '' }}"><a
                                                    href="{{ url('instructor-list') }}">List</a></li>
                                            <li class="{{ Request::is('instructor-grid') ? 'active' : '' }}"><a
                                                    href="{{ url('instructor-grid') }}">Grid</a></li>
                                        </ul>
                                    </li>
                                    <li><a class="{{ Request::is('instructor-dashboard') ? 'active' : '' }}"
                                            href="{{ url('instructor-dashboard') }}">Dashboard</a></li>
                                    <li><a class="{{ Request::is('instructor-profile') ? 'active' : '' }}"
                                            href="{{ url('instructor-profile') }}">My Profile</a></li>
                                    <li><a class="{{ Request::is('instructor-course', 'instructor-enrolled-course') ? 'active' : '' }}"
                                            href="{{ url('instructor-course') }}">My Course</a></li>
                                    <li><a class="{{ Request::is('instructor-wishlist') ? 'active' : '' }}"
                                            href="{{ url('instructor-wishlist') }}">Wishlist</a></li>
                                    <li><a class="{{ Request::is('instructor-reviews') ? 'active' : '' }}"
                                            href="{{ url('instructor-reviews') }}">Reviews</a></li>
                                    <li><a class="{{ Request::is('instructor-quiz') ? 'active' : '' }}"
                                            href="{{ url('instructor-quiz') }}">My Quiz Attempts</a></li>
                                    <li><a class="{{ Request::is('instructor-orders') ? 'active' : '' }}"
                                            href="{{ url('instructor-orders') }}">Orders</a></li>
                                    <li><a class="{{ Request::is('instructor-qa') ? 'active' : '' }}"
                                            href="{{ url('instructor-qa') }}">Question & Answer</a></li>
                                    <li><a class="{{ Request::is('instructor-referral') ? 'active' : '' }}"
                                            href="{{ url('instructor-referral') }}">Referrals</a></li>
                                    <li><a class="{{ Request::is('instructor-chat') ? 'active' : '' }}"
                                            href="{{ url('instructor-chat') }}">Messages</a></li>
                                    <li><a class="{{ Request::is('instructor-tickets') ? 'active' : '' }}"
                                            href="{{ url('instructor-tickets') }}">Support Ticket</a></li>
                                    <li><a class="{{ Request::is('instructor-notifications') ? 'active' : '' }}"
                                            href="{{ url('instructor-notifications') }}">Notifications</a></li>
                                    <li><a class="{{ Request::is('instructor-settings') ? 'active' : '' }}"
                                            href="{{ url('instructor-settings') }}">Settings</a></li>
                                </ul>
                            </li>
                            <li
                                class="has-submenu {{ Request::is(
                                    'students-list',
                                    'students-grid',
                                    'student-dashboard',
                                    'student-profile',
                                    'student-courses',
                                    'student-wishlist',
                                    'student-reviews',
                                    'student-quiz',
                                    'student-order-history',
                                    'student-qa',
                                    'student-referral',
                                    'student-messages',
                                    'student-tickets',
                                    'student-settings',
                                    'student-change-password',
                                    'student-setting-notifications',
                                    'student-setting-social-profile',
                                    'student-linked-accounts',
                                    'student-quiz-details',
                                    'setting-student-subscription',
                                    'student-notifications',
                                    'student-social-profile',
                                )
                                    ? 'active'
                                    : '' }}">
                                <a href="#">Student <i class="fas fa-chevron-down"></i></a>
                                <ul class="submenu first-submenu">
                                    <li
                                        class="has-submenu {{ Request::is('students-list', 'students-grid') ? 'active' : '' }}">
                                        <a class="{{ Request::is('students-list') ? 'active' : '' }}"
                                            href="{{ url('students-list') }}">Student</a>
                                        <ul class="submenu">
                                            <li><a class="{{ Request::is('students-list') ? 'active' : '' }}"
                                                    href="{{ url('students-list') }}">List</a></li>
                                            <li><a class="{{ Request::is('students-grid') ? 'active' : '' }}"
                                                    href="{{ url('students-grid') }}">Grid</a></li>
                                        </ul>
                                    </li>
                                    <li><a class="{{ Request::is('student-dashboard') ? 'active' : '' }}"
                                            href="{{ url('student-dashboard') }}">Student Dashboard</a></li>
                                    <li><a class="{{ Request::is('student-profile') ? 'active' : '' }}"
                                            href="{{ url('student-profile') }}">My Profile</a></li>
                                    <li><a class="{{ Request::is('student-courses') ? 'active' : '' }}"
                                            href="{{ url('student-courses') }}">Enrolled Courses</a></li>
                                    <li><a class="{{ Request::is('student-wishlist') ? 'active' : '' }}"
                                            href="{{ url('student-wishlist') }}">Wishlist</a></li>
                                    <li><a class="{{ Request::is('student-reviews') ? 'active' : '' }}"
                                            href="{{ url('student-reviews') }}">Reviews</a></li>
                                    <li><a class="{{ Request::is('student-quiz') ? 'active' : '' }}"
                                            href="{{ url('student-quiz') }}">My Quiz Attempts</a></li>
                                    <li><a class="{{ Request::is('student-order-history') ? 'active' : '' }}"
                                            href="{{ url('student-order-history') }}">Orders</a></li>
                                    <li><a class="{{ Request::is('student-qa') ? 'active' : '' }}"
                                            href="{{ url('student-qa') }}">Question & Answer</a></li>
                                    <li><a class="{{ Request::is('student-referral') ? 'active' : '' }}"
                                            href="{{ url('student-referral') }}">Referrals</a></li>
                                    <li><a class="{{ Request::is('student-messages') ? 'active' : '' }}"
                                            href="{{ url('student-messages') }}">Messages</a></li>
                                    <li><a class="{{ Request::is('student-tickets') ? 'active' : '' }}"
                                            href="{{ url('student-tickets') }}">Support Ticket</a></li>
                                    <li><a class="{{ Request::is('student-settings') ? 'active' : '' }}"
                                            href="{{ url('student-settings') }}">Settings</a></li>
                                </ul>
                            </li>
                            <li
                                class="has-submenu menu-effect {{ Request::is(
                                    'notifications',
                                    'privacy-policy',
                                    'pricing-plan',
                                    'wishlist',
                                    'coming-soon',
                                    'error-404',
                                    'error-500',
                                    'under-construction',
                                    'faq',
                                    'support',
                                    'job-category',
                                    'cart',
                                    'checkout',
                                    'login',
                                    'register',
                                    'forgot-password',
                                )
                                    ? 'active'
                                    : '' }}">
                                <a href="#">Pages <i class="fas fa-chevron-down"></i></a>
                                <ul class="submenu">
                                    <li><a class="{{ Request::is('notifications') ? 'active' : '' }}"
                                            href="{{ url('notifications') }}">Notification</a></li>
                                    <li><a class="{{ Request::is('pricing-plan') ? 'active' : '' }}"
                                            href="{{ url('pricing-plan') }}">Pricing Plan</a></li>
                                    <li><a class="{{ Request::is('wishlist') ? 'active' : '' }}"
                                            href="{{ url('wishlist') }}">Wishlist</a></li>
                                    <li
                                        class="has-submenu {{ Request::is('add-course', 'course-list', 'course-grid', 'course-details') ? 'active' : '' }}">
                                        <a href="{{ url('course-list') }}">Course</a>
                                        <ul class="submenu">
                                            <li><a class="{{ Request::is('add-course') ? 'active' : '' }}"
                                                    href="{{ url('add-course') }}">Add Course</a></li>
                                            <li><a class="{{ Request::is('course-list') ? 'active' : '' }}"
                                                    href="{{ url('course-list') }}">Course List</a></li>
                                            <li><a class="{{ Request::is('course-grid') ? 'active' : '' }}"
                                                    href="{{ url('course-grid') }}">Course Grid</a></li>
                                            <li><a class="{{ Request::is('course-details') ? 'active' : '' }}"
                                                    href="{{ url('course-details') }}">Course Details</a></li>
                                        </ul>
                                    </li>
                                    <li
                                        class="has-submenu {{ Request::is('coming-soon', 'error-404', 'error-500', 'under-construction') ? 'active' : '' }}">
                                        <a href="{{ url('coming-soon') }}">Error</a>
                                        <ul class="submenu">
                                            <li><a {{ Request::is('coming-soon') ? 'active' : '' }}
                                                    href="{{ url('coming-soon') }}">Coming Soon</a></li>
                                            <li><a {{ Request::is('error-404') ? 'active' : '' }}
                                                    href="{{ url('error-404') }}">404</a></li>
                                            <li><a {{ Request::is('error-500') ? 'active' : '' }}
                                                    href="{{ url('error-500') }}">500</a></li>
                                            <li><a {{ Request::is('under-construction') ? 'active' : '' }}
                                                    href="{{ url('under-construction') }}">Under Construction</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="{{ Request::is('faq') ? 'active' : '' }}"><a
                                            href="{{ url('faq') }}">FAQ</a>
                                    </li>
                                    <li class="{{ Request::is('support') ? 'active' : '' }}"><a
                                            href="{{ url('support') }}">Support</a></li>
                                    <li class="{{ Request::is('job-category') ? 'active' : '' }}"><a
                                            href="{{ url('job-category') }}">Category</a></li>
                                    <li class="{{ Request::is('cart') ? 'active' : '' }}"><a
                                            href="{{ url('cart') }}">Cart</a></li>
                                    <li class="{{ Request::is('checkout') ? 'active' : '' }}"><a
                                            href="{{ url('checkout') }}">Checkout</a></li>
                                    <li class="{{ Request::is('login') ? 'active' : '' }}"><a
                                            href="{{ route('student.login') }}">Login</a></li>
                                    <li class="{{ Request::is('forgot-password') ? 'active' : '' }}"><a
                                            href="{{ url('forgot-password') }}">Forgot Password</a></li>
                                </ul>
                            </li>
                            <li
                                class="has-submenu menu-effect {{ Request::is('blog-list', 'blog-grid', 'blog-masonry', 'blog-modern', 'blog-details') ? 'active' : '' }}">
                                <a href="#">Blog <i class="fas fa-chevron-down"></i></a>
                                <ul class="submenu">
                                    <li class="{{ Request::is('blog-list') ? 'active' : '' }}"><a
                                            href="{{ url('blog-list') }}">Blog List</a></li>
                                    <li class="{{ Request::is('blog-grid') ? 'active' : '' }}"><a
                                            href="{{ url('blog-grid') }}">Blog Grid</a></li>
                                    <li class="{{ Request::is('blog-masonry') ? 'active' : '' }}"><a
                                            href="{{ url('blog-masonry') }}">Blog Masonry</a></li>
                                    <li class="{{ Request::is('blog-modern') ? 'active' : '' }}"><a
                                            href="{{ url('blog-modern') }}">Blog Modern</a></li>
                                    <li class="{{ Request::is('blog-details') ? 'active' : '' }}"><a
                                            href="{{ url('blog-details') }}">Blog Details</a></li>
                                </ul>
                            </li>
                            <li class="login-link">
                                <a href="{{ route('student.login') }}">Signin</a>
                            </li>
                        </ul>
                    </div>
                    <ul class="nav header-navbar-rht">
                        <li class="nav-item">
                            <div>
                                <a href="#" id="dark-mode-toggle" class="dark-mode-toggle  ">
                                    <i class="fa-solid fa-moon"></i>
                                </a>
                                <a href="#" id="light-mode-toggle" class="dark-mode-toggle ">
                                    <i class="fa-solid fa-sun"></i>
                                </a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="login-head button" href="{{ route('student.login') }}">Login</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>
    <!-- /Header -->
@endif
@if (Route::is(['index-three']))
    <!-- Header -->
    <header class="header-three">
        <div class="header-fixed-three header-fixed">
            <nav class="navbar navbar-expand-lg header-nav-three scroll-sticky">
                <div class="container">
                    <div class="navbar-header">
                        <a id="mobile_btn" href="javascript:void(0);">
                            <span class="bar-icon">
                                <span></span>
                                <span></span>
                                <span></span>
                            </span>
                        </a>
                        <a href="{{ url('index') }}" class="navbar-brand logo">
                            <img src="{{ URL::asset('/build/img/logo/logo.png') }}" class="img-fluid"
                                alt="Logo">
                        </a>
                    </div>
                    <div class="main-menu-wrapper">
                        <div class="menu-header">
                            <a href="{{ url('index') }}" class="menu-logo">
                                <img src="{{ URL::asset('/build/img/logo/logo.svg') }}" class="img-fluid"
                                    alt="Logo">
                            </a>
                            <a id="menu_close" class="menu-close" href="javascript:void(0);">
                                <i class="fas fa-times"></i>
                            </a>
                        </div>
                        <ul class="main-nav">
                            <li
                                class="has-submenu {{ Request::is('index', 'index-two', 'index-three', 'index-four', '/') ? 'active' : '' }}">
                                <a href="#">Home <i class="fas fa-chevron-down"></i></a>
                                <ul class="submenu">
                                    <li class="{{ Request::is('index', '/') ? 'active' : '' }}"><a
                                            href="{{ url('index') }}">Home</a></li>
                                    <li class="{{ Request::is('index-two') ? 'active' : '' }}"><a
                                            href="{{ url('index-two') }}">Home Two</a></li>
                                    <li class="{{ Request::is('index-three') ? 'active' : '' }}"><a
                                            href="{{ url('index-three') }}">Home Three</a></li>
                                    <li class="{{ Request::is('index-four') ? 'active' : '' }}"><a
                                            href="{{ url('index-four') }}">Home Four</a></li>
                                </ul>
                            </li>
                            <li
                                class="has-submenu {{ Request::is('instructor-list', 'instructor-grid', 'instructor-dashboard', 'instructor-profile', 'instructor-course', 'instructor-wishlist', 'instructor-reviews', 'instructor-quiz', 'instructor-orders', 'instructor-qa', 'instructor-referral', 'instructor-chat', 'instructor-tickets', 'instructor-notifications', 'instructor-settings', 'instructor-enrolled-course', 'instructor-announcements', 'instructor-withdraw', 'instructor-quiz-attempts', 'instructor-assignment', 'instructor-earnings', 'instructor-change-password', 'instructor-setting-notifications', 'instructor-setting-withdraw', 'instructor-delete-account', 'instructor-quiz-details', 'instructor-quiz-attempts-details') ? 'active' : '' }}">
                                <a href="#">Instructor <i class="fas fa-chevron-down"></i></a>
                                <ul class="submenu">
                                    <li
                                        class="has-submenu {{ Request::is('instructor-list', 'instructor-grid') ? 'active' : '' }}">
                                        <a href="{{ url('instructor-list') }}"
                                            class="{{ Request::is('instructor-list') ? 'active' : '' }}">Instructor</a>
                                        <ul class="submenu">
                                            <li class="{{ Request::is('instructor-list') ? 'active' : '' }}"><a
                                                    href="{{ url('instructor-list') }}">List</a></li>
                                            <li class="{{ Request::is('instructor-grid') ? 'active' : '' }}"><a
                                                    href="{{ url('instructor-grid') }}">Grid</a></li>
                                        </ul>
                                    </li>
                                    <li><a class="{{ Request::is('instructor-dashboard') ? 'active' : '' }}"
                                            href="{{ url('instructor-dashboard') }}">Dashboard</a></li>
                                    <li><a class="{{ Request::is('instructor-profile') ? 'active' : '' }}"
                                            href="{{ url('instructor-profile') }}">My Profile</a></li>
                                    <li><a class="{{ Request::is('instructor-course', 'instructor-enrolled-course') ? 'active' : '' }}"
                                            href="{{ url('instructor-course') }}">My Course</a></li>
                                    <li><a class="{{ Request::is('instructor-wishlist') ? 'active' : '' }}"
                                            href="{{ url('instructor-wishlist') }}">Wishlist</a></li>
                                    <li><a class="{{ Request::is('instructor-reviews') ? 'active' : '' }}"
                                            href="{{ url('instructor-reviews') }}">Reviews</a></li>
                                    <li><a class="{{ Request::is('instructor-quiz') ? 'active' : '' }}"
                                            href="{{ url('instructor-quiz') }}">My Quiz Attempts</a></li>
                                    <li><a class="{{ Request::is('instructor-orders') ? 'active' : '' }}"
                                            href="{{ url('instructor-orders') }}">Orders</a></li>
                                    <li><a class="{{ Request::is('instructor-qa') ? 'active' : '' }}"
                                            href="{{ url('instructor-qa') }}">Question & Answer</a></li>
                                    <li><a class="{{ Request::is('instructor-referral') ? 'active' : '' }}"
                                            href="{{ url('instructor-referral') }}">Referrals</a></li>
                                    <li><a class="{{ Request::is('instructor-chat') ? 'active' : '' }}"
                                            href="{{ url('instructor-chat') }}">Messages</a></li>
                                    <li><a class="{{ Request::is('instructor-tickets') ? 'active' : '' }}"
                                            href="{{ url('instructor-tickets') }}">Support Ticket</a></li>
                                    <li><a class="{{ Request::is('instructor-notifications') ? 'active' : '' }}"
                                            href="{{ url('instructor-notifications') }}">Notifications</a></li>
                                    <li><a class="{{ Request::is('instructor-settings') ? 'active' : '' }}"
                                            href="{{ url('instructor-settings') }}">Settings</a></li>
                                </ul>
                            </li>
                            <li
                                class="has-submenu {{ Request::is(
                                    'students-list',
                                    'students-grid',
                                    'student-dashboard',
                                    'student-profile',
                                    'student-courses',
                                    'student-wishlist',
                                    'student-reviews',
                                    'student-quiz',
                                    'student-order-history',
                                    'student-qa',
                                    'student-referral',
                                    'student-messages',
                                    'student-tickets',
                                    'student-settings',
                                    'student-change-password',
                                    'student-setting-notifications',
                                    'student-setting-social-profile',
                                    'student-linked-accounts',
                                    'student-quiz-details',
                                    'setting-student-subscription',
                                    'student-notifications',
                                    'student-social-profile',
                                )
                                    ? 'active'
                                    : '' }}">
                                <a href="#">Student <i class="fas fa-chevron-down"></i></a>
                                <ul class="submenu first-submenu">
                                    <li
                                        class="has-submenu {{ Request::is('students-list', 'students-grid') ? 'active' : '' }}">
                                        <a class="{{ Request::is('students-list') ? 'active' : '' }}"
                                            href="{{ url('students-list') }}">Student</a>
                                        <ul class="submenu">
                                            <li><a class="{{ Request::is('students-list') ? 'active' : '' }}"
                                                    href="{{ url('students-list') }}">List</a></li>
                                            <li><a class="{{ Request::is('students-grid') ? 'active' : '' }}"
                                                    href="{{ url('students-grid') }}">Grid</a></li>
                                        </ul>
                                    </li>
                                    <li><a class="{{ Request::is('student-dashboard') ? 'active' : '' }}"
                                            href="{{ url('student-dashboard') }}">Student Dashboard</a></li>
                                    <li><a class="{{ Request::is('student-profile') ? 'active' : '' }}"
                                            href="{{ url('student-profile') }}">My Profile</a></li>
                                    <li><a class="{{ Request::is('student-courses') ? 'active' : '' }}"
                                            href="{{ url('student-courses') }}">Enrolled Courses</a></li>
                                    <li><a class="{{ Request::is('student-wishlist') ? 'active' : '' }}"
                                            href="{{ url('student-wishlist') }}">Wishlist</a></li>
                                    <li><a class="{{ Request::is('student-reviews') ? 'active' : '' }}"
                                            href="{{ url('student-reviews') }}">Reviews</a></li>
                                    <li><a class="{{ Request::is('student-quiz') ? 'active' : '' }}"
                                            href="{{ url('student-quiz') }}">My Quiz Attempts</a></li>
                                    <li><a class="{{ Request::is('student-order-history') ? 'active' : '' }}"
                                            href="{{ url('student-order-history') }}">Orders</a></li>
                                    <li><a class="{{ Request::is('student-qa') ? 'active' : '' }}"
                                            href="{{ url('student-qa') }}">Question & Answer</a></li>
                                    <li><a class="{{ Request::is('student-referral') ? 'active' : '' }}"
                                            href="{{ url('student-referral') }}">Referrals</a></li>
                                    <li><a class="{{ Request::is('student-messages') ? 'active' : '' }}"
                                            href="{{ url('student-messages') }}">Messages</a></li>
                                    <li><a class="{{ Request::is('student-tickets') ? 'active' : '' }}"
                                            href="{{ url('student-tickets') }}">Support Ticket</a></li>
                                    <li><a class="{{ Request::is('student-settings') ? 'active' : '' }}"
                                            href="{{ url('student-settings') }}">Settings</a></li>
                                </ul>
                            </li>
                            <li
                                class="has-submenu {{ Request::is(
                                    'notifications',
                                    'privacy-policy',
                                    'pricing-plan',
                                    'wishlist',
                                    'coming-soon',
                                    'error-404',
                                    'error-500',
                                    'under-construction',
                                    'faq',
                                    'support',
                                    'job-category',
                                    'cart',
                                    'checkout',
                                    'login',
                                    'register',
                                    'forgot-password',
                                )
                                    ? 'active'
                                    : '' }}">
                                <a href="#">Pages <i class="fas fa-chevron-down"></i></a>
                                <ul class="submenu">
                                    <li><a class="{{ Request::is('notifications') ? 'active' : '' }}"
                                            href="{{ url('notifications') }}">Notification</a></li>
                                    <li><a class="{{ Request::is('pricing-plan') ? 'active' : '' }}"
                                            href="{{ url('pricing-plan') }}">Pricing Plan</a></li>
                                    <li><a class="{{ Request::is('wishlist') ? 'active' : '' }}"
                                            href="{{ url('wishlist') }}">Wishlist</a></li>
                                    <li
                                        class="has-submenu {{ Request::is('add-course', 'course-list', 'course-grid', 'course-details') ? 'active' : '' }}">
                                        <a href="{{ url('course-list') }}">Course</a>
                                        <ul class="submenu">
                                            <li><a class="{{ Request::is('add-course') ? 'active' : '' }}"
                                                    href="{{ url('add-course') }}">Add Course</a></li>
                                            <li><a class="{{ Request::is('course-list') ? 'active' : '' }}"
                                                    href="{{ url('course-list') }}">Course List</a></li>
                                            <li><a class="{{ Request::is('course-grid') ? 'active' : '' }}"
                                                    href="{{ url('course-grid') }}">Course Grid</a></li>
                                            <li><a class="{{ Request::is('course-details') ? 'active' : '' }}"
                                                    href="{{ url('course-details') }}">Course Details</a></li>
                                        </ul>
                                    </li>
                                    <li
                                        class="has-submenu {{ Request::is('coming-soon', 'error-404', 'error-500', 'under-construction') ? 'active' : '' }}">
                                        <a href="{{ url('coming-soon') }}">Error</a>
                                        <ul class="submenu">
                                            <li><a {{ Request::is('coming-soon') ? 'active' : '' }}
                                                    href="{{ url('coming-soon') }}">Coming Soon</a></li>
                                            <li><a {{ Request::is('error-404') ? 'active' : '' }}
                                                    href="{{ url('error-404') }}">404</a></li>
                                            <li><a {{ Request::is('error-500') ? 'active' : '' }}
                                                    href="{{ url('error-500') }}">500</a></li>
                                            <li><a {{ Request::is('under-construction') ? 'active' : '' }}
                                                    href="{{ url('under-construction') }}">Under Construction</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="{{ Request::is('faq') ? 'active' : '' }}"><a
                                            href="{{ url('faq') }}">FAQ</a>
                                    </li>
                                    <li class="{{ Request::is('support') ? 'active' : '' }}"><a
                                            href="{{ url('support') }}">Support</a></li>
                                    <li class="{{ Request::is('job-category') ? 'active' : '' }}"><a
                                            href="{{ url('job-category') }}">Category</a></li>
                                    <li class="{{ Request::is('cart') ? 'active' : '' }}"><a
                                            href="{{ url('cart') }}">Cart</a></li>
                                    <li class="{{ Request::is('checkout') ? 'active' : '' }}"><a
                                            href="{{ url('checkout') }}">Checkout</a></li>
                                    <li class="{{ Request::is('login') ? 'active' : '' }}"><a
                                            href="{{ route('student.login') }}">Login</a></li>
                                    <li class="{{ Request::is('forgot-password') ? 'active' : '' }}"><a
                                            href="{{ url('forgot-password') }}">Forgot Password</a></li>
                                </ul>
                            </li>
                            <li
                                class="has-submenu {{ Request::is('blog-list', 'blog-grid', 'blog-masonry', 'blog-modern', 'blog-details') ? 'active' : '' }}">
                                <a href="#">Blog <i class="fas fa-chevron-down"></i></a>
                                <ul class="submenu">
                                    <li class="{{ Request::is('blog-list') ? 'active' : '' }}"><a
                                            href="{{ url('blog-list') }}">Blog List</a></li>
                                    <li class="{{ Request::is('blog-grid') ? 'active' : '' }}"><a
                                            href="{{ url('blog-grid') }}">Blog Grid</a></li>
                                    <li class="{{ Request::is('blog-masonry') ? 'active' : '' }}"><a
                                            href="{{ url('blog-masonry') }}">Blog Masonry</a></li>
                                    <li class="{{ Request::is('blog-modern') ? 'active' : '' }}"><a
                                            href="{{ url('blog-modern') }}">Blog Modern</a></li>
                                    <li class="{{ Request::is('blog-details') ? 'active' : '' }}"><a
                                            href="{{ url('blog-details') }}">Blog Details</a></li>
                                </ul>
                            </li>
                            <li class="login-link">
                                <a href="{{ route('student.login') }}">Signin</a>
                            </li>
                        </ul>
                    </div>
                    <ul class="nav header-navbar-rht align-items-center">
                        <li class="nav-item">
                            <div>
                                <a href="#" id="dark-mode-toggle" class="dark-mode-toggle  ">
                                    <i class="fa-solid fa-moon"></i>
                                </a>
                                <a href="#" id="light-mode-toggle" class="dark-mode-toggle ">
                                    <i class="fa-solid fa-sun"></i>
                                </a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link login-three-head button"
                                href="{{ route('student.login') }}"><span>Login</span></a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>
    <!-- /Header -->
@endif
@if (Route::is(['index-four']))
    <!-- Header -->
    <header class="header-five">
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
                        <a href="{{ url('index') }}" class="navbar-brand logo">
                            <img src="{{ URL::asset('/build/img/logo/logo-five.png') }}" class="img-fluid"
                                alt="Logo">
                        </a>
                    </div>
                    <div class="main-menu-wrapper">
                        <div class="menu-header">
                            <a href="{{ url('index') }}" class="menu-logo">
                                <img src="{{ URL::asset('/build/img/logo/logo-five.svg') }}" class="img-fluid"
                                    alt="Logo">
                            </a>
                            <a id="menu_close" class="menu-close" href="javascript:void(0);">
                                <i class="fas fa-times"></i>
                            </a>
                        </div>
                        <ul class="main-nav">
                            <li
                                class="has-submenu {{ Request::is('index', 'index-two', 'index-three', 'index-four', '/') ? 'active' : '' }}">
                                <a href="#">Home <i class="fas fa-chevron-down"></i></a>
                                <ul class="submenu">
                                    <li class="{{ Request::is('index', '/') ? 'active' : '' }}"><a
                                            href="{{ url('index') }}">Home</a></li>
                                    <li class="{{ Request::is('index-two') ? 'active' : '' }}"><a
                                            href="{{ url('index-two') }}">Home Two</a></li>
                                    <li class="{{ Request::is('index-three') ? 'active' : '' }}"><a
                                            href="{{ url('index-three') }}">Home Three</a></li>
                                    <li class="{{ Request::is('index-four') ? 'active' : '' }}"><a
                                            href="{{ url('index-four') }}">Home Four</a></li>
                                </ul>
                            </li>
                            <li
                                class="has-submenu {{ Request::is('instructor-list', 'instructor-grid', 'instructor-dashboard', 'instructor-profile', 'instructor-course', 'instructor-wishlist', 'instructor-reviews', 'instructor-quiz', 'instructor-orders', 'instructor-qa', 'instructor-referral', 'instructor-chat', 'instructor-tickets', 'instructor-notifications', 'instructor-settings', 'instructor-enrolled-course', 'instructor-announcements', 'instructor-withdraw', 'instructor-quiz-attempts', 'instructor-assignment', 'instructor-earnings', 'instructor-change-password', 'instructor-setting-notifications', 'instructor-setting-withdraw', 'instructor-delete-account', 'instructor-quiz-details', 'instructor-quiz-attempts-details') ? 'active' : '' }}">
                                <a href="#">Instructor <i class="fas fa-chevron-down"></i></a>
                                <ul class="submenu">
                                    <li
                                        class="has-submenu {{ Request::is('instructor-list', 'instructor-grid') ? 'active' : '' }}">
                                        <a href="{{ url('instructor-list') }}"
                                            class="{{ Request::is('instructor-list') ? 'active' : '' }}">Instructor</a>
                                        <ul class="submenu">
                                            <li class="{{ Request::is('instructor-list') ? 'active' : '' }}"><a
                                                    href="{{ url('instructor-list') }}">List</a></li>
                                            <li class="{{ Request::is('instructor-grid') ? 'active' : '' }}"><a
                                                    href="{{ url('instructor-grid') }}">Grid</a></li>
                                        </ul>
                                    </li>
                                    <li><a class="{{ Request::is('instructor-dashboard') ? 'active' : '' }}"
                                            href="{{ url('instructor-dashboard') }}">Dashboard</a></li>
                                    <li><a class="{{ Request::is('instructor-profile') ? 'active' : '' }}"
                                            href="{{ url('instructor-profile') }}">My Profile</a></li>
                                    <li><a class="{{ Request::is('instructor-course', 'instructor-enrolled-course') ? 'active' : '' }}"
                                            href="{{ url('instructor-course') }}">My Course</a></li>
                                    <li><a class="{{ Request::is('instructor-wishlist') ? 'active' : '' }}"
                                            href="{{ url('instructor-wishlist') }}">Wishlist</a></li>
                                    <li><a class="{{ Request::is('instructor-reviews') ? 'active' : '' }}"
                                            href="{{ url('instructor-reviews') }}">Reviews</a></li>
                                    <li><a class="{{ Request::is('instructor-quiz') ? 'active' : '' }}"
                                            href="{{ url('instructor-quiz') }}">My Quiz Attempts</a></li>
                                    <li><a class="{{ Request::is('instructor-orders') ? 'active' : '' }}"
                                            href="{{ url('instructor-orders') }}">Orders</a></li>
                                    <li><a class="{{ Request::is('instructor-qa') ? 'active' : '' }}"
                                            href="{{ url('instructor-qa') }}">Question & Answer</a></li>
                                    <li><a class="{{ Request::is('instructor-referral') ? 'active' : '' }}"
                                            href="{{ url('instructor-referral') }}">Referrals</a></li>
                                    <li><a class="{{ Request::is('instructor-chat') ? 'active' : '' }}"
                                            href="{{ url('instructor-chat') }}">Messages</a></li>
                                    <li><a class="{{ Request::is('instructor-tickets') ? 'active' : '' }}"
                                            href="{{ url('instructor-tickets') }}">Support Ticket</a></li>
                                    <li><a class="{{ Request::is('instructor-notifications') ? 'active' : '' }}"
                                            href="{{ url('instructor-notifications') }}">Notifications</a></li>
                                    <li><a class="{{ Request::is('instructor-settings') ? 'active' : '' }}"
                                            href="{{ url('instructor-settings') }}">Settings</a></li>
                                </ul>
                            </li>
                            <li
                                class="has-submenu {{ Request::is(
                                    'students-list',
                                    'students-grid',
                                    'student-dashboard',
                                    'student-profile',
                                    'student-courses',
                                    'student-wishlist',
                                    'student-reviews',
                                    'student-quiz',
                                    'student-order-history',
                                    'student-qa',
                                    'student-referral',
                                    'student-messages',
                                    'student-tickets',
                                    'student-settings',
                                    'student-change-password',
                                    'student-setting-notifications',
                                    'student-setting-social-profile',
                                    'student-linked-accounts',
                                    'student-quiz-details',
                                    'setting-student-subscription',
                                    'student-notifications',
                                    'student-social-profile',
                                )
                                    ? 'active'
                                    : '' }}">
                                <a href="#">Student <i class="fas fa-chevron-down"></i></a>
                                <ul class="submenu first-submenu">
                                    <li
                                        class="has-submenu {{ Request::is('students-list', 'students-grid') ? 'active' : '' }}">
                                        <a class="{{ Request::is('students-list') ? 'active' : '' }}"
                                            href="{{ url('students-list') }}">Student</a>
                                        <ul class="submenu">
                                            <li><a class="{{ Request::is('students-list') ? 'active' : '' }}"
                                                    href="{{ url('students-list') }}">List</a></li>
                                            <li><a class="{{ Request::is('students-grid') ? 'active' : '' }}"
                                                    href="{{ url('students-grid') }}">Grid</a></li>
                                        </ul>
                                    </li>
                                    <li><a class="{{ Request::is('student-dashboard') ? 'active' : '' }}"
                                            href="{{ url('student-dashboard') }}">Student Dashboard</a></li>
                                    <li><a class="{{ Request::is('student-profile') ? 'active' : '' }}"
                                            href="{{ url('student-profile') }}">My Profile</a></li>
                                    <li><a class="{{ Request::is('student-courses') ? 'active' : '' }}"
                                            href="{{ url('student-courses') }}">Enrolled Courses</a></li>
                                    <li><a class="{{ Request::is('student-wishlist') ? 'active' : '' }}"
                                            href="{{ url('student-wishlist') }}">Wishlist</a></li>
                                    <li><a class="{{ Request::is('student-reviews') ? 'active' : '' }}"
                                            href="{{ url('student-reviews') }}">Reviews</a></li>
                                    <li><a class="{{ Request::is('student-quiz') ? 'active' : '' }}"
                                            href="{{ url('student-quiz') }}">My Quiz Attempts</a></li>
                                    <li><a class="{{ Request::is('student-order-history') ? 'active' : '' }}"
                                            href="{{ url('student-order-history') }}">Orders</a></li>
                                    <li><a class="{{ Request::is('student-qa') ? 'active' : '' }}"
                                            href="{{ url('student-qa') }}">Question & Answer</a></li>
                                    <li><a class="{{ Request::is('student-referral') ? 'active' : '' }}"
                                            href="{{ url('student-referral') }}">Referrals</a></li>
                                    <li><a class="{{ Request::is('student-messages') ? 'active' : '' }}"
                                            href="{{ url('student-messages') }}">Messages</a></li>
                                    <li><a class="{{ Request::is('student-tickets') ? 'active' : '' }}"
                                            href="{{ url('student-tickets') }}">Support Ticket</a></li>
                                    <li><a class="{{ Request::is('student-settings') ? 'active' : '' }}"
                                            href="{{ url('student-settings') }}">Settings</a></li>
                                </ul>
                            </li>
                            <li
                                class="has-submenu {{ Request::is(
                                    'notifications',
                                    'privacy-policy',
                                    'pricing-plan',
                                    'wishlist',
                                    'coming-soon',
                                    'error-404',
                                    'error-500',
                                    'under-construction',
                                    'faq',
                                    'support',
                                    'job-category',
                                    'cart',
                                    'checkout',
                                    'login',
                                    'register',
                                    'forgot-password',
                                )
                                    ? 'active'
                                    : '' }}">
                                <a href="#">Pages <i class="fas fa-chevron-down"></i></a>
                                <ul class="submenu">
                                    <li><a class="{{ Request::is('notifications') ? 'active' : '' }}"
                                            href="{{ url('notifications') }}">Notification</a></li>
                                    <li><a class="{{ Request::is('pricing-plan') ? 'active' : '' }}"
                                            href="{{ url('pricing-plan') }}">Pricing Plan</a></li>
                                    <li><a class="{{ Request::is('wishlist') ? 'active' : '' }}"
                                            href="{{ url('wishlist') }}">Wishlist</a></li>
                                    <li
                                        class="has-submenu {{ Request::is('add-course', 'course-list', 'course-grid', 'course-details') ? 'active' : '' }}">
                                        <a href="{{ url('course-list') }}">Course</a>
                                        <ul class="submenu">
                                            <li><a class="{{ Request::is('add-course') ? 'active' : '' }}"
                                                    href="{{ url('add-course') }}">Add Course</a></li>
                                            <li><a class="{{ Request::is('course-list') ? 'active' : '' }}"
                                                    href="{{ url('course-list') }}">Course List</a></li>
                                            <li><a class="{{ Request::is('course-grid') ? 'active' : '' }}"
                                                    href="{{ url('course-grid') }}">Course Grid</a></li>
                                            <li><a class="{{ Request::is('course-details') ? 'active' : '' }}"
                                                    href="{{ url('course-details') }}">Course Details</a></li>
                                        </ul>
                                    </li>
                                    <li
                                        class="has-submenu {{ Request::is('coming-soon', 'error-404', 'error-500', 'under-construction') ? 'active' : '' }}">
                                        <a href="{{ url('coming-soon') }}">Error</a>
                                        <ul class="submenu">
                                            <li><a {{ Request::is('coming-soon') ? 'active' : '' }}
                                                    href="{{ url('coming-soon') }}">Coming Soon</a></li>
                                            <li><a {{ Request::is('error-404') ? 'active' : '' }}
                                                    href="{{ url('error-404') }}">404</a></li>
                                            <li><a {{ Request::is('error-500') ? 'active' : '' }}
                                                    href="{{ url('error-500') }}">500</a></li>
                                            <li><a {{ Request::is('under-construction') ? 'active' : '' }}
                                                    href="{{ url('under-construction') }}">Under Construction</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="{{ Request::is('faq') ? 'active' : '' }}"><a
                                            href="{{ url('faq') }}">FAQ</a>
                                    </li>
                                    <li class="{{ Request::is('support') ? 'active' : '' }}"><a
                                            href="{{ url('support') }}">Support</a></li>
                                    <li class="{{ Request::is('job-category') ? 'active' : '' }}"><a
                                            href="{{ url('job-category') }}">Category</a></li>
                                    <li class="{{ Request::is('cart') ? 'active' : '' }}"><a
                                            href="{{ url('cart') }}">Cart</a></li>
                                    <li class="{{ Request::is('checkout') ? 'active' : '' }}"><a
                                            href="{{ url('checkout') }}">Checkout</a></li>
                                    <li class="{{ Request::is('login') ? 'active' : '' }}"><a
                                            href="{{ route('student.login') }}">Login</a></li>
                                    <li class="{{ Request::is('forgot-password') ? 'active' : '' }}"><a
                                            href="{{ url('forgot-password') }}">Forgot Password</a></li>
                                </ul>
                            </li>
                            <li
                                class="has-submenu {{ Request::is('blog-list', 'blog-grid', 'blog-masonry', 'blog-modern', 'blog-details') ? 'active' : '' }}">
                                <a href="#">Blog <i class="fas fa-chevron-down"></i></a>
                                <ul class="submenu">
                                    <li class="{{ Request::is('blog-list') ? 'active' : '' }}"><a
                                            href="{{ url('blog-list') }}">Blog List</a></li>
                                    <li class="{{ Request::is('blog-grid') ? 'active' : '' }}"><a
                                            href="{{ url('blog-grid') }}">Blog Grid</a></li>
                                    <li class="{{ Request::is('blog-masonry') ? 'active' : '' }}"><a
                                            href="{{ url('blog-masonry') }}">Blog Masonry</a></li>
                                    <li class="{{ Request::is('blog-modern') ? 'active' : '' }}"><a
                                            href="{{ url('blog-modern') }}">Blog Modern</a></li>
                                    <li class="{{ Request::is('blog-details') ? 'active' : '' }}"><a
                                            href="{{ url('blog-details') }}">Blog Details</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <ul class="nav header-navbar-rht header-navbar-five">
                        <li class="nav-item">
                            <div>
                                <a href="#" id="dark-mode-toggle" class="dark-mode-toggle  ">
                                    <i class="fa-solid fa-moon"></i>
                                </a>
                                <a href="#" id="light-mode-toggle" class="dark-mode-toggle ">
                                    <i class="fa-solid fa-sun"></i>
                                </a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="login-five" href="{{ route('student.login') }}">Login</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>
    <!-- /Header -->
@endif
