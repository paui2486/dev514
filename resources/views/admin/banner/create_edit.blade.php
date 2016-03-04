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
<section id="main-content">
    <section class="wrapper">
        <ul class="nav nav-tabs">
            <li class="active">
                <a href="#tab-general" data-toggle="tab">Banner 設定</a>
            </li>
        </ul>

        <form class="form-horizontal" enctype="multipart/form-data"
          	method="post" autocomplete="off" role="form"
          	action="@if(isset($banners)){{ URL::to('dashboard/banner/'.$banners->id.'/update') }}
        	        @else{{ URL::to('dashboard/banner') }}@endif">
            {!! csrf_field() !!}
          	<!-- CSRF Token -->
          	<!-- <input type="hidden" name="_token" value="{{{ csrf_token() }}}" /> -->
          	<!-- ./ csrf token -->
          	<!-- Tabs Content -->
          	<div class="tab-content">
            		<!-- General tab -->
            		<div class="tab-pane active" id="tab-general">
            				<div class="form-group {{{ $errors->has('title') ? 'has-error' : '' }}}">
              					<div class="col-md-12">
                						<label class="control-label col-sm-2" for="title">
                                Banner 標題
                            </label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" name="title" id="title"
                      							value="{{{ Input::old('title', isset($banners) ? $banners->title : null) }}}" />
                    						    <!-- {!!$errors->first('name', '<label class="control-label">:message</label>')!!} -->
                            </div>
                        </div>
            				</div>
                    <div class="form-group {{{ $errors->has('source') ? 'has-error' : '' }}}">
              					<div class="col-md-12">
                						<label class="control-label col-sm-2" for="source">
                                Banner 圖檔
                            </label>
                            <div class="col-sm-10">
                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                    <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                                        <img src="{{{ ( isset($banners) && !empty($banners->source) ? asset($banners->source) : asset('img/no-image.png')) }}}" alt="" />
                                    </div>
                                    <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                    <div>
                                        <span class="btn btn-white btn-file">
                                            <span class="fileupload-new"><i class="fa fa-paper-clip"></i> 選擇圖片 </span>
                                            <span class="fileupload-exists"><i class="fa fa-undo"></i> 更改 </span>
                                            <input id="source" class="file[]"  name="source" type="file" />
                                        </span>
                                        <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash"></i> Remove </a>
                                    </div>
                                </div>
                            </div>
                        </div>
            				</div>
                    <div class="form-group {{{ $errors->has('caption') ? 'has-error' : '' }}}">
              					<div class="col-md-12">
                						<label class="control-label col-sm-2" for="caption">
                                Banner 標語
                            </label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" name="caption" id="caption"
                      							value="{{{ Input::old('caption', isset($banners) ? $banners->caption : null) }}}" />
                                    @if ($errors)
                                        <span class="help-block">
                                            <p>{{ $errors->first('caption') }}</p>
                                        </span>
                                    @endif
                            </div>
                        </div>
            				</div>
                    <div class="form-group {{{ $errors->has('email') ? 'has-error' : '' }}}">
              					<div class="col-md-12">
                						<label class="control-label col-sm-2" for="priority">
                                優先權
                            </label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" name="priority" id="priority"
                      							value="{{{ Input::old('priority', isset($banners) ? $banners->priority : null) }}}" />
                                    @if ($errors->has('priority'))
                                        <span class="help-block">
                                            <p>{{ $errors->first('priority') }}</p>
                                        </span>
                                    @endif
                            </div>
                        </div>
            				</div>
                    <div class="form-group">
              					<div class="col-md-12">
                            {{ Form::hidden('position', '1') }}
                        </div>
                    </div>
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
    </section>
</section>

@stop

@section('scripts')
    @parent
    <script type="text/javascript" src="{{asset('assets/bootstrap-fileupload/bootstrap-fileupload.js')}}"></script>
@stop
