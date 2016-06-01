@extends('layouts.blog')
@section('meta')
    <title>514文章專區</title>
@endsection
@section('script')
<!-- #region Jssor Slider Begin -->
    <!-- Generated by Jssor Slider Maker Online. -->
    <!-- This demo works with jquery library -->

    <script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="js/jssor.slider.mini.js"></script>
    <!-- use jssor.slider.debug.js instead for debug -->

    <script>

        jQuery(document).ready(function ($) {

            var _SlideshowTransitions = [
            //Fade
            { $Duration: 1200, $Opacity: 2 }
            ];

            var options = {
                $AutoPlay: true,
                $AutoPlaySteps: 1,
                $PauseOnHover: 1,
                $ArrowKeyNavigation: true,
                $SlideDuration: 500,
                $MinDragOffsetToSlide: 20,
                $SlideSpacing: 0,
                $Cols: 1,
                $ParkingPosition: 0,
                $UISearchMode: 1,
                $PlayOrientation: 1,
                $DragOrientation: 3,

                $SlideshowOptions: {
                    $Class: $JssorSlideshowRunner$,
                    $Transitions: _SlideshowTransitions,
                    $TransitionsOrder: 1,
                    $ShowLink: true
                },

                $BulletNavigatorOptions: {
                    $Class: $JssorBulletNavigator$,
                    $ChanceToShow: 2,
                    $AutoCenter: 1,
                    $Steps: 1,
                    $Rows: 1,
                    $SpacingX: 10,
                    $SpacingY: 10,
                    $Orientation: 1
                },

                $ArrowNavigatorOptions: {
                    $Class: $JssorArrowNavigator$,
                    $ChanceToShow: 2,
                    $Steps: 1
                }
            };
            var jssor_slider1 = new $JssorSlider$("slider1_container", options);
            function ScaleSlider() {
                var parentWidth = jssor_slider1.$Elmt.parentNode.clientWidth;
                if (parentWidth)
                    jssor_slider1.$ScaleWidth(parentWidth);
                else
                    window.setTimeout(ScaleSlider, 30);
            }
            ScaleSlider();

            $(window).bind("load", ScaleSlider);
            $(window).bind("resize", ScaleSlider);
            $(window).bind("orientationchange", ScaleSlider);
        });
    </script>
@endsection

    @section('content')



    <div id="slider1_container" style="position: relative; top: 0px; left: 0px; width: 1280px; height:480px; overflow: hidden; ">

        <!-- Loading Screen -->
        <div u="loading" style="position: absolute; top: 0px; left: 0px;">
            <div style="filter: alpha(opacity=70); opacity:0.7; position: absolute; display: block;
                background-color: #000000; top:0px; left: 0px;width: 100%;height:100%;">
            </div>
            <div style="position: absolute; display: block; background: url(../img/loading.gif) no-repeat center center;
                top: 0px; left: 0px;width: 100%;height:100%;">
            </div>
        </div>

        <!-- Slides Container -->
        <div u="slides" style="cursor:pointer; position: absolute; left: 0px; top: 0px; width: 1280px; height: 480px; overflow: hidden;">
            @foreach( $blogHome->banner as $banner )
                <div data-p="225.00">
                     <div class="blog-banner-text">
                        <div class="blog-banner-title">{{ $banner->title }}</div>


                        <div class="blog-banner-date">{{ preg_replace("/(.*)\s(.*)/", "$1", $banner->time)  }}</div>
<!--                        <div class="blog-banner-auth">by {{ $banner->author }}</div>-->
                    </div>
                    <div class="blog-banner-image" style="background-image:url('{{ $banner->image }}');">
                    </div>

                </div>
            @endforeach
        </div>

        <div u="navigator" class="jssorb05-1">
            <!-- bullet navigator item prototype -->
            <div u="prototype"></div>
        </div>

        <span u="arrowleft" class="jssora12l-1" style="top: 220px; left: 0px;">
        </span>

        <span u="arrowright" class="jssora12r-1" style="top: 220px; right: 0px;">
        </span>
    </div>
    <div class="blog-background">
        <div class="blog-container">
            @foreach ( $blogHome->categories as $category )
            <div class="row blog-category">
                <div class="row blog-cat-header">
                    <div class="blog-cat-title">
                        {{ $category->cat_title }}
                    </div>
                    <div style="display:none;">
                        {{ $category->cat_id }}
                    </div>
                    <!-- <div class="blog-cat-logo">
                        <img src="{{ $category->cat_logo }}">
                    </div> -->
<!--                    <div class="blog-readmore"><a href="{{asset ('blog/' . $category->cat_title)}}">閱讀更多</a></div>-->
                </div>
                <div class="row blog-cat-article">
                    @foreach ( $category->cat_content as $article )
                    <a href="{{asset ('blog/' . $category->cat_title . '/' . $article->title )}}">
                    <div class="col-sm-3 blog-cat-panel">
                        <div style="display:none;">
                            {{ $article->id }}
                        </div>
                        
                            <div class="blog-thumbnail"
                             style="background-image:url('{{ $article->thumbnail }}')">
                                <div class="blog-mb-text">
                                    <div class="blog-panel-title word-indent-02 ">
                                        {{ $article->title }}
                                    </div>
                                    <div class="blog-panel-time">
                                        {{ preg_replace("/(.*)\s(.*)/", "$1", $article->time)  }}
                                    </div>
                                    <div class="blog-panel-info word-indent-02 ">
                                        {{ $article->info }}
                                    </div>
                                </div>
                                <div class="home-blog-count">
                                    <img src="/img/icons/eye-03.png">0 人
                                </div>
                            </div>
                       
                        <div class="blog-panel-text">
                            <div class="blog-panel-title word-indent-02">
                                <a href="{{asset ('blog/article')}}">{{ $article->title }}</a>
                            </div>
                            <div class="blog-panel-time">
                                {{ preg_replace("/(.*)\s(.*)/", "$1", $article->time)  }}
                            </div>
                            <div class="blog-panel-author">
                                由 {{ $article->author }} 發表
                            </div>
                            <div class="blog-panel-info word-indent">
                                {{ $article->info }}
                            </div>
                        </div>
                    </div>
                     </a>
                    @endforeach
                </div>
<!--                <div class="mobile-blog-readmore">閱讀更多</div>-->
            </div>
            @endforeach
        </div>

        @endsection
    </div>
