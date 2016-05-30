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
    <style>
    .actpage-introduce {
        position: relative;
    }

    .actpage-introduce iframe {
        display:block;
        width:100%;
        height:auto;
        min-height: 260px;
    }
    </style>
    <style>
         #ad_root {
            font-size: 14px;
            height: 250px;
            line-height: 16px;
            position: relative;
            width: 300px;
          }

          .thirdPartyMediaClass {
            height: 157px;
            width: 300px;
          }

          .thirdPartyTitleClass {
            font-weight: 600;
            font-size: 16px;
            margin: 8px 0 4px 0;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
          }

          .thirdPartyBodyClass {
            display: -webkit-box;
            height: 32px;
            -webkit-line-clamp: 2;
            overflow: hidden;
          }

          .thirdPartyCallToActionClass {
            color: #326891;
            font-family: sans-serif;
            font-weight: 600;
            margin-top: 8px;
          }
    </style>
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
    <script>
        window.fbAsyncInit = function() {
            FB.Event.subscribe(
              'ad.loaded',
              function(placementId) {
                  console.log('Audience Network ad loaded');
                  document.getElementById('ad_root').style.display = 'block';
              }
            );
            FB.Event.subscribe(
                'ad.error',
                function(errorCode, errorMessage, placementId) {
                    console.log('Audience Network error (' + errorCode + ') ' + errorMessage);
                }
            );
        };
        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/en_US/sdk/xfbml.ad.js#xfbml=1&version=v2.5&appId={{ env('FACEBOOK_CLIENT_ID') }}";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>
    <style>
       #ad_root {
          display: none;
          font-size: 14px;
          height: 250px;
          line-height: 16px;
          position: relative;
          width: 300px;
        }
        .thirdPartyMediaClass {
          height: 157px;
          width: 300px;
        }
        .thirdPartyTitleClass {
          font-weight: 600;
          font-size: 16px;
          margin: 8px 0 4px 0;
          overflow: hidden;
          text-overflow: ellipsis;
          white-space: nowrap;
        }
        .thirdPartyBodyClass {
          display: -webkit-box;
          height: 32px;
          -webkit-line-clamp: 2;
          overflow: hidden;
        }
        .thirdPartyCallToActionClass {
          color: #326891;
          font-family: sans-serif;
          font-weight: 600;
          margin-top: 8px;
        }
      </style>
    {{--*/
        $header = (Request::is('/')) ? 'partials.header' : 'partials.page-header';
    /*--}}

    @include($header)

    @yield('banner')
    <fb:ad placementid="{{ env('FACEBOOK_PLACEMENT_ID','509598299165169_540528149405517') }}" format="native" testmode="false"></fb:ad>

    @yield('content')
    <div class="fb-ad" data-placementid="{{ env('FACEBOOK_PLACEMENT_ID','509598299165169_540528149405517') }}" data-format="native" data-nativeadid="ad_root" data-testmode="false"></div>
    <div id="ad_root">
      <a class="fbAdLink">
        <div class="fbAdMedia thirdPartyMediaClass"></div>
        <div class="fbAdTitle thirdPartyTitleClass"></div>
        <div class="fbAdBody thirdPartyBodyClass"></div>
        <div class="fbAdCallToAction thirdPartyCallToActionClass"></div>
      </a>
    </div>
    @include('partials.footer')

    <script type="text/javascript" src="/js/jquery.js"></script>
    <script type="text/javascript" src="/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/js/jssor.slider.mini.js"></script>
    <script type="text/javascript" src="/js/jquery.validate.js"></script>
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

        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-72845688-2', 'auto');
        ga('send', 'pageview');

        window.fbAsyncInit = function() {
            FB.init({
                appId      : '{{ env("FACEBOOK_CLIENT_ID") }}',
                xfbml      : true,
                version    : 'v2.6'
            });
        };

        (function(d, s, id){
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {return;}
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/zh_TW/all.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>
    <script type="text/javascript">
    $('.smobitrigger').smplmnu();
    $(function(){
        $.slidebars();

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

        $("#subscribe").click(function(){
            $.ajax({
                 type: "get",
                 url: "{{ URL('subscribes/add') }}",
                 data: {
                    'email' : $('input[name=email]').val()
                 },
                 success: function(data) {
                    alert(data['result']);
                 }
            });
            return false;
        });

        var RightFixed = $("#FilterFixed");
        $(window).scroll(function() {
            if ( $(this).scrollTop() > 150){
                $('.gotop-mb').fadeIn("fast");
            } else {
                $('.gotop-mb').stop().fadeOut("fast");
            }
        });

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
