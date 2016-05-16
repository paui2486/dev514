<div style="background:#f2f2f2;padding: 15px;">
    <div style="">
        <div style="font-size: 16px;line-height: 25px;line-height: 35px;">
            {{ $tickets->user_name }}您好，
            感謝您在514購買了<span class="color: #00bcd4;font-size:18px;"> {{ $tickets->ItemDesc }}</span>
            <br>514團隊在此預祝您活動愉快。
            <a href="{{ url('activity/'. reset($tickets->ticket_infos)->activity_id ) }}">點此觀看票券資訊</a>
        </div>
        <div style="border: 1px solid #ccc;padding: 10px 15px;line-height: 26px;font-size: 15px;  margin: 15px;">
            <div class="row">
                <label style="width: 50%;float: left;"> 交易序號 </label>
                <div class="col-md-8">{{ $tickets->TradeNo }}</div>
            </div>
            <div class="row">
                <label style="width: 50%;float: left;">  交易時間 </label>
                <div class="col-md-8">{{ $tickets->TradeTime }}</div>
            </div>
            <div class="row">
                <label style="width: 50%;float: left;">  活動名稱 </label>
                <div class="col-md-8">{{ $tickets->activity_name }}</div>
            </div>
            <div class="row">
                <label style="width: 50%;float: left;">  活動地點 </label>
                <div id="confirm-location" class="col-md-8">{{ $tickets->activity_location }}</div>
            </div>
            <div class="row">
                <label style="width: 50%;float: left;">  聯絡人姓名</label>
                <div id="confirm-name" class="col-md-8">{{ $tickets->user_name }}</div>
            </div>
            <div class="row">
                <label style="width: 50%;float: left;">  聯絡人電話</label>
                <div id="confirm-mobile" class="col-md-8">{{ $tickets->user_phone }}</div>
            </div>
            <div class="row">
                <label style="width: 50%;float: left;">  聯絡人 email</label>
                <div id="confirm-email" class="col-md-8">{{ $tickets->user_email }}</div>
            </div>
        </div>
        <div style="border: 1px solid #ccc;padding: 10px 15px;line-height: 26px;font-size: 15px;margin: 15px;">
            @foreach ( $tickets->ticket_infos as $info )
            <div class="confirm-ticket">
                <div class="row">
                    <label style="width: 50%;float: left;"> 票券名稱 </label>
                    <div id="confirm-act-date" class="col-md-9 col-xs-7">{{ $info->name }}</div>
                </div>
                <div class="row">
                    <label style="width: 50%;float: left;"> 票券數量 </label>
                    <div class="col-md-9 col-xs-7">
                        {{ $info->quantity }}
                    </div>
                </div>
                <div class="row">
                    <label style="width: 50%;float: left;"> 開始時間 </label>
                    <div class="col-md-9 col-xs-12">
                        {{ $info->ticket_start }}
                    </div>
                </div>
                <div class="row">
                    <label style="width: 50%;float: left;"> 結束時間 </label>
                    <div class="col-md-9 col-xs-12">
                        {{ $info->ticket_end }}
                    </div>
                </div>
                <div class="row">
                    <label style="width: 50%;float: left;"> 票券單價 </label>
                    <div class="col-md-9 col-xs-12">
                        $ {{ $info->price }} 元
                    </div>
                </div>
            </div>
            @endforeach
            <div>
                <p style="text-align: right;font-size: 17px;padding: 10px;border-top: 1px dashed #666;margin: 0;margin-top: 15px;"> 結帳總額 <span>$ {{ $tickets->TotalPrice }} 元</span></p>
            </div>
        </div>
    </div>
    <div style="padding: 10px;text-align: center;background-color: #d8d8d8;">
        <a href="{{ url('/') }}"><button class="    padding: 10px;background: #00bcd4;border: none;color: #fff;font-size: 15px;letter-spacing: 1px;margin: 5px 10px;cursor: pointer;">回到514</button></a>
        <a href="{{ url('/dashboard/activity#tab-1')}}"><button  class="padding: 10px;background: #00bcd4;border: none;color: #fff;font-size: 15px;letter-spacing: 1px;margin: 5px 10px;cursor: pointer;">我的票券</button></a>
    </div>
</div>
