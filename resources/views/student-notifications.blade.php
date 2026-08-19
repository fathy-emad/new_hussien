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
        notifications
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
											<li><a href="{{url('student-settings')}}"><i class="bx bx-edit"></i>Edit Profile</a></li>
											<li><a href="{{url('student-change-password')}}"><i class="bx bx-lock"></i>Change Password</a></li>
											<li><a href="{{url('student-social-profile')}}"><i class="bx bx-user-circle"></i>Social Profiles</a></li>
											<li><a href="{{url('student-linked-accounts')}}"><i class="bx bx-link"></i>Linked Accounts</a></li>
											<li><a href="{{url('student-notifications')}}" class="active"><i class="bx bx-bell"></i>Notifications</a></li>
										</ul>
									</div>
									<div class="checkout-form settings-wrap">
										<h5>Choose when and how to be notified</h5>
										<ul class="settings-noti-lists">
											<li>
												<div class="notification-title">
													<h6>Subscriptions</h6>
													<p>Notify me about activity from profile I’m subscribe to</p>
												</div>
												<div class="status-toggle modal-status">
													<input type="checkbox" id="user1" class="check" checked="">
													<label for="user1" class="checktoggle">	</label>
												</div>
											</li>
											<li>
												<div class="notification-title">
													<h6>Recommended Courses</h6>
													<p>Notify me about courses that suits for me</p>
												</div>
												<div class="status-toggle modal-status">
													<input type="checkbox" id="user2" class="check" checked="">
													<label for="user2" class="checktoggle">	</label>
												</div>
											</li>
											<li>
												<div class="notification-title">
													<h6>Reply to my comments</h6>
													<p>Notify me about replies for my comments</p>
												</div>
												<div class="status-toggle modal-status">
													<input type="checkbox" id="user3" class="check" checked="">
													<label for="user3" class="checktoggle">	</label>
												</div>
											</li>
											<li>
												<div class="notification-title">
													<h6>Activity on my comments</h6>
													<p>Notify me about replies for my comments</p>
												</div>
												<div class="status-toggle modal-status">
													<input type="checkbox" id="user4" class="check">
													<label for="user4" class="checktoggle">	</label>
												</div>
											</li>
										</ul>
										<h5>Email Notifications</h5>
										<ul class="settings-noti-lists email-noti-lists">
											<li>
												<div class="notification-title">
													<h6>Subscriptions</h6>
													<p>Notify me about activity from profile I’m subscribe to</p>
												</div>
												<div class="status-toggle modal-status">
													<input type="checkbox" id="user5" class="check" checked="">
													<label for="user5" class="checktoggle">	</label>
												</div>
											</li>
											<li>
												<div class="notification-title">
													<h6>Recommended Courses</h6>
													<p>Notify me about courses that suits for me</p>
												</div>
												<div class="status-toggle modal-status">
													<input type="checkbox" id="user6" class="check" checked="">
													<label for="user6" class="checktoggle">	</label>
												</div>
											</li>
											<li>
												<div class="notification-title">
													<h6>Reply to my comments</h6>
													<p>Notify me about replies for my comments</p>
												</div>
												<div class="status-toggle modal-status">
													<input type="checkbox" id="user7" class="check" checked="">
													<label for="user7" class="checktoggle">	</label>
												</div>
											</li>
										</ul>
										<a href="#" class="btn btn-primary">Save Changes</a>
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