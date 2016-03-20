@extends('layouts.app')

@section('style')
<link rel="stylesheet" href="{{asset('css/jquery.steps.css')}}"/>
<link rel="stylesheet" href="{{asset('css/zabuto_calendar.min.css')}}"/>

@endsection

@section('content')
<div class="row purchase-content">
<!--
    <div class="col-sm-4 col-md-3 purchase-left">
        <img class="purchase-thumnail" width="100%" src="{{asset('/img/pics/activity-photo.jpg')}}"/>
        <p>{{ $activity->description }}</p>
    </div>
-->
    <div class="col-sm-12 col-md-12 purchase-top"><!-- purchase-right -->
        <form id="wizard" action="{{ url('') }}" style="display:none;" method='POST'>
            {!! csrf_field() !!}
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <h1>選擇票卷</h1>
            <div class="purchase-panel">
                <div class="purchase-act-title">{{ $activity->title }}</div>
                <div class="row" style="margin:10px 0px;">
                    <p class="purchase-choose-title  col-md-2">選擇活動時間</p><span class="col-md-10 purchase-line"></span>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div id="calendar"></div>
                    </div>
                    <div class="col-md-6">
                        <div class="purchase-choose-time">
                            <h5>您選擇的活動日期</h5><strong></strong>
                            <h5>您選擇的活動時間</h5>
                            <div class="purchase-time-option"></div>
                        </div>
                    </div>
                </div>
                <div id="purchase-detail" class="row purchase-detail">

                </div>
            </div>

            <h1>填寫資料</h1>
            <div class="purchase-panel">
                <div class="purchase-act-title">{{ $activity->title }}</div>
                <div class="row" style="margin:10px 0px;">
                    <p class="purchase-choose-title  col-md-2">填寫聯絡資料</p><span class="col-md-10 purchase-line"></span>
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
                <div class="purchase-confirm">
                    <div class="row">
                        <label class="col-md-3 control-label"> 活動名稱 </label>
                        <div class="col-md-9">{{ $activity->title }}</div>
                    </div>

                    <div class="row">
                        <label class="col-md-3 control-label"> 活動日期 </label>
                        <div id="confirm-act-date" class="col-md-9"></div>
                    </div>

                    <div class="row">
                        <label class="col-md-3 control-label"> 活動時間 </label>
                        <div id="confirm-act-time" class="col-md-9"></div>
                    </div>

                    <div class="row">
                        <label class="col-md-3 control-label"> 活動地點 </label>
                        <div id="confirm-location" class="col-md-9"></div>
                    </div>

                    <div class="row">
                        <label class="col-md-3 control-label"> 訂購人姓名</label>
                        <div id="confirm-name" class="col-md-9"></div>
                    </div>

                    <div class="row">
                        <label class="col-md-3 control-label"> 訂購人電話</label>
                        <div id="confirm-mobile" class="col-md-9"></div>
                    </div>

                    <div class="row">
                        <label class="col-md-3 control-label"> 訂購人 email</label>
                        <div id="confirm-email" class="col-md-9"></div>
                    </div>

                    <div class="row">
                        <label class="col-md-3 control-label"> 票券內容 </label>
                        <div class="col-md-9">
                            <p><span id="confirm-ticket-content"></span> x <span id="confirm-ticket-number"></span> 張 </p>
                        </div>
                    </div>

                    <div class="confirm-price-row row">
                        <label class="col-md-3 control-label"> 總計 </label>
                         <div class="confirm-price col-md-9">
                             <p>$<span id="confirm-ticket-price"></span></p>
                         </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

</div>
@endsection

@section('script')
<script type="text/javascript" src="{{asset('js/jquery.steps.min.js')}}" ></script>
<script type="text/javascript" src="{{asset('js/zabuto_calendar.min.js')}}" ></script>
<script type="text/javascript" src="{{asset('js/jquery.validate.min.js')}}" ></script>

<script type="application/javascript">

var eventData = {!! json_encode($eventData) !!};

function getDetail(id) {
    document.getElementById('purchase-detail').innerHTML = ' \
        <div class="row" style="margin:10px auto"><p class="purchase-choose-title col-md-2">設定票券張數</p> \
            <span class="col-md-10 purchase-line"></span></div> \
        <div class="purchase-detail-info col-sm-8"><p>票券名稱 <span> '+ eventData[id]['description'] +' </span></p> \
            <p>票券單價 <span> '+ eventData[id]['price'] +' 元</span></p> \
            <p>活動地點 <span> '+ eventData[id]['location'] +' </span></p></div> \
        <div class="purchase-detail-result col-sm-4"><h5>票券張數</h5>  \
            <input id="purchase_number" name="purchase_number" type="number" placeholder="0" onchange="getPrice('+ id +', this.value)" min="1"> \
            <p>總計 <span>＄</span><span id="purchase_result"></span></p><input id="purchase" name="purchase_result" type="hidden"></div> \
    ';
}

