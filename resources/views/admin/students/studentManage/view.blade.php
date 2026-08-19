<?php $page = 'admin-student-view'; ?>
@extends('layout.admin')
@section('content')
    @component('components.admin-breadcrumb')
        @slot('title')
            عرض الطالب
        @endslot
        @slot('item1')
            الرئيسية
        @endslot
        @slot('item2')
            الطلاب
        @endslot
        @slot('item2Url')
            {{ route('admin.students.studentManage.index', $searchParams) }}
        @endslot
        @slot('item3')
            {{ $student->name }}
        @endslot
    @endcomponent

    <div class="page-content">
        <div class="container">
            <div class="row">
                @include('components.admin-sidebar')

                <div class="col-xl-9 col-lg-9">
                    @include('components.admin-alerts')

                    <div class="card admin-card">
                        <div class="card-body">
                            <div class="admin-card-header mb-4 d-flex flex-wrap justify-content-between align-items-start gap-2">
                                <div class="d-flex align-items-center gap-3">
                                    @php
                                        $avatarFile = normalizeStoredFilename($student->avatar);
                                        $avatarUrl = $avatarFile && is_file(public_path('uploads/students/images/'.$avatarFile))
                                            ? asset('uploads/students/images/'.$avatarFile)
                                            : URL::asset('/build/img/user/user-17.jpg');
                                    @endphp
                                    <img src="{{ $avatarUrl }}" alt="{{ $student->name }}" class="rounded-circle admin-student-avatar">
                                    <div>
                                        <h4 class="mb-1">{{ $student->name }}</h4>
                                        <p class="text-muted mb-0">
                                            <code>{{ $student->code }}</code>
                                            — {{ $student->center?->title ?? 'بدون سنتر' }}
                                        </p>
                                    </div>
                                </div>
                                <div class="d-flex flex-wrap gap-2">
                                    <a href="{{ route('admin.students.studentManage.index', $searchParams) }}" class="btn btn-outline-secondary btn-sm">رجوع</a>
                                    <a href="{{ route('admin.students.studentManage.edit', $student->id) }}" class="btn btn-primary btn-sm">تعديل</a>
                                </div>
                            </div>

                            <div class="row g-3 admin-lesson-view-details mb-4">
                                <div class="col-md-4">
                                    <div class="admin-detail-box">
                                        <span class="admin-detail-label">السنة الدراسية</span>
                                        <span class="admin-detail-value">{{ $student->academic_year ?? '—' }}</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="admin-detail-box">
                                        <span class="admin-detail-label">الصف الدراسي</span>
                                        <span class="admin-detail-value">{{ $classRooms[(int) $student->classroom] ?? '—' }}</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="admin-detail-box">
                                        <span class="admin-detail-label">النوع</span>
                                        <span class="admin-detail-value">{{ $genders[(int) $student->gender] ?? '—' }}</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="admin-detail-box">
                                        <span class="admin-detail-label">رقم الموبايل</span>
                                        <span class="admin-detail-value">{{ $student->phone }}</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="admin-detail-box">
                                        <span class="admin-detail-label">رقم ولى الأمر</span>
                                        <span class="admin-detail-value">{{ $student->father_phone }}</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="admin-detail-box">
                                        <span class="admin-detail-label">واتساب</span>
                                        <span class="admin-detail-value">{{ $student->whatsApp ?? '—' }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="admin-detail-box">
                                        <span class="admin-detail-label">البريد الإلكتروني</span>
                                        <span class="admin-detail-value">{{ $student->email ?? '—' }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="admin-lesson-view-section mb-4">
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
                                                        <span class="badge bg-success">تم الإستلام</span>
                                                    @else
                                                        <span class="badge bg-secondary">لم يُستلم</span>
                                                    @endif
                                                </span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="admin-lesson-view-section mb-4">
                                <h5 class="mb-3">امتحانات الطالب ونتائجه</h5>
                                @if ($examRows->isEmpty())
                                    <div class="alert alert-warning mb-0">لا توجد امتحانات مسجلة لصف هذا الطالب.</div>
                                @else
                                    <div class="table-responsive">
                                        <table class="table table-sm table-bordered mb-0">
                                            <thead>
                                                <tr>
                                                    <th>الامتحان</th>
                                                    <th>التاريخ</th>
                                                    <th>المدة</th>
                                                    <th>الحالة</th>
                                                    <th>النتيجة</th>
                                                    <th>وقت الدخول</th>
                                                    <th>إدارة</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($examRows as $row)
                                                    <tr>
                                                        <td>{{ $row['title'] }}</td>
                                                        <td>{{ $row['day'] ?? '—' }}</td>
                                                        <td>{{ $row['time'] }} دقيقة</td>
                                                        <td>
                                                            <span class="badge {{ $row['status_badge'] }}">{{ $row['status_label'] }}</span>
                                                        </td>
                                                        <td>
                                                            {{ $row['degree_label'] }}
                                                            @if ($row['percentage'] !== null)
                                                                <span class="text-muted small">({{ $row['percentage'] }}%)</span>
                                                            @endif
                                                        </td>
                                                        <td>{{ $row['visited_at'] ?? '—' }}</td>
                                                        <td>
                                                            @if ($row['result_url'])
                                                                <a href="{{ $row['result_url'] }}" class="btn btn-sm btn-outline-primary">عرض التفاصيل</a>
                                                            @else
                                                                <span class="text-muted">—</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>

                            <div class="admin-lesson-view-section">
                                <h5 class="mb-3">سجل الحضور</h5>
                                @if ($monthBlocks->isEmpty())
                                    <div class="alert alert-warning mb-0">لا يوجد حضور مسجل لهذا الطالب.</div>
                                @else
                                    @foreach ($monthBlocks as $block)
                                        <div class="mb-4">
                                            <h6 class="text-muted mb-2">{{ $block['label'] }}</h6>
                                            <div class="table-responsive">
                                                <table class="table table-sm table-bordered mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th>التاريخ</th>
                                                            <th>السنتر</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($block['items'] as $attendance)
                                                            <tr>
                                                                <td>{{ $attendance->created_label }}</td>
                                                                <td>{{ $attendance->center?->title ?? '—' }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
