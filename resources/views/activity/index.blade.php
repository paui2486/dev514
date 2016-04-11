@extends('layouts.app') @section('meta') @foreach($meta as $key => $value)
<meta {{ $key }} content="{{ $value }}"> @endforeach
<title>514活動頻道 - {{ $activity->title }}</title>
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
                <p class="col-md-6"> 剩 110 位 </p>
                <p class="col-md-6"> 倒數 10 天 </p>
            </div>
            <div class="row actpage-cart-content">
                <p class="actpage-buy-now">{{ $activity->title }}</p>
                <div class="row actpage-cart-ticket">
                    @foreach($tickets as $ticket)
                    <div class="row cart-option">
                        <div class="col-md-8">
                        <input name="ticket" type="checkbox" value="ticket-name" id="{{ $ticket->name }}"><label for="{{ $ticket->name }}">{{ $ticket->name }}</label>
                        </div>
                        <p class="col-md-4 actpage-surplus">剩 {{ $ticket->left_over }} 張</p>
                    </div>
                    <div class="cart-number">
                        <p>請選擇票券數量：
                        <select>
                            <option value="1">0</option>
                            <option value="1">1</option>
                            <option value="1">2</option>
                            <option value="1">3</option>
                            <option value="1">4</option>
                            <option value="1">5</option>
                        </select>
                        </p>
                    </div>
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
                <a href="{{ URL('purchase/'. $activity->category .'/'. $activity->title) }}">
                    <div class="row actpage-purchase">
                        <p><img src="/img/icons/playicon.png">讓生活更有意思!</p>
                    </div>
                </a>
                @else
                <div class="row actpage-purchase" onclick="alert('抱歉！目前已無票券可供您訂購')">sorry！票券已售完！</div>
                @endif
            
                <div id="shareBtn" class="btn btn-sm btn-success actpage-share">
                   分享到Facebook
                </div>
            </div>
        </div>
        <div class="purchase-mb-btn">
            @if(count($tickets)>0)
            <a href="{{ URL('purchase/'. $activity->category .'/'. $activity->title) }}">
                <div class="row actpage-purchase">
                    <p><img src="/img/icons/playicon.png">讓生活更有意思!</p>
                </div>
            </a>
            @else
            <div class="row actpage-purchase" onclick="alert('抱歉！目前已無票券可供您訂購')">無法訂購</div>
            @endif
        </div>
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
                                <p class="word-indent-02">{{ $suggest->description }}</p>
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
</div>
@if ( preg_match( "/酒/", urldecode(Request::segment(2)), $result ))
<div>
    <img src="{{asset('img/wine.jpg')}}" style="width:100%;">
</div>
@endif @endsection @section('script')
<script src="{{asset('js/jquery-ui-1.9.2.custom.min.js')}}"></script>

<script>
    // var disqus_config = function () {
    //     this.page.url = "{{ Request::URL() }}";
    //     this.page.identifier = "{{ $activity->title }}";
    // };
    //
    // (function() {
    //     var d = document, s = d.createElement('script');
    //     s.src = '//514life.disqus.com/embed.js';
    //     s.setAttribute('data-timestamp', +new Date());
    //     (d.head || d.body).appendChild(s);
    // })();

    document.getElementById('shareBtn').onclick = function () {
        // calling the API ...
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
            } else {
                console.log("User didin't share the story, we'll do something else");
            }
        }
        FB.ui(obj, callback);
    }

    $(document).ready(function () {
        // console.log( {!! json_encode($tickets) !!} );
        var RightFixed = $("#RightFixed");

        $(window).scroll(function () {
            if ($(this).scrollTop() > 580) {
                RightFixed.addClass("right-content-fixed");
            } else {
                RightFixed.removeClass("right-content-fixed");
            }
        });
    });
    
    $('div#OneClick ul li ul').hide();
    $('div#OneClick > ul > li >p').click(function(){
        $(this).next().slideToggle('fast');
    });
</script>
<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript" rel="nofollow">comments powered by Disqus.</a></noscript>

@endsection