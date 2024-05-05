@extends('layouts.appPage')
@section('title')
<title>Admisión UNASAM</title>
@endsection
@section('contentpage')
<style>
	.cerrar {
		color: red;
		margin-right: 10px;
		font-weight: bold;
		font-size: 30px;
	}

	.color-tail {
		color: #47d285;
	}
</style>
<!-- BANNER -->
<section class="bannercontainer bannercontainerV1">
	<div class="fullscreenbanner-container">
		<div class="fullscreenbanner">
			<ul>
				@for ($i = 0; $i < 4; $i++) <li data-transition="fade" data-slotamount="5" data-masterspeed="1000" data-title="Slide 1">
					{{--<img src="/page/img/home/slider/2022home.png" alt="slidebg1" data-bgfit="cover" data-bgposition="center center" data-bgrepeat="no-repeat" class="img-responsive">--}}
					<img src="/page/img/home/slider/slider.png" class="img-responsive">
					<div class="slider-caption container">
						<div class="tp-caption rs-caption-1 sft start text-center" data-hoffset="0" data-x="center" data-y="130" data-speed="800" data-start="1000" data-easing="Back.easeInOut" data-endspeed="1000" style="margin: 15px">
							<a href="http://127.0.0.1:8000/login" target="_blank"><img height="80" width="300" src="/page/img/logo-licenciado.png"></a>
						</div>
						<div class="tp-caption rs-caption-3 sft text-center" data-hoffset="0" data-x="center" data-y="110" data-speed="1000" data-start="1500" data-easing="Power4.easeOut" data-endspeed="300" data-endeasing="Power1.easeIn" data-captionhidden="off" style="
								font-size: 30px !important;
								color: #222222;
								font-weight: 700;
								font-family: 'Arial black',sans-serif;
								letter-spacing: -1px;
								text-shadow: -2px -2px 4px #fff, 2px 2px 4px #fff, -2px 2px 4px #fff, 2px -2px 4px #fff;
								margin-top: 140px;">
							EXAMEN DE
							<br><br>
							ADMISIÓN 2022-I
							<br><br>
							26 - 27 DE MARZO
						</div>
					</div>
					</li>
					{{-- <li data-transition="fade" data-slotamount="5" data-masterspeed="1000" data-title="Slide 1">
						<img src="/page/img/home/slider/slider.png" alt="slidebg1" data-bgfit="cover" data-bgposition="center center" data-bgrepeat="no-repeat">
						<div class="slider-caption container">
							<div class="tp-caption rs-caption-1 sft start text-center"
								data-hoffset="0"
								data-x="center"
								data-y="130"
								data-speed="800"
								data-start="1000"
								data-easing="Back.easeInOut"
								data-endspeed="1000"
								style="margin: 15px">
								<a href="https://admisionunasam.com/extraordinario2#menu6" target="_blank"><img  height="80" width="300" src="/page/img/logo-licenciado.png"></a>
							</div>
							<div class="tp-caption rs-caption-3 sft text-center"
								data-hoffset="0"
								data-x="center"
								data-y="110"
								data-speed="1000"
								data-start="1500"
								data-easing="Power4.easeOut"
								data-endspeed="300"
								data-endeasing="Power1.easeIn"
								data-captionhidden="off"
								style="
								font-size: 30px !important;
								color: #222222;
								font-weight: 700;
								font-family: 'Arial black',sans-serif;
								letter-spacing: -1px;
								text-shadow: -2px -2px 4px #fff, 2px 2px 4px #fff, -2px 2px 4px #fff, 2px -2px 4px #fff;
								margin-top: 140px;">
								ADMISIÓN 2022-I
							</div>
						</div>
					</li>--}}
					@endfor
			</ul>
		</div>
	</div>
