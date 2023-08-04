@extends('adminpnlx.layouts.login_layout')
@section('content')


<div class="d-flex flex-column">
    <div class="col-sm-5 offset-3 login-content d-flex flex-column card p-10">
        <!-- <a href="javascript:void(0);" class="login-logo pb-10 text-center"> -->
            <!-- <img src="{{asset('public/adminpnlx/img/jeevan.png')}}" class="max-h-100px" /> -->
        <!-- </a> -->

        <div class="login-form">
            <form method="post" action="{{ route('UserSignup') }}" class="form" id="kt_login_singin_form">
                @csrf

                <div class="mb-12 text-center">
                    <h3 class="font-weight-bold text-dark">Sign In</h3>
                    <p>Enter your details to sign to your account:</p>
                </div>

                <!--begin::Form group-->
                <div class="form-group">
                    <label class="font-size-h6 font-weight-bolder text-dark"> First Name</label>
                    <input type="text" name="first_name" class="form-control form-control-solid h-auto py-5 px-6 rounded-lg border-0" placeholder="First Name">
                    @if ($errors->has('first_name'))
                    <span class="error text-danger">{{ $errors->first('first_name') }}</span>
                    @endif
                </div>

                  <!--begin::Form group-->
                <div class="form-group">
                    <label class="font-size-h6 font-weight-bolder text-dark"> Last Name</label>
                    <input type="text" name="last_name" class="form-control form-control-solid h-auto py-5 px-6 rounded-lg border-0" placeholder="Last Name">
                    @if ($errors->has('last_name'))
                    <span class="error text-danger">{{ $errors->first('last_name') }}</span>
                    @endif
                </div>

                 <!--begin::Form group-->
                <div class="form-group">
                    <label class="font-size-h6 font-weight-bolder text-dark"> Email</label>
                    <input type="text" name="email" class="form-control form-control-solid h-auto py-5 px-6 rounded-lg border-0" placeholder="Email">
                    @if ($errors->has('email'))
                    <span class="error text-danger">{{ $errors->first('email') }}</span>
                    @endif
                </div>

                 <!--begin::Form group-->
                <div class="form-group">
                    <label class="font-size-h6 font-weight-bolder text-dark"> Phone Number</label>
                    <input type="text" name="phone_number" class="form-control form-control-solid h-auto py-5 px-6 rounded-lg border-0" placeholder="Phone Number">
                    @if ($errors->has('phone_number'))
                    <span class="error text-danger">{{ $errors->first('phone_number') }}</span>
                    @endif
                </div>

                <!--begin::Form group-->
                <div class="form-group">
                        <label class="font-size-h6 font-weight-bolder text-dark pt-5"> Password</label>
                        <input type="password" name="password" class="form-control form-control-solid h-auto py-5 px-6 rounded-lg border-0" placeholder="Password">

                    @if ($errors->has('password'))
                    <span class="error text-danger">{{ $errors->first('password') }}</span>
                    @endif
                </div>

                <!--begin::Form group-->
                <div class="form-group">
                        <label class="font-size-h6 font-weight-bolder text-dark pt-5">Confirm Password</label>                        
                    <input type="password" name="confirm_password" class="form-control form-control-solid h-auto py-5 px-6 rounded-lg border-0" placeholder="Confirm Password">

                    @if ($errors->has('confirm_password'))
                    <span class="error text-danger">{{ $errors->first('confirm_password') }}</span>
                    @endif
                </div>


                <div class="text-center">
                    <button button type="submit" class="btn btn-primary font-weight-bold text-uppercase px-9 py-4 btn-block">
                        Sign Up
                    </button>
                   <a href="{{route('UserLogin')}}" id="kt_login_submit" class="btn font-weight-bold text-uppercase px-9 py-4 btn-block">
                   Already a member?  Login</a>
                </div>
            </form>
        </div>
    </div>
    <!--end::Main-->

    <script>
        jQuery(document).ready(function() {
            $('input').keypress(function(e) {
                if (e.which == 13) {
                    $("#kt_login_singin_form").submit();
                }
            });

            $("#kt_login_submit").click(function(e) {
                $("#kt_login_singin_form").submit();
            });
        });
    </script>

    @stop