<?php $page = 'instructor-setting-withdraw'; ?>
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
            Withdraw
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
                                    <li><a href="{{ url('instructor-setting-withdraw') }}" class="active"><i
                                                class="bx bx-wallet-alt"></i>Withdraw</a></li>
                                    <li><a href="{{ url('instructor-delete-account') }}"><i
                                                class="bx bx-error-alt"></i>Delete Account</a></li>
                                </ul>
                            </div>
                            <form action="{{ url('instructor-setting-withdraw') }}">
                                <div class="checkout-form settings-wrap pb-0">
                                    <div class="edit-profile-info">
                                        <h5>Select a withdraw method</h5>
                                    </div>
                                    <ul class="nav nav-pills d-block" id="pills-tab1" role="tablist">
                                        <li class="wallet-method withdraw-box" role="presentation">
                                            <label class="custom_radio mb-0" id="pills-public-tab" data-bs-toggle="pill"
                                                data-bs-target="#pills-public" role="tab" aria-controls="pills-public"
                                                aria-selected="true">
                                                <input type="radio" name="public">
                                                <span class="checkmark"></span> Bank Transfer</label>
                                            <p>Minimum withdraw $80</p>
                                        </li>
                                        <li class="wallet-method withdraw-box" role="presentation">
                                            <label class="custom_radio mb-0" id="pills-private-tab" data-bs-toggle="pill"
                                                data-bs-target="#pills-private" role="tab" aria-controls="pills-private"
                                                aria-selected="false">
                                                <input type="radio" name="public">
                                                <span class="checkmark"></span> E-Check</label>
                                            <p>Minimum withdraw $80</p>
                                        </li>
                                        <li class="wallet-method withdraw-box" role="presentation">
                                            <label class="custom_radio mb-0 active" id="pills-select-people-tab"
                                                data-bs-toggle="pill" data-bs-target="#pills-select-people" role="tab"
                                                aria-controls="pills-select-people" aria-selected="false">
                                                <input type="radio" name="public" checked>
                                                <span class="checkmark"></span> PayPal</label>
                                            <p>Minimum withdraw $80</p>
                                        </li>
                                    </ul>
                                    <div class="wrap-wallet">
                                        <div class="tab-content" id="pills-tabContent">
                                            <div class="tab-pane fade" id="pills-public" role="tabpanel"
                                                aria-labelledby="pills-public-tab">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="input-block">
                                                            <label class="form-label">Account Name</label>
                                                            <input type="text" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="input-block">
                                                            <label class="form-label">Account Number</label>
                                                            <input type="text" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="input-block">
                                                            <label class="form-label">Bank Name</label>
                                                            <input type="text" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="input-block">
                                                            <label class="form-label">IBAN</label>
                                                            <input type="text" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="input-block">
                                                            <label class="form-label">BIC / SWIFT</label>
                                                            <input type="text" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <button class="btn btn-primary" type="submit">Save Withdrawal
                                                            Account</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="pills-private" role="tabpanel"
                                                aria-labelledby="pills-private-tab">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="input-block">
                                                            <label class="form-label">Your Physical Address</label>
                                                            <input type="text" class="form-control">
                                                            <p class="label-slug">We will send you an E-Check to this
                                                                address directly</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <button class="btn btn-primary" type="submit">Save Withdrawal
                                                            Account</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade show active" id="pills-select-people"
                                                role="tabpanel" aria-labelledby="pills-select-people-tab">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="input-block">
                                                            <input type="text" class="form-control"
                                                                value="test@example.com">
                                                            <p class="label-slug">We will use this email address to send
                                                                the money to your Paypal account</p>
                                                            <label class="form-label">PayPal Email Address</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <button class="btn btn-primary" type="submit">Save Withdrawal
                                                            Account</button>
                                                    </div>
                                                </div>
                                            </div>
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