</section>
<!-- MAIN CONTENT -->
<section class="clearfix linkSection">
	<div class="sectionLinkArea scrolling">
		<div class="container">
			<div class="row" style="margin-bottom: -80px;">
				<div class="col-sm-3" style="margin-top: 15px; margin-bottom: -15px;">
					<a href="/carreras" class="sectionLink bg-color-1" id="newsLink">
						<i class="fa fa-graduation-cap linkIcon border-color-1" aria-hidden="true"></i>
						<span class="linkText">Carreras</span>
						<i class="fa fa-chevron-down locateArrow" aria-hidden="true"></i>
					</a>
				</div>
				<div class="col-sm-3" style="margin-top: 15px; margin-bottom: -15px;">
					<a href="/temario" class="sectionLink bg-color-4" id="newsLink">
						<!--<i class="fa fa-files-o linkIcon border-color-4" aria-hidden="true"></i>fa-book-->
						<i class="fa fa-book linkIcon border-color-4" aria-hidden="true"></i>
						<span class="linkText">Temario</span>
						<i class="fa fa-chevron-down locateArrow" aria-hidden="true"></i>
					</a>
				</div>
				<div class="col-sm-3" style="margin-top: 15px; margin-bottom: -15px;">
					<a href="http://127.0.0.1:8000/login" class="sectionLink bg-color-3" id="galleryLink" target="_blank">
						<i class="fa fa-pencil-square-o  linkIcon border-color-3" aria-hidden="true"></i>
						<span class="linkText">Inscripciones</span>
						<i class="fa fa-chevron-down locateArrow" aria-hidden="true"></i>
					</a>
				</div>
				<div class="col-sm-3" style="margin-top: 15px; margin-bottom: -15px;">
					<a href="/resultados" class="sectionLink bg-color-2" id="teamLink">
						<i class="fa fa-file-text-o linkIcon border-color-2" aria-hidden="true"></i>
						<span class="linkText">Resultados</span>
						<i class="fa fa-chevron-down locateArrow" aria-hidden="true"></i>
					</a>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- FEATURE SECTION -->
<section class="mainContent full-width clearfix featureSection" style="padding-bottom: 0px">
	<div class="container">
		<div class="sectionTitle text-center">
			<h2>
				<span class="shape shape-left bg-color-4"></span>
				<span>Proceso de Admisión 2022-I</span>
				<span class="shape shape-right bg-color-4"></span>
			</h2>
		</div>
		<div class="row">
			<div class="col-sm-4 col-xs-12">
				<div class="media featuresContent">
					<span class="media-left bg-color-1">
						<i class="fa fa-graduation-cap bg-color-1" aria-hidden="true"></i>
					</span>
					<div class="media-body">
						<h3 class="media-heading color-1">
							<a href="/requisitos/vacante" titulo="VACANTES 2022-I" ccolor="#ea7066" class="color-1 abrirModal">Vacantes</a>
						</h3>
						<p>Lista de Vacantes del Proceso de Admisión <b>2022-I</b>, para sus 25 carreras en todas sus modalidades.</p>
					</div>
				</div>
			</div>
			<div class="col-sm-4 col-xs-12">
				<div class="media featuresContent">
					<span class="media-left bg-color-2">
						<i class="fa fa-calendar bg-color-2" aria-hidden="true"></i>
					</span>
					<div class="media-body">
						<h3 class="media-heading color-2">
							<a href="/requisitos/cronograma" class="color-2 abrirModal" titulo="CRONOGRAMA DE ADMISIÓN 2022-I" ccolor="#ea7066">Cronograma</a>
						</h3>
						<p>Actividades a desarrollarse en el Proceso de Admisión <b>2022-I</b> de la Unasam.</p>
					</div>
				</div>
			</div>
			<div class="col-sm-4 col-xs-12">
				<div class="media featuresContent">
					<span class="media-left bg-color-3">
						<i class="fa fa-money bg-color-3" aria-hidden="true"></i>
					</span>
					<div class="media-body">
						<h3 class="media-heading color-3">
							<a href="/requisitos/pagos" class="color-3 abrirModal" titulo="PAGOS DE INSCRIPCIÓN" ccolor="#ea7066">Pagos</a>
						</h3>
						<p>Costos de inscripción para todas las modalidades aprobadas en el TUPA de la Unasam.</p>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-4 col-xs-12">
				<div class="media featuresContent">
					<span class="media-left bg-color-4">
						<!--<i class="fa fa-th bg-color-4" aria-hidden="true"></i> fa fa-book-->
						<i class="fa fa-question bg-color-4" aria-hidden="true"></i>

					</span>
					<div class="media-body">
						<h3 class="media-heading color-4"><a href="/requisitos/pregunta" class="color-4 abrirModal" titulo="PREGUNTAS" ccolor="#ea7066">Distribución de Preguntas</a></h3>
						<p>La distribución de preguntas de cada curso y área académica según el área A, B, C y D.</p>
					</div>
				</div>
			</div>
			<div class="col-sm-4 col-xs-12">
				<div class="media featuresContent">
					<span class="media-left bg-color-1">
						<!--<i class="fa fa-list-ol bg-color-1" aria-hidden="true"></i>-->
						<i class="fa fa-book bg-color-1" aria-hidden="true"></i>
					</span>
					<div class="media-body">
						<h3 class="media-heading color-1"><a href="/temario" class="color-1">Temario</a></h3>
						<p>Contenido de los temas de cada uno de los cursos en las áreas académicas que entren en los exámenes.</p>
					</div>
				</div>
			</div>
			<!--<div class="col-sm-4 col-xs-12">
				<div class="media featuresContent">
					<span class="media-left bg-color-5">
						<i class="fa fa-video-camera bg-color-5" aria-hidden="true"></i>
					</span>
					<div class="media-body">
						<h3 class="media-heading color-5">
							<a href="https://www.youtube.com/watch?v=IUl5XMfVnxo" target="_blank" class="color-5">Video Tutorial</a>
						</h3>
						<p>Si quieres saber como inscribirte mira y sigue las instrucciones del <a href="https://www.youtube.com/watch?v=IUl5XMfVnxo" title="Video Tutorial" target="_blank">Video Tutorial</a> o la <a href="http://bit.ly/2SE4tuT" title="Manual" target="_blank">Guía</a> de inscripción.</p>
					</div>
				</div>
			</div>-->
		</div>
		<div class="row">
			{{--<div class="col-sm-4 col-xs-12">
				<div class="media featuresContent">
					<span class="media-left bg-color-2">
						<i class="fa fa-file-text-o bg-color-2" aria-hidden="true"></i>
					</span>
					<div class="media-body">
						<h3 class="media-heading color-2">
							<a href="/extraordinario2#menu6" target="_blank" class="color-2">Traslado Externo Especial</a>
						</h3>
						<p>Esta modalidad es ofertada para los alumnos de Universidades con Licencia Denegada.</p>
					</div>
				</div>
			</div>--}}
			<div class="col-sm-4 col-xs-12">
				<div class="media featuresContent">
					<span class="media-left bg-color-2">
						<!--<i class="fa fa-eye bg-color-4" aria-hidden="true"></i>
						fas fa-file-contract-->
						<i class="fa fa-file-text-o bg-color-2" aria-hidden="true"></i>

					</span>
					<div class="media-body">
						<h3 class="media-heading color-2"><a href="/resultados" class="color-2">Resultados</a></h3>
						<p> Aquí podrás encontrar los resultados por las diferentes modalidades del proceso 2021-II.</p>
					</div>
				</div>
			</div>
			<div class="col-sm-4 col-xs-12">
				<div class="media featuresContent">
					<span class="media-left bg-color-6">
						<!--<i class="fa fa-file-pdf-o bg-color-6" aria-hidden="true"></i>-->
						<i class="fa fa-copy bg-color-6" aria-hidden="true"></i>

					</span>
					<div class="media-body">
						<h3 class="media-heading color-6"><a href="/examenes" class="color-6">Exámenes</a></h3>
						<p>Aquí puedes encontrar los exámenes de los procesos de admisión anteriores, descárgalos en pdf.</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- WHITE SECTION -->
