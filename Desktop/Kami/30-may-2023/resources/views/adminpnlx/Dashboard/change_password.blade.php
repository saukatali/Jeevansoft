@extends('adminpnlx.layouts.default')
@section('content')

    <!--begin::Content-->
    <div class="content  d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Subheader-->
        <div class="subheader py-2 py-lg-4  subheader-solid " id="kt_subheader">
            <div class=" container-fluid  d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <div class="d-flex align-items-center flex-wrap mr-1">
                    <div class="d-flex align-items-baseline flex-wrap mr-5">
                        <h5 class="text-dark font-weight-bold my-1 mr-5">
                            Change Password
                        </h5>

                        <ul
                            class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard')}}" class="text-muted">Dashboard</a>
                            </li>
                        </ul>
                    </div>
                </div>

                @include("adminpnlx.elements.quick_links")
            </div>
        </div>
        <!--end::Subheader-->

        <!--begin::Entry-->
        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class="container ">
                <form method="post" action='{{route("Admin.changePassword")}}' class="mws-form"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="card card-custom gutter-b">
                        <div class="card-body">
                            <div class="row">                          

                                 <!--begin::Input-->
                                 <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="old_password">Old Password</label> <span class="text-danger"> * </span>
                                        <input type="password" name="old_password"
                                            class="form-control form-control-solid form-control-lg" placeholder="New Password"
                                            value="{{old('old_password') }}">
                                        @if ($errors->has('old_password'))
                                        <span class="error text-danger">{{ $errors->first('old_password') }}</span>
                                        @endif
                                    </div>
                                </div>

                                 <!--begin::Input-->
                                 <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="new_password">Password</label> <span class="text-danger"> * </span>
                                        <input type="password" name="new_password"
                                            class="form-control form-control-solid form-control-lg" placeholder="New Password"
                                            value="{{old('new_password') }}">
                                        @if ($errors->has('new_password'))
                                        <span class="error text-danger">{{ $errors->first('new_password') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <!--begin::Input-->
                                 <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="confirm_password">Confirm Password</label> <span class="text-danger"> * </span>
                                        <input type="password" name="confirm_password"
                                            class="form-control form-control-solid form-control-lg" placeholder="Confirm Password"
                                            value="{{old('confirm_password') }}">
                                        @if ($errors->has('confirm_password'))
                                        <span class="error text-danger">{{ $errors->first('confirm_password') }}</span>
                                        @endif
                                    </div>
                                </div>
                              
                            </div>

                            <div class="d-flex justify-content-between border-top mt-5 pt-10">
                                    <button button type="submit"
                                        class="btn btn-success font-weight-bold text-uppercase px-9 py-4">
                                        Submit
                                    </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    @stop