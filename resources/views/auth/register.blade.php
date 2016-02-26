@extends('layouts.app')

@section('content')
<div class="register-container">
    <div class="register-panel col-md-8 col-md-offset-2">
        <div class="panel-heading">成為 514 會員</div>
        <div class="panel-body">
            <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
                {!! csrf_field() !!}

                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <label class="col-md-5 control-label"> <span>*</span>姓名 Your Name</label>

                    <div class="col-md-7">
                        <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="建議輸入真實姓名">

                        @if ($errors->has('name'))
                            <span class="help-block">
                                <p>{{ $errors->first('name') }}</p>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label class="col-md-5 control-label"> <span>*</span>電子郵件 E-mail</label>

                    <div class="col-md-7">
                        <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="mis@514.com.tw">

                        @if ($errors->has('email'))
                            <span class="help-block">
                                <p>{{ $errors->first('email') }}</p>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label class="col-md-5 control-label"> 
                        <span>*</span>
                        密碼 Password
                    </label>

                    <div class="col-md-7">
                        <input type="password" class="form-control" name="password" placeholder="含有英文或數字之密碼">

                        @if ($errors->has('password'))
                            <span class="help-block">
                                <p>{{ $errors->first('password') }}</p>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                    <label class="col-md-5 control-label"> 
                        <span>*</span>
                        確認密碼 Comfirm Password
                    </label>

                    <div class="col-md-7">
                        <input type="password" class="form-control" name="password_confirmation" placeholder="請再輸入一次密碼">

                        @if ($errors->has('password_confirmation'))
                            <span class="help-block">
                                <p>{{ $errors->first('password_confirmation') }}</p>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <div class="register-button">
                        <button type="submit" class="btn btn-primary">
                            加入會員
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
