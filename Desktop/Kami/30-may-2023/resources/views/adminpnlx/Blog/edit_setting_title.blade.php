@extends('adminpnlx.layouts.default')
@section('content')

    <!--begin::Content-->
    <script src="public/js/ckeditor/ckeditor.js"></script>
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
                            Edit {{ Config('constants.BLOGS.BLOG_TITLE') }} </h5>
                        <!--end::Page Title-->

                        <!--begin::Breadcrumb-->
                        <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}" class="text-muted">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route($modelName . '.index') }}" class="text-muted">
                                    {{ Config('constants.BLOGS.BLOGS_TITLE') }}
                                </a>
                            </li>
                        </ul>
                        <!--end::Breadcrumb-->
                    </div>
                    <!--end::Page Heading-->
                </div>
                <!--end::Info-->

                @include('adminpnlx.elements.quick_links')
            </div>
        </div>
        <!--end::Subheader-->

        <!--begin::Entry-->
        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class=" container ">
                <form method="post" action="{{ route($modelName . '.edit_setting_title')}}" class="mws-form" enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    <div class="card card-custom gutter-b">
                        <div class="card-header card-header-tabs-line">
                            <h3 class="card-title font-weight-bolder text-dark">
                                {{ Config('constants.BLOGS.BLOG_TITLE') }} Information
                            </h3>
                        </div>

                        <div class="card-body">
                            <div class="row">
                            <!--begin::Input-->
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="heading"> Heading</label> <span class="text-danger"> * </span>
                                        <input type="text" name="heading"
                                            class="form-control form-control-solid form-control-lg" placeholder="Heading"
                                            value="{{ $modelDetails->heading ?? old('heading') }}">
                                        @if ($errors->has('heading'))
                                            <span class="error text-danger">{{ $errors->first('heading') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <!--begin::Input-->
							<div class="col-xl-6">
								<div class="form-group">
									<label for="is_enable">Status</label> <span class="text-danger"> </span>
									<select name="is_enable" class="form-control form-control-solid form-control-lg">
										<option value="1" {{ $modelDetails->is_enable == 1 ? 'Selected' : ''}}>Enable</option>
										<option value="0" {{ $modelDetails->is_enable == 0 ? 'Selected' : ''}}>Disable</option>
									</select>
									<div class="invalid-feedback"></div>
								</div>
							</div>

                                <!--begin::Input-->
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="title"> Title</label> <span class="text-danger"> * </span>
                                        <input type="text" name="title"
                                            class="form-control form-control-solid form-control-lg" placeholder="Title"
                                            value="{{ $modelDetails->title ?? old('title') }}">
                                        @if ($errors->has('title'))
                                            <span class="error text-danger">{{ $errors->first('title') }}</span>
                                        @endif
                                    </div>
                                </div>


                                <!--begin::Input-->
                                <div class="col-xl-12">
                                    <div class="form-group">
                                        <label for="description">Description</label> <span class="text-danger"> </span>
                                        <br>
                                        <textarea type="text" name="description" id="description" class="form-control form-control-solid form-control-lg"
                                            placeholder="description">{{ isset($modelDetails->description) ? $modelDetails->description : '' }}</textarea>
                                        @if ($errors->has('description'))
                                            <span class="error text-danger">{{ $errors->first('description') }}</span>
                                        @endif
                                    </div>
                                    <script>
                                        CKEDITOR.replace(description, {
                                            filebrowserUploadUrl: 'http://exbha.dev21.obtech.inet/base/uploder',
                                            enterMode: CKEDITOR.ENTER_BR
                                        });
                                        CKEDITOR.config.allowedContent = true;
                                    </script>

                                </div>


                            </div>

                            <div class="d-flex justify-content-between border-top mt-5 pt-10">

                                <div>
                                    <button type="submit"
                                        class="btn btn-success font-weight-bold text-uppercase px-9 py-4">
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
