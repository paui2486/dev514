@extends('layouts.app')

@section('style')
<link rel="stylesheet" href="{{asset('assets/bootstrap-fileupload/bootstrap-fileupload.css')}}" />
<link rel="stylesheet" href="{{asset('css/bootstrap-tagsinput.css')}}">
<link rel="stylesheet" href="{{asset('css/cropper.min.css')}}">
<link rel="stylesheet" href="{{asset('/css/style.css')}}"/>
@endsection

@section('content')
<div class="row Member-container">
    <div class="row Member-left col-md-4 col-xs-12">
        <div class="row Member-left-bg">
            <img src="{{ $member->avatar }}">
            <div class="Member-introduce">
                <p>@if($member->nick == '') {{ $member->name }} @else {{ $member->nick }} @endif</p>
                @foreach ( $member->tag_ids as $capacity )
                    <span>{{ $capacity }}</span>
                @endforeach
                <div class="Member-Stars">
                    <select id="Stars">
                      <option value="1">1</option>
                      <option value="1">2</option>
                      <option value="1">3</option>
                      <option value="1">4</option>
                      <option value="1">5</option>
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
            <li><a href="#Mtab-1">詳細資料</a></li>
            <li><a href="#Mtab-2">相關文章</a>
                
            
            
            
            </li>
            @if(Auth::check() && (Auth::id() ==  $member->id ))
            <li><a href="#Mtab-3" data-url="/expert/register">個人設定</a></li>
            @endif
        </ul>
        <div class="row Tab-Container">
            <div class="Member-content" id="Mtab-1">
                <p>關於我<span> About Me</span></p>
                <div class="Member-About">
                    {!! $member->description !!}
                </div>
                <p>我的活動<span> My Activies</span></p>
                <div class="row Member-activity">

                    @foreach ( $activitys as $activity )
                    <a href="/activity/{{ $activity->id }}">
                        <div class="col-xs-12 Member-panel">
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
            @if(Auth::check())
            <div class="Member-content" id="Mtab-3">
                <div class="Expert-container">
                <form class="form-horizontal" enctype="multipart/form-data"
                        method="post" autocomplete="off" role="form"
                        action="/expert/register">
                    {!! csrf_field() !!}
                    <div class="expert-content">
                        <div class="form-group">
                              <label class="control-label col-md-2" for="avatar">
                                   個人頭像<span>*</span>
                              </label>
                              <div class="col-sm-10">
                                  <div class="col-md-6 fileupload fileupload-new" data-provides="fileupload">
                                      <div class="img-preview preview-lg">
                                          <img id="avatar" width="100%" src="{{ Auth::user()->avatar }}" alt="" />
                                      </div>
                                      <div class="expert-uploadimg">
                                          <span class="btn btn-white btn-file">
                                              <span class="fileupload-new"><i class="fa fa-paper-clip"></i> 上傳圖片 </span>
                                              <input class="file input"  name="avatar" type="file" accept="image/*" value="{{ Auth::user()->avatar }}"/>
                                          </span>
                                          <button id="reset_avatar" type="button" class="btn btn-primary" data-method="reset" title="Reset" style="display:none;">
                                              <span class="docs-tooltip" data-toggle="tooltip">
                                                  <span class="fa fa-refresh"></span>
                                              </span>
                                          </button>
                                          <p>（尺寸建議為200 x 200 像素）</p>
                                      </div>
                                      <input class="form-control " type="hidden" name="dataX_avatar"  id="dataX_avatar"  value="" />
                                      <input class="form-control " type="hidden" name="dataY_avatar"  id="dataY_avatar"  value="" />
                                      <input class="form-control " type="hidden" name="dataH_avatar"  id="dataH_avatar"  value="" />
                                      <input class="form-control " type="hidden" name="dataW_avatar"  id="dataW_avatar"  value="" />
                                      <input class="form-control " type="hidden" name="dataR_avatar"  id="dataR_avatar"  value="" />
                                      <input class="form-control " type="hidden" name="dataSX_avatar" id="dataSX_avatar" value="" />
                                      <input class="form-control " type="hidden" name="dataSY_avatar" id="dataSY_avatar" value="" />
                                  </div>
                                  <div class="col-md-6 expert-eg-image">
                                      <div>
                                          <img src="/img/pics/correct-example.jpg">
                                          <p>O 建議以專長為主題，展現職人專業</p>
                                      </div>
                                      <div>
                                          <img src="/img/pics/error-example.jpg">
                                          <p>X 背景勿過於複雜，人物以個人為主</p>
                                      </div>
                                  </div>
                              </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">職人名稱 <span>*</span> </label>
                            <div class="col-md-10">
                                <input type="text" class="form-control" name="name" value="{{ (Auth::user()->nick=="")?
                                  Auth::user()->nick : Auth::user()->name }}" placeholder="此名稱將對外公開">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">特殊經歷</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="experience" id="experience" placeholder="請輸入標籤（例：米其林三星推薦）" value="" data-role="tagsinput"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">自我介紹</label>
                            <div class="col-md-10">
                                <textarea>
                                </textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12 col-xs-12 control-label expert-contact-title">聯絡方式 <span>*( 請至少選填一項 )</span>
                                
                            </label>
                            <div class="col-md-12 col-xs-12 exper-contact-content">
                                <div class="expert-contact">
                                    <div class="col-md-8">
                                        <p>聯絡電話</p>
                                        <input type="text" class="form-control expert-contact-input" name="phone" value="{{ Auth::user()->phone }}" placeholder="(02)2345-6789">
                                    </div>
                                    <div class="col-md-4 contact-display">
                                        <span>是否公開</span>
                                        <input type="radio" name="phone_s" value=1 checked=""> 是
                                        <input type="radio" name="phone_s" value=0> 否
                                    </div>
                                </div>
                                <div class="expert-contact">
                                    <div class="col-md-8">
                                        <p>手機號碼</p>
                                        <input type="text" class="form-control expert-contact-input" name="mobile" value="{{ Auth::user()->phone }}" placeholder="0912-345678">
                                    </div>
                                    <div class="col-md-4 contact-display">
                                        <span>是否公開</span>
                                        <input type="radio" name="mobile_s" value=1 checked="checked"> 是
                                        <input type="radio" name="mobile_s" value=0> 否
                                    </div>
                                </div>
                                <div class="expert-contact">
                                    <div class="col-md-8">
                                        <p>E-mail</p>
                                        <input type="email" class="form-control expert-contact-input" name="email" value="{{ Auth::user()->email }}" placeholder="service@514.com.tw">
                                    </div>
                                    <div class="col-md-4 contact-display">
                                        <span>是否公開</span>
                                        <input type="radio" name="email_s" value=1 checked="checked"> 是
                                        <input type="radio" name="email_s" value=0> 否
                                    </div>
                                </div>
                                <div class="expert-contact">
                                    <div class="col-md-8">
                                        <p>Line ID</p>
                                        <input type="text" class="form-control expert-contact-input" name="line" value="" placeholder="請輸入您的line ID">
                                    </div>
                                    <div class="col-md-4 contact-display">
                                        <span>是否公開</span>
                                        <input type="radio" name="line_s" value=1 checked="checked"> 是
                                        <input type="radio" name="line_s" value=0> 否
                                    </div>
                                </div>
                                <div class="expert-contact">
                                    <div class="col-md-8">
                                        <p>聯絡地址</p>
                                        <input type="text" class="form-control expert-contact-input" name="address" value="{{ Auth::user()->address }}" placeholder="請輸入您的聯絡地址">
                                    </div>
                                    <div class="col-md-4 contact-display">
                                        <span>是否公開</span>
                                        <input type="radio" name="address_s" value=1 checked="checked"> 是
                                        <input type="radio" name="address_s" value=0> 否
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 col-xs-12 control-label">
                                外部連結
                            </label>
                            <div class="col-md-10 col-xs-12">
                                 <input type="text" class="form-control" name='links[]' placeholder="請輸入外部連結網址（例：個人部落格網址）">
                                <div id="showBlock" class="row showBlock">
                                </div>
                                <input class="btn-white btn-file " type="button" id="btn" value="新增連結" />
                            </div>
                        </div>
                    </div>
                    <div class="expert-text">
                        <p>請填寫以下相關資料，以便日後您舉辦活動或使用金流服務。</p>
                        <label for="skip"><input type="checkbox" name="skip" id="skip"><span>先略過，日後再填寫</span></label>
                    </div>
                    <div class="row expert-Tab">
                        <ul class="row Tabs subTabs" style="margin:0;">
                            <li><a href="#Etab-1">以個人身份申請</a></li>
                            <li><a href="#Etab-2">以公司行號申請</a></li>
                        </ul>
                        <div class="row Tab-Container">
                            <div class="expert-tab-content" id="Etab-1">
                                <div class="row expert-tab-row">
                                    <label class="col-md-3 control-label">申請人姓名<span>*</span></label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="reg_name" value="{{ Auth::user()->name }}" placeholder="請輸入您的本名">
                                    </div>
                                </div>
                                <div class="row expert-tab-row">
                                    <label class="col-md-3 control-label">申請人電話<span>*</span></label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="reg_phone" value="{{ Auth::user()->phone }}">
                                    </div>
                                </div>
                                <div class="row expert-tab-row">
                                    <label class="col-md-3 control-label">通訊地址<span>*</span></label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="reg_address" value="{{ Auth::user()->address }}">
                                    </div>
                                </div>
                                <div class="row expert-tab-bottom">
                                    <div class="col-md-6 expert-tab-row">
                                        <label class="control-label">身份證影本<span>*</span></label>
                                        <div class="fileupload fileupload-new" data-provides="fileupload">
                                            <div class="fileupload-new thumbnail" style="width: 100%;">
                                                <img src="{{ asset('img/no-image.png') }}" alt="" />
                                            </div>
                                            <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 100%; line-height: 20px;"></div>
                                            <div>
                                                <span class="btn btn-white btn-file">
                                                    <span class="fileupload-new"><i class="fa fa-paper-clip"></i> 選擇圖片 </span>
                                                    <span class="fileupload-exists"><i class="fa fa-undo"></i> 更改 </span>
                                                    <input id="ID_path" class="file"  name="ID_path" type="file" accept="image/*" value=""/>
                                                </span>
                                                <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash"></i> Remove </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 expert-tab-row">
                                        <label class="control-label">存摺影本（匯款用）<span>*</span></label>
                                        <div class="fileupload fileupload-new" data-provides="fileupload">
                                            <div class="fileupload-new thumbnail" style="width: 100%;">
                                                <img src="{{ asset('img/no-image.png') }}" alt="" />
                                            </div>
                                            <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 100%;line-height: 20px;"></div>
                                            <div>
                                                <span class="btn btn-white btn-file">
                                                    <span class="fileupload-new"><i class="fa fa-paper-clip"></i> 選擇圖片 </span>
                                                    <span class="fileupload-exists"><i class="fa fa-undo"></i> 更改 </span>
                                                    <input id="bank_path" class="file"  name="bank_path" type="file" accept="image/*" value=""/>
                                                </span>
                                                <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash"></i> Remove </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="expert-tab-content" id="Etab-2">
                                <div class="row expert-tab-row">
                                    <label class="col-md-3 control-label">公司名稱<span>*</span></label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" nane="company_name" value="{{ Auth::user()->nick }}" placeholder="">
                                    </div>
                                </div>
                                <div class="row expert-tab-row">
                                    <label class="col-md-3 control-label">公司統一編號<span>*</span></label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="company_VAT">
                                    </div>
                                </div>
                                <div class="row expert-tab-row">
                                    <label class="col-md-3 control-label">公司地址<span>*</span></label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="company_address" value="{{ Auth::user()->address }}">
                                    </div>
                                </div>
                                <div class="row expert-tab-row">
                                    <label class="col-md-3 control-label">聯絡人姓名<span>*</span></label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="contact_name" value="{{ Auth::user()->name }}">
                                    </div>
                                </div>
                                <div class="row expert-tab-row">
                                    <label class="col-md-3 control-label">聯絡人電話<span>*</span></label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="contact_phone" value="{{ Auth::user()->phone }}">
                                    </div>
                                </div>
                                <div class="row expert-tab-bottom">
                                    <div class="col-md-6 expert-tab-row">
                                        <label class="control-label">公司營業登記表影本<span>*</span></label>
                                        <div class="fileupload fileupload-new" data-provides="fileupload">
                                            <div class="fileupload-new thumbnail" style="width: 100%;">
                                                <img src="{{ asset('img/no-image.png') }}" alt="" />
                                            </div>
                                            <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 100%; line-height: 20px;"></div>
                                            <div>
                                                <span class="btn btn-white btn-file">
                                                    <span class="fileupload-new"><i class="fa fa-paper-clip"></i> 選擇圖片 </span>
                                                    <span class="fileupload-exists"><i class="fa fa-undo"></i> 更改 </span>
                                                    <input id="cID_path" class="file"  name="cID_path" type="file" accept="image/*" value=""/>
                                                </span>
                                                <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash"></i> Remove </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 expert-tab-row">
                                        <label class="control-label">公司存摺影本（匯款用）<span>*</span></label>
                                        <div class="fileupload fileupload-new" data-provides="fileupload">
                                            <div class="fileupload-new thumbnail" style="width: 100%;">
                                                <img src="{{ asset('img/no-image.png') }}" alt="" />
                                            </div>
                                            <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 100%; height: 240px; line-height: 20px;"></div>
                                            <div>
                                                <span class="btn btn-white btn-file">
                                                    <span class="fileupload-new"><i class="fa fa-paper-clip"></i> 選擇圖片 </span>
                                                    <span class="fileupload-exists"><i class="fa fa-undo"></i> 更改 </span>
                                                    <input id="cbank_path" class="file"  name="cbank_path" type="file" accept="image/*" value=""/>
                                                </span>
                                                <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash"></i> Remove </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    {{ Form::hidden('invisible', 1) }}
                    <div class="expert-confirm">
                        <button type="submit" class="btn btn-sm">
                            確認送出
                        </button>
                    </div>
                </form>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="/js/jquery.barrating.min.js"></script>
