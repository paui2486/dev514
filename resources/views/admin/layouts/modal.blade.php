<!DOCTYPE html>

<html lang="en">
<head>
<meta charset="UTF-8">
    <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>514 管理後台</title>

    <link rel="stylesheet" href="{{asset('css/bootstrap-reset.css')}}">
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <!--external css-->
    <link rel="stylesheet" href="{{asset('assets/font-awesome/css/font-awesome.css')}}"/>
    <!-- <link rel="stylesheet" href="{{asset('assets/fullcalendar/fullcalendar/bootstrap-fullcalendar.css')}}"/> -->
    <link rel="stylesheet" href="{{asset('css/datatables.min.css')}}"/>
    <!-- <link rel="stylesheet" href="{{asset('css/jquery.dataTables.min.css')}}"/> -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/jquery-easy-pie-chart/jquery.easy-pie-chart.css')}}" media="screen"/>
    <link rel="stylesheet" type="text/css" href="{{asset('css/owl.carousel.css')}}">
    <!-- Right Slidebar -->
    <link rel="stylesheet" href="{{asset('css/slidebars.css')}}">
    <!-- ColorBox CSS -->
    <link rel="stylesheet" href="{{asset('css/colorbox.css')}}">
    <!-- <link href="{{ asset('css/summernote.css')}}" rel="stylesheet" type="text/css"> -->
    <!-- Custom styles for this template -->
    <link href="{{{ asset('css/select2.css') }}}" rel="stylesheet" type="text/css">
    @yield('style')
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" href="{{asset('css/style-responsive.css')}}"/>
</head>

<body>
	<!-- Container -->
	<div class="container">
		<div class="page-header"></div>
		<div class="pull-right">
			<button class="btn btn-primary btn-sm close_popup">
				<span class="glyphicon glyphicon-backward"></span> 返回
			</button>
		</div>
		<!-- Content -->
		@yield('content')
		<!-- ./ content -->
	</div>
	<!-- ./ container -->

  <!-- js placed at the end of the document so the pages load faster -->
  <script type="text/javascript" src="{{asset('js/jquery.js')}}"></script>
  <script type="text/javascript" src="{{asset('js/bootstrap.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('js/jquery-ui-1.9.2.custom.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('js/jquery-migrate-1.2.1.min.js')}}"></script>

  <!--right slidebar-->
  <script type="text/javascript" src="{{asset('js/slidebars.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('js/jquery.dcjqaccordion.2.7.js')}}"></script>

  <!-- scroll -->
  <script type="text/javascript" src="{{asset('js/jquery.scrollTo.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('js/jquery.nicescroll.js')}}"></script>

  <!-- analysis -->
  <!-- <script type="text/javascript" src="{{asset('js/jquery.sparkline.js')}}"></script> -->
  <!-- <script type="text/javascript" src="{{asset('assets/jquery-easy-pie-chart/jquery.easy-pie-chart.js')}}"></script> -->

  <!-- Data Range Picker -->
  <script type="text/javascript" src="{{asset('js/moment.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('js/daterangepicker.js')}}"></script>

  <!-- DataTables -->
  <script type="text/javascript" src="{{asset('js/datatables.min.js')}}"></script>
  <!-- <script type="text/javascript" src="{{asset('assets/data-tables/DT_bootstrap.js')}}"></script> -->
  <script type="text/javascript" src="{{asset('js/jquery.colorbox.js')}}"></script>

  <script type="text/javascript" src="{{asset('assets/fullcalendar/fullcalendar/fullcalendar.min.js')}}"></script>

  <!-- Editor -->
	<!-- <script src="{{  asset('js/summernote.js')}}"></script> -->
  <script type="text/javascript" src="{{asset('assets/ckeditor/ckeditor.js')}}"></script>
  <script type="text/javascript" src="{{asset('assets/ckfinder/ckfinder.js')}}"></script>


	<script src="{{  asset('js/select2.js') }}"></script>
  <!-- slider -->
  <!-- <script type="text/javascript" src="{{asset('js/owl.carousel.js')}}" ></script> -->

  <!--common script for all pages-->
  <script type="text/javascript" src="{{asset('js/common-scripts.js')}}"></script>
  <!--script for this page only-->
  <script type="text/javascript" src="{{asset('js/external-dragging-calendar.js')}}"></script>
  @yield('scripts')

	<script type="text/javascript">
			$(function() {
				// $('textarea').summernote({height: 250});
				$('form').submit(function(event) {
					event.preventDefault();
					var form = $(this);

					if (form.attr('id') == '' || form.attr('id') != 'fupload'){
						$.ajax({
							  type : form.attr('method'),
							  url : form.attr('action'),
							  data : form.serialize()
							  }).success(function() {
								  setTimeout(function() {
									  parent.$.colorbox.close();
									  window.parent.location.reload();
									  }, 10);
							}).fail(function(jqXHR, textStatus, errorThrown) {
			                    // Optionally alert the user of an error here...
			                    var textResponse = jqXHR.responseText;
			                    var alertText = "One of the following conditions is not met:\n\n";
			                    var jsonResponse = jQuery.parseJSON(textResponse);

			                    $.each(jsonResponse, function(n, elem) {
			                        alertText = alertText + elem + "\n";
			                    });
			                    alert(alertText);
			                });
						}
					else{
						var formData = new FormData(this);
						$.ajax({
							  type : form.attr('method'),
							  url : form.attr('action'),
							  data : formData,
							  mimeType:"multipart/form-data",
							  contentType: false,
							  cache: false,
							  processData:false
						}).success(function() {
							  setTimeout(function() {
								  parent.$.colorbox.close();
								  window.parent.location.reload();
								  }, 10);

						}).fail(function(jqXHR, textStatus, errorThrown) {
		                    // Optionally alert the user of an error here...
		                    var textResponse = jqXHR.responseText;
		                    var alertText = "One of the following conditions is not met:\n\n";
		                    var jsonResponse = jQuery.parseJSON(textResponse);

		                    $.each(jsonResponse, function(n, elem) {
		                        alertText = alertText + elem + "\n";
		                    });

		                    alert(alertText);
		                });
					};
				});

				$('.close_popup').click(function() {
					parent.$.colorbox.close()
					window.parent.location.reload();
				});
			});
		</script>
	@yield('scripts')
</body>
</html>
