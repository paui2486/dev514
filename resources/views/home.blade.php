@extends('layouts.app')

@foreach( $home->meta as $metaKey => $metaValue )
    <meta {{ $metaKey }} content="{{ $metaValue }}">
@endforeach

@section('content')

<div class="container">
    <div class="row">
        <div class="panel-banner">
            @foreach( $home->banner as $banner )
                {{-- 這是在給定 each banner image source, p 只是假的 --}}
                <img src={{ $banner->image }} /> </img>
                {{-- 這是在給定 each banner caption source, p 只是假的 --}}
                <p>{{ $banner->caption }}</p>
            @endforeach
        </div>
    </div>
    <div class="row">
        <div class="panel-filter">
            <select name="type" id="types" >
                <option style="display:none">想和誰去</option>
                @foreach( $home->filter->who as $key_with => $with_who )
                    <option value="{{ $key_with }}"> {{ $with_who }} </option>
                @endforeach
            </select>

            <select name="type" id="types" >
                <option style="display:none">想玩什麼</option>
                @foreach( $home->filter->what as $key_play => $play_what )
                    <option value="{{ $key_play }}"> {{ $play_what }} </option>
                @endforeach
            </select>

            <select name="type" id="types" >
                <option style="display:none">想去哪兒</option>
                @foreach( $home->filter->where as $key_where => $go_where )
                    <option value="{{ $key_where }}"> {{ $go_where }} </option>
                @endforeach
            </select>

            <select name="type" id="types" >
                <option style="display:none">預算多少</option>
                @foreach( $home->filter->price as $key_price => $price )
                    <option value="{{ $key_price }}"> {{ $price }} </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Dashboard
                </div>

                <div class="panel-body">
                    <div class="new-blog">
                        @foreach( $home->newBlog as $blog )
                            <div class="block">
                                <div class="blog-thumbnail">   {{ $blog->thumbnail }}   </div>
                                <div class="blog-title">       {{ $blog->title }}       </div>
                                <div class="blog-created_at">  {{ $blog->created_at }}  </div>
                                <div class="blog-category">    {{ $blog->category }}    </div>
                                <div class="blog-author">      {{ $blog->author }}      </div>
                                <div class="blog-description"> {{ $blog->description }} </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="new-activity">
                        @foreach( $home->newActivity as $newActivity )
                            <div class="block">
                                <div class="activity-id">          {{ $newActivity->activity_id }} </div>
                                <div class="activity-title">       {{ $newActivity->title }}       </div>
                                <div class="activity-count">       {{ $newActivity->count }}       </div>
                                <div class="activity-thumbnail">   {{ $newActivity->thumbnail }}   </div>
                                <div class="activity-description"> {{ $newActivity->description }} </div>
                                <div class="activity-price">       {{ $newActivity->price }}       </div>
                                <div class="activity-date">        {{ $newActivity->date }}        </div>
                                <div class="activity-location">    {{ $newActivity->location }}    </div>
                                <div class="activity-orginizer">   {{ $newActivity->orginizer }}   </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="total-activity">
                        @foreach( $home->totalActivity as $eachTypeActivity )
                            <div class="block">
                                <div class="activity-category-id">          {{ $eachTypeActivity->cat_id }}         </div>
                                <div class="activity-category-thumbnail">   {{ $eachTypeActivity->cat_thumbnail }}  </div>
                                <div class="activity-category-title">       {{ $eachTypeActivity->cat_title }}      </div>
                                <div class="activity-category-logo">        {{ $eachTypeActivity->cat_logo }}       </div>
                                <div class="activity-category-content">
                                    @foreach( $eachTypeActivity->cat_content as $activity )
                                        <div class="block">
                                            <div class="activity-id">          {{ $newActivity->activity_id }} </div>
                                            <div class="activity-title">       {{ $newActivity->title }}       </div>
                                            <div class="activity-count">       {{ $newActivity->count }}       </div>
                                            <div class="activity-thumbnail">   {{ $newActivity->thumbnail }}   </div>
                                            <div class="activity-description"> {{ $newActivity->description }} </div>
                                            <div class="activity-price">       {{ $newActivity->price }}       </div>
                                            <div class="activity-date">        {{ $newActivity->date }}        </div>
                                            <div class="activity-location">    {{ $newActivity->location }}    </div>
                                            <div class="activity-orginizer">   {{ $newActivity->orginizer }}   </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
