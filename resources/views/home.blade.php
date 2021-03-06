@extends('layouts.app')

@section('meta')
    @foreach($meta as $key => $value)
        <meta {{ $key }} content="{{ $value }}">
    @endforeach
    <title>514-有意思的人</title>
@endsection

@section('style')
    <link rel="stylesheet" href="/css/pure-min.css"/>
    <link rel="stylesheet" href="/css/easydropdown.css"/>
    <link rel="stylesheet" href="/css/jquery.jscrollpane.css"/>
    <link rel="stylesheet" href="/css/crollpane-style.css"/>
@endsection

@section('script')
<script type="text/javascript" src="../js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="../js/jquery.mousewheel.js"></script>
<script type="text/javascript" src="../js/jquery.contentcarousel.js"></script>
<script type="text/javascript">
    $('#expert-container').contentcarousel();
</script>
<script>
    $(function(){
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
        $(function () {
          $('[data-toggle="tooltip"]').tooltip();
        })
    });
</script>
@endsection

@section('banner')
    <div id="jssor_1" class="banner-1">
        <div data-u="slides" style="cursor: default; position: relative; top: 0px; left: 0px; width: 1300px; height: 500px; overflow: hidden;">
            @foreach( $home->banner as $banner )<?//banner 區塊 用foreach 把DB裡的圖片輪播?>
                <div data-p="225.00" style="display: none;">
                    <a href="{{ $banner->caption }}">
                        <div class="home_banner1" style="background-image:url({{ $banner->image }});" data-u="image"></div>
                    </a>
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
    <!-- mobile view -->
<div class="mobile-container">
<!--
        <div class="mobile-navbar">
            <ul class="nav nav-tabs">
                <li data-type="hot" ><a href="#">熱門排序</a></li>
                <li data-type="time" ><a href="#">時間排序</a></li>
                <li data-type="price" ><a href="#">優惠排序</a></li>
            </ul>
        </div>
