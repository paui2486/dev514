<!DOCTYPE html>
<html lang="zh-Hant-TW">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>514 管理後台</title>

        <!-- Bootstrap core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/bootstrap-reset.css" rel="stylesheet">
        <!--external css-->
        <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
        <!-- <link href="assets/jquery-easy-pie-chart/jquery.easy-pie-chart.css" rel="stylesheet" type="text/css" media="screen"/> -->
        <!-- <link rel="stylesheet" href="css/owl.carousel.css" type="text/css"> -->

          <!--right slidebar-->
          <link href="css/slidebars.css" rel="stylesheet">

        <!-- Custom styles for this template -->

        <link href="css/style.css" rel="stylesheet">
        <link href="css/style-responsive.css" rel="stylesheet" />

    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/bootstrap-reset.css')}}">
    <link rel="stylesheet" href="{{asset('assets/font-awesome/css/font-awesome.css')}}">
    <link rel="stylesheet" href="{{asset('css/slidebars.css')}}">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" href="{{asset('css/style-responsive.css')}}">
    @yield('style')
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}

</head>
<body id="app-layout">

    @include('admin.partials.header')

    @include('admin.partials.siderbar')

    @yield('content')

    @include('admin.partials.footer')

    <!-- js placed at the end of the document so the pages load faster -->
    <script type="text/javascript" src="{{asset('js/jquery.js')}}"></script>
    <!-- <script type="text/javascript" src="{{asset('js/jquery-ui-1.9.2.custom.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/jquery-migrate-1.2.1.min.js')}}"></script> -->
    <script type="text/javascript" src="{{asset('js/bootstrap.min.js')}}"></script>

    <!-- <script type="text/javascript" src="{{asset('js/jquery.dcjqaccordion.2.7.js')}}"></script> -->
    <script type="text/javascript" src="{{asset('js/slidebars.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/coevo-0.0.1.js')}}"></script>
    <!-- <script src="{{asset('js/common-scripts.js')}}"></script> -->

    <script>
    window.fbAsyncInit = function() {
    FB.init({
        appId      : '{{ env("FACEBOOK_CLIENT_ID") }}',
        xfbml      : true,
        version    : 'v2.5'
        });
    };
    </script>

    @yield('scripts')

</body>
</html>
