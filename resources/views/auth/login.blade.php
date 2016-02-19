@extends('layouts.app')

@section('content')
<div class="login-container">
    <div class="login-panel col-md-8 col-md-offset-2">
        <div class="panel-heading">會員登入 Login</div>
        <div class="panel-body">
            <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                {!! csrf_field() !!}

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label class="col-md-4 control-label">
                        <span>*</span>
                        電子郵件 E-mail
                    </label>
                    <div class="col-md-8">
                        <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="請輸入您的email">

                        @if ($errors->has('email'))
                            <span class="help-block">
                                <p>{{ $errors->first('email') }}</p>
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
                        <input type="password" class="form-control" name="password" placeholder="請輸入您的密碼">

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
                                <input type="checkbox" name="remember"> 記住我
                            </label>
                             <span>
                                <a class="btn btn-link" href="{{ url('/password/reset') }}">忘記密碼？</a>
                            </span>
                            
                        </div>
                </div>

                <div class="form-group">
                    <div class="login-button col-md-6 col-md-offset-4">
                        <button type="submit" class="btn btn-primary">
                            登入
                        </button>
                        <a class="btn btn-primary facebook-login" href="redirect">使用Facebook登入</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
