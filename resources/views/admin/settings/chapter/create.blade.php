<?php $page = 'admin-chapter-create'; ?>
@extends('layout.admin')
@section('content')
    @component('components.admin-breadcrumb')
        @slot('title')
            إنشاء فصل جديد
        @endslot
        @slot('item1')
            الرئيسية
        @endslot
        @slot('item2')
            إدارة الفصول
        @endslot
        @slot('item2Url')
            {{ route('admin.settings.chapter.index', $searchParams) }}
        @endslot
        @slot('item3')
            إنشاء فصل جديد
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
                                <h4 class="mb-1">إنشاء فصل جديد</h4>
                                <p class="text-muted mb-0">أدخل بيانات الفصل ثم احفظ</p>
                            </div>

                            <form method="POST" action="{{ route('admin.settings.chapter.create.submit') }}">
                                @csrf
                                @include('admin.settings.chapter._form', [
                                    'classRooms' => $classRooms,
                                    'academicYears' => $academicYears,
                                    'searchParams' => $searchParams,
                                ])

                                <div class="d-flex flex-wrap gap-2 mt-4">
                                    <button type="submit" class="btn btn-primary">حفظ</button>
                                    <a href="{{ route('admin.settings.chapter.index', $searchParams) }}" class="btn btn-outline-secondary">إلغاء</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
