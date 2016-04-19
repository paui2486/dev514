@extends('layouts.app')

@section('meta')
    @foreach($meta as $key => $value)
        <meta {{ $key }} content="{{ $value }}">
    @endforeach
    <title>活動列表 - 514 活動頻道</title>
@endsection

@section('content')
<div class ="row list-container">
    <div class="row list-banner" style="background-image:url('/img/pics/sunmoonlake.jpg')">
        <div class="list-banner-image">
            <img src="/img/pics/banner_title-02.png">
            <p>發現生活周遭美好的事物</p>
        </div>
    </div>
    <div class="list-content">
        <div class="row list-filter col-sm-4">
            <div class="list-filter-panel">
                <p class="list-filter-title"><span class="glyphicon glyphicon-search" aria-hidden="true"></span>搜尋活動</p>
                <div class="list-filter-content">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <!-- <div class="list-filter-row">
                        <p>想和誰去</p>
                        <div class="row list-filter-option">
                        foreach( $filter['who'] as $withWho )
                            <label class="checkbox-inline">
                                <input type="checkbox" class="checkbox" id="inlineCheckbox1" value=" $withWho->id }}"> $withWho->name }}
                            </label>
                        endforeach
                        </div>
                    </div> -->
                    <div class="list-filter-row">
                        <p>想玩什麼</p>
                        <div class="row list-filter-option">
                        @foreach( $filter['what'] as $playWhat  )
                            <label class="checkbox-inline">
                                <input type="checkbox" class="checkbox" id="inlineCheckbox1" value="{{ $playWhat->id }}">{{ $playWhat->name }}
                            </label>
                        @endforeach
                        </div>
                    </div>

                    <div class="list-filter-row">
                        <p>想去哪兒</p>
                        <div class="row list-filter-option">
                        @foreach( $filter['where'] as $goWhere )
                            <label class="checkbox-inline">
                                <input type="checkbox" class="checkbox" id="inlineCheckbox1" value="{{ $goWhere->id }}">{{ $goWhere->name }}
                            </label>
                        @endforeach
                        </div>
                    </div>

                    <div class="list-filter-row">
                        <p>什麼時候</p>
                        <div class="row list-filter-option">
                        @foreach( $filter['when'] as $playAt )
                            <label class="checkbox-inline">
                                <input type="checkbox" class="checkbox" id="inlineCheckbox1" value="{{ $playAt->id }}">{{ $playAt->name }}
                            </label>
                        @endforeach
                        </div>
                    </div>

                    <div class="list-filter-row">
                        <p>預算多少</p>
                        <div class="row list-filter-option">
                        @foreach( $filter['price'] as $price )
                            <label class="checkbox-inline">
                                <input type="checkbox" class="checkbox" id="inlineCheckbox1" value="{{ $price->id }}">{{ $price->name }}
                            </label>
                        @endforeach
                        </div>
                    </div>
                </div>
                <div class="list-mb-content">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <!-- <div class="list-filter-row">
                        <p>想和誰去<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span><p/>
                        <div class="row list-filter-option">
                        foreach( $filter['who'] as $withWho )
                            <label class="checkbox-inline">
                                <input type="checkbox" class="checkbox" id="inlineCheckbox1" value=" $withWho->id }}"> $withWho->name }}
                            </label>
                        endforeach
                        </div>
                    </div> -->
                    <div class="list-filter-row">
                        <p>想玩什麼<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span><p/>
                        <div class="row list-filter-option">
                        @foreach( $filter['what'] as $playWhat  )
                            <label class="checkbox-inline">
                                <input type="checkbox" class="checkbox" id="inlineCheckbox1" value="{{ $playWhat->id }}">{{ $playWhat->name }}
                            </label>
                        @endforeach
                        </div>
                    </div>

                    <div class="list-filter-row">
                        <p>想去哪兒<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span><p/>
                        <div class="row list-filter-option">
                        @foreach( $filter['where'] as $goWhere )
                            <label class="checkbox-inline">
                                <input type="checkbox" class="checkbox" id="inlineCheckbox1" value="{{ $goWhere->id }}">{{ $goWhere->name }}
                            </label>
                        @endforeach
                        </div>
                    </div>

                    <div class="list-filter-row">
                        <p>什麼時候<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span><p/>
                        <div class="row list-filter-option">
                        @foreach( $filter['when'] as $playAt )
                            <label class="checkbox-inline">
                                <input type="checkbox" class="checkbox" id="inlineCheckbox1" value="{{ $playAt->id }}">{{ $playAt->name }}
                            </label>
                        @endforeach
                        </div>
                    </div>

                    <div class="list-filter-row">
                        <p>預算多少<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span><p/>
                        <div class="row list-filter-option">
                        @foreach( $filter['price'] as $price )
                            <label class="checkbox-inline">
                                <input type="checkbox" class="checkbox" id="inlineCheckbox1" value="{{ $price->id }}">{{ $price->name }}
                            </label>
                        @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row list-right-content col-sm-7">
            <ul class="nav nav-tabs">
              <li role="presentation"><a href="#">最熱門</a></li>
              <li role="presentation"><a href="#">時間近</a></li>
              <li role="presentation"><a href="#">最優惠</a></li>
            </ul>
            <div class="list-content-panel">

            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
