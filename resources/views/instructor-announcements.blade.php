<?php $page = 'instructor-announcements'; ?>
@extends('layout.mainlayout')
@section('content')
    @component('components.breadcrumb')
        @slot('title')
            Announcements
        @endslot
        @slot('item1')
            Home
        @endslot
        @slot('item2')
            Announcements
        @endslot
    @endcomponent

   	<!-- Page Content -->
       <div class="page-content">
        <div class="container">
            <div class="row">
                
              
    @component('components.sidebar')
    @endcomponent
                
                <!-- Instructor Quiz -->
                <div class="col-xl-9 col-lg-9">	

                    <div class="settings-widget card-details">
                        <div class="settings-menu p-0">
                            <div class="profile-heading">
                                <h3>Announcements</h3>
                            </div>
                            <div class="checkout-form">
                                <div class="announcement-head">
                                    <div class="announcement-titlte">
                                        <h5>Notify your all students</h5>
                                        <p>Create Announcement</p>
                                    </div>
                                    <div class="add-announcement-btn">
                                        <a href="#" class="btn btn-primary">Add New Announcement</a>
                                    </div>
                                </div>
                                <div class="announcement-filter-head">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="input-block">
                                                <label  class="form-label">Courses</label>
                                                <select class="form-select select country-select"  name="sellist1">
                                                    <option>All</option>
                                                    <option>Javascript Course</option>
                                                    <option> Fullstack Web Developer</option>
                                                    <option>UI/UX Design</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-block">
                                                <label  class="form-label">Sort By</label>
                                                <select class="form-select select country-select"  name="sellist1">
                                                    <option>Default</option>
                                                    <option>Newest</option>
                                                    <option>Oldest</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-block">
                                                <label  class="form-label">Sort By Offer</label>
                                                <select class="form-select select country-select"  name="sellist1">
                                                    <option>Paid</option>
                                                    <option>Unpaid</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive custom-table">

                                    <!-- Referred Users-->
                                    <table class="table table-nowrap mb-0">
                                        <thead>
                                          <tr>
                                            <th>Date</th>
                                            <th>Announcements</th>
                                            <th></th>
                                            <th></th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div>
                                                        March 12, 2024 <br>
                                                        05:40 PM
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="announcement-table-data">
                                                        <h6>Welcome to Introduction to Programming</h6>
                                                        <p class="mb-0">Course: Introduction to Programming- 
                                                            Python & Java</p>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center tab-title"><i class="bx bx-edit me-2"></i>Edit</a>
                                                </td>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center tab-title"><i class="bx bx-trash me-2"></i>Delete</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div>
                                                        March 17, 2024 <br>
                                                        10:00 AM
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="announcement-table-data">
                                                        <h6>Essay Assignment Due Date Approaching</h6>
                                                        <p class="mb-0">Course: Sketch from A to Z (2024): Become an app designer
                                                        </p>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center tab-title"><i class="bx bx-edit me-2"></i>Edit</a>
                                                </td>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center tab-title"><i class="bx bx-trash me-2"></i>Delete</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div>
                                                        April 10, 2024 <br>
                                                        12:30 PM
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="announcement-table-data">
                                                        <h6>Final Exam Schedule and Preparation Tips</h6>
                                                        <p class="mb-0">Course: Learn Angular Fundamentals Beginners Guide</p>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center tab-title"><i class="bx bx-edit me-2"></i>Edit</a>
                                                </td>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center tab-title"><i class="bx bx-trash me-2"></i>Delete</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div>
                                                        April 24, 2024 <br>
                                                        02:20 PM
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="announcement-table-data">
                                                        <h6>New Video Lectures Added</h6>
                                                        <p class="mb-0">Course: Learn JavaScript and Express to become a Expert</p>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center tab-title"><i class="bx bx-edit me-2"></i>Edit</a>
                                                </td>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center tab-title"><i class="bx bx-trash me-2"></i>Delete</a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="dash-pagination">
                        <div class="row align-items-center">
                            <div class="col-6">
                                <p>Page 1 of 2</p>
                            </div>
                            <div class="col-6">
                                <ul class="pagination">
                                    <li class="active">
                                        <a href="#">1</a>
                                    </li>
                                    <li>
                                        <a href="#">2</a>
                                    </li>
                                    <li>
                                        <a href="#"><i class="bx bx-chevron-right"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>	
                <!-- /Instructor Quiz -->

            </div>
        </div>
    </div>	
    <!-- /Page Content -->
@endsection
