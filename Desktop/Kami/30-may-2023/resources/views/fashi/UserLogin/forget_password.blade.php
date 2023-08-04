@extends('adminpnlx.layouts.login_layout')
@section('content')

<!--begin::Main-->
<div class="d-flex flex-column">
    <div class="col-sm-4 offset-3 login-content d-flex flex-column card p-5 p-md-10">
        <a href="" class="login-logo pb-8 text-center">
            <img src="{{asset('public/adminpnlx/img/jeevan.png')}}" class="max-h-80px" alt="" />
        </a>

        <div class="login-form">
            <!--begin::Form-->
            <form method="post" action="{{ route('UserLogin.forgetPassword') }}" class="form" id="kt_login_singin_form">
                @csrf

                <!--begin::Title-->
                <div class="mb-12 text-center">
                    <h3 class="font-weight-bold text-dark">Forget Password </h3>
                    <p>Enter your email to reset your password.</p>
                </div>

                <!--begin::Form group-->
                <div class="form-group">
                    <label class="font-size-h6 font-weight-bolder text-dark"> Your Email</label>
                    <input type="text" name="email"
                        class="form-control form-control-solid h-auto py-5 px-6 rounded-lg border-0"
                        placeholder="Email">
                    @if ($errors->has('email'))
                    <span class="error text-danger">{{ $errors->first('email') }}</span>
                    @endif
                </div>


                <div class="text-center">
                    <button type="submit" class="btn btn-primary font-weight-bold text-uppercase px-9 py-4 mx-5">
                        Submit
                    </button>
                    
                    <a href="{{route('UserLogin.login')}}" id="kt_login_submit" 
                    class="btn btn-primary font-weight-bolder font-size-h6 px-12 py-4 my-3">Back To Login</a>

                </div>
                
                <!--end::Action-->
            </form>
            <!--end::Form-->
        </div>
        <!--end::Signin-->
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