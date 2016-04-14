<!DOCTYPE html>
<html lang="zh-Hant-TW">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>514 後台管理系統</title>
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/bootstrap-reset.css')}}">
    <link rel="stylesheet" href="{{asset('assets/font-awesome/css/font-awesome.css')}}">
    <link rel="stylesheet" href="{{asset('css/nprogress.css') }}">
    <link rel="stylesheet" href="{{asset('css/slidebars.css')}}">
    @yield('style')
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" href="{{asset('css/style-responsive.css')}}">
</head>

<body id="514Admin">

    @include('admin.partials.header')

    @include('admin.partials.siderbar')

    @yield('content')

    @include('admin.partials.footer')

    <script type="text/javascript" src="{{ asset('js/jquery-2.2.2.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery-ui-1.9.2.custom.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery-migrate-1.2.1.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.pjax.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/nprogress.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/slidebars.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/moment.min.js') }}"></script>
    <script>
        window.fbAsyncInit = function() {
            FB.init({
                appId : '{{ env("FACEBOOK_CLIENT_ID") }}',
                xfbml : true,
                version : 'v2.5',
            });
        };
    </script>
    @yield('scripts')
    <script type="text/javascript" src="{{ asset('js/coevo-0.0.1.js') }}"></script>

</body>
</html>
