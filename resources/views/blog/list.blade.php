@extends('layouts.blog')

@section('content')
<div class="blog-category-container">
    <div class="row blog-category-content">
        <div class="row blog-category-logo">
            <p>{{ $category->name }}</p>
            <img src="{{ asset($category->logo) }}">
        </div>
        @foreach( $blogList as $blog )
        <div class="row blog-category-panel">
            <a href="{{ URL::to( 'blog/' . $category->name . '/' . $blog->title ) }}">
                <div class="blog-category-thumnail"
                     style="background-image:url( {{ asset($blog->thumbnail) }} )">
                </div>
            </a>
            <div class="blog-category-text">
                <div class="category-title">
                    <a href="{{ URL::to( 'blog/' . $category->name . '/' . $blog->title ) }}">{{ $blog->title }}</a>
                </div>
                <div class="category-info">
                    <p><span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                        by {{ $blog->author }}
                    </p>
                    <p><span class="glyphicon glyphicon-time" aria-hidden="true"></span>
                        {{ preg_replace("/(.*)\s(.*)/", "$1", $blog->created_at)  }}
                    </p>
                </div>
                <div class="category-description word-indent">
                    {{ $blog->description }}
                </div>
                <div class="read-article">
                    <a href="{{ URL::to( 'blog/' . $category->name . '/' . $blog->title ) }}">觀看文章 >></a>
                </div>
            </div>
        </div>
        @endforeach
        <div class="row category-page-number">
            {!! $blogList->links() !!}
        </div>
    </div>

</div>
@endsection
