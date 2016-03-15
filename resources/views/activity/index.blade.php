@extends('layouts.app')

@section('content')
    <div class="act-page-container">
        <div class="act-page-blur" style="background-image:url('{{ asset($activity->thumbnail )}}')">
<!--            <img src="/img/pics/activity-photo.jpg">-->
        </div>
        <div class="actpage-main-image" style="background-image:url('{{ asset($activity->thumbnail )}}')">
        </div>
        <div class="actpage-panel">
            <div class="actpage-left-content">
                <p class="actpage-title">{{ $activity->title }}</p>
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
                        <p class="actpage-header-left">推薦活動</p>
                        <div class="actpage-header-dash"></div>
                    </div>
                    <div class="row actpage-recommend">
                        @foreach($suggests as $suggest)
                        <a href="{{ URL::to('activity/' . $activity->category . '/' . $suggest->title ) }}">
                            <div class="actpage-recommend-panel">
                                <div class="actpage-recommend-thumnail" style="background-image:url('{{ asset($suggest->thumbnail) }}')"></div>
                                <div class="actpage-recommend-info">
                                    <p class="word-indent-01"><strong>{{ $suggest->title }}</strong></p>
                                    <p class="word-indent-02">{{ $suggest->description }}</p>
                                    <li>{{ $suggest->min_price }} 元 ~</li>
                                    <li>{{ preg_replace("/(.*)\s(.*)/", "$1", $suggest->activity_start) }}</li>
                                    <li>{{ $suggest->location }}</li>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                    <div class="row actpage-header">
                        <p class="actpage-header-left">討論區</p>
                        <div class="actpage-header-dash"></div>
                        <div id="disqus_thread"></div>
                    </div>
                </div>
            </div>
            <div class="actpage-right-content">
                <p class="actpage-cart-title">{{ $activity->title }}</p>
                <div class="actpage-cart-content">
                    <div class="row actpage-cart-info actpage-time-block">
                        <div class="row" style="margin:0px;">
                        <img src="{{ asset('/img/icons/carttime.png') }}">
                        <p>活動時間</p>
                        </div>
                        @if(count($tickets)>0)
                            @foreach($tickets as $ticket)
                            <div class="actpage-cart-time">
                                <div class="actpage-cart-time01">
                                    <p>
                                        {{--*/ $weekday=['日', '一', '二', '三', '四', '五', '六'][date('w', strtotime($activity->activity_start))]; echo preg_replace("/(.*)\s(.*):(.*)/", "$1 ( $weekday ) $2", $ticket->ticket_start) /*--}}
                                    </p>
                                </div>
                                <div>～</div>
                                <div class="actpage-cart-time02">
                                    <p>
                                        {{--*/ $weekday=['日', '一', '二', '三', '四', '五', '六'][date('w', strtotime($activity->activity_start))]; echo preg_replace("/(.*)\s(.*):(.*)/", "$1 ( $weekday ) $2", $ticket->ticket_end) /*--}}
                                    </p>
                                </div>
                            </div>
                            <div class="actpage-surplus">
                                <span>剩 {{ $ticket->left_over }} 位</span>
                            </div>
                            @endforeach
                        @else
                          <div class="actpage-cart-time">
                              所有票卷已銷售完畢！
                          </div>
                        @endif
                    </div>
                     <div class="actpage-cart-info">
                        <div class="row" style="margin:0px;">
                        <img src="{{ asset('/img/icons/carttimelong.png') }}">
                        <p>活動長度</p>
                            <div class="actpage-cart-timelength">
                                {{ $activity->time_range }} 小時
                            </div>
                        </div>
                    </div>
                    <div class="actpage-cart-info">
                        <div class="row" style="margin:0px;">
                        <img src="{{ asset('/img/icons/cartprice.png') }}">
                        <p>{{ $activity->max_price }} ~ {{ $activity->min_price }} 元</p>
                        </div>
                    </div>

                    <div class="actpage-cart-info">
                        <div class="row" style="margin:0px;">
                        <img src="{{ asset('/img/icons/cartlocation.png') }}">
                        <p>{{ $activity->location }}</p>
                        </div>
                    </div>
                    <div class="actpage-cart-info actpage-last-block">
                        <div class="row" style="margin:0px;">
                        <img src="{{ asset('/img/icons/cartlanguage.png') }}">
                        <p>{{ $activity->remark }}</p>
                        </div>
                    </div>
                    @if(count($tickets)>0)
                        <a href="{{ URL('purchase/'. $activity->category .'/'. $activity->title) }}"><div class="row actpage-purchase">前往訂購</div></a>
                    @else
                        <div class="row actpage-purchase" onclick="alert('抱歉！目前已無票卷可供您訂購')">無法訂購</div>
                    @endif
                </div>
                <div class="actpage-holder-content">
                    <div class="actpage-holder-thumnail" style="background-image:url('{{ asset($activity->host_photo) }}')">
                    </div>
                    <div class="actpage-holder-name">{{ $activity->hoster }}</div>
                    <div class="actpage-holder-intro word-indent-04">{{ $activity->host_destricption }}</div>
                    <a href="{{ URL('member/'. $activity->hoster ) }}">
                        <div class="actpage-connect">連絡主辦單位</div>
                    </a>
                </div>
                <p class="actpage-bought-title">看看誰已訂購</p>
                <div class="actpage-bought-content">

                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
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

<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/zh_TW/sdk.js#xfbml=1&version=v2.5&appId=1516021815365717";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));
</script>

<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript" rel="nofollow">comments powered by Disqus.</a></noscript>

@endsection
