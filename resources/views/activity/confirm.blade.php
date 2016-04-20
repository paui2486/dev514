@extends('layouts.app')

@section('content')
<div class="row confirm-container">
    <div class="row confirm-panel">
        <div class="confirm-top">
            恭喜您！您的活動行程已經訂購成功！
            <p>我們將寄送確認信件至您的E-mail，您也可以選擇
                <a href="#"><span class="glyphicon glyphicon-print" aria-hidden="true" onClick="window.print()">列印此頁</span></a>。
            </p>
        </div>
        <div class="col-md-5 confirm-left">
            <div class="row">
                <label class="col-md-4 control-label"> 交易序號 </label>
                <div class="col-md-8">{{ $tickets->TradeNo }}</div>
            </div>
            <div class="row">
                <label class="col-md-4 control-label"> 交易時間 </label>
                <div class="col-md-8">{{ $tickets->TradeTime }}</div>
            </div>
            <div class="row">
                <label class="col-md-4 control-label"> 活動名稱 </label>
                <div class="col-md-8">{{ $tickets->activity_name }}</div>
            </div>
            <div class="row">
                <label class="col-md-4 control-label"> 活動地點 </label>
                <div id="confirm-location" class="col-md-8">{{ $tickets->activity_locaname . $tickets->activity_location }}</div>
            </div>
            <div class="row">
                <label class="col-md-4 control-label"> 聯絡人姓名</label>
                <div id="confirm-name" class="col-md-8">{{ $tickets->user_name }}</div>
            </div>
            <div class="row">
                <label class="col-md-4 control-label"> 聯絡人電話</label>
                <div id="confirm-mobile" class="col-md-8">{{ $tickets->user_phone }}</div>
            </div>
            <div class="row">
                <label class="col-md-4 control-label"> 聯絡人 email</label>
                <div id="confirm-email" class="col-md-8">{{ $tickets->user_email }}</div>
            </div>
        </div>
        <div class="col-md-7 confirm-right">
            <p>您的票券 Your Tickets</p>
            @foreach( $tickets->ticket_infos as $info )
            <div class="confirm-ticket">
                <div class="row">
                    <label class="col-md-3 col-xs-5 control-label"> 票券名稱 </label>
                    <div id="confirm-act-date" class="col-md-9 col-xs-7">{{ $info->name }}</div>
                </div>
                <div class="row">
                    <label class="col-md-3 col-xs-5 control-label"> 票券數量 </label>
                    <div class="col-md-9 col-xs-7">
                        {{ $info->quantity }}
                    </div>
                </div>
                <div class="row">
                    <label class="col-md-3 col-xs-12 control-label"> 開始時間 </label>
                    <div class="col-md-9 col-xs-12">
                        {{ $info->ticket_start }}
                    </div>
                </div>
                <div class="row">
                    <label class="col-md-3 col-xs-125 control-label"> 結束時間 </label>
                    <div class="col-md-9 col-xs-12">
                        {{ $info->ticket_end }}
                    </div>
                </div>
                <p>票價<span>$ {{ $info->price }} NTD</span></p>
            </div>
            @endforeach
            <div class="confirm-price">
                <p> 結帳總額 <span>$ {{ $tickets->TotalPrice }} NTD</span></p>
            </div>
        </div>
    </div>
    <div class="row confirm-button">
        <a href="{{ url('/') }}"><button>回到首頁</button></a>
        <a href="{{ url('/dashboard/activity#tab-1')}}"><button>我的票券</button></a>
    </div>
</div>

@endsection
