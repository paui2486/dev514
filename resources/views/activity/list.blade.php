@extends('layouts.app')

@section('meta')
    @foreach($meta as $key => $value)
        <meta {{ $key }} content="{{ $value }}">
    @endforeach
    <title>活動列表 - {{$category->name}} - 514 活動頻道</title>
@endsection

@section('content')
<div class="blog-category-container">
    <div class="row blog-category-content">
        <div class="row blog-category-logo">
            <p>{{ $category->name }}</p>
            <img src="{{ asset($category->logo) }}">
        </div>
        @foreach( $activity_list as $activity )
        <div class="row blog-category-panel">
            <a href="{{ URL::to( 'activity/' . $category->name . '/' . $activity->title ) }}">
                <div class="blog-category-thumnail"
                     style="background-image:url( {{ asset($activity->thumbnail) }} )">
                </div>
            </a>
            <div class="blog-category-text">
                <div class="category-title">
                    <a href="{{ URL::to( 'activity/' . $category->name . '/' . $activity->title ) }}">{{ $activity->title }}</a>
                </div>
                <div class="category-info">
                    <p><span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                        by {{ $activity->author }}
                    </p>
                    <p><span class="glyphicon glyphicon-time" aria-hidden="true"></span>
                        {{ preg_replace("/(.*)\s(.*)/", "$1", $activity->created_at)  }}
                    </p>
                </div>
                <div class="category-description word-indent">
                    {{ $activity->description }}
                </div>
                <div class="read-article">
                    <a href="{{ URL::to( 'activity/' . $category->name . '/' . $activity->title ) }}">進入活動 >></a>
                </div>
            </div>
        </div>
        @endforeach
        <div class="row category-page-number">
            {!! $activity_list->links() !!}
        </div>
    </div>

</div>
@endsection
