@extends('layouts.app')

@section('style')
<link rel="stylesheet" href="{{asset('css/jquery.steps.css')}}"/>
<link rel="stylesheet" href="{{asset('css/zabuto_calendar.min.css')}}"/>

@endsection

@section('content')
<div class="row purchase-content">
    <div class="col-sm-4 purchase-left"><!-- purchase-left 給我重寫！！！ -->
        <img class="purchase-thumnail" width="100%" src="{{asset('/uploads/avatar/avatar-1458133642.jpg')}}"/>
        <p>{{ $activity->description }}</p>
    </div>
    <div class="col-sm-8 purchase-right"><!-- purchase-right -->
        <form id="wizard" action="#">
            <h1>選擇票卷</h1>
            <div class="purchase-panel">
                <div class="purchase-title">{{ $activity->title }}</div>
                <div class="row" style="margin:10px 0px;">
                    <p>選擇活動時間</p><span class="purchase-line"></span>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div id="calendar"></div>
                    </div>
                    <div class="col-md-6">
                        <div class="purchase-choose-time">
                            <h5>您選擇的活動日期</h5><strong></strong>
                            <h5>您選擇的活動場次</h5>
                            <div class="purchase-time-option"></div>
                        </div>
                    </div>
                </div>
                <div id="purchase-detail" class="row">

                </div>
            </div>

            <h1>填寫資料</h1>
            <div class="purchase-panel">
                <div class="purchase-title-1">辦公室療癒植栽DIY</div>
                <div class="purchase-title-2 row" style="margin:10px 0px;">
                <p class="col-md-2">填寫聯絡資料</p><span class="col-md-10 purchase-line"></span>
                </div>
                <div class="row purchase-attention">
                    建議您<a href="{{url('login')}}">登入</a>或<a href="{{url('register')}}">加入會員</a>，方便日後查詢訂單紀錄。
                </div>
                <div class="row purchase-form">
                <div class="row form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label"> <span>*</span>聯絡人姓名</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control purchase-form-control" name="name" value="{{ old('name') }}" placeholder="建議輸入真實姓名">
                    </div>
                    </div>
                    <div class="row form-group{{ $errors->has('mobile') ? ' has-error' : '' }}">
                        <label class="col-md-3 control-label"> <span>*</span>聯絡人手機</label>
                        <div class="col-md-9">
                            <input type="mobile" class="form-control purchase-form-control" name="mobile" value="{{ old('mobile') }}" placeholder="0932-514-123">
                        </div>
                    </div>
                    <div class="row form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label class="col-md-3 control-label"> <span>*</span>電子郵件</label>
                        <div class="col-md-9">
                            <input type="email" class="form-control purchase-form-control" name="email" value="{{ old('email') }}" placeholder="mis@514.com.tw">
                        </div>
                    </div>
                </div>
            </div>

            <h1>確認訂單</h1>
            <div class="purchase-panel">
                <label class="col-md-3 control-label"> 訂閱人姓名</label>
                <div class="col-md-9"></div>

                <label class="col-md-3 control-label"> 訂閱人電話</label>
                <div class="col-md-9"></div>

                <label class="col-md-3 control-label"> 訂閱人 email</label>
                <div class="col-md-9"></div>

                <label class="col-md-3 control-label"> 活動名稱 </label>
                <div class="col-md-9"></div>

                <label class="col-md-3 control-label"> 活動時間 </label>
                <div class="col-md-9"></div>

                <label class="col-md-3 control-label"> 票卷費用 </label>
                <div class="col-md-9"></div>

                <label class="col-md-3 control-label"> 票卷詳細 </label>
                <div class="col-md-9"></div>
            </div>

            <h1>填寫資料</h1>
            <div class="purchase-panel">
              result
            </div>

        </form>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript" src="{{asset('js/jquery.steps.min.js')}}" ></script>
<script type="text/javascript" src="{{asset('js/zabuto_calendar.min.js')}}" ></script>
<script type="application/javascript">
var eventData = {!! json_encode($eventData) !!};

function getDetail(id) {
    document.getElementById('purchase-detail').innerHTML = '<p>設定票券張數</p> \
        <span class="purchase-line"></span></div> \
        <div class="col-sm-6"><h5>票卷資訊</h5> <div> '+ eventData[id]['description'] +' </div> \
        <h5>票卷單價</h5> <div> '+ eventData[id]['price'] +' </div> \
        <h5>活動地點</h5> <div> '+ eventData[id]['location'] +' </div> \
        </div><div class="col-sm-6"><h5>票卷張數</h5> <input type=numbers onchange="getPrice('+ id +', this.value)"> \
        <h5>票卷金額</h5> <div id="purchase_result"></div><input id="purchase" name="purchase_result" style="display: none;"> \
    ';
}

function getPrice(id, count) {
  document.getElementById('purchase_result').innerHTML = eventData[id]['price'] * count ;
  document.getElementById('purchase').value = eventData[id]['price'] * count ;
}

$(document).ready(function () {
    var wizard = $("#wizard").steps({
        // forceMoveForward: false,
        // saveState: true,
        // autoFocus: true,
        // enablePagination: false,
        // transitionEffect: "slideLeft",
        // onStepChanged: function (event, current, next) {
        //     if (current > 0) {
        //         $("#wizard .actions a[href='#previous']").hide();
        //     }
        // },
    });

    $("#calendar").zabuto_calendar({
        data: eventData,
        today: true,
        show_days: true,
        weekstartson: 1,
        nav_icon: {
            prev: '<i class="fa fa-chevron-circle-left"></i>',
            next: '<i class="fa fa-chevron-circle-right"></i>'
        },
        action: function () {
            return clickDate(this.id);
        },
    });

    function clickDate(id, fromModal) {
        var event_date = $("#" + id).data("date");
        var inputRow = "";
        var check = null;
        var day_list = ['日', '一', '二', '三', '四', '五', '六'];
        var weekday = new Date(event_date).getDay();
        var week_event = ' ('+ day_list[weekday] +')';
        for ( var eventIndex in eventData) {
            var ticket = eventData[eventIndex];
            if ( ticket['date'] === event_date ) {
                inputRow += '<div class="row"> \
                    <input type="radio" name="ticket" id="'+ eventData[eventIndex]['title'] +'" class="time-option" onchange="getDetail('+ eventIndex +');" /> \
                    <label for="' + eventData[eventIndex]['title'] + '">'+ eventData[eventIndex]['name'] + '</label> \
                    <div class="purchase-surplus">剩 ' +  eventData[eventIndex]['left_over'] + ' 位</div></div>';
                check = true;
            }
        }
        if (!check) {
            document.getElementById('purchase-detail').innerHTML = "" ;
        }
        $(".purchase-choose-time").find("strong").text(event_date + week_event);
        $(".purchase-time-option").html(inputRow);
        return true;
    }
});
</script>
@endsection
