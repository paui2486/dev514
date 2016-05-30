@extends('layouts.app')

@section('content')
<div class="row Member-container">
    <div class="row Member-left col-md-4 col-xs-12">
        <div class="row Member-left-bg">
            <img src="{{ $member->avatar }}">
            <div class="Member-introduce">
                <p>{{ $member->nick }}</p>
                <span>專業美甲師</span><span>超強小編</span>
                <img src="/img/pics/inline-star.png">
            </div>
            <div class="row Member-button">
                <div class="contact-dropdown">
                    <span class="contact-dropbtn">聯絡我</span>
                    <div class="contact-dropcontent">
                        <a><img src="/img/icons/envelope.png">
                            {{ $member->email }}</a>
                        <a><img src="/img/icons/phone-call.png">{{ $member->phone }}</a>
                        <a><img src="/img/icons/smartphone-call.png">{{ $member->phone }}</a>
                        <a><img src="/img/icons/address.png">{{ $member->address }}</a>
                    </div>
                </div>
                <div class="trace-button">
                    <span class="contact-dropbtn">＋追蹤我</span>
                </div>
            </div>
        </div>
    </div>
    <div class="row Member-Tab col-md-8">
        <ul class="row Tabs" style="margin:0;">
            <li><a href="#Mtab-1">認識職人</a></li>
            <li><a href="#Mtab-2">相關文章</a></li>
        </ul>
        <div class="row Tab-Container">
            <div class="Member-content" id="Mtab-1">
                <div class="Member-About">
                    <p>關於我<span> About Me</span></p>
                    <span>還沒輸入相關介紹哦！</span>
                </div>
                <div class="Member-experience">
                    <p>我的經歷<span> My Experience</span></p>
                    <ul style="margin-left: 20px;">
                        <!-- <li>真理大學畢業</li>
                        <li>B123擔任專職小編</li> -->
                    </ul>
                </div>
                <div class="row Member-activity">
                    <p>我的活動<span> My Activies</span></p>
                    @foreach ( $activitys as $activity )
                    <a href="/activity/{{ $activity->id }}">
                        <div class="Member-panel">
                            <div class="MemberAct-id">
                            </div>
                            <div class="MemberAct-thumbnail" style=" background-image: url({{ $activity->thumbnail }})">
                            </div>
                            <div class="MemberAct-text">
                                <div class="MemberAct-title ">{{ $activity->title }}
                                </div>
                                <div class="MemberAct-info">
                                    <span>{{--*/ $weekday=['日', '一', '二', '三', '四', '五', '六'][date('w', strtotime($activity->activity_start))]; echo preg_replace("/\d{4}-(.*)\s(.*):(.*)/", "$1 ( $weekday ) $2", $activity->activity_start) /*--}}</span>
                                    <span>${{ $activity->min_price }}元</span>
                                    <span>{{ $activity->location }}</span>
                                </div>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            <div class="Member-content" id="Mtab-2" style="padding: 30px;">
                <p style="color:#ccc;">尚無相關內容，敬請期待</p>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
$(function(){
	var _showTab = 0;
	$('.Member-Tab').each(function(){
		var $tab = $(this);

		var $defaultLi = $('ul.Tabs li', $tab).eq(_showTab).addClass('Member-active');
		$($defaultLi.find('a').attr('href')).siblings().hide();

		$('ul.Tabs li', $tab).click(function() {
			var $this = $(this),
				_clickTab = $this.find('a').attr('href');
			$this.addClass('Member-active').siblings('.Member-active').removeClass('Member-active');
			$(_clickTab).stop(false, true).fadeIn().siblings().hide();
			return false;
		}).find('a').focus(function(){
			this.blur();
		});
	});
});

$(".trace-button > span").on("click", function () {
        if ($(this).hasClass('teaced-me')) {
            $(this).removeClass('teaced-me');
        }
        else {
            $(this).addClass('teaced-me');
        }
    });


</script>
@endsection
