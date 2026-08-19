<?php $page = 'admin-exams-question-create'; ?>
@extends('layout.admin')
@section('content')
    @component('components.admin-breadcrumb')
        @slot('title')
            إضافة سؤال
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
            إضافة سؤال
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
                                <h4 class="mb-1">إضافة سؤال جديد</h4>
                                <p class="text-muted mb-0">أدخل السؤال والإجابات ثم حدد الإجابة الصحيحة</p>
                            </div>

                            <form method="POST" action="{{ route('admin.exams.question.create.submit') }}" enctype="multipart/form-data">
                                @csrf
                                @include('admin.exams.question._form', [
                                    'classRooms' => $classRooms,
                                    'searchParams' => $searchParams,
                                ])

                                <div class="d-flex flex-wrap gap-2 mt-4">
                                    <button type="submit" class="btn btn-primary">حفظ</button>
                                    <a href="{{ route('admin.exams.question.index', $searchParams) }}" class="btn btn-outline-secondary">إلغاء</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('admin.exams.question._dropzone-scripts')
@endsection
