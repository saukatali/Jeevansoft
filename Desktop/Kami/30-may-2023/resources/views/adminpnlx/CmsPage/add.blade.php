@extends('adminpnlx.layouts.default')
@section('content')
<script src="ckeditor/ckeditor.js"></script>
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
						Add New  {{ Config('constants.CMS_PAGES.CMS_PAGE_TITLE') }} </h5>
					<!--end::Page Title-->

					<!--begin::Breadcrumb-->
					<ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
						<li class="breadcrumb-item">
							<a href="{{ route('dashboard')}}" class="text-muted">Dashboard</a>
						</li>
						<li class="breadcrumb-item">
							<a href="{{ route($modelName.'.index')}}" class="text-muted">
							 {{ Config('constants.CMS_PAGES.CMS_PAGE_TITLE') }}
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
			<form method="post" action='{{route("$modelName.store")}}' class="mws-form" enctype="multipart/form-data" autocomplete="off">
				@csrf
				<div class="card card-custom gutter-b">
					<div class="card-header card-header-tabs-line">
						<h3 class="card-title font-weight-bolder text-dark"> 
						 {{ Config('constants.CMS_PAGES.CMS_PAGE_TITLE') }} Information</h3>
					</div>

					<div class="card-body">
						<div class="row">
							<div class="col-xl-6">
								<div class="form-group">
									<lable for="page_name">Page Name</lable><span class="text-danger"> * </span>
									<input name="page_name" class="form-control form-control-solid form-control-lg @error('page_name') is-invalid @enderror" value="{{old('page_name')}}" />
									@if ($errors->has('page_name'))
									<div class="invalid-feedback">
										{{ $errors->first('page_name') }}
									</div>
									@endif
								</div>
							</div>
							<!--end::Input-->

						</div>

					</div>

				</div>

				<div class="card card-custom gutter-b">
					<div class="card-header card-header-tabs-line">
						<div class="card-toolbar border-top">
							<ul class="nav nav-tabs nav-bold nav-tabs-line">
								@if(!empty($languages))
								<?php $i = 1; ?>
								@foreach($languages as $language)
								<li class="nav-item">
									<a class="nav-link {{($i==$language_code)?'active':'' }}" data-toggle="tab" href="#{{$language->title}}">
										<span class="symbol symbol-20 mr-3">
											<img src="{{url (Config::get('constants.LANGUAGES_IMAGE_ROOT_URL').$language->image)}}" alt="">
										</span>
										<span class="nav-text">{{$language->title}}</span>
									</a>
								</li>
								<?php $i++; ?>
								@endforeach
								@endif
							</ul>
						</div>
					</div>

					<div class="card-body">
						<div class="tab-content">
							@if(!empty($languages))
							<?php $i = 1; ?>
							@foreach($languages as $language)
							<div class="tab-pane fade {{ ($i ==  $language_code )?'show active':'' }}" id="{{$language->title}}" role="tabpanel" aria-labelledby="{{$language->title}}">
								<div class="row">
									<div class="col-xl-12">
										<div class="row">
											
										<div class="col-xl-6">
												<div class="form-group">
													@if($i == 1)
													<lable for="{{$language->id}}.page_title">Page Title</lable><span class="text-danger"> * </span>
													<input name="data[{{$language->id}}][page_title]" class="form-control form-control-solid form-control-lg @error('page_title') is-invalid @enderror" value="{{ old('data.'.$language->id.'.page_title')}} ">
													@if ($errors->has('page_title'))
													<div class="invalid-feedback">
														{{ $errors->first('page_title') }}
													</div>
													@endif

													@else
													<lable for="{{$language->id}}.page_title">Page Title</lable><span class="text-danger"> </span>
													<input name="data[{{$language->id}}][page_title]" class="form-control form-control-solid form-control-lg @error('page_title') is-invalid @enderror">

													@endif
												</div>
											</div>


											<div class="col-xl-12">
												<div class="form-group">
													@if($i == 1)
													<lable for="{{$language->id}}.description">Description</lable><span class="text-danger"> </span>
													<textarea name="data[{{$language->id}}][description]" id="description_{{$language->id}}" class="form-control form-control-solid form-control-lg @error('description') is-invalid @enderror" rows="5"></textarea>
													@if ($errors->has('description'))
													<div class="invalid-feedback">
														{{ $errors->first('description') }}
													</div>
													@endif

													@else
													<lable for="{{$language->id}}.description">Description</lable><span class="text-danger"> </span>
													<textarea name="data[{{$language->id}}][description]" id="description_{{$language->id}}" class="form-control form-control-solid form-control-lg @error('description') is-invalid @enderror" rows="5"></textarea>
													@endif
												</div>
												  <script src="{{asset('/public/adminpnlx/js/ckeditor/ckeditor.js')}}"></script>
												  <script>
                                                    CKEDITOR.replace( <?php echo 'description_'.$language->id ?>, {
                                                        filebrowserUploadUrl: 'http://exbha.dev21.obtech.inet/base/uploder',
                                                        enterMode: CKEDITOR.ENTER_BR
                                                    });
                                                    CKEDITOR.config.allowedContent = true;
                                                </script>
											</div>

										</div>
									</div>
								</div>
							</div>
							<?php $i++; ?>
							@endforeach
							@endif
						</div>
						<div class="d-flex justify-content-between border-top mt-5 pt-10">
							<div>
								<button button type="submit" class="btn btn-success font-weight-bold text-uppercase px-9 py-4">
									Submit
								</button>
							</div>
						</div>
					</div>

				</div>


			</form>
		</div>
	</div>
</div>
@stop