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
                <a href="#tab-general" data-toggle="tab">會員設定</a>
            </li>
        </ul>

        <form class="form-horizontal" enctype="multipart/form-data"
          	method="post" autocomplete="off" role="form"
          	action="@if(isset($category)){{ URL::to('dashboard/blog/category/'.$category->id.'/update') }}
        	        @else{{ URL::to('dashboard/blog/category') }}@endif">
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
                                文章類別
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
    </section>
</section>

@stop
