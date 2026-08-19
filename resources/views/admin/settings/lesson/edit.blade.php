<?php $page = 'admin-lesson-edit'; ?>
@extends('layout.admin')
@section('content')
    @component('components.admin-breadcrumb')
        @slot('title')
            تعديل درس
        @endslot
        @slot('item1')
            الرئيسية
        @endslot
        @slot('item2')
            إدارة الدروس
        @endslot
        @slot('item2Url')
            {{ route('admin.settings.lesson.index', $searchParams) }}
        @endslot
        @slot('item3')
            تعديل درس
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
                                <h4 class="mb-1">تعديل الدرس</h4>
                                <p class="text-muted mb-0">{{ $lesson->title }}</p>
                            </div>

                            <form method="POST" action="{{ route('admin.settings.lesson.update', $lesson->id) }}" enctype="multipart/form-data">
                                @csrf
                                @include('admin.settings.lesson._form', [
                                    'lesson' => $lesson,
                                    'chapter' => $chapter,
                                    'classRooms' => $classRooms,
                                    'searchParams' => $searchParams,
                                ])

                                <div class="d-flex flex-wrap gap-2 mt-4">
                                    <button type="submit" class="btn btn-primary">تحديث</button>
                                    <a href="{{ route('admin.settings.lesson.index', $searchParams) }}" class="btn btn-outline-secondary">إلغاء</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('admin.settings.lesson._dropzone-scripts', ['attachments' => $attachments])
@endsection
