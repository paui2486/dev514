@extends('layouts.app')

@section('content')
<div class="Member-container">
    <div class="row Member-TopContent">
        <div class="col-md-3">
            <img src="/img/pics/default-02.png">
        </div>
        <div class="Member-introduce col-md-9">
            <p>會員/廠商姓名</p><br>
            <span>尚未輸入任何相關資訊</span>
            
        </div>
        <div class="contact-dropdown">
            <span class="contact-dropbtn">聯絡我</span>
            <div class="contact-dropcontent">
                <a>grace@514.com.tw</a>
                <a>02-2767-5146</a>
                <a>0912-345678</a>
                <a>台北市信義區基隆路一段155號</a>
            </div>
        </div>
    </div>
    <div class="row Member-InfoBar">
        <span>參加中活動</span>
        <span>參加過活動</span>
        <span>舉辦中活動</span>
        <span>舉辦過活動</span>
    </div>
    <div class="row Member-MainContent">
        <div class="col-md-4 Member-panel">
            <a href="#">
            <div class="Member-panel-bg">
                <div class="MemberAct-id">
                </div>
                <div class="MemberAct-thumbnail" style=" background-image: url(/img/pics/activity-photo.jpg)">
                </div>
                <div class="MemberAct-text">
                    <div class="MemberAct-title word-indent-01">活動標題
                    </div>
                    <div class="MemberAct-info">
                        <img src="img/pics/calendar-icon-02.png">06-18（六）
                    </div>
                    <div class="MemberAct-info">
                        <img src="img/pics/money-icon-02.png">$1,200元
                    </div>
                    <div class="MemberAct-info">
                        <img src="img/pics/location-icon-02.png">台北市信義區
                    </div>
                    <div class="MemberAct-pro">
                        <img src="/img/icons/holder.png">
                        <span> 514頻道 </span>
                    </div>
                </div>
            </div>
            </a>
        </div>
</div>

@endsection