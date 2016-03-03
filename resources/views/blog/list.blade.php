@extends('layouts.blog')

@section('content')
<div class="blog-category-container">
    <div class="row blog-category-content">
        <div class="row blog-category-logo">
            <p>{{ current($blogList)->category_name }}</p>
            <img src="{{ asset( current($blogList)->category_logo ) }}">
        </div>
        @if( current($blogList)->id )
            @foreach( $blogList as $blog )
            <div class="row blog-category-panel">
                <a href="{{ URL::to( 'blog/' . $blog->category_name . '/' . $blog->title ) }}">
                    <div class="blog-category-thumnail"
                         style="background-image:url( {{ asset($blog->thumbnail) }} )">
                    </div>
                </a>
                <div class="blog-category-text">
                    <div class="category-title">
                        <a href="{{ URL::to( 'blog/' . $blog->category_name . '/' . $blog->title ) }}">{{ $blog->title }}</a>
                    </div>
                    <div class="category-info">
                        <p><span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                            by {{ $blog->author }}
                        </p>
                        <p><span class="glyphicon glyphicon-time" aria-hidden="true"></span>
                            {{ $blog->created_at }}
                        </p>
                    </div>
                    <div class="category-description word-indent">
                        {{ $blog->description }}
                    </div>
                    <div class="read-article">
                        <a href="{{ URL::to( 'blog/' . $blog->category_name . '/' . $blog->title ) }}">觀看文章 >></a>
                    </div>
                </div>
            </div>
            @endforeach
        @endif
        <!-- <div class="row category-page-number">
            <li><a href="#">1</a></li>
            <li><a href="#">2</a></li>
        </div> -->
    </div>

</div>
@endsection
