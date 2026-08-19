<?php $page = 'student-linked-accounts'; ?>
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
            Linked Accounts
        @endslot
    @endcomponent


    <!-- Page Content -->
    <div class="page-content">
        <div class="container">
            <div class="row">

                @component('components.sidebar')
                @endcomponent

                <!-- Student Settings -->
                <div class="col-xl-9 col-lg-9">

                    <div class="settings-widget card-details">
                        <div class="settings-menu p-0">
                            <div class="profile-heading">
                                <h3>Settings</h3>
                                <p>You have full control to manage your own account settings</p>
                            </div>
                            <div class="settings-page-head">
                                <ul class="settings-pg-links">
                                    <li><a href="{{ url('student-settings') }}"><i class="bx bx-edit"></i>Edit Profile</a>
                                    </li>
                                    <li><a href="{{ url('student-change-password') }}"><i class="bx bx-lock"></i>Change
                                            Password</a></li>
                                    <li><a href="{{ url('student-social-profile') }}"><i
                                                class="bx bx-user-circle"></i>Social Profiles</a></li>
                                    <li><a href="{{ url('student-linked-accounts') }}" class="active"><i
                                                class="bx bx-link"></i>Linked Accounts</a></li>
                                    <li><a href="{{ url('student-notifications') }}"><i
                                                class="bx bx-bell"></i>Notifications</a></li>
                                </ul>
                            </div>
                            <div class="checkout-form settings-wrap">
                                <ul class="lined-accounts-list">
                                    <li>
                                        <div class="account-icon">
                                            <img src="{{ URL::asset('/build/img/icon/fb-icon.svg') }}" alt="Img">
                                        </div>
                                        <div class="account-info">
                                            <div class="account-name">
                                                <h5>Facebook</h5>
                                            </div>
                                            <p>Enable one - click login and receive more personalized course recommendations
                                            </p>
                                            <a href="#" class="linked-btn">Remove my facebook account</a>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="account-icon">
                                            <img src="{{ URL::asset('/build/img/icon/google-icon.svg') }}" alt="Img">
                                        </div>
                                        <div class="account-info">
                                            <div class="account-name">
                                                <h5>Google</h5>
                                            </div>
                                            <p>Enable one - click login and receive more personalized course recommendations
                                            </p>
                                            <a href="#" class="linked-btn">Link my google account</a>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="account-icon">
                                            <img src="{{ URL::asset('/build/img/icon/github-icon.svg') }}" alt="Img">
                                        </div>
                                        <div class="account-info">
                                            <div class="account-name">
                                                <h5>Github</h5>
                                            </div>
                                            <p>Enable one - click login and receive more personalized course recommendations
                                            </p>
                                            <a href="#" class="linked-btn">Link my github account</a>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="account-icon">
                                            <img src="{{ URL::asset('/build/img/icon/twitter-x-icon.svg') }}"
                                                alt="Img">
                                        </div>
                                        <div class="account-info">
                                            <div class="account-name">
                                                <h5>Twitter</h5>
                                            </div>
                                            <p>Enable one - click login and receive more personalized course recommendations
                                            </p>
                                            <a href="#" class="linked-btn">Link my twitter account</a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Student Settings -->

            </div>
        </div>
    </div>
    <!-- /Page Content -->
@endsection
