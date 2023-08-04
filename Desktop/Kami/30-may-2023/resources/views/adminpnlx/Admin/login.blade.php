@extends('adminpnlx.layouts.login_layout')
@section('content')


<div class="d-flex flex-column">
    <div class="col-sm-4 offset-3 login-content d-flex flex-column card p-10">
        <a href="javascript:void(0);" class="login-logo pb-10 text-center">
            {{-- <img src="{{asset('public/adminpnlx/img/jeevan.png')}}" class="max-h-100px" /> --}}
        </a>

        <div class="login-form">
            <form method="post" action="{{ route('Admin.login') }}" class="form" id="kt_login_singin_form">
                @csrf

                <div class="mb-12 text-center">
                    <h3 class="font-weight-bold text-dark">Sign In</h3>
                    <p>Enter your details to login to your account:</p>
                </div>

                <!--begin::Form group-->
                <div class="form-group">
                    <label class="font-size-h6 font-weight-bolder text-dark">Your Email</label>
                    <input type="text" name="email" class="form-control form-control-solid h-auto py-5 px-6 rounded-lg border-0" placeholder="Email">
                    @if ($errors->has('email'))
                    <span class="error text-danger">{{ $errors->first('email') }}</span>
                    @endif
                </div>

                <!--begin::Form group-->
                <div class="form-group">
                    <div class="d-flex justify-content-between mt-n5">
                        <label class="font-size-h6 font-weight-bolder text-dark pt-5">Your Password</label>
                        <a href="{{route('Admin.forgetPassword')}}" class="text-primary font-size-h6 font-weight-bolder text-hover-primary pt-5">
                            Forgot Password ?
                        </a>
                    </div>
                    <input type="password" name="password" class="form-control form-control-solid h-auto py-5 px-6 rounded-lg border-0" placeholder="Password">

                    @if ($errors->has('password'))
                    <span class="error text-danger">{{ $errors->first('password') }}</span>
                    @endif
                </div>


                <div class="text-center">
                    <button button type="submit" class="btn btn-success font-weight-bold text-uppercase px-9 py-4">
                        Submit
                    </button>
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