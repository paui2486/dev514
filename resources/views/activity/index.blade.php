@extends('layouts.app')

@section('meta')
    @foreach($meta as $key => $value)
        <meta {{ $key }} content="{{ $value }}">
    @endforeach
    <title>514活動頻道 - {{ $activity->title }}</title>
@endsection

@section('content')

    <div class="act-page-container">
        <div class="act-page-blur" style="background-image:url('{{ asset($activity->thumbnail )}}')">
<!--            <img src="/img/pics/activity-photo.jpg">-->
        </div>
        <div class="actpage-main-image" style="background-image:url('{{ asset($activity->thumbnail )}}')">
        </div>
        <div class="actpage-content">
          <div id="RightFixed" class="col-md-4 actpage-right-content">
                <p class="actpage-cart-title">{{ $activity->title }}</p>
                <div class="row actpage-cart-content">
                    <p class="actpage-buy-now">馬上訂購票券</p>
                    <div class="row actpage-cart-ticket">
                        @foreach($tickets as $ticket)
                        <div class="row cart-option">
                        <label class="col-md-8 label_radio" for="radio-03">
                            <input name="ticket" type="radio" value="ticket-name" checked>{{ $ticket->name }}
                        </label>
                        <p class="col-md-4 actpage-surplus">剩 {{ $ticket->left_over }} 位</p>
                        </div>
                        @endforeach  
                    </div>
                
                @if(count($tickets)>0)
                <a href="{{ URL('purchase/'. $activity->category .'/'. $activity->title) }}">
                    <div class="row actpage-purchase">Let's Go</div>
                </a>
                @else
                <div class="row actpage-purchase" onclick="alert('抱歉！目前已無票券可供您訂購')">無法訂購</div>
                @endif
                </div>
            </div>
         <div class="row actpage-dashboard">
                    <div class="col-md-2">
                        <a href="{{ URL('member/'. $activity->hoster ) }}">
                            <div class="actpage-holder-thumnail" style="background-image:url('{{ asset($activity->host_photo) }}')">
                            </div>
                            <div class="actpage-holder-name">
                                @if($activity->nick) {{$activity->nick}} @else {{$activity->hoster}} @endif
                            </div>
                        </a>
                    </div>

                    <div class="col-md-6 actpage-dashboard-info">
                        <p>{{ $activity->title }}</p>
                        <div class="dashboard-block-date">
                            <img src="/img/icons/info-date.png">
                            @if(count($tickets)>0)
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

                        <div class="dashboard-block">
                            <img src="/img/icons/info-price.png">
                            <div class="dashboard-text">
                                 <p>{{ $activity->max_price }} ~ {{ $activity->min_price }} 元</p>
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
            <div class="col-md-8 actpage-left-content">
                <div class="actpage-activity-content">
                    <div class="row actpage-header">
                        <p class="actpage-header-left">活動介紹</p>
                        <div class="actpage-header-dash"></div>
                    </div>
                    <div class="actpage-introduce">
                        {{ $activity->description }}
                    </div>
                    <div class="row actpage-header">
                        <p class="actpage-header-left">購票說明</p>
                        <div class="actpage-header-dash"></div>
                    </div>
                    <div class="actpage-ticket">
                        {!! $activity->content !!}
                    </div>
                    <div class="row actpage-header">
                        <p class="actpage-header-left">同場加映</p>
                        <div class="actpage-header-dash"></div>
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
                        <p class="actpage-header-left">討論區</p>
                        <div class="actpage-header-dash"></div>
                        <div id="disqus_thread"></div>
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
            <img src="{{asset('img/wine.jpg')}}">
        </div>
    @endif
@endsection

@section('script')
<script src="{{asset('js/jquery-ui-1.9.2.custom.min.js')}}"></script>

<script>
var disqus_config = function () {
    this.page.url = "{{ Request::URL() }}";
    this.page.identifier = "{{ $activity->title }}";
};

(function() {
    var d = document, s = d.createElement('script');

    s.src = '//514life.disqus.com/embed.js';

    s.setAttribute('data-timestamp', +new Date());
    (d.head || d.body).appendChild(s);
})();
</script>

<script>
(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/zh_TW/sdk.js#xfbml=1&version=v2.5&appId=1516021815365717";
    fjs.parentNode.insertBefore(js, fjs);
} (document, 'script', 'facebook-jssdk'));
</script>

<script>
$(document).ready(function () {

    var RightFixed = $("#RightFixed");


    $(window).scroll(function() {
        if ($(this).scrollTop() > 580) {
            RightFixed.addClass("right-content-fixed");
        } else {
            RightFixed.removeClass("right-content-fixed");
        }
//        console.log(scrollbottom);

//        var scrollbottom = $(this).scrollTop() - $(window).height() ;
//        if (scrollbottom > 550 ) {
//            RightFixed.addClass ("fixed-bottom");
//        } else {
//            RightFixed.removeClass("fixed-bottom");
//        }
    });

//    RightFixed.on("scroll", function(e) {
//        console.log(1);
//        if (this.scrollTop > 580) {
//            RightFixed.addClass("right-content-fixed");
//        } else {
//            RightFixed.removeClass("right-content-fixed");
//        }
//
//    });
});
</script>

<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript" rel="nofollow">comments powered by Disqus.</a></noscript>

@endsection
