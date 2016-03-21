@extends('layouts.admin')

@section('style')
<link rel="stylesheet" href="{{asset('assets/bootstrap-datepicker/css/bootstrap-datetimepicker.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/bootstrap-timepicker/compiled/timepicker.css')}}">
@stop

{{-- Content --}}

@section('content')
<!-- Tabs -->
@if (!isset($_GET['view']))
<section id="main-content">
    <section class="wrapper">
@endif

<ul class="nav nav-tabs">
            <li class="active">
                <a href="#tab-general" data-toggle="tab">票卷設定 - {{ $act_info->title }}</a>
            </li>
        </ul>

        <form class="form-horizontal" enctype="multipart/form-data"
          	method="post" autocomplete="off" role="form"
          	action="@if(isset($ticket)){{ URL::to('dashboard/activity/' . $id . '/tickets/'.$ticket->id.'/update') }}
        	        @else{{ URL::to('dashboard/activity/'. $id .'/tickets') }}@endif">
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
                                票卷名稱
                            </label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" name="name" id="name"
                      							value="{{{ Input::old('name', isset($ticket) ? $ticket->name : null) }}}" />
                            </div>
                        </div>
            				</div>
                    <div class="form-group {{{ $errors->has('price') ? 'has-error' : '' }}}">
              					<div class="col-md-12">
                						<label class="control-label col-sm-2" for="price">
                                票卷單價
                            </label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <button class="btn btn-white" type="button">$</button>
                                    </span>
                                    <input class="form-control" type="number" name="price"
                                        value="{{{ Input::old('price', isset($ticket) ? $ticket->price : null) }}}" />
                                </div>
                            </div>
                        </div>
            				</div>
                    <div class="form-group {{{ $errors->has('total_numbers') ? 'has-error' : '' }}}">
              					<div class="col-md-12">
                						<label class="control-label col-sm-2" for="total_numbers">
                                票卷張數
                            </label>
                            <div class="col-sm-10">
                                <input class="form-control" type="number" name="total_numbers" id="total_numbers"
                      							value="{{{ Input::old('address', isset($ticket) ? $ticket->total_numbers : null) }}}" />
                            </div>
                        </div>
            				</div>
                    <div class="form-group {{{ $errors->has('event_time') ? 'has-error' : '' }}}">
              					<div class="col-md-12">
                						<label class="control-label col-sm-2" for="event_time">
                                活動時間
                            </label>
                            <div class="col-sm-10">
                                <input class="form-control time-picker ticket-time" type="text" name="event_time" id="event_time"
                      							value="{{{ Input::old('event_time', isset($ticket) ? $ticket->ticket_start . ' - ' . $ticket->ticket_end  : null) }}}" />
                            </div>
                        </div>
            				</div>
                    <div class="form-group {{{ $errors->has('status') ? 'has-error' : '' }}}">
              					<div class="col-md-12">
                						<label class="control-label col-sm-2" for="status">
                                售票狀態
                            </label>
                            <div class="col-sm-10">
                                <select style="width: 100%" name="status" class="form-control">
                                    <option value="1">發售</option>
                                    <option value="2">停售</option>
                                </select>
                            </div>
                        </div>
            				</div>
                    <div class="form-group {{{ $errors->has('sale_time') ? 'has-error' : '' }}}">
              					<div class="col-md-12">
                						<label class="control-label col-sm-2" for="sale_time">
                                售票區間
                            </label>
                            <div class="col-sm-10">
                                <input class="form-control time-picker ticket-time" type="text" name="sale_time" id="sale_time"
                      							value="{{{ Input::old('sale_time', isset($ticket) ? $ticket->sale_start . ' - ' . $ticket->sale_end  : null) }}}" />
                            </div>
                        </div>
            				</div>
                    <div class="form-group {{{ $errors->has('description') ? 'has-error' : '' }}}">
              					<div class="col-md-12">
                						<label class="control-label col-sm-2" for="description">
                                票種說明
                            </label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" name="description" id="description"
                      							value="{{{ Input::old('description', isset($ticket) ? $ticket->description : null) }}}" />
                    						    {!!$errors->first('description', '<label class="control-label">:message</label>')!!}
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
            				<div id="back" class="btn btn-sm btn-warning close_popup" onclick="history.go(-1);">
              					<span class="glyphicon glyphicon-ban-circle"></span>
                        返回
            				</div>
            				<button type="reset" class="btn btn-sm btn-default">
              					<span class="glyphicon glyphicon-remove-circle"></span>
                        重置
            				</button>
            				<button type="submit" class="btn btn-sm btn-success">
              					<span class="glyphicon glyphicon-ok-circle"></span>
              					@if	(isset($ticket))
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

{{-- Scripts --}}
@section('scripts')
    @parent
    <script type="text/javascript" src="{{asset('assets/bootstrap-datepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('input.time-picker').on('focus', picker);
        });

        var maxDate = null;
        function picker() {
            var maxday = null;
            if($(this).attr('name') != "activity_range"){
                maxday = maxDate;
            }
            $(this).daterangepicker({
                timePickerIncrement: 30,
                locale: {
                    format: 'YYYY-MM-DD H:mm:ss'
                },
                minDate: 'today',
                maxDate: maxday
            });
        }
    </script>
@endsection
