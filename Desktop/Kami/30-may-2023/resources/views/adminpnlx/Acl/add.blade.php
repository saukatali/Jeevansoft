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
                                {{ Config('constants.ACLS.ACLS_TITLE') }}
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
                            {{ Config('constants.ACLS.ACLS_TITLE') }} Information
                            </h3>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <!--begin::Input-->
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="parent_id">Select Parent</label> <span class="text-danger"> </span>
                                        <select name="parent_id" class="form-control form-control-solid form-control-lg">
                                       	<option value="">Select Parent</option>
                                       	@if(!empty($parent_list))
                                       	@foreach($parent_list as $parent)
                                       	<option value="{{ $parent->id }}"> {{ $parent->title }} </option>
                                       	@endforeach
                                       	@endif
                                       </select>
                                        @if ($errors->has('parent_id'))
                                        <span class="error text-danger">{{ $errors->first('parent_id') }}</span>
                                        @endif
                                    </div>
                                </div>
                              

                                <!--begin::Input-->
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="title">Title</label> <span class="text-danger"> * </span>
                                        <input type="text" name="title"
                                            class="form-control form-control-solid form-control-lg" placeholder="Title"
                                            value="{{old('title') }}">
                                        @if ($errors->has('title'))
                                        <span class="error text-danger">{{ $errors->first('title') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <!--begin::Input-->
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="path">Path</label> <span class="text-danger"> * </span>
                                        <input type="text" name="path"
                                            class="form-control form-control-solid form-control-lg" placeholder="Path"
                                            value="{{old('path') }}">
                                           <span>Without Plugin URL: javascript::void(); </span> <br>
                                        @if ($errors->has('path'))
                                        <span class="error text-danger">{{ $errors->first('path') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <!--begin::Input-->
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="order">Order</label> <span class="text-danger"> * </span>
                                        <input type="number" name="module_order"
                                            class="form-control form-control-solid form-control-lg" placeholder="Order"
                                            value="{{old('module_order') }}">
                                        @if ($errors->has('module_order'))
                                        <span class="error text-danger">{{ $errors->first('module_order') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <!--begin::Input-->
                                <div class="col-xl-12">
                                    <div class="form-group">
                                        <label for="icon">Icon</label> <span class="text-danger"> </span>
                                        <textarea name="icon" class="form-control form-control-solid form-control-lg" rows="5" placeholder="Icon">{{old('icon') }}</textarea>
                                        @if ($errors->has('icon'))
                                        <span class="error text-danger">{{ $errors->first('icon') }}</span>
                                        @endif
                                    </div>
                                </div>

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