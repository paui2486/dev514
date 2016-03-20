@extends('layouts.app')

@section('content')

<div class="row  result-container">
    <div class="result-panel">
        <p class="result-title">恭喜您訂購成功！預祝您活動愉快！</p>
            <div class="result-option row">
                <label class="col-md-3">交易序號</label>
                <div class="transaction-id  col-md-9">{{ $ticket->TradeNo }}</div>
            </div>
            <div class="result-option row">
                <label class="col-md-3">交易時間</label>
                <div class="transaction-id  col-md-9">{{ $ticket->TradeTime }}</div>
            </div>
            <div class="result-option row">
                <label class="col-md-3"> 訂購人姓名</label>
                <div class="col-md-9">{{ $ticket->user_name }}</div>
            </div>

            <div class="result-option row">
                <label class="col-md-3"> 訂購人電話</label>
                <div class="col-md-9">{{ $ticket->user_phone }}</div>
            </div>

            <div class="result-option row">
                <label class="col-md-3"> 訂購人E-mail</label>
                <div class="col-md-9">{{ $ticket->user_email }}</div>
            </div>

        <div class="result-ticket-content">
            <p>您的514活動票券</p>
            <div class="result-option row">
                <label class="col-md-3"> 活動名稱 </label>
                <div class="col-md-9">{{ $ticket->activity_name }}</div>
            </div>

            <div class="result-option row">
                <label class="col-md-3"> 活動時間 </label>
                <div class="col-md-9">{{ $ticket->ticket_day }} {{ $ticket->ticket_start }}~{{ $ticket->ticket_end }}</div>
            </div>

            <div class="result-option row">
                <label class="col-md-3"> 活動地點 </label>
                <div class="col-md-9">{{ $ticket->activity_location }}</div>
            </div>
            <div class="result-option row">
                <label class="col-md-3"> 票券名稱 </label>
                <div class="col-md-9">
                <p><span>{{ $ticket->ticket_name }}</span> x <span>{{ $ticket->ticket_number }}</span> 張 </p>
                </div>
            </div>
            <div class="result-option row">
                <label class="col-md-3"> 票價總計 </label>
                 <div class="result-price col-md-9">
                     <p> $ <span>{{ $ticket->TotalPrice }}</span><span>（ 已付款 ）</span></p>
                 </div>
            </div>
        </div>
        <div class="row result-button">
        <button onclick="javascript:location.href='{{ url('') }}'">確認資料</button><button onclick="windows.print();">列印此頁</button>
        </div>
    </div>
</div>

@endsection
