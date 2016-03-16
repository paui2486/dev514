{{-- */
    $layouts = 'layouts.admin';
/* --}}
@extends($layouts)

@section('style')
<link rel="stylesheet" href="{{asset('assets/bootstrap-fileupload/bootstrap-fileupload.css')}}" />
@stop

{{-- Content --}}

@section('content')
<!-- Tabs -->
@if (!isset($_GET['view']))
<section id="main-content">
    <section class="wrapper">
@endif
        <ul class="nav nav-tabs">
            <li class="">
                <a href="#tab-general" data-toggle="tab">類別設定</a>
            </li>
            <li class="">
                <a href="{{ url("/") }}" data-toggle="tab">類別設定</a>
            </li>
            <li class="">
                <a href="#tab-3" data-toggle="tab">類別設定</a>
            </li>
            <li class="">
                <a href="#tab-3" data-toggle="tab">類別設定</a>
            </li>
            <li class="">
                <a href="#tab-3" data-toggle="tab">類別設定</a>
            </li>

        </ul>
        <form class="form-horizontal" enctype="multipart/form-data"
          	method="post" autocomplete="off" role="form"
          	action="@if(isset($category)){{ URL::to('dashboard/'. Request::segment(2) .'/category/'.$category->id.'/update') }}
        	        @else{{ URL::to('dashboard/'.  Request::segment(2) .'/category') }}@endif">
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
                                類別名稱
                            </label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" name="name" id="name"
                      							value="{{{ Input::old('name', isset($category) ? $category->name : null) }}}" />
                    						    <!-- {!!$errors->first('name', '<label class="control-label">:message</label>')!!} -->
                            </div>
                        </div>
            				</div>
                    <div class="form-group {{{ $errors->has('priority') ? 'has-error' : '' }}}">
              					<div class="col-md-12">
                						<label class="control-label col-sm-2" for="priority">
                                優先權
                            </label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" name="priority" id="priority"
                      							value="{{{ Input::old('avatar', isset($category) ? $category->priority : null) }}}" />
                            </div>
                        </div>
            				</div>
                    <div class="form-group {{{ $errors->has('logo') ? 'has-error' : '' }}}">
              					<div class="col-md-12">
                						<label class="control-label col-sm-2" for="logo">
                                類別 logo
                            </label>
                            <div class="col-sm-10">
                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                    <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                                        <img src="{{{ ( isset($category) && trim($category->logo) != "" )? asset($category->logo) : asset('img/no-image.png') }}}" alt="" />
                                    </div>
                                    <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                    <div>
                                        <span class="btn btn-white btn-file">
                                            <span class="fileupload-new"><i class="fa fa-paper-clip"></i> 選擇圖片 </span>
                                            <span class="fileupload-exists"><i class="fa fa-undo"></i> 更改 </span>
                                            <input id="logo" class="file"  name="logo" type="file" />
                                        </span>
                                        <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash"></i> Remove </a>
                                    </div>
                                </div>
                            </div>
                        </div>
            				</div>
                    <div class="form-group {{{ $errors->has('thumbnail') ? 'has-error' : '' }}}">
              					<div class="col-md-12">
                						<label class="control-label col-sm-2" for="thumbnail">
                                類別主圖
                            </label>
                            <div class="col-sm-10">
                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                    <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                                        <img src="{{{ ( isset($category) && trim($category->thumbnail) != "" ) ? asset($category->thumbnail) : asset('img/no-image.png') }}}" alt="" />
                                    </div>
                                    <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                    <div>
                                        <span class="btn btn-white btn-file">
                                            <span class="fileupload-new"><i class="fa fa-paper-clip"></i> 選擇圖片 </span>
                                            <span class="fileupload-exists"><i class="fa fa-undo"></i> 更改 </span>
                                            <input id="thumbnail" class="file"  name="thumbnail" type="file" />
                                        </span>
                                        <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash"></i> Remove </a>
                                    </div>
                                </div>
                            </div>
                        </div>
            				</div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <label class="control-label col-sm-2" for="public">
                                正式上線
                            </label>
                            <div class="radio login-info checkbox col-sm-10">
                                <label class="col-xs-3">
                                    <input type="radio" name="public" value="1"
                                    {{{ Input::old('status', (isset($category) && $category->public == 1 ) ? 'checked' : null) }}}>
                                    顯示
                                </label>
                                <label class="col-xs-3">
                                    <input type="radio" name="public" value="0"
                                    {{{ Input::old('status', (isset($category) && $category->public == 0 ) ? 'checked' : null) }}}>
                                    隱藏
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
            				<button type="reset" class="btn btn-sm btn-warning close_popup" onclick="history.go(-1);">
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
    </section>
</section>

@stop

@section('scripts')
    @parent
    <script type="text/javascript" src="{{asset('assets/bootstrap-fileupload/bootstrap-fileupload.js')}}"></script>
@stop
