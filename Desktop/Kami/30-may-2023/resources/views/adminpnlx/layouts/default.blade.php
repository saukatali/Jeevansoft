<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->


<head>
    <base href="">
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Eccom</title>
    <script type="text/javascript" src="//code.jquery.com/jquery-2.1.3.js"></script>
    <script src="{{asset('/public/adminpnlx/js/ckeditor/ckeditor.js')}}"></script>

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <link href="{{config('constants.WEBSITE_CSS_URL')}}plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="{{config('constants.WEBSITE_CSS_URL')}}prismjs.bundle.css" rel="stylesheet" type="text/css" />
    <link href="{{config('constants.WEBSITE_CSS_URL')}}datatables.bundle.css" rel="stylesheet" type="text/css" />
    <link href="{{config('constants.WEBSITE_CSS_URL')}}style.bundle.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{config('constants.WEBSITE_CSS_URL')}}frontend/bootstrap-datetimepicker.min.css">


    <link href="{{config('constants.WEBSITE_CSS_URL')}}themes/layout/header/base/light.css" rel="stylesheet" type="text/css" />
    <link href="{{config('constants.WEBSITE_CSS_URL')}}themes/layout/header/menu/light.css" rel="stylesheet" type="text/css" />
    <link href="{{config('constants.WEBSITE_CSS_URL')}}themes/layout/brand/dark.css" rel="stylesheet" type="text/css" />
    <link href="{{config('constants.WEBSITE_CSS_URL')}}themes/layout/aside/dark.css" rel="stylesheet" type="text/css" />


    <link rel="stylesheet" href="{{config('constants.WEBSITE_CSS_URL')}}style.css">
    <link rel="shortcut icon" href="{{config('constants.WEBSITE_IMG_URL')}}fav.png" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css">


    <!--begin::Global Theme Bundle(used by all pages)-->
    <script src="{{config('constants.WEBSITE_JS_URL')}}plugins.bundle.js"></script>
    <script src="{{config('constants.WEBSITE_JS_URL')}}prismjs.bundle.js"></script>
    <script src="{{config('constants.WEBSITE_JS_URL')}}scripts.bundle.js"></script>
    <script src="{{config('constants.WEBSITE_JS_URL')}}sweetalert2.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>

</head>


