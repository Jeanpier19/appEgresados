<!DOCTYPE html>
<html lang="es">
	<head>
		<!-- SITE TITTLE -->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		@yield('title')
		{{-- <title>Admisión 2022</title> --}}
		<!-- PLUGINS CSS STYLE -->
		<link href="page/plugins/jquery-ui/jquery-ui.css" rel="stylesheet">
		<link href="page/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link href="page/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="page/plugins/rs-plugin/css/settings.css" media="screen">
		<link rel="stylesheet" type="text/css" href="page/plugins/selectbox/select_option1.css">
		<link rel="stylesheet" type="text/css" href="page/plugins/owl-carousel/owl.carousel.css" media="screen">
		<link rel="stylesheet" type="text/css" href="page/plugins/isotope/jquery.fancybox.css">
		<link rel="stylesheet" type="text/css" href="page/plugins/isotope/isotope.css">
		<!-- GOOGLE FONT -->
		<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Dosis:400,300,600,700' rel='stylesheet' type='text/css'>
		<!-- CUSTOM CSS -->
		<link href="page/css/style.css" rel="stylesheet">
		<link rel="stylesheet" href="page/css/default.css" id="option_color">
		<!-- Icons -->
		<link rel="shortcut icon" href="page/img/favicon.png">
		<link rel="icon" type="img/png" href="page/img/favicon.png">
		<!-- Facebook Pixel Code -->
		<script>
				!function(f,b,e,v,n,t,s)
				{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
				n.callMethod.apply(n,arguments):n.queue.push(arguments)};
				if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
				n.queue=[];t=b.createElement(e);t.async=!0;
				t.src=v;s=b.getElementsByTagName(e)[0];
				s.parentNode.insertBefore(t,s)}(window, document,'script',
				'https://connect.facebook.net/es_ES/fbevents.js');
				fbq('init', '660209364162527');
				fbq('track', 'PageView');
		</script>
		<noscript><img height="1" width="1" style="display:none"
		src="https://www.facebook.com/tr?id=660209364162527&ev=PageView&noscript=1"
		/></noscript>
		<!-- End Facebook Pixel Code -->

	</head>
	<body class="body-wrapper">
		<div>

		</div>
		<div class="main-wrapper">
			<!-- HEADER -->
			<header id="pageTop" class="header-wrapper">
				<!-- COLOR BAR -->
				<div class="container-fluid color-bar top-fixed clearfix">
					<div class="row">
						<div class="col-sm-1 col-xs-2 bg-color-1">fix bar</div>
						<div class="col-sm-1 col-xs-2 bg-color-2">fix bar</div>
						<div class="col-sm-1 col-xs-2 bg-color-3">fix bar</div>
						<div class="col-sm-1 col-xs-2 bg-color-4">fix bar</div>
						<div class="col-sm-1 col-xs-2 bg-color-5">fix bar</div>
						<div class="col-sm-1 col-xs-2 bg-color-6">fix bar</div>
						<div class="col-sm-1 bg-color-1 hidden-xs">fix bar</div>
						<div class="col-sm-1 bg-color-2 hidden-xs">fix bar</div>
						<div class="col-sm-1 bg-color-3 hidden-xs">fix bar</div>
						<div class="col-sm-1 bg-color-4 hidden-xs">fix bar</div>
						<div class="col-sm-1 bg-color-5 hidden-xs">fix bar</div>
						<div class="col-sm-1 bg-color-6 hidden-xs">fix bar</div>
					</div>
				</div>
				<!-- TOP INFO BAR -->
				<div class="top-info-bar bg-color-7 hidden-xs">
					<div class="container">
						<div class="row">
							<div class="col-sm-5">
								<ul class="list-inline topList">
									<li>
										<i class="fa fa-clock-o bg-color-6" aria-hidden="true"></i> Horario de Atención Lun. a Vie. 9:00 a.m. - 5:00 p.m
									</li>
								</ul>
							</div>
							<div class="col-sm-7">
								<ul class="list-inline functionList">			
									<li>
										<a href="tel:+43235868" target="_blank"><i class="fa fa-phone bg-color-2" aria-hidden="true"></i></a>
									</li>
									<li>
										<a href="https://wa.link/of3kq9" target="_blank"><i class="fa fa-whatsapp bg-color-2" aria-hidden="true"></i></a>	
									</li>	
									<li>								
										<a href="https://www.facebook.com/AdmisionUnasamOficial" target="_blank"><i class="fa fa-facebook bg-color-4" aria-hidden="true"></i></a>
									</li>		
									<li>						
										<a href="mailto:unasam.admision@gmail.com"><i class="fa fa-envelope bg-color-3" aria-hidden="true"></i></a>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
				<!-- NAVBAR -->
				<nav id="menuBar" class="navbar navbar-default lightHeader" role="navigation">
					<div class="container">
						<!-- Brand and toggle get grouped for better mobile display -->
						<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							</button>
							<a class="navbar-brand" href="https://www.admision.unasam.edu.pe">
								<img src="page/img/logo-school.png" alt="Kidz School">
							</a>
						</div>
						<!-- Collect the nav links, forms, and other content for toggling -->
						<div class="collapse navbar-collapse navbar-ex1-collapse">
							<ul class="nav navbar-nav navbar-right">
								<li class="dropdown singleDrop color-1   active ">
									<a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
										<i class="fa fa-home bg-color-1" aria-hidden="true"></i><span class="active">Inicio</span>
									</a>
									<ul class="dropdown-menu dropdown-menu-left">
											<li class=" ">
													<a href="https://www.admision.unasam.edu.pe">Inicio</a>
											</li>
									</ul>
								</li>
								<li class=" dropdown megaDropMenu color-2 ">
									<a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="300" data-close-others="true" aria-expanded="false">
										<i class="fa fa-graduation-cap bg-color-2" aria-hidden="true"></i>
										<span>OGAD</span>
									</a>
									<ul class="row dropdown-menu" style="width: 230px">
										<li class="col-sm-3 col-xs-12">
											<ul class="list-unstyled">
												<li style="width: 175px">Quienes Somos</li>
												<li class="">
													<a href="/mision-vision" style="width: 190px">Misión - Visión</a>
												</li>
												<li class="">
													<a href="/constancia" style="width: 190px">Constancia de Ingreso</a>
												</li>
												<li class="">
													<a href="https://drive.google.com/file/d/1_6TUTu0KDCgjtwAom3YYt4yzGyKIW9ci/view" target="_blank" style="width: 190px">Informe Memoria 2017</a>
												</li>
											</ul>
										</li>
									</ul>
								</li>
								<li class="dropdown singleDrop color-3" >
									<a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
										<i class="fa fa-graduation-cap bg-color-3" aria-hidden="true"></i>
										<span>Postgrado</span>
									</a>
									<ul class="dropdown-menu dropdown-menu-right">
										<li class="">
											<a href="http://postgrado.unasam.edu.pe/" target="_blank" >Pagina Web</a>
										</li>
										<li class="">
											<a href="/postgrado/inscripcion">Inscripción</a>
										</li>
										<li class="">
											<a href="#" target="_blank" >Maestría</a>
										</li>
										<li class="">
											<a href="#" target="_blank" >Doctorado</a>
										</li>
										<li class="" >
											<a href="/reglamento-postgrado">Reglamento</a>
										</li>
										<li class="" >
											<a href="/estadisticas-postgrado">Datos Estadísticos</a>
										</li>
									</ul>
								</li>
								<li class="dropdown singleDrop color-4 ">
									<a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
										<i class="fa fa-male bg-color-4" aria-hidden="true"></i>
										<span>Pregrado</span>
									</a>
									<ul class="dropdown-menu dropdown-menu-right">
										<li>
											<a href="https://www.admision.unasam.edu.pe/login">Inscripción</a>
										</li>
										<li>
											<a href="/temario">Temario</a>
										</li>
										<li>
											<a href="/carreras">Carreras</a>
										</li>
										<li>
											<a href="/resultados">Resultados</a>
										</li>
										<li>
											<a href="/examenes">Exámenes</a>
										</li>
										<li>
											<a href="/reglamento-pregrado">Reglamento</a>
										</li>
										<li>
											<a href="/estadisticas-pregrado">Datos Estadísticos</a>
										</li>
									</ul>
								</li>
								<li class="dropdown singleDrop color-5  ">
									<a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
										<i class="fa fa-gavel bg-color-5" aria-hidden="true"></i>
										<span>Transparencia</span>
									</a>
									<ul class="dropdown-menu dropdown-menu-right">
										<li class="" >
											<a href="/normas-legales">Normas Legales</a>
										</li>
									</ul>
								</li>
								<li class="dropdown singleDrop color-6 ">
									<a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
										<i class="fa fa-commenting-o bg-color-6" aria-hidden="true"></i><span>Preguntas Frecuentes</span>
									</a>
									<ul class="dropdown-menu dropdown-menu-right">
										<li class=" ">
											<a href="/preguntas">Preguntas</a>
										</li>
									</ul>
								</li>
							</ul>
						</div>
						
					</div>
				</nav>
			</header>
			@yield('contentpage')
			<!-- LIGHT SECTION -->
			<footer>
				<!-- COLOR BAR -->
				<div class="container-fluid color-bar clearfix">
					<div class="row">
						<div class="col-sm-1 col-xs-2 bg-color-1">fix bar</div>
						<div class="col-sm-1 col-xs-2 bg-color-2">fix bar</div>
						<div class="col-sm-1 col-xs-2 bg-color-3">fix bar</div>
						<div class="col-sm-1 col-xs-2 bg-color-4">fix bar</div>
						<div class="col-sm-1 col-xs-2 bg-color-5">fix bar</div>
						<div class="col-sm-1 col-xs-2 bg-color-6">fix bar</div>
						<div class="col-sm-1 bg-color-1 hidden-xs">fix bar</div>
						<div class="col-sm-1 bg-color-2 hidden-xs">fix bar</div>
						<div class="col-sm-1 bg-color-3 hidden-xs">fix bar</div>
						<div class="col-sm-1 bg-color-4 hidden-xs">fix bar</div>
						<div class="col-sm-1 bg-color-5 hidden-xs">fix bar</div>
						<div class="col-sm-1 bg-color-6 hidden-xs">fix bar</div>
					</div>
				</div>
				<!-- FOOTER INFO AREA -->
				<div class="footerInfoArea full-width clearfix" style="background-image: url(page/img/footer/footer-bg-1.png); padding-top: 20px;padding-bottom: 0px;">
					<div class="container">
						<div class="row">
							<div class="col-sm-3 col-xs-12">
								<div class="footerTitle">
									<a href="https://www.admision.unasam.edu.pe"><img src="page/img/logo-footer.png"></a>
								</div>
								<div class="footerInfo">
									<p>Jefe: Dr. Miguel Ángel Ramírez Guzmán</p>
									<p></p>
								</div>
							</div>
							<div class="col-sm-3 col-xs-12">
								<div class="footerTitle">
									<h4>Acerca de OGAD:</h4>
								</div>
								<div class="footerInfo">
									<ul class="list-unstyled footerList">
										<li>
											<a href="https://www.google.com.pe/maps/place/UNIVERSIDAD+NACIONAL+SANTIAGO+ANTUNEZ+DE+MAYOLO/@-9.5214333,-77.5293701,17z/data=!4m5!3m4!1s0x91a90d12eb234bf1:0xc860f66d7ad8abd9!8m2!3d-9.5212334!4d-77.5287366?hl=es-419" target="_blank">
												<i class="fa fa-angle-double-right" aria-hidden="true"></i>Av. centenario N°200 - Huaraz
											</a>
										</li>
										<li>
											<a href="#">
												<i class="fa fa-angle-double-right" aria-hidden="true"></i>Horario de Atención: Lunes a Viernes de 8:00 a.m. - 1:00 p.m. y de 3:00 P.m. - 5:00 p.m.
											</a>
										</li>
									</ul>
								</div>
							</div>
							<div class="col-sm-3 col-xs-12">
								<div class="footerTitle">
									<h4>Pagos:</h4>
								</div>
								<div class="footerInfo">
									<ul class="list-unstyled postLink">
										
										<li>
											<div class="media">
												<a class="media-left" href="http://www.bn.com.pe/" target="_blank">
													<img class="media-object img-rounded border-color-1" src="page/img/footer/footer-img-1.png"  alt="Image">
												</a>
												<div class="media-body">
													<div class="footerInfo">
														{{-- <p>Transacción: <b>9650</b></p> --}}
														<p>Código de Operación:<br><b>01774</b></p>
														<p>Pago con el número de DNI del Postulante</p>
													</div>

													<h5 class="media-heading"></a></h5>
													{{-- <p>Ordinario: 29 Marzo 2020</p>
													<p>Extraordinario: 22 Marzo 2020</p> --}}
												</div>
											</div>
										</li>
									</ul>
								</div>
							</div>
							<div class="col-sm-3 col-xs-12">
								<div class="footerTitle">
									<h4>Contáctanos:</h4>
								</div>
								<div class="footerInfo">
									<p>Telefono N° 01: <a href="tel:043640030">043-640030</a></p>
									<p>Whastapp: <a href="https://wa.link/of3kq9">+51 043 640030</a></p>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<!-- COPY ENLACES DE INTERES -->
				<section style="width: 100%; margin-bottom: 0px; height: 30%">
					<div style="background-color: #0f40ab">
						<img src="page/img/home/enlaces.png" alt="">
					</div>
					<div style="padding: 0px 0px; background-color: #fff; box-shadow: 2px 2px 5px 0px rgba(50, 50, 50, 0.5); height: auto">
						<marquee behavior="alternate">
						<img src="page/img/Interes/Separador.png" >
						<a href="http://www.jovenesproductivos.gob.pe" target="_blank"><img src="page/img/Interes/Jovenes-Productivos.png" ></a>
						<img src="page/img/Interes/Separador.png" >
						<a href="https://www.sunedu.gob.pe/" target="_blank"><img src="page/img/Interes/logo-sunedu.png"></a>
						<img src="page/img/Interes/Separador.png" >
						<a href="https://www.mef.gob.pe/" target="_blank"><img src="page/img/Interes/MEF.jpg" ></a>
						<img src="page/img/Interes/Separador.png" >
						<a href="http://www.minedu.gob.pe/" target="_blank"><img src="page/img/Interes/MinEdu.png"></a>
						<img src="page/img/Interes/Separador.png" >
						</marquee>
					</div>
				</section>
				<!-- COPY RIGHT -->
				<div class="copyRight clearfix">
					<div class="container">
						<div class="row">
							<div class="col-sm-5 col-sm-push-7 col-xs-12">
								<ul class="list-inline">
									<li>
										<a href="https://www.facebook.com/AdmisionUnasamOficial/" class="bg-color-4" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>
									</li>
									<li>
										<a href="mailto:unasam.admision@gmail.com" class="bg-color-2" target="_blank"><i class="fa fa-envelope" aria-hidden="true"></i></a>
									</li>
									<li>
										<a href="https://www.youtube.com/channel/UC1YcKbEDmFSgnKrOPctpRzA" class="bg-color-3" target="_blank"><i class="fa fa-youtube-play" aria-hidden="true"></i></a>
									</li>
									<li>
										<a href="https://www.instagram.com/admisionunasamoficial" class="bg-color-5" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a>
									</li>
								</ul>
							</div>
							<div class="col-sm-7 col-sm-pull-5 col-xs-12">
								<div class="copyRightText">
									<p>© 2019-2021 Copyright Oficina General de  <a href="https://www.admision.unasam.edu.pe">Admisión</a>.</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</footer>
		</div>
		<div class="scrolling">
			<a href="#pageTop" style="margin-right: 90px; margin-bottom: 6px;" class="backToTop hidden-xs" id="backToTop"><i class="fa fa-arrow-up" aria-hidden="true"></i></a>
		</div>

	<!-- Load Facebook SDK for JavaScript -->
      <div id="fb-root"></div>
		      <!-- Your Chat Plugin code -->
		<div class="fb-customerchat"
		attribution="setup_tool"
		page_id="1081511975213406"
		theme_color="#0084ff"
		logged_in_greeting="¡Hola! Como podemos ayudarte."
		logged_out_greeting="¡Hola! Como podemos ayudarte.">
		</div>

		</body>
	<script>
        window.fbAsyncInit = function() {
          FB.init({
            xfbml            : true,
            version          : 'v9.0'
          });
        };

        (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/es_ES/sdk/xfbml.customerchat.js';
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));
  	</script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="page/plugins/jquery-ui/jquery-ui.js"></script>
	<script src="page/plugins/bootstrap/js/bootstrap.min.js"></script>
	<script src="page/plugins/rs-plugin/js/jquery.themepunch.tools.min.js"></script>
	<script src="page/plugins/rs-plugin/js/jquery.themepunch.revolution.min.js"></script>
	<script src="page/plugins/selectbox/jquery.selectbox-0.1.3.min.js"></script>
	<script src="page/plugins/owl-carousel/owl.carousel.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/2.0.3/waypoints.min.js"></script>
	<script src="page/plugins/counter-up/jquery.counterup.min.js"></script>
	<script src="page/plugins/isotope/isotope.min.js"></script>
	<script src="page/plugins/isotope/jquery.fancybox.pack.js"></script>
	<script src="page/plugins/isotope/isotope-triger.js"></script>
	<script src="page/plugins/countdown/jquery.syotimer.js"></script>
	<script src="page/plugins/velocity/velocity.min.js"></script>
	{{-- <script src="page/plugins/smoothscroll/SmoothScroll.js"></script> --}}
	<script src="page/js/custom.js"></script>
	<script src="page/js/axios.min.js"></script>
	<script src="page/js/codigo.js"></script>

	@yield('scriptspage')

</html>