@extends('admin.layouts.modal') {{-- Content --}} @section('content')
<!-- Tabs -->
<ul class="nav nav-tabs">
    <li class="active">
        <a href="#tab-general" data-toggle="tab"> 會員設定</a>
    </li>
</ul>
<!-- ./ tabs -->
{{-- Edit Blog Form --}}
<form class="form-horizontal" enctype="multipart/form-data"
  	method="post" autocomplete="off"  role="form"
  	action="@if(isset($member)){{ URL::to('dashboard/member/'.$member->id.'/update') }}
	        @else{{ URL::to('dashboard/member/create') }}@endif">
    {!! csrf_field() !!}
  	<!-- CSRF Token -->
  	<!-- <input type="hidden" name="_token" value="{{{ csrf_token() }}}" /> -->
  	<!-- ./ csrf token -->
  	<!-- Tabs Content -->
  	<div class="tab-content">
    		<!-- General tab -->
    		<div class="tab-pane active" id="tab-general">
    				<div class="form-group {{{ $errors->has('name') ? 'has-error' : '' }}}">
      					<div class="col-md-12">
        						<label class="control-label col-sm-2" for="name">
                        使用者名稱
                    </label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="name" id="name"
              							value="{{{ Input::old('name', isset($member) ? $member->name : null) }}}" />
            						    <!-- {!!$errors->first('name', '<label class="control-label">:message</label>')!!} -->
                    </div>
                </div>
    				</div>
            <div class="form-group  {{ $errors->has('name') ? 'has-error' : '' }}">
            {!! Form::label('name', trans("admin/users.name"), array('class' => 'control-label')) !!}
                <div class="controls">
                    {!! Form::text('name', null, array('class' => 'form-control')) !!}
                    <span class="help-block">{{ $errors->first('name', ':message') }}</span>
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
                            @if ($errors)
                                <span class="help-block">
                                    <p>{{ $errors->first('address') }}</p>
                                </span>
                            @endif

            						    <!-- {!!$errors->first('address', '<label class="control-label">:message</label>')!!} -->
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
            						    {!!$errors->first('email', '<label class="control-label">:message</label>')!!}
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <p>{{ $errors->first('email') }}</p>
                                </span>
                            @endif
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
            						    {!!$errors->first('phone', '<label class="control-label">:message</label>')!!}
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
              							value="{{{ Input::old('phbank_nameone', isset($member) ? $member->bank_name : null) }}}" />
            						    {!!$errors->first('bank_name', '<label class="control-label">:message</label>')!!}
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
            						    {!!$errors->first('bank_account', '<label class="control-label">:message</label>')!!}
                    </div>
                </div>
    				</div>
            <div class="form-group {{{ $errors->has('password') ? 'has-error' : '' }}}">
      					<div class="col-md-12">
        						<label class="control-label col-sm-2" for="password">
                        登入密碼
                    </label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="password" id="password"
              							value="" />
            						    {!!$errors->first('password', '<label class="control-label">:message</label>')!!}
                    </div>
                </div>
    				</div>

            <div class="form-group">
                <div class="col-md-12">
                    <label class="control-label col-sm-2" for="password">
                        帳戶權限
                    </label>
                    <div class="login-info checkbox col-sm-10">
                        <label>
                            <input type="checkbox" name="permision[]" value="adminer">
                            管理者
                        </label>
                        <label>
                            <input type="checkbox" name="permision[]" value="hoster">
                            活動主
                        </label>
                        <label>
                            <input type="checkbox" name="permision[]" value="author">
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
                        <label>
                            <input type="radio" name="status" value="checked">
                            認證
                        </label>
                        <label>
                            <input type="radio" name="status" value="uncheck">
                            未認證
                        </label>
                        <label>
                            <input type="radio" name="status" value="block">
                            封鎖
                        </label>
                    </div>
                </div>
            </div>


				<!-- ./ general tab -->
        </div>
  			<!-- ./ tabs content -->
    </div>
		<!-- Form Actions -->
		<div class="form-group">
  			<div class="col-md-12">
    				<button type="reset" class="btn btn-sm btn-warning close_popup">
      					<span class="glyphicon glyphicon-ban-circle"></span>
                取消
    				</button>
    				<button type="reset" class="btn btn-sm btn-default">
      					<span class="glyphicon glyphicon-remove-circle"></span>
                重置
    				</button>
    				<button type="submit" class="btn btn-sm btn-success">
      					<span class="glyphicon glyphicon-ok-circle"></span>
      					@if	(isset($member))
      					  變更
      					@else
      					  確定
      					@endif
    				</button>
  			</div>
		</div>
		<!-- ./ form actions -->

</form>


@stop
