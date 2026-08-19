<?php $page = 'admin-exams-result-index'; ?>
@extends('layout.admin')
@section('content')
    @component('components.admin-breadcrumb')
        @slot('title')
            نتائج الامتحانات
        @endslot
        @slot('item1')
            الرئيسية
        @endslot
        @slot('item2')
            ادارة الامتحانات
        @endslot
        @slot('item3')
            النتائج
        @endslot
    @endcomponent

    <div class="page-content">
        <div class="container">
            <div class="row">
                @include('components.admin-sidebar')

                <div class="col-xl-9 col-lg-9">
                    @include('components.admin-alerts')

                    <x-admin-exam-result-filter
                        :action="route('admin.exams.result.index')"
                        :class-rooms="$classRooms"
                        :exams-for-classroom="$examsForClassroom"
                        :search-params="$searchParams"
                    />

                    @if ($hasSearch ?? false)
                        <div class="card admin-card">
                            <div class="card-body">
                                <div class="admin-card-header mb-4">
                                    <h4 class="mb-1">نتائج: {{ $exam->title ?? '' }}</h4>
                                    <p class="text-muted mb-0">
                                        {{ $classRooms[(int) ($searchParams['classroom'] ?? 0)] ?? '' }}
                                        @if ($exam->day)
                                            — {{ $exam->day->format('d M Y') }}
                                        @endif
                                    </p>
                                </div>

                                @if (! empty($examStats))
                                    <div class="row g-3 mb-4">
                                        <div class="col-md-6 col-lg-3 d-flex">
                                            <div class="card dash-info flex-fill admin-dash-stat-card w-100">
                                                <div class="card-body">
                                                    <p class="text-muted small mb-1">الحضور</p>
                                                    <h3 class="mb-0">{{ $examStats['attended_label'] }}</h3>
                                                    <p class="text-muted small mb-0 mt-1">طالب حضر من الإجمالي</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-3 d-flex">
                                            <div class="card dash-info flex-fill admin-dash-stat-card w-100">
                                                <div class="card-body">
                                                    <p class="text-muted small mb-1">الغياب</p>
                                                    <h3 class="mb-0">{{ $examStats['absent_percent'] }}%</h3>
                                                    <p class="text-muted small mb-0 mt-1">{{ $examStats['absent'] }} طالب لم يحضر</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-3 d-flex">
                                            <div class="card dash-info flex-fill admin-dash-stat-card w-100">
                                                <div class="card-body">
                                                    <p class="text-muted small mb-1">النجاح</p>
                                                    <h3 class="mb-0 text-success">{{ $examStats['success_percent'] }}%</h3>
                                                    <p class="text-muted small mb-0 mt-1">{{ $examStats['passed'] }} طالب (≥ {{ $examStats['pass_threshold'] }}%)</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-3 d-flex">
                                            <div class="card dash-info flex-fill admin-dash-stat-card w-100">
                                                <div class="card-body">
                                                    <p class="text-muted small mb-1">الرسوب</p>
                                                    <h3 class="mb-0 text-danger">{{ $examStats['fail_percent'] }}%</h3>
                                                    <p class="text-muted small mb-0 mt-1">{{ $examStats['failed'] }} طالب (&lt; {{ $examStats['pass_threshold'] }}%)</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <form method="GET" action="{{ route('admin.exams.result.index') }}" class="admin-table-keyword-search mb-4">
                                    <input type="hidden" name="classroom" value="{{ $searchParams['classroom'] }}">
                                    <input type="hidden" name="exam_id" value="{{ $searchParams['exam_id'] }}">
                                    <div class="row g-2 align-items-end">
                                        <div class="col-md-8">
                                            <label class="form-label mb-1" for="result_student_code">بحث بالكود</label>
                                            <input
                                                type="text"
                                                name="code"
                                                id="result_student_code"
                                                class="form-control"
                                                value="{{ $searchParams['code'] ?? '' }}"
                                                placeholder="كود الطالب..."
                                            >
                                        </div>
                                        <div class="col-md-4 d-flex gap-2">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="bx bx-search"></i> بحث
                                            </button>
                                            @if (! empty($searchParams['code']))
                                                <a
                                                    href="{{ route('admin.exams.result.index', [
                                                        'classroom' => $searchParams['classroom'],
                                                        'exam_id' => $searchParams['exam_id'],
                                                    ]) }}"
                                                    class="btn btn-outline-secondary"
                                                >
                                                    مسح
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                    @if (! empty($searchParams['code']))
                                        <p class="text-muted small mb-0 mt-2">
                                            عرض نتائج الطلاب الذين كودهم يحتوي على: <strong>{{ $searchParams['code'] }}</strong>
                                        </p>
                                    @endif
                                </form>

                                <x-admin-data-table
                                    :data-lables="$dataLables"
                                    :data-rows="$dataRows"
                                    :paginator="$students"
                                    view-route="admin.exams.result.view"
                                    :view-confirm="null"
                                    empty-message="{{ ! empty($searchParams['code']) ? 'لا يوجد طالب بهذا الكود في هذا الصف.' : 'لا يوجد طلاب في هذا الصف.' }}"
                                />
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
