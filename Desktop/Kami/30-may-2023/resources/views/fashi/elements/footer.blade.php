  
    <!-- Partner Logo Section Begin -->
    <div class="partner-logo">
        <div class="container">
            <div class="logo-carousel owl-carousel">
                <div class="logo-item">
                    <div class="tablecell-inner">
                        <img src="public/img/logo-carousel/logo-1.png" alt="">
                    </div>
                </div>
                <div class="logo-item">
                    <div class="tablecell-inner">
                        <img src="public/img/logo-carousel/logo-2.png" alt="">
                    </div>
                </div>
                <div class="logo-item">
                    <div class="tablecell-inner">
                        <img src="public/img/logo-carousel/logo-3.png" alt="">
                    </div>
                </div>
                <div class="logo-item">
                    <div class="tablecell-inner">
                        <img src="public/img/logo-carousel/logo-4.png" alt="">
                    </div>
                </div>
                <div class="logo-item">
                    <div class="tablecell-inner">
                        <img src="public/img/logo-carousel/logo-5.png" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Partner Logo Section End -->

  
  <!-- Footer Section Begin -->
  <footer class="footer-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="footer-left">
                        <div class="footer-logo">
                            <a href="#"><img src="public/img/footer-logo.png" alt=""></a>
                        </div>
                        <ul>
                            @if(Config::get('Site.address'))
                            <li>Address: {{Config::get('Site.address')}} </li>
                            @endif
                            @if(Config::get('Contact.telephone'))
                            <li>Phone: {{Config::get('Contact.telephone')}} </li>
                            @endif
                            @if(Config::get('Site.from_email'))
                            <li>Email: {{Config::get('Site.from_email') }} </li>
                            @endif
                        </ul>
                        <div class="footer-social">
                        @if(Config::get('Socail.facebook'))
                            <a href="{{Config::get('Socail.facebook')}}"><i class="fa fa-facebook"></i></a>
                         @endif
                          @if(Config::get('Socail.instagram'))
                            <a href="{{Config::get('Socail.instagram')}}"><i class="fa fa-instagram"></i></a>
                            @endif
                            @if(Config::get('Socail.twitter'))
                            <a href="{{Config::get('Socail.twitter')}}"><i class="fa fa-twitter"></i></a>
                            @endif
                            @if(Config::get('Socail.pinterest'))
                            <a href="{{Config::get('Socail.twitter')}}"><i class="fa fa-pinterest"></i></a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 offset-lg-1">
                    <div class="footer-widget">
                        <h5>Information</h5>
                        <ul>
                            <li><a href="{{route('Jeevan.index')}}">About Us</a></li>
                            <li><a href="{{route('Jeevan.checkout')}}">Checkout</a></li>
                            <li><a href="{{route('Jeevan.contact')}}">Contact</a></li>
                            <li><a href="{{route('Jeevan.shop')}}">Serivius</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="footer-widget">
                        <h5>My Account</h5>
                        <ul>
                            <li><a href="{{route('Jeevan.index')}}">My Account</a></li>
                            <li><a href="{{route('Jeevan.contact')}}">Contact</a></li>
                            <li><a href="{{route('Jeevan.shoppingCart')}}">Shopping Cart</a></li>
                            <li><a href="{{route('Jeevan.shop')}}">Shop</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="newslatter-item">
                        <h5>Join Our Newsletter Now</h5>
                        <p>Get E-mail updates about our latest shop and special offers.</p>
                        <form action="{{route('Jeevan.shop')}}" class="subscribe-form">
                            <input type="text" placeholder="Enter Your Mail">
                            <button type="button">Subscribe</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="copyright-reserved">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="copyright-text">
                            Copyright &copy;<script>
                                document.write(new Date().getFullYear());
                            </script> All rights reserved | This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="http://exbha.dev21.obtech.inet/adminpnlx" target="_blank">Fashi</a>
                        </div>
                        <div class="payment-pic">
                            <img src="img/payment-method.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer Section End -->