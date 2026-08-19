<?php $page = 'student-social-profile'; ?>
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
		Social Profile
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
											<li><a href="{{url('student-social-profile')}}" class="active"><i class="bx bx-user-circle"></i>Social Profiles</a></li>
											<li><a href="{{url('student-linked-accounts')}}"><i class="bx bx-link"></i>Linked Accounts</a></li>
											<li><a href="{{url('student-notifications')}}"><i class="bx bx-bell"></i>Notifications</a></li>
										</ul>
									</div>
									<form action="student-social-profile">
										<div class="checkout-form settings-wrap">
											<div class="row">
												<div class="col-md-12">
													<div class="input-block">
														<label class="form-label">Website</label>
														<input type="text" class="form-control">
													</div>
												</div>
												<div class="col-md-12">
													<div class="input-block">
														<label class="form-label">Github</label>
														<input type="text" class="form-control">
													</div>
												</div>
												<div class="col-md-12">
													<div class="input-block">
														<label class="form-label">Facebook</label>
														<input type="text" class="form-control">
													</div>
												</div>	
												<div class="col-md-12">
													<div class="input-block">
														<label class="form-label">Twitter</label>
														<input type="text" class="form-control">
													</div>
												</div>										
												<div class="col-md-12">
													<div class="input-block">
														<label class="form-label">Linkedin</label>
														<input type="text" class="form-control">
													</div>
												</div>	
												<div class="col-md-12">
													<button class="btn btn-primary" type="submit">Save Profile</button>
												</div>
											</div>
										</div>
									</form>								
								</div>
							</div>
						</div>	
						<!-- /Student Settings -->
						
					</div>
				</div>
			</div>	
			<!-- /Page Content -->
    @endsection