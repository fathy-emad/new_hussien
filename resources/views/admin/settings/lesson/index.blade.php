<?php $page = 'admin-lesson-index'; ?>
@extends('layout.admin')
@section('content')
    @component('components.admin-breadcrumb')
        @slot('title')
            جميع الدروس
        @endslot
        @slot('item1')
            الرئيسية
        @endslot
        @slot('item2')
            إدارة الدروس
        @endslot
        @slot('item2Url')
            {{ route('admin.settings.lesson.index') }}
        @endslot
        @slot('item3')
            جميع الدروس
        @endslot
    @endcomponent

    <div class="page-content">
        <div class="container">
            <div class="row">
                @include('components.admin-sidebar')

                <div class="col-xl-9 col-lg-9">
                    @include('components.admin-alerts')

                    <x-admin-lesson-search-filters
                        :action="route('admin.settings.lesson.index')"
                        :class-rooms="$classRooms"
                        :chapters-by-classroom="$chaptersByClassroom"
                        :search-params="$searchParams"
                    />

                    @if ($hasSearch && $chapter)
                        <div class="card admin-card">
                            <div class="card-body">
                                <div class="admin-card-header d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
                                    <div>
                                        <h4 class="mb-1">جميع الدروس</h4>
                                        <p class="text-muted mb-0">
                                            {{ $chapter->title }} ({{ $chapter->academic_year }})
                                            — {{ $classRooms[(int) $chapter->classroom] ?? '' }}
                                        </p>
                                    </div>
                                    <a href="{{ route('admin.settings.lesson.create', $searchParams) }}" class="btn btn-primary">
                                        <i class="bx bx-plus"></i> إنشاء درس جديد
                                    </a>
                                </div>

                                <form method="POST"
                                    action="{{ route('admin.settings.lesson.resetViews', $chapter->id) }}"
                                    class="admin-reset-views-form mb-4"
                                    onsubmit="return confirm('هل أنت متأكد من ضبط مصنع المشاهدات لهذا الفصل؟ سيتم تصفير جميع مرات المشاهدة.');">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">
                                        <i class="bx bx-reset"></i>
                                        ضبط مصنع المشاهدات لفصل {{ $chapter->title }}
                                    </button>
                                </form>

                                <x-admin-data-table
                                    :data-lables="$dataLables"
                                    :data-rows="$dataRows"
                                    :paginator="$lessons"
                                    view-route="admin.settings.lesson.view"
                                    edit-route="admin.settings.lesson.edit"
                                    delete-route="admin.settings.lesson.delete"
                                    delete-confirm="هل أنت متأكد من حذف هذا الدرس وملفاته وسجل مشاهداته؟"
                                    empty-message="لا توجد دروس لهذا الفصل."
                                />
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
