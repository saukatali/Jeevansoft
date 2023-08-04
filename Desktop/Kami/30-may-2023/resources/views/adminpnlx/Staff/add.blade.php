@extends('adminpnlx.layouts.default')
@section('content')

    {{-- <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/6.4.1/css/intlTelInput.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/6.4.1/js/intlTelInput.min.js">
    </script> --}}


    <!--begin::Content-->
    <div class="content  d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="subheader py-2 py-lg-4  subheader-solid " id="kt_subheader">
            <div class=" container-fluid  d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <div class="d-flex align-items-center flex-wrap mr-1">
                    <div class="d-flex align-items-baseline flex-wrap mr-5">
                        <h5 class="text-dark font-weight-bold my-1 mr-5">
                            Add New
                        </h5>

                        <!--begin::Breadcrumb-->
                        <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}" class="text-muted">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route($modelName . '.index') }}" class="text-muted">
                                    {{ Config('constants.STAFFS.STAFFS_TITLE') }}
                                </a>
                            </li>
                        </ul>
                        <!--end::Breadcrumb-->
                    </div>
                </div>

                @include('adminpnlx.elements.quick_links')
            </div>
        </div>
        <!--end::Subheader-->

        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class=" container ">
                <form method="post" action='{{ route("$modelName.store") }}' class="mws-form"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="card card-custom gutter-b">
                        <div class="card-header card-header-tabs-line">
                            <h3 class="card-title font-weight-bolder text-dark">
                                {{ Config('constants.STAFFS.STAFF_TITLE') }} Information
                            </h3>
                        </div>

                        <div class="card-body">
                            <div class="row">
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


                                <!--begin::Input-->
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="first_name">First Name</label> <span class="text-danger"> * </span>
                                        <input type="text" name="first_name"
                                            class="form-control form-control-solid form-control-lg" placeholder="First Name"
                                            value="{{ old('first_name') }}">
                                        @if ($errors->has('first_name'))
                                            <span class="error text-danger">{{ $errors->first('first_name') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <!--begin::Input-->
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="last_name">Last Name</label> <span class="text-danger"> * </span>
                                        <input type="text" name="last_name"
                                            class="form-control form-control-solid form-control-lg" placeholder="Last Name"
                                            value="{{ old('last_name') }}">
                                        @if ($errors->has('last_name'))
                                            <span class="error text-danger">{{ $errors->first('last_name') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <!--begin::Input-->
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="email">Email</label> <span class="text-danger"> * </span>
                                        <input type="email" name="email"
                                            class="form-control form-control-solid form-control-lg" placeholder="Email"
                                            value="{{ old('email') }}">
                                        @if ($errors->has('email'))
                                            <span class="error text-danger">{{ $errors->first('email') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <!--begin::Input-->
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="number">Phone Number</label> <span class="text-danger"> * </span>
                                        <input type="number" name="phone_number"
                                            class="form-control form-control-solid form-control-lg"
                                            placeholder="Phone Number" value="{{ old('phone_number') }}">
                                        @if ($errors->has('phone_number'))
                                            <span class="error text-danger">{{ $errors->first('phone_number') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <!--begin::Input-->
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="password">Password</label> <span class="text-danger"> * </span>
                                        <input type="password" name="password"
                                            class="form-control form-control-solid form-control-lg" placeholder="password"
                                            value="{{ old('password') }}">
                                        @if ($errors->has('password'))
                                            <span class="error text-danger">{{ $errors->first('password') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <!--begin::Input-->
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="confirm_password">Confirm Password</label> <span class="text-danger"> * </span>
                                        <input type="password" name="confirm_password"
                                            class="form-control form-control-solid form-control-lg"
                                            placeholder="Confirm Password" value="{{ old('confirm_password') }}">
                                        @if ($errors->has('confirm_password'))
                                            <span class="error text-danger">{{ $errors->first('confirm_password') }}</span>
                                        @endif
                                    </div>
                                </div>

                            </div>

                            <hr>
                            <h3 class="p-5"> Department Information </h3>
                            <div class="row">
                                <!--begin::Input-->
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="department">Department</label> <span class="text-danger"> * </span>
                                        <select name="department" id="department"
                                            class="form-control form-control-solid form-control-lg">
                                            <option value="">Select Department</option>
                                            @if (!empty($departments))
                                                @foreach ($departments as $department)
                                                    <option value="{{ $department->id }}"> {{ $department->name ?? old('department') }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @if ($errors->has('department'))
                                            <span class="error text-danger">{{ $errors->first('department') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <!--begin::Input-->
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="designation">Designation</label> <span class="text-danger"> * </span>
                                        <select name="designation" id="all_designation" class="form-control form-control-solid form-control-lg">
                                            <option value="">Select Designation</option>
                                        </select>
                                        @if ($errors->has('designation'))
                                            <span class="error text-danger">{{ $errors->first('designation') }}</span>
                                        @endif
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="staffPermission"> </div>
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

    <script>
        $('#department').on("change", function() {
            var department_id = $(this).val();
            $.ajax({            
                type: 'POST',
                url: "{{ route('Staff.designation') }}",
                dataType: 'json',
                data: { 
                     _token  : $('meta[name="csrf-token"]').attr('content'),
                      dept_id : department_id 
                    }, 
                   success: function(response) {
                    console.log(response);
                    $("#all_designation").html(response);
                }
            });
        })


        $('#all_designation').on("change", function() {
            var designation_id = $(this).val();
            $.ajax({            
                type: 'POST',
                url: "{{ route('Staff.permission') }}",
                dataType: 'json',
                data: { 
                     _token  : $('meta[name="csrf-token"]').attr('content'),
                      desig_id : designation_id 
                    }, 
                   success: function(response) {
                    console.log(response);
                    $("#all_designation").html(response);
                }
            });
        })

    </script>


@stop
