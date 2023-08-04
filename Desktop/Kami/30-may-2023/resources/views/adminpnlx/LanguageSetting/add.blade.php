@extends('adminpnlx.layouts.default')
@section('content')
<!--begin::Content-->
<div class="content  d-flex flex-column flex-column-fluid" id="kt_content">
	<!--begin::Subheader-->
	<div class="subheader py-2 py-lg-4  subheader-solid " id="kt_subheader">
		<div class=" container-fluid  d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
			<!--begin::Info-->
			<div class="d-flex align-items-center flex-wrap mr-1">
				<!--begin::Page Heading-->
				<div class="d-flex align-items-baseline flex-wrap mr-5">
					<!--begin::Page Title-->
					<h5 class="text-dark font-weight-bold my-1 mr-5">
						Add New Word </h5>
					<!--end::Page Title-->

					<!--begin::Breadcrumb-->
					<ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
						<li class="breadcrumb-item">
							<a href="{{ route('dashboard')}}" class="text-muted">Dashboard</a>
						</li>
						<li class="breadcrumb-item">
							<a href="{{route('LanguageSetting.index')}}" class="text-muted">
							{{ Config('constants.LANGUAGES.LANGUAGE_TITLE') }}
							</a>
						</li>
					</ul>
					<!--end::Breadcrumb-->
				</div>
			</div>

			@include("adminpnlx.elements.quick_links")
		</div>
	</div>
	<!--end::Subheader-->

	<!--begin::Entry-->
	<div class="d-flex flex-column-fluid">
		<!--begin::Container-->
		<div class=" container ">
			<form action="{{route('LanguageSetting.store')}}" method="post" class="mws-form">
				@csrf
				<div class="card">
					<div class="card-body">
						<div class="row">
							<div class="col-xl-1"></div>
							<div class="col-xl-10">
								<h3 class="mb-10 font-weight-bold text-dark">
								</h3>

								<div class="row">
									<div class="col-xl-6">
										<div class="form-group">
											<label for="default"> Default </label> <span class="text-danger"> * </span>
											<input type="text" name="default" class="form-control form-control-solid form-control-lg ">
											@if ($errors->has('default'))
											<span class="error text-danger">{{ $errors->first('default') }}</span>
											@endif
										</div>
									</div>


									@if(!empty($languages))
									@foreach($languages as $key => $val)
									<div class="col-xl-6">
										<div class="form-group"> 
											<label for="code">{{$val->title}}</label> 
											<input type="text" name="language[{{$val->lang_code}}]" class="form-control form-control-solid form-control-lg ">
											<div class="invalid-feedback"><?php echo $errors->first('code'); ?></div>
										</div>
									</div>
									@endforeach
									@endif

								</div>
								<div class="d-flex justify-content-left">
									<div class="mx-3">
										<a href="{{route('LanguageSetting.create')}}" class="btn btn-danger font-weight-bold text-uppercase px-9 py-4">{{ trans('Reset') }}</a>

									</div>
									<div>
										<button button type="submit" class="btn btn-success font-weight-bold text-uppercase px-9 py-4">
											Submit
										</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
@stop