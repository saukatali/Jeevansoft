@extends('adminpnlx.layouts.login_layout')
@section('content')


<div class="d-flex flex-column">
    <div class="col-sm-4 offset-3 login-content d-flex flex-column card p-20">
        <a href="javascript:void(0);" class="login-logo pb-10 text-center">
            {{-- <img src="{{asset('public/adminpnlx/img/jeevan.png')}}" class="max-h-100px" /> --}}
        </a>

        <div class="login-form">
            <form method="post" class="form" id="kt_login_form">
                @csrf

                <div class="mb-12 text-center">
                    <h3 class="font-weight-bold text-dark">Log In</h3>
                    <p>Enter your details to login to your account:</p>
                </div>

                <!--begin::Form group-->
                <div class="form-group">
                    <label class="font-size-h6 font-weight-bolder text-dark"> Email</label>
                    <input type="text" name="email" id="login_email" class="form-control form-control-solid h-auto py-5 px-6 rounded-lg border-0" placeholder="Email">
                    @if ($errors->has('email'))
                    <span class="error text-danger">{{ $errors->first('email') }}</span>
                    @endif
                </div>

                <!--begin::Form group-->
                <div class="form-group">
                    <div class="d-flex justify-content-between mt-n5">
                        <label class="font-size-h6 font-weight-bolder text-dark pt-5"> Password</label>
                        <a href="{{route('UserForgetPassword')}}" class="text-primary font-size-h6 font-weight-bolder text-hover-primary pt-5">
                            Forgot Password ?
                        </a>
                    </div> 
                    <input type="password" name="password" id="login_password" class="form-control form-control-solid h-auto py-5 px-6 rounded-lg border-0" placeholder="Password">

                    @if ($errors->has('password'))
                    <span class="error text-danger">{{ $errors->first('password') }}</span>
                    @endif
                </div>


                <div class="text-center">
                    <button type="button" id="kt_login_submit" class="btn btn-success font-weight-bold text-uppercase px-9 py-4 btn-block">
                        Login
                    </button>

                    <a href="{{route('UserSignup')}}" class="btn  font-weight-bold text-uppercase px-9 py-4 btn-block">
                        Not a member yet? Sign Up</a>
                </div>
            </form>
        </div>
    </div>
    <!--end::Main-->

    <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#loginOtpVerify">
  Launch demo modal
</button> -->

    <!-- Modal -->
    <div class="modal fade" id="loginOtpVerify" tabindex="-1" role="dialog" aria-labelledby="loginOtpVerifyTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginOtpVerifyTitle">Verify OTP</h5>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">X</button>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h4>Enter the code we've sent via email to <br> 
                    <span id="showEmail"></span></h4>
                    <form id="kt_otp_verify_form">
                        @csrf
                        <div class="verification-code--inputs">
                                <input type="text" maxlength="1" tabindex="1" class="otp__input"
                                    value="">
                                <input type="text" maxlength="1" tabindex="2" class="otp__input"
                                    value="">
                                <input type="text" maxlength="1" tabindex="3" class="otp__input"
                                    value="">
                                <input type="text" maxlength="1" tabindex="4" class="otp__input"
                                    value="">
                                <input type="text" maxlength="1" tabindex="5" class="otp__input"
                                    value="">
                                <input type="text" maxlength="1" tabindex="6" class="otp__input"
                                    value="">
                            </div>
                            <input type="hidden" type="user_id" name="user_id" class="user_id" id="user_id" value="" />
                            <!-- <input type="hidden" type="text" name="otp" id="otp__input" value="" /> -->
                            <input type="text" maxlength="6" class="form-control" name="otp" id="otp__input" value="" />

                            <style>
                            input.otp__input {
                                width: 60px;
                                height: 60px;
                                margin: 5px;
                                border: 1px solid #c5b8b8;
                                text-align: center;
                                font-size: 20px;
                            }
                            </style>

                        <a type="button" class="btn btn-success btn-block" id="kt_otp_verify_submit">Countiue</a>

                        <a href="#" class="btn text-center">Resend Otp</a>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script>
        $('#kt_login_submit').on('click', function() {
            let email = $('#login_email').val();
            let password = $('#login_password').val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{ route('UserLogin') }}",
                method: 'POST',
                data: {
                    '_token' : $('meta[name="csrf-token"]').attr('content'),
                    'email' : email,
                    'password' : password,
                },
                success: function(response) {
                    if(response.status == false){
                        if(response.show_verify==true){
                            $('#loginOtpVerify').modal('show');
                            $('#showEmail').html(response.user_email)
                            $('#user_id').val(response.user_id);
                        }
                    }else{
                        location.reload();
                    }                       
                },
            });

        });

        $('#kt_otp_verify_submit').on('click', function() {
            let user_otp = $('#otp__input').val();
            let user_id = $('#user_id').val();
            alert(user_otp);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{ route('verifyOtp') }}",
                method: 'POST',
                data: {
                    '_token' : $('meta[name="csrf-token"]').attr('content'),
                    'user_id' : user_id,
                    'user_otp' : user_otp,
                },
                success: function(response) {
                    console.log(response);
                        if(response.show_verify==true)
                        {
                            $('#loginOtpVerify').modal('show');
                            $('#showEmail').html(response.user_email);
                            $('#otp__input').val(response.user_id);
                            $('#otp__input').val(response.user_email);
                        }
                },
            });

        });
    </script>

    @stop