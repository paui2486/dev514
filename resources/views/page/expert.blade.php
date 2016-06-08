@extends('layouts.app')

@section('style')
<link rel="stylesheet" href="{{asset('/css/style.css')}}"/>
@endsection

@section('content')
<form class="form-horizontal expert-container" role="form">
    <div class="form-group">
        <div class="col-md-12">
            <label class="control-label col-md-2" for="avatar">
                 個人頭像<span>*</span>
            </label>
            <div class="col-sm-10">
                <div class="fileupload fileupload-new" data-provides="fileupload">
                    <div class="fileupload-new thumbnail" style="width: 200px; height: 200px;    background-image: url('/img/no-image.png');background-size: cover;background-position: center;">
                        
                    </div>
<!--                    <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 100%; max-height: 300px; line-height: 20px;"></div>-->
                    <div>
                        <span class="btn btn-white btn-file">
                            <span class="fileupload-new"><i class="fa fa-paper-clip"></i> 上傳圖片 </span>
                        </span>
                        <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash"></i> 移除圖片 </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label">職人名稱 <span>*</span> </label>
        <div class="col-md-10">
            <input type="text" class="form-control" name="name" value="" placeholder="此名稱將對外公開">

            @if ($errors->has('name'))
                <span class="help-block">
                    <p>{{ $errors->first('name') }}</p>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-2 control-label">特殊經歷</label>

        <div class="col-md-10">
            <input type="text" class="form-control" name="experience" value="" placeholder="例：米其林三星推薦、世界調酒師大賽冠軍">
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-2 control-label">聯絡方式 <span>*</span>
            <br><span>( 請至少選填一項 )</span>
        </label>
        <div class="col-md-10">
            <div class="expert-contact">
                <div class="col-md-9">
                    <p>聯絡電話</p>
                    <input type="phone" style="width:85%" class="form-control" name="phone" value="{{ old('phone') }}" placeholder="(02)2345-6789">
                </div>
                <div class="col-md-3 contact-display">
                    <span>是否公開</span>
                    <input type="radio" name="display0" checked="checked"> 是
                    <input type="radio" name="display0"> 否
                </div>
            </div>
            <div class="expert-contact">
                <div class="col-md-9">
                    <p>手機號碼</p>
                    <input type="phone" style="width:85%" class="form-control" name="phone" value="{{ old('phone') }}" placeholder="0912-345-678">
                </div>
                <div class="col-md-3 contact-display">
                    <span>是否公開</span>
                    <input type="radio" name="display1" checked="checked"> 是
                    <input type="radio" name="display1"> 否
                </div>
            </div>
            <div class="expert-contact">
                <div class="col-md-9">
                    <p>E-mail</p>
                    <input type="email"  style="width:85%" class="form-control" name="email" value="{{ old('email') }}" placeholder="service@514.com.tw">
                </div>
                <div class="col-md-3 contact-display">
                    <span>是否公開</span>
                    <input type="radio" name="display2" checked="checked" > 是
                    <input type="radio" name="display2"> 否
                </div>
            </div>
            <div class="expert-contact">
                <div class="col-md-9">
                    <p>Line ID</p>
                    <input type="text" style="width:85%" class="form-control" name="line" value="{{ old('line') }}" placeholder="請輸入您的line ID">
                </div>
                <div class="col-md-3 contact-display">
                    <span>是否公開</span>
                    <input type="radio" name="display3" checked="checked" > 是
                    <input type="radio" name="display3" > 否
                </div>
            </div>
            <div class="expert-contact">
                <div class="col-md-9">
                    <p>聯絡地址</p>
                    <input type="text" style="width:85%" class="form-control" name="address" value="{{ old('address') }}" placeholder="請輸入您的聯絡地址">
                </div>
                <div class="col-md-3 contact-display">
                    <span>是否公開</span>
                    <input type="radio" name="display4" checked="checked" > 是
                    <input type="radio" name="display4"> 否
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label">
            外部連結 
        </label>
        <div class="col-md-10">
             <input type="text" class="form-control" placeholder="請輸入外部連結網址（例：個人部落格網址）">
        
            <div id="showBlock" class="row showBlock">
            </div>
            <input class="button-url" type="button" id="btn" value="新增連結" />
        </div>
    </div>
