<!DOCTYPE html>
<html lang="zh-Hant-TW">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>514 後台管理系統</title>
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/bootstrap-reset.css')}}">
    <link rel="stylesheet" href="{{asset('assets/font-awesome/css/font-awesome.css')}}">
    <link rel="stylesheet" href="{{asset('css/nprogress.css') }}">
    <link rel="stylesheet" href="{{asset('css/slidebars.css')}}">
    @yield('style')
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" href="{{asset('css/style-responsive.css')}}">
</head>

<body id="514Admin">


    <section class="wrapper">
  			<div class="Customer">
    				<div class="page-header">
      					<div class="alert alert-info" role="alert">
        						<ul>
      							<li><p>建議廠商修改活動內容，</p><p>將 Mail 廠商要求重新修正內容。</p></li>
        						</ul>
      					</div>
    				</div>
        <form class="form-horizontal" enctype="multipart/form-data"
            method="post" autocomplete="off" role="form" action="{{ URL::current() }}">
            {!! csrf_field() !!}

				<div class="panel panel-default">
  					<div class="panel-heading">
                聯絡廠商
  					</div>
  					<div class="panel-body">
    						<form id="cusForm" method="post" class="form-horizontal" style="padding: 10px 25px;">
      							<div class="form-group">
                        <label class="col-sm-2 control-label" for="name"><span>*</span>活動廠商</label>
        								<div class="col-sm-10">
                          <input class="form-control" type="hidden" name="provider_id" id="provider_id" value="{{ $provider->provider_id }}"/>
                          <input class="form-control" type="hidden" name="name" id="name" value="{{ $provider->name }}"/>
                            <p class="form-control-static">{{ $provider->name }}</p>
        								</div>
      							</div>
      							<div class="form-group">
        								<label class="col-sm-2 control-label" for="activity"><span>*</span>活動名稱</label>
        								<div class="col-sm-10">
                            <input class="form-control" type="hidden" name="activity" id="activity" value="{{ $provider->activity }}"/>
                            <p class="form-control-static">{{ $provider->activity }}</p>
        								</div>
      							</div>
      							<div class="form-group">
        								<label class="col-sm-2 control-label" for="email"><span>*</span>電子郵件</label>
        								<div class="col-sm-10">
                            <input class="form-control" type="hidden" name="email" id="email" value="{{ $provider->email }}"/>
                            <p class="form-control-static">{{ $provider->email }}</p>
        								</div>
      							</div>
      							<div class="form-group">
        								<label class="col-sm-2 control-label" for="phone"><span>*</span>聯絡電話</label>
        								<div class="col-sm-10">
                            <input class="form-control" type="hidden" name="phone" id="phone" value="{{ $provider->phone }}"/>
                            <p class="form-control-static">{{ $provider->phone }}</p>
        								</div>
      							</div>
                    <div class="form-group">
        								<label class="col-sm-2 control-label" for="comment"><span>*</span>建議修改</label>
        								<div class="col-sm-10">
          									<textarea type="text" class="form-control" name="comment" /></textarea>
        								</div>
      							</div>
      							<div class="form-group">
        								<div class="col-sm-12 customer-button">
                            <button type="submit" class="btn btn-primary" id="submit" name="submit" value="submit" onclick="parent.$.colorbox.close();">退回</button>
        								</div>
      							</div>
    						</form>
  					</div>
				</div>
    </section>

    <script type="text/javascript" src="{{ asset('js/jquery-2.2.2.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery-ui-1.9.2.custom.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery-migrate-1.2.1.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.pjax.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/nprogress.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/slidebars.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/moment.min.js') }}"></script>
</body>
</html>
