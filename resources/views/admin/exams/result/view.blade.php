<?php $page = 'admin-exams-result-view'; ?>
@extends('layout.admin')
@section('content')
    @component('components.admin-breadcrumb')
        @slot('title')
            تفاصيل نتيجة الطالب
        @endslot
        @slot('item1')
            الرئيسية
        @endslot
        @slot('item2')
            ادارة الامتحانات
        @endslot
        @slot('item2Url')
            {{ route('admin.exams.result.index', $searchParams) }}
        @endslot
        @slot('item3')
            تفاصيل النتيجة
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
                                <div>
                                    <h4 class="mb-1">{{ $student?->name ?: $student?->code ?: 'طالب' }}</h4>
                                    <p class="text-muted mb-0">
                                        {{ $exam?->title ?? '—' }}
                                        @if ($examStudent->visited)
                                            — دخول: {{ $examStudent->visited->format('d M Y - H:i:s') }}
                                        @endif
                                    </p>
                                </div>
                                <a href="{{ route('admin.exams.result.index', $searchParams) }}" class="btn btn-outline-secondary btn-sm">رجوع</a>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered mb-0">
                                    <thead>
                                        <tr>
                                            <th>السؤال</th>
                                            <th>إجابة الطالب</th>
                                            <th>الإجابة الصحيحة</th>
                                            <th>الحالة</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($details as $detail)
                                            <tr>
                                                <td>{{ $detail['question'] }}</td>
                                                <td>{{ $detail['student_answer'] }}</td>
                                                <td>{{ $detail['correct_answer'] }}</td>
                                                <td>
                                                    @if ($detail['is_correct'])
                                                        <span class="badge bg-success">صحيح</span>
                                                    @else
                                                        <span class="badge bg-danger">خطأ</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center text-muted py-4">لا توجد إجابات مسجلة.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
