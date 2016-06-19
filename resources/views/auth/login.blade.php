@extends('layouts.app')

@section('content')
<div class="login-container">
    <div class="login-panel col-md-8 col-md-offset-2">
        <div class="panel-heading">會員登入 Login</div>
        <div class="panel-body">
              @if (Session::has('flashmessage'))
                  <div class="alert alert-danger">{{ Session::get('flashmessage') }}</div>
              @endif
              <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                {!! csrf_field() !!}
                <div class="form-group{{ $errors->has('account') ? ' has-error' : '' }}">
                    <label class="col-md-4 control-label">
                        <span>*</span>
                        帳號 Account
                    </label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="account" value="@if(isset($_COOKIE['account'])){!! $_COOKIE['account']!!} @endif" placeholder="請輸入您的 手機號碼 或 電子信箱">

                        @if ($errors->has('account'))
                            <span class="help-block">
                                <p>{{ $errors->first('account') }}</p>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label class="col-md-4 control-label">
                        <span>*</span>
                        密碼 Password
                    </label>
                    <div class="col-md-8">
                        <input type="password" class="form-control" value="" name="password" placeholder="請輸入您的密碼">
                        @if ($errors->has('password'))
                            <span class="help-block">
                                <p>{{ $errors->first('password') }}</p>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                        <div class="login-info checkbox">
                            <label>
                                <input type="checkbox" name="remember" @if(isset($_COOKIE['remember']) && ($_COOKIE['remember'] = 'on')) checked @endif > 記住我
                            </label>
                             <span>
                                <a class="btn btn-link" href="{{ url('/password/reset') }}">忘記密碼？</a>
                            </span>
                        </div>
                </div>
                <div class="login-button col-md-offset-4">
                    <button type="submit" class="btn btn-primary">
                        登入
                    </button>
                    <a class="btn  facebook-login" href="redirect">使用Facebook登入</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
