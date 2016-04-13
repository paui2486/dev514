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
    <div class="col-md-4 purchase-left">
        <p class="purchase-title">{{ $activity->title }}</p>
        <p class="purchase-location"><span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span>台北市信義區基隆路一段155號818室</p>
        <div class="purchase-tickets">
            <p class="ticket-name">雙人套票</p>
            <p class="row ticket-item">票券單價：$150NTD</p>         
            <p class="row ticket-item">購買數量：1</p>
            <p class="row ticket-item">開始時間：2016-05-30（一）10:00</p>
            <p class="row ticket-item">結束時間：2016-05-30（一）20:00</p>
        </div>
        <div class="purchase-total">總計<span>$250 NTD</span></div>
        <div class="purchase-mb-top" id="mb-detail">
            <p>查看詳細票券資訊</p>
            <div class="purchase-mb-ticket">
                <p class="ticket-name">雙人套票</p>
                <p class="row ticket-item">票券單價：$150NTD</p>         
                <p class="row ticket-item">購買數量：1</p>
                <p class="row ticket-item">開始時間：2016-05-30（一）10:00</p>
                <p class="row ticket-item">結束時間：2016-05-30（一）20:00</p>
            </div>
            <div class="purchase-mb-total">總計<span>$250 NTD</span></div>
        </div>
    </div>
    <div class="col-md-8 purchase-right">
        <p>1. 填寫聯絡資料</p>
        <div class="row purchase-attention">
            建議您<a href="{{url('login')}}">登入</a>或<a href="{{url('register')}}">加入會員</a>，方便日後查詢訂單紀錄。
        </div>
        <div class="row purchase-form">
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
        </div>
        <div class="purchase-button">
            <input type ="button" onclick="history.back()" value="修改票券" class="btn-pre"></input>
            <a href="#"><button class="btn-submit">前往付款</button></a> 
        </div>
    </div>  
</div>
@endsection
@section('script')
<script> 
    $('div#mb-detail div').hide();
    $('div#mb-detail > p').click(function(){
        $(this).next().slideToggle('fast');
    });
</script>
@endsection