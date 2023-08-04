@extends('fashi.layouts.default')

@section('content')

<!-- Breadcrumb Section Begin -->
<div class="breacrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-text product-more">
                    <a href="./home.html"><i class="fa fa-home"></i> Home</a>
                    <a href="./shop.html">Shop</a>
                    <span>Shopping Cart</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb Section Begin -->

<!-- Shopping Cart Section Begin -->
<section class="shopping-cart spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                @if(!empty($cartData))
                <div class="cart-table">
                    <table>
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Product Name</th>
                                <th>Price</th>
                                <th>Discount</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th><i class="ti-close"></i></th>
                            </tr>
                        </thead>
                        <tbody>

                        
                          <?php 
                          $final_price = [];
                          $final_discount = []; 
                          ?>
                           @foreach($cartData as $cart)
                           <?php                               
                              $total_price = $cart->price * $cart->quantity;
                              $total_discount = $cart->discount * $cart->quantity;
                              
                              $final_price[] = $total_price;
                              $final_discount[] = $total_discount;
                                ?>
                           <tr>
                                <td class="cart-pic first-row">
                                    <img width="100px;" src="{{Config('constants.PRODUCT_IMAGE_ROOT_URL').$cart->image}}" alt="">
                                </td>
                                <td class="cart-title first-row">
                                    <h5>{{$cart->name}}</h5>
                                </td>

                               
                                <td class="p-price first-row">${{$cart->price}}</td>
                                <td class="p-price first-row">${{$cart->discount}}</td>
                                <td class="qua-col first-row">
                                    <div class="quantity">
                                        <div class="pro-qty">
                                            <input type="text" name="quantity" value="{{$cart->quantity}}">
                                        </div>
                                    </div>
                                </td>

                                <td class="total-price first-row">${{ ($total_price - $total_discount)}}</td>
                                <td class="close-td first-row">
                                   <a href="{{route('Jeevan.removeCartItem', $cart->id)}}"> <i class="ti-close text-danger"></i> </a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="cart-buttons">
                            <a href="{{route('Jeevan.index')}}" class="primary-btn continue-shop">Continue shopping</a>
                            <a href="{{route('Jeevan.shoppingCart')}}" class="primary-btn up-cart">Update cart</a>
                        </div>
                        <div class="discount-coupon">
                            <h6>Discount Codes</h6>
                            <form action="#" class="coupon-form">
                                <input type="text" placeholder="Enter your codes">
                                <button type="submit" class="site-btn coupon-btn">Apply</button>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-4 offset-lg-4">
                        <div class="proceed-checkout">
                            <ul>
                                <li class="subtotal">Subtotal <span>${{ array_sum($final_price) }} </span></li>
                                <li class="cart-total">Total <span>$ {{ array_sum($final_price) - array_sum($final_discount)  }} </span></li>
                            </ul>
                            <a href="{{route('Jeevan.checkout')}}" class="proceed-btn">PROCEED TO CHECK OUT</a>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
<!-- Shopping Cart Section End -->

@stop