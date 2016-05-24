@extends('layouts.app')

@section('content')
<div class="Member-container">
    <div class="row Member-TopContent">
        <div class="Member-owner col-md-3">
            <img src="/img/pics/default-02.png">
        </div>
        <div class="Member-introduce col-md-9">
            <p>{{ $member->name }}</p><br>
            <span>職人介紹 —— {{ $member->description }}</span>

        </div>
        <div class="contact-dropdown">
            <a href="mailto:{{ $member->email }}"><span class="contact-dropbtn">聯絡我</span></a>
            <div class="contact-dropcontent">
                <a><img src="/img/icons/envelope.png">
                    {{ $member->email }}</a>
                <a><img src="/img/icons/smartphone-call.png">{{ $member->phone }}</a>
                <a><img src="/img/icons/address.png">{{ $member->address }}</a>
            </div>
        </div>
    </div>
    <div class="row Member-Tab">
        <ul class="row Tabs" style="margin:0;">
            <li><a href="#Mtab-1">職人經歷</a></li>
            <li><a href="#Mtab-2">參加中活動</a></li>
            <li><a href="#Mtab-3">參加中活動</a></li>
        </ul>
        <div class="row Tab-Container" style="min-height:200px">
            <div class="row Member-content" id="Mtab-1">
                <p></p>
            </div>
            <div class="row Member-content" id="Mtab-2">
                <div class="col-md-4 Member-panel">
                    <div class="MemberAct-id">
                    </div>
                    <div class="MemberAct-thumbnail" style=" background-image: url(/img/pics/macaron.jpg)">
                    </div>
                    <div class="MemberAct-text">
                        <div class="MemberAct-title word-indent-01">活動標題
                        </div>
                        <div class="MemberAct-info">
                            <img src="/img/pics/calendar-icon-02.png">06-18（六）
                        </div>
                        <div class="MemberAct-info">
                            <img src="/img/pics/money-icon-02.png">$1,200元
                        </div>
                        <div class="MemberAct-info">
                            <img src="/img/pics/location-icon-02.png">台北市信義區
                        </div>
                        <div class="MemberAct-pro">
                            <img src="/img/icons/holder.png">
                            <span> 514頻道 </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row Member-content" id="Mtab-3">
                <div class="col-md-4 Member-panel">
                    <div class="MemberAct-id">
                    </div>
                    <div class="MemberAct-thumbnail" style=" background-image: url(/img/pics/activity-photo.jpg)">
                    </div>
                    <div class="MemberAct-text">
                        <div class="MemberAct-title word-indent-01">活動標題
                        </div>
                        <div class="MemberAct-info">
                            <img src="/img/pics/calendar-icon-02.png">06-18（六）
                        </div>
                        <div class="MemberAct-info">
                            <img src="/img/pics/money-icon-02.png">$1,200元
                        </div>
                        <div class="MemberAct-info">
                            <img src="/img/pics/location-icon-02.png">台北市信義區
                        </div>
                        <div class="MemberAct-pro">
                            <img src="/img/icons/holder.png">
                            <span> 514頻道 </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $(function(){
	// 預設顯示第一個 Tab
	var _showTab = 0;
	$('.Member-Tab').each(function(){
		// 目前的頁籤區塊
		var $tab = $(this);

		var $defaultLi = $('ul.Tabs li', $tab).eq(_showTab).addClass('Member-active');
		$($defaultLi.find('a').attr('href')).siblings().hide();

		// 當 li 頁籤被點擊時...
		// 若要改成滑鼠移到 li 頁籤就切換時, 把 click 改成 mouseover
		$('ul.Tabs li', $tab).click(function() {
			// 找出 li 中的超連結 href(#id)
			var $this = $(this),
				_clickTab = $this.find('a').attr('href');
			// 把目前點擊到的 li 頁籤加上 .active
			// 並把兄弟元素中有 .active 的都移除 class
			$this.addClass('Member-active').siblings('.Member-active').removeClass('Member-active');
			// 淡入相對應的內容並隱藏兄弟元素
			$(_clickTab).stop(false, true).fadeIn().siblings().hide();

			return false;
		}).find('a').focus(function(){
			this.blur();
		});
	});
});
</script>
@endsection
