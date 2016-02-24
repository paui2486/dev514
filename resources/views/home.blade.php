@extends('layouts.app')

@section('script')
<script>
    jQuery(document).ready(function ($) {
        var SlideoTransitions = [
        ];

        var jssor_1_options = {
            $AutoPlay: true,
            $SlideDuration: 2000,
            $SlideEasing: $Jease$.$OutQuint,
            $CaptionSliderOptions: {
                $Class: $JssorCaptionSlideo$,
                $Transitions: SlideoTransitions
            },
            $ArrowNavigatorOptions: {
                $Class: $JssorArrowNavigator$
            },
            $BulletNavigatorOptions: {
                $Class: $JssorBulletNavigator$
            }
        };

        var HomeBanner = new $JssorSlider$("jssor_1", jssor_1_options);

        //responsive code begin
        //you can remove responsive code if you don't want the slider scales while window resizing
        function ScaleSlider() {
            var parentWidth = HomeBanner.$Elmt.parentNode.clientWidth;
            if (parentWidth)
                HomeBanner.$ScaleWidth(parentWidth);
            else
                window.setTimeout(ScaleSlider, 30);
        }
        ScaleSlider();
        $(window).bind("load", ScaleSlider);
        $(window).bind("resize", ScaleSlider);
        $(window).bind("orientationchange", ScaleSlider);
        //responsive code end
    });
</script>
@endsection

@section('banner')
    <div id="jssor_1" style="position: relative; margin: 0 auto; top: 0px; left: 0px; width: 1300px; height: 500px; overflow: hidden; visibility: hidden;">
        <!-- Loading Screen -->
        <div data-u="loading" style="position: absolute; top: 0px; left: 0px;">
            <div style="filter: alpha(opacity=70); opacity: 0.7; position: absolute; display: block; top: 0px; left: 0px; width: 100%; height: 100%;"></div>
            <div style="position:absolute;display:block;background:url('../img/loading.gif') no-repeat center center;top:0px;left:0px;width:100%;height:100%;"></div>
        </div>

        <div data-u="slides" style="cursor: default; position: relative; top: 0px; left: 0px; width: 1300px; height: 500px; overflow: hidden;">
            @foreach( $home->banner as $banner )
            <div data-p="225.00" style="display: none;">
                <div class="home_bntitle">
                    <img src="/img/pics/banner_title-02.png" />
                </div>
                <div class="home_banner1" style="background-image:url({{ $banner->image }});" data-u="image">
                </div>

            </div>
            @endforeach
        </div>
        <!-- Bullet Navigator -->
        <div data-u="navigator" class="jssorb05" style="bottom:16px;right:16px;" data-autocenter="1">
            <!-- bullet navigator item prototype -->
            <div data-u="prototype" style="width:16px;height:16px;"></div>
        </div>
        <!-- Arrow Navigator -->
        <span data-u="arrowleft" class="jssora22l" style="top:0px;left:12px;width:40px;height:58px;" data-autocenter="2"></span>
        <span data-u="arrowright" class="jssora22r" style="top:0px;right:12px;width:40px;height:58px;" data-autocenter="2"></span>
    </div>
@endsection

