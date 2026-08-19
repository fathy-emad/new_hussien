<?php $page = 'admin-exams-exam-edit'; ?>
@extends('layout.admin')
@section('content')
    @component('components.admin-breadcrumb')
        @slot('title')
            تعديل امتحان
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
            تعديل امتحان
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
                                <h4 class="mb-1">تعديل: {{ $exam->title }}</h4>
                                <p class="text-muted mb-0">عدّل بيانات الامتحان والأسئلة</p>
                            </div>

                            <form method="POST" action="{{ route('admin.exams.exam.update', $exam->id) }}">
                                @csrf
                                @include('admin.exams.exam._form', [
                                    'exam' => $exam,
                                    'classRooms' => $classRooms,
                                    'searchParams' => $searchParams,
                                    'bankQuestions' => $bankQuestions,
                                ])

                                <div class="d-flex flex-wrap gap-2 mt-4">
                                    <button type="submit" class="btn btn-primary">حفظ التعديلات</button>
                                    <a href="{{ route('admin.exams.exam.index', $searchParams) }}" class="btn btn-outline-secondary">إلغاء</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
