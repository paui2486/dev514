@extends('layouts.blog')

@section('content')
<div class="article-container">
    <div class="article-content">
        <div class="article-left">
           <div class="row article-left-header">
                <div class="article-left-title">
                    <!-- 下午茶時間到囉～一起吃點心！ -->
                    {{ $article -> title }}
                </div>
                <div class="article-share">
                    <ul class="share-buttons">
                        <img src="/img/icons/Facebook.png">
                        <img src="/img/icons/Email.png">
                        <img src="/img/icons/Google.png">
                        <img src="/img/icons/Twitter.png">
                    </ul>
                </div>
            </div>
            <div class="row article-left-info">
                <p class="article-create-at">
                    <!-- 2016/02/29 -->
                    {{ $article -> created_at }}
                </p>
                 <p class="article-author">
                    <!-- By Lance大大 -->
                    By {{ $article -> name }}
                </p>
                <p class="article-count">
                    閱覽次數： {{ $article -> counter }}
                </p>
            </div>
            <div class="article-left-content">
                {!! $article -> content !!}
                <!-- 下午茶時間就是要吃點心啊，不然要幹麻？
                <div class="article-thumnail">
                </div>
                吃完下午茶以後就下班啦 -->
            </div>
            <div class="article-left-tag">
            </div>
            <div class="article-left-comment">
            </div>
            <div id="disqus_thread"></div>

        </div>
        <div class="article-right">
            <div class="row article-relative-art">
                <p>相關文章</p>
                @foreach ($relate_articles as $relate_article)
                    <div>
                        <div> Title : {{ $relate_article -> title }}</div>
                        <div> Image url : {{ $relate_article -> thumbnail }}</div>
                        <div> Create time : {{ $relate_article -> created_at }}</div>
                    </div>
                @endforeach
            </div>
            <div class="banner-3">
            </div>
            <div class="article-relative-act">
                <p>相關活動</p>
                @foreach ($relate_activities as $relate_activity)
                    <div>
                        <div> Title : {{ $relate_activity -> title }}</div>
                        <div> Image url : {{ $relate_activity -> thumbnail }}</div>
                        <div> Create time : {{ $relate_activity -> created_at }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
var disqus_config = function () {
this.page.url = "{{ Request::URL() }}";
this.page.identifier = {{ $article -> title }};
};
(function() {
var d = document,w s = d.createElement('script');

s.src = '//514life.disqus.com/embed.js';

s.setAttribute('data-timestamp', +new Date());
(d.head || d.body).appendChild(s);
})();
</script>
<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript" rel="nofollow">comments powered by Disqus.</a></noscript>
@endsection
