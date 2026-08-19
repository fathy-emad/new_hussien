<?php $page = 'admin-chapter-edit'; ?>
@extends('layout.admin')
@section('content')
    @component('components.admin-breadcrumb')
        @slot('title')
            تعديل فصل
        @endslot
        @slot('item1')
            الرئيسية
        @endslot
        @slot('item2')
            إدارة الفصول
        @endslot
        @slot('item2Url')
            {{ route('admin.settings.chapter.index', [
                'academic_year' => $chapter->academic_year,
                'classroom' => $chapter->classroom,
            ]) }}
        @endslot
        @slot('item3')
            تعديل فصل
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
                                <h4 class="mb-1">تعديل الفصل</h4>
                                <p class="text-muted mb-0">{{ $chapter->title }}</p>
                            </div>

                            <form method="POST" action="{{ route('admin.settings.chapter.update', $chapter->id) }}">
                                @csrf
                                <input type="hidden" name="chapter_id" value="{{ $chapter->id }}">
                                @include('admin.settings.chapter._form', [
                                    'chapter' => $chapter,
                                    'classRooms' => $classRooms,
                                    'academicYears' => $academicYears,
                                    'searchParams' => [
                                        'classroom' => $chapter->classroom,
                                        'academic_year' => $chapter->academic_year,
                                    ],
                                ])

                                <div class="d-flex flex-wrap gap-2 mt-4">
                                    <button type="submit" class="btn btn-primary">تحديث</button>
                                    <a href="{{ route('admin.settings.chapter.index', [
                                        'academic_year' => $chapter->academic_year,
                                        'classroom' => $chapter->classroom,
                                    ]) }}" class="btn btn-outline-secondary">إلغاء</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
