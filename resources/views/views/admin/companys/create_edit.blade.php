@extends('admin.layouts.modal') @section('content')
<ul class="nav nav-tabs">
	<li class="active"><a href="#tab-general" data-toggle="tab">{{{
			trans('admin/modal.general') }}}</a></li>
</ul>
<form class="form-horizontal" method="post"
	action="@if (isset($Company)){{ URL::to('admin/Companys/' . $Company->id . '/edit') }}@endif"
	autocomplete="off">
	<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
	<div class="tab-content">
		<div class="tab-pane active" id="tab-general">
			<div class="col-md-12">
				<div class="form-group">
					<label class="col-md-2 control-label" for="company">{{
						trans('admin/Companys.company') }}</label>
					<div class="col-md-10">
						<input class="form-control" tabindex="1"
							placeholder="{{ trans('admin/Companys.company') }}" type="text"
							name="company_name" id="company_name"
							value="{{{ Input::old('company_name', isset($Company) ? $Company->company_name : null) }}}">
					</div>
				</div>
			</div>
            <div class="col-md-12">
                <div class="form-group {{{ $errors->has('contact_name') ? 'has-error' : '' }}}">
                    <label class="col-md-2 control-label" for="contact_name">{{
						trans('admin/Companys.contact_name') }}</label>
                    <div class="col-md-10">
                        <input class="form-control" type="contact_name" tabindex="4"
                               placeholder="{{ trans('admin/Companys.contact_name') }}" name="contact_name"
                               id="contact_name"
                               value="{{{ Input::old('contact_name', isset($Company) ? $Company->contact_name : null) }}}" />
                        {!! $errors->first('contact_name', '<label class="control-label"
                                                            for="contact_name">:message</label>')!!}
                    </div>
                </div>
            </div>
			<div class="col-md-12">
				<div class="form-group {{{ $errors->has('contact_number') ? 'has-error' : '' }}}">
					<label class="col-md-2 control-label" for="contact_number">{{
						trans('admin/Companys.contact_number') }}</label>
					<div class="col-md-10">
						<input class="form-control" type="contact_number" tabindex="4"
							placeholder="{{ trans('admin/Companys.contact_number') }}" name="contact_number"
							id="contact_number"
							value="{{{ Input::old('contact_number', isset($Company) ? $Company->contact_number : null) }}}" />
						{!! $errors->first('contact_number', '<label class="control-label"
							for="contact_number">:message</label>')!!}
					</div>
				</div>
			</div>
            <div class="col-md-12">
				<div class="form-group {{{ $errors->has('contact_email') ? 'has-error' : '' }}}">
					<label class="col-md-2 control-label" for="contact_email">{{
						trans('admin/Companys.contact_email') }}</label>
					<div class="col-md-10">
						<input class="form-control" type="contact_email" tabindex="4"
							placeholder="{{ trans('admin/Companys.contact_email') }}" name="contact_email"
							id="contact_email"
							value="{{{ Input::old('contact_email', isset($Company) ? $Company->contact_email : null) }}}" />
						{!! $errors->first('contact_email', '<label class="control-label"
							for="contact_email">:message</label>')!!}
					</div>
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-">
					<label class="col-md-2 control-label" for="enable">{{
						trans('admin/Companys.activate_company') }}</label>
					<div class="col-md-6">
						<select class="form-control" name="enable" id="enable">
							<option value="1" {{{ ((isset($Company) && $Company->enable == 1)? '
								selected="selected"' : '') }}}>{{{ trans('admin/Companys.yes')
								}}}</option>
							<option value="0" {{{ ((isset($Company) && $Company->enable == 0) ?
								' selected="selected"' : '') }}}>{{{ trans('admin/Companys.no')
								}}}</option>
						</select>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-12">
			<button type="reset" class="btn btn-sm btn-warning close_popup">
				<span class="glyphicon glyphicon-ban-circle"></span> {{
				trans("admin/modal.cancel") }}
			</button>
			<button type="reset" class="btn btn-sm btn-default">
				<span class="glyphicon glyphicon-remove-circle"></span> {{
				trans("admin/modal.reset") }}
			</button>
			<button type="submit" class="btn btn-sm btn-success">
				<span class="glyphicon glyphicon-ok-circle"></span> 
				    @if	(isset($Company))
				        {{ trans("admin/modal.edit") }}
				    @else
				        {{ trans("admin/modal.create") }}
				    @endif
			</button>
		</div>
	</div>
</form>
@stop @section('scripts')
<script type="text/javascript">
	$(function() {
		$("#roles").select2()
	});
</script>
@stop
