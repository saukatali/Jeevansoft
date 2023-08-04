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
                <form method="post" action='{{route("$modelName.store")}}' class="mws-form"
                    enctype="multipart/form-data">
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
                                        <label for="image">Image</label> <span class="text-danger"> * </span>
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
                                            value="{{old('first_name') }}">
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
                                            value="{{old('last_name') }}">
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
                                            value="{{old('email') }}">
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
                                            class="form-control form-control-solid form-control-lg" placeholder="Phone Number"
                                            value="{{old('phone_number') }}">
                                        @if ($errors->has('phone_number'))
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
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                            <option value="other">Other</option>
                                         </select>
                                            @if ($errors->has('gender'))
                                        <span class="error text-danger">{{ $errors->first('gender') }}</span>
                                        @endif
                                    </div>
                                </div>

                                 <!--begin::Input-->
                                 <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="password">Password</label> <span class="text-danger"> * </span>
                                        <input type="password" name="password"
                                            class="form-control form-control-solid form-control-lg" placeholder="password"
                                            value="{{old('password') }}">
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
                                            class="form-control form-control-solid form-control-lg" placeholder="Confirm Password"
                                            value="{{old('confirm_password') }}">
                                        @if ($errors->has('confirm_password'))
                                        <span class="error text-danger">{{ $errors->first('confirm_password') }}</span>
                                        @endif
                                    </div>
                                </div>
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




<script src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_KEY')}}&callback=initAutocomplete&libraries=places" defer></script>
<script>
    $(document).ready(function() {
        initialize();
    });

    var autocomplete;

    function initialize() {
        var options = {
            componentRestrictions: {
                country: "us"
            }
        };
        var acInputs = document.getElementsByClassName("autocomplete");
        for (var i = 0; i < acInputs.length; i++) {
            var autocomplete = new google.maps.places.Autocomplete(acInputs[i], options);
            autocomplete.inputId = acInputs[i].id;
            google.maps.event.addListener(autocomplete, 'place_changed', function() {
                var place = this.getPlace();
                var lat = place.geometry.location.lat();
                var lng = place.geometry.location.lng();
                $('.latitude_v').val(lat);
                $('.longitude_v').val(lng);
                var latlng = new google.maps.LatLng(lat, lng);
                var geocoder = geocoder = new google.maps.Geocoder();
                geocoder.geocode({
                    'latLng': latlng
                }, function(results, status) {
                    if (results[0]) {
                        console.log(results[0])
                        var addresss = results[0].formatted_address;
                        var pin = results[0].address_components[results[0].address_components.length - 1].long_name;
                        var country = results[0].address_components[results[0].address_components.length - 2].long_name;
                        var state = results[0].address_components[results[0].address_components.length - 3].long_name;
                        var city = results[0].address_components[results[0].address_components.length - 4].long_name;
                        $(".city_v").val(city);
                        $(".zipcode_v").val(pin);
                        $(".statecode_v").val(state);
                        $(".country_v").val(country);
                    }
                });
            });
        }
    }
</script>

    @stop