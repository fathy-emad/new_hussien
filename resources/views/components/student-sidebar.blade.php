@php
    $student = auth('student')->user();
    $avatarFile = normalizeStoredFilename($student?->avatar);
    $studentAvatar = $avatarFile && is_file(public_path('uploads/students/images/' . $avatarFile))
        ? asset('uploads/students/images/' . $avatarFile)
        : URL::asset('/build/img/user/user-17.jpg');

    $items = [
        [
            'route' => 'student.dashboard',
            'active' => request()->routeIs('student.dashboard'),
            'icon' => 'bxs-dashboard',
            'label' => 'لوحة التحكم',
        ],
        [
            'route' => 'student.material',
            'active' => request()->routeIs('student.material', 'student.lesson', 'student.video.lesson'),
            'icon' => 'bxs-book-open',
            'label' => 'المواد الدراسية',
        ],
        [
            'route' => 'student.exams',
            'active' => request()->routeIs('student.exams', 'student.exam.*'),
            'icon' => 'bxs-edit',
            'label' => 'الامتحانات',
        ],
        [
            'route' => 'student.attendance',
            'active' => request()->routeIs('student.attendance'),
            'icon' => 'bxs-calendar-check',
            'label' => 'الحضور والغياب',
        ],
        [
            'route' => 'student.review',
            'active' => request()->routeIs('student.review', 'student.review.submit'),
            'icon' => 'bxs-star',
            'label' => 'رأيك فى مستر حسين',
        ],
        [
            'route' => 'student.myProfile',
            'active' => request()->routeIs('student.myProfile'),
            'icon' => 'bxs-user',
            'label' => 'الملف الشخصي',
        ],
    ];
@endphp

<div class="col-xl-3 col-lg-3 theiaStickySidebar">
    <div class="settings-widget dash-profile admin-sidebar-card">
        <div class="settings-menu">
            <div class="profile-bg">
                <div class="profile-img">
                    <img src="{{ $studentAvatar }}" alt="Student">
                </div>
            </div>
            <div class="profile-group">
                <div class="profile-name text-center px-3 pb-3">
                    <h4 class="mb-1">{{ auth('student')->user()->name ?: auth('student')->user()->code }}</h4>
                    <p class="text-muted mb-0">{{ auth('student')->user()->code }}</p>
                </div>
            </div>
            <ul class="nav flex-column admin-sidebar-nav">
                @foreach ($items as $item)
                    <li class="nav-item">
                        <a href="{{ route($item['route']) }}" class="nav-link {{ $item['active'] ? 'active' : '' }}">
                            <i class="bx {{ $item['icon'] }}"></i> {{ $item['label'] }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
