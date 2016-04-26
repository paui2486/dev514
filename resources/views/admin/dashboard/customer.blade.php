@extends('layouts.admin')

@section('content')
<section id="main-content">
    <section class="wrapper">
			<div class="Customer">
				<div class="page-header">
					<div class="alert alert-info" role="alert">
						<ul>
							<li>立即填寫線上表格，514團隊將以最快的速度回覆您。</li>
						</ul>
					</div>
				</div>

				<div class="panel panel-default">
					<div class="panel-heading">
                        聯絡我們
					</div>
					<div class="panel-body">
						<form id="cusForm" method="post" class="form-horizontal" style="padding: 10px 25px;">
							<div class="form-group">
                                <label class="col-sm-2 control-label" for="username"><span>*</span>您的姓名</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="username" name="username" />
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-2 control-label" for="email"><span>*</span>電子郵件</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="email" name="email" placeholder="例：service@514.com.tw" />
								</div>
							</div>
                            
                            <div class="form-group">
								<label class="col-sm-2 control-label" for="mobile"><span>*</span>聯絡電話</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="mobile" name="mobile" placeholder="請填寫手機號碼" />
								</div>
							</div>
                            
                            <div class="form-group">
								<label class="col-sm-2 control-label" for="comment"><span>*</span>需求內容</label>
								<div class="col-sm-10">
									<textarea type="text" class="form-control"  name="comment" /></textarea>
								</div>
							</div>
                            
							<div class="form-group">
								<div class="col-sm-12 customer-button">
									<button type="submit" class="btn btn-primary" name="submit" value="submit">送出</button>
								</div>
							</div>
                            
						</form>
					</div>
				</div>
			</div>

    </section>
</section>
@endsection

@section('scripts')
<script type="text/javascript" src="/js/jquery.validate.js"></script>
<script type="text/javascript" src="additional-methods.min.js"></script>
<script type="text/javascript" src="messages_zh_TW.min.js"></script>
	<script type="text/javascript">
		$.validator.setDefaults( {
			submitHandler: function () {
				alert( "感謝您的提問，514客服人員將盡快回覆您！" );
			}
		} );

		$( document ).ready( function () {
			$( "#cusForm" ).validate( {
				rules: {
					username: {
						required: true,
					},
					email: {
						required: true,
						email: true
					},
                    mobile: {
                        required: true,
                    },
                    comment: {
                        required:true,
                    }
                    
				},
				messages: {
					username: {
						required: "*請輸入您的姓名",
					},
					email: "*請填寫正確email格式",
                    mobile: "*請輸入聯絡電話",
                    comment: "*此欄位不可空白"
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
					$( element ).parents( ".col-sm-10" ).addClass( "has-error" ).removeClass( "has-success" );
				},
				unhighlight: function (element, errorClass, validClass) {
					$( element ).parents( ".col-sm-10" ).addClass( "has-success" ).removeClass( "has-error" );
				}
			} );
		} );
	</script>
@stop










