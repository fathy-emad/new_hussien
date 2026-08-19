<?php $page = 'admin-exams-question-view'; ?>
@extends('layout.admin')
@section('content')
    @component('components.admin-breadcrumb')
        @slot('title')
            عرض سؤال
        @endslot
        @slot('item1')
            الرئيسية
        @endslot
        @slot('item2')
            ادارة الامتحانات
        @endslot
        @slot('item2Url')
            {{ route('admin.exams.question.index', $searchParams) }}
        @endslot
        @slot('item3')
            عرض سؤال
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
                                    <h4 class="mb-1">تفاصيل السؤال</h4>
                                    <p class="text-muted mb-0">
                                        {{ $classRooms[(int) $question->classroom] ?? '' }}
                                    </p>
                                </div>
                                <div class="d-flex flex-wrap gap-2">
                                    <a href="{{ route('admin.exams.question.index', $searchParams) }}" class="btn btn-outline-secondary btn-sm">رجوع</a>
                                    <a href="{{ route('admin.exams.question.edit', $question->id) }}" class="btn btn-primary btn-sm">تعديل</a>
                                </div>
                            </div>

                            <div class="admin-lesson-view-section mb-4">
                                <h5 class="mb-2">السؤال</h5>
                                <p class="mb-0">{{ $question->question }}</p>
                            </div>

                            @php
                                $answers = is_array($question->answers) ? $question->answers : [];
                            @endphp

                            <div class="admin-lesson-view-section mb-4">
                                <h5 class="mb-3">الإجابات</h5>
                                <ul class="list-group">
                                    @foreach ($answers as $index => $answer)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>{{ $answer }}</span>
                                            @if ((string) $question->correct_answer === (string) $index)
                                                <span class="badge bg-success">الإجابة الصحيحة</span>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            @if (count($images))
                                <div class="admin-lesson-view-section">
                                    <h5 class="mb-3">صور السؤال</h5>
                                    <div class="admin-lesson-images-grid">
                                        @foreach ($images as $image)
                                            <div class="admin-lesson-image-card">
                                                <a href="{{ $image['url'] }}" target="_blank" class="admin-lesson-image-link">
                                                    <img src="{{ $image['url'] }}" alt="{{ $image['name'] }}" class="admin-lesson-image-thumb">
                                                </a>
                                                <div class="admin-lesson-image-meta">
                                                    <span class="admin-lesson-file-name">{{ $image['name'] }}</span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
