@extends('adminpnlx.layouts.default')
@section('content')

<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/6.4.1/css/intlTelInput.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/6.4.1/js/intlTelInput.min.js"></script>


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
                        <ul
                            class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard')}}" class="text-muted">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route($modelName.'.index')}}" class="text-muted">
                                {{ Config('constants.COUPONS.COUPON_TITLE') }}
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
                <form method="post" action='{{route("$modelName.store")}}' class="mws-form"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="card card-custom gutter-b">
                        <div class="card-header card-header-tabs-line">
                            <h3 class="card-title font-weight-bolder text-dark">
                            {{ Config('constants.COUPONS.COUPON_TITLE') }} Information
                            </h3>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <!--begin::Input-->
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="image">Image</label> <span class="text-danger">  </span>
                                        <input type="file" name="image"
                                            class="form-control form-control-solid form-control-lg">
                                        <div class="invalid-feedback"></div>
                                        @if ($errors->has('image'))
                                        <span class="error text-danger">{{ $errors->first('image') }}</span>
                                        @endif
                                    </div>
                                </div>
                              

                                <!--begin::Input-->
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="name"> Name </label> <span class="text-danger"> * </span>
                                        <input type="text" name="name"
                                            class="form-control form-control-solid form-control-lg" placeholder="Name"
                                            value="{{old('name') }}">
                                        @if ($errors->has('name'))
                                        <span class="error text-danger">{{ $errors->first('name') }}</span>
                                        @endif
                                    </div>
                                </div>

                                 <!--begin::Input-->
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="offer_code"> Offer Code </label> <span class="text-danger"> * </span>
                                        <input type="text" name="offer_code"
                                            class="form-control form-control-solid form-control-lg" placeholder="Offer Code"
                                            value="{{old('offer_code') }}">
                                        @if ($errors->has('offer_code'))
                                        <span class="error text-danger"> {{ $errors->first('offer_code') }} </span>
                                        @endif
                                    </div>
                                </div>

                                <!--begin::Input-->
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="type"> Coupon Type </label> <span class="text-danger"> * </span>
                                            <select name="type" class="form-control form-control-solid form-control-lg">
                                                <option value="">Select Coupon Type</option>
                                                <option value="percentage">percentage</option>
                                                <option value="fixed">fixed</option>
                                            </select>
                                        @if ($errors->has('type'))
                                        <span class="error text-danger">{{ $errors->first('type') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <!--begin::Input-->
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="count"> Count </label> <span class="text-danger"> * </span>
                                        <input type="number" name="count"
                                            class="form-control form-control-solid form-control-lg" placeholder="Count"
                                            value="{{old('count') }}">
                                        @if ($errors->has('count'))
                                        <span class="error text-danger">{{ $errors->first('count') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <!--begin::Input-->
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="start_date">Start Date</label> <span class="text-danger"> * </span>
                                        <input type="date" name="start_date"
                                            class="form-control form-control-solid form-control-lg" placeholder="Start Date"
                                            value="{{old('start_date') }}">
                                        @if ($errors->has('start_date'))
                                        <span class="error text-danger">{{ $errors->first('start_date') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <!--begin::Input-->
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="end_date">End Date</label> <span class="text-danger"> * </span>
                                        <input type="date" name="end_date"
                                            class="form-control form-control-solid form-control-lg" placeholder="End Date"
                                            value="{{old('end_date') }}">
                                        @if ($errors->has('end_date'))
                                        <span class="error text-danger">{{ $errors->first('end_date') }}</span>
                                        @endif
                                    </div>
                                </div>

                               
                                <!--begin::Input-->
                                <div class="col-xl-12">
                                    <div class="form-group">
                                        <label for="description">Description</label> <span class="text-danger"> </span>
                                        <br>
                                        <textarea type="text" name="description" id="description"
                                            class="form-control form-control-solid form-control-lg"
                                            placeholder="description">{{old('description')}}</textarea>
                                        @if ($errors->has('description'))
                                        <span class="error text-danger">{{ $errors->first('description') }}</span>
                                        @endif
                                    </div>
                                    <!-- <script src="{{asset('/public/adminpnlx/js/ckeditor/ckeditor.js')}}"></script> -->
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