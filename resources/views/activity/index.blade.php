@extends('layouts.app')

@section('meta')
    @if(isset($meta))
        @foreach($meta as $key => $value)
            <meta {{ $key }} content="{{ $value }}">
        @endforeach
    @endif
    <title>514活動頻道 - {{ $activity->title }}</title>
@endsection

@section('style')
    <link rel="stylesheet" href="/css/colorbox.css" />
@endsection

@section('content')
<div class="act-page-container">
    <div class="act-page-blur" style="background-image:url('{{ $activity->thumbnail }}')">
        <!--            <img src="/img/pics/activity-photo.jpg">-->
    </div>
    <div class="actpage-main-image" style="background-image:url('{{ $activity->thumbnail }}')">
    </div>
    <div class="actpage-content">
        <div id="RightFixed" class="col-md-4 col-sm-4 actpage-right-content">
            <div class="row actpage-cart-title">
                <p id="" class="col-md-6 col-sm-6 left_number"> 剩  位 </p>
                <p id="" class="col-md-6 col-sm-6 left_date"> 倒數  天 </p>
            </div>
            <div class="row actpage-cart-content">
                <p class="actpage-buy-now">{{ $activity->title }}</p>
                <div class="row actpage-cart-ticket">
                    {!! csrf_field() !!}
                    {{--*/ $count = 0; /*--}}
                    @foreach($tickets as $key => $ticket)
                    {{--*/ $count += $ticket->left_over; /*--}}
                    <div class="row cart-option">
                        <div class="col-md-8 ">
                            <label class="checkbox-inline"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                            <input name="ticket_id" type="checkbox" class="checkbox" id="inlineCheckbox1"  value="{{ $key }}">{{ $ticket->name }}
                            </label>
                        </div>
                        <p class="col-md-4 actpage-surplus">剩 {{ $ticket->left_over }} 張</p>
                    </div>
                    <div class="cart-number">
                        <p>請選擇票券數量：
                            <select name="ticket-{{$key}}-number">
                            @for ($i = 1; $i <= 10; $i++)
                                <option value="{{$i}}">{{$i}}</option>
                            @endfor
                            </select>
                        </p>
                    </div>
                    <input type="hidden" name="ticket-{{$key}}-id" value="{{ $ticket->id }}">
                    <div id="OneClick" class="row cart-option-detail">
                        <ul>
                            <li>
                                <p>詳細票券資訊</p>
                                <ul>
                                    <li>票價：$ {{ $ticket->price }} NTD</li>
                                    <li>活動開始： {{--*/ $weekday=['日', '一', '二', '三', '四', '五', '六'][date('w', strtotime($ticket->ticket_start))]; echo preg_replace("/(.*)\s(.*):(.*)/", "$1 ( $weekday ) $2", $ticket->ticket_start) /*--}} </li>

                                    <li>活動結束： {{--*/ $weekday=['日', '一', '二', '三', '四', '五', '六'][date('w', strtotime($ticket->ticket_end))]; echo preg_replace("/(.*)\s(.*):(.*)/", "$1 ( $weekday ) $2", $ticket->ticket_end) /*--}} </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="purchase-block">
                @if(count($tickets)>0)
                <div class="row actpage-purchase">
                    <p><img src="/img/icons/playicon.png">前往購買</p>
                </div>
                @else
                <div class="row actpage-purchase" onclick="alert('抱歉！目前已無票券可供您訂購')">sorry！票券已售完！</div>
                @endif

                <div class="actpage-share">
                    <span class="btn btn-sm"  onclick="share('FBSeed', FB)">
                        <img src="/img/icons/share-fb.png">Facebook</span>
                    <span class="btn btn-sm"  onclick="share('FBMsg', FB)">
                        <img src="/img/icons/share-message.png">Message</span>
                    <span class="btn btn-sm" onclick="share('Mail')">
                        <img src="/img/icons/share-email.png">Email</span>
                    <div class="share-dropdown">
                        <span class="share-dropbtn">更多...</span>
                        <div class="share-dropdown-content">
                            <!-- <a href="#" id="shareWeChat">WeChat</a> -->
                            <a href="#" onclick="share('Weibo')">微博</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<!--------------mobile colorbox start--------------->
        <div class="purchase-mb-btn">
            @if(count($tickets)>0)
            <a class='inline' href="#inline_content">
            <div class="row actpage-mb-purchase">
                 <p><img src="/img/icons/playicon.png">前往購買</p>

            </div>
            </a>
            <div style='display:none'>
                <div id='inline_content' style='padding:10px; background:#fff;'>
                    <p class="actpage-buy-now">{{ $activity->title }}</p>
                    <div class="row actpage-cart-ticket">
                        {!! csrf_field() !!}
                        {{--*/ $count = 0; /*--}}
                        @foreach($tickets as $key => $ticket)
                        {{--*/ $count += $ticket->left_over; /*--}}
                        <div class="row cart-option">
                            <div class="col-xs-8">
                                <label class="checkbox-inline">
                            <input name="ticket_id" type="checkbox" class="checkbox" id="inlineCheckbox1"  value="{{ $key }}">{{ $ticket->name }}
                            </label>
                            </div>
                            <p class="col-xs-4 actpage-surplus">剩 {{ $ticket->left_over }} 張</p>
                        </div>
                        <div class="cart-number">
                            <p>請選擇票券數量：
                                <select name="ticket-{{$key}}-number">
                                @for ($i = 1; $i <= 10; $i++)
                                    <option value="{{$i}}">{{$i}}</option>
                                @endfor
                                </select>
                            </p>
                        </div>
                        <input type="hidden" name="ticket-{{$key}}-id" value="{{ $ticket->id }}">
                        <div id="OneClick" class="row cart-option-detail">
                            <ul>
                                <li>
                                    <p>詳細票券資訊
                                        <span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span>
                                    </p>
                                    <ul>
                                        <li>票價：$ {{ $ticket->price }} NTD</li>
                                        <li>活動開始： {{--*/ $weekday=['日', '一', '二', '三', '四', '五', '六'][date('w', strtotime($ticket->ticket_start))]; echo preg_replace("/(.*)\s(.*):(.*)/", "$1 ( $weekday ) $2", $ticket->ticket_start) /*--}} </li>

                                        <li>活動結束： {{--*/ $weekday=['日', '一', '二', '三', '四', '五', '六'][date('w', strtotime($ticket->ticket_end))]; echo preg_replace("/(.*)\s(.*):(.*)/", "$1 ( $weekday ) $2", $ticket->ticket_end) /*--}} </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        @endforeach
                    </div>
                    <div class="purchase-mb-submit">繼續下一步</div>
                </div>
            </div>
            @else

            <div class="row actpage-mb-purchase" onclick="alert('抱歉！目前已無票券可供您訂購')">sorry！票券已售完</div>
            @endif
        </div>
<!--------------mobile colorbox end--------------->
        <div class="row actpage-dashboard">
            @if (Session::has('message'))
            <div class="alert alert-danger">
                <ul>
                  <li> *** {{ Session::get('message') }} *** </li>
                </ul>
            </div>
            @endif
            <div class="col-md-2 col-sm-2">
                <div class="actpage-holder">
                    <a href="{{ URL('member/'. $activity->hoster ) }}">
                        <div class="actpage-holder-thumnail" style="background-image:url('{{ $activity->host_photo }}')">
                        </div>
                        <div class="actpage-holder-name">
                            @if($activity->nick) {{$activity->nick}} @else {{$activity->hoster}} @endif
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-6 col-sm-4 actpage-dashboard-info">
                <p>{{ $activity->title }}</p>
                <a href="http://www.google.com/calendar/event?action=TEMPLATE&text={{ $activity->title }}&dates={{ date('Ymd\\THi00\\Z', strtotime($activity->activity_start)) }}/{{ date('Ymd\\THi00\\Z', strtotime($activity->activity_end)) }}&details=活動名稱：{{ $activity->title }}%0A活動描述：{{ $activity->description }}%0A活動網址：{{ url('activity'). '/' . $activity->id }}&location={{ $activity->locat_name . $activity->location }}&trp=true" target="_blank" rel="nofollow"  data-toggle="tooltip"data-placement="right "title="加到日曆">
                <div class="dashboard-block dashboard-block-date">
                    <img src="/img/icons/info-date.png"> @if(count($tickets)>0)
                    <div class="dashboard-text">
                        <p>
                            {{--*/ $weekday=['日', '一', '二', '三', '四', '五', '六'][date('w', strtotime($activity->activity_start))]; echo preg_replace("/(.*)\s(.*):(.*)/", "$1 ( $weekday ) $2", $activity->activity_start) /*--}}
                        </p>
                        <p>～</p>
                        <p>
                            {{--*/ $weekday=['日', '一', '二', '三', '四', '五', '六'][date('w', strtotime($activity->activity_end))]; echo preg_replace("/(.*)\s(.*):(.*)/", "$1 ( $weekday ) $2", $activity->activity_end) /*--}}
                        </p>
                    </div>
                    @else
                    <div class="dashboard-text dashboard-alert">
                        票券已售完
                    </div>
                    @endif
                </div>
                </a>
                <div class="dashboard-block dashboard-price">
                    <img src="/img/icons/info-price.png">
                    <div class="dashboard-text dashboard-block-price">
                        <p>$ {{ $activity->min_price }} NTD起</p>
                    </div>
                </div>
                <a href="https://maps.google.com?daddr={{ $activity->locat_name . $activity->location }}" target="_blank">
                <div class="dashboard-block">
                    <img src="/img/icons/info-where.png">
                    <div class="dashboard-text">
                        <p>{{ $activity->locat_name . $activity->location }}</p>
                    </div>
                </div>
                </a>
            </div>
        </div>

<!--mobile-dashboard start-->
        <div class="row actpage-mb-dashboard">
           <div class="col-xs-3" style="padding:0;">
                <div class="actpage-holder">
                    <a href="{{ URL('member/'. $activity->hoster ) }}">
                        <div class="actpage-holder-thumnail" style="background-image:url('{{ $activity->host_photo }}')">
                        </div>

                    </a>
                </div>
            </div>
            <div class="dashboard-title col-xs-9">
                <p style="margin:0;">{{ $activity->title }}</p>
                <div class="actpage-holder-name">
                    由 @if($activity->nick) {{$activity->nick}} @else {{$activity->hoster}} @endif 主辦
                </div>
                <div class="actpage-mb-surplus">
                    <p class="left_number"> 剩  位 </p>
                    <p class="left_date"> 倒數  天 </p>
                </div>
            </div>
            <div class="col-xs-12 actpage-dashboard-info">
                <a href="http://www.google.com/calendar/event?action=TEMPLATE&text={{ $activity->title }}&dates={{ date('Ymd\\THi00\\Z', strtotime($activity->activity_start)) }}/{{ date('Ymd\\THi00\\Z', strtotime($activity->activity_end)) }}&details=活動名稱：{{ $activity->title }}%0A活動描述：{{ $activity->description }}%0A活動網址：{{ url('activity'). '/' . $activity->id }}&location={{ $activity->locat_name . $activity->location }}&trp=true" target="_blank" rel="nofollow"  data-toggle="tooltip"data-placement="right "title="加到日曆">
                <div class="dashboard-block">
                    <img src="/img/icons/info-date.png"> @if(count($tickets)>0)
                    <div class="dashboard-text">
                        <p>
                            {{--*/ $weekday=['日', '一', '二', '三', '四', '五', '六'][date('w', strtotime($activity->activity_start))]; echo preg_replace("/(.*)\s(.*):(.*)/", "$1 ( $weekday ) $2", $activity->activity_start) /*--}}
                        </p>
                        <p>～</p>
                        <p>
                            {{--*/ $weekday=['日', '一', '二', '三', '四', '五', '六'][date('w', strtotime($activity->activity_end))]; echo preg_replace("/(.*)\s(.*):(.*)/", "$1 ( $weekday ) $2", $activity->activity_end) /*--}}
                        </p>
                    </div>
                    @else
                    <div class="dashboard-text dashboard-alert">
                        票券已售完
                    </div>
                    @endif
                </div>
                </a>
                <a href="https://maps.google.com?daddr={{ $activity->locat_name . $activity->location }}" target="_blank">
                <div class="dashboard-block">
                    <img src="/img/icons/info-where.png">
                    <div class="dashboard-text">
                        <p>{{ $activity->locat_name . $activity->location }}</p>
                    </div>
                </div>
                </a>
                <div class="dashboard-block dashboard-price">
                    <img src="/img/icons/info-price.png">
                    <div class="dashboard-text">
                        <p>$ {{ $activity->min_price }} NTD起</p>
                    </div>
                </div>
            </div>
            <div class="dashboard-mb-share col-xs-12">
                <span>分享到</span>
                <img src="/img/icons/share-fb.png" onclick="share('FBSeed', FB)">
                <img src="/img/icons/share-line.png" onclick="share('Line')">
                <!-- <img src="/img/icons/share-wechat.png" onclick="share('WeChat')"> -->
                <img src="/img/icons/share-email.png" onclick="share('Mail')">
            </div>
        </div>
<!--mobile-dashboard end-->
        <div class="actpage-panel">
            <div class="col-md-8 col-xs-12 actpage-left-content">
                <div class="actpage-activity-content">
                    <div class="row actpage-header">
                        <p class="col-md-3 col-xs-4 actpage-header-left">活動介紹</p>
                        <div class="col-md-9 col-xs-8 actpage-header-dash"></div>
                    </div>
                    <div class="actpage-introduce">
                        {!! $activity->content !!}
                    </div>
                    <div class="row actpage-header">
                        <p class="col-md-3 col-xs-4 actpage-header-left">購票說明</p>
                        <div class="col-md-9 col-xs-8 actpage-header-dash"></div>
                    </div>
                    <div class="actpage-ticket">
                        <!--                        {!! $activity->content !!}-->
                    </div>
                    <div class="row actpage-header">
                        <p class="col-md-3 col-xs-4 actpage-header-left impact-acts">同場加映</p>
                        <div class="col-md-9 col-xs-8 actpage-header-dash"></div>
                    </div>
                    <div class="row actpage-recommend">
                        @foreach($suggests as $suggest)
                        <a href="{{ URL::to('activity/' . $suggest->id) }}">
                        <div class="actpage-recommend-panel">
                            <div class="actpage-recommend-thumnail" style="background-image:url('{{ $suggest->thumbnail }}')">
                                <p class="actpage-thum-mb-title">{{ $suggest->title }}</p>
                            </div>
                            <div class="actpage-recommend-info">
                                <p class="word-indent-01">{{ $suggest->title }}</p>
                                <p>
                                    <img src="/img/icons/web-price.png"><span>{{ $suggest->min_price }} 元起</span>
                                </p>
                                <p>
                                    <img src="/img/icons/web-date.png"><span>{{--*/ $weekday=['日', '一', '二', '三', '四', '五', '六'][date('w', strtotime($suggest->activity_start))]; echo preg_replace("/(.*)\s(.*):(.*)/", "$1 ( $weekday )", $suggest->activity_start); /*--}}</span>
                                </p>
                                <p class="word-indent-01">
                                    <img src="/img/icons/web-location.png"><span>{{ $suggest->locat_name . $suggest->location }}</span></p>
                                <p>
                                    <img src="/img/icons/web-category.png"><span>{{ $suggest->cat_name }}</span>
                                </p>
                            </div>
                        </div>
                        </a>
                        @endforeach
                    </div>
                    <div class="row actpage-header">
                        <p class="col-md-3 col-xs-4 actpage-header-left">討論區</p>
                        <div class="col-md-9 col-xs-8 actpage-header-dash"></div>
                        <div class="fb-comments" data-href="{{ Request::URL() }}" data-width="100%" data-numposts="5"></div>
                    </div>
                </div>
            </div>
            <!--
                <div class="actpage-holder-content">
                    <div class="actpage-holder-thumnail" style="background-image:url('{{ $activity->host_photo }}')">
                    </div>
                    <div class="actpage-holder-name">@if($activity->nick) {{$activity->nick}} @else {{$activity->hoster}} @endif</div>
                    <div class="actpage-holder-intro word-indent-04">{{ $activity->host_destricption }}</div>
                    <a href="{{ URL('member/'. $activity->hoster ) }}">
                        <div class="actpage-connect">連絡主辦單位</div>
                    </a>
                </div>
                <p class="actpage-bought-title">看看誰已訂購</p>
                <div class="actpage-bought-content">
                </div>
              -->
        </div>
    </div>
</div>
@if ( preg_match( "/酒/", urldecode(Request::segment(2)), $result ))
<div>
    <img src="/img/wine.jpg" style="width:100%;">
</div>
@endif
@endsection

@section('script')
<script type="text/javascript" src="/js/jquery.colorbox.js"></script>
<script type="text/javascript" src="/js/moment.min.js"></script>
<script>
    function share(type, FB) {
        if (FB === undefined) FB = false;
        var obj = {
            method: 'feed',
            redirect_uri: '{{ Request::URL() }}',
            link: '{{ Request::URL() }}',
            display: 'popup',
            link: '{{ Request::URL() }}',
            picture: '{{ asset($activity->thumbnail) }}',
            name: '514 活動頻道 - {{ $activity->title }}',
            caption: '活動由 514 活動頻道 所提供',
            // caption: '活動由 @if($activity->nick) {{$activity->nick}} @else {{$activity->hoster}} @endif 所提供',
            description: '{{ $activity->description }}'
        };

        function callback(response) {
            if (response && response.post_id) {
                document.getElementById('msg').innerHTML = "Post ID: " + response["post_id"];
            }
        }

        switch (type) {
            case 'FBSeed':
                FB.ui(obj, callback);
                break;

            case 'FBMsg':
                obj['method'] = 'send';
                FB.ui(obj, callback);
                break;

            case 'Line':
                window.location = "http://line.me/R/msg/{{ $activity->title }}/?{{ URL::current() }}";
                break;

            case 'WeChat':
                console.log(type);
                break;

            case 'Weibo':
                window.open("http://service.weibo.com/share/share.php?title=&url=http://www.iwine.com.tw/expert_article.php?n_id=307", "_blank")
                break;

            case 'Mail':
                window.location = "mailto:?Subject=從%20514%20活動頻道分享 {{ $activity->title }}&body=這是一個非常好玩的活動%20{{ $activity->title }}%0D%0A點此瀏覽頁面%09{{ Request::URL() }}";
                break;

            default:
                console.log(type);
        }
    }

    $(document).ready(function () {
        var duration = moment("{{$activity->activity_start}}", "YYYY-MM-DD hh:mm:ss").diff(moment(),'days');
        $('.left_number').text('剩 {{ $count }} 位');
        $('.left_date').text('倒數 '+ duration +' 天');

        var RightFixed = $("#RightFixed");
        $(window).scroll(function () {
            if ($(this).scrollTop() > 580) {
                RightFixed.addClass("right-content-fixed");
            } else {
                RightFixed.removeClass("right-content-fixed");
            }
//            if ($(this).scrollTop() > $(".act-page-container").height()-$(window).height()+200){
//                RightFixed.removeClass("right-content-fixed");
//            }

            $(".inline").colorbox({inline:true, width:"90%"});
            $("#click").click(function(){
                $('#click').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");
                return false;
            });
        });

        $('.actpage-purchase').click(function() {
            var ticketIds = [];
            var ticketNumbers = [];
            $('input[name=ticket_id]:checked').each(function() {
                id = $(this).val();
                ticketIds.push($('input[name=ticket-' + id + '-id]').val());
                ticketNumbers.push($('select[name=ticket-' + id + '-number]').val());
            });
            var url = "{{ URL('purchase/'. $activity->id) }}?tickets=" + ticketIds.toString() + "&numbers=" + ticketNumbers.toString();
            window.location.href = url;
            });

        $(".checkbox").on("click", function() {
            if ($(this).closest(".cart-option").hasClass('list-checkbox')) {
                $(this).closest(".cart-option").removeClass('list-checkbox');
            } else {
                $(this).closest(".cart-option").addClass('list-checkbox');
            }
        });

        $('.purchase-mb-submit').click(function() {
            var ticketIds = [];
            var ticketNumbers = [];
            $('input[name=ticket_id]:checked').each(function() {
                id = $(this).val();
                ticketIds.push($('input[name=ticket-' + id + '-id]').val());
                ticketNumbers.push($('select[name=ticket-' + id + '-number]').val());
            });
            var url = "{{ URL('purchase/'. $activity->id) }}?tickets=" + ticketIds.toString() + "&numbers=" + ticketNumbers.toString();
            window.location.href = url;
        });
//
//        $('div#OneClick ul li ul').hide();
//        $('div#OneClick > ul > li >p').click(function(){
//            $(this).next().slideToggle('fast');
//        });
    });
</script>
@endsection
