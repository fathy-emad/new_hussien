@php
    $admin = auth('admin')->user();
    $adminAvatar = ! empty($admin?->avatar)
        ? asset('uploads/admins/images/' . $admin->avatar)
        : URL::asset('/build/img/user/user-17.jpg');

    $sidebarSections = [
        [
            'id' => 'main',
            'title' => 'القائمة الرئيسية',
            'items' => [
                [
                    'route' => 'admin.dashboard',
                    'active' => request()->routeIs('admin.dashboard'),
                    'icon' => 'bxs-dashboard',
                    'label' => 'لوحة التحكم',
                ],
            ],
        ],
        [
            'id' => 'students',
            'title' => 'ادارة الطلاب',
            'items' => [
                [
                    'route' => 'admin.students.studentManage.index',
                    'active' => request()->routeIs('admin.students.studentManage.*'),
                    'icon' => 'bxs-user',
                    'label' => 'الطلاب',
                ],
                [
                    'route' => 'admin.students.studentCards.index',
                    'active' => request()->routeIs('admin.students.studentCards.*'),
                    'icon' => 'bxs-id-card',
                    'label' => 'الكروت',
                ],
                [
                    'route' => 'admin.students.studentAttendance.index',
                    'active' => request()->routeIs('admin.students.studentAttendance.*'),
                    'icon' => 'bxs-calendar-check',
                    'label' => 'الغياب و الحضور',
                ],
            ],
        ],
        [
            'id' => 'master-settings',
            'title' => 'إعدادات المستر',
            'items' => [
                [
                    'route' => 'admin.settings.center.index',
                    'active' => request()->routeIs('admin.settings.center.*'),
                    'icon' => 'bxs-buildings',
                    'label' => 'السناتر',
                ],
                [
                    'route' => 'admin.settings.chapter.index',
                    'active' => request()->routeIs('admin.settings.chapter.*'),
                    'icon' => 'bxs-book-bookmark',
                    'label' => 'الفصول',
                ],
                [
                    'route' => 'admin.settings.lesson.index',
                    'active' => request()->routeIs('admin.settings.lesson.*'),
                    'icon' => 'bxs-book-open',
                    'label' => 'الدروس',
                ],
            ],
        ],
        [
            'id' => 'content',
            'title' => 'المحتوى التعليمي',
            'items' => [
                [
                    'route' => 'admin.settings.schedule.index',
                    'active' => request()->routeIs('admin.settings.schedule.*'),
                    'icon' => 'bxs-calendar',
                    'label' => 'الجدول',
                ],
            ],
        ],
        [
            'id' => 'exams',
            'title' => 'ادارة الامتحانات',
            'items' => [
                [
                    'route' => 'admin.exams.question.index',
                    'active' => request()->routeIs('admin.exams.question.*'),
                    'icon' => 'bxs-help-circle',
                    'label' => 'الأسئلة والإجابات',
                ],
                [
                    'route' => 'admin.exams.exam.index',
                    'active' => request()->routeIs('admin.exams.exam.*'),
                    'icon' => 'bxs-edit',
                    'label' => 'الامتحانات',
                ],
                [
                    'route' => 'admin.exams.result.index',
                    'active' => request()->routeIs('admin.exams.result.*'),
                    'icon' => 'bxs-bar-chart-alt-2',
                    'label' => 'النتائج',
                ],
            ],
        ],
        [
            'id' => 'offline',
            'title' => 'Offline',
            'items' => [
                [
                    'route' => 'admin.capacitors.capacitor.index',
                    'active' => request()->routeIs('admin.capacitors.capacitor.*'),
                    'icon' => 'bxs-book-content',
                    'label' => 'دروس Offline',
                ],
                [
                    'route' => 'admin.capacitors.card.index',
                    'active' => request()->routeIs('admin.capacitors.card.*'),
                    'icon' => 'bxs-id-card',
                    'label' => 'الكروت',
                ],
            ],
        ],
        [
            'id' => 'other',
            'title' => 'أخرى',
            'items' => [
                [
                    'route' => 'admin.permissionsAndEmployees.permission.index',
                    'active' => request()->routeIs('admin.permissionsAndEmployees.*'),
                    'icon' => 'bxs-lock-alt',
                    'label' => 'الصلاحيات',
                ],
                [
                    'route' => 'admin.website.page.edit',
                    'active' => request()->routeIs('admin.website.page.*'),
                    'icon' => 'bxs-globe',
                    'label' => 'إدارة الموقع',
                ],
                [
                    'route' => 'admin.website.reviews.index',
                    'active' => request()->routeIs('admin.website.reviews.*'),
                    'icon' => 'bxs-star',
                    'label' => 'آراء الطلاب',
                ],
                [
                    'route' => 'admin.website.requests.index',
                    'active' => request()->routeIs('admin.website.requests.*'),
                    'icon' => 'bxs-message-dots',
                    'label' => 'طلبات الموقع',
                ],
            ],
        ],
    ];

    foreach ($sidebarSections as &$section) {
        $section['has_active'] = collect($section['items'])->contains(fn ($item) => $item['active']);
    }
    unset($section);
@endphp

<div class="col-xl-3 col-lg-3 theiaStickySidebar">
    <div class="settings-widget dash-profile">
        <div class="settings-menu">
            <div class="profile-bg">
                <div class="profile-img">
                    <img src="{{ $adminAvatar }}" alt="{{ $admin?->name }}">
                </div>
            </div>
            <div class="profile-group">
                <div class="profile-name text-center">
                    <h4>{{ $admin?->name }}</h4>
                    <p>مدير النظام</p>
                </div>
            </div>
        </div>
    </div>

    <div class="settings-widget account-settings admin-sidebar-widget">
        <div class="settings-menu admin-sidebar-menu">
            <div class="accordion admin-sidebar-accordion" id="adminSidebarAccordion">
                @foreach ($sidebarSections as $section)
                    @php
                        $panelId = 'adminSidebar-' . $section['id'];
                        $headingId = 'adminSidebarHeading-' . $section['id'];
                    @endphp
                    <div class="accordion-item admin-sidebar-accordion-item {{ $section['has_active'] ? 'has-active' : '' }}">
                        <h3 class="accordion-header" id="{{ $headingId }}">
                            <button
                                class="accordion-button admin-sidebar-heading {{ $section['has_active'] ? '' : 'collapsed' }}"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#{{ $panelId }}"
                                aria-expanded="{{ $section['has_active'] ? 'true' : 'false' }}"
                                aria-controls="{{ $panelId }}"
                            >
                                {{ $section['title'] }}
                            </button>
                        </h3>
                        <div
                            id="{{ $panelId }}"
                            class="accordion-collapse collapse {{ $section['has_active'] ? 'show' : '' }}"
                            aria-labelledby="{{ $headingId }}"
                        >
                            <div class="accordion-body admin-sidebar-body">
                                <ul class="admin-sidebar-links">
                                    @foreach ($section['items'] as $item)
                                        <li class="nav-item {{ $item['active'] ? 'active' : '' }}">
                                            <a href="{{ route($item['route']) }}" class="nav-link">
                                                <i class="bx {{ $item['icon'] }}"></i>{{ $item['label'] }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
