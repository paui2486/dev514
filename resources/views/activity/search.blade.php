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
        <div class="row list-filter col-md-4 col-sm-4">
            <div class="list-filter-panel">
                <p class="list-filter-title">
                    <span class="glyphicon glyphicon-search" aria-hidden="true"></span>搜尋活動
                </p>
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
                        <p>想找什麼</p>
                        <div class="row list-search">
                            <input class="col-md-8" name="keySearch" type="text" placeholder="請輸入關鍵字...">
                            <button class="btn col-md-4" type="submit">搜尋</button>
                        </div>
                    </div>
                    <div class="list-filter-row">
                        <p>想玩什麼</p>
                        <div class="row list-filter-option">
                        @foreach( $filter['what'] as $playWhat  )
                            <label class="checkbox-inline">
                                <input type="checkbox" class="checkbox" id="inlineCheckbox1" value="{{ $playWhat->id }}" {{ $playWhat->checked }}>{{ $playWhat->name }}
                            </label>
                        @endforeach
                        </div>
                    </div>

                    <div class="list-filter-row">
                        <p>想去哪兒</p>
                        <div class="row list-filter-option">
                        @foreach( $filter['where'] as $goWhere )
                            <label class="checkbox-inline">
                                <input type="checkbox" class="checkbox" id="inlineCheckbox1" value="{{ $goWhere->id }}" {{ $goWhere->checked }}>{{ $goWhere->name }}
                            </label>
                        @endforeach
                        </div>
                    </div>

                    <div class="list-filter-row">
                        <p>什麼時候</p>
                        <div class="row list-filter-option">
                        @foreach( $filter['when'] as $playAt )
                            <label class="checkbox-inline">
                                <input type="checkbox" class="checkbox" id="inlineCheckbox1" value="{{ $playAt->id }}" {{ $playAt->checked }}>{{ $playAt->name }}
                            </label>
                        @endforeach
                        </div>
                    </div>

                    <div class="list-filter-row">
                        <p>預算多少</p>
                        <div class="row list-filter-option">
                        @foreach( $filter['price'] as $price )
                            <label class="list-howmuch checkbox-inline">
                                <input type="checkbox" class="checkbox" id="inlineCheckbox1" value="{{ $price->id }}" {{ $price->checked }}>{{ $price->name }}
                            </label>
                        @endforeach
                        </div>
                    </div>
                </div>
<!------mobile_start------>
                <div class="list-mb-content">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="list-filter-row">
                        <p>想玩什麼 <span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span></p>
                        <div class="row list-filter-option">
                        @foreach( $filter['what'] as $playWhat  )
                            <label class="list-mb-what checkbox-inline">
                                <input type="checkbox" class="checkbox" id="inlineCheckbox1" value="{{ $playWhat->id }}" {{ $playWhat->checked }}>{{ $playWhat->name }}
                            </label>
                        @endforeach
                        </div>
                    </div>
                    <div class="list-filter-row">
                        <p>想去哪兒<span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span></p>
                        <div class="row list-filter-option">
                        @foreach( $filter['where'] as $goWhere )
                            <label class="list-mb-where checkbox-inline">
                                <input type="checkbox" class="checkbox" id="inlineCheckbox1" value="{{ $goWhere->id }}" {{ $goWhere->checked }}>{{ $goWhere->name }}
                            </label>
                        @endforeach
                        </div>
                    </div>
                    <div class="list-filter-row">
                        <p>什麼時候<span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span></p>
                        <div class="row list-filter-option">
                        @foreach( $filter['when'] as $playAt )
                            <label class="list-mb-when checkbox-inline">
                                <input type="checkbox" class="checkbox" id="inlineCheckbox1" value="{{ $playAt->id }}" {{ $playAt->checked }}>{{ $playAt->name }}
                            </label>
                        @endforeach
                        </div>
                    </div>
                    <div class="list-filter-row">
                        <p>預算多少<span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span></p>
                        <div class="row list-filter-option">
                        @foreach( $filter['price'] as $price )
                            <label class="list-mb-howmuch checkbox-inline">
                                <input type="checkbox" class="checkbox" id="inlineCheckbox1" value="{{ $price->id }}" {{ $price->checked }}>{{ $price->name }}
                            </label>
                        @endforeach
                        </div>
                    </div>
                </div>
