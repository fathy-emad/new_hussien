<?php $page = 'admin-center-index'; ?>
@extends('layout.admin')
@section('content')
    @component('components.admin-breadcrumb')
        @slot('title')
            السناتر
        @endslot
        @slot('item1')
            الرئيسية
        @endslot
        @slot('item2')
            السناتر
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
                            <div class="admin-card-header d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
                                <div>
                                    <h4 class="mb-1">السناتر</h4>
                                    <p class="text-muted mb-0">إدارة جميع سناتر المستر</p>
                                </div>
                                <a href="{{ route('admin.settings.center.create') }}" class="btn btn-primary">
                                    <i class="bx bx-plus"></i> إضافة سنتر
                                </a>
                            </div>

                            <x-admin-data-table
                                :data-lables="$dataLables"
                                :data-rows="$dataRows"
                                :paginator="$centers"
                                edit-route="admin.settings.center.edit"
                                delete-route="admin.settings.center.delete"
                                delete-confirm="هل أنت متأكد من حذف هذا السنتر؟ لن يتم الحذف إذا كان مرتبطاً بطلاب أو جداول."
                                empty-message="لا توجد سناتر مسجلة حالياً."
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
