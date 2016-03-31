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
          	action="@if(isset($filter)){{ URL::to('dashboard/filter/'.$filter->id.'/update') }}
        	        @else{{ URL::to('dashboard/filter') }}@endif">
            {!! csrf_field() !!}
          	<div class="tab-content">
            		<!-- General tab -->
            		<div class="tab-pane active" id="tab-general">
            				<div class="form-group {{{ $errors->has('name') ? 'has-error' : '' }}}">
              					<div class="col-md-12">
                						<label class="control-label col-sm-2" for="name">
                                名稱
                            </label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" name="name" id="name"
                      							value="{{{ Input::old('name', isset($filter) ? $filter->name : null) }}}" />
                            </div>
                        </div>
            				</div>
                    <div class="form-group {{{ $errors->has('type') ? 'has-error' : '' }}}">
                        <div class="col-md-12">
                            <label class="control-label col-sm-2" for="type">
                                Filter 分類
                            </label>
                            <div class="col-sm-10">
                                <select style="width: 100%" name="type" class="form-control">
                                @foreach($categories as $id => $value)
                                    <option value="{{ $id }}"
                                    @if (isset($filter))
                                        @if ($filter->type == $id)
                                    selected="selected"
                                        @endif
                                    @endif > {{$value}}
                                    </option>
                                @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" id="data">


                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <label class="control-label col-sm-2" for="public">
                                狀態
                            </label>
                            <div class="radio login-info checkbox col-sm-10">
                                <label class="col-xs-3">
                                    <input type="radio" name="public" value="1"
                                    {{{ Input::old('status', (isset($filter) && $filter->public == 1 ) ? 'checked' : null) }}}>
                                    顯示
                                </label>
                                <label class="col-xs-3">
                                    <input type="radio" name="public" value="0"
                                    {{{ Input::old('status', (isset($filter) && $filter->public == 0 ) ? 'checked' : null) }}}>
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
              					@if	(isset($filter))
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
<script>
$(document).ready(function () {
    @if (isset($filter))
        checkValue({{$filter->type}});
    @endif

    $('select[name=type]').on('change', function () {
        var select = $(this).val();
        checkValue(select);
    });

    function checkValue(select) {
        if (select == 5) {
            var inputForm = '<div class="col-md-12" ><label class="control-label col-sm-2" for="name"> 天數 </label> \
                  <div class="col-sm-10"><input class="form-control" type="text" name="value" \
                  value="{{{ Input::old('value', isset($filter) && $filter->type == 5 ? $filter->value : null) }}}" /> </div> </div>';
        } else if (select == 6) {
            var inputForm = '<div class="col-md-12" ><label class="control-label col-sm-2" for="name"> 最大值 </label> \
                  <div class="col-sm-10"><input class="form-control" type="text" name="max" \
                  value="{{{ Input::old('max', isset($filter) ? preg_replace("/(\d+)\D*(\d+)/", "$2", $filter->value) : null) }}}" /> </div> </div> \
                  <div class="col-md-12" ><label class="control-label col-sm-2" for="name"> 最小值 </label> \
                  <div class="col-sm-10"><input class="form-control" type="text" name="min" \
                  value="{{{ Input::old('min', isset($filter) ? preg_replace("/(\d+)\D*(\d+)/", "$1", $filter->value) : null) }}}" /> </div> </div> ';
        }
        $("#data").html( inputForm );
    }
});
</script>
@endsection
