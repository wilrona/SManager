<html>
    <head>
        <title>Yoomee POS - @yield('title')</title>
        <!-- start: META -->
		<!--[if IE]><meta http-equiv='X-UA-Compatible' content="IE=edge,IE=9,IE=8,chrome=1" /><![endif]-->
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta content="" name="description" />
		<meta content="" name="author" />
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<!-- end: META -->
		<!-- start: GOOGLE FONTS -->
		<link href="http://fonts.googleapis.com/css?family=Lato:300,400,400italic,600,700|Raleway:300,400,500,600,700|Crete+Round:400italic" rel="stylesheet" type="text/css" />
		<!-- end: GOOGLE FONTS -->
		<!-- start: MAIN CSS -->
		<link rel="stylesheet" href="{{URL::asset('bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
		<link rel="stylesheet" href="{{URL::asset('bower_components/font-awesome/css/font-awesome.min.css')}}">
		<link rel="stylesheet" href="{{URL::asset('bower_components/themify-icons/themify-icons.css')}}">
		<link rel="stylesheet" href="{{URL::asset('bower_components/flag-icon-css/css/flag-icon.min.css')}}">
		<link rel="stylesheet" href="{{URL::asset('bower_components/animate.css/animate.min.css')}}">
		<link rel="stylesheet" href="{{URL::asset('bower_components/perfect-scrollbar/css/perfect-scrollbar.min.css')}}">
		<link rel="stylesheet" href="{{URL::asset('bower_components/switchery/dist/switchery.min.css')}}">
		<link rel="stylesheet" href="{{URL::asset('bower_components/seiyria-bootstrap-slider/dist/css/bootstrap-slider.min.css')}}">
		<link rel="stylesheet" href="{{URL::asset('bower_components/ladda/dist/ladda-themeless.min.css')}}">
		<link rel="stylesheet" href="{{URL::asset('bower_components/slick.js/slick/slick.css')}}">
		<link rel="stylesheet" href="{{URL::asset('bower_components/slick.js/slick/slick-theme.css')}}">
		<link rel="stylesheet" href="{{URL::asset('bower_components/sweetalert/dist/sweetalert.css')}}">
		<link rel="stylesheet" href="{{URL::asset('bower_components/toastr/toastr.min.css')}}">
		<!-- end: MAIN CSS -->
		<!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->
		<!-- end: CSS REQUIRED FOR THIS PAGE ONLY -->
		<!-- start: Packet CSS -->
		<link rel="stylesheet" href="{{URL::asset('assets/css/styles.css')}}">
		<link rel="stylesheet" href="{{URL::asset('assets/css/plugins.css')}}">
		<link rel="stylesheet" href="{{URL::asset('assets/css/themes/lyt1-theme-1.css')}}">
		<link rel="stylesheet" href="{{URL::asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.css')}}">
		<link rel="stylesheet" href="{{URL::asset('bower_components/DataTables/media/css/dataTables.bootstrap.min.css')}}">
		<link rel="stylesheet" href="{{URL::asset('bower_components/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.css')}}">


		<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
		<!-- end: Packet CSS -->

		<link rel="stylesheet" href="{{URL::asset('assets/css/app.css')}}">

		<script src="{{URL::asset('bower_components/jquery/dist/jquery.min.js')}}"></script>


		<!-- Favicon -->
		<link rel="shortcut icon" href="favicon.ico" />
    </head>
    <body>
     <div id="app" class="">
        
            <!-- sidebar -->
			<div class="sidebar app-aside" id="sidebar">
				<div class="sidebar-container perfect-scrollbar">
					<div>
						<!-- start: SEARCH FORM -->
						<div class="search-form hidden-md hidden-lg">
							<a class="s-open" href="#"> <i class="ti-search"></i> </a>
							<form class="navbar-form" role="search">
								<a class="s-remove" href="#" target=".navbar-form"> <i class="ti-close"></i> </a>
								<div class="form-group">
									<input type="text" class="form-control" placeholder="Enter search text here...">
									<button class="btn search-button" type="submit">
										<i class="ti-search"></i>
									</button>
								</div>
							</form>
						</div>
						<!-- end: SEARCH FORM -->
						<!-- start: USER OPTIONS -->
						<div class="nav-user-wrapper">
							<div class="media">
								<div class="media-left">
									<a class="profile-card-photo" href="#"><img alt="" src="{{URL::asset('assets/images/avatar-1.jpg')}}"></a>
								</div>
								<div class="media-body">
									<span class="media-heading text-white">Peter Clark</span>
									<div class="text-small text-white-transparent">
										UI Designer
									</div>
								</div>
								<div class="media-right media-middle">
									<div class="dropdown">
										<button href class="btn btn-transparent text-white dropdown-toggle" data-toggle="dropdown">
											<i class="fa fa-caret-down"></i>
										</button>
										<ul class="dropdown-menu animated fadeInRight pull-right">
											<li>
												<a href="<?= url('users/profile') ?>"> My Profile </a>
											</li>
											<li>
												<a href="#"> My Calendar </a>
											</li>
											<li>
												<a href="#"> My Messages (3) </a>
											</li>
											<li>
												<a href="#"> Lock Screen </a>
											</li>
											<li class="divider"></li>
											<li>
												
                                                @if (Route::has('login'))
                                                    
                                                        @auth
                                                            <a href="{{ route('logout') }}">Logout</a>
                                                        @else
                                                            <a href="{{ route('login') }}">Login</a>
                                                        @endauth
                                                    
                                                @endif
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
						<!-- end: USER OPTIONS -->
						<nav>
							<!-- start: MAIN NAVIGATION MENU --> 
							<div class="navbar-title">
								<span>Main Navigation</span>
							</div>

							<ul class="main-navigation-menu">
								<li class="{{ Menu::active('/') }}" >
									<a href="<?= url('/') ?>">
									<div class="item-content">
										<div class="item-media">
											<div class="lettericon" data-text="Dashboard" data-size="sm" data-char-count="2"></div>
										</div>
										<div class="item-inner">
											<span class="title"> Dashboard </span>
										</div>
									</div> </a>
								</li>

								<li class="{{ Menu::active('caisse-manager') }}" >
									<a href="<?= route('caisseManager.index') ?>">
										<div class="item-content">
											<div class="item-media">
												<div class="lettericon" data-text="Mes Caisses" data-size="sm" data-char-count="2"></div>
											</div>
											<div class="item-inner">
												<span class="title"> Mes Caisses </span>
											</div>
										</div>
									</a>
								</li>

								<li class="{{ Menu::active('clients') }}" >
									<a href="<?= route('client.index') ?>">
										<div class="item-content">
											<div class="item-media">
												<div class="lettericon" data-text="Client" data-size="sm" data-char-count="2"></div>
											</div>
											<div class="item-inner">
												<span class="title"> Clients </span>
											</div>
										</div>
									</a>
								</li>
								<li class="{{ Menu::active('demandes') }} ">
									<a href="javascript:void(0)">
										<div class="item-content">
											<div class="item-media">
												<div class="lettericon" data-text="Demande Stock" data-size="sm" data-char-count="2"></div>
											</div>
											<div class="item-inner">
												<span class="title"> Demande Stock </span><i class="icon-arrow"></i>
											</div>
										</div> </a>
									<ul class="sub-menu">
										<li>
											<a href="{{ route('dmd.index') }}"> <span class="title">Demande Envoyée </span> </a>
										</li>
										<li>
											<a href="{{ route('receive.index') }}"> <span class="title">Demande Reçue </span> </a>
										</li>
									</ul>
								</li>
								<li class="{{ Menu::active('stockages') }} ">
									<a href="javascript:void(0)">
										<div class="item-content">
											<div class="item-media">
												<div class="lettericon" data-text="Stock" data-size="sm" data-char-count="2"></div>
											</div>
											<div class="item-inner">
												<span class="title"> Stock </span><i class="icon-arrow"></i>
											</div>
										</div> </a>
									<ul class="sub-menu">
										<li>
											<a href="{{ route('produit.index') }}"> <span class="title">Produits </span> </a>
										</li>

										<li>
											<a href="{{ route('serie.index') }}"> <span class="title">N° Serie </span> </a>
										</li>

										<li>
											<a href="{{ route('ecriture.index') }}"> <span class="title">Ecriture Stock </span> </a>
										</li>

									</ul>
								</li>

								<li class="{{ Menu::active('settings') }} ">
									<a href="javascript:void(0)">
										<div class="item-content">
											<div class="item-media">
												<div class="lettericon" data-text="Paramètres" data-size="sm" data-char-count="2"></div>
											</div>
											<div class="item-inner">
												<span class="title"> Paramètres </span><i class="icon-arrow"></i>
											</div>
										</div> </a>
									<ul class="sub-menu">
										<li>
											<a href="<?= route('user.index') ?>"> <span class="title">Utilisateurs </span> </a>
										</li>
										<li>
											<a href="<?= route('profile.index') ?>"> <span class="title">Profiles </span> </a>
										</li>
										<li>
											<a href="{{ route('magasin.index') }}"> <span class="title">Magasins </span> </a>
										</li>

										<li>
											<a href="{{ route('pos.index') }}"> <span class="title">Points de vente </span> </a>
										</li>
										<li>
											<a href="{{ route('famillepro.index') }}"> <span class="title">Familles de produit </span> </a>
										</li>
										<li>
											<a href="{{ route('unite.index') }}"> <span class="title">Unités de produit </span> </a>
										</li>
										<li>
											<a href="{{ route('famillecli.index') }}"> <span class="title">Familles de client </span> </a>
										</li>
										<li>
											<a href="{{ route('caisse.index') }}"> <span class="title">Caisses </span> </a>
										</li>
										<li>
											<a href="{{ route('param.index') }}"> <span class="title">Configurations </span> </a>
										</li>

									</ul>
								</li>
								
							</ul>
							<!-- end: MAIN NAVIGATION MENU -->
							
						</nav>
					</div>
				</div>
			</div>
			<!-- / sidebar @show-->
        
		
        	<div class="app-content">
				<!-- start: TOP NAVBAR -->
				<header class="navbar navbar-default navbar-static-top">
					<!-- start: NAVBAR HEADER -->
					<div class="navbar-header">
						<button href="#" class="sidebar-mobile-toggler pull-left btn no-radius hidden-md hidden-lg" class="btn btn-navbar sidebar-toggle" data-toggle-class="app-slide-off" data-toggle-target="#app" data-toggle-click-outside="#sidebar">
							<i class="fa fa-bars"></i>
						</button>
						<a class="navbar-brand" href="index.html"> <img src="{{URL::asset('assets/images/logo.png')}}" alt="Packet"/> </a>
						<a class="navbar-brand navbar-brand-collapsed" href="index.html"> <img src="{{URL::asset('assets/images/logo-collapsed.png')}}" alt="" /> </a>

						<button class="btn pull-right menu-toggler visible-xs-block" id="menu-toggler" data-toggle="collapse" href=".navbar-collapse" data-toggle-class="menu-open">
							<i class="fa fa-folder closed-icon"></i><i class="fa fa-folder-open open-icon"></i><small><i class="fa fa-caret-down margin-left-5"></i></small>
						</button>
					</div>
					<!-- end: NAVBAR HEADER -->
					<!-- start: NAVBAR COLLAPSE -->
					<div class="navbar-collapse collapse">
						<ul class="nav navbar-left hidden-sm hidden-xs">
							<li class="sidebar-toggler-wrapper">
								<div>
									<button href="javascript:void(0)" class="btn sidebar-toggler visible-md visible-lg">
										<i class="fa fa-bars"></i>
									</button>
								</div>
							</li>
							<li>
								<a href="#" class="toggle-fullscreen"> <i class="fa fa-expand expand-off"></i><i class="fa fa-compress expand-on"></i></a>
							</li>
							
						</ul>
						<ul class="nav navbar-right">
							<!-- start: MESSAGES DROPDOWN -->
							<li class="dropdown">
								<a href class="" > <span class=""> POS </span> <i class="fa fa-th-large"></i> </a>
							
							</li>
							<!-- end: MESSAGES DROPDOWN -->
							<!-- start: ACTIVITIES DROPDOWN -->
							<li class="dropdown">
								<a href class="dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-bell"></i> </a>
								<ul class="dropdown-menu dropdown-light dropdown-messages dropdown-large animated fadeInUpShort">
									<li>
										<span class="dropdown-header"> You have new notifications</span>
									</li>
									<li>
										<div class="drop-down-wrapper ps-container">
											<div class="list-group no-margin">
												<a class="media list-group-item" href=""> <img class="img-circle" alt="..." src="{{URL::asset('assets/images/avatar-1.jpg')}}"> <span class="media-body block no-margin"> Use awesome animate.css <small class="block text-grey">10 minutes ago</small> </span> </a>
												<a class="media list-group-item" href=""> <span class="media-body block no-margin"> 1.0 initial released <small class="block text-grey">1 hour ago</small> </span> </a>
											</div>
										</div>
									</li>
									<li class="view-all">
										<a href="#"> See All </a>
									</li>
								</ul>
							</li>
							<!-- end: ACTIVITIES DROPDOWN -->
						</ul>
					
					</div>
					
				</header>
			    <!-- end: TOP NAVBAR -->
				<div class="main-content" >
           			 @yield('content')
				</div>
        </div>
        <!-- start: FOOTER -->

			<footer>
				<div class="footer-inner">
					<div class="pull-left">
						&copy; <span class="current-year"></span><span class="text-bold text-uppercase"> ClipTheme</span>. <span>All rights reserved</span>
					</div>
					<div class="pull-right">
						<span class="go-top"><i class="ti-angle-up"></i></span>
					</div>
				</div>
			</footer>
			<!-- end: FOOTER -->


		 <div class="modal centered-modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="mService1" aria-hidden="true" >
			 <div class="modal-dialog">
				 <div class="modal-content">
					 <div >
						 <div style="margin: 0 auto; text-align: center;" class="padding-40">
							 <i class="fa fa-spin fa-spinner" style="font-size: 160px; line-height: 160px"></i>
							 <h3 class="margin-top-35">Chargement ....</h3>
						 </div>
					 </div>
				 </div>
			 </div>
		 </div>
		 <div class="modal centered-modal" id="myModal-lg" tabindex="-1" role="dialog" aria-labelledby="mService1" aria-hidden="true" >
			 <div class="modal-dialog modal-lg">
				 <div class="modal-content ">
					 <div >
						 <div style="margin: 0 auto; text-align: center;" class="padding-40">
							 <i class="fa fa-spin fa-spinner" style="font-size: 160px; line-height: 160px"></i>
							 <h3 class="margin-top-35">Chargement ....</h3>
						 </div>
					 </div>
				 </div>
			 </div>
		 </div>

	 </div>
			
			
     </div>
	 @section('footer')
     <!-- start: MAIN JAVASCRIPTS -->


		<script src="{{URL::asset('bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
		<script src="{{URL::asset('bower_components/components-modernizr/modernizr.js')}}"></script>
		<script src="{{URL::asset('bower_components/js-cookie/src/js.cookie.js')}}"></script>
		<script src="{{URL::asset('bower_components/perfect-scrollbar/js/perfect-scrollbar.jquery.min.js')}}"></script>
		<script src="{{URL::asset('bower_components/jquery-fullscreen/jquery.fullscreen-min.js')}}"></script>
		<script src="{{URL::asset('bower_components/switchery/dist/switchery.min.js')}}"></script>
		<script src="{{URL::asset('bower_components/jquery.knobe/dist/jquery.knob.min.js')}}"></script>
		<script src="{{URL::asset('bower_components/seiyria-bootstrap-slider/dist/bootstrap-slider.min.js')}}"></script>
		<script src="{{URL::asset('bower_components/slick.js/slick/slick.min.js')}}"></script>
		<script src="{{URL::asset('bower_components/jquery-numerator/jquery-numerator.js')}}"></script>
		<script src="{{URL::asset('bower_components/ladda/dist/spin.min.js')}}"></script>
		<script src="{{URL::asset('bower_components/ladda/dist/ladda.min.js')}}"></script>
		<script src="{{URL::asset('bower_components/ladda/dist/ladda.jquery.min.js')}}"></script>


	 	<script src="{{URL::asset('bower_components/jquery.maskedinput/dist/jquery.maskedinput.min.js')}}"></script>
	 	<script src="{{URL::asset('bower_components/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js')}}"></script>
	 	<script src="{{URL::asset('bower_components/autosize/dist/autosize.min.js')}}"></script>
	 	<script src="{{URL::asset('bower_components/select2/dist/js/select2.min.js')}}"></script>
	 	<script src="{{URL::asset('bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
	 	<script src="{{URL::asset('bower_components/bootstrap-datepicker/dist/locales/bootstrap-datepicker.fr.min.js')}}"></script>
	 	<script src="{{URL::asset('bower_components/bootstrap-timepicker/js/bootstrap-timepicker.js')}}"></script>


	 	<script src="{{URL::asset('bower_components/DataTables/media/js/jquery.dataTables.js')}}"></script>
	 	<script src="{{URL::asset('bower_components/DataTables/media/js/dataTables.bootstrap.js')}}"></script>
	 	<script src="{{URL::asset('bower_components/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.js')}}"></script>
	 	<script src="{{URL::asset('bower_components/sweetalert/dist/sweetalert.min.js')}}"></script>
	 	<script src="{{URL::asset('bower_components/toastr/toastr.min.js')}}"></script>
		<!-- end: MAIN JAVASCRIPTS -->
		<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY >
		<script src="bower_components/Chart-js/Chart.min.js"></script>
		<! end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY >
		<! start: Packet JAVASCRIPTS -->
		<script src="{{URL::asset('assets/js/letter-icons.js')}}"></script>
		<script src="{{URL::asset('assets/js/main.js')}}"></script>


		<script src="{{URL::asset('assets/js/selectFx/classie.js')}}"></script>
		<script src="{{URL::asset('assets/js/selectFx/selectFx.js')}}"></script>
		<script src="{{URL::asset('assets/js/form-elements.js')}}"></script>
	 	<script src="{{URL::asset('assets/js/table-data.js')}}"></script>
	 	<script src="{{URL::asset('assets/js/ui-notifications.js')}}"></script>


	 	<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

	 	<script src="{{URL::asset('assets/js/app.js')}}"></script>
		<!-- end: Packet JAVASCRIPTS -->

		<script src="{{URL::asset('assets/js/index.js')}}"></script>
		<script>
			jQuery(document).ready(function() {
				Main.init();
//				Index.init();
                FormElements.init();
                TableData.init();
                UINotifications.init();
			});

            $('#myModal').on('hide.bs.modal', function(e) {
                $(this).removeData('bs.modal');
                $('.modal-content').html('<div class="height-200" >\n' +
                    '                                <div style="margin: 0 auto; text-align: center;">\n' +
                    '                                    <i class="fa fa-spin fa-spinner" style="font-size: 160px; line-height: 160px"></i>\n' +
                    '                                </div>\n' +
                    '                            </div>');

            });

            $('#myModal-lg').on('hide.bs.modal', function(e) {
                $(this).removeData('bs.modal');
                $('.modal-content').html('<div class="height-200" >\n' +
                    '                                <div style="margin: 0 auto; text-align: center;">\n' +
                    '                                    <i class="fa fa-spin fa-spinner" style="font-size: 160px; line-height: 160px"></i>\n' +
                    '                                </div>\n' +
                    '                            </div>');

            });

            toastr.options = {
                "closeButton": true,
                "positionClass": "toast-bottom-right",
                "showDuration": "1000",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }

		</script>






	 @show
    </body>
</html>