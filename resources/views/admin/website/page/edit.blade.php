<?php $page = 'admin-website-page-edit'; ?>
@extends('layout.admin')
@section('content')
    @component('components.admin-breadcrumb')
        @slot('title')
            إدارة الموقع
        @endslot
        @slot('item1')
            الرئيسية
        @endslot
        @slot('item2')
            إدارة الموقع
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
                                <h4 class="mb-1">إدارة محتوى الصفحة الرئيسية</h4>
                                <p class="text-muted mb-0">عدّل عناوين وأوصاف الأقسام الظاهرة على موقع مستر حسين</p>
                            </div>

                            <form method="POST" action="{{ route('admin.website.page.update') }}">
                                @csrf
                                @include('admin.website.page._form', [
                                    'sections' => $sections,
                                ])

                                <div class="d-flex flex-wrap gap-2 mt-4">
                                    <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                                    <a href="{{ route('home') }}" target="_blank" class="btn btn-outline-secondary">معاينة الموقع</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('admin.website.page._dropzone-scripts', ['attachments' => $attachments])
@endsection
