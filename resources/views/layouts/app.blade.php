<!DOCTYPE html>
<html lang="zh-Hant-TW">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @yield('meta')

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
    <link rel="stylesheet" type="text/css" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
	<link rel="stylesheet" type="text/css" href="/css/simpleMobileMenu.css" />
    @yield('style')

    <link rel="stylesheet" href="{{asset('css/style.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/style-responsive.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/project.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/mobile.css')}}"/>
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

    <!-- JavaScripts -->
    <script type="text/javascript" src="{{asset('js/jquery.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/jssor.slider.mini.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/jquery.dcjqaccordion.2.7.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/jquery.scrollTo.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/jquery.nicescroll.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/owl.carousel.js')}}"></script>
	<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="{{asset('js/simpleMobileMenu.js')}}"></script>
	<script type="text/javascript">

		jQuery(document).ready(function($) {
			$('.smobitrigger').smplmnu();
		});

	</script>
    <script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-36251023-1']);
  _gaq.push(['_setDomainName', 'jqueryscript.net']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

    </script>
    <!--right slidebar-->
    <script src=" {{asset('js/slidebars.min.js')}}"></script>
{{--     <script type="text/javascript" src="{{ elixir('js/app.js') }}"></script> --}}
    <script>
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
            $.slidebars();
        });
    </script>

    @yield('script')

</body>
</html>
