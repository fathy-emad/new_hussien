<?php $page = 'admin-dashboard'; ?>
@extends('layout.admin')
@section('content')
    @component('components.admin-breadcrumb')
        @slot('title')
            لوحة التحكم
        @endslot
        @slot('item1')
            الرئيسية
        @endslot
        @slot('item2')
            لوحة التحكم
        @endslot
    @endcomponent

    <div class="page-content">
        <div class="container">
            <div class="row">
                @include('components.admin-sidebar')

                <div class="col-xl-9 col-lg-9">
                    <div class="admin-page-title mb-4">
                        <p class="mb-0">مرحباً {{ auth('admin')->user()->name }}، هذه نظرة عامة على النظام.</p>
                    </div>

                    <div class="row g-3">
                        <div class="col-lg-4 col-md-6 d-flex">
                            <div class="card dash-info flex-fill admin-dash-stat-card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
                                        <h5 class="mb-0">كروت Offline</h5>
                                        <i class="bx bx-chip fs-4 text-primary"></i>
                                    </div>
                                    <h2 class="mb-1">
                                        {{ number_format($capacitorCardsUsed) }}
                                        <span class="text-muted fs-5 fw-normal">/ {{ number_format($capacitorCardsTotal) }}</span>
                                    </h2>
                                    <p class="text-muted small mb-2">مستخدم / الإجمالي</p>
                                    <p class="small mb-2">
                                        غير مستخدم: <strong>{{ number_format($capacitorCardsUnused) }}</strong>
                                    </p>
                                    <a href="{{ route('admin.capacitors.card.index') }}" class="small">عرض كروت Offline</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 d-flex">
                            <div class="card dash-info flex-fill admin-dash-stat-card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
                                        <h5 class="mb-0">امتحانات مفتوحة اليوم</h5>
                                        <i class="bx bx-edit fs-4 text-danger"></i>
                                    </div>
                                    <h2 class="mb-2">{{ number_format($openExamsCount) }}</h2>
                                    <a href="{{ route('admin.exams.exam.index') }}" class="small">عرض الامتحانات</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 d-flex">
                            <div class="card dash-info flex-fill admin-dash-stat-card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
                                        <h5 class="mb-0">طلبات موقع غير مقروءة</h5>
                                        <i class="bx bx-message-dots fs-4 text-warning"></i>
                                    </div>
                                    <h2 class="mb-2">{{ number_format($unreadWebsiteRequests) }}</h2>
                                    <a href="{{ route('admin.website.requests.index') }}" class="small">عرض الطلبات</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="card dash-info admin-dash-stat-card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start gap-2 mb-3">
                                        <h5 class="mb-0">كروت طلاب (حسب الصف)</h5>
                                        <i class="bx bx-id-card fs-4 text-success"></i>
                                    </div>
                                    <div class="row g-3">
                                        @foreach ($classRooms as $classId => $classLabel)
                                            @php
                                                $cardStats = $studentCardsByClass[$classId] ?? ['used' => 0, 'total' => 0, 'unused' => 0];
                                            @endphp
                                            <div class="col-md-4">
                                                <div class="border rounded p-3 h-100 bg-light">
                                                    <p class="text-muted small mb-1">{{ $classLabel }}</p>
                                                    <h3 class="mb-1">
                                                        {{ number_format($cardStats['used']) }}
                                                        <span class="text-muted fs-6 fw-normal">/ {{ number_format($cardStats['total']) }}</span>
                                                    </h3>
                                                    <p class="text-muted small mb-0">مستخدم / الإجمالي</p>
                                                    <p class="small mb-0 mt-1">
                                                        غير مستخدم: <strong>{{ number_format($cardStats['unused']) }}</strong>
                                                    </p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <a href="{{ route('admin.students.studentCards.index') }}" class="small d-inline-block mt-3">عرض كروت الطلاب</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row g-3 mt-1">
                        <div class="col-12">
                            <div class="card dash-info admin-dash-stat-card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start gap-2 mb-3">
                                        <div>
                                            <h5 class="mb-1">الطلاب</h5>
                                            <h2 class="mb-0">{{ number_format($studentsCount) }}</h2>
                                            <p class="text-muted small mb-0">إجمالي الطلاب في النظام</p>
                                        </div>
                                        <i class="bx bx-user fs-4 text-primary"></i>
                                    </div>
                                    <div class="row g-3">
                                        @foreach ($classRooms as $classId => $classLabel)
                                            <div class="col-md-4">
                                                <div class="border rounded p-3 h-100 bg-light">
                                                    <p class="text-muted small mb-1">{{ $classLabel }}</p>
                                                    <h3 class="mb-0">{{ number_format($studentsByClass[$classId] ?? 0) }}</h3>
                                                    <p class="text-muted small mb-0">طالب مسجل</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <a href="{{ route('admin.students.studentManage.index') }}" class="small d-inline-block mt-3">عرض الطلاب</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 d-flex">
                            <div class="card dash-info flex-fill">
                                <div class="card-body">
                                    <h5>المراكز</h5>
                                    <h2>{{ number_format($centersCount) }}</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 d-flex">
                            <div class="card dash-info flex-fill">
                                <div class="card-body">
                                    <h5>الدروس</h5>
                                    <h2>{{ number_format($lessonsCount) }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-4">
                        <div class="card-body">
                            <h5 class="mb-3">اختصارات سريعة</h5>
                            <div class="d-flex flex-wrap gap-2">
                                <a href="{{ route('admin.students.studentManage.index') }}" class="btn btn-outline-primary btn-sm">الطلاب</a>
                                <a href="{{ route('admin.settings.lesson.index') }}" class="btn btn-outline-primary btn-sm">الدروس</a>
                                <a href="{{ route('admin.exams.exam.index') }}" class="btn btn-outline-primary btn-sm">الامتحانات</a>
                                <a href="{{ route('admin.website.requests.index') }}" class="btn btn-outline-primary btn-sm">طلبات الموقع</a>
                                <a href="{{ route('admin.capacitors.card.index') }}" class="btn btn-outline-primary btn-sm">كروت Offline</a>
                                <a href="{{ route('admin.students.studentCards.index') }}" class="btn btn-outline-primary btn-sm">كروت الطلاب</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
