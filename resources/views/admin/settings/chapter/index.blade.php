<?php $page = 'admin-chapter-index'; ?>
@extends('layout.admin')
@section('content')
    @component('components.admin-breadcrumb')
        @slot('title')
            جميع الفصول
        @endslot
        @slot('item1')
            الرئيسية
        @endslot
        @slot('item2')
            إدارة الفصول
        @endslot
        @slot('item2Url')
            {{ route('admin.settings.chapter.index') }}
        @endslot
        @slot('item3')
            جميع الفصول
        @endslot
    @endcomponent

    <div class="page-content">
        <div class="container">
            <div class="row">
                @include('components.admin-sidebar')

                <div class="col-xl-9 col-lg-9">
                    @include('components.admin-alerts')

                    <x-admin-search-filters
                        :action="route('admin.settings.chapter.index')"
                        :class-rooms="$classRooms"
                        :academic-years="$academicYears"
                        :search-params="$searchParams"
                    />

                    @if ($hasSearch)
                        <div class="card admin-card">
                            <div class="card-body">
                                <div class="admin-card-header d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
                                    <div>
                                        <h4 class="mb-1">جميع الفصول</h4>
                                        <p class="text-muted mb-0">
                                            {{ $classRooms[(int) $searchParams['classroom']] ?? '' }}
                                            — {{ $searchParams['academic_year'] }}
                                        </p>
                                    </div>
                                    <a href="{{ route('admin.settings.chapter.create', $searchParams) }}" class="btn btn-primary">
                                        <i class="bx bx-plus"></i> إنشاء فصل جديد
                                    </a>
                                </div>

                                <x-admin-data-table
                                    :data-lables="$dataLables"
                                    :data-rows="$dataRows"
                                    :paginator="$chapters"
                                    edit-route="admin.settings.chapter.edit"
                                delete-route="admin.settings.chapter.delete"
                                delete-confirm="هل أنت متأكد من حذف هذا الفصل؟ لن يتم الحذف إذا كان يحتوي على دروس."
                                    empty-message="لا توجد فصول لهذا البحث."
                                />
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
