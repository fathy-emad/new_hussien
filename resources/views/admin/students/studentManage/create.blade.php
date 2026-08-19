<?php $page = 'admin-student-create'; ?>
@extends('layout.admin')
@section('content')
    @component('components.admin-breadcrumb')
        @slot('title')
            إضافة طالب
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
            إضافة طالب
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
                                <h4 class="mb-1">إضافة طالب جديد</h4>
                                <p class="text-muted mb-0">أدخل بيانات الطالب ثم احفظ</p>
                            </div>

                            <form method="POST" action="{{ route('admin.students.studentManage.create.submit') }}" enctype="multipart/form-data">
                                @csrf
                                @include('admin.students.studentManage._form', [
                                    'centers' => $centers,
                                    'classRooms' => $classRooms,
                                    'academicYears' => $academicYears,
                                    'genders' => $genders,
                                    'searchParams' => $searchParams,
                                ])

                                <div class="d-flex flex-wrap gap-2 mt-4">
                                    <button type="submit" class="btn btn-primary">حفظ</button>
                                    <a href="{{ route('admin.students.studentManage.index', $searchParams) }}" class="btn btn-outline-secondary">إلغاء</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('admin.students.studentManage._dropzone-scripts')
@endsection
