@extends('layouts.admin')

@section('style')
<link rel="stylesheet" href="{{asset('assets/bootstrap-fileupload/bootstrap-fileupload.css')}}" />
<link rel="stylesheet" href="{{asset('assets/bootstrap-datepicker/css/bootstrap-datetimepicker.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/bootstrap-timepicker/compiled/timepicker.css')}}">
<link rel="stylesheet" href="{{asset('assets/bootstrap-colorpicker/css/colorpicker.css')}}">
<link rel="stylesheet" href="{{asset('css/bootstrap-tagsinput.css')}}">
@stop

{{-- Content --}}

@section('content')
<!-- Tabs -->
<section id="main-content">
    <section class="wrapper">
        <ul class="nav nav-tabs">
            <li class="active">
                <a href="#tab-general" data-toggle="tab">活動設定</a>
            </li>
        </ul>

        <form class="form-horizontal" enctype="multipart/form-data"
            method="post" autocomplete="off" role="form"
            action="@if(isset($activity)){{ URL::to('dashboard/activity/'.$activity->id.'/update') }}
                  @else{{ URL::to('dashboard/activity') }}@endif">
            {!! csrf_field() !!}
            <!-- CSRF Token -->
            <!-- <input type="hidden" name="_token" value="{{{ csrf_token() }}}" /> -->
            <!-- ./ csrf token -->
            <!-- Tabs Content -->
            <div class="tab-content">
                <!-- General tab -->
                <div class="tab-pane active" id="tab-general">
                      @if (count($errors) > 0)
                      <div class="alert alert-danger">
                          <ul>
                              @foreach ($errors->all() as $error)
                                  <li>{{ $error }}</li>
                              @endforeach
                          </ul>
                      </div>
                    @endif
                    <div class="col-md-8">
                        <div class="form-group {{{ $errors->has('title') ? 'has-error' : '' }}}">
                            <div class="col-md-12">
                                <label class="control-label col-sm-2 col-md-3" for="title">
                                    活動名稱
                                </label>
                                <div class="col-sm-10 col-md-9">
                                    <input class="form-control" type="text" name="title" id="title"
                                        value="{{{ Input::old('title', isset($activity) ? $activity->title : null) }}}" />
                                </div>
                            </div>
                        </div>
                        @if (Auth::user()->adminer)
                        <div class="form-group {{{ $errors->has('host_id') ? 'has-error' : '' }}}">
                            <div class="col-md-12">
                                <label class="control-label col-sm-2 col-md-3" for="host_id">
                                    活動主辦
                                </label>
                                <div class="col-sm-10 col-md-9">
                                    <select style="width: 100%" name="host_id" id="host_id" class="form-control">
                                    @foreach($hosters as $hoster)
                                        <option value="{{$hoster->id}}"
                                        @if(!empty($activitys))
                                            @if($activitys->host_id==$hoster->id)
                                        selected="selected"
                                            @endif
                                        @endif >{{$hoster->name}}
                                        </option>
                                    @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="form-group {{{ $errors->has('category_id') ? 'has-error' : '' }}}">
                            <div class="col-md-12">
                                <label class="control-label col-sm-2 col-md-3" for="category_id">
                                    活動分類
                                </label>
                                <div class="col-sm-10 col-md-9">
                                    <select style="width: 100%" name="category_id" id="category_id" class="form-control">
                                      @foreach($categories as $category)
                                        <option value="{{$category->id}}"
                                        @if(!empty($activitys))
                                            @if($activitys->category_id==$category->id)
                                                selected="selected"
                                            @endif
                                        @endif >{{$category->name}}
                                        </option>
                                      @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group {{{ $errors->has('activity_range') ? 'has-error' : '' }}}">
                            <div class="col-md-12">
                                <label class="control-label col-sm-2 col-md-3" for="activity_range">
                                    活動時間
                                </label>
                                <div class="col-sm-10 col-md-9">
                                    <input class="form-control time-picker" type="text" name="activity_range" id="activity_range"
                                        value="{{{ Input::old('activity_range', isset($activity) ? $activity->activity_start . " - " . $activity->activity_end : date("Y-m-d 00:00:00") . " - " . date("Y-m-d 00:00:00") ) }}}" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group {{{ $errors->has('thumbnail') ? 'has-error' : '' }}}">
                            <div class="col-md-12">
                                <label class="control-label col-sm-2 col-md-3" for="thumbnail">
                                    活動縮圖
                                </label>
                                <div class="col-sm-10 col-md-9">
                                    <div class="fileupload fileupload-new" data-provides="fileupload">
                                        <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                                            <img src="{{{ ( isset($activity) && !empty($activity->thumbnail) ? asset($activity->thumbnail) : asset('img/no-image.png')) }}}" alt="" />
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
                    </div>
                    <div class="col-md-12">
                        <div class="form-group {{{ $errors->has('location') ? 'has-error' : '' }}}">
                            <div class="col-md-12">
                                <label class="control-label col-sm-2" for="location">
                                    活動地點
                                </label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="location" id="location" placeholder=""
                                        value="{{{ Input::old('description', isset($activity) ? $activity->location : null) }}}" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group {{{ $errors->has('description') ? 'has-error' : '' }}}">
                            <div class="col-md-12">
                                <label class="control-label col-sm-2" for="description">
                                    活動描述
                                </label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="description" id="description"
                                        value="{{{ Input::old('description', isset($activity) ? $activity->description : null) }}}" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group {{{ $errors->has('tag_ids') ? 'has-error' : '' }}}">
                            <div class="col-md-12">
                                <label class="control-label col-sm-2" for="tag_ids">
                                    活動標籤
                                </label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="tag_ids" id="tag_ids" placeholder="Tag..."
                                        value="{{{ Input::old('tag_ids', isset($activity) ? $activity->tag_ids : null) }}}"  data-role="tagsinput"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group {{{ $errors->has('content') ? 'has-error' : '' }}}">
                            <div class="col-md-12">
                                <label class="control-label col-sm-2" for="content">
                                    活動內容
                                </label>
                                <div class="col-sm-10">
                                    <textarea class="form-control ckeditor" id="content" name="content" rows="6">{{{ Input::old('content', isset($activity) ? $activity->content : null) }}}</textarea>
                                </div>
                            </div>
                        </div>
                        @if (Auth::user()->adminer)
                        <div class="form-group {{{ $errors->has('counter') ? 'has-error' : '' }}}">
                            <div class="col-md-12">
                                <label class="control-label col-sm-2" for="counter">
                                    觀賞人數
                                </label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="counter" id="counter"
                                        value="{{{ Input::old('counter', isset($activity) ? $activity->counter : null) }}}" />
                                        <!-- {!!$errors->first('name', '<label class="control-label">:message</label>')!!} -->
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="form-group {{{ $errors->has('status') ? 'has-error' : '' }}}">
                            <div class="col-md-12">
                                <label class="control-label col-sm-2" for="status">
                                    活動狀態
                                </label>
                                <div class="radio login-info checkbox col-sm-10">
                                    <label class="col-xs-3">
                                        <input type="radio" name="status" value="1"
                                        {{{ Input::old('status', (isset($activity) && $activity->status == 1 ) ? 'checked' : 'checked') }}}>
                                        草稿
                                    </label>
                                    <label class="col-xs-3">
                                        <input type="radio" name="status" value="2"
                                        {{{ Input::old('status', (isset($activity) && $activity->status == 2 ) ? 'checked' : null) }}}>
                                        發佈
                                    </label>
                                    <label class="col-xs-3">
                                        <input type="radio" name="status" value="3"
                                        {{{ Input::old('status', (isset($activity) && $activity->status == 3 ) ? 'checked' : null) }}}>
                                        隱藏
                                    </label>
                                </div>
                            </div>
                        </div>
                        @if ( Request::segment(3) == "create" )
                        <div class="form-group {{{ $errors->has('tickets') ? 'has-error' : '' }}}">
                            <div class="col-sm-12 ticket-area">
                                <div id="ticket1" class="form-ticket">
                                    <div class="row">
                                        <label class="control-label col-sm-2" for="ticket-name">票卷名稱</label>
                                        <div class="col-sm-2">
                                            <input class="form-control" type="text" name="ticket[0][name]"/>
                                        </div>
                                        <label class="control-label col-sm-1" for="ticket-price">單價</label>
                                        <div class="col-sm-2">
                                            <div class="input-group">
                                              <span class="input-group-btn">
                                                  <button class="btn btn-white" type="button">$</button>
                                              </span>
                                              <input class="form-control" type="number" name="ticket[0][price]"/>
                                            </div>
                                        </div>
                                        <label class="control-label col-sm-1" for="ticket-count">張數</label>
                                        <div class="col-sm-2">
                                            <input class="form-control" type="number" name="ticket[0][numbers]"/>
                                        </div>
                                        <div class="col-sm-2 t-function">
                                            <button type="button" class="btn btn-shadow btn-info btn-xs btn-clone">複製</button>
                                            <button type="button" class="btn btn-shadow btn-danger btn-xs btn-del">刪除</button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="control-label col-sm-2" for="ticket-time">售票狀態</label>
                                        <div class="col-sm-2">
                                            <select style="width: 100%" name="ticket[0][status]" class="form-control">
                                                <option value="1">發售</option>
                                                <option value="2">停售</option>
                                            </select>
                                        </div>
                                        <label class="control-label col-sm-2" for="ticket-time">售票期間</label>
                                        <div class="col-sm-6">
                                            <input class="form-control time-picker ticket-time" type="text" name="ticket[0][time]"/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="control-label col-sm-2" for="ticket-description">票種說明</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" name="ticket[0][description]"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="form-group">
                  					<div class="col-md-12">
                                {{ Form::hidden('position', '1') }}
                            </div>
                        </div>
                    		<div class="form-group">
                            請閱讀建立活動及販售票券同意書＊  我已閱讀且同意 建立活動及販售票券同意書 。
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
                </div>
            <!-- ./ general tab -->
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
    <script type="text/javascript" src="{{asset('assets/bootstrap-fileupload/bootstrap-fileupload.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/bootstrap-tagsinput.min.js')}}"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            CKFinder.setupCKEditor();

            var editor = CKEDITOR.replace( 'content', {
                language : 'zh',
                height : 500,
                allowedContent : true,
                extraPlugins: 'autosave',
                autosave_SaveKey: 'autosaveKey',
                autosave_NotOlderThen : 10,
                filebrowserBrowseUrl : '/assets/ckfinder/ckfinder.html',
                filebrowserImageBrowseUrl : '/assets/ckfinder/ckfinder.html?Type=Image',
                filebrowserUploadUrl : '/assets/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
                filebrowserImageUploadUrl : '/assets/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Image',

                removeButtons : 'BidiLtr,BidiRtl,Anchor,Maximize,Styles,Paste,PasteText,PasteFromWord,Cut,Copy,Source,Save,NewPage,DocProps,Print,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,Blockquote,CreateDiv,Language,Flash,Iframe,',

                font_names : 'Arial;Arial Black;Comic Sans MS;Courier New;Tahoma;Times New Roman;Verdana;新細明體;細明體;標楷體;微軟正黑體',
                fontSize_sizes : '8/8px;9/9px;10/10px;11/11px;12/12px;13/13px;14/14px;15/15px;16/16px;17/17px;18/18px;19/19px;20/20px;21/21px;22/22px;23/23px;24/24px;25/25px;26/26px;28/28px;36/36px;48/48px;72/72px'
            });

            $('input.time-picker').on('focus', picker);
            $("button.btn-clone").on('click', clone);
            $("button.btn-del").on('click', remove);

            $.fn.modal.Constructor.prototype.enforceFocus = function() {
                modal_this = this
                $(document).on('focusin.modal', function (e) {
                    if (modal_this.$element[0] !== e.target && !modal_this.$element.has(e.target).length
                    && !$(e.target.parentNode).hasClass('cke_dialog_ui_input_select')
                    && !$(e.target.parentNode).hasClass('cke_dialog_ui_input_text')) {
                        modal_this.$element.focus()
                    }
                })
            };

            $("#activity_range").change(function() {
                date = $(this).attr("value");
                maxDate = date.match(/-\s(.*)/i)[1];
            })

            $(document).on("keypress", "form", function(event) {
                return event.keyCode != 13;
            });

            $('form').on('submit', function() {
                CKEDITOR.instances.content.updateElement();
            });
        });

        function clone() {
            var regex = /\[(\d*)/i;
            var id_next = $(".form-ticket").length;
            $(this).parents(".form-ticket").clone()
                .appendTo(".ticket-area")
                .attr("id", "ticket" + (id_next + 1) )
                .find("*")
                .each(function() {
                    var name = $(this).attr('name');
                    if (typeof name !== "undefined") {
                        var cg_name = name.replace(regex, '[' + id_next);
                        $(this).attr('name', cg_name);
                    }
                })
                .on('focus', 'input.time-picker', picker)
                .on('click', 'button.btn-clone', clone)
                .on('click', 'button.btn-del', remove);
        }

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

        function remove() {
            var count = $(".form-ticket").length;
            if (count === 1){
                alert("只剩下一張票卷！請勿刪除！！感謝");
            } else {
                $(this).parents(".form-ticket").remove();
            }
        }


    </script>
@stop