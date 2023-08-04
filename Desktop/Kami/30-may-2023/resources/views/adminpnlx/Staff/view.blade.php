@extends('adminpnlx.layouts.default')
@section('content')
<!--begin::Content-->
<div class="content  d-flex flex-column flex-column-fluid" id="kt_content">
	<!--begin::Subheader-->
	<div class="subheader py-2 py-lg-4  subheader-solid " id="kt_subheader">
		<div
			class=" container-fluid  d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
			<!--begin::Info-->
			<div class="d-flex align-items-center flex-wrap mr-1">
				<!--begin:: Heading-->
				<div class="d-flex align-items-baseline flex-wrap mr-5">
					<!--begin::Page Title-->
					<h5 class="text-dark font-weight-bold my-1 mr-5">
					{{ Config('constants.STAFFS.STAFF_TITLE') }}
				   </h5>

					<!--begin::Breadcrumb-->
					<ul
						class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
						<li class="breadcrumb-item">
							<a href="{{ route('dashboard')}}" class="text-muted">Dashboard</a>
						</li>
						<li class="breadcrumb-item">
							<a href="{{ route($modelName.'.index')}}" class="text-muted"> 
							{{ Config('constants.STAFFS.STAFFS_TITLE') }}
							</a>
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
			<div class="card card-custom gutter-b">
				<!--begin::Header-->
				<div class="card-header card-header-tabs-line">
					<div class="card-toolbar">
						<ul class="nav nav-tabs nav-tabs-space-lg nav-tabs-line nav-bold nav-tabs-line-3x"
							role="tablist">
							<li class="nav-item">
								<a class="nav-link active" data-toggle="tab"
									href="#kt_apps_contacts_view_tab_1">
									<span class="nav-text">
									{{ Config('constants.STAFFS.STAFF_TITLE') }} Details
									</span>
								</a>
							</li>
						</ul>
					</div>
				</div>
				<!--end::Header-->

				<!--begin::Body-->
				<div class="card-body px-0">
					<div class="tab-content px-10">
						<!--begin::Tab Content-->
						<div class="tab-pane active" id="kt_apps_contacts_view_tab_1" role="tabpanel">

					  @if(!empty($modelDetails->image))
						<div class="form-group row my-2">
								<label class="col-4 col-form-label"> Image:</label>
								<div class="col-8">
									<span class="form-control-plaintext font-weight-bolder">
									<a class="fancybox-buttons" data-fancybox-group="button" 
									href="{{ config('constants.STAFF_IMAGE_ROOT_URL').$modelDetails->image }}">
										<img height="70" width="100" src="{{ config('constants.STAFF_IMAGE_ROOT_URL').$modelDetails->image }}">
									</a>
								</span>  
							</div>
						</div>
						@endif 
							
							<div class="form-group row my-2">
								<label class="col-4 col-form-label">First Name:</label>
								<div class="col-8">
									<span class="form-control-plaintext font-weight-bolder">
										{{ $modelDetails->first_name ?? '' }}
									</span>
								</div>
							</div>

							<div class="form-group row my-2">
								<label class="col-4 col-form-label">Last Name:</label>
								<div class="col-8">
									<span class="form-control-plaintext font-weight-bolder">
										{{ $modelDetails->last_name ?? '' }}
									</span>
								</div>
							</div>

							<div class="form-group row my-2">
								<label class="col-4 col-form-label"> Email:</label>
								<div class="col-8">
									<span class="form-control-plaintext font-weight-bolder">
									{{ $modelDetails->email ?? '' }}
									</span>
								</div>
							</div>

							<div class="form-group row my-2">
								<label class="col-4 col-form-label"> Phone Number:</label>
								<div class="col-8">
									<span class="form-control-plaintext font-weight-bolder">
									{{ $modelDetails->phone_number ?? '' }}
									</span>
								</div>
							</div>

						

							<div class="form-group row my-2">
								<label class="col-4 col-form-label"> Description:</label>
								<div class="col-8">
									<span class="form-control-plaintext font-weight-bolder">
									{{ $modelDetails->description ?? '' }}
									</span>
								</div>
							</div>

							<div class="form-group row my-2">
								<label class="col-4 col-form-label"> Status:</label>
								<div class="col-8">
									<span class="form-control-plaintext font-weight-bolder">
									@if ($modelDetails->is_active == 1)
										<span class="label label-lg label-light-success label-inline">Activated</span>
										@else
										<span class="label label-lg label-light-danger label-inline">Deactivated</span>
									@endif
									</span>
								</div>
							</div>



							<div class="form-group row my-2">
								<label class="col-4 col-form-label"> Registered On:</label>
								<div class="col-8">
									<span class="form-control-plaintext font-weight-bolder">
									{{ $modelDetails->created_at ?? '' }}
									</span>
								</div>
							</div>
							
						</div>
						
						<!--end::Tab Content-->
					</div>
				</div>
				<!--end::Body-->
			</div>

		</div>
		<!--end::Container-->
	</div>
</div>
<!--end::Content-->
@stop
