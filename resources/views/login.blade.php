<!DOCTYPE html>
<!-- Template Name: Packet - Responsive Admin Template build with Twitter Bootstrap 3.x | Author: ClipTheme -->
<!--[if IE 8]><html class="ie8" lang="en"><![endif]-->
<!--[if IE 9]><html class="ie9" lang="en"><![endif]-->
<!--[if !IE]><!-->
<html lang="en">
	<!--<![endif]-->
	<!-- start: HEAD -->
	<head>
		<title>Packet - Responsive Admin Template</title>
		<!-- start: META -->
		<!--[if IE]><meta http-equiv='X-UA-Compatible' content="IE=edge,IE=9,IE=8,chrome=1" /><![endif]-->
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta content="" name="description" />
		<meta content="" name="author" />
		<!-- end: META -->
		<!-- start: GOOGLE FONTS -->
		<link href="http://fonts.googleapis.com/css?family=Lato:300,400,400italic,600,700|Raleway:300,400,500,600,700|Crete+Round:400italic" rel="stylesheet" type="text/css" />
		<!-- end: GOOGLE FONTS -->
		<!-- start: MAIN CSS -->
		<link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
		<link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="bower_components/themify-icons/themify-icons.css">
		<link rel="stylesheet" href="bower_components/flag-icon-css/css/flag-icon.min.css">
		<link rel="stylesheet" href="bower_components/animate.css/animate.min.css">
		<link rel="stylesheet" href="bower_components/perfect-scrollbar/css/perfect-scrollbar.min.css">
		<link rel="stylesheet" href="bower_components/switchery/dist/switchery.min.css">
		<link rel="stylesheet" href="bower_components/seiyria-bootstrap-slider/dist/css/bootstrap-slider.min.css">
		<link rel="stylesheet" href="bower_components/ladda/dist/ladda-themeless.min.css">
		<link rel="stylesheet" href="bower_components/slick.js/slick/slick.css">
		<link rel="stylesheet" href="bower_components/slick.js/slick/slick-theme.css">
		<!-- end: MAIN CSS -->
		<!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->
		<!-- end: CSS REQUIRED FOR THIS PAGE ONLY -->
		<!-- start: Packet CSS -->
		<link rel="stylesheet" href="assets/css/styles.css">
		<link rel="stylesheet" href="assets/css/plugins.css">
		<link rel="stylesheet" href="assets/css/themes/lyt2-theme-1.css" id="skin_color">
		<!-- end: Packet CSS -->
		<!-- Favicon -->
		<link rel="shortcut icon" href="favicon.ico" />
	</head>
	<!-- end: HEAD -->
	<!-- start: BODY -->
	<body class="login">
		<!-- start: LOGIN -->
		<div class="row">
			<div class="main-login col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4 col-lg-2 col-lg-offset-5">
				<div class="logo text-center">
					<img src="assets/images/logo-big.png" alt="" class="img-responsive" />
				</div>
				<p class="text-center text-dark text-bold text-extra-large margin-top-15">
					Welcome to Packet
				</p>
				<p class="text-center">
					You can build just about any type of dashboard you want with Packet, a developer friendly admin theme.
				</p>
				<p class="text-center">
					Please enter your name and password to log in.
				</p>
				<!-- start: LOGIN BOX -->
				<div class="box-login">
                    <form class="form-login" method="POST" action="{{url('auth/login')}}">
						{!! csrf_field() !!}
						<div class="form-group">
							<input type="email" id="email" class="form-control"  name="email" value="{{ old('email') }}" placeholder="Email">
						</div>
						<div class="form-group form-actions">

							<input type="password" class="form-control password" name="password" placeholder="Password">

						</div>
						<div class="text-center">
							<a href="login_forgot.html"> I forgot my password </a>
						</div>
						<div class="form-actions">
							<button type="submit" class="btn btn-red btn-block">
								Login
							</button>
							<div class="checkbox clip-check check-primary">
								<input type="checkbox" id="remember" value="1">
								<label for="remember"> Keep me signed in </label>
							</div>
						</div>
						
					</form>
					<!-- start: COPYRIGHT -->
					<div class="copyright">
						2016 &copy; Packet by ClipTheme.
					</div>
					<!-- end: COPYRIGHT -->
				</div>
				<!-- end: LOGIN BOX -->
			</div>
		</div>
		<!-- end: LOGIN -->
		<!-- start: MAIN JAVASCRIPTS -->
		<script src="bower_components/jquery/dist/jquery.min.js"></script>
		<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
		<script src="bower_components/components-modernizr/modernizr.js"></script>
		<script src="bower_components/js-cookie/src/js.cookie.js"></script>
		<script src="bower_components/perfect-scrollbar/js/perfect-scrollbar.jquery.min.js"></script>
		<script src="bower_components/jquery-fullscreen/jquery.fullscreen-min.js"></script>
		<script src="bower_components/switchery/dist/switchery.min.js"></script>
		<script src="bower_components/jquery.knobe/dist/jquery.knob.min.js"></script>
		<script src="bower_components/seiyria-bootstrap-slider/dist/bootstrap-slider.min.js"></script>
		<script src="bower_components/slick.js/slick/slick.min.js"></script>
		<script src="bower_components/jquery-numerator/jquery-numerator.js"></script>
		<script src="bower_components/ladda/dist/spin.min.js"></script>
		<script src="bower_components/ladda/dist/ladda.min.js"></script>
		<script src="bower_components/ladda/dist/ladda.jquery.min.js"></script>
		<!-- end: MAIN JAVASCRIPTS -->
		<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
		<script src="bower_components/ckeditor/ckeditor.js"></script>
		<script src="bower_components/ckeditor/adapters/jquery.js"></script>
		<script src="bower_components/bb-jquery-validation/dist/jquery.validate.js"></script>
		<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
		<!-- start: Packet JAVASCRIPTS -->
		<script src="assets/js/letter-icons.js"></script>
		<script src="assets/js/main.js"></script>
		<!-- end: Packet JAVASCRIPTS -->
		<!-- start: JavaScript Event Handlers for this page -->
		<script src="assets/js/login.js"></script>
		<script>
			jQuery(document).ready(function() {
				Main.init();
				Login.init();
			});
		</script>
		<!-- end: JavaScript Event Handlers for this page -->
	</body>
</html>