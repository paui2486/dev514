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
                 <div class="form-group {{{ $errors->has('contact_name') ? 'has-error' : '' }}}">
                    <div class="col-md-12">
                        <label class="control-label col-sm-3" for="contact_name">
                           <span>*</span> 聯絡人姓名
                        </label>
                        <div class="col-sm-9">
                            <input class="form-control" type="text" name="contact_name" id="contact_name" placeholder="" value="{{ Auth::user()->name }}" />
                        </div>
                    </div>
                </div>
                <div class="form-group {{{ $errors->has('contact_phone') ? 'has-error' : '' }}}">
                    <div class="col-md-12">
                        <label class="control-label col-sm-3" for="contact_phone">
                            <span>*</span> 聯絡人電話
                        </label>
                        <div class="col-sm-9">
                            <input placeholder="請輸入聯絡人手機號碼" class="form-control" type="text" name="contact_phone" id="contact_phone"
                                value="{{ Auth::user()->phone }}" />
                        </div>
                    </div>
                </div>
                <div class="form-group {{{ $errors->has('contact_email') ? 'has-error' : '' }}}">
                    <div class="col-md-12">
                        <label class="control-label col-sm-3" for="contact_email">
                            <span>*</span> 聯絡人信箱
                        </label>
                        <div class="col-sm-9">
                            <input class="form-control" type="text" name="contact_email" id="contact_email" placeholder="" value="{{ Auth::user()->email }}" />
                        </div>
                    </div>
                </div>
                <div class="form-group {{{ $errors->has('CompanyName') ? 'has-error' : '' }}}">
                    <div class="col-md-12">
                        <label class="control-label col-sm-3" for="CompanyName">
                            <span>*</span> 公司名稱
                        </label>
                        <div class="col-sm-9">
                            <input placeholder="請輸入公司全名" class="form-control" type="text" name="CompanyName" id="CompanyName" value="" />
                        </div>
                    </div>
                </div>
                <div class="form-group {{{ $errors->has('TaxID') ? 'has-error' : '' }}}">
                    <div class="col-md-12">
                        <label class="control-label col-sm-3" for="TaxID">
                            公司統編/身分證字號
                        </label>
                        <div class="col-sm-9">
                            <input class="form-control" type="text" name="TaxID" id="TaxID" value="" placeholder="請輸入公司統一編號 或 聯絡人身分證字號" />
                        </div>
                    </div>
                </div>
                <div class="form-group {{{ $errors->has('address') ? 'has-error' : '' }}}">
                    <div class="col-md-12">
                        <label class="control-label col-sm-3" for="address">
                            公司地址
                        </label>
                        <div class="col-sm-9">
                            <input class="form-control time-picker" type="text" name="address" id="address" value=""/>
                        </div>
                    </div>
                </div>
                <div class="form-group {{{ $errors->has('phone') ? 'has-error' : '' }}}">
                    <div class="col-md-12">
                        <label class="control-label col-sm-3" for="phone">
                            公司電話
                        </label>
                        <div class="col-sm-9">
                            <input class="form-control" type="text" name="phone" id="phone" placeholder="例：(02)1234-5678" value="" />
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
                                <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 100%; height: 300px; line-height: 20px;"></div>
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
                                <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 100%; height: 300px; line-height: 20px;"></div>
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
<script>
$(document).ready(function () {
    $(document).on("keypress", "form", function(event) {
        return event.keyCode != 13;
    });

    $.validator.addMethod("phone", function(value, element) {
        return this.optional(element) || /\d{4}-\d{3}-\d{3}/.test(value);
    }, "請輸入完手機號碼");

    $(".form-horizontal").validate( {
        rules: {
              name: {
                  required: true,
              },

              email: {
                  email: true,
                  required: true,
              },
              phone: {
                  required: true,
                  phone: true,
              },
              CompanyName: {
                  required: true,
              },
          },
          messages: {
              name: "*請輸入聯絡人姓名",
              email: {
                  required: "*請輸入聯絡人信箱",
                  email: "*請輸入正確的 email 格式"
              },
          },

});
</script>
