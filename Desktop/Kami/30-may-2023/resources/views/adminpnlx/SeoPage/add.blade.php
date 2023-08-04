@extends('adminpnlx.layouts.default')
@section('content')

    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/6.4.1/css/intlTelInput.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/6.4.1/js/intlTelInput.min.js">
    </script>


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
                            Add New
                        </h5>
                        <!--end::Page Title-->

                        <!--begin::Breadcrumb-->
                        <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}" class="text-muted">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route($modelName . '.index') }}" class="text-muted">
                                    {{ Config('constants.SEO_PAGES.SEO_PAGE_TITLE') }}
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
                <form method="post" action='{{ route("$modelName.store") }}' class="mws-form"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="card card-custom gutter-b">
                        <div class="card-header card-header-tabs-line">
                            <h3 class="card-title font-weight-bolder text-dark">
                                {{ Config('constants.SEO_PAGES.SEO_PAGE_TITLE') }} Information
                            </h3>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <!--begin::Input-->
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="page_id">Page ID</label> <span class="text-danger"> * </span>
                                        <input type="text" name="page_id"
                                            class="form-control form-control-solid form-control-lg" placeholder="Page ID"
                                            value="{{ old('page_id') }}">
                                        @if ($errors->has('page_id'))
                                            <span class="error text-danger">{{ $errors->first('page_id') }}</span>
                                        @endif
                                    </div>
                                </div>


                                <!--begin::Input-->
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="page_name">Page Name</label> <span class="text-danger"> * </span>
                                        <input type="text" name="page_name"
                                            class="form-control form-control-solid form-control-lg" placeholder="Page Name"
                                            value="{{ old('page_name') }}">
                                        @if ($errors->has('page_name'))
                                            <span class="error text-danger">{{ $errors->first('page_name') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <!--begin::Input-->
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="meta_title">Meta Title</label> <span class="text-danger"> * </span>
                                        <input type="text" name="meta_title"
                                            class="form-control form-control-solid form-control-lg" placeholder="meta_title"
                                            value="{{ old('meta_title') }}">
                                        @if ($errors->has('meta_title'))
                                            <span class="error text-danger">{{ $errors->first('meta_title') }}</span>
                                        @endif
                                    </div>
                                </div>


                                <!--begin::Input-->
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="meta_description">Meta Description</label> <span class="text-danger">
                                        </span>
                                        <br>
                                        <textarea type="text" name="meta_description" id="meta_description"
                                            class="form-control form-control-solid form-control-lg" placeholder="Meta Description">{{ old('meta_description') }}</textarea>
                                        @if ($errors->has('meta_description'))
                                            <span class="error text-danger">{{ $errors->first('meta_description') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <!--begin::Input-->
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="meta_keywords">Meta Keywords</label> <span class="text-danger"> </span>
                                        <br>
                                        <textarea type="text" name="meta_keywords" id="meta_keywords" class="form-control form-control-solid form-control-lg"
                                            placeholder="Meta Keywords">{{ old('meta_keywords') }}</textarea>
                                        @if ($errors->has('meta_keywords'))
                                            <span class="error text-danger">{{ $errors->first('meta_keywords') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <!--begin::Input-->
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="twitter_card">Twitter Card</label> <span class="text-danger"> </span>
                                        <br>
                                        <textarea type="text" name="twitter_card" id="twitter_card" class="form-control form-control-solid form-control-lg"
                                            placeholder="Twitter Card">{{ old('twitter_card') }}</textarea>
                                        @if ($errors->has('twitter_card'))
                                            <span class="error text-danger">{{ $errors->first('twitter_card') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <!--begin::Input-->
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="twitter_site">Twitter Site</label> <span class="text-danger"> </span>
                                        <br>
                                        <textarea type="text" name="twitter_site" id="twitter_site" class="form-control form-control-solid form-control-lg"
                                            placeholder="Twitter Site">{{ old('twitter_site') }}</textarea>
                                        @if ($errors->has('twitter_site'))
                                            <span class="error text-danger">{{ $errors->first('twitter_site') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <!--begin::Input-->
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="og_url">Og Url</label> <span class="text-danger"> </span>
                                        <br>
                                        <textarea type="text" name="og_url" id="og_url" class="form-control form-control-solid form-control-lg"
                                            placeholder="Og Url">{{ old('og_url') }}</textarea>
                                        @if ($errors->has('og_url'))
                                            <span class="error text-danger">{{ $errors->first('og_url') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <!--begin::Input-->
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="og_type">Og Type</label> <span class="text-danger"> </span>
                                        <br>
                                        <textarea type="text" name="og_type" id="og_type" class="form-control form-control-solid form-control-lg"
                                            placeholder="Og Type">{{ old('og_type') }}</textarea>
                                        @if ($errors->has('og_type'))
                                            <span class="error text-danger">{{ $errors->first('og_type') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <!--begin::Input-->
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="og_title">Og Title</label> <span class="text-danger"> </span>
                                        <br>
                                        <textarea type="text" name="og_title" id="og_title" class="form-control form-control-solid form-control-lg"
                                            placeholder="Og Title">{{ old('og_title') }}</textarea>
                                        @if ($errors->has('og_title'))
                                            <span class="error text-danger">{{ $errors->first('og_title') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <!--begin::Input-->
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="og_description">Og Description</label> <span class="text-danger">
                                        </span>
                                        <br>
                                        <textarea type="text" name="og_description" id="og_description"
                                            class="form-control form-control-solid form-control-lg" placeholder="Og Description">{{ old('og_description') }}</textarea>
                                        @if ($errors->has('og_description'))
                                            <span class="error text-danger">{{ $errors->first('og_description') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <!--begin::Input-->
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="meta_chronicles">Meta Chronicles</label> <span class="text-danger">
                                        </span>
                                        <br>
                                        <textarea type="text" name="meta_chronicles" id="meta_chronicles"
                                            class="form-control form-control-solid form-control-lg" placeholder="Meta Chronicles">{{ old('meta_chronicles') }}</textarea>
                                        @if ($errors->has('meta_chronicles'))
                                            <span class="error text-danger">{{ $errors->first('meta_chronicles') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <!--begin::Input-->
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="image">Image</label> <span class="text-danger"> </span>
                                        <input type="file" name="image"
                                            class="form-control form-control-solid form-control-lg">
                                        <div class="invalid-feedback"></div>
                                        @if ($errors->has('image'))
                                            <span class="error text-danger">{{ $errors->first('image') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between border-top mt-5 pt-10">
                                <div>
                                    <button button type="submit"
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