<section class="whiteSection full-width clearfix coursesSection" style="padding-top: 0px" id="ourCourses">
	<div class="container">
		<div class="sectionTitle text-center">
			<h2>
				<span class="shape shape-left bg-color-4"></span>
				<span>Modalidades y Requisitos de Ingreso</span>
				<span class="shape shape-right bg-color-4"></span>
			</h2>
		</div>
		<div class="row">
			<div class="col-sm-3 col-xs-12 block">
				<div class="thumbnail thumbnailContent">
					<a href="reglamento-pregrado"><img src="/page/img/home/courses/course-1.jpg" alt="image" class="img-responsive"></a>
					<a>
						<div class="sticker bg-color-1 abrirModal" href="/requisitos/ordinario" text-align="center" ccolor="#ea7066" titulo="Requisitos Ordinario" align="center"><i class="fa fa-file-text-o bg-color-1" aria-hidden="true"></i>
						</div>
					</a>
					<a>
						<div class="sticker bg-color-1 abrirModal" href="/requisitos/ordinario" titulo="Requisitos Ordinario" ccolor="#ea7066" align="center"><i class="fa fa-file-text-o bg-color-1" aria-hidden="true"></i>
						</div>
					</a>
					<div class="caption border-color-1">
						<h3><a class="color-1">Modalidad <br>Ordinario</a></h3>
						<ul class="list-unstyled">
							<li class="color-1">INSCRIPCIONES (Virtual)</li>
							<li><i class="fa fa-calendar-o" aria-hidden="true"></i>Desde el 24 de enero al 18 de marzo de 2022</li>
						</ul>
						<b>Tipo de Examen: Presencial</b><br>
						<b>Días del Examen: 26 (Área A y B) - 27 (Área C y D) de Octubre.</b>
						<p>En este examen pueden postular sólo los alumnos que hayan culminado el 5to año de educación secundaria. </p>
						{{-- <p>En este examen 2022-I puede postular cualquier persona natural, <b style="color: #47d285;">PUEDEN PARTICIPAR</b> los alumnos que se encuentren cursando el <b>5to año de educación secundaria</b>. </p>--}}
						<ul class="list-inline btn-yellow">
							<li>
								<a href="/requisitos/ordinario" class="btn btn-primary abrirModal" titulo="Requisitos Ordinario" ccolor="#ea7066">
									<i class="fa fa-edit" aria-hidden="true"></i>Ver Requisitos
								</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="col-sm-3 col-xs-12 block">
				<div class="thumbnail thumbnailContent">
					<a href="/reglamento-pregrado"><img src="/page/img/home/courses/course-2.jpg" alt="image" class="img-responsive"></a>
					<a href="/extraordinario2">
						<div class="sticker bg-color-2"><i class="fa fa-file-text-o bg-color-2" aria-hidden="true"></i></div>
					</a>
					<div class="caption border-color-2">
						<h3><a style="color: #47d285;">Modalidad <br>Extraordinario II</a></h3>
						<ul class="list-unstyled">
							<li style="color: #47d285;">INSCRIPCIONES (Virtual)</li>
							<li><i class="fa fa-calendar-o" aria-hidden="true"></i>Desde el 24 de enero al 15 de marzo de 2022</li>
						</ul>
						<b>Tipo de Examen: Presencial</b><br>
						<b>Día del Examen: 13 y 20 de Marzo.</b>
						<p>En este examen participan todas las modalidades estipuladas en el reglamento previa presentación de los requisitos. Enviar al correo <b>unasam.admision@gmail.com</b></p>
						<ul class="list-inline btn-green">
							<li><a href="/extraordinario2" class="btn btn-primary ">
									<i class="fa fa-edit" aria-hidden="true"></i>
									</i>Ver Requisitos</a></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="col-sm-3 col-xs-12 block">
				<div class="thumbnail thumbnailContent">
					<a href="reglamento-pregrado"><img src="/page/img/home/courses/course-3.jpg" alt="image" class="img-responsive"></a>
					<a href="/requisitos/cpu" titulo="Requisitos CPU" ccolor="#ea7066" class="abrirModal">
						<div class="sticker bg-color-3 "><i class="fa fa-file-text-o bg-color-3" aria-hidden="true"></i></div>
					</a>
					<div class="caption border-color-3">
						<h3><a class="color-3">Centro <BR> Pre-Universitario</a></h3>
						<ul class="list-unstyled">
							<li class="color-3">CICLO INTENSIVO 2022</li>
							<li><i class="fa fa-calendar-o" aria-hidden="true"></i>
								Las fechas seran programadas de acuerdo al cronograma de CPU.</li>
						</ul>
						<b>Tipo de Examen: Presencial</b><br>
						<b>Día del Examen: 06 de Febrero y 06 de Marzo.</b>
						<p>En esta modalidad los alumnos brindan dos exámenes durante su proceso de enseñanza y aquellos que logren obtener una vacante su inscripción es presencial. </p>
						<ul class="list-inline btn-red">
							<li>
								<a href="/requisitos/cpu" titulo="Requisitos CPU" ccolor="#ea7066" class="btn btn-primary abrirModal"><i class="fa fa-edit" aria-hidden="true"></i>Ver Requisitos</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="col-sm-3 col-xs-12 block">
				<div class="thumbnail thumbnailContent">
					<a href="/reglamento-pregrado"><img src="/page/img/home/courses/course-4.jpg" alt="image" class="img-responsive"></a>
					<a href="/requisitos/convenio" titulo="Convenio Comunidades Campesinas" ccolor="#ea7066" class="convenio">
						<div class="sticker bg-color-4">
							<i class="fa fa-file-text-o bg-color-4" aria-hidden="true"></i>
						</div>
					</a>
					<div class="caption border-color-4">
						<h3>
							<a class="color-4">Convenio Comunidades <BR>Campesinas</a>
						</h3>
						<ul class="list-unstyled">
							<li class="color-4">CICLO DE NIVELACION</li>
							<li>
								<i class="fa fa-calendar-o" aria-hidden="true"></i>Las fechas seran programadas de acuerdo al cronograma de CPU.
							</li>
						</ul>
						<b>Tipo de Examen: Presencial</b><br>
						<b>Día del Examen: Programado para el año 2022.</b>
						<p>Esta modalidad solo están incluidas las comunidades campesinas que tienen convenio con la Unasam. Solo se realiza en el <b>primer proceso</b> de admisión de cada año.
						</p>
						<ul class="list-inline btn-sky">
							<li><a href="/requisitos/comunidades" titulo="Convenio Comunidades Campesinas" ccolor="#ea7066" class="btn btn-primary abrirModal"><i class="fa fa-edit" aria-hidden="true"></i>Ver Requisitos</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	</div>
