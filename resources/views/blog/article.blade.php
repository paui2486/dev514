@extends('layouts.blog')

@section('content')
<div class="article-container">
    <div class="article-content">
        <div class="article-left">
           <div class="row article-left-header">
                <div class="article-left-title">
<!--                    下午茶時間到囉～一起吃點心！-->
                       {{ $article -> title }}
                </div>
               
                <div class="article-share">
                    <div class="fb-share-button" data-href="{{ Request::URL() }}" data-layout="button_count">
                    </div>
                </div>
            </div>
            <div class="row article-left-info">
                <p class="article-create-at">
<!--                    2016/02/29-->
                    {{ $article -> created_at }}
                </p>
                 <p class="article-author">
<!--                    By Lance大大-->
                     By {{ $article -> name }}
                </p>
                <p class="article-count">
<!--                    閱覽次數：394-->
                    <span><img src="/img/icons/eye-02.png"></span> {{ $article -> counter }}人
                </p>
            </div>
            <div class="article-left-content">
                {!! $article -> content !!}

            </div>
            <div class="article-left-tag">
            </div>
            <div class="article-left-comment">
            </div>
            <div id="disqus_thread"></div>
        </div>
        <div class="article-right">
            <div class="row relative-art">
                <p>相關文章</p>
                @if (count($relate_articles) == 0)
                <img src="/img/icons/noart.png">
                @else
                <div class="row article-relative-content">
                    @foreach ($relate_articles as $relate_article)
                    <div class="row" style="margin:0 0 20px 0;">
                        <div class="article-relative-thumnail" style="background-image:url('{{ asset( $relate_article -> thumbnail ) }}')">
                        </div>
                        <div class="article-relative-text word-indent-02">
                           {{ $relate_article -> title }}
                        </div>
                        <div class="article-relative-time">
                             {{ $relate_article -> created_at }}
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
            <div class="row relative-act">
                <p>相關活動</p>
                @if (count($relate_activities) == 0)
                <img src="/img/icons/noact.png">
                @else
                <div class="row activity-relative-content">
                    @foreach ($relate_activities as $relate_activity)
                    <div class="row" style="margin:0 0 20px 0;">
                        <div class="activity-relative-thumnail" style="background-image:url('{{ asset($relate_activity -> thumbnail) }}')">
                        </div>
                        <div class="activity-relative-text word-indent-02">
                            {{ $relate_activity -> title }}
                        </div>
                        <div class="activity-relative-time">
                            {{ $relate_activity -> created_at }}
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
            <div class="banner-3">
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
var disqus_config = function () {
this.page.url = "{{ Request::URL() }}";
this.page.identifier = "{{ $article -> title }}";
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
