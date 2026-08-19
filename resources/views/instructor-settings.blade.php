<?php $page = 'instructor-settings'; ?>
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
            Edit Profile
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
                                    <li><a href="{{ url('instructor-settings') }}" class="active"><i
                                                class="bx bx-edit"></i>Edit Profile</a></li>
                                    <li><a href="{{ url('instructor-change-password') }}"><i class="bx bx-lock"></i>Change
                                            Password</a></li>
                                    <li><a href="{{ url('instructor-setting-notifications') }}"><i
                                                class="bx bx-bell"></i>Notifications</a></li>
                                    <li><a href="{{ url('instructor-setting-withdraw') }}"><i
                                                class="bx bx-wallet-alt"></i>Withdraw</a></li>
                                    <li><a href="{{ url('instructor-delete-account') }}"><i
                                                class="bx bx-error-alt"></i>Delete Account</a></li>
                                </ul>
                            </div>
                            <form action="{{ url('instructor-settings') }}">
                                <div class="course-group profile-upload-group mb-0 d-flex">
                                    <div class="course-group-img profile-edit-field d-flex align-items-center">
                                        <a href="{{ url('student-profile') }}" class="profile-pic"><img
                                                src="{{ URL::asset('/build/img/user/user-17.jpg') }}" alt=""
                                                class="img-fluid"></a>
                                        <div class="profile-upload-head">
                                            <h4><a href="{{ url('instructor-profile') }}">Your avatar</a></h4>
                                            <p>PNG or JPG no bigger than 800px width and height</p>
                                            <div class="new-employee-field">
                                                <div class="d-flex align-items-center mt-2">
                                                    <div class="image-upload mb-0">
                                                        <input type="file">
                                                        <div class="image-uploads">
                                                            <i class="bx bx-cloud-upload"></i>
                                                        </div>
                                                    </div>
                                                    <div class="img-delete">
                                                        <a href="" class="delete-icon"><i
                                                                class="bx bx-trash"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="checkout-form settings-wrap">
                                    <div class="edit-profile-info">
                                        <h5>Personal Details</h5>
                                        <p>Edit your personal information</p>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="input-block">
                                                <label class="form-label">First Name</label>
                                                <input type="text" class="form-control" value="Eugene">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-block">
                                                <label class="form-label">Last Name</label>
                                                <input type="text" class="form-control" value="Andre">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-block">
                                                <label class="form-label">User Name</label>
                                                <input type="text" class="form-control" value="studentdemo">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-block">
                                                <label class="form-label">Phone Number</label>
                                                <input type="text" class="form-control" value="90154-91036">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="input-block">
                                                <label class="form-label">Designation</label>
                                                <input type="text" class="form-control" value="Web Development">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="input-block">
                                                <label class="form-label">Bio</label>
                                                <textarea rows="4" class="form-control">Very well thought out and articulate communication. Clear milestones, deadlines and fast work. Patience. Infinite patience. No shortcuts. Even if the client is being careless. Some quick example text to build on the card title and bulk the card's content Moltin gives you platform. As a highly skilled and successfull product development and design specialist with more than 4 Years of My experience lies in successfully conceptualizing, designing, and modifying consumer products specific to interior design and home furnishings.</textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <button class="btn btn-primary" type="submit">Update Profile</button>
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
