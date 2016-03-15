@extends('layouts.app')

@section('content')
<div class="login-container">
    <div class="login-panel col-md-8 col-md-offset-2">
        <div class="panel-heading">購物測試</div>
        <div class="panel-body">
            @if (Session::has('flashmessage'))
                <div class="alert alert-danger">{{ Session::get('flashmessage') }}</div>
            @endif
            <form class="form-horizontal" role="form" method="POST" action="{{ URL::current() }}">
                {!! csrf_field() !!}
                <div class="form-group{{ $errors->has('ticket') ? ' has-error' : '' }}">
                    <label class="col-md-4 control-label">
                        <span>*</span>
                        選擇票卷
                    </label>
                    <div class="col-md-8">
                        <select style="width: 100%" name="ticket" id="ticket" class="form-control">
                        @foreach($tickets as $ticket)
                            <option value="{{$ticket->id}}">
                                {{$ticket->name}} ( {{$ticket->price}} 元 / 張 )
                            </option>
                        @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group{{ $errors->has('number') ? ' has-error' : '' }}">
                    <label class="col-md-4 control-label">
                        <span>*</span>
                        選擇張數
                    </label>
                    <div class="col-md-8">
                        <select style="width: 100%" name="number" id="number" class="form-control">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="4">4</option>
                            <option value="8">8</option>
                        </select>
                    </div>
                </div>
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <label class="col-md-4 control-label">
                        <span>*</span>
                        姓名
                    </label>
                    <div class="col-md-8">
                        <input type="name" class="form-control" name="name" value="測試一" placeholder="請輸入您的姓名">
                    </div>
                </div>
                <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                    <label class="col-md-4 control-label">
                        <span>*</span>
                        電話
                    </label>
                    <div class="col-md-8">
                        <input type="phone" class="form-control" name="phone" value="0919173037" placeholder="請輸入您的電話">
                    </div>
                </div>
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label class="col-md-4 control-label">
                        <span>*</span>
                        E-mail
                    </label>
                    <div class="col-md-8">
                        <input type="email" class="form-control" name="email" value="test@514.com.tw" placeholder="請輸入您的 E-mail">
                    </div>
                </div>

                <button type="submit" class="btn btn-sm btn-success">
                    <span class="glyphicon glyphicon-ok-circle"></span>
                    @if	(isset($banners))
                      變更
                    @else
                      確定
                    @endif
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
@endsection
