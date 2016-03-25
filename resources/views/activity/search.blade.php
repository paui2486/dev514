@extends('layouts.app')

@section('meta')
    @foreach($meta as $key => $value)
        <meta {{ $key }} content="{{ $value }}">
    @endforeach
    <title>活動列表 - 514 活動頻道</title>
@endsection

@section('content')
<div class ="content" style="margin-top:100px">
    <div class="col-sm-4">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div>
            <p>想和誰去</p>
            @foreach( $filter['who'] as $withWho )
                <label class="checkbox-inline">
                    <input type="checkbox" class="checkbox" id="inlineCheckbox1" value="{{ $withWho->id }}"> {{ $withWho->name }}
                </label>
            @endforeach
        </div>
        <div>
            <p>想玩什麼</p>
            @foreach( $filter['what'] as $playWhat )
                <label class="checkbox-inline">
                    <input type="checkbox" id="inlineCheckbox2" value="{{ $playWhat->id }}"> {{ $playWhat->name }}
                </label>
            @endforeach
        </div>
        <div>
            <p>想去哪兒</p>
            @foreach( $filter['where'] as $goWhere )
                <label class="checkbox-inline">
                    <input type="checkbox" id="inlineCheckbox3" value="{{ $goWhere->id }}"> {{ $goWhere->name }}
                </label>
            @endforeach
        </div>
        <div>
            <p>時間</p>
            @foreach( $filter['when'] as $playAt )
                <label class="checkbox-inline">
                    <input type="checkbox" id="inlineCheckbox4" value="{{ $playAt->id }}"> {{ $playAt->name }}
                </label>
            @endforeach
        </div>
        <div>
            <p>預算多少</p>
            @foreach( $filter['price'] as $price )
                <label class="checkbox-inline">
                    <input type="checkbox" id="inlineCheckbox4" value="{{ $price->id }}"> {{ $price->name }}
                </label>
            @endforeach
        </div>
    </div>
    <div class="col-sm-8">
        <div class="row activity-content"></div>
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

    // console.log(eventData);
    function showResult ( data ) {

        var activityRow = new String();
        // activityRow.length = 0;
        console.log(data);
        for ( var eventIndex in data ) {
            activityRow += '<div class="row blog-category-panel"> \
                <a href="{{ URL::to( 'activity/')}}/' + eventData[eventIndex]['category'] + '/' + eventData[eventIndex]['title'] + '"> \
                <div class="blog-category-thumnail" style="background-image:url(\''+ eventData[eventIndex]['thumbnail']  +'\')"> </div> </a> \
                <div class="blog-category-text"> <div class="category-title"> \
                <a href="{{ URL::to( 'activity/')}}/' + eventData[eventIndex]['category'] + '/' + eventData[eventIndex]['title'] + '">'+ eventData[eventIndex]['title'] +'</a> \
                </div> <div class="category-info"> <p> <span class="glyphicon glyphicon-time" aria-hidden="true"></span> \
                ' + getDay(eventData[eventIndex]['activity_start']) + " " + getWeekday(eventData[eventIndex]['activity_start']) + '</p> </div> \
                <div class="category-description word-indent">' + eventData[eventIndex]['description'] + '</div>  <div class="read-article"> \
                <a href="{{ URL::to( 'activity/')}}/' + eventData[eventIndex]['category'] + '/' + eventData[eventIndex]['title'] + '">進入活動 >> </a> \
                </div> </div> </div> <div class="row category-page-number"> links </div> ';
        }
        $('.activity-content').html(activityRow);
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
