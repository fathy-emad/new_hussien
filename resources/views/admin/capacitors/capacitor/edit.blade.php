<?php $page = 'admin-offline-capacitor-edit'; ?>
@extends('layout.admin')
@section('content')
    @component('components.admin-breadcrumb')
        @slot('title')
            تعديل درس Offline
        @endslot
        @slot('item1')
            الرئيسية
        @endslot
        @slot('item2')
            Offline
        @endslot
        @slot('item2Url')
            {{ route('admin.capacitors.capacitor.index', $searchParams) }}
        @endslot
        @slot('item3')
            تعديل درس Offline
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
                                <h4 class="mb-1">تعديل: {{ $model->title }}</h4>
                                <p class="text-muted mb-0">عدّل بيانات الدرس ثم احفظ</p>
                            </div>

                            <form method="POST" action="{{ route('admin.capacitors.capacitor.update', $model->id) }}" enctype="multipart/form-data">
                                @csrf
                                @include('admin.capacitors.capacitor._form', [
                                    'model' => $model,
                                    'classRooms' => $classRooms,
                                    'searchParams' => $searchParams,
                                    'attachments' => $attachments,
                                ])

                                <div class="d-flex flex-wrap gap-2 mt-4">
                                    <button type="submit" class="btn btn-primary">حفظ التعديلات</button>
                                    <a href="{{ route('admin.capacitors.capacitor.index', $searchParams) }}" class="btn btn-outline-secondary">إلغاء</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('admin.capacitors.capacitor._dropzone-scripts', ['attachments' => $attachments])
@endsection
