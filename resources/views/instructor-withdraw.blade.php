<?php $page = 'instructor-withdraw'; ?>
@extends('layout.mainlayout')
@section('content')
    @component('components.breadcrumb')
        @slot('title')
            Withdrawal
        @endslot
        @slot('item1')
            Home
        @endslot
        @slot('item2')
            Withdrawal
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
                                <h3>Withdrawal</h3>
                            </div>
                            <div class="checkout-form">
                                <div class="withdrawel-head">
                                    <div class="title-withdrawel">
                                        <span class="file-text-icon">
                                            <i class="bx bxs-wallet"></i>
                                        </span>
                                        <div class="info-withdraw">
                                            <h6>Current Balance</h6>
                                            <h5>You have <span>$486</span> ready to withdraw now</h5>
                                        </div>
                                    </div>
                                    <div class="add-announcement-btn">
                                        <a href="#" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#withdraw-request">Withdrawal Request</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="settings-widget card-details">
                        <div class="settings-menu p-0">
                            <div class="profile-heading">
                                <h3>Withdrawal History</h3>
                            </div>
                            <div class="checkout-form">
                                <div class="table-responsive custom-table">

                                    <!-- Referred Users-->
                                    <table class="table table-nowrap mb-0">
                                        <thead>
                                            <tr>
                                                <th>Withdrawal Method</th>
                                                <th>Requested On</th>
                                                <th>Amount</th>
                                                <th>Status</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="payment-method-data">
                                                        <span><img src="{{ URL::asset('/build/img/icon/paypal-icon.svg') }}"
                                                                alt=""></span>
                                                        <div class="payment-name">
                                                            Paypal <br>
                                                            te****t@example.com
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    March 20, 2024 <br>
                                                    10:30 AM
                                                </td>
                                                <td>
                                                    $100
                                                </td>
                                                <td>
                                                    <span class="status-badge badge-soft-warning">Pending</span>
                                                </td>
                                                <td><i class="bx bx-info-circle"></i></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="payment-method-data">
                                                        <span><img src="{{ URL::asset('/build/img/icon/paypal-icon.svg') }}"
                                                                alt=""></span>
                                                        <div class="payment-name">
                                                            Paypal <br>
                                                            te****t@example.com
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    March 24, 2024 <br>
                                                    11:40 AM
                                                </td>
                                                <td>
                                                    $120
                                                </td>
                                                <td>
                                                    <span class="status-badge badge-soft-danger">Cancelled</span>
                                                </td>
                                                <td><i class="bx bx-info-circle"></i></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="payment-method-data">
                                                        <span><img src="{{ URL::asset('/build/img/icon/paypal-icon.svg') }}"
                                                                alt=""></span>
                                                        <div class="payment-name">
                                                            Paypal <br>
                                                            te****t@example.com
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    March 26, 2024 <br>
                                                    01:15 PM
                                                </td>
                                                <td>
                                                    $300
                                                </td>
                                                <td>
                                                    <span class="status-badge badge-soft-warning">Pending</span>
                                                </td>
                                                <td><i class="bx bx-info-circle"></i></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="payment-method-data">
                                                        <span><img src="{{ URL::asset('/build/img/icon/paypal-icon.svg') }}"
                                                                alt=""></span>
                                                        <div class="payment-name">
                                                            Paypal <br>
                                                            te****t@example.com
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    April 02, 2024 <br>
                                                    09:10 AM
                                                </td>
                                                <td>
                                                    $140
                                                </td>
                                                <td>
                                                    <span class="status-badge badge-soft-success">Success</span>
                                                </td>
                                                <td><i class="bx bx-info-circle"></i></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="payment-method-data">
                                                        <span><img src="{{ URL::asset('/build/img/icon/paypal-icon.svg') }}"
                                                                alt=""></span>
                                                        <div class="payment-name">
                                                            Paypal <br>
                                                            te****t@example.com
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    March 20, 2024 <br>
                                                    10:30 AM
                                                </td>
                                                <td>
                                                    $100
                                                </td>
                                                <td>
                                                    <span class="status-badge badge-soft-warning">Pending</span>
                                                </td>
                                                <td><i class="bx bx-info-circle"></i></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="payment-method-data">
                                                        <span><img src="{{ URL::asset('/build/img/icon/paypal-icon.svg') }}"
                                                                alt=""></span>
                                                        <div class="payment-name">
                                                            Paypal <br>
                                                            te****t@example.com
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    March 24, 2024 <br>
                                                    11:40 AM
                                                </td>
                                                <td>
                                                    $120
                                                </td>
                                                <td>
                                                    <span class="status-badge badge-soft-danger">Cancelled</span>
                                                </td>
                                                <td><i class="bx bx-info-circle"></i></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="payment-method-data">
                                                        <span><img src="{{ URL::asset('/build/img/icon/paypal-icon.svg') }}"
                                                                alt=""></span>
                                                        <div class="payment-name">
                                                            Paypal <br>
                                                            te****t@example.com
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    March 26, 2024 <br>
                                                    01:15 PM
                                                </td>
                                                <td>
                                                    $300
                                                </td>
                                                <td>
                                                    <span class="status-badge badge-soft-warning">Pending</span>
                                                </td>
                                                <td><i class="bx bx-info-circle"></i></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="payment-method-data">
                                                        <span><img src="{{ URL::asset('/build/img/icon/paypal-icon.svg') }}"
                                                                alt=""></span>
                                                        <div class="payment-name">
                                                            Paypal <br>
                                                            te****t@example.com
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    April 02, 2024 <br>
                                                    09:10 AM
                                                </td>
                                                <td>
                                                    $140
                                                </td>
                                                <td>
                                                    <span class="status-badge badge-soft-success">Success</span>
                                                </td>
                                                <td><i class="bx bx-info-circle"></i></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="payment-method-data">
                                                        <span><img src="{{ URL::asset('/build/img/icon/paypal-icon.svg') }}"
                                                                alt=""></span>
                                                        <div class="payment-name">
                                                            Paypal <br>
                                                            te****t@example.com
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    May 20, 2024 <br>
                                                    03:00 PM
                                                </td>
                                                <td>
                                                    $460
                                                </td>
                                                <td>
                                                    <span class="status-badge badge-soft-warning">Pending</span>
                                                </td>
                                                <td><i class="bx bx-info-circle"></i></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="payment-method-data">
                                                        <span><img src="{{ URL::asset('/build/img/icon/paypal-icon.svg') }}"
                                                                alt=""></span>
                                                        <div class="payment-name">
                                                            Paypal <br>
                                                            te****t@example.com
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    June 22, 2024 <br>
                                                    06:40 PM
                                                </td>
                                                <td>
                                                    $200
                                                </td>
                                                <td>
                                                    <span class="status-badge badge-soft-danger">Cancelled</span>
                                                </td>
                                                <td><i class="bx bx-info-circle"></i></td>
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
