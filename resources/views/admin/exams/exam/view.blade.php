<?php $page = 'admin-exams-exam-view'; ?>
@extends('layout.admin')
@section('content')
    @component('components.admin-breadcrumb')
        @slot('title')
            عرض امتحان
        @endslot
        @slot('item1')
            الرئيسية
        @endslot
        @slot('item2')
            ادارة الامتحانات
        @endslot
        @slot('item2Url')
            {{ route('admin.exams.exam.index', $searchParams) }}
        @endslot
        @slot('item3')
            {{ $exam->title }}
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
                                    <h4 class="mb-1">{{ $exam->title }}</h4>
                                    <p class="text-muted mb-0">
                                        {{ $classRooms[(int) $exam->classroom] ?? '' }}
                                        — {{ $exam->day ? $exam->day->format('d M Y') : '—' }}
                                        — {{ $exam->time }} دقيقة
                                    </p>
                                </div>
                                <div class="d-flex flex-wrap gap-2">
                                    <a href="{{ route('admin.exams.exam.index', $searchParams) }}" class="btn btn-outline-secondary btn-sm">رجوع</a>
                                    <a href="{{ route('admin.exams.exam.edit', $exam->id) }}" class="btn btn-primary btn-sm">تعديل</a>
                                </div>
                            </div>

                            @php
                                $questionIds = is_array($exam->questions) ? $exam->questions : [];
                            @endphp

                            <div class="admin-lesson-view-section">
                                <h5 class="mb-3">أسئلة الامتحان ({{ count($questionIds) }})</h5>
                                @if (count($questionIds))
                                    <ol class="mb-0">
                                        @foreach ($questionIds as $questionId)
                                            @php $bankQuestion = $bankQuestions->get($questionId); @endphp
                                            <li class="mb-2">
                                                {{ $bankQuestion?->question ?? 'سؤال محذوف #' . $questionId }}
                                            </li>
                                        @endforeach
                                    </ol>
                                @else
                                    <p class="text-muted mb-0">لا توجد أسئلة مرتبطة بهذا الامتحان.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