<!------mobile_end------>
            </div>
        </div>
        <p class="list-result">活動搜尋列表</p>
        <div class="row list-right-content col-md-8 col-sm-8">
            <div class="list-content-panel">
            </div>
        </div>
        <div class="row list-mb-activities col-sm-12" style="margin:5px 0;">
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
    var url_param = getURLParameter('cat_id');
    $("input").on("change", function() {
        var content = $(this).parents('div[class!="list-content"][class$="content"]');

        if ($(this).parent().hasClass('list-checkbox')) {
            $(this).parent().removeClass('list-checkbox');
        } else {
            $(this).parent().addClass('list-checkbox');
        }

        search = content.find('input:checkbox:checked').map(function() {
            return this.value;
        }).get();
        search.push();
        $.ajax({
             type: "POST",
             headers: { 'X-CSRF-Token' : $('input[name=_token]').val() },
             url: "{{ URL('activity/data') }}",
             data: { 'selects' : search.filter( onlyUnique ),
                'keySearch' : $('input[name=keySearch]').val(),
                // 'showOld' : 'y', 顯示過往選項
             },
             success: function(data) {
                 showResult(data);
             }
        });
    });

    if ( url_param ) {
        $('input[value='+ url_param +']').click();
    } else {
        showResult(eventData);
    }

    $('.list-mb-content > .list-filter-row > div ').hide();
    $('.list-mb-content > .list-filter-row > p').click(function(){
        $(this).parent().find('.list-filter-option').slideToggle();
    });

    function onlyUnique(value, index, self) {
        return self.indexOf(value) === index;
    }

    function getURLParameter(name) {
        return decodeURIComponent((new RegExp('[?|&]' + name + '=' + '([^&;]+?)(&|#|;|$)').exec(location.search)||[,""])[1].replace(/\+/g, '%20'))||null;
    }

    function showResult ( data ) {
        var activityRow = new String();
        if (data.length > 0) {
            for ( var eventIndex in data ) {
                activityRow += ' <a href="{{ URL::to( 'activity/')}}/' + data[eventIndex]['id'] + '"> <div class="row list-category-panel"> \
                    <div class="col-md-12 col-xs-6 list-category-thumnail" style="background-image:url(\''+ data[eventIndex]['thumbnail']  +'\')"></div>  \
                    <div class="col-md-12 col-xs-6 list-category-text"> \ <div class="word-indent-01 list-category-title"> \
                    '+ data[eventIndex]['title'] +' \
                    </div> <div class="list-category-info"> <p> <img src="/img/icons/mb-price.png"> ' + " $ " + data[eventIndex]['min_price'] + "元起 " + ' \
                    </p> \
                    <p> <img src="/img/icons/mb-date.png"> ' + getDay(data[eventIndex]['activity_start']) +  getWeekday(data[eventIndex]['activity_start']) + " ～ " +
                    getDay(data[eventIndex]['activity_end']) + getWeekday(data[eventIndex]['activity_start']) +' </p> \
                    <p> <img src="/img/icons/mb-location.png"> ' + data[eventIndex]['locat_name'] + data[eventIndex]['location'] + ' </p> \
                    <p> <img src="/img/icons/mb-category.png"> ' + data[eventIndex]['cat_name'] + '  </p> \
                    </div> \
                    </div> </div></a>';
            }
        } else {
            activityRow = '<div class="list-attention"> Woops！尚無相關的活動類別！ </div>';
        }

        $('.list-content-panel').html(activityRow);
    }

    function getDay ( datetime ) {
        if ( datetime != null) {
            var DateReg = "";
            var result = /\d{4}-(.*)\s/.exec( datetime );
            return result[1];
        } else {
            return '';
        }
    }

    function getWeekday( datetime ) {
        if ( datetime != null) {
            var day_list = ['日', '一', '二', '三', '四', '五', '六'];
            var weekday = new Date(datetime).getDay();
            var week_event = ' ('+ day_list[weekday] +')';
            return week_event;
        } else {
            return '';
        }
    }
});
</script>

@endsection
