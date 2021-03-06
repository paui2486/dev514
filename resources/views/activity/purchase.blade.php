@extends('layouts.app')

@section('meta')
<title>514 訂購流程</title>
@endsection

@section('style')
<link rel="stylesheet" href="{{asset('css/jquery.steps.css')}}"/>
<link rel="stylesheet" href="{{asset('css/zabuto_calendar.min.css')}}"/>
@endsection

@section('content')
<div class="row purchase-content">
    <div class="col-md-4 col-sm-4 purchase-left">
        <p class="purchase-title">{{ $activity->title }}</p>
        <p class="purchase-location"><span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span>{{ $activity->locat_name . $activity->location }}</p>
        {{--*/ $count = 0; /*--}}
        @foreach ( $eventData as $event )
        {{--*/ $count += $event->price * $event->quantity; /*--}}
        <div class="purchase-tickets">
            <p class="ticket-name">{{ $event->name }}</p>
            <p class="row ticket-item">票券單價：$ {{ $event->price }} NTD</p>
            <p class="row ticket-item">購買數量：{{ $event->quantity }}</p>
            <p class="row ticket-item">開始時間：{{ $event->act_start }}</p>
            <p class="row ticket-item">結束時間：{{ $event->act_end }}</p>
        </div>
        @endforeach
        <div class="purchase-total">總計<span>$ {{ $count }} NTD</span></div>
        <div class="purchase-mb-top">
            @foreach ( $eventData as $event )
            <div class="purchase-mb-ticket">
                <p class="ticket-name">{{ $event->name }}</p>
                <p class="row ticket-item">票券單價：$ {{ $event->price }} NTD</p>
                <p class="row ticket-item">購買數量：{{ $event->quantity }}</p>
                <p class="row ticket-item">開始時間：{{ $event->act_start }}</p>
                <p class="row ticket-item">結束時間：{{ $event->act_end }}</p>
            </div>
            @endforeach
            <div class="purchase-mb-total">總計<span>$ {{ $count }} NTD</span></div>
        </div>
    </div>
    <div class="col-md-8 col-sm-8 purchase-right">
        <p>1. 填寫聯絡資料</p>
        <div class="row purchase-attention">
            建議您<a href="{{url('login')}}">登入</a>或<a href="{{url('register')}}">加入會員</a>，方便日後查詢訂單紀錄。
        </div>
        <form class="row purchase-form" action="{{ Request::url() }}" method='POST'>
            {!! csrf_field() !!}
            <div class="row form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <label class="col-md-3 control-label"> <span>*</span>聯絡人姓名</label>
                <div class="col-md-9">
                    <input type="text" class="form-control purchase-form-control" name="name"
                        value="{{{ Input::old('name', Auth::check() ? Auth::user()->name : null) }}}" placeholder="建議輸入真實姓名（例：陳小明）">
                </div>
            </div>
            <div class="row form-group{{ $errors->has('mobile') ? ' has-error' : '' }}">
                <label class="col-md-3 control-label"> <span>*</span>聯絡人手機</label>
                <div class="col-md-9">
                    <input type="mobile" class="form-control purchase-form-control" name="mobile"
                        value="{{{ Input::old('mobile', Auth::check() ? Auth::user()->phone : null) }}}" placeholder="請輸入手機號碼（例：0912345678）">
                </div>
            </div>
            <div class="row form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label class="col-md-3 control-label"> <span>*</span>電子郵件</label>
                <div class="col-md-9">
                    <input type="email" class="form-control purchase-form-control" name="email"
                      value="{{{ Input::old('email', Auth::check() ? Auth::user()->email : null) }}}" placeholder="請輸入email（例：mis@514.com.tw）">
                </div>
            </div>
            <div class="purchase-button">
                <input type="button" onclick="history.back()" value="上一步" class="btn-pre"></input>
                <a id="submit" href="#"><button class="btn-submit">前往付款</button></a>
            </div>
            <input type="hidden" name="data" value='{{ json_encode(Request::all()) }}'>
            <input type="hidden" name="price" value='{{ $count }}'>
        </form>
    </div>
</div>
@endsection
@section('script')
<script>
//$(document).ready(function () {
//    $('div#mb-detail div').hide();
//    $('div#mb-detail > p').click(function(){
//        $(this).parent().find('div').slideToggle('fast');
//    });
//    $('#submit').click( function() { $('form').submit(); });
//});
</script>
@endsection
