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
                        <input class="form-control" type="text" name="phone" id="phone"
              							value="{{{ Input::old('phone', isset($member) ? $member->phone : null) }}}" />
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
                        <input class="form-control" type="text" name="bank_account" id="bank_account"
              							value="{{{ Input::old('bank_account', isset($member) ? $member->bank_account : null) }}}" />
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

<script type="text/javascript" src="{{asset('assets/bootstrap-fileupload/bootstrap-fileupload.js')}}"></script>
