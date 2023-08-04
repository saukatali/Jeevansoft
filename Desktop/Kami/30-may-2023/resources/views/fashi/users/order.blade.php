@extends('frontEnd.layouts.master')
@section('title', 'Checkout Page')
@section('content')



    </head>

    <body class="js">

        <!-- Preloader -->
        <div class="preloader">
            <div class="preloader-inner">
                <div class="preloader-icon">
                    <span></span>
                    <span></span>
                </div>
            </div>
        </div>
        <!-- End Preloader -->

        <!-- Breadcrumbs -->
        <div class="breadcrumbs">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="bread-inner">
                            <ul class="bread-list">
                                <li><a href="{{ route('dashboard') }}">Home<i class="ti-arrow-right"></i></a></li>
                                <li class="active"><a href="{{ route('checkout') }}">Checkout</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Breadcrumbs -->

        <!-- Start Checkout -->
        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $message }}</strong>
            </div>
        @endif
        @if ($message = Session::get('error'))
            <div class="alert alert-danger alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $message }}</strong>
            </div>
        @endif
        <h4> SHIPPING ADDRESS</h2>
        <section class="shop checkout section">
            <div class="container">
                <div class="row">

                    <div class="col-lg-8 col-12">
                        <div class="checkout-form">
                            <form class="form" method="post" action="{{ route('order-submit') }}"
                            enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" >
                       
                             <div class="row">
                                 @foreach ($user_address as  $user)

                                        <div class="col-md-6">
                                              <input type="radio" value="{{$user->id}}" name="add_id" id="hide" style="padding: 5px;"> Address  
                                                <br>
                                         <div style="border: 1px solid;">
                                            <p style="padding: 8px;">{{ $user->address }}, {{ $user->city }}, {{ $user->state }}, {{ $user->pincode }}</p>   
                                            </div>
                                            </div>
                                 @endforeach
                              </div>

                              <div class="row">
                                <div class="col-md-12">
                                     <input type="radio" checked="checked"  name="add_id" value="0" id="show" style="padding: 5px;"> New Address 
                                </div>
                              </div>
                           
                                <hr>
                          
                            <p></p>
                            <!-- Form -->
                            
                                <div class="row" id="address_form">
                                    <div class="col-lg-6 col-md-6 col-12">
                                        <div class="form-group">
                                            <label>First Name<span>*</span></label>
                                            <input type="text" name="name"
                                                class="@error('name') is-invalid @enderror">
                                            @if ($errors->has('name'))
                                                <span class="text-danger">{{ $errors->first('name') }}</span>
                                            @endif
                                        </div>
                                    </div>


                                    <div class="col-lg-6 col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Last Name<span>*</span></label>
                                            <input type="text" name="last_name" placeholder=""
                                                class="@error('last_name') is-invalid @enderror">
                                            @if ($errors->has('last_name'))
                                                <span class="text-danger">{{ $errors->first('last_name') }}</span>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Email Address<span>*</span></label>
                                            <input type="email" name="email" placeholder=""
                                                class="@error('email') is-invalid @enderror">
                                            @if ($errors->has('email'))
                                                <span class="text-danger">{{ $errors->first('email') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Phone Number<span>*</span></label>
                                            <input type="number" name="number" placeholder=""
                                                class="@error('number') is-invalid @enderror" id='yes'>
                                            @if ($errors->has('number'))
                                                <span class="text-danger">{{ $errors->first('number') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Country<span>*</span></label>
                                            <select name="country" id="country" class="form-control"
                                                class="@error('country') is-invalid @enderror">
                                                @if ($errors->has('country'))
                                                    <span class="text-danger">{{ $errors->first('country') }}</span>
                                                @endif
                                                @php $country =DB::table('countries')->get(); @endphp
                                                @foreach ($country as $countrys)
                                                    <option value="{{ $countrys->country_name }}">{{ $countrys->country_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-12">
                                        <div class="form-group">
                                            <label>State / Divition<span>*</span></label>
                                            <select name="state" id="state" class="form-control"
                                                class="@error('state') is-invalid @enderror">
                                                @if ($errors->has('state'))
                                                    <span class="text-danger">{{ $errors->first('state') }}</span>
                                                @endif
                                                @php $state =DB::table('states')->get(); @endphp
                                                @foreach ($state as $states)
                                                    <option value="{{ $states->name }}">{{ $states->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-12">
                                        <div class="form-group">
                                            <label>City<span>*</span></label>
                                            <select name="city" id="city" class="form-control"
                                                class="@error('city') is-invalid @enderror">
                                                @if ($errors->has('city'))
                                                    <span class="text-danger">{{ $errors->first('city') }}</span>
                                                @endif
                                                @php $city =DB::table('city')->get(); @endphp
                                                @foreach ($city as $citys)
                                                    <option value="{{ $citys->name }}">{{ $citys->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Address Line 1<span>*</span></label>
                                            <input type="text" name="address" placeholder=""
                                                class="@error('address') is-invalid @enderror">
                                            @if ($errors->has('address'))
                                                <span class="text-danger">{{ $errors->first('address') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Landmark<span>*</span></label>
                                            <input type="text" name="landmark" placeholder=""
                                                class="@error('landmark') is-invalid @enderror">
                                            @if ($errors->has('landmark'))
                                                <span class="text-danger">{{ $errors->first('landmark') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Postal Code<span>*</span></label>
                                            <input type="text" name="pincode" placeholder=""
                                                class="@error('pincode') is-invalid @enderror">
                                            @if ($errors->has('pincode'))
                                                <span class="text-danger">{{ $errors->first('pincode') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <button type="submit"  
                                 class="btn" id="submit">proceed to checkout</button>
                            </form>
                            <!--/ End Form -->
                        </div>
                    </div>
                    @php $coupondata = Session::get('pro_amount'); @endphp

                    <div class="col-lg-4 col-12">
                        @if ($coupondata)
                            <a href="{{ route('checkout') }}" class="deleteSession text-danger"
                                style="margin-left: 164px;"><i class="fa fa-trash"> </i></a><br>
                            <strong class="text bnt btn-success" style="margin-left: 70px; padding:5px;">Coupon Applied
                                Successful</strong>
                        @else
                       
                        @endif
                        <div class="order-details">
                            <div class="single-widget">
                                <form class="form" method="get" action="{{ route('checkout') }}"
                                    enctype="multipart/form-data" style="margin-left: 11.5px;">
                                    @csrf
                                    @php $coupondata = Session::get('pro_amount'); @endphp
                                    @if ($coupondata)
                                        <input type="text" name="coupon_code" id="coupon"
                                            value="{{ $coupondata->coupon_code }}"
                                            style="width: 325px;
                                            margin-left: 5px;
                                            border: 2px solid black;">
                                    @else
                                        <input type="text" name="coupon_code" id="coupon"
                                            style="width: 325px;
                                            margin-left: 5px;
                                            border: 2px solid black;">
                                    @endif
                                    <div>
                                        <button type="submit" class="btn1 btn-success"
                                            style="margin-top: 10px;width:100px;padding:3px;margin-left:125px;">Apply
                                            Coupon</button>
                                    </div>


                                </form>
                            </div>

                            <div class="single-widget">
                                <h2>CART TOTALS</h2>
                                <div class="content">
                                    @php
                                        $total_value = 0;
                                        foreach ($data as $cart_data) {
                                            $total_value += $cart_data->price * $cart_data->quantity;
                                        }
                                    @endphp

                                    <ul>
                                        {{-- Start Sub total Amount --}}
                                        <li>Sub Total<span>{{ $total_value }}</span></li>
                                        {{-- End Sub total Amount --}}

                                        {{-- Star Minimum Shipping charge --}}
                                        @if ($total_value < 1000)
                                            <li>Shipping Charge <span> + {{ 50 }}</span></li>
                                        @else
                                            <li> Shipping Charge<span>0</span></li>
                                        @endif
                                        {{-- End Minimum Shipping charge --}}




                                        {{-- Start Coupon Discount charge --}}
                                        @if ($coupondata)
                                            {{-- Start Coupon Discount type Percent --}}
                                            @if ($coupondata->amount_type == '1')
                                                @php
                                                    $detect = ($total_value * $coupondata->amount) / 100;
                                                    $total_aumount = $total_value - $detect;
                                                @endphp

                                                <li>Coupon Discount<span> - {{ $detect }}</span></li>

                                                {{-- End total amount With Percent --}}
                                                {{-- Start Coupon Discount type Fixed --}}
                                            @else
                                                @php
                                                    $detect = $coupondata->amount;
                                                    $total_aumount = $total_value - $detect;
                                                @endphp
                                                {{-- total amount With fixed --}}
                                                <li>Coupon Discount<span> - {{ $detect }}</span></li>
                                                {{-- End total amount With fixed --}}
                                            @endif
                                            {{-- End Coupon Discount type --}}
                                        @else
                                            <li> Coupon Discount<span>{{ 0 }}</span></li>
                                        @endif
                                        {{-- End Coupon Discount charge --}}
                                        @if ($total_value < 1000)
                                            @if ($coupondata)
                                                <li class="last"> Grand Total<span>{{ $total_aumount + 50 }}</span></li>
                                            @else
                                                <li class="last"> Grand Total<span>{{ $total_value + 50 }}</span></li>
                                            @endif
                                        @else
                                            <li class="last"> Grand Total<span>{{ $total_value }}</span></li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                            <!--/ End Order Widget -->
                            <!-- Order Widget -->
                            <div class="single-widget">
                                <h2>Payments</h2>
                                <div class="content">
                                    <div class="radio px-2">
                                        <label class="radio" for="1">
                                            <input name="payments" id="1" type="radio"> Check Payments</label>
                                        <br>
                                        <label class="radio" for="2">
                                            <input name="payments" id="2" type="radio" name="Cod"> Cash On
                                            Delivery</label> <br>
                                        <label class="radio" for="3">
                                            <input name="payments" id="3" type="radio" name="paypal">
                                            PayPal</label>
                                    </div>
                                </div>
                            </div>

                            <!--/ End Order Widget -->
                            <!-- Payment Method Widget -->
                            <div class="single-widget payement">
                                <div class="content">
                                    <img src="public/images/payment-method.png" alt="#">
                                </div>
                            </div>
                            <!--/ End Payment Method Widget -->
                            <!-- Button Widget -->
                            <div class="single-widget get-button">
                                <div class="content">
                                    <div class="button">

                                    </div>
                                </div>
                            </div>

                            <!--/ End Button Widget -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--/ End Checkout -->

        <!-- Start Shop Services Area  -->
        <section class="shop-services section home">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-12">
                        <!-- Start Single Service -->
                        <div class="single-service">
                            <i class="fa fa-rocket"></i>
                            <h4>Free shiping</h4>
                            <p>Orders over $100</p>
                        </div>
                        <!-- End Single Service -->
                    </div>
                    <div class="col-lg-3 col-md-6 col-12">
                        <!-- Start Single Service -->
                        <div class="single-service">
                            <i class="fa fa-refresh"></i>
                            <h4>Free Return</h4>
                            <p>Within 30 days returns</p>
                        </div>
                        <!-- End Single Service -->
                    </div>
                    <div class="col-lg-3 col-md-6 col-12">
                        <!-- Start Single Service -->
                        <div class="single-service">
                            <i class="fa fa-lock"></i>
                            <h4>Sucure Payment</h4>
                            <p>100% secure payment</p>
                        </div>
                        <!-- End Single Service -->
                    </div>
                    <div class="col-lg-3 col-md-6 col-12">
                        <!-- Start Single Service -->
                        <div class="single-service">
                            <i class="fa fa-tag"></i>
                            <h4>Best Peice</h4>
                            <p>Guaranteed price</p>
                        </div>
                        <!-- End Single Service -->
                    </div>
                </div>
            </div>
        </section>
        <!-- End Shop Services -->

        <!-- Start Shop Newsletter  -->
        <section class="shop-newsletter section">
            <div class="container">
                <div class="inner-top">
                    <div class="row">
                        <div class="col-lg-8 offset-lg-2 col-12">
                            <!-- Start Newsletter Inner -->
                            <div class="inner">
                                <h4>Newsletter</h4>
                                <p> Subscribe to our newsletter and get <span>10%</span> off your first purchase</p>
                                <form action="mail/mail.php" method="get" target="_blank" class="newsletter-inner">
                                    <input name="EMAIL" placeholder="Your email address" required=""
                                        type="email">
                                    <button class="btn">Subscribe</button>
                                </form>
                            </div>
                            <!-- End Newsletter Inner -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <style>
            .btn1:hover {

                color: white;
                background: #007bff;
            }
            h4{
                text-align: center;
                margin-top: 15px;
                color:#F7941D;
                font-size: 30px;
            }
           


        </style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
$(document).ready(function(){
  $("#hide").click(function(){
    $("#address_form").hide();
    
  });
  $("#show").click(function(){
    $("#address_form").show();
    
  });
});
</script>
       
    </body>

    </html>
@endsection
