<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>514 管理後台</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-reset.css">
    <!--external css-->
    <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.css"/>
    <link rel="stylesheet" href="assets/fullcalendar/fullcalendar/bootstrap-fullcalendar.css"/>
    <link rel="stylesheet" type="text/css" href="assets/jquery-easy-pie-chart/jquery.easy-pie-chart.css" media="screen"/>
    <link rel="stylesheet" type="text/css" href="css/owl.carousel.css">
    <!--  right slidebar -->
    <link rel="stylesheet" href="css/slidebars.css">
    <!-- Custom styles for this template -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/style-responsive.css"/>
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}

</head>
<body id="app-layout">

    @include('admin.partials.header')

    @include('admin.partials.siderbar')

    @yield('content')

    @include('admin.partials.footer')

    <!-- js placed at the end of the document so the pages load faster -->
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/jquery-ui-1.9.2.custom.min.js"></script>
    <!--right slidebar-->
    <script type="text/javascript" src="js/slidebars.min.js"></script>
    <script type="text/javascript" src="js/jquery.dcjqaccordion.2.7.js"></script>

    <!-- scroll -->
    <script type="text/javascript" src="js/jquery.scrollTo.min.js"></script>
    <script type="text/javascript" src="js/jquery.nicescroll.js"></script>

    <!-- analysis -->
    <!-- <script type="text/javascript" src="js/jquery.sparkline.js"></script> -->
    <!-- <script type="text/javascript" src="assets/jquery-easy-pie-chart/jquery.easy-pie-chart.js"></script> -->

    <script type="text/javascript" src="assets/fullcalendar/fullcalendar/fullcalendar.min.js"></script>

    <!-- slider -->
    <!-- <script type="text/javascript" src="js/owl.carousel.js" ></script> -->

    <!--common script for all pages-->
    <script type="text/javascript" src="js/common-scripts.js"></script>
    <!--script for this page only-->
    <script type="text/javascript" src="js/external-dragging-calendar.js"></script>

</body>
</html>
