@extends('fashi.layouts.default')

@section('content')


<!-- Breadcrumb Section Begin -->
<div class="breacrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-text product-more">
                    <a href="{{route('Jeevan.index')}}"><i class="fa fa-home"></i> Home</a>
                    <a href="{{route('Jeevan.index')}}">Shop</a>
                    <span>Check Out</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb Section Begin -->

<!-- Shopping Cart Section Begin -->
<section class="checkout-section spad">
    <div class="container">
        <form action="{{ route('Jeevan.order') }}" class="checkout-form" data-cc-on-file="false" id="payment-form">
            <div class="row">
                <div class="col-lg-6">
                    <div class="checkout-content">
                        <a href="{{route('UserLogin')}}" class="content-btn">Click Here To Login</a>
                    </div>
                    <h4>Biiling Details</h4>
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="fir">First Name<span>*</span></label>
                            <input type="text" name="first_name" id="fir">
                            @if ($errors->has('first_name'))
                              <span class="error text-danger">{{ $errors->first('first_name') }}</span>
                            @endif
                        </div>
                        <div class="col-lg-6">
                            <label for="last">Last Name<span>*</span></label>
                            <input type="text" name="last_name" id="last">
                            @if ($errors->has('last_name'))
                              <span class="error text-danger">{{ $errors->first('last_name') }}</span>
                            @endif
                        </div>
                        <div class="col-lg-12">
                            <label for="cun-name">Company Name</label>
                            <input type="text" name="company_name" id="cun-name">
                        </div>
                        <div class="col-lg-12">
                            <label for="cun">Country<span>*</span></label>
                            <input type="text" name="country" id="cun">
                            @if ($errors->has('first_name'))
                              <span class="error text-danger">{{ $errors->first('first_name') }}</span>
                            @endif
                        </div>
                        <div class="col-lg-12">
                            <label for="street">Street Address<span>*</span></label>
                            <input type="text" name="street" id="street" class="street-first">
                            @if ($errors->has('street'))
                              <span class="error text-danger">{{ $errors->first('street') }}</span>
                            @endif
                            <input type="text">
                        </div>
                        <div class="col-lg-12">
                            <label for="zip">Postcode / ZIP (optional)</label>
                            <input type="text" name="zip" id="zip">
                        </div>
                        <div class="col-lg-12">
                            <label for="town">Town / City<span>*</span></label>
                            <input type="text" name="town" id="town">
                        </div>
                        <div class="col-lg-6">
                            <label for="email">Email Address<span>*</span></label>
                            <input type="text" name="email" id="email">
                            @if ($errors->has('email'))
                              <span class="error text-danger">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                        <div class="col-lg-6">
                            <label for="phone">Phone<span>*</span></label>
                            <input type="text" name="phone" id="phone">
                            @if ($errors->has('phone'))
                              <span class="error text-danger">{{ $errors->first('phone') }}</span>
                            @endif
                        </div>
                        <div class="col-lg-12">
                            <div class="create-item">
                                <label for="acc-create">
                                    Create an account?
                                    <input type="checkbox" name="account" id="acc-create">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="checkout-content">
                        <input type="text" placeholder="Enter Your Coupon Code">
                    </div>
                    <div class="place-order">
                        <h4>Your Order</h4>
                        <div class="order-total">
                            <ul class="order-table">
                                <li>Product <span>Total</span></li>
                                @if(!empty($carts))
                        <?php 
                          $final_price = 0;
                          $final_discount = 0; 
                          ?>
                                @foreach($carts as $cart)
                                <?php                               
                              $total_price = $cart->price * $cart->quantity;
                              $total_discount = $cart->discount * $cart->quantity;
                              
                              $final_price += $total_price;
                              $final_discount += $total_discount;
                                ?>

                                <li class="fw-normal"> {{$cart->name }} <span>${{$cart->price }} </span></li>
                                @endforeach
                                <li class="fw-normal">Discount <span>${{ $final_discount }} </span></li>
                                <li class="fw-normal">Subtotal <span>${{ $final_price }} </span></li>
                                <li class="total-price">Total <span>${{ $final_price - $final_discount  }} </span></li>
                            </ul>
                            @endif


                            <div class="payment-check">
                                <div class="pc-item">
                                    <label for="pc-check">
                                        COD
                                        <input type="radio" name="payments" id="pc-check">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="pc-item">
                                        <label for="pc-paypal">
                                           Payment Card
                                            <input type="radio" name="payments" id="pc-paypal">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                            </div>

                            <div class="order-btn">
                                <button type="submit" class="site-btn place-btn">Place Order</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
<!-- Shopping Cart Section End -->


@stop