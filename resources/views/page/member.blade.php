@extends('layouts.app')

@section('content')
<div class="row Member-container">
    <div class="row Member-left col-md-4 col-xs-12">
        <div class="row Member-left-bg">
            <img src="{{ $member->avatar }}">
            <div class="Member-introduce">
                <p>{{ $member->nick }}</p>
                <span>最佳職人</span><span>多項技能</span>
                <div class="Member-Stars">
                    <select id="Stars">
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                      <option value="5">5</option>
                    </select>
                </div>
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
<!--
                <div class="trace-button">
                    <span class="contact-dropbtn">＋追蹤我</span>
                </div>
-->
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
                <p>關於我<span> About Me</span></p>
                <div class="Member-About">
                    <span>還沒輸入相關介紹哦！</span>
                </div>
                <p>我的活動<span> My Activies</span></p>
                <div class="row Member-activity">
                    
                    @foreach ( $activitys as $activity )
                    <a href="/activity/{{ $activity->id }}">
                        <div class="Member-panel">
                            <div class="MemberAct-id">
                            </div>
                            <div class="MemberAct-thumbnail" style=" background-image: url({{ $activity->thumbnail }})">
                                <div class="MemberAct-title ">{{ $activity->title }}
                                </div>
                            </div>
                            <div class="MemberAct-text">
                                <p><img src="/img/pics/calendar-icon-02.png">{{--*/ $weekday=['日', '一', '二', '三', '四', '五', '六'][date('w', strtotime($activity->activity_start))]; echo preg_replace("/\d{4}-(.*)\s(.*):(.*)/", "$1 ( $weekday ) $2", $activity->activity_start) /*--}}</p>
                                <p><img src="/img/pics/money-icon-02.png">${{ $activity->min_price }}元</p>
                                <p class="word-indent-01"><img src="/img/pics/location-icon-02.png">{{ $activity->location }}</p>
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
<script src="/js/jquery.barrating.min.js"></script>
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
    
$(function() {
      $('#Stars').barrating({
        theme: 'fontawesome-stars'
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
