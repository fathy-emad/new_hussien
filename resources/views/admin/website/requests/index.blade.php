<?php $page = 'admin-website-requests-index'; ?>
@extends('layout.admin')
@section('content')
    @component('components.admin-breadcrumb')
        @slot('title')
            طلبات الموقع
        @endslot
        @slot('item1')
            الرئيسية
        @endslot
        @slot('item2')
            طلبات الموقع
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
                                <h4 class="mb-1">استفسارات الموقع</h4>
                                <p class="text-muted mb-0">رسائل واستفسارات الزوار من صفحة الموقع</p>
                            </div>

                            <x-admin-data-table
                                :data-lables="$dataLables"
                                :data-rows="$dataRows"
                                :paginator="$asks"
                                view-route="admin.website.requests.view"
                                delete-route="admin.website.requests.delete"
                                :view-confirm="null"
                                delete-confirm="هل أنت متأكد من حذف هذا الاستفسار؟"
                                empty-message="لا توجد طلبات أو استفسارات حالياً."
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
