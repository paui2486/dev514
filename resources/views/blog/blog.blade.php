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
        </div>
        <div class="article-right">
            <div class="row article-relative-art">
                <p>相關文章</p>
                <div class="article-relative-thumnail"></div>
                <div class="article-relative-text">這是馬卡龍</div>

            </div>
            <div class="banner-3">
            </div>
            <div class="article-relative-act">
                <p>相關活動</p>
            </div>
        </div>
    </div>
</div>
@endsection