<script type="text/javascript" src="{{ asset('js/jquery-migrate-1.2.1.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/bootstrap-fileupload/bootstrap-fileupload.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/bootstrap-tagsinput.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/cropper.min.js') }}"></script>
<script>
$(function(){
	$('.Member-Tab').each(function(){
		var $tab = $(this);
        var _showTab = 0;
        var invisible = 1;

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

    $('.expert-Tab').each(function(){
		var $tab = $(this);
        var _showTab = 0;
        var invisible = 1;

		var $subDefaultLi = $('ul.subTabs li', $tab).eq(_showTab).addClass('Member-active');

        $($subDefaultLi.find('a').attr('href')).siblings().hide();

		$('ul.subTabs li', $tab).click(function() {
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

    var blobURL;
    var $inputImage = $('.input');
    var URL = window.URL || window.webkitURL;
    $('[data-toggle="tooltip"]').tooltip();
    if (URL) {
        $inputImage.change(function () {
            var file;
            var $ratio;
            var files   = this.files;
            var $name   = $(this).attr('name');
            var $image  = $('#'.concat($name));
            var $reset  = $('#reset_'.concat($name));
            var $dataX  = $('#dataX_'.concat($name));
            var $dataY  = $('#dataY_'.concat($name));
            var $dataHeight = $('#dataH_'.concat($name));
            var $dataWidth  = $('#dataW_'.concat($name));
            var $dataRotate = $('#dataR_'.concat($name));
            var $dataScaleX = $('#dataSX_'.concat($name));
            var $dataScaleY = $('#dataSY_'.concat($name));

            $reset.show();
            $reset.click(function () {
                $image.cropper('reset');
            });

            $image.cropper({
                aspectRatio: 1/1,
                crop: function(e) {
                    $dataX.val(Math.round(e.x));
                    $dataY.val(Math.round(e.y));
                    $dataHeight.val(Math.round(e.height));
                    $dataWidth.val(Math.round(e.width));
                    $dataRotate.val(e.rotate);
                    $dataScaleX.val(e.scaleX);
                    $dataScaleY.val(e.scaleY);
                }
            });

            if (!$image.data('cropper')) { return; }
            if (files && files.length) {
                file = files[0];
                if (/^image\/\w+$/.test(file.type)) {
                    blobURL = URL.createObjectURL(file);
                    $image.one('built.cropper', function () {
                        // Revoke when load complete
                        URL.revokeObjectURL(blobURL);
                    }).cropper('reset').cropper('replace', blobURL);
                    // $inputImage.val('');
                } else {
                    window.alert('Please choose an image file.');
                }
            }
            $('.fileupload-new').attr("style", "display:inline");
        });
    } else {
        $inputImage.prop('disabled', true).parent().addClass('disabled');
    }

    // handle if a or b is not a number -->  isNaN(a) || isNaN(b)
    $('#skip').click(function(){
       $skipvalue = $('#skip').prop('checked');
       if( $skipvalue ) {
           $('.expert-Tab').hide('fast');
           $('input[name=invisible]').val(0);
       } else {
           $('.expert-Tab').show('fast');
           $('input[name=invisible]').val(invisible);
       }
    });

    $(document).on("keypress", "form", function(event) {
        return event.keyCode != 13;
    });

    var txtId = 1;
    $("#btn").click(function () {
        $("#showBlock").append('<div class="new-url" id="div' + txtId + '">\
          <input type="text" class="form-control new-url-text" name="links[]" placeholder="請輸入外部連結網址">\
          <input type="button" class="btn-white btn-file" style="    margin: 1px;" value="移除連結" onclick="deltxt('+txtId+')"></div>');
        txtId++;
    });
//$(document).ready(function () {
//    $('#skip').click(function(){
//        $('.expert-Tab').hide();
//    });
//});

//remove div
function deltxt(id) {
    $("#div"+id).remove();
}


</script>
@endsection