<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed
aside-minimize-hoverable page-loading">

    <script type="text/javascript">
        function show_message(message, message_type) {
            Swal.fire({
                position: "top-right",
                icon: message_type,
                title: message,
                showConfirmButton: false,
                timer: 8000
            });
        }
        $(document).ready(function() {
            $('.magnific-image').magnificPopup({
                type: 'image'
            });
            $('.fancybox-buttons').magnificPopup({
                type: 'image'
            });
        });
    </script>

    <div id="kt_header_mobile" class="header-mobile align-items-center  header-mobile-fixed ">
        <a href="{{route('dashboard')}}">
            <!-- <img alt="Logo" src="{{asset('public/adminpnlx/img/jeevan.png')}}" /> -->
        </a>

        <div class="d-flex align-items-center">
            <!--begin::Aside Mobile Toggle-->
            <button class="btn p-0 burger-icon burger-icon-left" id="kt_aside_mobile_toggle">
                <span></span>
            </button>
            <!--end::Aside Mobile Toggle-->

            <!--begin::Topbar Mobile Toggle-->
            <button class="btn btn-hover-text-primary p-0 ml-2" id="kt_header_mobile_topbar_toggle">
                <span class="svg-icon svg-icon-xl">
                    <!--begin::Svg Icon | path:assets/media/svg/icons/General/User.svg-->
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <polygon points="0 0 24 0 24 24 0 24" />
                            <path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
                            <path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero" />
                        </g>
                    </svg>
                    <!--end::Svg Icon-->
                </span> </button>
            <!--end::Topbar Mobile Toggle-->
        </div>
        <!--end::Toolbar-->
    </div>
    <!--end::Header Mobile-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Page-->
        <div class="d-flex flex-row flex-column-fluid page">

            <!--begin::Aside-->
            <div class="aside aside-left  aside-fixed  d-flex flex-column flex-row-auto" id="kt_aside">
                <!--begin::Brand-->
                <div class="brand flex-column-auto " id="kt_brand">
                    <!--begin::Logo-->
                    <a href="{{route('dashboard')}}" class="brand-logo w-100 justify-content-center">
                        <!-- <img alt="Logo" src="{{asset('public/adminpnlx/img/jeevan.png')}}" /> -->
                    </a>
                    <!--end::Logo-->

                    <!--begin::Toggle-->
                    <button class="brand-toggle btn btn-sm px-0" id="kt_aside_toggle">
                        <span class="svg-icon svg-icon svg-icon-xl">
                            <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Angle-double-left.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <polygon points="0 0 24 0 24 24 0 24" />
                                    <path d="M5.29288961,6.70710318 C4.90236532,6.31657888 4.90236532,5.68341391 5.29288961,5.29288961 C5.68341391,4.90236532 6.31657888,4.90236532 6.70710318,5.29288961 L12.7071032,11.2928896 C13.0856821,11.6714686 13.0989277,12.281055 12.7371505,12.675721 L7.23715054,18.675721 C6.86395813,19.08284 6.23139076,19.1103429 5.82427177,18.7371505 C5.41715278,18.3639581 5.38964985,17.7313908 5.76284226,17.3242718 L10.6158586,12.0300721 L5.29288961,6.70710318 Z" fill="#000000" fill-rule="nonzero" transform="translate(8.999997, 11.999999) scale(-1, 1) translate(-8.999997, -11.999999) " />
                                    <path d="M10.7071009,15.7071068 C10.3165766,16.0976311 9.68341162,16.0976311 9.29288733,15.7071068 C8.90236304,15.3165825 8.90236304,14.6834175 9.29288733,14.2928932 L15.2928873,8.29289322 C15.6714663,7.91431428 16.2810527,7.90106866 16.6757187,8.26284586 L22.6757187,13.7628459 C23.0828377,14.1360383 23.1103407,14.7686056 22.7371482,15.1757246 C22.3639558,15.5828436 21.7313885,15.6103465 21.3242695,15.2371541 L16.0300699,10.3841378 L10.7071009,15.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(15.999997, 11.999999) scale(-1, 1) rotate(-270.000000) translate(-15.999997, -11.999999) " />
                                </g>
                            </svg>
                            <!--end::Svg Icon-->
                        </span>
                    </button>
                    <!--end::Toolbar-->
                </div>
                <!--end::Brand-->

                <!--begin::Aside Menu-->
                <div class="aside-menu-wrapper flex-column-fluid" id="kt_aside_menu_wrapper">
                    <?php
                    $segment1    =    Request::segment(1);
                    $segment2    =    Request::segment(2);
                    $segment3    =    Request::segment(3);
                    $segment4    =    Request::segment(4);
                    ?>
                    <!--begin::Menu Container-->
                    <div id="kt_aside_menu" class="aside-menu my-4 " data-menu-vertical="1" data-menu-scroll="1" data-menu-dropdown-timeout="500">
                        <?php
                        $menus   =    Session()->get('acls');
                        echo sideBarNavigation($menus);
                        ?>
                       <!--  <ul class="menu-nav ">
                            <li class="menu-item  {{ ($segment2 == 'dashboard') ? 'menu-item-active' : '' }}" aria-haspopup="true">
                                <a href="{{route('dashboard')}}" class="menu-link "><span class="svg-icon menu-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <polygon points="0 0 24 0 24 24 0 24" />
                                                <path d="M12.9336061,16.072447 L19.36,10.9564761 L19.5181585,10.8312381 C20.1676248,10.3169571 20.2772143,9.3735535 19.7629333,8.72408713 C19.6917232,8.63415859 19.6104327,8.55269514 19.5206557,8.48129411 L12.9336854,3.24257445 C12.3871201,2.80788259 11.6128799,2.80788259 11.0663146,3.24257445 L4.47482784,8.48488609 C3.82645598,9.00054628 3.71887192,9.94418071 4.23453211,10.5925526 C4.30500305,10.6811601 4.38527899,10.7615046 4.47382636,10.8320511 L4.63,10.9564761 L11.0659024,16.0730648 C11.6126744,16.5077525 12.3871218,16.5074963 12.9336061,16.072447 Z" fill="#000000" fill-rule="nonzero" />
                                                <path d="M11.0563554,18.6706981 L5.33593024,14.122919 C4.94553994,13.8125559 4.37746707,13.8774308 4.06710397,14.2678211 C4.06471678,14.2708238 4.06234874,14.2738418 4.06,14.2768747 L4.06,14.2768747 C3.75257288,14.6738539 3.82516916,15.244888 4.22214834,15.5523151 C4.22358765,15.5534297 4.2250303,15.55454 4.22647627,15.555646 L11.0872776,20.8031356 C11.6250734,21.2144692 12.371757,21.2145375 12.909628,20.8033023 L19.7677785,15.559828 C20.1693192,15.2528257 20.2459576,14.6784381 19.9389553,14.2768974 C19.9376429,14.2751809 19.9363245,14.2734691 19.935,14.2717619 L19.935,14.2717619 C19.6266937,13.8743807 19.0546209,13.8021712 18.6572397,14.1104775 C18.654352,14.112718 18.6514778,14.1149757 18.6486172,14.1172508 L12.9235044,18.6705218 C12.377022,19.1051477 11.6029199,19.1052208 11.0563554,18.6706981 Z" fill="#000000" opacity="0.3" />
                                            </g>
                                        </svg>
                                    </span>
                                    <span class="menu-text">Dashboard</span>
                                </a>
                            </li>

                            <li class="menu-item menu-item-submenu
                            {{ in_array($segment2 ,array('banners','blogs')) ? 
                              'menu-item-open' : '' }}" aria-haspopup="true" data-menu-toggle="hover">
                                <a href="javascript:;" class="menu-link menu-toggle">
                                    <span class="svg-icon menu-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24" />
                                                <path d="M3.95709826,8.41510662 L11.47855,3.81866389 C11.7986624,3.62303967 12.2013376,3.62303967 12.52145,3.81866389 L20.0429,8.41510557 C20.6374094,8.77841684 21,9.42493654 21,10.1216692 L21,19.0000642 C21,20.1046337 20.1045695,21.0000642 19,21.0000642 L4.99998155,21.0000673 C3.89541205,21.0000673 2.99998155,20.1046368 2.99998155,19.0000673 L2.99999828,10.1216672 C2.99999935,9.42493561 3.36258984,8.77841732 3.95709826,8.41510662 Z M10,13 C9.44771525,13 9,13.4477153 9,14 L9,17 C9,17.5522847 9.44771525,18 10,18 L14,18 C14.5522847,18 15,17.5522847 15,17 L15,14 C15,13.4477153 14.5522847,13 14,13 L10,13 Z" fill="#000000" />
                                            </g>
                                        </svg>
                                    </span>
                                    <span class="menu-text"> Home Management </span>
                                    <i class="menu-arrow"></i>
                                </a>
                                <div class="menu-submenu">
                                    <i class="menu-arrow"></i>
                                    <ul class="menu-subnav">
                                        <li class="menu-item menu-item-parent" aria-haspopup="true">
                                            <span class="menu-link">
                                                <span class="menu-text"> Home Management </span>
                                            </span>
                                        </li>

                                        <li @if($segment2=='banners' ) class="menu-item menu-item-active" @else class="menu-item" @endif aria-haspopup="true">
                                            <a href="{{route('Banner.index')}}" class="menu-link">
                                                <i class="menu-bullet menu-bullet-line">
                                                    <span></span>
                                                </i>
                                                <span class="menu-text">Banner</span>
                                            </a>
                                        </li>

                                        <li @if($segment2=='blogs' ) class="menu-item menu-item-active" @else class="menu-item" @endif aria-haspopup="true">
                                            <a href="{{route('Blog.index')}}" class="menu-link">
                                                <i class="menu-bullet menu-bullet-line">
                                                    <span></span>
                                                </i>
                                                <span class="menu-text"> Blog </span>
                                            </a>
                                        </li>
                                    </ul>
                            </li>

                            <li class="menu-item  {{ ($segment2 == 'users') ? 'menu-item-active' : '' }}" aria-haspopup="true">
                                <a href="{{route('User.index')}}" class="menu-link "><span class="svg-icon menu-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <polygon points="0 0 24 0 24 24 0 24" />
                                                <path d="M18,8 L16,8 C15.4477153,8 15,7.55228475 15,7 C15,6.44771525 15.4477153,6 16,6 L18,6 L18,4 C18,3.44771525 18.4477153,3 19,3 C19.5522847,3 20,3.44771525 20,4 L20,6 L22,6 C22.5522847,6 23,6.44771525 23,7 C23,7.55228475 22.5522847,8 22,8 L20,8 L20,10 C20,10.5522847 19.5522847,11 19,11 C18.4477153,11 18,10.5522847 18,10 L18,8 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                                <path d="M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z" fill="#000000" fill-rule="nonzero" />
                                            </g>
                                        </svg>
                                    </span>
                                    <span class="menu-text">Customers</span>
                                </a>
                            </li>

                            <li class="menu-item  {{ ($segment2 == 'staff') ? 'menu-item-active' : '' }}" aria-haspopup="true">
                                <a href="{{route('Staff.index')}}" class="menu-link "><span class="svg-icon menu-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <polygon points="0 0 24 0 24 24 0 24" />
                                                <path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                                <path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero" />
                                            </g>
                                        </svg>
                                    </span>
                                    <span class="menu-text">Staff Management</span>
                                </a>
                            </li>

                            <li class="menu-item menu-item-submenu
                              {{ in_array($segment2 ,array('order','order-cancel-request', 'order-refund-request', 'order-return-request')) ? 
                                'menu-item-open' : '' }}" aria-haspopup="true" data-menu-toggle="hover">
                                <a href="javascript:;" class="menu-link menu-toggle">
                                    <span class="svg-icon menu-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24" />
                                                <rect fill="#000000" x="4" y="4" width="7" height="7" rx="1.5" />
                                                <path d="M5.5,13 L9.5,13 C10.3284271,13 11,13.6715729 11,14.5 L11,18.5 C11,19.3284271 10.3284271,20 9.5,20 L5.5,20 C4.67157288,20 4,19.3284271 4,18.5 L4,14.5 C4,13.6715729 4.67157288,13 5.5,13 Z M14.5,4 L18.5,4 C19.3284271,4 20,4.67157288 20,5.5 L20,9.5 C20,10.3284271 19.3284271,11 18.5,11 L14.5,11 C13.6715729,11 13,10.3284271 13,9.5 L13,5.5 C13,4.67157288 13.6715729,4 14.5,4 Z M14.5,13 L18.5,13 C19.3284271,13 20,13.6715729 20,14.5 L20,18.5 C20,19.3284271 19.3284271,20 18.5,20 L14.5,20 C13.6715729,20 13,19.3284271 13,18.5 L13,14.5 C13,13.6715729 13.6715729,13 14.5,13 Z" fill="#000000" opacity="0.3" />
                                            </g>
                                        </svg>
                                    </span>
                                    <span class="menu-text"> Order Management </span>
                                    <i class="menu-arrow"></i>
                                </a>
                                <div class="menu-submenu">
                                    <i class="menu-arrow"></i>
                                    <ul class="menu-subnav">
                                        <li class="menu-item menu-item-parent" aria-haspopup="true">
                                            <span class="menu-link">
                                                <span class="menu-text"> Order Management </span>
                                            </span>
                                        </li>

                                        <li @if($segment2=='order' ) class="menu-item menu-item-active" @else class="menu-item" @endif aria-haspopup="true">
                                            <a href="{{route('Order.index')}}" class="menu-link">
                                                <i class="menu-bullet menu-bullet-line">
                                                    <span></span>
                                                </i>
                                                <span class="menu-text">Order</span>
                                            </a>
                                        </li>

                                        <li @if($segment2=='order-cancel-request' ) class="menu-item menu-item-active" @else class="menu-item" @endif aria-haspopup="true">
                                            <a href="{{route('OrderCancel.index')}}" class="menu-link">
                                                <i class="menu-bullet menu-bullet-line">
                                                    <span></span>
                                                </i>
                                                <span class="menu-text">Order Cancel Request </span>
                                            </a>
                                        </li>

                                        <li @if($segment2=='order-refund-request' ) class="menu-item menu-item-active" @else class="menu-item" @endif aria-haspopup="true">
                                            <a href="{{route('OrderRefund.index')}}" class="menu-link">
                                                <i class="menu-bullet menu-bullet-line">
                                                    <span></span>
                                                </i>
                                                <span class="menu-text">Order Refund Request </span>
                                            </a>
                                        </li>
                                        <li @if($segment2=='order-return-request' ) class="menu-item menu-item-active" @else class="menu-item" @endif aria-haspopup="true">
                                            <a href="{{route('OrderReturn.index')}}" class="menu-link">
                                                <i class="menu-bullet menu-bullet-line">
                                                    <span></span>
                                                </i>
                                                <span class="menu-text">Order Return Request </span>
                                            </a>
                                        </li>

                                    </ul>
                            </li>
                            <li class="menu-item  {{ ($segment2 == 'payments') ? 'menu-item-active' : '' }}" aria-haspopup="true">
                                <a href="{{route('Payment.index')}}" class="menu-link "><span class="svg-icon menu-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24" />
                                                <path d="M2,6 L21,6 C21.5522847,6 22,6.44771525 22,7 L22,17 C22,17.5522847 21.5522847,18 21,18 L2,18 C1.44771525,18 1,17.5522847 1,17 L1,7 C1,6.44771525 1.44771525,6 2,6 Z M11.5,16 C13.709139,16 15.5,14.209139 15.5,12 C15.5,9.790861 13.709139,8 11.5,8 C9.290861,8 7.5,9.790861 7.5,12 C7.5,14.209139 9.290861,16 11.5,16 Z" fill="#000000" opacity="0.3" transform="translate(11.500000, 12.000000) rotate(-345.000000) translate(-11.500000, -12.000000) " />
                                                <path d="M2,6 L21,6 C21.5522847,6 22,6.44771525 22,7 L22,17 C22,17.5522847 21.5522847,18 21,18 L2,18 C1.44771525,18 1,17.5522847 1,17 L1,7 C1,6.44771525 1.44771525,6 2,6 Z M11.5,16 C13.709139,16 15.5,14.209139 15.5,12 C15.5,9.790861 13.709139,8 11.5,8 C9.290861,8 7.5,9.790861 7.5,12 C7.5,14.209139 9.290861,16 11.5,16 Z M11.5,14 C12.6045695,14 13.5,13.1045695 13.5,12 C13.5,10.8954305 12.6045695,10 11.5,10 C10.3954305,10 9.5,10.8954305 9.5,12 C9.5,13.1045695 10.3954305,14 11.5,14 Z" fill="#000000" />
                                            </g>
                                        </svg>
                                    </span>
                                    <span class="menu-text">Payment Management</span>
                                </a>
                            </li>

                            <li class="menu-item menu-item-submenu
                              {{ in_array($segment2 ,array('products','categories','sub-categories', 'coupons')) ? 
                                'menu-item-open' : '' }}" aria-haspopup="true" data-menu-toggle="hover">
                                <a href="javascript:;" class="menu-link menu-toggle">
                                    <span class="svg-icon menu-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24" />
                                                <path d="M7,6 C6.44771525,6 6,6.44771525 6,7 L6,17 C6,17.5522847 6.44771525,18 7,18 L17,18 C17.5522847,18 18,17.5522847 18,17 L18,7 C18,6.44771525 17.5522847,6 17,6 L7,6 Z M7,4 L17,4 C18.6568542,4 20,5.34314575 20,7 L20,17 C20,18.6568542 18.6568542,20 17,20 L7,20 C5.34314575,20 4,18.6568542 4,17 L4,7 C4,5.34314575 5.34314575,4 7,4 Z" fill="#000000" fill-rule="nonzero" />
                                            </g>
                                        </svg>
                                    </span>
                                    <span class="menu-text"> Product Management </span>
                                    <i class="menu-arrow"></i>
                                </a>
                                <div class="menu-submenu">
                                    <i class="menu-arrow"></i>
                                    <ul class="menu-subnav">
                                        <li class="menu-item menu-item-parent" aria-haspopup="true">
                                            <span class="menu-link">
                                                <span class="menu-text"> Product Management </span>
                                            </span>
                                        </li>

                                        <li @if($segment2=='products' ) class="menu-item menu-item-active" @else class="menu-item" @endif aria-haspopup="true">
                                            <a href="{{route('Product.index')}}" class="menu-link">
                                                <i class="menu-bullet menu-bullet-line">
                                                    <span></span>
                                                </i>
                                                <span class="menu-text">Product</span>
                                            </a>
                                        </li>

                                        <li @if($segment2=='categories' ) class="menu-item menu-item-active" @else class="menu-item" @endif aria-haspopup="true">
                                            <a href="{{route('Category.index')}}" class="menu-link">
                                                <i class="menu-bullet menu-bullet-line">
                                                    <span></span>
                                                </i>
                                                <span class="menu-text"> Category</span>
                                            </a>
                                        </li>

                                        <li @if($segment2=='coupons' ) class="menu-item menu-item-active" @else class="menu-item" @endif aria-haspopup="true">
                                            <a href="{{route('Coupon.index')}}" class="menu-link">
                                                <i class="menu-bullet menu-bullet-line">
                                                    <span></span>
                                                </i>
                                                <span class="menu-text">Offers And Discounts</span>
                                            </a>
                                        </li>

                                    </ul>
                            </li>

                            <li class="menu-item  {{ ($segment2 == 'reviews-rating') ? 'menu-item-active' : '' }}" aria-haspopup="true">
                                <a href="{{route('ReviewAndRating.index')}}" class="menu-link "><span class="svg-icon menu-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <polygon points="0 0 24 0 24 24 0 24" />
                                                <path d="M12,18 L7.91561963,20.1472858 C7.42677504,20.4042866 6.82214789,20.2163401 6.56514708,19.7274955 C6.46280801,19.5328351 6.42749334,19.309867 6.46467018,19.0931094 L7.24471742,14.545085 L3.94038429,11.3241562 C3.54490071,10.938655 3.5368084,10.3055417 3.92230962,9.91005817 C4.07581822,9.75257453 4.27696063,9.65008735 4.49459766,9.61846284 L9.06107374,8.95491503 L11.1032639,4.81698575 C11.3476862,4.32173209 11.9473121,4.11839309 12.4425657,4.36281539 C12.6397783,4.46014562 12.7994058,4.61977315 12.8967361,4.81698575 L14.9389263,8.95491503 L19.5054023,9.61846284 C20.0519472,9.69788046 20.4306287,10.2053233 20.351211,10.7518682 C20.3195865,10.9695052 20.2170993,11.1706476 20.0596157,11.3241562 L16.7552826,14.545085 L17.5353298,19.0931094 C17.6286908,19.6374458 17.263103,20.1544017 16.7187666,20.2477627 C16.5020089,20.2849396 16.2790408,20.2496249 16.0843804,20.1472858 L12,18 Z" fill="#000000" />
                                            </g>
                                        </svg>
                                    </span>
                                    <span class="menu-text">Reviews And Ratings</span>
                                </a>
                            </li>

                            <li class="menu-item  {{ ($segment2 == 'notifications') ? 'menu-item-active' : '' }}" aria-haspopup="true">
                                <a href="{{route('Notification.index')}}" class="menu-link "><span class="svg-icon menu-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24" />
                                                <path d="M4,6 L20,6 C20.5522847,6 21,6.44771525 21,7 L21,8 C21,8.55228475 20.5522847,9 20,9 L4,9 C3.44771525,9 3,8.55228475 3,8 L3,7 C3,6.44771525 3.44771525,6 4,6 Z M5,11 L10,11 C10.5522847,11 11,11.4477153 11,12 L11,19 C11,19.5522847 10.5522847,20 10,20 L5,20 C4.44771525,20 4,19.5522847 4,19 L4,12 C4,11.4477153 4.44771525,11 5,11 Z M14,11 L19,11 C19.5522847,11 20,11.4477153 20,12 L20,19 C20,19.5522847 19.5522847,20 19,20 L14,20 C13.4477153,20 13,19.5522847 13,19 L13,12 C13,11.4477153 13.4477153,11 14,11 Z" fill="#000000" />
                                                <path d="M14.4452998,2.16794971 C14.9048285,1.86159725 15.5256978,1.98577112 15.8320503,2.4452998 C16.1384028,2.90482849 16.0142289,3.52569784 15.5547002,3.83205029 L12,6.20185043 L8.4452998,3.83205029 C7.98577112,3.52569784 7.86159725,2.90482849 8.16794971,2.4452998 C8.47430216,1.98577112 9.09517151,1.86159725 9.5547002,2.16794971 L12,3.79814957 L14.4452998,2.16794971 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                            </g>
                                        </svg>
                                    </span>
                                    <span class="menu-text"> Notification Management</span>
                                </a>
                            </li>



                            <li class="menu-item menu-item-submenu {{ in_array($segment2 ,array('departments','sizes','colors', 'brands')) ? 
                                'menu-item-open' : '' }}" aria-haspopup="true" data-menu-toggle="hover">
                                <a href="javascript:;" class="menu-link menu-toggle">
                                    <span class="svg-icon menu-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24"></rect>
                                                <path d="M7,3 L17,3 C19.209139,3 21,4.790861 21,7 C21,9.209139 19.209139,11 17,11 L7,11 C4.790861,11 3,9.209139 3,7 C3,4.790861 4.790861,3 7,3 Z M7,9 C8.1045695,9 9,8.1045695 9,7 C9,5.8954305 8.1045695,5 7,5 C5.8954305,5 5,5.8954305 5,7 C5,8.1045695 5.8954305,9 7,9 Z" fill="#000000"></path>
                                                <path d="M7,13 L17,13 C19.209139,13 21,14.790861 21,17 C21,19.209139 19.209139,21 17,21 L7,21 C4.790861,21 3,19.209139 3,17 C3,14.790861 4.790861,13 7,13 Z M17,19 C18.1045695,19 19,18.1045695 19,17 C19,15.8954305 18.1045695,15 17,15 C15.8954305,15 15,15.8954305 15,17 C15,18.1045695 15.8954305,19 17,19 Z" fill="#000000" opacity="0.3"></path>
                                            </g>
                                        </svg>
                                    </span>

                                    <span class="menu-text"> Master</span>
                                    <i class="menu-arrow"></i>
                                </a>
                                <div class="menu-submenu">
                                    <i class="menu-arrow"></i>
                                    <ul class="menu-subnav">
                                        <li class="menu-item menu-item-parent" aria-haspopup="true">
                                            <span class="menu-link">
                                                <span class="menu-text"> Master </span>
                                            </span>
                                        </li>

                                        <li @if($segment2=='departments' ) class="menu-item menu-item-active" @else class="menu-item" @endif aria-haspopup="true">
                                            <a href="{{route('Department.index')}}" class="menu-link">
                                                <i class="menu-bullet menu-bullet-line">
                                                    <span></span>
                                                </i>
                                                <span class="menu-text">Department</span>
                                            </a>
                                        </li>

                                        <li @if($segment2=='colors' ) class="menu-item menu-item-active" @else class="menu-item" @endif aria-haspopup="true">
                                            <a href="{{route('Color.index')}}" class="menu-link">
                                                <i class="menu-bullet menu-bullet-line">
                                                    <span></span>
                                                </i>
                                                <span class="menu-text">Color</span>
                                            </a>
                                        </li>

                                        <li @if($segment2=='sizes' ) class="menu-item menu-item-active" @else class="menu-item" @endif aria-haspopup="true">
                                            <a href="{{route('Size.index')}}" class="menu-link">
                                                <i class="menu-bullet menu-bullet-line">
                                                    <span></span>
                                                </i>
                                                <span class="menu-text">Size</span>
                                            </a>
                                        </li>

                                        <li @if($segment2=='brands' ) class="menu-item menu-item-active" @else class="menu-item" @endif aria-haspopup="true">
                                            <a href="{{route('Brand.index')}}" class="menu-link">
                                                <i class="menu-bullet menu-bullet-line">
                                                    <span></span>
                                                </i>
                                                <span class="menu-text">Brand</span>
                                            </a>
                                        </li>

                                    </ul>
                            </li>


                            <li class="menu-item menu-item-submenu
                              {{ in_array($segment2 ,array('cms-managers','email-templates','email-logs','seo-page-manager')) ? 
                                'menu-item-open' : '' }}" aria-haspopup="true" data-menu-toggle="hover">
                                <a href="javascript:;" class="menu-link menu-toggle">
                                    <span class="svg-icon menu-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24" />
                                                <rect fill="#000000" x="4" y="4" width="7" height="7" rx="1.5" />
                                                <path d="M5.5,13 L9.5,13 C10.3284271,13 11,13.6715729 11,14.5 L11,18.5 C11,19.3284271 10.3284271,20 9.5,20 L5.5,20 C4.67157288,20 4,19.3284271 4,18.5 L4,14.5 C4,13.6715729 4.67157288,13 5.5,13 Z M14.5,4 L18.5,4 C19.3284271,4 20,4.67157288 20,5.5 L20,9.5 C20,10.3284271 19.3284271,11 18.5,11 L14.5,11 C13.6715729,11 13,10.3284271 13,9.5 L13,5.5 C13,4.67157288 13.6715729,4 14.5,4 Z M14.5,13 L18.5,13 C19.3284271,13 20,13.6715729 20,14.5 L20,18.5 C20,19.3284271 19.3284271,20 18.5,20 L14.5,20 C13.6715729,20 13,19.3284271 13,18.5 L13,14.5 C13,13.6715729 13.6715729,13 14.5,13 Z" fill="#000000" opacity="0.3" />
                                            </g>
                                        </svg>
                                    </span>
                                    <span class="menu-text"> System Management</span>
                                    <i class="menu-arrow"></i>
                                </a>
                                <div class="menu-submenu">
                                    <i class="menu-arrow"></i>
                                    <ul class="menu-subnav">
                                        <li class="menu-item menu-item-parent" aria-haspopup="true">
                                            <span class="menu-link">
                                                <span class="menu-text"> System Management </span>
                                            </span>
                                        </li>

                                        <li @if($segment2=='cms-managers' ) class="menu-item menu-item-active" @else class="menu-item" @endif aria-haspopup="true">
                                            <a href="{{route('CmsPage.index')}}" class="menu-link">
                                                <i class="menu-bullet menu-bullet-line">
                                                    <span></span>
                                                </i>
                                                <span class="menu-text">Cms Page</span>
                                            </a>
                                        </li>

                                        <li @if($segment2=='email-templates' ) class="menu-item menu-item-active" @else class="menu-item" @endif aria-haspopup="true">
                                            <a href="{{route('EmailTemplate.index')}}" class="menu-link">
                                                <i class="menu-bullet menu-bullet-line">
                                                    <span></span>
                                                </i>
                                                <span class="menu-text">Email Template</span>
                                            </a>
                                        </li>

                                        <li @if($segment2=='email-logs' ) class="menu-item menu-item-active" @else class="menu-item" @endif aria-haspopup="true">
                                            <a href="{{route('EmailLog.index')}}" class="menu-link">
                                                <i class="menu-bullet menu-bullet-line">
                                                    <span></span>
                                                </i>
                                                <span class="menu-text">Email Log </span>
                                            </a>
                                        </li>

                                        <li @if($segment2=='seo-page-manager' ) class="menu-item menu-item-active" @else class="menu-item" @endif aria-haspopup="true">
                                            <a href="{{route('SeoPage.index')}}" class="menu-link">
                                                <i class="menu-bullet menu-bullet-line">
                                                    <span></span>
                                                </i>
                                                <span class="menu-text">Seo Page</span>
                                            </a>
                                        </li>

                                    </ul>
                            </li>

                            <li class="menu-item menu-item-submenu
                              {{ in_array($segment2 ,array('settings/prefix/Site','settings/prefix/Reading','settings/prefix/Socail','settings/prefix/Contact')) ? 
                                'menu-item-open' : '' }}" aria-haspopup="true" data-menu-toggle="hover">
                                <a href="javascript:;" class="menu-link menu-toggle">
                                    <span class="svg-icon menu-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24" />
                                                <path d="M5,8.6862915 L5,5 L8.6862915,5 L11.5857864,2.10050506 L14.4852814,5 L19,5 L19,9.51471863 L21.4852814,12 L19,14.4852814 L19,19 L14.4852814,19 L11.5857864,21.8994949 L8.6862915,19 L5,19 L5,15.3137085 L1.6862915,12 L5,8.6862915 Z M12,15 C13.6568542,15 15,13.6568542 15,12 C15,10.3431458 13.6568542,9 12,9 C10.3431458,9 9,10.3431458 9,12 C9,13.6568542 10.3431458,15 12,15 Z" fill="#000000" />
                                            </g>
                                        </svg>
                                    </span>
                                    <span class="menu-text"> Setting</span>
                                    <i class="menu-arrow"></i>
                                </a>
                                <div class="menu-submenu">
                                    <i class="menu-arrow"></i>
                                    <ul class="menu-subnav">  
                                        <li class="menu-item menu-item-parent" aria-haspopup="true">
                                            <span class="menu-link">
                                                <span class="menu-text"> Setting </span>
                                            </span>
                                        </li>

                                        <li @if($segment2=='settings' && Request::segment(3)=='Site' ) class="menu-item menu-item-active" @else class="menu-item" @endif aria-haspopup="true">
                                            <a href="{{URL::to('adminpnlx/settings/prefix/Site')}}" class="menu-link">
                                                <i class="menu-bullet menu-bullet-line">
                                                    <span></span>
                                                </i>
                                                <span class="menu-text">Site Setting</span>
                                            </a>
                                        </li>

                                        <li @if($segment2=='setting/reading' ) class="menu-item menu-item-active" @else class="menu-item" @endif aria-haspopup="true">
                                            <a href="{{route('settings.prefix', 'Reading')}}" class="menu-link">
                                                <i class="menu-bullet menu-bullet-line">
                                                    <span></span>
                                                </i>
                                                <span class="menu-text">Reading Setting</span>
                                            </a>
                                        </li>

                                        <li @if($segment2=='setting/social' ) class="menu-item menu-item-active" @else class="menu-item" @endif aria-haspopup="true">
                                            <a href="{{route('settings.prefix', 'Socail')}}" class="menu-link">
                                                <i class="menu-bullet menu-bullet-line">
                                                    <span></span>
                                                </i>
                                                <span class="menu-text">Socail Setting </span>
                                            </a>
                                        </li>

                                        <li @if($segment2=='setting/contacts' ) class="menu-item menu-item-active" @else class="menu-item" @endif aria-haspopup="true">
                                            <a href="{{route('settings.prefix', 'Contact')}}" class="menu-link">
                                                <i class="menu-bullet menu-bullet-line">
                                                    <span></span>
                                                </i>
                                                <span class="menu-text">Contact Setting</span>
                                            </a>
                                        </li>

                                    </ul>
                            </li>


                            <li class="menu-item  {{ ($segment2 == 'contact-enquiry') ? 'menu-item-active' : '' }}" aria-haspopup="true">
                                <a href="{{route('ContactEnquiry.index')}}" class="menu-link "><span class="svg-icon menu-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24" />
                                                <path d="M3.5,21 L20.5,21 C21.3284271,21 22,20.3284271 22,19.5 L22,8.5 C22,7.67157288 21.3284271,7 20.5,7 L10,7 L7.43933983,4.43933983 C7.15803526,4.15803526 6.77650439,4 6.37867966,4 L3.5,4 C2.67157288,4 2,4.67157288 2,5.5 L2,19.5 C2,20.3284271 2.67157288,21 3.5,21 Z" fill="#000000" opacity="0.3" />
                                                <path d="M12,13 C10.8954305,13 10,12.1045695 10,11 C10,9.8954305 10.8954305,9 12,9 C13.1045695,9 14,9.8954305 14,11 C14,12.1045695 13.1045695,13 12,13 Z" fill="#000000" opacity="0.3" />
                                                <path d="M7.00036205,18.4995035 C7.21569918,15.5165724 9.36772908,14 11.9907452,14 C14.6506758,14 16.8360465,15.4332455 16.9988413,18.5 C17.0053266,18.6221713 16.9988413,19 16.5815,19 C14.5228466,19 11.463736,19 7.4041679,19 C7.26484009,19 6.98863236,18.6619875 7.00036205,18.4995035 Z" fill="#000000" opacity="0.3" />
                                            </g>
                                        </svg>
                                    </span>
                                    <span class="menu-text">Contact Enquiry</span>
                                </a>
                            </li>

                            <li class="menu-item menu-item-submenu {{ in_array($segment2 ,array('language-setting')) ? 
                                'menu-item-open' : '' }}" aria-haspopup="true" data-menu-toggle="hover">
                                <a href="javascript:;" class="menu-link menu-toggle">
                                    <span class="svg-icon menu-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24" />
                                                <path d="M3.5,3 L5,3 L5,19.5 C5,20.3284271 4.32842712,21 3.5,21 L3.5,21 C2.67157288,21 2,20.3284271 2,19.5 L2,4.5 C2,3.67157288 2.67157288,3 3.5,3 Z" fill="#000000" />
                                                <path d="M6.99987583,2.99995344 L19.754647,2.99999303 C20.3069317,2.99999474 20.7546456,3.44771138 20.7546439,3.99999613 C20.7546431,4.24703684 20.6631995,4.48533385 20.497938,4.66895776 L17.5,8 L20.4979317,11.3310353 C20.8673908,11.7415453 20.8341123,12.3738351 20.4236023,12.7432941 C20.2399776,12.9085564 20.0016794,13 19.7546376,13 L6.99987583,13 L6.99987583,2.99995344 Z" fill="#000000" opacity="0.3" />
                                            </g>
                                        </svg>
                                    </span>
                                    <span class="menu-text"> Langauge Setting</span>
                                    <i class="menu-arrow"></i>
                                </a>
                                <div class="menu-submenu">
                                    <i class="menu-arrow"></i>
                                    <ul class="menu-subnav">
                                        <li class="menu-item menu-item-parent" aria-haspopup="true">
                                            <span class="menu-link">
                                                <span class="menu-text"> Langauge Setting </span>
                                            </span>
                                        </li>

                                        <li @if($segment2=='language-setting' ) class="menu-item menu-item-active" @else class="menu-item" @endif aria-haspopup="true">
                                            <a href="{{route('LanguageSetting.index')}}" class="menu-link">
                                                <i class="menu-bullet menu-bullet-line">
                                                    <span></span>
                                                </i>
                                                <span class="menu-text">Langauge Setting</span>
                                            </a>
                                        </li>
                                    </ul>
                            </li>
                        </ul> -->
                    </div>
                </div>
            </div>
            <!--end::Aside-->



            <!--begin::Wrapper-->
            <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
                <div id="kt_header" class="header  header-fixed ">
                    <div class=" container-fluid  d-flex align-items-stretch justify-content-between">
                        <!--begin::Topbar-->
                        <div class="topbar ml-auto">
                            <!--begin::User-->
                            <div class="dropdown ml-3">

                                <div class="topbar-item" data-toggle="dropdown" data-offset="10px,0px">
                                    <a href="#" class="d-flex align-items-center">
                                        @if(Auth::guard('admins')->user())
                                        <?php $login_user = Auth::guard('admins')->user()->first_name; ?>
                                        <div class="symbol symbol-30 symbol-circle symbol-primary mr-2">
                                            <span class="symbol-label">{{ucfirst( substr($login_user ,0,1) ) }}</span>
                                        </div>
                                        @endif
                                        <div class="d-flex flex-column text-left">
                                            @if(Auth::guard('admins')->user())
                                            <span class="text-muted font-weight-bold">Welcome</span>
                                            <span class="text-primary font-weight-bold">
                                                <?php $login_user = Auth::guard('admins')->user()->first_name; ?>
                                                {{ucfirst( $login_user ) }} </span>
                                            @endif
                                        </div>
                                    </a>
                                </div>
                                <!--begin::Dropdown-->
                                <div class="dropdown-menu p-0 m-0 dropdown-menu-right dropdown-menu-anim-up dropdown-menu-lg">
                                    <!--begin:Header-->
                                    <div class="d-flex flex-column flex-center py-10 bgi-size-cover bgi-no-repeat rounded-top" style="background-image: url(bg-1.jpg)">
                                        <h4 class="text-white font-weight-bold mb-0">
                                            Quick Actions
                                        </h4>
                                    </div>
                                    <!--end:Header-->

                                    <!--begin:Nav-->
                                    <div class="row row-paddingless">
                                        <!--begin:Item-->
                                        <div class="col-6">
                                            <a href="{{route('myAccount')}}" class="d-block py-6 px-5 text-center bg-hover-light border-right border-bottom">
                                                <span class="svg-icon svg-icon-3x svg-icon-success">
                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                            <rect x="0" y="0" width="24" height="24" />
                                                            <path d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) " />
                                                            <rect fill="#000000" opacity="0.3" x="5" y="20" width="15" height="2" rx="1" />
                                                        </g>
                                                    </svg>
                                                    <!--end::Svg Icon-->
                                                </span>
                                                <span class="d-block text-dark-75 font-weight-bold font-size-h10 mt-2 mb-1">Edit Profile</span>
                                            </a>
                                        </div>
                                        <!--end:Item-->

                                        <!--begin:Item-->
                                        <div class="col-6">
                                            <a href="{{route('Admin.changePassword')}}" class="d-block py-6 px-5 text-center bg-hover-light border-right border-bottom">
                                                <span class="svg-icon svg-icon-3x svg-icon-success">
                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                            <rect x="0" y="0" width="24" height="24" />
                                                            <path d="M7.38979581,2.8349582 C8.65216735,2.29743306 10.0413491,2 11.5,2 C17.2989899,2 22,6.70101013 22,12.5 C22,18.2989899 17.2989899,23 11.5,23 C5.70101013,23 1,18.2989899 1,12.5 C1,11.5151324 1.13559454,10.5619345 1.38913364,9.65805651 L3.31481075,10.1982117 C3.10672013,10.940064 3,11.7119264 3,12.5 C3,17.1944204 6.80557963,21 11.5,21 C16.1944204,21 20,17.1944204 20,12.5 C20,7.80557963 16.1944204,4 11.5,4 C10.54876,4 9.62236069,4.15592757 8.74872191,4.45446326 L9.93948308,5.87355717 C10.0088058,5.95617272 10.0495583,6.05898805 10.05566,6.16666224 C10.0712834,6.4423623 9.86044965,6.67852665 9.5847496,6.69415008 L4.71777931,6.96995273 C4.66931162,6.97269931 4.62070229,6.96837279 4.57348157,6.95710938 C4.30487471,6.89303938 4.13906482,6.62335149 4.20313482,6.35474463 L5.33163823,1.62361064 C5.35654118,1.51920756 5.41437908,1.4255891 5.49660017,1.35659741 C5.7081375,1.17909652 6.0235153,1.2066885 6.2010162,1.41822583 L7.38979581,2.8349582 Z" fill="#000000" opacity="0.3" />
                                                            <path d="M14.5,11 C15.0522847,11 15.5,11.4477153 15.5,12 L15.5,15 C15.5,15.5522847 15.0522847,16 14.5,16 L9.5,16 C8.94771525,16 8.5,15.5522847 8.5,15 L8.5,12 C8.5,11.4477153 8.94771525,11 9.5,11 L9.5,10.5 C9.5,9.11928813 10.6192881,8 12,8 C13.3807119,8 14.5,9.11928813 14.5,10.5 L14.5,11 Z M12,9 C11.1715729,9 10.5,9.67157288 10.5,10.5 L10.5,11 L13.5,11 L13.5,10.5 C13.5,9.67157288 12.8284271,9 12,9 Z" fill="#000000" />
                                                        </g>
                                                    </svg>
                                                    <!--end::Svg Icon-->
                                                </span> <span class="d-block text-dark-75 font-weight-bold font-size-h10 mt-2 mb-1">Change Password</span>
                                            </a>
                                        </div>
                                        <!--end:Item-->

                                        <!--begin:Item-->
                                        <div class="col-12">
                                            <a href="{{route('Admin.logout')}}" class="d-block py-6 px-5 text-center bg-hover-light border-bottom">
                                                <span class="svg-icon svg-icon-3x svg-icon-success">
                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                            <rect x="0" y="0" width="24" height="24" />
                                                            <path d="M14.0069431,7.00607258 C13.4546584,7.00607258 13.0069431,6.55855153 13.0069431,6.00650634 C13.0069431,5.45446114 13.4546584,5.00694009 14.0069431,5.00694009 L15.0069431,5.00694009 C17.2160821,5.00694009 19.0069431,6.7970243 19.0069431,9.00520507 L19.0069431,15.001735 C19.0069431,17.2099158 17.2160821,19 15.0069431,19 L3.00694311,19 C0.797804106,19 -0.993056895,17.2099158 -0.993056895,15.001735 L-0.993056895,8.99826498 C-0.993056895,6.7900842 0.797804106,5 3.00694311,5 L4.00694793,5 C4.55923268,5 5.00694793,5.44752105 5.00694793,5.99956624 C5.00694793,6.55161144 4.55923268,6.99913249 4.00694793,6.99913249 L3.00694311,6.99913249 C1.90237361,6.99913249 1.00694311,7.89417459 1.00694311,8.99826498 L1.00694311,15.001735 C1.00694311,16.1058254 1.90237361,17.0008675 3.00694311,17.0008675 L15.0069431,17.0008675 C16.1115126,17.0008675 17.0069431,16.1058254 17.0069431,15.001735 L17.0069431,9.00520507 C17.0069431,7.90111468 16.1115126,7.00607258 15.0069431,7.00607258 L14.0069431,7.00607258 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(9.006943, 12.000000) scale(-1, 1) rotate(-90.000000) translate(-9.006943, -12.000000) " />
                                                            <rect fill="#000000" opacity="0.3" transform="translate(14.000000, 12.000000) rotate(-270.000000) translate(-14.000000, -12.000000) " x="13" y="6" width="2" height="12" rx="1" />
                                                            <path d="M21.7928932,9.79289322 C22.1834175,9.40236893 22.8165825,9.40236893 23.2071068,9.79289322 C23.5976311,10.1834175 23.5976311,10.8165825 23.2071068,11.2071068 L20.2071068,14.2071068 C19.8165825,14.5976311 19.1834175,14.5976311 18.7928932,14.2071068 L15.7928932,11.2071068 C15.4023689,10.8165825 15.4023689,10.1834175 15.7928932,9.79289322 C16.1834175,9.40236893 16.8165825,9.40236893 17.2071068,9.79289322 L19.5,12.0857864 L21.7928932,9.79289322 Z" fill="#000000" fill-rule="nonzero" transform="translate(19.500000, 12.000000) rotate(-90.000000) translate(-19.500000, -12.000000) " />
                                                        </g>
                                                    </svg>
                                                    <!--end::Svg Icon-->
                                                </span> <span class="d-block text-dark-75 font-weight-bold font-size-h10 mt-2 mb-1">Logout</span>
                                            </a>
                                        </div>
                                        <!--end:Item-->

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Topbar-->
                    </div>
                    <!--end::Container-->
                </div>
                <!--end::Header-->


                @if(Session::has('error'))
                <script type="text/javascript">
                    $(document).ready(function(e) {

                        show_message("{{{ Session::get('error') }}}", 'error');
                    });
                </script>
                @endif

                @if(Session::has('success'))
                <script type="text/javascript">
                    $(document).ready(function(e) {
                        show_message("{{{ Session::get('success') }}}", 'success');
                    });
                </script>
                @endif

                @if(Session::has('flash_notice'))
                <script type="text/javascript">
                    $(document).ready(function(e) {
                        show_message("{{{ Session::get('flash_notice') }}}", 'success');
                    });
                </script>
                @endif

                @yield('content')


                <!--begin::Footer-->
                <div class="footer bg-white py-4 d-flex flex-lg-column " id="kt_footer">
                    <div class=" container-fluid  d-flex flex-column flex-md-row align-items-center justify-content-between">
                        <div class="text-dark order-2 order-md-1">
                            <span class="text-muted font-weight-bold mr-2">{{date("Y")}}&copy;</span>
                            <a href="" target="_blank" class="text-dark-75 text-hover-primary">{{{Config::get("Site.title")}}}</a>
                        </div>
                        <div class="nav nav-dark">
                        </div>
                    </div>
                </div>
                <!--end::Footer-->


            </div>
        </div>
    </div>
    <!--end::Main-->

    <!--begin::Scrolltop-->
    <div id="kt_scrolltop" class="scrolltop">
        <span class="svg-icon">
            <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Up-2.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <polygon points="0 0 24 0 24 24 0 24" />
                    <rect fill="#000000" opacity="0.3" x="11" y="10" width="2" height="10" rx="1" />
                    <path d="M6.70710678,12.7071068 C6.31658249,13.0976311 5.68341751,13.0976311 5.29289322,12.7071068 C4.90236893,12.3165825 4.90236893,11.6834175 5.29289322,11.2928932 L11.2928932,5.29289322 C11.6714722,4.91431428 12.2810586,4.90106866 12.6757246,5.26284586 L18.6757246,10.7628459 C19.0828436,11.1360383 19.1103465,11.7686056 18.7371541,12.1757246 C18.3639617,12.5828436 17.7313944,12.6103465 17.3242754,12.2371541 L12.0300757,7.38413782 L6.70710678,12.7071068 Z" fill="#000000" fill-rule="nonzero" />
                </g>
            </svg>
            <!--end::Svg Icon-->
        </span>
    </div>
    <!--end::Scrolltop-->

    <script>
        $(document).ready(function() {
            $('#datepickerfrom').datetimepicker({
                format: 'YYYY-MM-DD'
            });
            $('#datepickerto').datetimepicker({
                format: 'YYYY-MM-DD'
            });

            $(".confirmDelete").click(function(e) {
                e.stopImmediatePropagation();
                url = $(this).attr('href');
                Swal.fire({
                    title: "Are you sure?",
                    text: "Want to delete this ?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, delete it",
                    cancelButtonText: "No, cancel",
                    reverseButtons: true
                }).then(function(result) {
                    if (result.value) {
                        window.location.replace(url);
                    } else if (result.dismiss === "cancel") {
                        Swal.fire(
                            "Cancelled",
                            "Your imaginary file is safe :)",
                            "error"
                        )
                    }
                });
                e.preventDefault();
            });

            $(".status_any_item").click(function(e) {
                e.stopImmediatePropagation();
                url = $(this).attr('href');
                Swal.fire({
                    title: "Are you sure?",
                    text: "Want to change status this ?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, change it",
                    cancelButtonText: "No, cancel",
                    reverseButtons: true
                }).then(function(result) {
                    if (result.value) {
                        window.location.replace(url);
                    }
                });
                e.preventDefault();
            });
        });
    </script>


    <script>
        var HOST_URL = "";
    </script>
    <!--begin::Global Config(global config for global JS scripts)-->
    <script>
        var KTAppSettings = {
            "breakpoints": {
                "sm": 576,
                "md": 768,
                "lg": 992,
                "xl": 1200,
                "xxl": 1400
            },
            "colors": {
                "theme": {
                    "base": {
                        "white": "#ffffff",
                        "primary": "#3699FF",
                        "secondary": "#E5EAEE",
                        "success": "#1BC5BD",
                        "info": "#8950FC",
                        "warning": "#FFA800",
                        "danger": "#F64E60",
                        "light": "#E4E6EF",
                        "dark": "#181C32"
                    },
                    "light": {
                        "white": "#ffffff",
                        "primary": "#E1F0FF",
                        "secondary": "#EBEDF3",
                        "success": "#C9F7F5",
                        "info": "#EEE5FF",
                        "warning": "#FFF4DE",
                        "danger": "#FFE2E5",
                        "light": "#F3F6F9",
                        "dark": "#D6D6E0"
                    },
                    "inverse": {
                        "white": "#ffffff",
                        "primary": "#ffffff",
                        "secondary": "#3F4254",
                        "success": "#ffffff",
                        "info": "#ffffff",
                        "warning": "#ffffff",
                        "danger": "#ffffff",
                        "light": "#464E5F",
                        "dark": "#ffffff"
                    }
                },
                "gray": {
                    "gray-100": "#F3F6F9",
                    "gray-200": "#EBEDF3",
                    "gray-300": "#E4E6EF",
                    "gray-400": "#D1D3E0",
                    "gray-500": "#B5B5C3",
                    "gray-600": "#7E8299",
                    "gray-700": "#5E6278",
                    "gray-800": "#3F4254",
                    "gray-900": "#181C32"
                }
            },
            "font-family": "Poppins"
        };
    </script>


</body>

</html>