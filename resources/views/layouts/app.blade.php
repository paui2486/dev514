<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @yield('meta')

    <title>514生活頻道 - 讓生活更有意思</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/bootstrap-reset.css')}}"/>
    <!--external css-->
    <link rel="stylesheet" href="{{asset('assets/font-awesome/css/font-awesome.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/jquery-easy-pie-chart/jquery.easy-pie-chart.css')}}" media="screen"/>
    <link rel="stylesheet" href="{{asset('css/owl.carousel.css')}}"/>
    <!--  right slidebar -->
    <link rel="stylesheet" href="{{asset('css/slidebars.css')}}"/>
    <!-- Custom styles for this template -->
    @yield('style')
    
    <link rel="stylesheet" href="{{asset('css/style.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/style-responsive.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/project.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/mobile.css')}}"/>
    {{-- <link rel="stylesheet" href="{{ elixir('css/app.css') }}"> --}}

</head>
<body id="app-layout">

    {{--*/
        $header = (Request::is('/')) ? 'partials.header' : 'partials.page-header';
    /*--}}

    @include($header)

    @yield('banner')

    @yield('content')

    @include('partials.footer')

    <!-- JavaScripts -->
    <script type="text/javascript" src="{{asset('js/jquery.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/jssor.slider.mini.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/jquery.dcjqaccordion.2.7.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/jquery.scrollTo.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/jquery.nicescroll.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/jquery.sparkline.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/jquery-easy-pie-chart/jquery.easy-pie-chart.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/owl.carousel.js')}}"></script>
    <!--right slidebar-->
    <!--common script for all pages-->
<!--    <script type="text/javascript" src="{{asset('js/common-scripts.js')}}"></script>-->
    <!--script for this page only-->
    <script type="text/javascript" src="{{asset('js/sparkline-chart.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/easy-pie-chart.js')}}"></script>
{{--     <script type="text/javascript" src="{{ elixir('js/app.js') }}"></script> --}}

    @yield('script')

</body>
</html>
