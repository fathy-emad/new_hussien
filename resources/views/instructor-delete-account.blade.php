<?php $page = 'instructor-delete-account'; ?>
@extends('layout.mainlayout')
@section('content')
    @component('components.breadcrumb')
        @slot('title')
            Settings
        @endslot
        @slot('item1')
            Home
        @endslot
        @slot('item2')
            Delete Account
        @endslot
    @endcomponent

    <!-- Page Content -->
    <div class="page-content">
        <div class="container">
            <div class="row">

                @component('components.sidebar')
                @endcomponent

                <!-- Instructor Settings -->
                <div class="col-xl-9 col-lg-9">

                    <div class="settings-widget card-details">
                        <div class="settings-menu p-0">
                            <div class="profile-heading">
                                <h3>Settings</h3>
                                <p>You have full control to manage your own account settings</p>
                            </div>
                            <div class="settings-page-head">
                                <ul class="settings-pg-links">
                                    <li><a href="{{ url('instructor-settings') }}"><i class="bx bx-edit"></i>Edit
                                            Profile</a></li>
                                    <li><a href="{{ url('instructor-change-password') }}"><i class="bx bx-lock"></i>Change
                                            Password</a></li>
                                    <li><a href="{{ url('instructor-setting-notifications') }}"><i
                                                class="bx bx-bell"></i>Notifications</a></li>
                                    <li><a href="{{ url('instructor-setting-withdraw') }}"><i
                                                class="bx bx-wallet-alt"></i>Withdraw</a></li>
                                    <li><a href="{{ url('instructor-delete-account') }}" class="active"><i
                                                class="bx bx-error-alt"></i>Delete Account</a></li>
                                </ul>
                            </div>
                            <div class="checkout-form settings-wrap">
                                <div class="edit-profile-info">
                                    <h5>Select a withdraw method</h5>
                                </div>
                                <div class="del-acc">
                                    <h6>Warning</h6>
                                    <p>If you close your account, you will be unsubscribed from all your 0 courses, and will
                                        lose access forever.</p>
                                </div>
                                <a href="{{ url('index') }}" class="btn btn-primary">Delete My Account</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Instructor Settings -->

            </div>
        </div>
    </div>
    <!-- /Page Content -->
@endsection
