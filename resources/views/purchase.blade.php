@extends('layouts.app') 

@section('content')
<div class="row purchase-content">
    <div class="purchase-left">
        <div class="purchase-thumnail" style="background-image:url('/img/pics/activity-photo.jpg')">
        </div>
        <p>綠色植物不僅可以綠化空氣，還能給人帶來生氣，很多人都喜歡在家中或者是辦公室里擺放幾盆綠植。</p>
    </div>
    <div class="purchase-right">
    <img src="/img/pics/514purchase1-02.png">
        <div class="purchase-panel">
            <div class="purchase-title">辦公室療癒植栽DIY</div>
            <div class="row" style="margin:10px 0px;">
            <p>選擇活動時間</p><span class="purchase-line"></span>
            </div>
            <div class="row purchase-time">
                <div class="purchase-calendar">
                <img src="/img/pics/canlendar-03.png">
                </div>
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
            </div>
            <div class="row" style="margin:10px 0px;">
            <p>選擇票券種類</p><span class="purchase-line"></span>
                 </div>
              <div class="row">
                  <input type="radio" name="gender" value="male" checked>早鳥優惠票65折<br>
              </div>
                <div class="row">
              <input type="radio" name="gender" value="female">雙人超值套票<br></div>
                    <div class="row">
              <input type="radio" name="gender" value="other">單人獨享優惠票<br> </div>
                
           
        </div>
    </div>
</div>

@endsection 