<!DOCTYPE html>
<html lang="zh-Hant-TW">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @yield('meta')

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="/css/bootstrap-reset.css"/>
    <!--external css-->
    <link rel="stylesheet" href="/assets/font-awesome/css/font-awesome.css"/>
    <link rel="stylesheet" href="/assets/jquery-easy-pie-chart/jquery.easy-pie-chart.css" media="screen"/>
    <link rel="stylesheet" href="/css/owl.carousel.css"/>
    <!--  right slidebar -->
    <link rel="stylesheet" href="/css/slidebars.css"/>
    <!-- Custom styles for this template -->
    <link rel="stylesheet" type="text/css" href="/css/ionicons.min.css">
  	<link rel="stylesheet" type="text/css" href="/css/simpleMobileMenu.css" />
    @yield('style')
    <link rel="stylesheet" href="/css/style.css"/>
    <link rel="stylesheet" href="/css/style-responsive.css"/>
    <link rel="stylesheet" href="/css/project.css"/>
    <link rel="stylesheet" href="/css/mobile.css"/>
    {{-- <link rel="stylesheet" href="{{ elixir('css/app.css') }}"> --}}
</head>
<body id="app-layout">
    <!-- Google Tag Manager -->
    <noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-5ZKFLX"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    '//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-5ZKFLX');</script>
    <!-- End Google Tag Manager -->

    {{--*/
        $header = (Request::is('/')) ? 'partials.header' : 'partials.page-header';
    /*--}}

    @include($header)

    @yield('banner')

    @yield('content')

    @include('partials.footer')

    <script type="text/javascript" src="/js/jquery.js"></script>
    <script type="text/javascript" src="/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/js/jssor.slider.mini.js"></script>
    <script type="text/javascript" src="/js/jquery.dcjqaccordion.2.7.js"></script>
    <script type="text/javascript" src="/js/jquery.scrollTo.min.js"></script>
    <script type="text/javascript" src="/js/jquery.nicescroll.js"></script>
    <script type="text/javascript" src="/js/owl.carousel.js"></script>
  	<script type="text/javascript" src="/js/simpleMobileMenu.js"></script>
    <script type="text/javascript" src="/js/slidebars.min.js"></script>
{{--     <script type="text/javascript" src="{{ elixir('js/app.js') }}"></script> --}}
    <script>
        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-36251023-1']);
        _gaq.push(['_setDomainName', 'jqueryscript.net']);
        _gaq.push(['_trackPageview']);

        (function() {
          var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
          ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
          var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
        })();
        window.fbAsyncInit = function() {
        FB.init({
            appId      : '{{ env("FACEBOOK_CLIENT_ID") }}',
            xfbml      : true,
            version    : 'v2.5'
            });
        };

        (function(d, s, id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));

        $(function(){
            $('.smobitrigger').smplmnu();
            $.slidebars();
        });

        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-72845688-2', 'auto');
        ga('send', 'pageview');
    </script>
    <script type="text/javascript">
    $(function(){
        $(".gotop").click(function(){
            jQuery("html,body").animate({
                scrollTop:0
            },1000);
        });
        $(window).scroll(function() {
            if ( $(this).scrollTop() > 300){
                $('.gotop').fadeIn("fast");
            } else {
                $('.gotop').stop().fadeOut("fast");
            }
        });
        $(".gotop-mb").click(function(){
            jQuery("html,body").animate({
                scrollTop:0
            },1000);
        });
        $(window).scroll(function() {
            if ( $(this).scrollTop() > 150){
                $('.gotop-mb').fadeIn("fast");
            } else {
                $('.gotop-mb').stop().fadeOut("fast");
            }
        });
    });
    </script>
    <script>
        $(document).ready(function () {
        var RightFixed = $("#FilterFixed");
        $(window).scroll(function () {
            if ($(this).scrollTop() >470) {
                RightFixed.addClass("FilterFixed");
            } else {
                RightFixed.removeClass("FilterFixed");
            }
            });
        });
    </script>


    @yield('script')

</body>
</html>
