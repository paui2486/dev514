<link rel="stylesheet" href="{{asset('assets/bootstrap-fileupload/bootstrap-fileupload.css')}}" />

<form class="form-horizontal" enctype="multipart/form-data"
    method="post" autocomplete="off" role="form"
    action="{{ Request::url() }}">
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
                <div class="form-group {{{ $errors->has('name') ? 'has-error' : '' }}}">
                    <div class="col-md-12">
                        <label class="control-label col-sm-2" for="name">
                            公司名稱
                        </label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" name="name" id="name" value="" />
                        </div>
                    </div>
                </div>
                <div class="form-group {{{ $errors->has('TaxID') ? 'has-error' : '' }}}">
                    <div class="col-md-12">
                        <label class="control-label col-sm-2" for="TaxID">
                            公司統編
                        </label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" name="TaxID" id="TaxID" value="" />
                        </div>
                    </div>
                </div>
                <div class="form-group {{{ $errors->has('address') ? 'has-error' : '' }}}">
                    <div class="col-md-12">
                        <label class="control-label col-sm-2" for="address">
                            公司地址
                        </label>
                        <div class="col-sm-10">
                            <input class="form-control time-picker" type="text" name="address" id="address" value=""/>
                        </div>
                    </div>
                </div>
                <div class="form-group {{{ $errors->has('phone') ? 'has-error' : '' }}}">
                    <div class="col-md-12">
                        <label class="control-label col-sm-2" for="phone">
                            公司電話
                        </label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" name="phone" id="phone" placeholder="" value="" />
                        </div>
                    </div>
                </div>
                <div class="form-group {{{ $errors->has('contact_name') ? 'has-error' : '' }}}">
                    <div class="col-md-12">
                        <label class="control-label col-sm-2" for="contact_name">
                            連絡人姓名
                        </label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" name="contact_name" id="contact_name" placeholder="" value="{{ Auth::user()->name }}" />
                        </div>
                    </div>
                </div>
                <div class="form-group {{{ $errors->has('contact_phone') ? 'has-error' : '' }}}">
                    <div class="col-md-12">
                        <label class="control-label col-sm-2" for="contact_phone">
                            聯絡人電話
                        </label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" name="contact_phone" id="contact_phone"
                                value="{{ Auth::user()->phone }}" />
                        </div>
                    </div>
                </div>
                <div class="form-group {{{ $errors->has('contact_email') ? 'has-error' : '' }}}">
                    <div class="col-md-12">
                        <label class="control-label col-sm-2" for="contact_email">
                            聯絡人信箱
                        </label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" name="contact_email" id="contact_email" placeholder="" value="{{ Auth::user()->email }}" />
                        </div>
                    </div>
                </div>

                <div class="form-group {{{ $errors->has('ID_path') ? 'has-error' : '' }}}">
                    <div class="col-md-12">
                        <label class="control-label col-sm-2" for="thumbnail">
                            公司行號登記表
                        </label>
                        <div class="col-sm-10">
                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                <div class="fileupload-new thumbnail" style="width: 100%; height: 300px;">
                                    <img src="{{ asset('img/no-image.png') }}" alt="" />
                                </div>
                                <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 100%; max-height: 300px; line-height: 20px;"></div>
                                <div>
                                    <span class="btn btn-white btn-file">
                                        <span class="fileupload-new"><i class="fa fa-paper-clip"></i> 選擇圖片 </span>
                                        <span class="fileupload-exists"><i class="fa fa-undo"></i> 更改 </span>
                                        <input id="ID_path" class="file"  name="ID_path" type="file" value=""/>
                                    </span>
                                    <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash"></i> Remove </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group {{{ $errors->has('Bank_path') ? 'has-error' : '' }}}">
                    <div class="col-md-12">
                        <label class="control-label col-sm-2" for="thumbnail">
                            銀行存摺
                        </label>
                        <div class="col-sm-10">
                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                <div class="fileupload-new thumbnail" style="width: 100%; height: 300px;">
                                    <img src="{{ asset('img/no-image.png') }}" alt="" />
                                </div>
                                <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 100%; max-height: 300px; line-height: 20px;"></div>
                                <div>
                                    <span class="btn btn-white btn-file">
                                        <span class="fileupload-new"><i class="fa fa-paper-clip"></i> 選擇圖片 </span>
                                        <span class="fileupload-exists"><i class="fa fa-undo"></i> 更改 </span>
                                        <input id="Bank_path" class="file"  name="Bank_path" type="file" value=""/>
                                    </span>
                                    <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash"></i> Remove </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            		<div class="form-group">
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

<script type="text/javascript" src="{{asset('assets/bootstrap-fileupload/bootstrap-fileupload.js')}}"></script>
