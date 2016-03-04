{{-- */
    $layouts = 'layouts.admin';
/* --}}
@extends($layouts)

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
                <a href="#tab-general" data-toggle="tab">文章設定</a>
            </li>
        </ul>

        <form class="form-horizontal" enctype="multipart/form-data"
            method="post" autocomplete="off" role="form"
            action="@if(isset($article)){{ URL::to('dashboard/blog/'.$article->id.'/update') }}
                  @else{{ URL::to('dashboard/blog') }}@endif">
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
                    <div class="col-md-6">
                        <div class="form-group {{{ $errors->has('title') ? 'has-error' : '' }}}">
                            <div class="col-md-12">
                                <label class="control-label col-sm-2 col-md-4" for="title">
                                    文章標題
                                </label>
                                <div class="col-sm-10 col-md-8">
                                    <input class="form-control" type="text" name="title" id="title"
                                        value="{{{ Input::old('title', isset($article) ? $article->title : null) }}}" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group {{{ $errors->has('author_id') ? 'has-error' : '' }}}">
                            <div class="col-md-12">
                                <label class="control-label col-sm-2 col-md-4" for="author_id">
                                    文章作者
                                </label>
                                <div class="col-sm-10 col-md-8">
                                    <select style="width: 100%" name="author_id" id="author_id" class="form-control">
                                    @foreach($authors as $author)
                                        <option value="{{$author->id}}"
                                        @if(!empty($articles))
                                            @if($articles->author_id==$author->id)
                                        selected="selected"
                                            @endif
                                        @endif >{{$author->name}}
                                        </option>
                                    @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group {{{ $errors->has('category_id') ? 'has-error' : '' }}}">
                            <div class="col-md-12">
                                <label class="control-label col-sm-2 col-md-4" for="category_id">
                                    文章分類
                                </label>
                                <div class="col-sm-10 col-md-8">
                                    <select style="width: 100%" name="category_id" id="category_id" class="form-control">
                                      @foreach($categories as $category)
                                        <option value="{{$category->id}}"
                                        @if(!empty($articles))
                                            @if($articles->category_id==$category->id)
                                                selected="selected"
                                            @endif
                                        @endif >{{$category->name}}
                                        </option>
                                      @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group {{{ $errors->has('created_at') ? 'has-error' : '' }}}">
                            <div class="col-md-12">
                                <label class="control-label col-sm-2 col-md-4" for="created_at">
                                    發布時間
                                </label>
                                <div class="col-sm-10 col-md-8">
                                    <input class="form-control" type="text" name="created_at" id="created_at"
                                        value="{{{ Input::old('created_at', isset($article) ? $article->created_at : null) }}}" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group {{{ $errors->has('thumbnail') ? 'has-error' : '' }}}">
                            <div class="col-md-12">
                                <label class="control-label col-sm-2 col-md-4" for="thumbnail">
                                    文章縮圖
                                </label>
                                <div class="col-sm-10 col-md-8">
                                    <div class="fileupload fileupload-new" data-provides="fileupload">
                                        <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                                            <img src="{{{ ( isset($article) && !empty($article->thumbnail) ? asset($article->thumbnail) : asset('img/no-image.png')) }}}" alt="" />
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
                        <div class="form-group {{{ $errors->has('description') ? 'has-error' : '' }}}">
                            <div class="col-md-12">
                                <label class="control-label col-sm-2" for="description">
                                    文章描述
                                </label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="description" id="description"
                                        value="{{{ Input::old('description', isset($article) ? $article->description : null) }}}" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group {{{ $errors->has('tag_ids') ? 'has-error' : '' }}}">
                            <div class="col-md-12">
                                <label class="control-label col-sm-2" for="tag_ids">
                                    文章標籤
                                </label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="tag_ids" id="tag_ids" placeholder="Tag..."
                                        value="{{{ Input::old('tag_ids', isset($article) ? $article->tag_ids : null) }}}"  data-role="tagsinput"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group {{{ $errors->has('content') ? 'has-error' : '' }}}">
                            <div class="col-md-12">
                                <label class="control-label col-sm-2" for="content">
                                    文章內容
                                </label>
                                <div class="col-sm-10">
                                    <textarea class="form-control ckeditor" id="content" name="content" rows="6">{{{ Input::old('content', isset($article) ? $article->content : null) }}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-group {{{ $errors->has('counter') ? 'has-error' : '' }}}">
                            <div class="col-md-12">
                                <label class="control-label col-sm-2" for="counter">
                                    觀賞人數
                                </label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="counter" id="counter"
                                        value="{{{ Input::old('counter', isset($article) ? $article->counter : null) }}}" />
                                        <!-- {!!$errors->first('name', '<label class="control-label">:message</label>')!!} -->
                                </div>
                            </div>
                        </div>
                        <div class="form-group {{{ $errors->has('status') ? 'has-error' : '' }}}">
                            <div class="col-md-12">
                                <label class="control-label col-sm-2" for="status">
                                    文章狀態
                                </label>
                                <div class="radio login-info checkbox col-sm-10">
                                    <label class="col-xs-3">
                                        <input type="radio" name="status" value="1"
                                        {{{ Input::old('status', (isset($article) && $article->status == 1 ) ? 'checked' : 'checked') }}}>
                                        草稿
                                    </label>
                                    <label class="col-xs-3">
                                        <input type="radio" name="status" value="2"
                                        {{{ Input::old('status', (isset($article) && $article->status == 2 ) ? 'checked' : null) }}}>
                                        發佈
                                    </label>
                                    <label class="col-xs-3">
                                        <input type="radio" name="status" value="3"
                                        {{{ Input::old('status', (isset($article) && $article->status == 3 ) ? 'checked' : null) }}}>
                                        隱藏
                                    </label>
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
            $("#created_at").datetimepicker({
                format: 'YYYY-MM-DD HH:mm:ss'
            });
        });
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

        $(document).on("keypress", "form", function(event) {
            return event.keyCode != 13;
        });

        $('form').on('submit', function(){
            CKEDITOR.instances.content.updateElement();
        });
    </script>
@stop