</form>
<div class="expert-text">
    <p>請填寫以下相關資料，以便日後您舉辦活動或使用金流服務。</p>
    <label for="skip"><input type="checkbox" name="skip" id="skip">先略過，日後再填寫</label>
</div>
<div class="row expert-Tab">
    <ul class="row Tabs" style="margin:0;">
        <li><a href="#Etab-1">以個人身份申請</a></li>
        <li><a href="#Etab-2">以公司行號申請</a></li>
    </ul>
    <div class="row Tab-Container">
        <div class="expert-tab-content" id="Etab-1">
            <div class="row expert-tab-row">
                <label class="col-md-2 control-label">申請人姓名</label>
                <div class="col-md-10">
                    <input type="text" class="form-control" placeholder="請輸入您的本名">
                </div>
            </div>
            <div class="row expert-tab-row">
                <label class="col-md-2 control-label">申請人電話</label>
                <div class="col-md-10">
                    <input type="text" class="form-control">
                </div>
            </div>
            <div class="row expert-tab-row">
                <label class="col-md-2 control-label">通訊地址</label>
                <div class="col-md-10">
                    <input type="text" class="form-control">
                </div>
            </div>
            <div class="row expert-tab-row">
                <label class="col-md-2 control-label">身份證影本</label>
                <div class="col-md-10">
                </div>
            </div>
            <div class="row expert-tab-row">
                <label class="col-md-2 control-label">存摺影本（匯款用）</label>
                <div class="col-md-10">
                </div>
            </div>
        </div>
        <div class="expert-content" id="Etab-2">
            <div class="row expert-tab-row">
                <label class="col-md-2 control-label">公司名稱</label>
                <div class="col-md-10">
                    <input type="text" class="form-control" placeholder="">
                </div>
            </div>
            <div class="row expert-tab-row">
                <label class="col-md-2 control-label">公司統一編號</label>
                <div class="col-md-10">
                    <input type="text" class="form-control">
                </div>
            </div>
            <div class="row expert-tab-row">
                <label class="col-md-2 control-label">公司地址</label>
                <div class="col-md-10">
                    <input type="text" class="form-control">
                </div>
            </div>
            <div class="row expert-tab-row">
                <label class="col-md-2 control-label">聯絡人姓名</label>
                <div class="col-md-10">
                    <input type="text" class="form-control">
                </div>
            </div>
            <div class="row expert-tab-row">
                <label class="col-md-2 control-label">聯絡人電話</label>
                <div class="col-md-10">
                    <input type="text" class="form-control">
                </div>
            </div>
            <div class="row expert-tab-row">
                <label class="col-md-2 control-label">公司營業登記表影本</label>
                <div class="col-md-10">
                </div>
            </div>
            <div class="row expert-tab-row">
                <label class="col-md-2 control-label">公司存摺影本（匯款用）</label>
                <div class="col-md-10">
                </div>
            </div>
        
        </div>
    </div>
</div>

<div class="row register-button">
    <div class="login-button col-md-offset-4">
        <button type="submit" class="btn btn-primary">
            確認送出
        </button>
    </div>
</div>
@endsection

@section('script')
<script>
$(function(){
var _showTab = 0;
$('.expert-Tab').each(function(){
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
    
$(document).ready(function () {
    $('#skip').click(function(){
        $('.expert-Tab').hide();
    });
});
   
var txtId = 1;

$("#btn").click(function () {
    $("#showBlock").append('<div class="new-url" id="div' + txtId + '"><input type="text" class="form-control" style="width:85%;float:left;" placeholder="請輸入外部連結網址"> <input type="button" class="remove-url" value="移除連結" onclick="deltxt('+txtId+')"></div>');
    txtId++;
});

//remove div
function deltxt(id) {
    $("#div"+id).remove();
}
    
</script>
@endsection