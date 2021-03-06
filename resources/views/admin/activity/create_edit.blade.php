{{-- */
    $layouts = ( isset($_GET['view'])) ? 'admin.layouts.tabs' : 'layouts.admin';
/* --}}
@extends($layouts)

@section('style')
<link rel="stylesheet" href="{{ asset('css/responsive-tabs.css') }}" />
<link rel="stylesheet" href="{{asset('assets/bootstrap-fileupload/bootstrap-fileupload.css')}}" />
<link rel="stylesheet" href="{{asset('assets/bootstrap-datepicker/css/bootstrap-datetimepicker.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/bootstrap-timepicker/compiled/timepicker.css')}}">
<link rel="stylesheet" href="{{asset('assets/bootstrap-colorpicker/css/colorpicker.css')}}">
<link rel="stylesheet" href="{{asset('assets/jquery-selectize/dist/css/selectize.default.css')}}">
<link rel="stylesheet" href="{{asset('css/bootstrap-tagsinput.css')}}">
<link rel="stylesheet" href="{{asset('css/cropper.min.css')}}">
<style>
.fileupload-exists .fileupload-new,
.fileupload-new .fileupload-exists {
    display: inline !important;
}
</style>
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
                <a href="#tab-general" data-toggle="tab">活動設定 {{{ Input::old('title', isset($activity) ? " - ". $activity->title : null) }}}</a>
            </li>
        </ul>
@endif
        <form class="form-horizontal" enctype="multipart/form-data"
            method="post" autocomplete="off" role="form"
            action="@if(isset($activity)){{ URL::to('dashboard/activity/'.$activity->id.'/update') }}
                  @else{{ URL::to('dashboard/activity') }}@endif">
            {!! csrf_field() !!}
            <div class="tab-content">
                <div class="tab-pane active" id="tab-general">
                    @if (count($errors) > 0)
                      <div class="alert alert-danger">
                          <ul>
                              @foreach ($errors->all() as $error)
                                  <li>{{ $error }}</li>
                              @endforeach
                          </ul>
                      </div>
                    @elseif (Session::has('message'))
                      <div class="alert alert-danger">
                          <ul>
                              <li>{{ Session::get('message') }}</li>
                          </ul>
                      </div>
                    @endif
                    <div class="col-md-12">
                        <div class="form-group {{{ $errors->has('banner') ? 'has-error' : '' }}} ">
                            <div class="col-md-12">
                                <label class="control-label col-sm-2" for="banner">
                                    <p>0</p>活動內頁 Banner
                                </label>
                                <div class="col-sm-10">
                                    <div class="fileupload fileupload-new" data-provides="fileupload">
                                        <div class="img-preview preview-lg" style="max-width: 500px; max-height: 300px;">
                                            <img id="banner" width="100%" src="{{{ ( isset($activity) && !empty($activity->banner) ? asset($activity->banner) : asset('img/no-image.png')) }}}" alt="" />
                                        </div>
                                        <div>
                                            <span class="btn btn-white btn-file">
                                                <span class="fileupload-new"><i class="fa fa-paper-clip"></i> 上傳圖片 </span>
                                                <input class="file input"  name="banner" type="file" accept="image/*"
                                                    value="{{{ Input::old('banner', isset($activity) ? $activity->banner : null) }}}"/>
                                            </span>
                                            <button id="reset_banner" type="button" class="btn btn-primary" data-method="reset" title="Reset" style="display:none;">
                                                <span class="docs-tooltip" data-toggle="tooltip">
                                                    <span class="fa fa-refresh"></span>
                                                </span>
                                            </button>
                                            <span style="color:red;">(建議以人物為主題，尺寸 1,260 x 500 像素)</span>
                                        </div>
                                        <input class="form-control " type="hidden" name="dataX_banner"  id="dataX_banner"  value="" />
                                        <input class="form-control " type="hidden" name="dataY_banner"  id="dataY_banner"  value="" />
                                        <input class="form-control " type="hidden" name="dataH_banner"  id="dataH_banner"  value="" />
                                        <input class="form-control " type="hidden" name="dataW_banner"  id="dataW_banner"  value="" />
                                        <input class="form-control " type="hidden" name="dataR_banner"  id="dataR_banner"  value="" />
                                        <input class="form-control " type="hidden" name="dataSX_banner" id="dataSX_banner" value="" />
                                        <input class="form-control " type="hidden" name="dataSY_banner" id="dataSY_banner" value="" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group {{{ $errors->has('thumbnail') ? 'has-error' : '' }}} ">
                            <div class="col-md-12">
                                <label class="control-label col-sm-2" for="thumbnail">
                                    <p>1</p>活動縮圖
                                </label>
                                <div class="col-sm-10">
                                    <div class="fileupload fileupload-new" data-provides="fileupload">
                                        <div class="img-preview preview-lg" style="max-width: 500px; max-height: 300px;">
                                            <img id="thumbnail" width="100%" src="{{{ ( isset($activity) && !empty($activity->thumbnail) ? asset($activity->thumbnail) : asset('img/no-image.png')) }}}" alt="" />
                                        </div>
                                        <div>
                                            <span class="btn btn-white btn-file">
                                                <span class="fileupload-new"><i class="fa fa-paper-clip"></i> 上傳圖片 </span>
                                                <input class="file input"  name="thumbnail" type="file" accept="image/*"
                                                    value="{{{ Input::old('thumbnail', isset($activity) ? $activity->thumbnail : null) }}}"/>
                                            </span>
                                            <button id="reset_thumbnail" type="button" class="btn btn-primary" data-method="reset" title="Reset" style="display:none;">
                                                <span class="docs-tooltip" data-toggle="tooltip">
                                                    <span class="fa fa-refresh"></span>
                                                </span>
                                            </button>
                                            <span style="color:red;">(建議以人物為主題，尺寸 360 x 240 像素)</span>
                                        </div>
                                        <input class="form-control " type="hidden" name="dataX_thumbnail"  id="dataX_thumbnail"  value="" />
                                        <input class="form-control " type="hidden" name="dataY_thumbnail"  id="dataY_thumbnail"  value="" />
                                        <input class="form-control " type="hidden" name="dataH_thumbnail"  id="dataH_thumbnail"  value="" />
                                        <input class="form-control " type="hidden" name="dataW_thumbnail"  id="dataW_thumbnail"  value="" />
                                        <input class="form-control " type="hidden" name="dataR_thumbnail"  id="dataR_thumbnail"  value="" />
                                        <input class="form-control " type="hidden" name="dataSX_thumbnail" id="dataSX_thumbnail" value="" />
                                        <input class="form-control " type="hidden" name="dataSY_thumbnail" id="dataSY_thumbnail" value="" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group {{{ $errors->has('title') ? 'has-error' : '' }}}">
                            <div class="col-md-12">
                                <label class="control-label col-sm-2" for="title">
                                    <p>2</p>活動名稱
                                </label>
                                <div class="col-sm-10 errorbox">
                                    <input class="form-control " type="text" name="title" id="title" value="{{{ Input::old('title', isset($activity) ? $activity->title : null) }}}" />
                                </div>
                            </div>
                        </div>
                        @if (Auth::user()->adminer)
                        <div class="form-group {{{ $errors->has('hoster_id') ? 'has-error' : '' }}}">
                            <div class="col-md-12">
                                <label class="control-label col-sm-2" for="hoster_id">
                                    <p>3</p>主辦單位
                                </label>
                                <div class="col-sm-10">
                                    <select style="width: 100%" name="hoster_id" id="hoster_id" class="form-control">
                                    @foreach($hosters as $hoster)
                                        <option value="{{$hoster->id}}"
                                        @if(!empty($activity))
                                            @if( $activity->hoster_id == $hoster->id )
                                        selected="selected"
                                            @endif
                                        @endif > {{$hoster->name}}
                                        </option>
                                    @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        @endif
                        <!-- 幹！什麼爛東西 -->
                        @if( Auth::id() === 101 )
                        <div class="form-group {{{ $errors->has('fkul') ? 'has-error' : '' }}}">
                            <div class="col-md-12">
                                <label class="control-label col-sm-2" for="fkul">
                                    <p>*</p>導購網址
                                </label>
                                <div class="col-sm-10 errorbox">
                                    <input class="form-control " type="text" name="fkul" id="fkul" value="{{{ Input::old('fkul', isset($activity) ? $activity->fkul : null) }}}" />
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="form-group {{{ $errors->has('soWhat') ? 'has-error' : '' }}}">
                            <div class="col-md-12">
                                <label class="control-label col-sm-2" for="soWhat">
                                    <p>4</p>活動分類
                                </label>
                                <div class="col-sm-10">
                                    <select style="width: 100%" name="soWhat" class="form-control">
                                    @foreach($slideCategory as $category)
                                        @if($category->type === 1)
                                            <option value="{{$category->id}}"
                                            @if(!empty($activity))
                                                @if($activity->category_id == $category->id)
                                                    selected="selected"
                                                @endif
                                            @endif >{{$category->name}}
                                            </option>
                                        @endif
                                    @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group {{{ $errors->has('activity_range') ? 'has-error' : '' }}}">
                            <div class="col-md-12">
                                <label class="control-label col-sm-2" for="activity_start">
                                    <p>5</p>活動期間
                                </label>
                                <div class="errorbox col-sm-6 col-md-5">
                                    <div class="col-md-2 table-cell">
                                        <label class="control-label">
                                            From
                                        </label>
                                    </div>
                                    <div class="errorbox col-xs-8 col-sm-7 col-md-6">
                                        <input class="form-control act_date" type="text" name="activity_start_date" placeholder="年/月/日" value="{{{ Input::old('activity_end_time', isset($activity) ? preg_replace('/(.*)\s(.*):(.*)/', '$1', $activity->activity_start ) : null) }}}"/>
                                    </div>
                                    <div class="errorbox col-xs-4 col-sm-5 col-md-4">
                                        <input class="form-control act_time" type="text" name="activity_start_time" placeholder="時/分" value="{{{ Input::old('activity_end_time', isset($activity) ? preg_replace('/(.*)\s(.*):(.*)/', '$2', $activity->activity_start ) : null) }}}"/>
                                    </div>
                                    <div class="col-md-2 table-cell" style="margin-top:10px;">
                                        <label class="control-label">
                                            To
                                        </label>
                                    </div>
                                    <div class="errorbox col-xs-8 col-sm-7 col-md-6" style="margin-top:10px;">
                                        <input class="form-control act_date" type="text" name="activity_end_date" placeholder="年/月/日" value="{{{ Input::old('activity_end_time', isset($activity) ? preg_replace('/(.*)\s(.*):(.*)/', '$1', $activity->activity_end ) : null) }}}"/>
                                    </div>
                                    <div class="errorbox col-xs-4 col-sm-5 col-md-4"style="margin-top:10px;">
                                        <input class="form-control act_time" type="text" name="activity_end_time" placeholder="時/分" value="{{{ Input::old('activity_end_time', isset($activity) ? preg_replace('/(.*)\s(.*):(.*)/', '$2', $activity->activity_end ) : null) }}}"/>
                                    </div>
                                </div>
                                <div class="col-sm-4 col-md-5" style="display:none">
                                    <label class="control-label col-sm-4" for="time_range">
                                        活動長度
                                    </label>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <input class="form-control" type="text" name="time_range" id="time_range" placeholder=""
                                                value="{{{ Input::old('time_range', isset($activity) ? $activity->time_range : null) }}}" />
                                            <span class="input-group-addon">小時</span>
                                        </div>
                                    </div>
                                    <div class="col-md-12" style="padding-right: 0;padding-top: 10px;color:#41cac0;">
                                        <p>*若不滿1小時請以小數點呈現（例：1小時30分 = "1.5"小時）</p></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group {{{ $errors->has('withWho') ? 'has-error' : '' }}}" style="display:none">
                            <div class="col-md-12">
                                <label class="control-label col-sm-2" for="withWho">
                                    活動對象
                                </label>
                                <div class="col-sm-10">
                                    <select id="input-who" name="withWho[]" multiple placeholder="對象是...">
                                        @foreach($slideCategory as $category)
                                            @if($category->type === 3)
                                            <option value="{{$category->id}}" @if (isset($categories_data)) @if (in_array($category->id, $categories_data)) selected @endif @endif>
                                                {{$category->name}}
                                            </option>
                                            @endif
                                        @endforeach
                          					</select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group {{{ $errors->has('location') ? 'has-error' : '' }}}">
                            <div class="col-md-12">
                                <label class="control-label col-sm-2" for="goWhere">
                                    <p>6</p>活動地點
                                </label>
                                <div class="col-sm-2">
                                    <select style="width: 100%" name="goWhere" class="form-control">
                                    @foreach($slideCategory as $category)
                                        @if($category->type === 4)
                                        <option value="{{$category->id}}" @if (isset($categories_data)) @if (in_array($category->id, $categories_data)) selected @endif @endif>
                                            {{$category->name}}
                                        </option>
                                        @endif
                                    @endforeach
                                    </select>
                                </div>
                                <div class="errorbox col-sm-8">
                                    <input class="form-control" type="text" name="location" placeholder="請輸入詳細活動地址"
                                        value="{{{ Input::old('location', isset($activity) ? $activity->location : null) }}}" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group {{{ $errors->has('description') ? 'has-error' : '' }}}"  style="display:none">
                            <div class="col-md-12">
                                <label class="control-label col-sm-2" for="description">
                                    <p>9</p>活動摘要
                                </label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="description" id="description" placeholder="為活動顯示使用，請簡單描述一下您的活動吧！" value="{{{ Input::old('description', isset($activity) ? $activity->description : null) }}}" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group {{{ $errors->has('ticket_description') ? 'has-error' : '' }}}">
                            <div class="col-md-12">
                                <label class="control-label col-sm-2" for="ticket_description">
                                    <p>7</p>購票說明
                                </label>
                                <div class="col-sm-10">
                                    <textarea class="form-control ckeditor" id="ticket_description" name="ticket_description" rows="6">{{{ Input::old('ticket_description', isset($activity) ? $activity->ticket_description : null) }}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-group {{{ $errors->has('tag_ids') ? 'has-error' : '' }}}">
                            <div class="col-md-12">
                                <label class="control-label col-sm-2" for="tag_ids">
                                    <p>8</p>活動標籤
                                </label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="tag_ids" id="tag_ids" placeholder="輸入後按Enter，或使用小寫逗號區隔"
                                        value="{{{ Input::old('tag_ids', isset($activity) ? $activity->tag_ids : null) }}}"  data-role="tagsinput"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group {{{ $errors->has('content') ? 'has-error' : '' }}}">
                            <div class="col-md-12">
                                <label class="control-label col-sm-2" for="content">
                                    <p>9</p>活動內容<br><span>（建議以人物故事為描述主題）</span>
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
                                    觀賞人數 (PageView)
                                </label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="counter" id="counter"
                                        value="{{{ Input::old('counter', isset($activity) ? $activity->counter : null) }}}"/>
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="form-group {{{ $errors->has('status') ? 'has-error' : '' }}}">
                            <div class="col-md-12">
                                <label class="control-label col-sm-2" for="status">
                                    <p>10</p>活動狀態
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
                                        隱藏
                                    </label>
                                    <label class="col-xs-3">
                                        <input type="radio" name="status" value="3"
                                        {{{ Input::old('status', (isset($activity) && $activity->status == 3 ) ? 'checked' : null) }}}>
                                        送審
                                    </label>
                                    @if (Auth::user()->adminer )
                                    <label class="col-xs-3">
                                        <input type="radio" name="status" value="4"
                                        {{{ Input::old('status', (isset($activity) && $activity->status == 4 ) ? 'checked' : null) }}}>
                                        發佈
                                    </label>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @if ( Request::segment(3) == "create" )
                        <div class="form-group {{{ $errors->has('tickets') ? 'has-error' : '' }}}">
                            <div class="col-sm-12 ticket_area">
                                <div id="ticket1" class="form-ticket">
                                    <div class="row">
                                        <label class="control-label col-sm-2" for="ticket_name"><p>11</p>票券名稱</label>
                                        <div class="errorbox col-sm-2">
                                            <input class="form-control" placeholder="例：早鳥票" type="text" name="ticket[0][name]"/>
                                        </div>
                                        <label class="control-label col-sm-2" for="ticket_price"><p>12</p>票券單價</label>
                                        <div class="col-sm-4">
                                            <div class="input-group">
                                              <span class="input-group-btn">
                                                  <button class="btn btn-white" type="button">$</button>
                                              </span>
                                              <input class="form-control" type="number" name="ticket[0][price]" min="0"/>
                                            </div>
                                        </div>
                                        <div class="col-sm-2 t-function">
                                            <button type="button" class="btn btn-shadow btn-info btn-xs btn-clone">新增其他票券</button>
                                            <button type="button" class="btn btn-shadow btn-danger btn-xs btn-del">刪除</button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="control-label col-sm-2" for="ticket_numbers"><p>13</p>票券張數</label>
                                        <div class="col-sm-2">
                                            <input class="form-control" type="number" name="ticket[0][numbers]" min="0"/>
                                        </div>
                                        <label class="control-label col-sm-2" for="ticket_time"><p>14</p>票券使用時間</label>
                                        <div class="col-sm-6">
                                            <div class="col-xs-2 table-cell">
                                                <label class="control-label">
                                                    From
                                                </label>
                                            </div>
                                            <div class="col-xs-6">
                                                <input class="form-control act_date act_start_date ticket_date" type="text" placeholder="年/月/日" name="ticket[0][ticket_start_date]"/>
                                            </div>
                                            <div class="col-xs-4">
                                                <input id="ticket_start_time" class="form-control act_time act_start_time ticket_time" type="text" placeholder="時/分" name="ticket[0][ticket_start_time]"/>
                                            </div>
                                            <div class="col-xs-2 table-cell">
                                                <label class="control-label">
                                                    To
                                                </label>
                                            </div>
                                            <div class="col-xs-6">
                                                <input class="form-control act_date act_end_date ticket_date" type="text" placeholder="年/月/日" name="ticket[0][ticket_end_date]"/>
                                            </div>
                                            <div class="col-xs-4">
                                                <input id="ticket_end_time" class="form-control act_time act_end_time ticket_time" type="text" placeholder="時/分" name="ticket[0][ticket_end_time]"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="control-label col-sm-2" for="ticket_time"><p>15</p>售票狀態</label>
                                        <div class="col-sm-2">
                                            <select style="width: 100%" name="ticket[0][ticket_status]" class="form-control">
                                                <option value="1">發售</option>
                                                <option value="2">停售</option>
                                            </select>
                                        </div>
                                        <label class="control-label col-sm-2" for="ticket_time"><p>16</p>售票區間</label>
                                        <div class="col-sm-6">
                                            <div class="col-xs-2">
                                                <label class="control-label">
                                                    From
                                                </label>
                                            </div>
                                            <div class="col-xs-6">
                                                <input class="form-control act_date sale_start_date ticket_date" type="text" placeholder="年/月/日" name="ticket[0][sale_start_date]"/>
                                            </div>
                                            <div class="col-xs-4">
                                                <input id="sale_start_time" class="form-control act_time sale_start_time ticket_time" type="text" placeholder="時/分" name="ticket[0][sale_start_time]"/>
                                            </div>
                                            <div class="col-xs-2">
                                                <label class="control-label">
                                                    To
                                                </label>
                                            </div>
                                            <div class="col-xs-6">
                                                <input class="form-control act_date sale_end_date ticket_date" type="text" placeholder="年/月/日" name="ticket[0][sale_end_date]"/>
                                            </div>
                                            <div class="col-xs-4">
                                                <input id="sale_end_time" class="form-control act_time sale_end_time ticket_time" type="text" placeholder="時/分" name="ticket[0][sale_end_time]"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="control-label col-sm-2" for="ticket_description"><p>17</p>票種說明</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" name="ticket[0][description]"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    		<div class="form-group">
                            <!-- 請閱讀建立活動及販售票券同意書＊  我已閱讀且同意 建立活動及販售票券同意書 。 -->
                      			<div class="col-md-12">
                        				<div type="reset" class="btn btn-sm btn-warning close_popup" onclick="history.go(-1);">
                          					<span class="glyphicon glyphicon-ban-circle"></span>
                                    取消
                        				</div>
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
            </div>
        </form>
@if(!isset($_GET['view']))
    </section>
</section>
@endif

@stop

{{-- Scripts --}}
@section('scripts')
    @parent
<script type="text/javascript" src="{{ asset('js/jquery.validate.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/additional-methods.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery.responsiveTabs.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/bootstrap-datepicker/js/bootstrap-datetimepicker.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/bootstrap-fileupload/bootstrap-fileupload.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/bootstrap-tagsinput.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/jquery-selectize/dist/js/standalone/selectize.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/ckeditor/ckeditor.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/ckfinder/ckfinder.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/cropper.min.js') }}"></script>
<!-- <script type="text/javascript" src="{{ asset('js/jquery.mu.image.resize.js') }}"></script> -->
<script type="text/javascript">
    $(document).ready(function () {
        var $inputImage = $('.input');
        var URL = window.URL || window.webkitURL;
        var blobURL;

        $('[data-toggle="tooltip"]').tooltip();

        if (URL) {
            $inputImage.change(function () {
                var file;
                var $ratio;
                var files   = this.files;
                var $name   = $(this).attr('name');
                var $image  = $('#'.concat($name));
                var $reset  = $('#reset_'.concat($name));
                var $dataX  = $('#dataX_'.concat($name));
                var $dataY  = $('#dataY_'.concat($name));
                var $dataHeight = $('#dataH_'.concat($name));
                var $dataWidth  = $('#dataW_'.concat($name));
                var $dataRotate = $('#dataR_'.concat($name));
                var $dataScaleX = $('#dataSX_'.concat($name));
                var $dataScaleY = $('#dataSY_'.concat($name));

                $reset.show();
                $reset.click(function () {
                    $image.cropper('reset');
                });

                if ( $name == 'thumbnail' ) {
                    $ratio = 6 / 4 ;
                } else {
                    $ratio = 5 / 2 ;
                }

                $image.cropper({
                    aspectRatio: $ratio,
                    crop: function(e) {
                        $dataX.val(Math.round(e.x));
                        $dataY.val(Math.round(e.y));
                        $dataHeight.val(Math.round(e.height));
                        $dataWidth.val(Math.round(e.width));
                        $dataRotate.val(e.rotate);
                        $dataScaleX.val(e.scaleX);
                        $dataScaleY.val(e.scaleY);
                    }
                });

                if (!$image.data('cropper')) {
                    return;
                }

                if (files && files.length) {
                    file = files[0];
                    if (/^image\/\w+$/.test(file.type)) {
                        blobURL = URL.createObjectURL(file);
                        $image.one('built.cropper', function () {
                            // Revoke when load complete
                            URL.revokeObjectURL(blobURL);
                        }).cropper('reset').cropper('replace', blobURL);
                        // $inputImage.val('');
                    } else {
                        window.alert('Please choose an image file.');
                    }
                }
            });
        } else {
            $inputImage.prop('disabled', true).parent().addClass('disabled');
        }

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

        var description = CKEDITOR.replace( 'ticket_description', {
            language : 'zh',
            height : 100,
            autosave_SaveKey: 'autosaveKey',
            autosave_NotOlderThen : 10,
            filebrowserBrowseUrl : '/assets/ckfinder/ckfinder.html',
            filebrowserImageBrowseUrl : '/assets/ckfinder/ckfinder.html?Type=Images',
            filebrowserUploadUrl : '/assets/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
            filebrowserImageUploadUrl : '/assets/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
            toolbar: [
                ['Styles', 'Format', 'Font', 'FontSize'],
                ['TextColor', 'BGColor']
            ],
            uiColor : '#9AB8F3'
        });

        var editor = CKEDITOR.replace( 'content', {
            language : 'zh',
            uiColor : '#9AB8F3',
            height : 500,
            allowedContent : true,
            extraPlugins: 'autosave',
            autosave_SaveKey: 'autosaveKey',
            autosave_NotOlderThen : 10,
            // filebrowserBrowseUrl : '/assets/ckfinder/ckfinder.html',
            // filebrowserImageBrowseUrl : '/assets/ckfinder/ckfinder.html?Type=Images',
            filebrowserUploadUrl : '/assets/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
            filebrowserImageUploadUrl : '/assets/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',

            removeButtons : 'BidiLtr,BidiRtl,Anchor,Maximize,Styles,Paste,PasteText,PasteFromWord,Cut,Copy,Source,Save,NewPage,DocProps,Print,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,Blockquote,CreateDiv,Language,Flash,Iframe,',

            font_names : 'Arial;Arial Black;Comic Sans MS;Courier New;Tahoma;Times New Roman;Verdana;新細明體;細明體;標楷體;微軟正黑體',
            fontSize_sizes : '8/8px;9/9px;10/10px;11/11px;12/12px;13/13px;14/14px;15/15px;16/16px;17/17px;18/18px;19/19px;20/20px;21/21px;22/22px;23/23px;24/24px;25/25px;26/26px;28/28px;36/36px;48/48px;72/72px'
        });

        var maxDate = null;
        var minDate = moment().format("YYYY-MM-DD");

        $(".act_date").datetimepicker({
            format: 'YYYY-MM-DD',
            startDate: $(this).value,
        });

        $(".act_time").datetimepicker({
            stepping: 10,
            format: 'HH:mm',
            startDate: $(this).value,
        });

        $("input[name=activity_start_date]").on("dp.change", function (e) {
            $('input.act_start_date').data("DateTimePicker").minDate(e.date);
            $('input[name="activity_end_date"]').data("DateTimePicker").minDate(e.date);
        });


        $("input[name=activity_end_date]").on("dp.change", function (e) {
            $('input.act_start_date').data("DateTimePicker").maxDate(e.date);
            $('input.act_end_date').data("DateTimePicker").maxDate(e.date);
            $('input.sale_start_date').data("DateTimePicker").maxDate(e.date);
            $('input.sale_end_date').data("DateTimePicker").maxDate(e.date);
        });

        // $("input[name='activity_end_time']").on("dp.change", function (e) {
        //     $('input.act_end_time').data('DateTimePicker').minDate(e.date);
        //     $('input.sale_end_time').data('DateTimePicker').minDate(e.date);
        //     var start_time_arr = $("input[name='activity_start_time']").val().split(':');
        //     var end_time_arr   = $("input[name='activity_end_time']").val().split(':');
        //     var timecost       = Math.floor(end_time_arr[0]) - Math.floor(start_time_arr[0]) +
        //                             Math.round((Math.floor(end_time_arr[1]) - Math.floor(start_time_arr[1])) / 60 * 10) / 10;
        //     $('input[name="time_range"]').val(timecost);
        // });
        //
        // if ($("input[name='activity_start_date']").val() == $("input[name=activity_end_date]").val()) {
            // $("input[name='activity_start_time']").on("dp.change", function (e) {
            //     $('input[name="activity_end_time"]').data("DateTimePicker").minDate(e.date);
            //     $('input.act_start_time').data('DateTimePicker').date(e.date);
            //     $('input.sale_start_time').data('DateTimePicker').date(e.date);
            // });
        // }

        // $('input.time-picker').on('focus', picker);
        $("button.btn-clone").on('click', clone);
        $("button.btn-del").on('click', remove);

        $('#input-who').selectize({
            maxItems: 5,
            create: false,
        });

        $(document).on("keypress", "form", function(event) {
            return event.keyCode != 13;
        });

        $('form').on('submit', function() {
            CKEDITOR.instances.content.updateElement();
        });

        $(".form-horizontal").validate( {
            rules: {
                  title: {
                    required: true,
                  },
                  activity_start_date: {
                      required: true,
                  },
                  activity_end_date: {
                      required: true,
                  },
                  activity_start_time: {
                      required: true,
                  },
                  activity_end_time: {
                      required: true,
                  },
                  location:{
                      required:true,
                  },
              },
              messages: {
                  title: {
                      required: "*請填寫活動名稱",
                  },
                  activity_start_date:"*請選取日期",
                  activity_end_date:"*請選取日期",
                  activity_start_time:"*請選取日期",
                  activity_end_time:"*請選取日期",
                  location:"*請填寫活動詳細地址",
              },
              errorElement: "em",
              errorPlacement: function ( error, element ) {
            // Add the `help-block` class to the error element
              error.addClass( "help-block" );

              if ( element.prop( "type" ) === "checkbox" ) {
                  error.insertAfter( element.parent( "label" ) );
              } else {
                  error.insertAfter( element );
              }
          },
          highlight: function ( element, errorClass, validClass ) {
              $( element ).parents( ".errorbox" ).addClass( "has-error" ).removeClass( "has-success" );
          },
          unhighlight: function (element, errorClass, validClass) {
              $( element ).parents( ".errorbox" ).addClass( "has-success" ).removeClass( "has-error" );
          }
        } );
    });

    function clone() {
        var regex = /\[(\d*)/i;
        var id_next = $(".form-ticket").length;
        $(this).parents(".form-ticket").clone()
            .appendTo(".ticket_area")
            .attr("id", "ticket" + (id_next + 1) )
            .find("*")
            .each(function() {
                var name = $(this).attr('name');
                if (typeof name !== "undefined") {
                    var cg_name = name.replace(regex, '[' + id_next);
                    $(this).attr('name', cg_name);
                }
            })
            // .on('focus', 'input.time-picker', picker)
            .on('focus', 'input.act_date', pickerDate)
            .on('focus', 'input.act_time', pickerTime)
            .on('click', 'button.btn-clone', clone)
            .on('click', 'button.btn-del', remove);
    }

    function pickerDate() {
        $(this).datetimepicker({
            minDate: moment(),
            maxDate: $('input[name="activity_end_date"]').val(),
            format: 'YYYY-MM-DD',
        });
    }

    function pickerTime() {
        $(this).datetimepicker({
            minDate: moment({hour: 0, minute: 0}),
            stepping: 10,
            format: 'HH:mm',
        });
    }

    function picker() {
        var maxday = false;
        if ($(this).attr('name') != "activity_range") {
            maxday = maxDate;
        }

        $(this).daterangepicker({
            timePicker: true,
            timePickerIncrement: 30,
            locale: {
                format: 'YYYY-MM-DD H:mm',
                separator: '   -   '
            },
            minDate: 'today',
            maxDate: maxday
        });
    }

    function remove() {
        var count = $(".form-ticket").length;
        if (count === 1){
            alert("只剩下一張票券！請勿刪除！！感謝");
        } else {
            $(this).parents(".form-ticket").remove();
        }
    }
</script>
@stop
