{{-- */
    $layouts = ( isset($_GET['view'])) ? 'admin.layouts.modal' : 'layouts.admin';
/* --}}
@extends($layouts)

{{-- Content --}}

@section('content')
<!-- Tabs -->
@if (!isset($_GET['view']))
<section id="main-content">
    <section class="wrapper">
@endif

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
                                Banner 網址
                            </label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" name="source" id="source"
                      							value="{{{ Input::old('source', isset($banners) ? $banners->source : null) }}}" />
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
              					@if	(isset($banners))
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
