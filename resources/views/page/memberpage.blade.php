@extends('layouts.app')

@section('content')
<div class="row Member-container">
    <div class="row Member-left col-md-4 col-xs-12">
        <div class="row Member-left-bg">
            <img src="/img/pics/default-02.png">
            <div class="Member-introduce">
                <p>Wen-Yu Chen</p>
                <span>專業美甲師</span><span>超強小編</span>
                <img src="/img/pics/inline-star.png">
            </div>
            <div class="row Member-button">
                <div class="contact-dropdown">
                    <span class="contact-dropbtn">聯絡我</span>
                    <div class="contact-dropcontent">
                        <a><img src="/img/icons/envelope.png">
                            grace@514.com.tw</a>
                        <a><img src="/img/icons/phone-call.png">02-2767-5146</a>
                        <a><img src="/img/icons/smartphone-call.png">0912-345678</a>
                        <a><img src="/img/icons/address.png">台北市信義區基隆路一段155號</a>
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
                        <li>真理大學畢業</li>
                        <li>B123擔任專職小編</li>
                    </ul>
                </div>
                <div class="row Member-activity">
                    <p>我的活動<span> My Activies</span></p>
                    <a href="#">
                    <div class="Member-panel">
                        <div class="MemberAct-id">
                        </div>
                        <div class="MemberAct-thumbnail" style=" background-image: url(/img/pics/macaron.jpg)">
                        </div>
                        <div class="MemberAct-text">
                            <div class="MemberAct-title ">夏日指彩教學～漸層色超美
                            </div>
                            <div class="MemberAct-info">
                                <span>06-18（六）</span>
                                <span>$1,200元</span>
                                <span>台北市</span>
                            </div>
                        </div>
                    </div>
                    </a>
                    <a href="#">
                    <div class="Member-panel">
                        <div class="MemberAct-id">
                        </div>
                        <div class="MemberAct-thumbnail" style=" background-image: url(/img/pics/macaron.jpg)">
                        </div>
                        <div class="MemberAct-text">
                            <div class="MemberAct-title ">夏日指彩教學～漸層色超美
                            </div>
                            <div class="MemberAct-info">
                                <span>06-18（六）</span>
                                <span>$1,200元</span>
                                <span>台北市</span>
                            </div>
                        </div>
                    </div>
                    </a>
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