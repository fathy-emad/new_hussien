<?php $page = 'admin-offline-card-index'; ?>
@extends('layout.admin')
@section('content')
    @component('components.admin-breadcrumb')
        @slot('title')
            الكروت
        @endslot
        @slot('item1')
            الرئيسية
        @endslot
        @slot('item2')
            Offline
        @endslot
        @slot('item3')
            الكروت
        @endslot
    @endcomponent

    <div class="page-content">
        <div class="container">
            <div class="row">
                @include('components.admin-sidebar')

                <div class="col-xl-9 col-lg-9">
                    @include('components.admin-alerts')

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show admin-alert" role="alert">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="card admin-card">
                        <div class="card-body">
                            <div class="admin-card-header d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
                                <div>
                                    <h4 class="mb-1">كروت Offline</h4>
                                    <p class="text-muted mb-0">إنشاء batches وتحميل أكواد الكروت CSV</p>
                                </div>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createOfflineCardModal">
                                    <i class="bx bx-plus"></i> إنشاء Batch جديد
                                </button>
                            </div>

                            <x-admin-data-table
                                :data-lables="$dataLables"
                                :data-rows="$dataRows"
                                :paginator="$batches"
                                view-route="admin.capacitors.card.view"
                                delete-route="admin.capacitors.card.delete"
                                :view-confirm="null"
                                delete-confirm="هل أنت متأكد من حذف هذا الباتش وجميع الكروت المرتبطة به؟"
                                empty-message="لا توجد batches حالياً. أنشئ batch جديد."
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="createOfflineCardModal" tabindex="-1" aria-labelledby="createOfflineCardModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="POST" action="{{ route('admin.capacitors.card.create') }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="createOfflineCardModalLabel">إنشاء Batch جديد</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label" for="offline_card_title">العنوان <span class="text-danger">*</span></label>
                            <input
                                type="text"
                                class="form-control @error('title') is-invalid @enderror"
                                name="title"
                                id="offline_card_title"
                                value="{{ old('title') }}"
                                required
                            >
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-0">
                            <label class="form-label" for="offline_card_count">عدد الكروت <span class="text-danger">*</span></label>
                            <input
                                type="number"
                                class="form-control @error('count') is-invalid @enderror"
                                name="count"
                                id="offline_card_count"
                                value="{{ old('count') }}"
                                min="1"
                                required
                            >
                            @error('count')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">إلغاء</button>
                        <button type="submit" class="btn btn-primary">إنشاء الكروت</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if ($errors->any())
        @push('scripts')
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const modal = document.getElementById('createOfflineCardModal');
                    if (modal) {
                        new bootstrap.Modal(modal).show();
                    }
                });
            </script>
        @endpush
    @endif
@endsection
