<?php $page = 'student-dashboard'; ?>
@extends('layout.student')
@section('content')
    <div class="page-content">
        <div class="container">
            <div class="row">
                @include('components.student-sidebar')

                <div class="col-xl-9 col-lg-9">
                    @include('components.admin-alerts')

                    <div class="admin-page-title mb-4">
                        <h4 class="mb-1">مرحباً {{ $student->name ?: $student->code }}</h4>
                        <p class="text-muted mb-0">
                            {{ $classRooms[(int) $student->classroom] ?? '' }}
                            @if ($student->academic_year)
                                — {{ $student->academic_year }}
                            @endif
                        </p>
                    </div>

                    @if ($barcode)
                        <div class="card admin-card mb-4 student-checkin-barcode-section">
                            <div class="card-body student-checkin-barcode-section-body">
                                <x-student-checkin-barcode :code="$student->code" :barcode="$barcode" />
                            </div>
                        </div>
                    @endif

                    <div class="row g-3">
                        <div class="col-md-6 col-lg-3 d-flex">
                            <a href="{{ route('student.material') }}" class="card dash-info flex-fill text-decoration-none admin-dash-stat-card">
                                <div class="card-body">
                                    <h5 class="text-dark">المواد الدراسية</h5>
                                    <p class="text-muted small mb-0">مشاهدة الدروس والفيديوهات</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-6 col-lg-3 d-flex">
                            <a href="{{ route('student.exams') }}" class="card dash-info flex-fill text-decoration-none admin-dash-stat-card">
                                <div class="card-body">
                                    <h5 class="text-dark">الامتحانات</h5>
                                    <p class="text-muted small mb-0">الامتحانات المتاحة والنتائج</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-6 col-lg-3 d-flex">
                            <a href="{{ route('student.attendance') }}" class="card dash-info flex-fill text-decoration-none admin-dash-stat-card">
                                <div class="card-body">
                                    <h5 class="text-dark">الحضور والغياب</h5>
                                    <p class="text-muted small mb-0">سجل حضورك في السنتر</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-6 col-lg-3 d-flex">
                            <a href="{{ route('student.myProfile') }}" class="card dash-info flex-fill text-decoration-none admin-dash-stat-card">
                                <div class="card-body">
                                    <h5 class="text-dark">الملف الشخصي</h5>
                                    <p class="text-muted small mb-0">بياناتك وكود الدخول</p>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="card admin-card mt-4">
                        <div class="card-body">
                            <h5 class="mb-3">بيانات سريعة</h5>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <p class="text-muted small mb-1">الكود</p>
                                    <p class="mb-0 fw-semibold">{{ $student->code }}</p>
                                </div>
                                <div class="col-md-4">
                                    <p class="text-muted small mb-1">رقم الموبايل</p>
                                    <p class="mb-0 fw-semibold">{{ $student->phone ?: '—' }}</p>
                                </div>
                                <div class="col-md-4">
                                    <p class="text-muted small mb-1">السنة الدراسية</p>
                                    <p class="mb-0 fw-semibold">{{ $student->academic_year ?: '—' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card admin-card mt-4">
                        <div class="card-body">
                            <h5 class="mb-3">إستلام المطبوعات</h5>
                            <div class="row g-3">
                                @foreach ([
                                    'material_one' => 'الأولى',
                                    'material_two' => 'الثانية',
                                    'material_three' => 'الثالثة',
                                    'material_four' => 'الرابعة',
                                ] as $field => $label)
                                    <div class="col-md-6 col-lg-3">
                                        <div class="admin-detail-box">
                                            <span class="admin-detail-label">{{ $label }}:</span>
                                            <span class="admin-detail-value">
                                                @if ($student->$field)
                                                    <span class="badge bg-success">نعم — تم الإستلام</span>
                                                @else
                                                    <span class="badge bg-secondary">لا — لم يُستلم</span>
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
