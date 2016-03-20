<!DOCTYPE html>
<html lang="zh-Hant-TW">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>514 管理後台</title>

    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/bootstrap-reset.css')}}"/>
    <!--external css-->
    <link rel="stylesheet" href="{{asset('assets/font-awesome/css/font-awesome.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/fullcalendar/fullcalendar/bootstrap-fullcalendar.css')}}"/>
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="{{asset('css/datatables.min.css')}}"/>
    <!-- <link rel="stylesheet" href="{{asset('css/jquery.dataTables.min.css')}}"/> -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/jquery-easy-pie-chart/jquery.easy-pie-chart.css')}}" media="screen"/>
    <link rel="stylesheet" type="text/css" href="{{asset('css/owl.carousel.css')}}"/>
    <!-- Data Range Picker -->
    <link rel="stylesheet" type="text/css" href="{{asset('css/daterangepicker.css')}}" />
    <!--  Right slidebar -->
    <link rel="stylesheet" href="{{asset('css/slidebars.css')}}"/>
    <!-- ColorBox CSS -->
    <link rel="stylesheet" href="{{asset('css/colorbox.css')}}"/>
    <!-- Custom styles for this template -->
    @yield('style')
    <link rel="stylesheet" href="{{asset('css/style.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/style-responsive.css')}}"/>
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}

</head>
<body id="app-layout">

    @include('admin.partials.header')

    @include('admin.partials.siderbar')

    @yield('content')

    @include('admin.partials.footer')

    <!-- js placed at the end of the document so the pages load faster -->
    <script type="text/javascript" src="{{asset('js/jquery.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/jquery-ui-1.9.2.custom.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/jquery-migrate-1.2.1.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/bootstrap.min.js')}}"></script>
    <!-- editor -->
    <script type="text/javascript" src="{{asset('assets/ckeditor/ckeditor.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/ckfinder/ckfinder.js')}}"></script>
    <!-- <script type="text/javascript" src="{{asset('assets/tinymce/tinymce.min.js')}}"></script> -->

    <!--right slidebar-->
    <script type="text/javascript" src="{{asset('js/slidebars.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/jquery.dcjqaccordion.2.7.js')}}"></script>

    <!-- scroll -->
    <script type="text/javascript" src="{{asset('js/jquery.scrollTo.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/jquery.nicescroll.js')}}"></script>

    <!-- analysis -->
    <script type="text/javascript" src="{{asset('js/jquery.sparkline.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/jquery-easy-pie-chart/jquery.easy-pie-chart.js')}}"></script>

    <!-- DataTables -->
    <script type="text/javascript" src="{{asset('js/datatables.min.js')}}"></script>
    <!-- <script type="text/javascript" src="{{asset('assets/data-tables/DT_bootstrap.js')}}"></script> -->
    <script type="text/javascript" src="{{asset('js/jquery.colorbox.js')}}"></script>

    <!-- Data Range Picker -->
    <script type="text/javascript" src="{{asset('js/moment.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/daterangepicker.js')}}"></script>

    <!-- tagsinput -->
    <script type="text/javascript" src="{{asset('js/jquery.tagsinput.js')}}"></script>
    <!-- Inputmask -->
    <script type="text/javascript" src="{{asset('assets/bootstrap-inputmask/bootstrap-inputmask.min.js')}}"></script>

    <script type="text/javascript" src="{{asset('assets/fullcalendar/fullcalendar/fullcalendar.min.js')}}"></script>

    <!-- slider -->
    <script type="text/javascript" src="{{asset('js/owl.carousel.js')}}" ></script>

    <!--common script for all pages-->
    <script type="text/javascript" src="{{asset('js/common-scripts.js')}}"></script>
    <!--script for this page only-->
    <script type="text/javascript" src="{{asset('js/external-dragging-calendar.js')}}"></script>
    @yield('scripts')

</body>
</html>
