@extends('admin.layouts.modal')
@section('content')
	{!! Form::model($tickets, array('url' => URL::to('dashboard/activity/' . $tickets->activity_id . '/tickets' ) . '/' . $tickets->id, 'method' => 'delete', 'class' => 'bf', 'files'=> true)) !!}
	<div class="form-group">
			<div class="tab-content">
					<div class="controls">
							請確認是否刪除此票卷  {{ $tickets->name }}
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
