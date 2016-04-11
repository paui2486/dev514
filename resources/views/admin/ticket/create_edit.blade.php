{{-- */
    $layouts = ( isset($_GET['view'])) ? 'admin.layouts.tabs' : 'layouts.admin';
/* --}}
@extends($layouts)

@section('style')
<link rel="stylesheet" href="{{asset('assets/bootstrap-datepicker/css/bootstrap-datetimepicker.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/bootstrap-timepicker/compiled/timepicker.css')}}">
<link rel="stylesheet" href="{{asset('assets/bootstrap-datepicker/css/bootstrap-datetimepicker.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/bootstrap-timepicker/compiled/timepicker.css')}}">
@stop

{{-- Content --}}

@section('content')

@if(!isset($_GET['view']))
<section id="main-content">
    <section class="wrapper">
        <ul class="nav nav-tabs">
            @foreach( $AdminTabs as $key => $tab )
                <li >
                    <a href="/dashboard/activity#tab-{{ $key }}" >{{ $tab->name }}</a>
                </li>
            @endforeach
            <li class="active">
                <a href="#tab-general" data-toggle="tab">票卷設定 - {{ $act_info->title }}</a>
            </li>
        </ul>
@endif
        <div class="r-tabs-panel r-tabs-state-active">
            <h4 class="wrapper-title">
               票卷設定  @if(isset($act_info)) {{ ' : ' . $act_info->title }} @endif
            </h4>

            <form class="form-horizontal" enctype="multipart/form-data"
              	method="post" autocomplete="off" role="form"
              	action="@if(isset($ticket)){{ URL::to('dashboard/activity/' . $id . '/tickets/'.$ticket->id.'/update') }}
            	        @else{{ URL::to('dashboard/activity/'. $id .'/tickets') }}@endif">
                {!! csrf_field() !!}
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
                                <label class="control-label col-sm-2" for="activity_start">
                                    活動期間
                                </label>
                                <div class="col-sm-10">
                                    <div class="col-md-2 table-cell">
                                        <label class="control-label"> From </label>
                                    </div>
                                    <div class="col-xs-8 col-sm-7 col-md-6">
                                        <input class="form-control act_date" type="text" name="ticket_start_date"
                                            value="{{{ Input::old('ticket_end_time', isset($ticket) ? preg_replace('/(.*)\s(.*):(.*)/', '$1', $ticket->ticket_start ) : null) }}}"/>
                                    </div>
                                    <div class="col-xs-4 col-sm-5 col-md-4">
                                        <input class="form-control act_time" type="text" name="ticket_start_time"
                                            value="{{{ Input::old('ticket_end_time', isset($ticket) ? preg_replace('/(.*)\s(.*):(.*)/', '$2', $ticket->ticket_start ) : null) }}}"/>
                                    </div>
                                    <div class="col-md-2 table-cell">
                                        <label class="control-label"> To </label>
                                    </div>
                                    <div class="col-xs-8 col-sm-7 col-md-6">
                                        <input class="form-control act_date" type="text" name="ticket_end_date"
                                            value="{{{ Input::old('ticket_end_time', isset($ticket) ? preg_replace('/(.*)\s(.*):(.*)/', '$1', $ticket->ticket_end ) : null) }}}"/>
                                    </div>
                                    <div class="col-xs-4 col-sm-5 col-md-4">
                                        <input class="form-control act_time" type="text" name="ticket_end_time"
                                            value="{{{ Input::old('ticket_end_time', isset($ticket) ? preg_replace('/(.*)\s(.*):(.*)/', '$2', $ticket->ticket_end ) : null) }}}"/>
                                    </div>
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
                                    <div class="col-md-2 table-cell">
                                        <label class="control-label"> From </label>
                                    </div>
                                    <div class="col-xs-8 col-sm-7 col-md-6">
                                        <input class="form-control act_date" type="text" name="sale_start_date"
                                            value="{{{ Input::old('sale_start_time', isset($ticket) ? preg_replace('/(.*)\s(.*):(.*)/', '$1', $ticket->sale_start ) : null) }}}"/>
                                    </div>
                                    <div class="col-xs-4 col-sm-5 col-md-4">
                                        <input class="form-control act_time" type="text" name="sale_start_time"
                                            value="{{{ Input::old('sale_start_time', isset($ticket) ? preg_replace('/(.*)\s(.*):(.*)/', '$2', $ticket->sale_start ) : null) }}}"/>
                                    </div>
                                    <div class="col-md-2 table-cell">
                                        <label class="control-label"> To </label>
                                    </div>
                                    <div class="col-xs-8 col-sm-7 col-md-6">
                                        <input class="form-control act_date" type="text" name="sale_end_date"
                                            value="{{{ Input::old('sale_end_time', isset($ticket) ? preg_replace('/(.*)\s(.*):(.*)/', '$1', $ticket->sale_end ) : null) }}}"/>
                                    </div>
                                    <div class="col-xs-4 col-sm-5 col-md-4">
                                        <input class="form-control act_time" type="text" name="sale_end_time"
                                            value="{{{ Input::old('sale_end_time', isset($ticket) ? preg_replace('/(.*)\s(.*):(.*)/', '$2', $ticket->sale_end ) : null) }}}"/>
                                    </div>
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
                    </div>
                </div>
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
            </form>
        </div>
@if(!isset($_GET['view']))
    </section>
</section>
@endif

@stop

{{-- Scripts --}}
@section('scripts')
    @parent
    <script type="text/javascript" src="{{asset('assets/bootstrap-datepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function () {

            var minDate = moment().format("YYYY-MM-DD");
            $(".act_date").datetimepicker({
                minDate: moment(),
                format: 'YYYY-MM-DD',
            });

            $("input[name=ticket_start_date]").on("dp.change", function (e) {
                $('input[name="ticket_end_date"]').data("DateTimePicker").minDate(e.date);
            });

            $("input[name=sale_start_date]").on("dp.change", function (e) {
                $('input[name="sale_end_date"]').data("DateTimePicker").minDate(e.date);
            });

            $(".act_time").val("00:00");
            $(".act_time").datetimepicker({
                minDate: moment({hour: 0, minute: 0}),
                stepping: 10,
                format: 'HH:mm',
            });
        });
    </script>
@endsection
