<?php $page = 'admin-offline-capacitor-index'; ?>
@extends('layout.admin')
@section('content')
    @component('components.admin-breadcrumb')
        @slot('title')
            دروس Offline
        @endslot
        @slot('item1')
            الرئيسية
        @endslot
        @slot('item2')
            Offline
        @endslot
        @slot('item3')
            دروس Offline
        @endslot
    @endcomponent

    <div class="page-content">
        <div class="container">
            <div class="row">
                @include('components.admin-sidebar')

                <div class="col-xl-9 col-lg-9">
                    @include('components.admin-alerts')

                    <x-admin-offline-classroom-filter
                        :action="route('admin.capacitors.capacitor.index')"
                        :class-rooms="$classRooms"
                        :search-params="$searchParams"
                    />

                    @if ($hasSearch ?? false)
                        <div class="card admin-card">
                            <div class="card-body">
                                <div class="admin-card-header d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
                                    <div>
                                        <h4 class="mb-1">جميع دروس Offline</h4>
                                        <p class="text-muted mb-0">
                                            {{ $classRooms[(int) ($searchParams['classroom'] ?? 0)] ?? '' }}
                                        </p>
                                    </div>
                                    <a href="{{ route('admin.capacitors.capacitor.create', $searchParams) }}" class="btn btn-primary">
                                        <i class="bx bx-plus"></i> إنشاء درس Offline
                                    </a>
                                </div>

                                <x-admin-data-table
                                    :data-lables="$dataLables"
                                    :data-rows="$dataRows"
                                    :paginator="$capacitors"
                                    view-route="admin.capacitors.capacitor.view"
                                    edit-route="admin.capacitors.capacitor.edit"
                                    delete-route="admin.capacitors.capacitor.delete"
                                    :view-confirm="null"
                                    empty-message="لا توجد دروس Offline لهذا الصف."
                                />
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