$(document).ready(function () {
    var eventData = {!! json_encode($activities) !!};
    var search = [];
    showResult(eventData);
    $("input[type=checkbox]").on("click", function() {
        search = $('input:checkbox:checked').map(function() {
             return this.value;
        }).get();
        search.push()
        $.ajax({
             type: "POST",
             headers: { 'X-CSRF-Token' : $('input[name=_token]').val() },
             url: "{{ URL::current() }}",
             data: { 'selects' : search },
             success: function(data) {
                 showResult(data);
             }
        });
    });

    $('.list-mb-content > .list-filter-row > div ').hide();
    $('.list-mb-content > .list-filter-row > p').click(function(){
        $(this).parent().find('.list-filter-option').slideToggle();
    });
    // console.log(eventData);
    function showResult ( data ) {

        var activityRow = new String();
        if (data.length > 0) {
            for ( var eventIndex in data ) {
                activityRow += '<div class="row list-category-panel"> \
                    <a href="{{ URL::to( 'activity/')}}/' + data[eventIndex]['category'] + '/' + data[eventIndex]['title'] + '"> \
                    <div class="col-md-5 col-xs-5 list-category-thumnail" style="background-image:url(\''+ data[eventIndex]['thumbnail']  +'\')"> </div> </a> \
                    <div class="col-md-7 col-xs-7 list-category-text"> <div class="list-category-title"> \
                    <a href="{{ URL::to( 'activity/')}}/' + data[eventIndex]['category'] + '/' + data[eventIndex]['title'] + '">'+ data[eventIndex]['title'] +'</a> \
                    <div class="list-category-description word-indent-02">' + data[eventIndex]['description'] + '</div>  \
                    </div> <div class="list-category-info"> <p> <img src="img/pics/money-icon-02.png"> ' + " $ " + data[eventIndex]['min_price'] + " NTD起 " + ' \
                    </p> \
                    <p> <img src="img/pics/calendar-icon-02.png"> ' + getDay(data[eventIndex]['activity_start']) +  getWeekday(data[eventIndex]['activity_start']) + " ～ " +
                    getDay(data[eventIndex]['activity_end']) + getWeekday(data[eventIndex]['activity_start']) +' </p> \
                    <p> <img src="img/pics/location-icon-02.png"> ' + data[eventIndex]['location'] + ' </p> \
                    </div> \
                    </div> </div> <div class="row list-page-number"></div> ';
            }
        } else {
            activityRow = '<div class="list-attention"> Woops！尚無相關的活動類別！ </div>';
        }

        $('.list-content-panel').html(activityRow);
    }

    function getDay ( datetime ) {
        var DateReg = "";
        var result = /(.*)\s/.exec( datetime );
        return result[0];
    }

    function getWeekday( datetime ) {
        var day_list = ['日', '一', '二', '三', '四', '五', '六'];
        var weekday = new Date(datetime).getDay();
        var week_event = ' ('+ day_list[weekday] +')';
        return week_event;
    }
});
</script>

@endsection
