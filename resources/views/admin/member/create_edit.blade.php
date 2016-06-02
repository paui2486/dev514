<link rel="stylesheet" href="{{asset('css/bootstrap-tagsinput.css')}}">

<form class="form-horizontal" enctype="multipart/form-data"
  	method="post" autocomplete="off" role="form"
  	action="@if(isset($member)){{ URL::to('dashboard/member/'.$member->id.'/update') }}
	        @else{{ URL::to('dashboard/member') }}@endif">
    {!! csrf_field() !!}
  	<!-- CSRF Token -->
  	<!-- <input type="hidden" name="_token" value="{{{ csrf_token() }}}" /> -->
  	<!-- ./ csrf token -->
  	<!-- Tabs Content -->
  	<div class="tab-content">
    		<!-- General tab -->
    		<div class="tab-pane active" id="tab-general">
            @if (count($errors) > 0)
              <div class="alert alert-danger">
                  <ul>
                      @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                      @endforeach
                  </ul>
              </div>
            @endif
            <div class="form-group {{{ $errors->has('avatar') ? 'has-error' : '' }}}">
                <div class="col-md-12">
                    <label class="control-label col-sm-2" for="avatar">
                        個人頭像
                    </label>
                    <div class="col-sm-10">
                        <div class="fileupload fileupload-new" data-provides="fileupload">
                            <div class="fileupload-new thumbnail" style="width: 150px; height: 150px;">
                                <img src="{{{ ( isset($member) && !empty($member->avatar) ? asset($member->avatar) : asset('img/no-image.png')) }}}" alt="" />
                            </div>
                            <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 100%; max-height: 300px; line-height: 20px;"></div>
                            <div>
                                <span class="btn btn-white btn-file">
                                    <span class="fileupload-new"><i class="fa fa-paper-clip"></i> 上傳圖片 </span>
                                    <span class="fileupload-exists"><i class="fa fa-undo"></i> 更改 </span>
                                    <input id="avatar" class="file"  name="avatar" type="file" />
                                </span>
                                <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash"></i> 移除圖片 </a>
                            </div>
                        </div>
                    </div>
                </div>
    				</div>
    				<div class="form-group {{{ $errors->has('name') ? 'has-error' : '' }}}">
      					<div class="col-md-12">
        						<label class="control-label col-sm-2" for="name">
                        使用者名稱
                    </label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="name" id="name"
              							value="{{{ Input::old('name', isset($member) ? $member->name : null) }}}" />
                    </div>
                </div>
    				</div>
            <div class="form-group {{{ $errors->has('nick') ? 'has-error' : '' }}}">
      					<div class="col-md-12">
        						<label class="control-label col-sm-2" for="nick">
                        使用者暱稱
                    </label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="nick" id="nick"
              							value="{{{ Input::old('name', isset($member) ? $member->nick : null) }}}" />
                    </div>
                </div>
    				</div>
            <div class="form-group {{{ $errors->has('address') ? 'has-error' : '' }}}">
      					<div class="col-md-12">
        						<label class="control-label col-sm-2" for="address">
                        居住地址
                    </label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="address" id="address"
              							value="{{{ Input::old('address', isset($member) ? $member->address : null) }}}" />
                    </div>
                </div>
    				</div>
            <div class="form-group {{{ $errors->has('email') ? 'has-error' : '' }}}">
      					<div class="col-md-12">
        						<label class="control-label col-sm-2" for="email">
                        電子信箱
                    </label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="email" id="email"
              							value="{{{ Input::old('email', isset($member) ? $member->email : null) }}}" />
                    </div>
                </div>
    				</div>
            <div class="form-group {{{ $errors->has('phone') ? 'has-error' : '' }}}">
      					<div class="col-md-12">
        						<label class="control-label col-sm-2" for="phone">
                        電話號碼
                    </label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="phone" id="phone" placeholder="xxxx-xxx-xxx"
              							value="{{{ Input::old('phone', isset($member) ? $member->phone : null) }}}"  data-masked-input="9999-999-999"/>
                    </div>
                </div>
    				</div>
            <div class="form-group {{{ $errors->has('tag_ids') ? 'has-error' : '' }}}">
                <div class="col-md-12">
                    <label class="control-label col-sm-2" for="tag_ids">
                        個人標籤
                    </label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="tag_ids" id="tag_ids" placeholder="輸入後按Enter，或使用小寫逗號區隔"
                            value="{{{ Input::old('tag_ids', isset($member) ? $member->tag_ids : null) }}}"  data-role="tagsinput"/>
                    </div>
                </div>
            </div>
            <div class="form-group {{{ $errors->has('description') ? 'has-error' : '' }}}">
                <div class="col-md-12">
                    <label class="control-label col-sm-2" for="description">
                        個人描述
                    </label>
                    <div class="col-sm-10">
                        <textarea class="form-control ckeditor" id="description" name="description" rows="6">{{{ Input::old('description', isset($member) ? $member->description : null) }}}</textarea>
                    </div>
                </div>
            </div>
            <div class="form-group {{{ $errors->has('bank_name') ? 'has-error' : '' }}}">
      					<div class="col-md-12">
        						<label class="control-label col-sm-2" for="bank_name">
                        銀行名稱
                    </label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="bank_name" id="bank_name"
              							value="{{{ Input::old('bank_name', isset($member) ? $member->bank_name : null) }}}" />
                    </div>
                </div>
    				</div>
            <div class="form-group {{{ $errors->has('bank_account') ? 'has-error' : '' }}}">
      					<div class="col-md-12">
        						<label class="control-label col-sm-2" for="bank_account">
                        銀行帳號
                    </label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="bank_account" id="bank_account" placeholder="xxxx-xxxx-xxxx-xxxx"
              							value="{{{ Input::old('bank_account', isset($member) ? $member->bank_account : null) }}}" data-masked-input="9999-9999-9999-9999"/>
                    </div>
                </div>
    				</div>
            <div class="form-group {{{ $errors->has('password') ? 'has-error' : '' }}}">
      					<div class="col-md-12">
        						<label class="control-label col-sm-2" for="password">
                        登入密碼
                    </label>
                    <div class="col-sm-10">
                        <input class="form-control" type="password" name="password" id="password" value="" />
                    </div>
                </div>
    				</div>
            @if ( Auth::user()->adminer )
            <div class="form-group">
                <div class="col-md-12">
                    <label class="control-label col-sm-2" for="password">
                        帳戶權限
                    </label>
                    <div class="login-info checkbox col-sm-10">
                        @if( Auth::user()->adminer >= 1 )
                        <label class="col-xs-3">
                            <input type="checkbox" name="permission[]" value="adminer"
                            {{{ Input::old('adminer', (isset($member) && $member->adminer ) ? 'checked' : null) }}}>
                            管理者
                        </label>
                        @endif
                        <label class="col-xs-3">
                            <input type="checkbox" name="permission[]" value="hoster"
                            {{{ Input::old('hoster', (isset($member) && $member->hoster ) ? 'checked' : null) }}}>
                            活動主
                        </label>
                        <label class="col-xs-3">
                            <input type="checkbox" name="permission[]" value="author"
                            {{{ Input::old('author', (isset($member) && $member->author ) ? 'checked' : null) }}}>
                            部落客達人
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    <label class="control-label col-sm-2" for="password">
                        帳戶狀態
                    </label>
                    <div class="radio login-info checkbox col-sm-10">
                        <label class="col-xs-3">
                            <input type="radio" name="status" value="1"
                            {{{ Input::old('status', (isset($member) && $member->status == 1 ) ? 'checked' : null) }}}>
                            已完成認證
                        </label>
                        <label class="col-xs-3">
                            <input type="radio" name="status" value="0"
                            {{{ Input::old('status', (isset($member) && $member->status == 0 ) ? 'checked' : null) }}}>
                            未完成認證
                        </label>
                        <label class="col-xs-3">
                            <input type="radio" name="status" value="2"
                            {{{ Input::old('status', (isset($member) && $member->status == 2 ) ? 'checked' : null) }}}>
                            遭系統封鎖
                        </label>
                    </div>
                </div>
            </div>
            @endif
            <div class="form-group">
          			<div class="col-md-12" style="margin:15px;">
            				<!-- <div type="reset" class="btn btn-sm btn-warning close_popup" onclick="history.go(-1);">
              					<span class="glyphicon glyphicon-ban-circle"></span>
                        取消
            				</div> -->
            				<button type="reset" class="btn btn-sm btn-default">
              					<span class="glyphicon glyphicon-remove-circle"></span>
                        重置
            				</button>
            				<button type="submit" class="btn btn-sm btn-success">
              					<span class="glyphicon glyphicon-ok-circle"></span>
              					@if	(isset($banners))
              					  變更
              					@else
              					  確定
              					@endif
            				</button>
          			</div>
            </div>
        </div>
    <!-- ./ general tab -->
    </div>
		<!-- ./ form actions -->
