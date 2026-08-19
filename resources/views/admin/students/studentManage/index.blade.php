<?php $page = 'admin-student-index'; ?>
@extends('layout.admin')
@section('content')
    @component('components.admin-breadcrumb')
        @slot('title')
            الطلاب
        @endslot
        @slot('item1')
            الرئيسية
        @endslot
        @slot('item2')
            ادارة الطلاب
        @endslot
        @slot('item3')
            الطلاب
        @endslot
    @endcomponent

    <div class="page-content">
        <div class="container">
            <div class="row">
                @include('components.admin-sidebar')

                <div class="col-xl-9 col-lg-9">
                    @include('components.admin-alerts')

                    <x-admin-student-search-filters
                        :action="route('admin.students.studentManage.index')"
                        :class-rooms="$classRooms"
                        :academic-years="$academicYears"
                        :centers="$centers"
                        :search-params="$searchParams"
                    />

                    @if ($hasSearch)
                        <div class="card admin-card">
                            <div class="card-body">
                                <div class="admin-card-header d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
                                    <div>
                                        <h4 class="mb-1">الطلاب</h4>
                                        <p class="text-muted mb-0">
                                            {{ $classRooms[(int) $searchParams['classroom']] ?? '' }}
                                            — {{ $searchParams['academic_year'] }}
                                            @php
                                                $centerTitle = ($searchParams['center_id'] ?? '') === 'none'
                                                    ? 'بدون سنتر'
                                                    : $centers->firstWhere('id', (int) ($searchParams['center_id'] ?? 0))?->title;
                                            @endphp
                                            @if ($centerTitle)
                                                — {{ $centerTitle }}
                                            @endif
                                        </p>
                                    </div>
                                    <a href="{{ route('admin.students.studentManage.create', $searchParams) }}" class="btn btn-primary">
                                        <i class="bx bx-plus"></i> إضافة طالب
                                    </a>
                                </div>

                                @if (! empty($searchParams['keyword']))
                                    <p class="text-muted small mb-3">
                                        نتائج البحث عن: <strong>{{ $searchParams['keyword'] }}</strong>
                                        — <a href="{{ route('admin.students.studentManage.index', array_merge($searchParams, ['keyword' => ''])) }}">مسح</a>
                                    </p>
                                @endif

                                <form method="GET" action="{{ route('admin.students.studentManage.index') }}" class="admin-table-keyword-search mb-4">
                                    <input type="hidden" name="academic_year" value="{{ $searchParams['academic_year'] }}">
                                    <input type="hidden" name="classroom" value="{{ $searchParams['classroom'] }}">
                                    <input type="hidden" name="center_id" value="{{ $searchParams['center_id'] }}">
                                    <div class="row g-2 align-items-end">
                                        <div class="col-md-8">
                                            <label class="form-label mb-1" for="table_keyword">بحث بالاسم أو الكود أو الموبايل</label>
                                            <input
                                                type="text"
                                                name="keyword"
                                                id="table_keyword"
                                                class="form-control"
                                                value="{{ $searchParams['keyword'] ?? '' }}"
                                                placeholder="اكتب للبحث في الجدول..."
                                            >
                                        </div>
                                        <div class="col-md-4 d-flex gap-2">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="bx bx-search"></i> بحث
                                            </button>
                                            @if (! empty($searchParams['keyword']))
                                                <a href="{{ route('admin.students.studentManage.index', collect($searchParams)->except('keyword')->all()) }}" class="btn btn-outline-secondary">مسح</a>
                                            @endif
                                        </div>
                                    </div>
                                </form>

                                <x-admin-data-table
                                    :data-lables="$dataLables"
                                    :data-rows="$dataRows"
                                    :paginator="$students"
                                    view-route="admin.students.studentManage.view"
                                    edit-route="admin.students.studentManage.edit"
                                    delete-route="admin.students.studentManage.delete"
                                    delete-confirm="هل أنت متأكد من حذف هذا الطالب؟"
                                    empty-message="لا يوجد طلاب لهذا البحث."
                                />
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
