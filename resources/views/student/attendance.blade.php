<?php $page = 'student-attendance'; ?>
@extends('layout.student')
@section('content')
    <div class="page-content">
        <div class="container">
            <div class="row">
                @include('components.student-sidebar')

                <div class="col-xl-9 col-lg-9">
                    <div class="card admin-card">
                        <div class="card-body">
                            <h4 class="mb-4">سجل الحضور والغياب</h4>

                            @forelse ($monthBlocks as $block)
                                <div class="mb-4">
                                    <h5 class="mb-3">{{ $block['label'] }}</h5>
                                    <div class="table-responsive">
                                        <table class="table table-bordered mb-0">
                                            <thead>
                                                <tr>
                                                    <th>التاريخ</th>
                                                    <th>السنتر</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($block['items'] as $item)
                                                    <tr>
                                                        <td>{{ $item->created_label }}</td>
                                                        <td>{{ $item->center?->title ?? '—' }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @empty
                                <p class="text-muted mb-0">لا يوجد سجل حضور حتى الآن.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