-->
        <div class="mobile-recommend">
            <div class="mobile-recom-image"></div>
            <div class="mobile-recom-text">
                <p><img src="/img/pics/comma.png">職人名字</p>
                <div>514之我們在做什麼～？</div>
                <div class="mobile-recom-blue"></div>
            </div>
        </div>

        <p class="home-mb-title">▼ 熱門職人 ▼</p>
        <div class="row mobile-expert">
            @foreach( $home->hotExpert as $expert )
            <a href="/member/{{ $expert->id }}">
                <div class="mobile-expert-panel">
                    <div class="mb-expert-thumb" style="background-image:url('{{ $expert->avatar }}')"></div>
                    <div class="mb-expert-text">
                        <p>{{ ($expert->content['name'])? $expert->content['name'] : $expert->name }}</p>
                        <img src="/img/pics/yellow-stars.png">
                        <p class="word-indent-02" style="word-break: break-all;color:#b3b3b3;">
                            @if($expert->content['experience'] == '' && implode(',', $expert->content['capacity']) != '')
                                @foreach($expert->content['capacity'] as $capacity)
                                <span class="mb-expert-tag">{{ $capacity }}</span>
                                @endforeach
                            @elseif ($expert->content['experience'] != '')
                                <span class="mb-expert-tag">{{ $expert->content['experience'] }}</span>
                            @endif
                        </p>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
        <p class="home-mb-title">▼ 熱門活動 ▼</p>
        <div class="mobile-activity">
            @foreach( $home->allActivity as $mbActivity )
            <a href="{{ 'activity/' . $mbActivity->activity_id }}">
            <div class="act-mb-panel">
                <div class="col-xs-12 act-mb-thumb" style="background-image:url('{{ $mbActivity->thumbnail }}')">
                    <div class="act-mb-title-bg">
                        <div class="act-mb-count">
                            <img src="/img/icons/eye-03.png">{{ $mbActivity->count }} 人
                        </div>
                        <div class="act-mb-title word-indent-01">
                             {{ $mbActivity->title }}
                        </div>
                    </div>
                </div>
                <div class="row" style="margin:0;">
                    <div class="col-xs-5 act-mb-expert">
                        <div class="act-mb-expert-thumb" style="background-image:url('{{ $mbActivity->avatar }}')"></div>
                        <p>{{ $mbActivity->nick }}</p>
                    </div>
                    <div class="col-xs-7 act-mb-text">
                        <div class=" act-mb-info word-indent-newact">
                            <img src="/img/icons/mb-date.png">
                                {{--*/ $weekday=['日', '一', '二', '三', '四', '五', '六'][date('w', strtotime($mbActivity->date))]; echo preg_replace("/\d{4}-(.*)\s(.*):(.*)/", "$1 ( $weekday )", $mbActivity->date) /*--}}
                        </div>
                        <div class="act-mb-info word-indent-newact">
                            <img src="/img/icons/mb-location.png">
                            {{ $mbActivity->locat_name . $mbActivity->location }}
                        </div>
                        <div class="act-mb-info">
                            <img src="/img/icons/mb-price.png">
                            {{ $mbActivity->price }} 元
                        </div>
                        <div class="act-mb-info">
                            <img src="/img/icons/mb-category.png">
                            {{ $mbActivity->cat_name }}
                        </div>
                    </div>
                </div>
            </div>
            </a>
            @endforeach
        </div>
<!--
        <a href="/activity">
        <div class="more-activity">
            <div>進階搜尋</div>
        </div>
        </a>
-->
    </div>
</div>
    <!-- mobile view end-->

    <div class="home-container">
        <form class="form-horizontal" enctype="multipart/form-data" method="post" action="{{ '/activity' }}">
            {!! csrf_field() !!}
            <div class="filter-bg" id="FilterFixed">
                <div class="pure-g panel-filter">
                    <div class="filter-select pure-u-4-24">
                        <select name="playWhat" class="filter-select dropdown">
                            <option value="" class="label">專長類別</option>
                            @foreach( $home->filter->what as $play_what )
                            <option value="{{ $play_what->id }}"> {{ $play_what->name }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="pure-u-4-24">
                        <select name="goWhere" class="dropdown">
                            <option value="" class="label">位置/地點</option>
                            @foreach( $home->filter->where as $key_where => $go_where )
                            <option value="{{ $go_where->id }}"> {{ $go_where->name }} </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="pure-u-4-24">
                        <select name="atWhen" class="dropdown">
                            <option value="" class="label">活動時間</option>
                            @foreach( $home->filter->when as $key_when => $at_when )
                            <option value="{{ $at_when->id }}"> {{ $at_when->name }} </option>
                            @endforeach
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
                    <div class="pure-u-6-24">
                        <input name="keySearch" class="search-bar" type="text" placeholder="輸入關鍵字 尋找職人活動" />
                    </div>
                    <div class="pure-u-2-24">
                        <button type="submit" class="search-button btn">
                            搜尋
                        </button>
                    </div>
                </div>
            </div>
        </form>
        <div class="home-blog">
            <div class="row home-title">
                <img src="/img/pics/new_articles-02.png">
            </div>
            <div class="row home-blog-content">
                @foreach( $home->newBlog as $blog )
                <div class="row col-md-2 home-blog-panel">
                    <a href="{{ '/blog/' . $blog->category . '/' . $blog->title }}">
                        <div class="home-blog-thumbnail" style="background-image:url({{ $blog->thumbnail }})">
                            <div class="home-blog-count">
                                <img src="/img/icons/eye-03.png">{{ $blog->counter }} 人
                            </div>
                        </div>
                    </a>

                    <div class="Hblog-panel-text">
                        <div class="home-blog-title">
                             <a href="{{ '/blog/' . $blog->category . '/' . $blog->title }}">{{ $blog->title }} </a>
                        </div>
                        <div class="row home-blog-info">
<!--
                            <a href="https://www.google.com/calendar/event?action=TEMPLATE&text=[event-title]&dates=[start-custom format='Ymd\\THi00\\Z']/[end-custom format='Ymd\\THi00\\Z']&details=[description]&location=[location]&trp=false&sprop=&sprop=name:" target="_blank" rel="nofollow">                    <div class="home-blog-created_at">
                                    <li>{{--*/ $weekday=['日', '一', '二', '三', '四', '五', '六'][date('w', strtotime($blog->created_at))]; echo preg_replace("/(.*)\s(.*):(.*)/", "$1 ( $weekday )", $blog->created_at); /*--}}</li>
                                </div>
                            </a>
-->
                            <a href="{{ '/blog/'. $blog->category }}">
                                <div class="home-blog-category">
                                    <li>{{ $blog->category }}</li>
                                </div>
                            </a>
<!--
                            <a href="{{ '/member/'. $blog->author }}">
                                <div class="home-blog-author">
                                    <li> 由 {{ $blog->author }} 發表</li>
                                </div>
                            </a>
-->
                        </div>
                        <div class="home-blog-description word-indent-02">
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
        <div class="hot-expert">
            <div class="row home-title">
                <img src="/img/pics/hot-profession-02.png">
            </div>
            <div class="row hot-expert-content">
                <div id="expert-container" class="ca-container">
            				<div class="ca-wrapper">
                        @foreach( $home->hotExpert as $hotExpert )
                        <div class="ca-item ca-item-1">
                            <a href="/member/{{ $hotExpert->id }}">
                                <div class="ca-item-main">
                                    <div class="ca-image" style="background-image:url('{{ $hotExpert->avatar }}')"></div>
                                    <div class="ca-text">
                                        <h3>{{ ($hotExpert->content['name'])? $hotExpert->content['name'] : $hotExpert->name }}</h3>
                                        <div class="home-exper-tag">
                                        @if($hotExpert->content['experience'] == '' && implode(',', $hotExpert->content['capacity']) != '')
                                            @foreach($hotExpert->content['capacity'] as $capacity)
                                            <p class="ca-tag">{{ $capacity }}</p>
                                            @endforeach
                                        @elseif ($hotExpert->content['experience'] != '')
                                            <p class="ca-tag">{{ $hotExpert->content['experience'] }}</p>
                                        @endif
                                        </div>
                                        <div class="ca-introduce">{!! ($hotExpert->content['description'] == '')? $hotExpert->description : $hotExpert->content['description'] !!}</div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endforeach
            				</div>
                </div>
            </div>
        </div>
        <div class="new-activity">
            <div class="row home-title">
                <img src="/img/pics/new_activities-02.png">
            </div>
            <div class="row new-activity-content">
                @foreach( $home->newActivity as $newActivity )
                <div class="col-md-4 col-sm-4 col-xs-12 new-activity-panel">
                    <div class="newact_panel_bg">
                        <div class="new-activity-id">
                            {{ $newActivity->activity_id }}
                        </div>
                        <a href="{{ '/activity/' . $newActivity->activity_id }}">
                        <div class="new-activity-thumbnail"
                             style="background-image:url({{ $newActivity->thumbnail }})">
                            <div class="home-mb-count">
                                <img src="/img/icons/eye-03.png">{{ $newActivity->count }} 人
                            </div>
                        </div>
                        </a>
                        <div class="new-activity-right">
                            <div class="new-activity-title word-indent-01">
                                 <a href="{{ '/activity/' . $newActivity->activity_id }}">{{ $newActivity->title }} </a>
                            </div>
                            <div class="new-activity-count">
                                <img src="/img/icons/eye-03.png">{{ $newActivity->count }} 人
                            </div>
                            <!-- HTML to write -->

                                <div class="new-activity-orginizer">
                                     由 <a href="{{ '/member/'. $newActivity->hoster_id }}"><span>{{ ($newActivity->orginizer)? $newActivity->orginizer: $newActivity->name }}</span> </a> 舉辦
                                </div>

                            <div style="padding-bottom:10px;">
                                <a href="{{ '/member/'. $newActivity->hoster_id }}">
                                    <div class="new-activity-expert" style="background-image:url('{{ $newActivity->avatar }}')">
                                    </div>
                                </a>
                                <div class="new-activity-date">
                                    <img src="img/pics/calendar-icon-02.png">
                                    {{--*/ $weekday=['日', '一', '二', '三', '四', '五', '六'][date('w', strtotime($newActivity->date))]; echo preg_replace("/\d{4}-(.*)\s(.*):(.*)/", "$1 ( $weekday )", $newActivity->date) /*--}}
                                    <a href="https://www.google.com/calendar/event?action=TEMPLATE&text={{ $newActivity->title }}&dates={{ date('Ymd\\THi00\\Z', strtotime($newActivity->date)) }}/{{ date('Ymd\\THi00\\Z', strtotime($newActivity->date_end)) }}&details=活動名稱：{{ $newActivity->title }}%0A活動描述：{{ $newActivity->description }}%0A活動網址：{{ '/activity/'. $newActivity->activity_id }}&location={{ $newActivity->locat_name . $newActivity->location }}&trp=true" target="_blank" rel="nofollow"  data-toggle="tooltip"data-placement="right "title="加到日曆">
                                    <img src="/img/icons/arrow-calendar.png" style="width:27px;padding-bottom:2px;"></a>
                                    <div class="tooltip top" role="tooltip">
                                        <div class="tooltip-arrow"></div>
                                        <div class="tooltip-inner"></div>
                                    </div>
                                </div>
                                <div class="new-activity-price">
                                    <img src="img/pics/money-icon-02.png">
                                    {{ $newActivity->price }} 元
                                </div>
                                <div class="new-activity-location word-indent-newact ">
                                    <img src="img/pics/location-icon-02.png">
                                    {{ $newActivity->locat_name . $newActivity->location }}
                                </div>
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
                        <a href="{{ '/activity?cat_id='. $eachTypeActivity->cat_id }}">
                            <p class="col-md-2 col-sm-4 col-xs-4">
                                <img src="/img/icons/icon_arrowicon.png">
                                {{ $eachTypeActivity->cat_title }}
                            </p>
                        </a>
                        <div class="col-md-8 col-sm-6 col-xs-5 home-dashed"></div>
                           <!-- <img src="{{ $eachTypeActivity->cat_logo }}"> -->
                        <div class="col-md-2 col-sm-2 col-xs-3 category-readmore">
                            <a href="{{ '/activity?cat_id='. $eachTypeActivity->cat_id }}">
                            <!-- <a href="{{ $eachTypeActivity->affinity }}"> -->
                                Read More
                            </a>
                        </div>
                    </div>
                    @foreach( $eachTypeActivity->cat_content as $activity )
                    <div class="col-md-4 col-sm-4 inter-panel">
                        <a href="{{ '/activity/' . $activity->activity_id }}">
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
                            <a href="{{ '/member/'. $newActivity->hoster_id }}">
                                <div class="new-activity-expert" style="background-image:url('{{ $newActivity->avatar }}')">
                                </div>
                            </a>
                            <div class="new-activity-title word-indent-01">
                                <a href="{{ '/activity/' . $activity->activity_id }}">
                                    {{ $activity->title }}
                                </a>
                            </div>
                            <div class="new-activity-orginizer">
                                 由 <a href="{{ '/member/'. $newActivity->hoster_id }}"><span>{{ ($newActivity->orginizer)? $newActivity->orginizer : $newActivity->name }}</span> </a> 舉辦
                            </div>
                            <div class="new-activity-date">
                                <img src="img/pics/calendar-icon-02.png">
                                {{--*/ $weekday=['日', '一', '二', '三', '四', '五', '六'][date('w', strtotime($activity->date))]; echo preg_replace("/\d{4}-(.*)\s(.*):(.*)/", "$1 ( $weekday )", $activity->date); /*--}}
                                <a href="https://www.google.com/calendar/event?action=TEMPLATE&text={{ $newActivity->title }}&dates={{ date('Ymd\\THi00\\Z', strtotime($newActivity->date)) }}/{{ date('Ymd\\THi00\\Z', strtotime($newActivity->date_end)) }}&details={{ $newActivity->description }}&location={{ $newActivity->locat_name . $newActivity->location }}&trp=true" target="_blank" rel="nofollow"  data-toggle="tooltip"data-placement="right "title="加到日曆">
                                <img src="/img/icons/arrow-calendar.png" style="width:27px;padding-bottom: 2px;"></a>
                                <div class="tooltip top" role="tooltip">
                                    <div class="tooltip-arrow"></div>
                                    <div class="tooltip-inner"></div>
                                </div>
                            </div>
                            <div class="new-activity-price">
                                <img src="img/pics/money-icon-02.png">
                                {{ $activity->price }} 元
                            </div>
                            <div class="new-activity-location word-indent-newact ">
                                <img src="img/pics/location-icon-02.png">
                                <span>{{ $activity->locat_name . $activity->location }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endforeach
            </div>
        </div>
      </div>
    </div>
@endsection
