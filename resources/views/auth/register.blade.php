@extends('layouts.app')

@section('content')
<div class="row register-container">
    <div class="register-panel col-md-6 col-md-offset-2">
        <div class="panel-heading">成為 514 會員</div>
        <div class="panel-body">
            <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
                {!! csrf_field() !!}

                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <label class="col-md-4 control-label"> <span>*</span>姓名 </label>

                    <div class="col-md-8">
                        <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="建議輸入真實姓名">

                        @if ($errors->has('name'))
                            <span class="help-block">
                                <p>{{ $errors->first('name') }}</p>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label class="col-md-4 control-label"> <span>*</span>電子郵件 </label>

                    <div class="col-md-8">
                        <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="mis@514.com.tw">

                        @if ($errors->has('email'))
                            <span class="help-block">
                                <p>{{ $errors->first('email') }}</p>
                            </span>
                        @endif
                    </div>
                </div>
                
                <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                    <label class="col-md-4 control-label"> <span>*</span>電話號碼 </label>

                    <div class="col-md-8">
                        <input type="phone" class="form-control" name="phone" value="{{ old('phone') }}" placeholder="09xx-xxxxxx">

                        @if ($errors->has('phone'))
                            <span class="help-block">
                                <p>{{ $errors->first('phone') }}</p>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label class="col-md-4 control-label">
                        <span>*</span>
                        密碼 
                    </label>

                    <div class="col-md-8">
                        <input type="password" class="form-control" name="password" placeholder="含有英文或數字之密碼">

                        @if ($errors->has('password'))
                            <span class="help-block">
                                <p>{{ $errors->first('password') }}</p>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                    <label class="col-md-4 control-label">
                        <span>*</span>
                        確認密碼 
                    </label>

                    <div class="col-md-8">
                        <input type="password" class="form-control" name="password_confirmation" placeholder="請再輸入一次密碼">

                        @if ($errors->has('password_confirmation'))
                            <span class="help-block">
                                <p>{{ $errors->first('password_confirmation') }}</p>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="row register-button">
                    <div class="login-button col-md-offset-4">
                        <button type="submit" class="btn btn-primary">
                            註冊
                        </button>
                        <a class="btn facebook-login" href="redirect">使用Facebook註冊</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-6 expert-panel">
        <div class="panel-heading">成為職人</div>
        <div class="expert-content">
            <p>什麼是職人？</p>
            <span>想成為不同領域的職業人士嗎？除了現在職場上的專業才能，您還有其他專長嗎？514提供您一個平台，讓您可以在閒暇時間，利用您的一技之長賺取經歷或金錢，開拓您另一塊領域的職業才能，建立您下班後的夢想平台！</span>
            <p>成為職人有什麼好處？</p>
            <span>成為514職人，您將可以在514平台上，刊登您擅長領域的活動或課程，讓他人分享您的技能之餘，您也可以藉此賺取外快或是磨練技術！且現階段不需收取任何上架費，在您開設活動並販售出票券後，我們才會收取您一張票10%的手續費，長期合作職人還能享其他優惠方案。</span>
        </div>
        <p class="expert-alert">＊尚未成為514會員請先於左方註冊</p>
        <a href="#"><div class="expert-button">已是會員，馬上成為職人</div></a>
    </div>
</div>
@endsection