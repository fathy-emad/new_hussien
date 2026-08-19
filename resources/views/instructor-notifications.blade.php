<?php $page = 'instructor-notifications'; ?>
@extends('layout.mainlayout')
@section('content')
    @component('components.breadcrumb')
        @slot('title')
            Notifications
        @endslot
        @slot('item1')
            Home
        @endslot
        @slot('item2')
            Notifications
        @endslot
    @endcomponent

    <!-- Page Content -->
    <div class="page-content">
        <div class="container">
            <div class="row">

                @component('components.sidebar')
                @endcomponent

                <!-- Instructor profile -->
                <div class="col-xl-9 col-lg-9">

                    <div class="settings-widget card-details mb-0">
                        <div class="settings-menu p-0">
                            <div class="profile-heading">
                                <h3>Notifications</h3>
                            </div>
                            <div class="checkout-form personal-address">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="d-flex instructor-noti-head align-items-center">
                                            <div class="icon-form mb-0">
                                                <span class="form-icon"><i class="bx bx-calendar-edit"></i></span>
                                                <input type="text" class="form-control bookingrange"
                                                    placeholder="01 Jan 2024 - 01 Feb 2024">
                                            </div>
                                            <div class="noti-mark-btns">
                                                <ul>
                                                    <li>
                                                        <a href="#" class="btn"><i class="feather-check me-2"></i>
                                                            Mark all as read</a>
                                                    </li>
                                                    <li>
                                                        <a href="#" class="btn btn-delete"><i
                                                                class="feather-trash-2 me-2"></i> Delete all</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="notication-list">
                                            <div class="notication-item">
                                                <div class="row">
                                                    <div class="col-md-9">
                                                        <div class="notication-content">
                                                            <span>
                                                                <img src="{{ URL::asset('/build/img/user/user2.jpg') }}"
                                                                    class="img-fluid" alt="img">
                                                            </span>
                                                            <div class="notication-info">
                                                                <p><span>Thompson</span> Hicks enroll a new course on
                                                                    Programming</p>
                                                                <p class="notify-time">10 mins ago</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="notification-btn text-end">
                                                            <a href="javascript:void(0);" class="btn btn-danger">Delete</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="notication-item">
                                                <div class="row">
                                                    <div class="col-md-9">
                                                        <div class="notication-content">
                                                            <span>
                                                                <img src="{{ URL::asset('/build/img/user/user1.jpg') }}"
                                                                    class="img-fluid" alt="img">
                                                            </span>
                                                            <div class="notication-info">
                                                                <p><span>Shirley</span> Lis submitted the assignent on
                                                                    Complete <span> HTML, CSS and Javascript Course </span>
                                                                </p>
                                                                <p class="notify-time">12 mins ago</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="notification-btn text-end">
                                                            <a href="javascript:void(0);" class="btn btn-danger">Delete</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="notication-item">
                                                <div class="row">
                                                    <div class="col-md-9">
                                                        <div class="notication-content">
                                                            <span>
                                                                <img src="{{ URL::asset('/build/img/user/user12.jpg') }}"
                                                                    class="img-fluid" alt="img">
                                                            </span>
                                                            <div class="notication-info">
                                                                <p><span>James </span> Schulte replied to your comment </p>
                                                                <p class="notify-time">15 mins ago</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="notification-btn text-end">
                                                            <a href="javascript:void(0);" class="btn btn-danger">Delete</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /Instructor profile -->

            </div>
        </div>
    </div>
    <!-- /Page Content -->
@endsection
