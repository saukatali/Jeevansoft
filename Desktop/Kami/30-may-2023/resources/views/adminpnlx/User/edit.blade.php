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
                        Edit {{ Config('constants.USERS.USER_TITLE') }} </h5>
                    <!--end::Page Title-->

                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard')}}" class="text-muted">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route($modelName.'.index')}}" class="text-muted">
                            {{ Config('constants.USERS.USERS_TITLE') }}
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
            <form method="post" action="{{route($modelName.'.update', base64_encode($modelDetails->id))}}"
                class="mws-form" enctype="multipart/form-data" autocomplete="off">
                @csrf
                <div class="card card-custom gutter-b">
                    <div class="card-header card-header-tabs-line">
                        <h3 class="card-title font-weight-bolder text-dark">
                        {{ Config('constants.USERS.USER_TITLE') }} Information
                        </h3>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <!--begin::Input-->
                            <div class="col-xl-6">
                                <div class="form-group">
                                    <label for="">Image </label> <span class="text-danger"> </span>
                                    <input type="file" name="image"
                                        value="{{ isset($modelDetails->image) ? $modelDetails->image :'' }}"
                                        class="form-control form-control-solid form-control-lg">
                                    @if(!empty($modelDetails->image))
                                    <div class="banner-image">
                                        <img height="70" width="100" src="{{ config('constants.USER_IMAGE_ROOT_URL').$modelDetails->image }}" />
                                        <a href='{{ route("$modelName.deleteImage", base64_encode($modelDetails->id)) }}' class="btn btn-icon btn-light btn-hover-danger btn-sm confirmDeleteImage"
                                            data-toggle="tooltip" data-placement="top" data-container="body" data-boundary="window" title="" data-original-title="Delete Image">
                                            <span class="svg-icon svg-icon-md svg-icon-danger">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                    height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24" />
                                                        <path
                                                            d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z"
                                                            fill="#000000" fill-rule="nonzero" />
                                                        <path
                                                            d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z"
                                                            fill="#000000" opacity="0.3" />
                                                    </g>
                                                </svg>
                                            </span>
                                        </a>
                                    </div>
                                    @endif
                                </div>
                            </div>

                             <!--begin::Input-->
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="first_name">First Name</label> <span class="text-danger"> * </span>
                                        <input type="text" name="first_name"
                                            class="form-control form-control-solid form-control-lg" placeholder="First Name"
                                            value="{{$modelDetails->first_name ?? old('first_name') }}">
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
                                            value="{{ $modelDetails->last_name ?? old('last_name') }}">
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
                                            value="{{$modelDetails->email ?? old('email') }}">
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
                                            class="form-control form-control-solid form-control-lg" placeholder="phone_number"
                                            value="{{$modelDetails->phone_number ?? old('phone_number') }}">
                                        @if ($errors->has('quantity'))
                                        <span class="error text-danger">{{ $errors->first('phone_number') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <!--begin::Input-->
                                <div class="col-xl-6">
                                    <div class="form-group"> 
                                        <label for="gender">Gender</label> <span class="text-danger"> * </span>
                                        <select name="gender" class="form-control form-control-solid form-control-lg">
                                            <option value="">Select Gender</option>
                                            <option value="male" {{$modelDetails->gender == 'male' ? 'selected' : '' }}>Male</option>
                                            <option value="female" {{$modelDetails->gender == 'female' ? 'selected' : '' }}>Female</option>
                                            <option value="other" {{$modelDetails->gender == 'other' ? 'selected' : '' }}>Other</option>
                                         </select>
                                            @if ($errors->has('gender'))
                                        <span class="error text-danger">{{ $errors->first('gender') }}</span>
                                        @endif
                                    </div>
                                </div>

                                 
                            <!--begin::Input-->
                            <!-- <div class="col-xl-12">
                                <div class="form-group">
                                    <label for="description">Description</label> <span class="text-danger"> </span>
                                    <textarea type="description" name="description" id="description"
                                        class="form-control form-control-solid form-control-lg" rows="5"
                                        placeholder="description">{{$modelDetails->description ?? old('description') }}</textarea>
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
                            </div> -->

                        </div>

                        <hr>
                                <h3>General Information</h3>
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label for="address"> Address </label><span class="text-danger"> * </span>
                                            <input type="text" name="address" class="form-control form-control-solid form-control-lg autocomplete @error('address') is-invalid @enderror" value="{{old('address')}}">
                                            @if ($errors->has('address'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('address') }}
                                            </div>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- <div class="col-xl-6">
                                        <div class="form-group">
                                            <label for="city"> City </label><span class="text-danger"> </span>
                                            <input type="text" name="city" class="form-control form-control-solid form-control-lg city_v @error('city') is-invalid @enderror" value="{{old('city')}}">
                                            @if ($errors->has('city'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('city') }}
                                            </div>
                                            @endif
                                        </div>
                                    </div> -->


                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label>State</label><span class="text-danger"> * </span>
                                            <select name="state" id="get_state" class="form-control form-control-solid form-control-lg statecode_v @error('state') is-invalid @enderror">
                                                <option value="">Select State </option>
                                                @if(isset($states ))
                                                @foreach($states as $state)
                                                <option value="{{$state->id}}">{{$state->state}}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                            @if ($errors->has('state'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('state') }}
                                            </div>
                                            @endif
                                        </div>
                                    </div>


                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label for="country"> Country </label><span class="text-danger"> * </span>
                                            <input type="text" name="country" class="form-control form-control-solid form-control-lg country_v @error('country') is-invalid @enderror" value="{{old('country')}}">
                                            @if ($errors->has('country'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('country') }}
                                            </div>
                                            @endif
                                        </div>
                                    </div>



                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label for="zip_code"> Zip Code </label><span class="text-danger"> </span>
                                            <input type="number" name="zip_code" class="form-control form-control-solid form-control-lg zipcode_v @error('zip_code') is-invalid @enderror" value="{{old('zip_code')}}">
                                            @if ($errors->has('zip_code'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('zip_code') }}
                                            </div>
                                            @endif
                                        </div>
                                    </div>

                                    


                                    <input type="hidden" name="latitude" class="form-control latitude_v" value="{{old('latitude')}}">
                                    <input type="hidden" name="longitude" class="form-contro longitude_v" value="{{old('longitude')}}">
                                </div>

                        <div class="d-flex justify-content-between border-top mt-5 pt-10">

                            <div>
                                <button type="submit" class="btn btn-success font-weight-bold text-uppercase px-9 py-4">
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