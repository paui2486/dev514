@extends('layouts.app')

@section('content')

<div class="row  result-container">
    <div class="result-panel">
            <p class="result-title">
        恭喜您訂購成功！預祝您活動愉快！</p>
            <div class="result-option row">
                <label class="col-md-3">交易序號</label>
                <div class="transaction-id  col-md-9">EFK4569305</div>
            </div>
            <div class="result-option row">
                <label class="col-md-3"> 訂購人姓名</label>
                <div class="col-md-9">Allen Liang</div>
            </div>

            <div class="result-option row">
                <label class="col-md-3"> 訂購人電話</label>
                <div class="col-md-9">0945-356-294</div>
            </div>

            <div class="result-option row">
                <label class="col-md-3"> 訂購人E-mail</label>
                <div class="col-md-9">allen@514.com.tw</div>
            </div>
        
        <div class="result-ticket-content">
            <p>您的514活動票券</p>
            <div class="result-option row">
                <label class="col-md-3"> 活動名稱 </label>
                <div class="col-md-9">辦公室植栽DIY</div>
            </div>

            <div class="result-option row">
                <label class="col-md-3"> 活動時間 </label>
                <div class="col-md-9">2016-05-23 12:00~14:00</div>
            </div>

            <div class="result-option row">
                <label class="col-md-3"> 活動地點 </label>
                <div class="col-md-9">台北市信義區</div>
            </div>
            <div class="result-option row">
                <label class="col-md-3"> 票券名稱 </label>
                <div class="col-md-9">
                <p><span>早鳥優惠票</span> x <span>4</span> 張 </p>
                </div>
            </div>
            <div class="result-option row">
                <label class="col-md-3"> 票價總計 </label>
                 <div class="result-price col-md-9">
                     <p> $ <span>2,400</span><span>（ 已付款 ）</span></p>
                 </div>
            </div>
        </div>
        <div class="row result-button">
        <button>確認資料</button><button>列印此頁</button>
        </div>
    </div>
</div>

@endsection