@section('content')

    <div class="home-container">
        <div class="panel-filter">
            <select name="type" id="types">
                <option style="display:none">想和誰去</option>
                @foreach( $home->filter->who as $key_with => $with_who )
                <option value="{{ $key_with }}"> {{ $with_who }} </option>
                @endforeach
            </select>

            <select name="type" id="types">
                <option style="display:none">想玩什麼</option>
                @foreach( $home->filter->what as $key_play => $play_what )
                <option value="{{ $key_play }}"> {{ $play_what }} </option>
                @endforeach
            </select>

            <select name="type" id="types">
                <option style="display:none">想去哪兒</option>
                @foreach( $home->filter->where as $key_where => $go_where )
                <option value="{{ $key_where }}"> {{ $go_where }} </option>
                @endforeach
            </select>

            <select name="type" id="types">
                <option style="display:none">預算多少</option>
                @foreach( $home->filter->price as $key_price => $price )
                <option value="{{ $key_price }}"> {{ $price }} </option>
                @endforeach
            </select>
        </div>

        <div class="home-blog">
            <div class="row home-title">
                <img src="/img/pics/new_articles-02.png">
            </div>
            <div class="row home-blog-content">
                @foreach( $home->newBlog as $blog )
                <div class="col-lg-6 col-md-6 col-sm-12 home-blog-panel">
                    <div class="home-blog-thumbnail"
                         style="background-image:url({{ $blog->thumbnail }})">
                    </div>
                    <div class="home-blog-panelright">
                        <div class="home-blog-title">
                            {{ $blog->title }}
                        </div>
                        <div class="home-blog-created_at">
                            {{ $blog->created_at }}
                        </div>
                        <div class="glyphicon glyphicon-folder-open home-blog-category">
                            {{ $blog->category }}
                        </div>
                        <div class="glyphicon glyphicon-user home-blog-author">
                            {{ $blog->author }}
                        </div>
                        <div class="home-blog-description word-indent">
                            {{ $blog->description }}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="row home-read-more">
                閱讀更多
            </div>
        </div>

        <div class="home-new-activity">
            <div class="row home-title">
                <img src="/img/pics/new_activities-02.png">
            </div>
            <div class="row home-new-activity-contain">
                @foreach( $home->newActivity as $newActivity )
                <div class="col-lg-4 col-md-6 col-sm-12 home-new-activity-panel">
                    <div class="newact_panel_bg">
                        <div class="home-new-activity-id">
                            {{ $newActivity->activity_id }}
                        </div>
                        <div class="home-new-activity-thumbnail"
                             style="background-image:url({{ $newActivity->thumbnail }})">
                        </div>

                        <div class="home-new-activity-title">
                            {{ $newActivity->title }}
                        </div>
                        <div class="home-new-activity-count">
                            {{ $newActivity->count }} 人
                        </div>
                        <div class="home-new-activity-description word-indent">
                            {{ $newActivity->description }}
                        </div>
                        <div class="home-new-activity-price">
                            <img src="img/pics/money-icon-02.png">
                            {{ $newActivity->price }} 元
                        </div>
                        <div class="home-new-activity-date">
                            <img src="img/pics/calendar-icon-02.png">
                            {{ $newActivity->date }}
                        </div>
                        <div class="home-new-activity-location">
                            <img src="img/pics/location-icon-02.png">
                            {{ $newActivity->location }}
                        </div>
                        <div class="home-new-activity-orginizer">
                            --- {{ $newActivity->orginizer }} ---
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="total-activity">
            <div class="row home-title">
                <img src="/img/pics/act_category-02.png">
            </div>
            <div class="total-activity-contain">
                @foreach( $home->totalActivity as $eachTypeActivity )
                <div class="outer-panel">
                    <div class="activity-category-thumbnail"
                         style="background-image:url({{ $eachTypeActivity->cat_thumbnail }})">
                    </div>
                    <div class="activity-category-content">
                        <div class="activity-category-id">
                            {{ $eachTypeActivity->cat_id }}
                        </div>
                        <div class="activity-category-title">
                            {{ $eachTypeActivity->cat_title }}
                        </div>
                        <div class="activity-category-logo">
                            <img src="{{ $eachTypeActivity->cat_logo }}">
                        </div>
                        @foreach( $eachTypeActivity->cat_content as $activity )
                        <div class="inter-panel">
                            <div class="activity-thumbnail"
                                 style="background-image:url({{ $newActivity->thumbnail }})">
                            </div>
                            <div class="activity-id">
                                {{ $newActivity->activity_id }}
                            </div>
                            <div class="home-new-activity-title activity-title">
                                {{ $newActivity->title }}
                            </div>
                            <div class="activity-count">
                                {{ $newActivity->count }} 人
                            </div>
                            <div class="home-new-activity-description word-indent-02">
                                {{ $newActivity->description }}
                            </div>
                            <div class="home-new-activity-price activity-price">
                                <img src="img/pics/money-icon-02.png">
                                {{ $newActivity->price }} 元
                            </div>
                            <div class="home-new-activity-date activity-date">
                                <img src="img/pics/calendar-icon-02.png">
                                {{ $newActivity->date }}
                            </div>
                            <div class="home-new-activity-location activity-location">
                                <img src="img/pics/location-icon-02.png">
                                {{ $newActivity->location }}
                            </div>
                            <div class="home-new-activity-orginizer activity-orginizer">
                                --- {{ $newActivity->orginizer }} ---
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endsection
