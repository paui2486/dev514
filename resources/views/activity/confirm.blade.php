@extends('layouts.app')

@section('content')
<div class="row confirm-container">
    <div class="row confirm-panel">
        <div class="confirm-top">
            恭喜您！您的活動行程已經訂購成功！
            <p>我們將寄送確認信件至您的E-mail，您也可以選擇
                <a href="#"><span class="glyphicon glyphicon-print" aria-hidden="true">列印此頁</span></a>。
            </p>
        </div>
        <div class="col-md-5 confirm-left">
            <div class="row">
                <label class="col-md-4 control-label"> 活動名稱 </label>
                <div class="col-md-8">一日小廚師體驗</div>
            </div>

            <div class="row">
                <label class="col-md-4 control-label"> 活動地點 </label>
                <div id="confirm-location" class="col-md-8">台北市中正區</div>
            </div>

            <div class="row">
                <label class="col-md-4 control-label"> 聯絡人姓名</label>
                <div id="confirm-name" class="col-md-8">高意茹</div>
            </div>

            <div class="row">
                <label class="col-md-4 control-label"> 聯絡人電話</label>
                <div id="confirm-mobile" class="col-md-8">0932-993-668</div>
            </div>

            <div class="row">
                <label class="col-md-4 control-label"> 聯絡人 email</label>
                <div id="confirm-email" class="col-md-8">choice586@gmail.com</div>
            </div>
        </div>
        <div class="col-md-7 confirm-right">
            <p>您的票券 Your Tickets</p>
            <div class="confirm-ticket">
                <div class="row">
                    <label class="col-md-3 control-label"> 票券名稱 </label>
                    <div id="confirm-act-date" class="col-md-9"> 雙人票 </div>
                </div>
                <div class="row">
                    <label class="col-md-3 control-label"> 票券數量 </label>
                    <div class="col-md-9">
                        1
                    </div>
                </div>
                <div class="row">
                    <label class="col-md-3 control-label"> 開始時間 </label>
                    <div class="col-md-9">
                        2016-05-30（一）10:00
                    </div>
                </div>
                <div class="row">
                    <label class="col-md-3 control-label"> 結束時間 </label>
                    <div class="col-md-9">
                        2016-05-30（一）10:00
                    </div>
                </div>
            </div>
            <div class="confirm-price">
                <p> 結帳總額 <span>$ 1,200 NTD</span></p>
            </div>
        </div>
    </div>
    <div class="row confirm-button">
        <button>回到首頁</button>
        <button>前往票券管理</button>
    </div>
</div>

@endsection 