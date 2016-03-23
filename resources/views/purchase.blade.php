@extends('layouts.app')

@section('meta')
<title>514 訂購流程</title>
@endsection

@section('content')
<div class="row purchase-content">
    <div class="purchase-left"  style="background-image:url('/img/pics/purchase-ticket.png')">
        <div class="purchase-ticket">
            <p>您的票券</p>
            <div class="purchase-ticket-title">
            <span class="glyphicon glyphicon-star" aria-hidden="true"></span>活動時間<span class="glyphicon glyphicon-star" aria-hidden="true"></span><br>
            </div>
            2016-04-02<br>
            13:00~16:00
                <p class="dashed"></p>
            <div class="purchase-ticket-title">
            <span class="glyphicon glyphicon-star" aria-hidden="true"></span>票券名稱<span class="glyphicon glyphicon-star" aria-hidden="true"></span>
            </div>
            早鳥優惠票65折 x 1<br>
                <p class="dashed"></p>

        </div>

    </div>
    <div class="purchase-right">
        <div class="purchase-panel">
            <div class="purchase-title-1">辦公室療癒植栽DIY</div>
            <div class="purchase-title-2 row" style="margin:10px 0px;">
            <p class="col-md-2">填寫聯絡資料</p><span class="col-md-10 purchase-line"></span>
            </div>
            <div class="row purchase-attention">
                建議您<a href="#">登入</a>或<a href="#">加入會員</a>，方便日後查詢訂單紀錄。
            </div>
            <div class="row purchase-form">
             <div class="row form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label"> <span>*</span>聯絡人姓名</label>

                    <div class="col-md-9">
                        <input type="text" class="form-control purchase-form-control" name="name" value="{{ old('name') }}" placeholder="建議輸入真實姓名">

                        @if ($errors->has('name'))
                            <span class="help-block">
                                <p>{{ $errors->first('name') }}</p>
                            </span>
                        @endif
                    </div>
                </div>
                 <div class="row form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label"> <span>*</span>聯絡人手機</label>

                    <div class="col-md-9">
                        <input type="mobile" class="form-control purchase-form-control" name="mobile" value="{{ old('mobile') }}" placeholder="0932-514-123">

                        @if ($errors->has('mobile'))
                            <span class="help-block">
                                <p>{{ $errors->first('mobile') }}</p>
                            </span>
                        @endif
                    </div>
                </div>
                 <div class="row form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label"> <span>*</span>電子郵件</label>

                    <div class="col-md-9">
                        <input type="email" class="form-control purchase-form-control" name="email" value="{{ old('email') }}" placeholder="mis@514.com.tw">

                        @if ($errors->has('email'))
                            <span class="help-block">
                                <p>{{ $errors->first('email') }}</p>
                            </span>
                        @endif
                    </div>
                </div>

            </div>
<!--
                <div class="purchase-choose-time">
                    <h5>您選擇的活動日期</h5>
                    <strong>2016-04-02（六）</strong>
                    <h5>您選擇的活動場次</h5>
                        <div class="row" style="margin:0px;">
                            <div class="purchase-time-option">
                            <input type="radio" name="date" id="date1" class="time-option" checked/>
                            <label for="date1">上午場 10:00~12:00</label>
                            </div>
                        <div class="purchase-surplus">剩123位</div>
                        </div>
                        <div class="row" style="margin:0px;">
                            <div class="purchase-time-option">
                            <input type="radio" name="date" id="date2" class="time-option" checked/>
                            <label for="date2">上午場 10:00~12:00</label>
                            </div>
                        <div class="purchase-surplus">剩123位</div>
                        </div>
                </div>
-->
            </div>

       </div>
  </div>
</div>




@endsection
