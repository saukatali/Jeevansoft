@extends('adminpnlx.layouts.default')
@section('content') 

<?php
	$userInfo	=	Auth::guard("admins")->user();
	$email		=	(isset($userInfo->email)) ? $userInfo->email : '';
	$name		=	(isset($userInfo->username)) ? $userInfo->username : '';
?>
<!--begin::Content-->
	<div class="content  d-flex flex-column flex-column-fluid" id="kt_content">
		<!--begin::Subheader-->
		<div class="subheader py-2 py-lg-4  subheader-solid " id="kt_subheader">
			<div
				class=" container-fluid  d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
				<!--begin::Info-->
				<div class="d-flex align-items-center flex-wrap mr-1">
					<!--begin::Page Heading-->
					<div class="d-flex align-items-baseline flex-wrap mr-5">
						<!--begin::Page Title-->
						<h5 class="text-dark font-weight-bold my-1 mr-5">
							My Account </h5>
						<!--end::Page Title-->

						<!--begin::Breadcrumb-->
						<ul
							class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
							<li class="breadcrumb-item">
								<a href="{{ route('dashboard')}}" class="text-muted">Dashboard</a>
							</li>
						</ul>
						<!--end::Breadcrumb-->
					</div>
					<!--end::Page Heading-->
				</div>
				<!--end::Info-->

				@include("adminpnlx.elements.quick_links")
			</div>
		</div>
		<!--end::Subheader-->

		<!--begin::Entry-->
		<div class="d-flex flex-column-fluid">
			<!--begin::Container-->
			<div class=" container ">
				{{ Form::open(['role' => 'form','url' => 'adminpnlx/my-account','class' => 'mws-form','files'=>'true']) }}
				<div class="card">
					<div class="card-body">
						<div class="row">
							<div class="col-xl-1"></div>
							<div class="col-xl-10">
								<h3 class="mb-10 font-weight-bold text-dark"></h3>
								<div class="row">
								<div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="first_name">First Name</label> <span class="text-danger"> * </span>
                                        <input type="text" name="first_name"
                                            class="form-control form-control-solid form-control-lg" value="{{Auth::guard('admins')->user()->first_name}}"
                                            value="{{old('first_name') }}">
                                        @if ($errors->has('first_name'))
                                        <span class="error text-danger">{{ $errors->first('first_name') }}</span>
                                        @endif
                                    </div>
                                </div>

								<div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="last_name">Last Name</label> <span class="text-danger"> * </span>
                                        <input type="text" name="last_name"
                                            class="form-control form-control-solid form-control-lg" value="{{Auth::guard('admins')->user()->last_name}}"
                                            value="{{old('last_name') }}">
                                        @if ($errors->has('last_name'))
                                        <span class="error text-danger">{{ $errors->first('last_name') }}</span>
                                        @endif
                                    </div>
                                </div>

								<div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="email">Email</label> <span class="text-danger"> * </span>
                                        <input type="text" name="email"
                                            class="form-control form-control-solid form-control-lg" value="{{Auth::guard('admins')->user()->email}}"
                                            value="{{old('email') }}">
                                        @if ($errors->has('email'))
                                        <span class="error text-danger">{{ $errors->first('email') }}</span>
                                        @endif
                                    </div>
                                </div>

								<div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="phone_number">Phone Number</label> <span class="text-danger"> * </span>
                                        <input type="text" name="phone_number"
                                            class="form-control form-control-solid form-control-lg" value="{{Auth::guard('admins')->user()->phone_number}}"
                                            value="{{old('phone_number') }}">
                                        @if ($errors->has('phone_number'))
                                        <span class="error text-danger">{{ $errors->first('phone_number') }}</span>
                                        @endif
                                    </div>
                                </div>

								</div>
								
								<div class="d-flex justify-content-between border-top mt-5 pt-10">
									
									<div>
										<button	button type="submit" class="btn btn-success font-weight-bold text-uppercase px-9 py-4">
											Submit
										</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				{{ Form::close() }} 
			</div>
		</div>
	</div>
@stop
