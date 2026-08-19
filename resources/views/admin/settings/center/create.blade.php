<?php $page = 'admin-center-create'; ?>
@extends('layout.admin')
@section('content')
    @component('components.admin-breadcrumb')
        @slot('title')
            إضافة سنتر
        @endslot
        @slot('item1')
            الرئيسية
        @endslot
        @slot('item2')
            السناتر
        @endslot
        @slot('item2Url')
            {{ route('admin.settings.center.index') }}
        @endslot
        @slot('item3')
            إضافة سنتر
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
                                <h4 class="mb-1">إضافة سنتر جديد</h4>
                                <p class="text-muted mb-0">أدخل بيانات السنتر ثم احفظ</p>
                            </div>

                            <form method="POST" action="{{ route('admin.settings.center.create.submit') }}">
                                @csrf
                                @include('admin.settings.center._form')

                                <div class="d-flex flex-wrap gap-2 mt-4">
                                    <button type="submit" class="btn btn-primary">حفظ</button>
                                    <a href="{{ route('admin.settings.center.index') }}" class="btn btn-outline-secondary">إلغاء</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
