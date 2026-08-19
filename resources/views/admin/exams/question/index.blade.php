<?php $page = 'admin-exams-question-index'; ?>
@extends('layout.admin')
@section('content')
    @component('components.admin-breadcrumb')
        @slot('title')
            الأسئلة والإجابات
        @endslot
        @slot('item1')
            الرئيسية
        @endslot
        @slot('item2')
            ادارة الامتحانات
        @endslot
        @slot('item3')
            الأسئلة والإجابات
        @endslot
    @endcomponent

    <div class="page-content">
        <div class="container">
            <div class="row">
                @include('components.admin-sidebar')

                <div class="col-xl-9 col-lg-9">
                    @include('components.admin-alerts')

                    <x-admin-offline-classroom-filter
                        :action="route('admin.exams.question.index')"
                        :class-rooms="$classRooms"
                        :search-params="$searchParams"
                    />

                    @if ($hasSearch ?? false)
                        <div class="card admin-card">
                            <div class="card-body">
                                <div class="admin-card-header d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
                                    <div>
                                        <h4 class="mb-1">بنك الأسئلة والإجابات</h4>
                                        <p class="text-muted mb-0">
                                            {{ $classRooms[(int) ($searchParams['classroom'] ?? 0)] ?? '' }}
                                        </p>
                                    </div>
                                    <a href="{{ route('admin.exams.question.create', $searchParams) }}" class="btn btn-primary">
                                        <i class="bx bx-plus"></i> إضافة سؤال
                                    </a>
                                </div>

                                <x-admin-data-table
                                    :data-lables="$dataLables"
                                    :data-rows="$dataRows"
                                    :paginator="$questions"
                                    view-route="admin.exams.question.view"
                                    edit-route="admin.exams.question.edit"
                                    :view-confirm="null"
                                    empty-message="لا توجد أسئلة لهذا الصف."
                                />
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
