<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Fashi Template">
    <meta name="keywords" content="Fashi, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> @yield('title') </title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Muli:300,400,500,600,700,800,900&display=swap" rel="stylesheet">

    <!-- Css Styles --> 
    <link rel="stylesheet" href="{{asset('public/css/bootstrap.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('public/css/font-awesome.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('public/css/themify-icons.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('public/css/elegant-icons.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('public/css/owl.carousel.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('public/css/nice-select.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('public/css/jquery-ui.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('public/css/slicknav.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('public/css/style.css')}}" type="text/css">
</head>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div> 
  
  
   
    <!-- Header Section Begin -->
    @include('fashi.elements.header')
    <!-- Header End --> 


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
    <!-- Header Section Begin -->

    <!-- Footer End -->
    @include('fashi.elements.footer')
    <!-- Js Plugins -->
    <script src="{{asset('public/js/jquery-3.3.1.min.js')}}"></script>
    <script src="{{asset('public/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('public/js/jquery-ui.min.js')}}"></script>
    <script src="{{asset('public/js/jquery.countdown.min.js')}}"></script>
    <script src="{{asset('public/js/jquery.nice-select.min.js')}}"></script>
    <script src="{{asset('public/js/jquery.zoom.min.js')}}"></script>
    <script src="{{asset('public/js/jquery.dd.min.js')}}"></script>
    <script src="{{asset('public/js/jquery.slicknav.js')}}"></script>
    <script src="{{asset('public/js/owl.carousel.min.js')}}"></script>
    <script src="{{asset('public/js/main.js')}}"></script>
</body>

</html>