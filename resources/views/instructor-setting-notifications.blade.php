<?php $page = 'instructor-setting-notifications'; ?>
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
            Notifications
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
                                    <li><a href="{{ url('instructor-notifications') }}" class="active"><i
                                                class="bx bx-bell"></i>Notifications</a></li>
                                    <li><a href="{{ url('instructor-setting-withdraw') }}"><i
                                                class="bx bx-wallet-alt"></i>Withdraw</a></li>
                                    <li><a href="{{ url('instructor-delete-account') }}"><i
                                                class="bx bx-error-alt"></i>Delete Account</a></li>
                                </ul>
                            </div>
                            <div class="checkout-form settings-wrap">
                                <h5>Choose when and how to be notified</h5>
                                <ul class="settings-noti-lists">
                                    <li>
                                        <div class="notification-title">
                                            <h6>Student Questions</h6>
                                            <p>Notify me when a student asks a question in the Q&A section</p>
                                        </div>
                                        <div class="status-toggle modal-status">
                                            <input type="checkbox" id="user1" class="check" checked="">
                                            <label for="user1" class="checktoggle"> </label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="notification-title">
                                            <h6>Feedback Received</h6>
                                            <p>Notify me when receive feedback from students</p>
                                        </div>
                                        <div class="status-toggle modal-status">
                                            <input type="checkbox" id="user2" class="check" checked="">
                                            <label for="user2" class="checktoggle"> </label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="notification-title">
                                            <h6>Quiz/Exam Results Submission</h6>
                                            <p>Notify me when quiz or exam results are submitted</p>
                                        </div>
                                        <div class="status-toggle modal-status">
                                            <input type="checkbox" id="user3" class="check" checked="">
                                            <label for="user3" class="checktoggle"> </label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="notification-title">
                                            <h6>Forum Activity</h6>
                                            <p>Notify me about new posts or replies in course discussion forums.</p>
                                        </div>
                                        <div class="status-toggle modal-status">
                                            <input type="checkbox" id="user4" class="check">
                                            <label for="user4" class="checktoggle"> </label>
                                        </div>
                                    </li>
                                </ul>
                                <h5>Email Notifications</h5>
                                <ul class="settings-noti-lists email-noti-lists">
                                    <li>
                                        <div class="notification-title">
                                            <h6>Course Enrollment</h6>
                                            <p>Send me emails when a new student enrolls the course</p>
                                        </div>
                                        <div class="status-toggle modal-status">
                                            <input type="checkbox" id="user5" class="check" checked="">
                                            <label for="user5" class="checktoggle"> </label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="notification-title">
                                            <h6>Assignment Submission</h6>
                                            <p>Send me email whenever an assignment is submitted by a student</p>
                                        </div>
                                        <div class="status-toggle modal-status">
                                            <input type="checkbox" id="user6" class="check" checked="">
                                            <label for="user6" class="checktoggle"> </label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="notification-title">
                                            <h6>System Updates</h6>
                                            <p>Send me emails about updates to the LMS platform </p>
                                        </div>
                                        <div class="status-toggle modal-status">
                                            <input type="checkbox" id="user7" class="check" checked="">
                                            <label for="user7" class="checktoggle"> </label>
                                        </div>
                                    </li>
                                </ul>
                                <a href="#" class="btn btn-primary">Save Changes</a>
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
