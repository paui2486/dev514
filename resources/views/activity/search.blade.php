@extends('layouts.app')

@section('meta')
    @foreach($meta as $key => $value)
        <meta {{ $key }} content="{{ $value }}">
    @endforeach
    <title>活動列表 - 514 活動頻道</title>
@endsection

@section('content')
<div class="blog-category-container">
    <div class="row blog-category-content">
        <div class="row blog-category-logo">
            <p>name</p>
            <img src=" asset($category->logo) ">
        </div>
        <div class="row blog-category-panel">
            <a href="{{ URL::to( 'activity/' ) }}">
                <div class="blog-category-thumnail"
                     style="background-image:url(  asset($activity->thumbnail)  )">
                </div>
            </a>
            <div class="blog-category-text">
                <div class="category-title">
                    <a href="{{ URL::to( 'activity/' ) }}"> $activity->title </a>
                </div>
                <div class="category-info">
                    <p><span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                        by $activity->author
                    </p>
                    <p><span class="glyphicon glyphicon-time" aria-hidden="true"></span>
                        preg_replace("/(.*)\s(.*)/", "$1", $activity->created_at)
                    </p>
                </div>
                <div class="category-description word-indent">
                    activity->description
                </div>
                <div class="read-article">
                    <a href="{{ URL::to( 'activity/' ) }}">進入活動 >></a>
                </div>
            </div>
        </div>
        <div class="row category-page-number">
            links
        </div>
    </div>

</div>
@endsection
