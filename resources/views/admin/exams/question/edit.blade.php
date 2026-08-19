<?php $page = 'admin-exams-question-edit'; ?>
@extends('layout.admin')
@section('content')
    @component('components.admin-breadcrumb')
        @slot('title')
            تعديل سؤال
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
            تعديل سؤال
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
                            <div class="admin-card-header mb-4">
                                <h4 class="mb-1">تعديل السؤال</h4>
                                <p class="text-muted mb-0">{{ Str::limit($question->question, 80) }}</p>
                            </div>

                            <form method="POST" action="{{ route('admin.exams.question.update', $question->id) }}" enctype="multipart/form-data">
                                @csrf
                                @include('admin.exams.question._form', [
                                    'question' => $question,
                                    'classRooms' => $classRooms,
                                    'searchParams' => $searchParams,
                                ])

                                <div class="d-flex flex-wrap gap-2 mt-4">
                                    <button type="submit" class="btn btn-primary">حفظ التعديلات</button>
                                    <a href="{{ route('admin.exams.question.index', $searchParams) }}" class="btn btn-outline-secondary">إلغاء</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('admin.exams.question._dropzone-scripts', ['attachments' => $attachments ?? []])
@endsection
