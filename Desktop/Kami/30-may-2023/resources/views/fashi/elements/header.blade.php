   <!-- Header Section Begin -->
   <header class="header-section">
        <div class="header-top">
            <div class="container">
                <div class="ht-left">
                    <div class="mail-service">
                        <i class=" fa fa-envelope"></i>
                          @if(Config::get('Site.from_email'))
                           {{Config::get('Site.from_email') }} 
                            @endif
                    </div>
                    <div class="phone-service">
                        <i class=" fa fa-phone"></i>
                        @if(Config::get('Contact.telephone'))
                            {{Config::get('Contact.telephone')}} 
                            @endif
                    </div>
                </div>
                <div class="ht-right">
                    <a href="#" class="login-panel"><i class="fa fa-user"></i>Login</a>
                    <div class="lan-selector">
                        <?php $languages = getActiveLanguages(); ?>

                        <select class="language_drop Langchange" name="countries" id="countries" style="width:300px;">
                           @if(!empty($languages))
                           @foreach($languages as $lang)
                            <option value='{{$lang->lang_code}} {{ session()->get("locale") == $lang->lang_code ? "selected" : "" }}' data-image="{{ url(Config('constants.LANGUAGES_IMAGE_ROOT_URL').$lang->image)}}"
                             data-imagecss="flag yt" data-title="English" style="height:30px;">{{ $lang->title }} </option>
                                @endforeach
                            @endif
                            <!-- <option value='{{ session()->get('locale') == 'sp' ? 'selected' : '' }}' data-image="public/img/flag-2.jpg" data-imagecss="flag yu"
                                data-title="Bangladesh">German </option> -->
                        </select>
                    </div>
                    <div class="top-social">
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
        </div>
        <div class="container">
            <div class="inner-header">
                <div class="row">
                    <div class="col-lg-2 col-md-2">
                        <div class="logo">
                            <a href="./index.html">
                                <img src="img/logo.png" alt="">
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-7 col-md-7">
                        <div class="advanced-search">
                            <button type="button" class="category-btn">All Categories</button>
                            <div class="input-group">
                                <input type="text" placeholder="What do you need?">
                                <button type="button"><i class="ti-search"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 text-right col-md-3">
                        <ul class="nav-right">
                            <li class="heart-icon">
                                <a href="#">
                                    <i class="icon_heart_alt"></i>
                                    <span>1</span>
                                </a>
                            </li>
                            <li class="cart-icon">
                                <a href="#">
                                    <i class="icon_bag_alt"></i>
                                    <span>3</span>
                                </a>
                                <div class="cart-hover">
                                    <div class="select-items">
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td class="si-pic"><img src="public/img/select-product-1.jpg" alt=""></td>
                                                    <td class="si-text">
                                                        <div class="product-selected">
                                                            <p>$60.00 x 1</p>
                                                            <h6>Kabino Bedside Table</h6>
                                                        </div>
                                                    </td>
                                                    <td class="si-close">
                                                        <i class="ti-close"></i>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="si-pic"><img src="public/img/select-product-2.jpg" alt=""></td>
                                                    <td class="si-text">
                                                        <div class="product-selected">
                                                            <p>$60.00 x 1</p>
                                                            <h6>Kabino Bedside Table</h6>
                                                        </div>
                                                    </td>
                                                    <td class="si-close">
                                                        <i class="ti-close"></i>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="select-total">
                                        <span>total:</span>
                                        <h5>$120.00</h5>
                                    </div>
                                    <div class="select-button">
                                        <a href="#" class="primary-btn view-card">VIEW CARD</a>
                                        <a href="#" class="primary-btn checkout-btn">CHECK OUT</a>
                                    </div>
                                </div>
                            </li>
                            <li class="cart-price">$150.00</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="nav-item">
            <div class="container">
                <div class="nav-depart">
                    <div class="depart-btn">
                        <i class="ti-menu"></i>
                        <span>All departments</span>
                        <ul class="depart-hover">
                            <li class="active"><a href="#">Women’s Clothing</a></li>
                            <li><a href="#">Men’s Clothing</a></li>
                            <li><a href="#">Underwear</a></li>
                            <li><a href="#">Kid's Clothing</a></li>
                            <li><a href="#">Brand Fashion</a></li>
                            <li><a href="#">Accessories/Shoes</a></li>
                            <li><a href="#">Luxury Brands</a></li>
                            <li><a href="#">Brand Outdoor Apparel</a></li>
                        </ul>
                    </div>
                </div>
              
                <nav class="nav-menu mobile-menu">
                    <ul>
                        <li class="active"><a href="./index.html">{{ trans('messages.home')}}</a></li>
                        <li><a href="./shop.html">{{ trans('messages.login')}}</a></li>
                        <li><a href="#">Collection</a>
                            <ul class="dropdown">
                                <li><a href="#">Men's</a></li>
                                <li><a href="#">Women's</a></li>
                                <li><a href="#">Kid's</a></li>
                            </ul>
                        </li>
                        <li><a href="./blog.html">{{ trans('messages.blog')}}</a></li>
                        <li><a href="./contact.html">Contact</a></li>
                        <li><a href="#">Pages</a>
                            <ul class="dropdown">
                                <li><a href="./blog-details.html">Blog Details</a></li>
                                <li><a href="./shopping-cart.html">Shopping Cart</a></li>
                                <li><a href="./check-out.html">Checkout</a></li>
                                <li><a href="./faq.html">Faq</a></li>
                                <li><a href="./register.html">Register</a></li>
                                <li><a href="./login.html">Login</a></li>
                            </ul>
                        </li>
                    </ul>
                </nav>
                <div id="mobile-menu-wrap"></div>
            </div>
        </div>
    </header>
    <!-- Header End -->

    
 <!-- <script type="text/javascript">  
    var url = "{{ route('LangChange') }}";
      $(".Langchange").change(function(){
        alert(1212);
        // window.location.href = url + "?lang="+ $(this).val();
    });   -->
    <script src="jquery-3.6.4.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script>
         var url = "{{ route('LangChange') }}";
        $(document).ready(function(){
        $('.Langchange').change(function(){
            window.location.href = url + "?lang="+ $(this).val();
    });
});
    </script>