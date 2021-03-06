@extends('admin.layouts.modal')
@section('content')
	{!! Form::model($filter, array('url' => URL::to('dashboard/filter') . '/' . $filter->id, 'method' => 'delete', 'class' => 'bf', 'files'=> true)) !!}
	<div class="form-group">
			<div class="tab-content">
					<div class="controls">
							請確認是否刪除此類別  {{ $filter->name }}
							<br>
							<br>
							<element class="btn btn-warning btn-sm close_popup">
									<span class="glyphicon glyphicon-ban-circle"></span>
									取消
							</element>
							<button type="submit" class="btn btn-sm btn-danger">
									<span class="glyphicon glyphicon-trash"></span>
									刪除
							</button>
					</div>
			</div>
	</div>
	{!! Form::close() !!}
@stop
