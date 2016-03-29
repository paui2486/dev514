@extends('layouts.app')

@section('meta')
    @foreach($meta as $key => $value)
        <meta {{ $key }} content="{{ $value }}">
    @endforeach
    <title>514活動頻道 - 讓生活更有意思</title>
@endsection

@section('style')
    <link rel="stylesheet" href="{{asset('css/pure-min.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/easydropdown.css')}}"/>
@endsection

@section('script')
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
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
    <div class="searchbar-mobile">
        <div class="col-xs-8">
            <input name="keySearch" class="search-bar" type="text" />
        </div>
        <div class="col-xs-4">
            <button type="submit" class="search-button btn">
                搜尋
            </button>
        </div>
    </div>
    <div id="jssor_1" class="banner-1">
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

        <form class="form-horizontal" enctype="multipart/form-data" method="post" action="{{ url('activity') }}">
            {!! csrf_field() !!}
            <div class="filter-bg">
            <div class="pure-g panel-filter">
                <div class="pure-u-4-24">
                    <select name="withWho" class="dropdown" >
                        <option value="" class="label">想和誰去</option>
                        @foreach( $home->filter->who as $with_who )
                        <option value="{{ $with_who->id }}"> {{ $with_who->name }} </option>
                        @endforeach
                    </select>
                </div>

                <div class="pure-u-4-24">
                    <select name="playWhat" class="dropdown">
                        <option value="" class="label">想玩什麼</option>
                        @foreach( $home->filter->what as $play_what )
                        <option value="{{ $play_what->id }}"> {{ $play_what->name }} </option>
                        @endforeach
                    </select>
                </div>

                <div class="pure-u-4-24">
                    <select name="goWhere" class="dropdown">
                        <option value="" class="label">想去哪兒</option>
                        @foreach( $home->filter->where as $key_where => $go_where )
                        <option value="{{ $go_where->id }}"> {{ $go_where->name }} </option>
                        @endforeach
                    </select>
                </div>

                <div class="pure-u-4-24">
                    <select name="atWhen" class="dropdown">
                        <option value="" class="label">時間</option>
                        <option value="1"> 今天 </option>
                        <option value="2"> 明天 </option>
                        <option value="3"> 這週 </option>
                        <option value="4"> 下週 </option>
                        <option value="5"> 一個月內 </option>
                        <option value="6"> 兩個月內 </option>
                    </select>
                </div>

                <div class="pure-u-4-24">
                    <select name="haveMoney" class="dropdown">
                        <option value="" class="label">預算多少</option>
                        @foreach( $home->filter->price as $key_price => $price )
                        <option value="{{ $price->id }}"> {{ $price->name }} </option>
                        @endforeach
                    </select>
                </div>
                <div class="pure-u-3-24">
                    <input name="keySearch" class="search-bar" type="text" />
                </div>
                <div class="pure-u-1-24">
                    <button type="submit" class="search-button btn">
                        搜尋
                    </button>
                </div>
            </div>
            </div>
        </form>

        <div class="new-activity">
            <div class="row home-title">
                <img src="/img/pics/new_activities-02.png">
            </div>
            <div class="row new-activity-content">
                @foreach( $home->newActivity as $newActivity )

                    <div class="col-md-4 new-activity-panel">
                        <div class="newact_panel_bg">
                            <div class="new-activity-id">
                                {{ $newActivity->activity_id }}
                            </div>
                            <a href="{{ URL::to('activity/' . $newActivity->category . '/' . $newActivity->title ) }}">
                            <div class="new-activity-thumbnail"
                                 style="background-image:url({{ $newActivity->thumbnail }})">
                            </div>
                            </a>
                            <div class="new-activity-right">

                                <div class="new-activity-title word-indent-01">
                                     <a href="{{ URL::to('activity/' . $newActivity->category . '/' . $newActivity->title ) }}">{{ $newActivity->title }} </a>
                                </div>

                                <div class="new-activity-count">
                                    <img src="/img/icons/eye-03.png">{{ $newActivity->count }} 人
                                </div>
                                <div class="new-activity-description word-indent">
                                    {{ $newActivity->description }}
                                </div>
                                <div class="new-activity-price">
                                    <img src="img/pics/money-icon-02.png">
                                    {{ $newActivity->price }} 元
                                </div>
                                <div class="new-activity-date">
                                    <img src="img/pics/calendar-icon-02.png">
                                    {{--*/ $weekday=['日', '一', '二', '三', '四', '五', '六'][date('w', strtotime($newActivity->date))]; echo preg_replace("/(.*)\s(.*):(.*)/", "$1 ( $weekday )", $newActivity->date) /*--}}
                                </div>
                                <div class="new-activity-location word-indent-newact ">
                                    <img src="img/pics/location-icon-02.png">
                                    {{ $newActivity->location }}
                                </div>
                                <div class="new-activity-orginizer">
                                    <img src="/img/icons/holder.png">
                                    <span> {{ $newActivity->orginizer }} </span>
                                </div>
                            </div>
                        </div>
                    </div>

                @endforeach
            </div>
        </div>

        <div class="Act-category">
            <div class="row home-title">
                <img src="/img/pics/act_category-02.png">
            </div>
            <div class="row Act-category-content">
                @foreach( $home->totalActivity as $eachTypeActivity )
                    <div class="row Act-category-panel">

                            <div class="Act-category-id">
                                {{ $eachTypeActivity->cat_id }}
                            </div>

                           <div class="row Act-category-title">
                                <p class="col-md-2"><a href="{{ URL::to('activity/' . $eachTypeActivity->cat_title ) }}">{{ $eachTypeActivity->cat_title }}</a>
                                </p>
                                <div class="col-md-8 home-dashed"></div>
    <!--                            <img src="{{ $eachTypeActivity->cat_logo }}">-->
                                <div class="col-md-2 category-readmore">
                                    <a href="{{ URL::to('activity/' . $eachTypeActivity->cat_title ) }}">
                                        <img src="/img/icons/rightarrow.png">
                                        <p> Read More </p>
                                    </a>
                                </div>
                            </div>


                        @foreach( $eachTypeActivity->cat_content as $activity )

                            <div class="col-md-4 inter-panel">
                                <a href="{{ URL::to('activity/' . $eachTypeActivity->cat_title . '/' . $activity->title ) }}">
                                <div class="inter-panel-thumbnail"
                                     style="background-image:url({{ $activity->thumbnail }})">
                                </div>
                                    </a>
                                <div class="inter-panel-id">
                                    {{ $activity->activity_id }}
                                </div>
                                <div class="inter-panel-count">
                                     <img src="/img/icons/eye-03.png">{{ $activity->count }} 人
                                </div>
                                <div class="inter-panel-info">
                                    <a href="{{ URL::to('activity/' . $eachTypeActivity->cat_title . '/' . $activity->title ) }}">
                                    <div class="new-activity-title word-indent-01">
                                        <a href="{{ URL::to('activity/' . $eachTypeActivity->cat_title . '/' . $activity->title ) }}">{{ $activity->title }}</a>
                                    </div>
                                    </a>

                                    <div class="inter-panel-description new-activity-description word-indent-02">
                                        {{ $activity->description }}
                                    </div>

                                    <div class="new-activity-price">
                                        <img src="img/pics/money-icon-02.png">
                                        {{ $activity->price }} 元
                                    </div>
                                    <div class="new-activity-date">
                                        <img src="img/pics/calendar-icon-02.png">
                                        {{--*/ $weekday=['日', '一', '二', '三', '四', '五', '六'][date('w', strtotime($activity->date))]; echo preg_replace("/(.*)\s(.*):(.*)/", "$1 ( $weekday )", $activity->date); /*--}}
                                    </div>
                                    <div class="new-activity-location word-indent-newact ">
                                        <img src="img/pics/location-icon-02.png">
                                        <span>{{ $activity->location }}</span>
                                    </div>
                                    <div class="new-activity-orginizer">
                                       <img src="/img/icons/holder.png">
                                       <span> {{ $newActivity->orginizer }} </span>
                                    </div>
                                </div>
                            </div>

                        @endforeach
                    </div>
                @endforeach
                </div>
            </div>
        </div>
        <div class="home-blog">
            <div class="row home-title">
                <img src="/img/pics/new_articles-02.png">
            </div>
            <div class="row home-blog-content">
                @foreach( $home->newBlog as $blog )
                <div class="row home-blog-panel">
                    <a href="{{ URL::to('blog/' . $blog->category . '/' . $blog->title ) }}">
                        <div class="home-blog-thumbnail" style="background-image:url({{ $blog->thumbnail }})">
                        </div>
                    </a>
                    <div class="home-blog-panel-right">
                        <div class="home-blog-title">
                             <a href="{{ URL::to('blog/' . $blog->category . '/' . $blog->title ) }}">{{ $blog->title }} </a>
                        </div>
                        <div class="row home-blog-info">
                            <div class="home-blog-created_at">

                                <li>{{--*/ $weekday=['日', '一', '二', '三', '四', '五', '六'][date('w', strtotime($blog->created_at))]; echo preg_replace("/(.*)\s(.*):(.*)/", "$1 ( $weekday )", $blog->created_at); /*--}}</li>
                            </div>
                            <a href="{{ url('/blog/'. $blog->category) }}">
                                <div class="home-blog-category">

                                    <li>{{ $blog->category }}</li>
                                </div>
                            </a>
                            <a href="{{ url('/member/'. $blog->author)}}">
                                <div class="home-blog-author">

                                    <li> By {{ $blog->author }}</li>
                                </div>
                            </a>
                        </div>
                        <div class="home-blog-description word-indent-04">
                            {{ $blog->description }}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="row home-read-more">
                <a href="blog"> 閱讀更多 </a>
            </div>
        </div>
    </div>
    @endsection
