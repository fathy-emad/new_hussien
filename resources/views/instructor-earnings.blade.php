<?php $page = 'instructor-earnings'; ?>
@extends('layout.mainlayout')
@section('content')
    <!-- Page Wrapper -->
    <div class="page-content">
        <div class="container">
            <div class="row">

                @component('components.sidebar')
                @endcomponent

                <!-- Instructor Dashboard -->
                <div class="col-xl-9 col-lg-8 col-md-12">
                    <div class="settings-widget card-details">
                        <div class="settings-menu p-0">
                            <div class="profile-heading">
                                <h3>Earnings</h3>
                            </div>
                            <div class="checkout-form instructor-earnings-card">
                                <!-- Dashboard Grid -->
                                <div class="row justify-content-center">
                                    <div class="col-lg-4 col-md-6 d-flex">
                                        <div class="card dash-info flex-fill">
                                            <div class="card-body">
                                                <h5>Revenue</h5>
                                                <h2>$467</h2>
                                                <p>Earning this month</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 d-flex">
                                        <div class="card dash-info flex-fill">
                                            <div class="card-body">
                                                <h5>Students Enrollments</h5>
                                                <h2>12000</h2>
                                                <p>New this month</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 d-flex">
                                        <div class="card dash-info flex-fill">
                                            <div class="card-body">
                                                <h5>Courses Ratings</h5>
                                                <h2>4.8</h2>
                                                <p>Rating this month</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="earning-chart-header">
                                            <h5>Earnings by Year</h5>
                                            <div class="icon-form mb-0">
                                                <span class="form-icon"><i class="bx bx-calendar-edit"></i></span>
                                                <input type="text" class="form-control bookingrange"
                                                    placeholder="01 Jan 2024 - 01 Feb 2024">
                                            </div>
                                        </div>
                                        <div class="chart-body">
                                            <div id="earnigs_chart"></div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /Dashboard Grid -->
                            </div>
                        </div>
                    </div>

                    <div class="settings-widget card-details">
                        <div class="settings-menu p-0">
                            <div class="profile-heading">
                                <h3>Best Selling Courses</h3>
                            </div>
                            <div class="checkout-form">
                                <div class="table-responsive custom-table">

                                    <!-- Referred Users-->
                                    <table class="table table-nowrap mb-0">
                                        <thead>
                                            <tr>
                                                <th>Courses</th>
                                                <th>Sales</th>
                                                <th>Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="sell-table-group d-flex align-items-center">
                                                        <div class="sell-group-img">
                                                            <a href="{{ url('course-details') }}">
                                                                <img src="{{ URL::asset('/build/img/course/course-28.jpg') }}"
                                                                    class="img-fluid " alt="Img">
                                                            </a>
                                                        </div>
                                                        <div class="sell-tabel-info">
                                                            <p><a href="{{ url('course-details') }}">Build Responsive
                                                                    Websites with
                                                                    HTML5 and CSS3</a></p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>35</td>
                                                <td>4,620</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="sell-table-group d-flex align-items-center">
                                                        <div class="sell-group-img">
                                                            <a href="{{ url('course-details') }}">
                                                                <img src="{{ URL::asset('/build/img/course/course-29.jpg') }}"
                                                                    class="img-fluid " alt="Img">
                                                            </a>
                                                        </div>
                                                        <div class="sell-tabel-info">
                                                            <p><a href="{{ url('course-details') }}">C# Developers Double
                                                                    Your
                                                                    Coding with Visual Studio</a></p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>35</td>
                                                <td>4,620</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="sell-table-group d-flex align-items-center">
                                                        <div class="sell-group-img">
                                                            <a href="{{ url('course-details') }}">
                                                                <img src="{{ URL::asset('/build/img/course/course-30.jpg') }}"
                                                                    class="img-fluid " alt="Img">
                                                            </a>
                                                        </div>
                                                        <div class="sell-tabel-info">
                                                            <p><a href="{{ url('course-details') }}">Information About UI/UX
                                                                    Design
                                                                    Degree</a></p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>35</td>
                                                <td>4,620</td>
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
                <!-- /Instructor Dashboard -->

            </div>
        </div>
    </div>
    <!-- /Page Wrapper -->
@endsection
