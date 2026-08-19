<?php $page = 'instructor-change-password'; ?>
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
            Change Password
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
                                    <li><a href="{{ url('instructor-change-password') }}" class="active"><i
                                                class="bx bx-lock"></i>Change Password</a></li>
                                    <li><a href="{{ url('instructor-setting-notifications') }}"><i
                                                class="bx bx-bell"></i>Notifications</a></li>
                                    <li><a href="{{ url('instructor-setting-withdraw') }}"><i
                                                class="bx bx-wallet-alt"></i>Withdraw</a></li>
                                    <li><a href="{{ url('instructor-delete-account') }}"><i
                                                class="bx bx-error-alt"></i>Delete Account</a></li>
                                </ul>
                            </div>
                            <form action="{{ url('instructor-change-password') }}">
                                <div class="checkout-form settings-wrap">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="input-block">
                                                <label class="form-label">Current Password</label>
                                                <input type="password" class="form-control">
                                            </div>
                                            <div class="input-block">
                                                <label class="form-label">New Password</label>
                                                <input type="password" class="form-control">
                                            </div>
                                            <div class="input-block">
                                                <label class="form-label">Re-type New Password</label>
                                                <input type="password" class="form-control">
                                            </div>
                                            <button class="btn btn-primary" type="submit">Reset Password</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /Instructor Settings -->

            </div>
        </div>
    </div>
    <!-- /Page Content -->
@endsection
