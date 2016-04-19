@extends('layouts.app') @section('meta') @foreach($meta as $key => $value)
<meta {{ $key }} content="{{ $value }}"> @endforeach
<title>514活動頻道 - {{ $activity->title }}</title>
<link rel="stylesheet" href="/css/colorbox.css" />
@endsection
@section('content')

<div class="act-page-container">
    <div class="act-page-blur" style="background-image:url('{{ asset($activity->thumbnail )}}')">
        <!--            <img src="/img/pics/activity-photo.jpg">-->
    </div>
    <div class="actpage-main-image" style="background-image:url('{{ asset($activity->thumbnail )}}')">
        <p class="actpage-mb-price">$ {{ $activity->min_price }} NTD起 </p>
    </div>
    <div class="actpage-content">
        <div id="RightFixed" class="col-md-4 actpage-right-content">
            <div class="row actpage-cart-title">
                <p id="left_number" class="col-md-6"> 剩  位 </p>
                <p id="left_date" class="col-md-6"> 倒數  天 </p>
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
                            <input name="ticket_id" type="checkbox" value="{{ $key }}" id="{{ $ticket->name }}"><label for="{{ $ticket->name }}">{{ $ticket->name }}</label>
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
            </div>
            <div class="purchase-block">
                @if(count($tickets)>0)
                <div class="row actpage-purchase">
                    <p><img src="/img/icons/playicon.png"> GO!讓生活更有意思!</p>
                </div>
                @else
                <div class="row actpage-purchase" onclick="alert('抱歉！目前已無票券可供您訂購')">sorry！票券已售完！</div>
                @endif

                <div id="shareBtn" class="btn btn-sm btn-success actpage-share">
                   分享到Facebook
                </div>
            </div>
        </div>
<!--------------mobile submit button--------------->
        <div class="purchase-mb-btn">
            @if(count($tickets)>0)
            <a class='inline' href="#inline_content">
            <div class="row actpage-mb-purchase">
               <p><img src="/img/icons/playicon.png">GO!讓生活更有意思!</p>
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
                                <input name="ticket_id" type="checkbox" value="{{ $key }}" id="{{ $ticket->name }}"><label for="{{ $ticket->name }}">{{ $ticket->name }}</label>
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
            <div class="row actpage-purchase" onclick="alert('抱歉！目前已無票券可供您訂購')">無法訂購</div>
            @endif
        </div>
<!--------------mobile submit buttonv end--------------->
        <div class="row actpage-dashboard">
            <div class="col-md-2 col-xs-4">
                <a href="{{ URL('member/'. $activity->hoster ) }}">
                    <div class="actpage-holder-thumnail" style="background-image:url('{{ asset($activity->host_photo) }}')">
                    </div>
                    <div class="actpage-holder-name">
                        @if($activity->nick) {{$activity->nick}} @else {{$activity->hoster}} @endif
                    </div>
                </a>
            </div>

            <div class="col-md-6 col-xs-8 actpage-dashboard-info">
                <p>{{ $activity->title }}</p>
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
                    <div class="dashboard-text">
                        所有票券都賣完囉！
                    </div>
                    @endif
                </div>

                <div class="dashboard-block dashboard-price">
                    <img src="/img/icons/info-price.png">
                    <div class="dashboard-text">
                        <p>$ {{ $activity->min_price }} NTD起</p>
                    </div>
                </div>
                <div class="dashboard-block">
                    <img src="/img/icons/info-where.png">
                    <div class="dashboard-text">
                        {{ $activity->location }}
                    </div>
                </div>
            </div>
        </div>
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
                        <p class="col-md-3 col-xs-4 actpage-header-left">同場加映</p>
                        <div class="col-md-9 col-xs-8 actpage-header-dash"></div>
                    </div>
                    <div class="row actpage-recommend">
                        @foreach($suggests as $suggest)
                        <div class="actpage-recommend-panel">
                            <a href="{{ URL::to('activity/' . $activity->category . '/' . $suggest->title ) }}">
                                <div class="actpage-recommend-thumnail" style="background-image:url('{{ asset($suggest->thumbnail) }}')"></div>
                            </a>
                            <div class="actpage-recommend-info">
                                <p class="word-indent-01"><strong>{{ $suggest->title }}</strong></p>
                                <li>{{ $suggest->min_price }} 元 ~</li>
                                <li>{{ preg_replace("/(.*)\s(.*)/", "$1", $suggest->activity_start) }}</li>
                                <li><span class="word-indent-01">{{ $suggest->location }}</span></li>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="row actpage-header">
                        <p class="col-md-3 col-xs-4 actpage-header-left">討論區</p>
                        <div class="col-md-9 col-xs-8 actpage-header-dash"></div>
                        <!-- <div id="disqus_thread"></div> -->
                        <div class="fb-comments" data-href="{{ Request::URL() }}" data-width="100%" data-numposts="5"></div>
                    </div>
                </div>
            </div>


            <!--
                <div class="actpage-holder-content">
                    <div class="actpage-holder-thumnail" style="background-image:url('{{ asset($activity->host_photo) }}')">
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
    <img src="{{asset('img/wine.jpg')}}" style="width:100%;">
</div>
@endif
@endsection

@section('script')
<script src="{{asset('js/jquery-ui-1.9.2.custom.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/moment.min.js') }}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="{{ asset('js/jquery.colorbox.js') }}"></script>

<script>
    document.getElementById('shareBtn').onclick = function () {
        var obj = {
            method: 'feed',
            redirect_uri: '{{ Request::URL() }}',
            display: 'popup',
            link: '{{ Request::URL() }}',
            picture: '{{ asset($activity->thumbnail) }}',
            name: '514 活動頻道 - {{ $activity->title }}',
            caption: '活動由 @if($activity->nick) {{$activity->nick}} @else {{$activity->hoster}} @endif 所提供',
            description: '{{ $activity->description }}'
        };

        function callback(response) {
            if (response && response.post_id) {
                document.getElementById('msg').innerHTML = "Post ID: " + response["post_id"];
            }
        }
        FB.ui(obj, callback);
    }

    $(document).ready(function () {
        var duration = moment("{{$activity->activity_start}}", "YYYY-MM-DD hh:mm:ss").diff(moment(),'days');
        $('#left_number').text('剩 {{ $count }} 位');
        $('#left_date').text('倒數 '+ duration +' 天');

        var RightFixed = $("#RightFixed");
        $(window).scroll(function () {
            if ($(this).scrollTop() > 580) {
                RightFixed.addClass("right-content-fixed");
            } else {
                RightFixed.removeClass("right-content-fixed");
            }

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
        var url = "{{ URL('purchase/'. $activity->category .'/'. $activity->title) }}?tickets=" + ticketIds.toString() + "&numbers=" + ticketNumbers.toString();
        window.location.href = url;
        });
        
    $('.purchase-mb-submit').click(function() {
        var ticketIds = [];
        var ticketNumbers = [];
        $('input[name=ticket_id]:checked').each(function() {
            id = $(this).val();
            ticketIds.push($('input[name=ticket-' + id + '-id]').val());
            ticketNumbers.push($('select[name=ticket-' + id + '-number]').val());
        });
        var url = "{{ URL('purchase/'. $activity->category .'/'. $activity->title) }}?tickets=" + ticketIds.toString() + "&numbers=" + ticketNumbers.toString();
        window.location.href = url;
        
    });

    $('div#OneClick ul li ul').hide();
    $('div#OneClick > ul > li >p').click(function(){
        $(this).next().slideToggle('fast');
    });
         });
</script>
@endsection