function getPrice(id, count) {
  document.getElementById('purchase_result').innerHTML = eventData[id]['price'] * count ;
  document.getElementById('purchase').value = eventData[id]['price'] * count ;
}

$(document).ready(function () {
    $.ajaxSetup({
        headers: { 'X-CSRF-Token' : $('input[name=_token]').attr('content') }
    });

    var form = $("#wizard");
    form.validate({
        errorPlacement: function errorPlacement(error, element) { element.before(error); },
            rules: {
            }
    });

    $.fn.addHidden = function (name, value) {
        return this.each(function () {
            var input = $("<input>").attr("type", "hidden").attr("name", name).val(value);
            form.append(input);
        });
    };

    var first_event_day = eventData[0]['date'];
    getInputRow(first_event_day);

    form.show();

    var wizard = form.steps({

        labels: {
            current:    "current step:",
            pagination: "Pagination",
            finish:     "確認送出",
            next:       "下一步",
            previous:   "上一步",
            loading:    "Loading ...",
        },
        onStepChanging: function (event, currentIndex, newIndex)
        {
            var number = Number($("#purchase_number").val());
            var event_id = $('input[name=ticket]:checked').val();
            if (newIndex === 1)
            {
                if (isNaN(number)) {
                    alert('請選擇活動日期與活動票卷');
                    return false;
                } else if (number <= 0) {
                    alert('請輸入您的正確票卷張數');
                    return false;
                }
            } else if (newIndex === 2) {
                getPurchaseDetail( event_id );
            }
            form.validate().settings.ignore = ":disabled,:hidden";
            return form.valid();
        },
        onFinishing: function (event, currentIndex)
        {
            form.validate().settings.ignore = ":disabled";
            return form.valid();
        },
        onFinished: function (event, currentIndex)
        {
            var event_id = $('input[name=ticket]:checked').val();
            form.addHidden('activity',      '{{ $activity->title }}')
                .addHidden('ticket_id',     eventData[event_id]['title'])
                .addHidden('ticket_date',   eventData[event_id]['date'])
                .addHidden('ticket_price',  eventData[event_id]['price'])
                .addHidden('ticket_dest',   eventData[event_id]['description'])
                .submit();
        }
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
        getInputRow(event_date);
        return true;
    }

    function getInputRow( someday )
    {
        var inputRow = "";
        var check = null;
        var day_list = ['日', '一', '二', '三', '四', '五', '六'];
        var weekday = new Date(someday).getDay();
        var week_event = ' ('+ day_list[weekday] +')';

        for ( var eventIndex in eventData) {
            var ticket = eventData[eventIndex];
            if ( ticket['date'] === someday ) {
                 inputRow += '<div class="row time-option-panel"> \
                    <input type="radio" name="ticket" id="'+ eventData[eventIndex]['title'] +'" value="'+ eventIndex +'" class="time-option" onchange="getDetail('+ eventIndex +'); " /> \
                    <label class="col-md-8" for="' + eventData[eventIndex]['title'] + '"><p>'+ eventData[eventIndex]['name'] + '</p></label> \
                    <div class="col-md-3 purchase-surplus">剩 ' +  eventData[eventIndex]['left_over'] + ' 位</div></div>';
                check = true;
            }
        }
        if (!check) {
            document.getElementById('purchase-detail').innerHTML = "" ;
        }
        $(".purchase-choose-time").find("strong").text(someday + week_event);
        $(".purchase-time-option").html(inputRow);
    }

    function getPurchaseDetail( event_id )
    {
        $("#confirm-act-date").text(eventData[event_id]['date']);
        $("#confirm-act-time").text(eventData[event_id]['name']);
        $("#confirm-name").text($('input[name=name]').val());
        $("#confirm-location").text(eventData[event_id]['location']);
        $("#confirm-mobile").text($('input[name=mobile]').val());
        $("#confirm-email").text($('input[name=email]').val());
        $("#confirm-ticket-content").text(eventData[event_id]['description']);
        $("#confirm-ticket-number").text($('input[name=purchase_number]').val());
        $("#confirm-ticket-price").text(eventData[event_id]['price']);
    }
});
</script>

@endsection
