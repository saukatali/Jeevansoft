<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
    <base href="">
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Eccom</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <!--end::Fonts-->

 <!--begin::Fonts-->
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






    <div class="d-flex flex-column flex-root">
        <div class="d-flex flex-row flex-column-fluid page">

            <!--begin::Wrapper-->
            <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">

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

            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->
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