</form>

<script type="text/javascript" src="{{ asset('js/jquery.validate.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery.masked-input.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/additional-methods.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/bootstrap-fileupload/bootstrap-fileupload.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/ckeditor/ckeditor.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/ckfinder/ckfinder.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/bootstrap-tagsinput.min.js') }}"></script>
<script>
$(document).ready(function () {
    $.validator.addMethod("phone", function(value, element) {
        return this.optional(element) || /\d{4}-\d{3}-\d{3}/.test(value);
    }, "請輸入完整電話號碼");

    $.validator.addMethod("credit_card", function(value, element) {
        return this.optional(element) || /\d{4}-\d{4}-\d{4}-\d{4}/.test(value);
    }, "請輸入正確銀行帳號");

    var description = CKEDITOR.replace( 'description', {
        language : 'zh',
        height : 100,
        autosave_SaveKey: 'autosaveKey',
        autosave_NotOlderThen : 10,
        filebrowserBrowseUrl : '/assets/ckfinder/ckfinder.html',
        filebrowserImageBrowseUrl : '/assets/ckfinder/ckfinder.html?Type=Images',
        filebrowserUploadUrl : '/assets/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
        filebrowserImageUploadUrl : '/assets/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
        toolbar: [
            ['Styles', 'Format', 'Font', 'FontSize'],
            ['TextColor', 'BGColor']
        ],
        uiColor : '#9AB8F3'
    });

    @if($member->description == '')
      $('#description').val('<br>514 真正有意思～<br>');
    @endif

    $(document).on("keypress", "form", function(event) {
        return event.keyCode != 13;
    });

    $('form').on('submit', function() {
        CKEDITOR.instances.content.updateElement();
    });

    $(".form-horizontal").validate( {
        rules: {
              name: {
                  required: true,
              },
              address: {
                  required: false,
              },
              email: {
                  email: true,
                  required: true,
              },
              phone: {
                  required: false,
                  phone: false,
              },
              bank_account: {
                  credit_card: false,
              },
          },
          messages: {
              name: "*請填寫使用者名稱",
              email: {
                  required: "*請輸入電子信箱",
                  email: "*請輸入 email 格式"
              },
          },
          errorElement: "em",
          errorPlacement: function ( error, element ) {
          // Add the `help-block` class to the error element
            error.addClass( "help-block" );

            if ( element.prop( "type" ) === "checkbox" ) {
                error.insertAfter( element.parent( "label" ) );
            } else {
                error.insertAfter( element );
            }
        },
        highlight: function ( element, errorClass, validClass ) {
            $( element ).parents( ".errorbox" ).addClass( "has-error" ).removeClass( "has-success" );
        },
        unhighlight: function (element, errorClass, validClass) {
            $( element ).parents( ".errorbox" ).addClass( "has-success" ).removeClass( "has-error" );
        }
    });
});
</script>
