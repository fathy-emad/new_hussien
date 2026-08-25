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
                            <img src="{{ \App\Support\WebsiteHomepage::siteLogo() }}" class="img-fluid" alt="حسين فايز">
                        </a>
                    </div>

                    <ul class="nav header-navbar-rht">
                        @if ($admin)
                            <li class="nav-item dropdown admin-noti-nav" id="adminNotifications">
                                <a href="#" class="dropdown-toggle admin-noti-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bx bx-bell"></i>
                                    <span class="admin-noti-badge d-none" data-unread-badge>0</span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end admin-noti-menu">
                                    <div class="admin-noti-header">
                                        <strong>الإشعارات</strong>
                                        <button type="button" class="btn btn-sm btn-link p-0" data-mark-all-read>تعليم الكل كمقروء</button>
                                    </div>
                                    <div class="admin-noti-list" data-notifications-list>
                                        <div class="admin-noti-empty text-muted">لا توجد إشعارات</div>
                                    </div>
                                </div>
                            </li>
                        @endif
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
    @if ($admin)
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const root = document.getElementById('adminNotifications');
                if (!root) return;

                const listEl = root.querySelector('[data-notifications-list]');
                const badgeEl = root.querySelector('[data-unread-badge]');
                const markAllBtn = root.querySelector('[data-mark-all-read]');
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
                const indexUrl = @json(route('admin.notifications.index'));
                const readAllUrl = @json(route('admin.notifications.read-all'));
                const readUrlTemplate = @json(route('admin.notifications.read', ['id' => '__ID__']));

                function escapeHtml(value) {
                    const div = document.createElement('div');
                    div.textContent = value || '';
                    return div.innerHTML;
                }

                function render(payload) {
                    const unread = payload.unread || 0;
                    badgeEl.textContent = unread > 99 ? '99+' : String(unread);
                    badgeEl.classList.toggle('d-none', unread < 1);

                    const items = payload.notifications || [];
                    if (!items.length) {
                        listEl.innerHTML = '<div class="admin-noti-empty text-muted">لا توجد إشعارات</div>';
                        return;
                    }

                    listEl.innerHTML = items.map(function (item) {
                        const unreadClass = item.read_at ? '' : ' is-unread';
                        return (
                            '<a class="admin-noti-item' + unreadClass + '" href="' + escapeHtml(item.url) + '" data-id="' + escapeHtml(item.id) + '">' +
                                '<strong>' + escapeHtml(item.title) + '</strong>' +
                                '<span>' + escapeHtml(item.message) + '</span>' +
                                '<small>' + escapeHtml(item.created_at || '') + '</small>' +
                            '</a>'
                        );
                    }).join('');
                }

                async function loadNotifications() {
                    try {
                        const response = await fetch(indexUrl, {
                            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                            credentials: 'same-origin'
                        });
                        if (!response.ok) return;
                        render(await response.json());
                    } catch (e) {}
                }

                async function markRead(id) {
                    try {
                        await fetch(readUrlTemplate.replace('__ID__', encodeURIComponent(id)), {
                            method: 'POST',
                            headers: {
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            credentials: 'same-origin'
                        });
                    } catch (e) {}
                }

                listEl.addEventListener('click', function (event) {
                    const item = event.target.closest('.admin-noti-item');
                    if (!item) return;
                    markRead(item.getAttribute('data-id'));
                });

                markAllBtn?.addEventListener('click', async function (event) {
                    event.preventDefault();
                    event.stopPropagation();
                    try {
                        await fetch(readAllUrl, {
                            method: 'POST',
                            headers: {
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            credentials: 'same-origin'
                        });
                        loadNotifications();
                    } catch (e) {}
                });

                loadNotifications();
                setInterval(loadNotifications, 15000);
            });
        </script>
    @endif
    @stack('scripts')
</body>

</html>