</section>
<!-- COLOR SECTION -->
<section class="colorSection full-width clearfix bg-color-5 teamSection" id="ourTeam">
	<div class="container">
		<div class="sectionTitle text-center alt">
			<h2>
				<span class="shape shape-left bg-color-3"></span>
				<span>Comisión Central de Admisión 2022-I</span>
				<span class="shape shape-right bg-color-3"></span>
			</h2>
		</div>
		<div class="row">
			<div class="col-xs-12">
				<div class="owl-carousel teamSlider">
					{{--<div class="slide">
						<div class="teamContent">
							<div class="teamImage">
								<img src="/page/img/cca/jefe.png" alt="img" class="img-circle">
								<div class="maskingContent">
									<ul class="list-inline">
									</ul>
								</div>
							</div>
							<div class="teamInfo">
								<br><h3><a href="#" style="color: white;">Dr. Miguel Ángel Ramírez Guzmán</a></h3>
								<p>Jefe de la OGAD</p>
							</div>
						</div>
					</div>--}}
					{{--<div class="slide">
						<div class="teamContent">
							<div class="teamImage">
								<img src="page/img/cca/miembro1.png" alt="img" class="img-circle">
								<div class="maskingContent">
									<ul class="list-inline">
									</ul>
								</div>
							</div>
							<div class="teamInfo">
								<br><h3><a href="#">Dr. Julio Arturo Henostroza Torres</a></h3>
								<p>Presidente de la CCA</p>
							</div>
						</div>
					</div>--}}
					<div class="slide">
						<img src="page/img/cca/miembro1.png" alt="img" class="img-circle">
						<ul class="list-inline"></ul>
						<div class="teamInfo">
							<br>
							<h3><a href="#" style="color:white;">Dr. Julio Arturo Henostroza Torres</a></h3>
							<p>Presidente de la CCA</p>
						</div>
					</div>
					<div class="slide">
						<div class="teamContent">
							<div class="teamImage">
								<img src="page/img/cca/segundomiembro.png" alt="img" class="img-circle">
								<div class="maskingContent">
									<ul class="list-inline">
									</ul>
								</div>
							</div>
							<div class="teamInfo">
								<br>
								<h3><a href="#">Dr. Toribio Marcos Reyes Rodríguez </a></h3>
								<p>Miembro de la CCA</p>
							</div>
						</div>
					</div>
					<div class="slide">
						<div class="teamContent">
							<div class="teamImage">
								<img src="page/img/cca/tercermiembro.png" alt="img" class="img-circle">
								<div class="maskingContent">
									<ul class="list-inline">
									</ul>
								</div>
							</div>
							<div class="teamInfo">
								<br>
								<h3><a href="#">Mag. Pepe Zenobio Melgarejo Barreto</a></h3>
								<p>Miembro de la CCA</p>
							</div>
						</div>
					</div>
					<div class="slide">
						<div class="teamContent">
							<div class="teamImage">
								<img src="page/img/cca/mestudiante1.png" alt="img" class="img-circle">
								<div class="maskingContent">
									<ul class="list-inline">
									</ul>
								</div>
							</div>
							<div class="teamInfo">
								<br>
								<h3><a href="#">Alum. Guissell Verónica Ramírez Chávez</a></h3>
								<p>Miembro de la CCA</p>
							</div>
						</div>
					</div>
					<div class="slide">
						<div class="teamContent">
							<div class="teamImage">
								{{--<img src="page/img/cca/miembro4.png" alt="img" class="img-circle">--}}
								<div class="maskingContent">
									<ul class="list-inline">
									</ul>
								</div>
							</div>
							<div class="teamInfo">
								<br>
								<h3><a href="#">--</a></h3>
								<p>Miembro de la CCA</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="hidden">
		<a id="iniciarModal" href="/requisitos/alert_vigilante" titulo="COMUNICADO" ccolor="#ea7066" class="color-1">Iniciar Ventana</a>
	</div>
</section>

@endsection
@section('scriptspage')
<script src="page/plugins/bootbox/bootbox.min.js"></script>
<script>
	showModal('.abrirModal', 'large');
	showModal('.convenio', 'medium');

	$(document).ready(function() {
		ejecutarAxios('#iniciarModal', 'medium');
	});
</script>
@endsection