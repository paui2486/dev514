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
    <div class="col-sm-12 col-md-12 purchase-top"><!-- purchase-right -->
        <p>填寫資料</p>
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
                    <input type="text" class="form-control purchase-form-control" name="name"
                        value="{{{ Input::old('name', Auth::check() ? Auth::user()->name : null) }}}" placeholder="建議輸入真實姓名">
                </div>
                </div>
                <div class="row form-group{{ $errors->has('mobile') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label"> <span>*</span>聯絡人手機</label>
                    <div class="col-md-9">
                        <input type="mobile" class="form-control purchase-form-control" name="mobile"
                            value="{{{ Input::old('mobile', Auth::check() ? Auth::user()->phone : null) }}}" placeholder="0932-514-123">
                    </div>
                </div>
                <div class="row form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label"> <span>*</span>電子郵件</label>
                    <div class="col-md-9">
                        <input type="email" class="form-control purchase-form-control" name="email"
                          value="{{{ Input::old('email', Auth::check() ? Auth::user()->email : null) }}}" placeholder="mis@514.com.tw">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
