<?php $page = 'instructor-assignment'; ?>
@extends('layout.mainlayout')
@section('content')
    @component('components.breadcrumb')
        @slot('title')
            Assignments
        @endslot
        @slot('item1')
            Home
        @endslot
        @slot('item2')
            Assignments
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
                                <h3>Assignments</h3>
                            </div>
                            <div class="checkout-form">
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
                                                    <option>Ascending</option>
                                                    <option>Descending</option>
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
                                            <th>Assignment Name</th>
                                            <th>Total Marks</th>
                                            <th>Total Submit</th>
                                            <th></th>
                                            <th></th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="announcement-table-data">
                                                        <h6>Building Your First Landing Page</h6>
                                                        <p>Course: Sketch from A to Z (2024): Become an app designer</p>
                                                    </div>
                                                </td>
                                                <td>80</td>
                                                <td>2</td>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center tab-title"><i class="bx bx-edit me-2"></i>Edit</a>
                                                </td>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center tab-title"><i class="bx bx-trash me-2"></i>Delete</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="announcement-table-data">
                                                        <h6>Building a Basic Angular Application</h6>
                                                        <p>Course: Learn Angular Fundamentals Beginners Guide</p>
                                                    </div>
                                                </td>
                                                <td>60</td>
                                                <td>4</td>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center tab-title"><i class="bx bx-edit me-2"></i>Edit</a>
                                                </td>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center tab-title"><i class="bx bx-trash me-2"></i>Delete</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="announcement-table-data">
                                                        <h6> Basic Arithmetic Operations</h6>
                                                        <p>Course: Learn JavaScript and Express to become a Expert</p>
                                                    </div>
                                                </td>
                                                <td>30</td>
                                                <td>3</td>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center tab-title"><i class="bx bx-edit me-2"></i>Edit</a>
                                                </td>
                                                <td>
                                                    <a href="#" class="d-flex align-items-center tab-title"><i class="bx bx-trash me-2"></i>Delete</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="announcement-table-data">
                                                        <h6> Basic Calculations</h6>
                                                        <p>Course: Introduction to Programming- 
                                                            Python & Java</p>
                                                    </div>
                                                </td>
                                                <td>50</td>
                                                <td>5</td>
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
