@extends('layouts.appPage')
@section('title')
<title>Extraordinario II</title>
<style type="text/css">
	table,
	td,
	th {
		border: 1px solid black;
		border-collapse: collapse;
		padding: 10px;
		text-align: center;
		color: #000;
	}

	.academico {
		background-color: #f8d8dd;
		color: #000;
	}

	.matematica {
		background-color: #ffd381;
		color: #000;
	}

	.comunicacion {
		background-color: #d9ffa0;
		color: #000;
	}

	.cgeneral {
		background-color: #ffcff6;
		color: #000;
	}

	.sociales {
		background-color: #ddb87d;
		color: #000;
	}

	.tecnologia {
		background-color: #cef2f0;
		color: #000;
	}

	.negro {
		color: #000;
	}

	a.disabled {
		pointer-events: none;
		cursor: default;
	}

	div.oculto {
		display: none;
		visibility: hidden;
	}
</style>
@endsection
@section('contentpage')
<!-- PAGE TITLE SECTION-->
<section class="pageTitleSection">
	<div class="container">
		<div class="pageTitleInfo">
			<h2>Extraordinario - Admisión UNASAM</h2>
			<ol class="breadcrumb">
				<li><a href="http://admision.unasam.edu.pe">Admisión</a></li>
				<li class="active">Estraordinario II</li>
			</ol>
		</div>
	</div>
</section>
<!-- PRODUCT SECTION -->
<section class="mainContent full-width clearfix">
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<div class="sectionTitle text-center">
					<h2>
						<span class="shape shape-left bg-color-4"></span>
						<span>MODALIDADES DE INGRESO A LA UNASAM</span>
						<span class="shape shape-right bg-color-4"></span>
					</h2>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-xs-12">
				<div id="tabCommon" class="tabCommon">
					<ul class="nav nav-tabs">
						<li class="active"><a style="width: 267px;" data-toggle="tab" val="0" href="#home">1RO y 2DO PUESTOS</a></li>
						<li><a style="width: 267px;" data-toggle="tab" val="1" href="#menu1">DEPORTISTAS CALIFICADOS</a></li>
						<li><a style="width: 267px;" data-toggle="tab" val="2" href="#menu2">PERSONAS CON DISCAPACIDAD</a></li>
						<li><a style="width: 267px;" data-toggle="tab" val="3" href="#menu3">TITULADOS Y GRADUADOS</a></li>
						<li style="padding-top: 20px;"><a style="width: 267px;" data-toggle="tab" val="4" href="#menu4">TRASLADO INTERNO</a></li>
						<li style="padding-top: 20px;"><a style="width: 267px;" data-toggle="tab" val="5" href="#menu5">TRASLADO EXTERNO</a></li>
						<!--<li style="padding-top: 20px;"><a style="width: 267px;" data-toggle="tab" val="6" href="#menu6">TRASLADO EXTERNO ESPECIAL</a></li>-->
						<li style="padding-top: 20px;"><a style="width: 267px;" data-toggle="tab" val="7" href="#menu7">VICTIMAS DE TERRORISMO</a></li>
					</ul>
					<div class="tab-content">
						{{-- <div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12">
								<div class="product-info">
									<h3 class="product-title" style="color: #ea7066;font-size:34px; margin-bottom: 15px;" align="center">Requisitos Mínimos para un Examen Virtual</h3>
									<p align="justify" style="color: #000000;">
										El postulante debe contar obligatoriamente con los siguiente requisitos mínimos:<br>
										<i class="fa fa-check" aria-hidden="true" style="color: #ea7066;margin-bottom: 7px;margin-top: -34px;"></i> 
										Conexión a Internet vía cable de red (de preferencia) o vía Wifi.<br>
										<i class="fa fa-check" aria-hidden="true" style="color: #ea7066;margin-bottom: 7px;margin-top: -34px;"></i>
											Ancho de banda como mínimo de 4Mbps.<br>
										<i class="fa fa-check" aria-hidden="true" style="color: #ea7066;margin-bottom: 7px;margin-top: -34px;"></i>
											Laptop o computadora.<br>
										<i class="fa fa-check" aria-hidden="true" style="color: #ea7066;margin-bottom: 7px;margin-top: -34px;"></i>
											Cámara web o webcam con resolución mínima de 640x480 pixeles (indispensable para corroborar la identidad del postulante).<br>
										<i class="fa fa-check" aria-hidden="true" style="color: #ea7066;margin-bottom: 7px;margin-top: -34px;"></i>
											Un micrófono.<br>
											<i class="fa fa-check" aria-hidden="true" style="color: #ea7066;margin-bottom: 7px;margin-top: -34px;"></i>
											Sistema operativo Windows, Mac OS, iOS.<br>
										<i class="fa fa-check" aria-hidden="true" style="color: #ea7066;margin-bottom: 7px;margin-top: -34px;"></i>
											Navegador Google Chrome (de preferencia), Firefox, Opera, Safari.<br>				
									</p>            
								</div>
							</div>
						</div> --}}
						<div id="home" class="tab-pane fade in active">
							<div class="media">
								<div>
									<div class="media-left">
										<a href="/normas-legales"></a><br>&nbsp&nbsp&nbsp&nbsp
										<img class="img-rounded" style="width: 230px;height:230px;" src="/page/img/extraordinarioii/primeros-puestos.jpg">
										<div class="product-info">
											<center>
												<h5><br><b class="color-3 media-heading">DESCARGAR REGLAMENTO</b></h5>
												<a href="https://drive.google.com/file/d/17-DURyUbWV8bSJfyqK4EaZuvBsSb-rgq/view" class="btn btn-warning" target="_blank" text-align="center" margin="0 auto" style="width: 210px;height:50px;">
													<i class="fa fa-cloud-download"></i> REGLAMENTO
												</a><br>
											</center>
										</div>
									</div>
									<div class="media-body" align="justify">
										<h1 class="media-heading" align="center"><u>1er y 2do PUESTOS</u></h1>
										En esta modalidad parcipan todos los alumnos que ocuparon solo los dos primeros puestos tanto para colegios particulares como estatales, previo pago por la modalidad a postular. <br><br>
										Por esta modalidad tambien participan los alumnos que terminarion en los Colegios Mayor Secundario Presidente del Perú, la inscripción es de forma presencial en la Oficina General de Admisión en los horarios de oficina. <br>
										<b class="color-3">TIPO DE EXAMEN:</b> PRESENCIAL.<br>
										<b class="color-3">FECHA DE EXAMEN:</b> 20 de Marzo del 2022.<br>
										<b class="color-3">RESPUESTA CORRECTA:</b> 4.0 Puntos.<br>
										<b class="color-3">RESPUESTA SIN RESPONDER:</b> 0.0 Puntos.<br>
										<b class="color-3">RESPUESTA INCORRECTA:</b> -0.5 Puntos.<br>
										<b class="color-3">CANTIDAD DE PREGUNTAS:</b> 100.<br>
										<b class="color-3">PUNTAJE MÍNIMO:</b> 100.00 Puntos.<br>
										<b class="color-3">DURACIÓN:</b> 03 Horas.<br>
									</div>
								</div>
							</div>
							<div class="modal-body">
								<div class="row">
									<div class="col-md-6 col-sm-5 col-xs-12">
										<div class="media" align="justify">
											<h3 class="media-heading" style="color: #ea7066;" align="center">
												<b><u>REQUISITOS DEL POSTULANTE PARA PRIMEROS PUESTOS</u></b>
											</h3><br>
											<ul class="list-unstyled para-list">
												<li>
													<i class="fa fa-check" aria-hidden="true" style="color: #ea7066;margin-bottom: 7px;margin-top: -34px;"></i>
													Comprobante de pago efectuado en el banco de la Nación al código de operación <b>N°01774</b> con el número de <b>DNI</b> del postulante.<br>
													- Colegio nacional <b>S/. 300</b><br>
													- Colegio particular <b>S/.350</b>
												</li>
												<li>
													<i class="fa fa-check" aria-hidden="true" style="color: #ea7066;margin-bottom: 7px;margin-top: -34px;"></i>
													Fotografía del Documento Nacional de Identidad <b><a href="/r_ejemplos/dni" class="color-3 abrirEjemplo">(DNI)</a></b>.
												</li>
												<li>
													<i class="fa fa-check" aria-hidden="true" style="color: #ea7066;"></i>
													Fotografía medio cuerpo de frente, en formato digital en <b>CD o USB</b>, tamaño <b><a href="/r_ejemplos/foto" class="color-3 abrirFoto">JUMBO (400x600 px)</a></b>, sin retoques, sin lentes, a colores y con fondo blanco.
												</li>
												<li>
													<i class="fa fa-check" aria-hidden="true" style="color: #ea7066;"></i>
													<b>Copia de certificados de estudios del 1° al 5° año de educación secundaria
														con calificaciones aprobatorias</b>, con nombres y apellidos según su partida de
													nacimiento, e indicando su respectivo orden de mérito, emitido por el colegio
													donde estudió y <b>visado por la UGEL</b> correspondiente o Constancia de <b>Logros
														de Aprendizaje</b>
												</li>
												<li>
													<i class="fa fa-check" aria-hidden="true" style="color: #ea7066;"></i>
													Copia de Resolución o Acta que acredite haber ocupado el primero o segundo
													puesto del orden de mérito de los cinco <b>(05) años de estudios</b> emitida por la
													Institución Educativa de la que proceden y <b>visado por la UGEL correspondiente</b>.
												</li>
												<li>
													<i class="fa fa-check" aria-hidden="true" style="color: #ea7066;"></i>
													Los egresados del Colegio Mayor Secundario Presidente del Perú deben presentar
													una <b>copia de constancia de egresado, emitido por el Director del CMSP-COAR.</b>
											</ul>
											<div class="product-info">
												<center>
													<a href="/login" class="btn btn-success" target="_blank" text-align="center">
														<i class="fa fa-laptop"></i> INSCRIPCIÓN
													</a>
												</center>
											</div><br>
										</div>
									</div>
									<div class="col-md-6 col-sm-5 col-xs-12" align="justify">
										<h3 class="media-heading" style="color: #ea7066;" align="center"><b><u>REQUISITOS DEL INGRESANTE</u></b></h3><br>
										<ul class="list-unstyled para-list">
											<li>
												<i class="fa fa-check" aria-hidden="true" style="color: #ea7066;"></i>
												<b>Copia de certificados de estudios del 1° al 5° año de educación secundaria
													con calificaciones aprobatorias</b>, con nombres y apellidos según su partida de
												nacimiento, e indicando su respectivo orden de mérito, emitido por el colegio
												donde estudió y <b>visado por la UGEL</b> correspondiente o Constancia de <b>Logros
													de Aprendizaje</b>
											</li>
											<li><i class="fa fa-check" aria-hidden="true" style="color: #ea7066;">
												</i> Partida de Nacimiento <b>(original sin deterioro ni enmendaduras).</b></li>
											<li><i class="fa fa-check" aria-hidden="true" style="color: #ea7066;">
												</i> Copia de <b>DNI legalizada.</b></li>
											<li><i class="fa fa-check" aria-hidden="true" style="color: #ea7066;">
												</i> Certificado judicial de antecedentes penales para <b>MAYORES DE EDAD (Poder Judicial)</b> y para los <b>MENORES DE EDAD una Declaración Jurada simple</b> de no tener Antecedentes Penales, adjuntar copia simple del Documento de Identidad del padre o apoderado que firma el documento (El formato lo puede descargar de la página web <b>admision.unasam.edu.pe</b>).</li>
											<li><i class="fa fa-check" aria-hidden="true" style="color: #ea7066;">
												</i> Pago por Constancia de Ingreso <b>S/.20.00</b> al Banco de la Nación al <b>código N° 01774</b>, con el número de <b>DNI del Ingresante.</b></li>
										</ul>
										<div class="product-info">
											<center><a href="http://bit.ly/37hwQTQ" class="btn btn-info" target="_blank" text-align="center">
													<i class="fa fa-cloud-download"></i> DECLARACIÓN JURADA
												</a>
											</center>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div id="menu1" class="tab-pane fade">
							<div class="media">
								<div class="media-left">
									<center>
										<a href="/normas-legales"></a><br>&nbsp&nbsp&nbsp&nbsp
										<img class="img-rounded" style="width: 230px;height:230px;" src="/page/img/extraordinarioii/deportista.jpg">
										<h5><br><b class="color-3 media-heading">DESCARGAR REGLAMENTO</b></h5>
										<a href="https://drive.google.com/file/d/17-DURyUbWV8bSJfyqK4EaZuvBsSb-rgq/view" class="btn btn-warning" target="_blank" text-align="center" margin="0 auto" style="width: 210px;height:50px;">
											<i class="fa fa-cloud-download"></i> REGLAMENTO
										</a><br>
									</center>
								</div>
								<div class="media-body" align="justify">
									<h1 class="media-heading" align="center"><u>DEPORTISTAS CALIFICADOS</u></h1>
									De acuerdo a la ley N°28036 Art.21 Las Universidades, Institutos Superiores y Escuelas de las Fuerzas Armadas y Policía Nacional del Perú deberán estipular en sus Estatutos y Reglamentos normas promocionales para la incorporación de deportistas calificados de alto nivel a sus respectivos centros de estudios previa evaluación especial a propuesta de su respectiva Federación Nacional y con la aprobación del Instituto Peruano del Deporte. <br><br>
									Los postulantes que se inscriben al concurso de admisión programado por la UNASAM deben realizar su inscripción en forma presencial en la Oficina General de Admisión.<br>
									<b class="color-3">TIPO DE EXAMEN:</b> PRESENCIAL.<br>
									<b class="color-3">FECHA DE EXAMEN:</b> 20 de Marzo del 2022.<br>
									<b class="color-3">RESPUESTA CORRECTA:</b> 4.0 Puntos.<br>
									<b class="color-3">RESPUESTA SIN RESPONDER:</b> 0.0 Puntos.<br>
									<b class="color-3">RESPUESTA INCORRECTA:</b> -0.5 Puntos.<br>
									<b class="color-3">CANTIDAD DE PREGUNTAS:</b> 100.<br>
									<b class="color-3">PUNTAJE MÍNIMO:</b> 100.00 Puntos.<br>
									<b class="color-3">DURACIÓN:</b> 03 Horas.<br>
								</div>
							</div>
							<div class="modal-body">
								<div class="row">
									<div class="col-md-6 col-sm-5 col-xs-12">
										<div class="media" align="justify">
											<h3 class="media-heading" style="color: #ea7066;" align="center">
												<u>REQUISITOS DEL POSTULANTE PARA DEPORTISTAS CALIFICADOS</u>
											</h3>
											<ul class="list-unstyled para-list">
												<li>
													<i class="fa fa-check" aria-hidden="true" style="color: #ea7066;"></i>
													Comprobante de pago efectuado en el Banco de la Nación al código de operación <b>N° 01774</b> con el número de <b>DNI</b> del postulante con el importe de <b>S/. 350</b>.
												</li>
												<li>
													<i class="fa fa-check" aria-hidden="true" style="color: #ea7066;"></i>
													Constancia original del <b>Instituto Peruano del Deporte (IPD)</b>
													que lo acredite como <b>deportista calificado (DC)</b>
													o deportista calificado de <b>alto nivel (DECAN)</b>.
												</li>
												<li>
													<i class="fa fa-check" aria-hidden="true" style="color: #ea7066;"></i>
													Constancia de tener <b>actividad deportiva permanente en la disciplina</b>, con un
													tiempo mínimo de dos (02) años anteriores a la postulación, emitida por el
													<b>IPD</b>.
												</li>
												<li>
													<i class="fa fa-check" aria-hidden="true" style="color: #ea7066;"></i>
													Constancia del <b>Instituto Peruano del Deporte (IPD)</b> de no haber sido
													sancionado por <b>faltas graves o prácticas antideportivas</b>
												</li>
												<li>
													<i class="fa fa-check" aria-hidden="true" style="color: #ea7066;"></i>
													Carta de compromiso para participar en representación de su <b>escuela
														profesional o de la UNASAM</b>.
												</li>
												<li>
													<i class="fa fa-check" aria-hidden="true" style="color: #ea7066;margin-bottom: 7px;margin-top: -34px;"></i>
													Fotografía del Documento Nacional de Identidad <b><a href="/r_ejemplos/dni" class="color-3 abrirEjemplo">(DNI)</a></b>.
												</li>
												<li>
													<i class="fa fa-check" aria-hidden="true" style="color: #ea7066;"></i>
													Fotografía medio cuerpo de frente, en formato digital en <b>CD o USB</b>, tamaño <b><a href="/r_ejemplos/foto" class="color-3 abrirFoto">JUMBO (400x600 px)</a></b>, sin retoques, sin lentes, a colores y con fondo blanco.
												</li>
											</ul>
											<div class="product-info">
												<center>
													<a href="/login" class="btn btn-success" target="_blank" text-align="center">
														<i class="fa fa-laptop"></i> INSCRIPCIÓN
													</a>
												</center><br><br>
											</div>
										</div>
									</div>
									<div class="col-md-6 col-sm-5 col-xs-12" align="justify">
										<h3 class="media-heading" style="color: #ea7066;" align="center">
											<u>REQUISITOS DEL INGRESANTE DEPORTISTAS CALIFICADOS</u>
										</h3>
										<ul class="list-unstyled para-list">
											<li><i class="fa fa-check" aria-hidden="true" style="color: #ea7066;"></i>
												<b>Copia de certificados de estudios del 1° al 5° año de educación secundaria
													con calificaciones aprobatorias</b>, con nombres y apellidos según su partida de
												nacimiento, e indicando su respectivo orden de mérito, emitido por el colegio
												donde estudió y <b>visado por la UGEL</b> correspondiente o Constancia de <b>Logrosde Aprendizaje</b>
											</li>
											<li><i class="fa fa-check" aria-hidden="true" style="color: #ea7066;">
												</i> Certificado de estudios <b>(visado por la ugel).</b></li>
											<li><i class="fa fa-check" aria-hidden="true" style="color: #ea7066;">
												</i> Partida de nacimiento<b>(original sin deterioro ni enmendaduras)</b>.</li>
											<li><i class="fa fa-check" aria-hidden="true" style="color: #ea7066;">
												</i> Copia del <b>DNI</b> del postulante <b>legalizada.</b></li>
											<li>
												<i class="fa fa-check" aria-hidden="true" style="color: #ea7066;"></i>
												Constancia original del <b>Instituto Peruano del Deporte (IPD)</b>
												que lo acredite como <b>deportista calificado (DC)</b>
												o deportista calificado de <b>alto nivel (DECAN)</b>.
											</li>
											<li>
												<i class="fa fa-check" aria-hidden="true" style="color: #ea7066;"></i>
												Constancia de tener <b>actividad deportiva permanente en la disciplina</b>, con un
												tiempo mínimo de dos (02) años anteriores a la postulación, emitida por el
												<b>IPD</b>.
											</li>
											<li>
												<i class="fa fa-check" aria-hidden="true" style="color: #ea7066;"></i>
												Constancia del <b>Instituto Peruano del Deporte (IPD)</b> de no haber sido
												sancionado por <b>faltas graves o prácticas antideportivas</b>
											</li>
											<li><i class="fa fa-check" aria-hidden="true" style="color: #ea7066;">
												</i> Carta de compromiso para participar en representación de su <b>ESCUELA PROFESIONAL</b> o <b>DE LA UNASAM.</b></li>
											<li><i class="fa fa-check" aria-hidden="true" style="color: #ea7066;">
												</i> Certificado Judicial de antecedentes penales <b>(PODER JUDICAL)</b> para <b>MAYORES</b> y para <b>MENORES DE EDAD</b> una declaración jurada más copia del dni del apoderado.</li>
											<li><i class="fa fa-check" aria-hidden="true" style="color: #ea7066;">
												</i> Voucher de pago de <b>S/ 20.00</b> al <b>BANCO DE LA NACIÓN</b> al código <b>01774</b>.</li>
										</ul>
										<div class="product-info">
											<center><a href="http://bit.ly/37hwQTQ" class="btn btn-info" target="_blank" text-align="center">
													<i class="fa fa-cloud-download"></i> DECLARACIÓN JURADA
												</a>
											</center>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div id="menu2" class="tab-pane fade">
							<div class="media">
								<center>
									<div class="media-left">
										<a href="/normas-legales"><br>&nbsp&nbsp&nbsp&nbsp
											<img class="img-rounded" style="width: 230px;height:230px;" src="/page/img/extraordinarioii/discapacidad.jpg">
										</a>
										<h5><br><b class="color-3 media-heading">DESCARGAR REGLAMENTO</b></h5>
										<a href="https://drive.google.com/file/d/17-DURyUbWV8bSJfyqK4EaZuvBsSb-rgq/view" class="btn btn-warning" target="_blank" text-align="center" margin="0 auto" style="width: 210px;height:50px;">
											<i class="fa fa-cloud-download"></i> REGLAMENTO
										</a><br>
									</div>
									<div class="media-body" align="justify">
										<h1 class="media-heading" align="center"><u>PERSONAS CON DISCAPACIDAD</u></h1>
										De acuerdo a la ley N°29973 Art.76 El certificado de discapacidad acredita la condición de persona con discapacidad. Es otorgado por todos los hospitales de los ministerios de Salud, de Defensa y del Interior y el Seguro Social de Salud (EsSalud). La evaluación, calificación y la certificación son gratuitas. <br>
										Los postulantes que se inscriben al concurso de admisión programado por la UNASAM deben realizar su inscripción en forma presencial en la Oficina General de Admisión.<br>
										<b class="color-3">TIPO DE EXAMEN:</b> PRESENCIAL.<br>
										<b class="color-3">FECHA DE EXAMEN:</b> 20 de Marzo del 2022.<br>
										<b class="color-3">RESPUESTA CORRECTA:</b> 4.0 Puntos.<br>
										<b class="color-3">RESPUESTA SIN RESPONDER:</b> 0.0 Puntos.<br>
										<b class="color-3">RESPUESTA INCORRECTA:</b> -0.5 Puntos.<br>
										<b class="color-3">CANTIDAD DE PREGUNTAS:</b> 100.<br>
										<b class="color-3">PUNTAJE MÍNIMO:</b> 100.00 Puntos.<br>
										<b class="color-3">DURACIÓN:</b> 03 Horas.<br>
									</div>
								</center>
							</div>
							<div class="modal-body">
								<div class="row">
									<div class="col-md-6 col-sm-5 col-xs-12">
										<div class="media" align="justify">
											<h3 class="media-heading" style="color: #ea7066;" align="center">
												<u>REQUISITOS DEL POSTULANTE PARA PERSONAS CON DISCAPACIDAD</u>
											</h3>
											<ul class="list-unstyled para-list">
												<li>
													<i class="fa fa-check" aria-hidden="true" style="color: #ea7066;"></i>
													Comprobante de pago efectuado en el banco de la Nación al código de operación <b>N°01774</b> con el número de <b>DNI</b> del postulante.<br>
													- Colegio nacional <b>S/. 300</b><br>
													- Colegio particular <b>S/.350</b>
												</li>
												<li>
													<i class="fa fa-check" aria-hidden="true" style="color: #ea7066;"></i>
													Carne emitida por el <b>Consejo Nacional de la Persona con discapacidad
														(CONADIS)</b>.
												</li>
												<li>
													<i class="fa fa-check" aria-hidden="true" style="color: #ea7066;"></i>
													Copia de la Resolución Ejecutiva, emitida por el <b>Consejo Nacional de la
														Persona con discapacidad (CONADIS)</b>, que acredita su condición de
													discapacidad.
												</li>
												<li>
													<i class="fa fa-check" aria-hidden="true" style="color: #ea7066;"></i>
													<b>Declaración jurada</b> en la que el postulante acepta someterse a las condiciones
													establecidas por la Universidad para rendir el examen según la discapacidad
													del postulante.
												</li>
												<li>
													<i class="fa fa-check" aria-hidden="true" style="color: #ea7066;margin-bottom: 7px;margin-top: -34px;"></i>
													Fotografía del Documento Nacional de Identidad <b><a href="/r_ejemplos/dni" class="color-3 abrirEjemplo">(DNI)</a></b>.
												</li>
												<li>
													<i class="fa fa-check" aria-hidden="true" style="color: #ea7066;"></i>
													Fotografía medio cuerpo de frente, en formato digital en <b>CD o USB</b>, tamaño <b><a href="/r_ejemplos/foto" class="color-3 abrirFoto">JUMBO (400x600 px)</a></b>, sin retoques, sin lentes, a colores y con fondo blanco.
												</li>
											</ul>
											<div class="product-info">
												<center>
													<a href="https://drive.google.com/file/d/1M6qicgrr1KwYSAUmeUGj8d2gF9gGO4XI/view?usp=sharing" class="btn btn-info" target="_blank" text-align="center">
														<i class="fa fa-cloud-download"></i> DECLARACIÓN J. MENORES
													</a>
												</center>
												<br>
												<center>
													<a href="https://drive.google.com/file/d/1vzOHUtGlQblWzKXKVZAIhB4vXcpU1Dk3/view?usp=sharing" class="btn btn-info" target="_blank" text-align="center">
														<i class="fa fa-cloud-download"></i> DECLARACIÓN J. MAYORES
													</a>
												</center>
												<br>
												<center>
													<a href="/login" class="btn btn-success" target="_blank" text-align="center">
														<i class="fa fa-laptop"></i> INSCRIPCIÓN
													</a>
												</center><br><br>
											</div>
										</div>
									</div>
									<div class="col-md-6 col-sm-5 col-xs-12" align="justify">
										<h3 class="media-heading" style="color: #ea7066;" align="center"><u>REQUISITOS DEL INGRESANTE PERSONAS CON DISCAPACIDAD</u></h3>
										<ul class="list-unstyled para-list">
											<li><i class="fa fa-check" aria-hidden="true" style="color: #ea7066;"></i>
												<b>Copia de certificados de estudios del 1° al 5° año de educación secundaria
													con calificaciones aprobatorias</b>, con nombres y apellidos según su partida de
												nacimiento, e indicando su respectivo orden de mérito, emitido por el colegio
												donde estudió y <b>visado por la UGEL</b> correspondiente o Constancia de <b>Logrosde Aprendizaje</b>
											</li>
											<li><i class="fa fa-check" aria-hidden="true" style="color: #ea7066;">
												</i> Partida de nacimiento <b>(original sin deterioro ni enmendaduras).</b></li>
											<li><i class="fa fa-check" aria-hidden="true" style="color: #ea7066;">
												</i> Copia del DNI del postulante legalizada.</li>
											<li><i class="fa fa-check" aria-hidden="true" style="color: #ea7066;">
												</i> Resolución ejecutiva en original y copia, emitida por el <b>CONSEJO NACIONAL DE LA PERSONA CON DISCAPACIDAD (CONADIS)</b> que acredite su condición de discapacidad.</li>
											<li><i class="fa fa-check" aria-hidden="true" style="color: #ea7066;">
												</i> Declaración jurada en el que el postulante acepta someterse a las condiciones establecidas por la universidad para rendir el examen según la discapacidad del postulante.</li>
											<li><i class="fa fa-check" aria-hidden="true" style="color: #ea7066;">
												</i> Certificado Judicial de antecedentes penales <b>(PODER JUDICAL)</b> para <b>MAYORES</b> y para <b>MENORES DE EDAD UNA DECLARACIÓN JURADA</b> más copia del <b>DNI</b> del apoderado.</li>
											<li>
												<i class="fa fa-check" aria-hidden="true" style="color: #ea7066;">
												</i> Voucher de pago de <b>S/. 20.00</b> al <b>BANCO DE LA NACIÓN</b> al código <b>01774.</b>
											</li>
										</ul>
										<div class="product-info">
											<center>
												<a href="http://bit.ly/37hwQTQ" class="btn btn-info" target="_blank" text-align="center">
													<i class="fa fa-cloud-download"></i> DECLARACIÓN JURADA
												</a>
											</center>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div id="menu3" class="tab-pane fade">
							<div class="media">
								<center>
									<div class="media-left">
										<a href="/normas-legales"></a><br>&nbsp&nbsp&nbsp&nbsp
										<img class="img-rounded" style="width: 230px;height:230px" src="/page/img/extraordinarioii/titulados.jpg">
										<h5><br><b class="color-3 media-heading">DESCARGAR REGLAMENTO</b></h5>
										<a href="https://drive.google.com/file/d/17-DURyUbWV8bSJfyqK4EaZuvBsSb-rgq/view" class="btn btn-warning" target="_blank" text-align="center" margin="0 auto" style="width: 210px;height:50px;">
											<i class="fa fa-cloud-download"></i> REGLAMENTO
										</a><br>
									</div>
								</center>
								<div class="media-body" align="justify">
									<h1 class="media-heading" align="center"><u>TITULADOS Y GRADUADOS</u></h1>
									Por esta modalidad participan los graduados y/o titulados de las Universidades particulares y estatales nacionales e internacionales, de la misma manera los oficiales y suboficiales de las fuerzas armadas. <br><br>
									Los postulantes que se inscriben al concurso de admisión programado por la UNASAM deben realizar su inscripción en forma presencial en la Oficina General de Admisión. <br>
									<b class="color-3">TIPO DE EXAMEN:</b> PRESENCIAL.<br>
									<b class="color-3">FECHA DE EXAMEN:</b> 13 de Marzo del 2022.<br>
									<b class="color-3">RESPUESTA CORRECTA:</b> 4.0 Puntos.<br>
									<b class="color-3">RESPUESTA SIN RESPONDER:</b> 0.0 Puntos.<br>
									<b class="color-3">RESPUESTA INCORRECTA:</b> -0.5 Puntos.<br>
									<b class="color-3">CANTIDAD DE PREGUNTAS:</b> 50.<br>
									<b class="color-3">PUNTAJE MÍNIMO:</b> 90.00 Puntos.<br>
									<b class="color-3">DURACIÓN:</b>1.5 Horas.<br>
								</div>
							</div>
							<div class="modal-body">
								<div class="row">
									<div class="col-md-6 col-sm-5 col-xs-12">
										<div class="media" align="justify">
											<h3 class="media-heading" style="color: #ea7066" align="center">
												<u>REQUISITOS DEL POSTULANTE PARA TITULADOS Y GRADUADOS</u>
											</h3>
											<ul class="list-unstyled para-list">
												<li>
													<i class="fa fa-check" aria-hidden="true" style="color: #ea7066"></i>
													Comprobante de pago efectuado en el banco de la Nación al código de operación <b>N°01774</b> con el número de <b>DNI</b> del postulante con el importe de <b>S/. 800</b>.
												</li>
												<li>
													<i class="fa fa-check" aria-hidden="true" style="color: #ea7066"></i>
													Fotocopia autenticada por la <b>UNIVERSIDAD</b> de origen del grado académico de <b>BACHILLER y/o TÍTULO PROFESIONAL.</b> Los procedentes de <b>UNIVERSIDADES EXTRANJERAS</b> deberán revalidar y legalizar el grado o título profesional de acuerdo a ley.
												</li>
												<li>
													<i class="fa fa-check" aria-hidden="true" style="color: #ea7066"></i>
													Copia del diploma de <b>Título Profesional o Bachiller</b>.
												</li>
												<li>
													<i class="fa fa-check" aria-hidden="true" style="color: #ea7066;margin-bottom: 7px;margin-top: -34px;"></i>
													Fotografía del Documento Nacional de Identidad <b><a href="/r_ejemplos/dni" class="color-3 abrirEjemplo">(DNI)</a></b>.
												</li>
												<li>
													<i class="fa fa-check" aria-hidden="true" style="color: #ea7066;"></i>
													Fotografía medio cuerpo de frente, en formato digital en <b>CD o USB</b>, tamaño <b><a href="/r_ejemplos/foto" class="color-3 abrirFoto">JUMBO (400x600 px)</a></b>, sin retoques, sin lentes, a colores y con fondo blanco.
												</li>
											</ul>
											<center>
												<a href="/login" class="btn btn-success" target="_blank" text-align="center">
													<i class="fa fa-laptop"></i> INSCRIPCIÓN
												</a>
											</center><br>
										</div>
									</div>
									<div class="col-md-6 col-sm-5 col-xs-12" align="justify">
										<h3 class="media-heading" style="color: #ea7066" align="center"><u>REQUISITOS DEL INGRESANTE GRADUADOS Y TITULADOS</u></h3>
										<ul class="list-unstyled para-list">
											<li><i class="fa fa-check" aria-hidden="true" style="color: #ea7066;"></i>
												<b>Copia de certificados de estudios del 1° al 5° año de educación secundaria
													con calificaciones aprobatorias</b>, con nombres y apellidos según su partida de
												nacimiento, e indicando su respectivo orden de mérito, emitido por el colegio
												donde estudió y <b>visado por la UGEL</b> correspondiente o Constancia de <b>Logrosde Aprendizaje</b>
											</li>
											<li>
												<i class="fa fa-check" aria-hidden="true" style="color: #ea7066"></i>
												Partida de nacimiento (<b>ORIGINAL</b>).
											</li>
											<li>
												<i class="fa fa-check" aria-hidden="true" style="color: #ea7066"></i>
												Copia del <b>DNI</b> del postulante legalizada.
											</li>

											<li>
												<i class="fa fa-check" aria-hidden="true" style="color: #ea7066"></i>
												Certificado Judicial de antecedentes penales <b>(PODER JUDICAL).</b>
											</li>
											<li>
												<i class="fa fa-check" aria-hidden="true" style="color: #ea7066"></i>
												Certificados de estudios originales, con calificación aprobatoria y sin enmendaduras.
											</li>
											<li>
												<i class="fa fa-check" aria-hidden="true" style="color: #ea7066"></i>
												Fotocopia autenticada por la <b>UNIVERSIDAD</b> de origen del grado académico de <b>BACHILLER y/o TÍTULO PROFESIONAL.</b> Los procedentes de <b>UNIVERSIDADES EXTRANJERAS</b> deberán revalidar y legalizar el grado o título profesional de acuerdo a ley.
											</li>
											<li>
												<i class="fa fa-check" aria-hidden="true" style="color: #ea7066">
												</i> Voucher de pago de S/. 20.00 al BANCO DE LA NACION al código <b>01774.</b> <br><br>
											</li>
										</ul>
										<div class="row">
											<div class="col-md-12 col-sm-12 col-xs-12">
												<div class="product-info">
													<center><a href="http://bit.ly/37hwQTQ" class="btn btn-info" target="_blank" text-align="center">
															<i class="fa fa-cloud-download"></i> DECLARACIÓN JURADA
														</a>
													</center>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div id="menu4" class="tab-pane fade">
							<div class="media">
								<div>
									<center>
										<div class="media-left">
											<a href="/normas-legales"></a><br>&nbsp&nbsp&nbsp&nbsp
											<img class="img-rounded" style="width: 230px;height:230px" src="/page/img/extraordinarioii/traslado_interno.png">
											<h5><br><b class="color-3 media-heading">DESCARGAR REGLAMENTO</b></h5>
											<a href="https://drive.google.com/file/d/17-DURyUbWV8bSJfyqK4EaZuvBsSb-rgq/view" class="btn btn-warning" target="_blank" text-align="center" margin="0 auto" style="width: 210px;height:50px;">
												<i class="fa fa-cloud-download"></i> REGLAMENTO
											</a><br>
										</div>
									</center>
									<div class="media-body" align="justify">
										<h1 class="media-heading" align="center"><u>TRASLADOS INTERNO</u></h1>
										Por esta modalidad solo pueden participar los alumnos de las universidades públicas y privadas que acrediten haber
										aprobado los cuatro primeros ciclos académicos o dos anuales o 72 créditos.<br>
										Los postulantes que se inscriben al concurso de admisión programado por la UNASAM deben realizar su inscripción en forma presencial en la Oficina General de Admisión.<br>
										<div class="media-body" align="justify">
											<b class="color-3">Traslado Interno solo se da en el primer proceso de cada año.</b><br>
											<b class="color-3">TIPO DE EXAMEN:</b> PRESENCIAL.<br>
											<b class="color-3">FECHA DE EXAMEN:</b> 13 de Marzo del 2022.<br>
											<b class="color-3">RESPUESTA CORRECTA:</b> 4.0 Puntos.<br>
											<b class="color-3">RESPUESTA SIN RESPONDER:</b> 0.0 Puntos.<br>
											<b class="color-3">RESPUESTA INCORRECTA:</b> -0.5 Puntos.<br>
											<b class="color-3">CANTIDAD DE PREGUNTAS:</b> 50.<br>
											<b class="color-3">PUNTAJE MÍNIMO:</b> 90.00 Puntos.<br>
											<b class="color-3">DURACIÓN:</b> 1.5 Horas.<br>
										</div>
									</div>
								</div>
							</div>
							<div class="modal-body">
								<div class="row">
									<div class="col-md-6 col-sm-5 col-xs-12">
										<div class="media" align="justify">
											<h3 class="media-heading" style="color: #ea7066;" align="center"><u>REQUISITOS DEL POSTULANTE PARA TRASLADO INTERNOS</u></h3>
											<ul class="list-unstyled para-list">
												<li>
													<i class="fa fa-check" aria-hidden="true" style="color: #ea7066;"></i>
													Comprobante de pago efectuado en el banco de la Nación al código de operación <b>N°01774</b> con el número de <b>DNI</b> del postulante con el importe de <b>S/. 200</b>.
												</li>
												<li>
													<i class="fa fa-check" aria-hidden="true" style="color: #ea7066;"></i>
													Record Curricular Integral<b class="color-3"> (RCI)</b> que acredite haber aprobado los cuatro primeros ciclos académicos o 72 créditos.
												</li>
												<li>
													<i class="fa fa-check" aria-hidden="true" style="color: #ea7066;margin-bottom: 7px;margin-top: -34px;"></i>
													Fotografía del Documento Nacional de Identidad <b><a href="/r_ejemplos/dni" class="color-3 abrirEjemplo">(DNI)</a></b>.
												</li>
												<li>
													<i class="fa fa-check" aria-hidden="true" style="color: #ea7066;"></i>
													Fotografía medio cuerpo de frente, en formato digital en <b>CD o USB</b>, tamaño <b><a href="/r_ejemplos/foto" class="color-3 abrirFoto">JUMBO (400x600 px)</a></b>, sin retoques, sin lentes, a colores y con fondo blanco.
												</li>
												</p>
												<b class="color-3 abrirEjemplo">Nota: No olvide que debe realizar con anticipación los trámites para obtener los documentos requeridos de ingreso, los cuales deben presentar de acuerdo al cronograma de Extraordinario II.</b> {{-- (30/03/2020 al 03/04/2020)<a href="https://drive.google.com/file/d/14iNdXp_npAcQuB2LCIEKEfnuSNJrIZ-x/view" title="">Ver</a> --}} </b>.
											</ul>
											<div class="product-info">
												<center>
													<a href="/login" class="btn btn-success" target="_blank" text-align="center">
														<i class="fa fa-laptop"></i> INSCRIPCIÓN
													</a>
												</center><br><br>
											</div>
										</div>
									</div>
									<div class="col-md-6 col-sm-5 col-xs-12" align="justify">
										<h3 class="media-heading" style="color: #ea7066;" align="center"><u>REQUISITOS DEL INGRESANTE TRASLADO INTERNOS</u></h3>
										<ul class="list-unstyled para-list">
											<li><i class="fa fa-check" aria-hidden="true" style="color: #ea7066;"></i>
												<b>Copia de certificados de estudios del 1° al 5° año de educación secundaria
													con calificaciones aprobatorias</b>, con nombres y apellidos según su partida de
												nacimiento, e indicando su respectivo orden de mérito, emitido por el colegio
												donde estudió y <b>visado por la UGEL</b> correspondiente o Constancia de <b>Logrosde Aprendizaje</b>
											</li>
											<li>
												<i class="fa fa-check" aria-hidden="true" style="color: #ea7066;"></i>
												Certificado original de estudios expedido por la UNASAM acreditando haber aprobado los cuatro primeros ciclos académicos o dos anuales o <b>72 créditos</b>.
											</li>
											<li>
												<i class="fa fa-check" aria-hidden="true" style="color: #ea7066;"></i>
												Constancia de ingreso a la UNASAM, indicando el año y modalidad de ingreso.
											</li>
											<li>
												<i class="fa fa-check" aria-hidden="true" style="color: #ea7066;"></i>
												Constancia de matrícula vigente (del <b>último ciclo académico que antecede al examen de admisión</b> al que se presente) emitida por la Facultad de Procedencia.
											</li>
											<li>
												<i class="fa fa-check" aria-hidden="true" style="color: #ea7066;"></i>
												Constancia de no haber sido separado por <b>medida disciplinaria o por asuntos académicos</b>, expedida por la Secretaría General de la UNASAM.</b>
											</li>
											<li>
												<i class="fa fa-check" aria-hidden="true" style="color: #ea7066;"></i>
												Copia autenticada del plan de estudios y sílabos de las asignaturas aprobadas en la UNASAM. Documentos que deben de ser refrendados por el Secretario General, por el Decano de la Facultad respectiva o por la oficina correspondiente (Si el postulante logra ingresar, estos documentos serán presentados en la Dirección de Escuelas de la carrera profesional correspondiente).
											</li>
											<li>
												<i class="fa fa-check" aria-hidden="true" style="color: #ea7066;"></i> Voucher de pago de <b>S/. 20.00 al BANCO DE LA NACIÓN al código 01774.</b>
											</li>
										</ul>
										<div class="product-info">
											<center><a href="http://bit.ly/37hwQTQ" class="btn btn-info" target="_blank" text-align="center">
													<i class="fa fa-cloud-download"></i> DECLARACIÓN JURADA
												</a>
											</center>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div id="menu5" class="tab-pane fade">
							<div class="media">
								<center>
									<div class="media-left">
										<a href="/normas-legales"></a><br>&nbsp&nbsp&nbsp&nbsp
										<img class="img-rounded" style="width: 230px;height:230px;" src="/page/img/extraordinarioii/traslados.jpg">
										<h5><br><b class="color-3 media-heading">DESCARGAR REGLAMENTO</b></h5>
										<a href="https://drive.google.com/file/d/17-DURyUbWV8bSJfyqK4EaZuvBsSb-rgq/view" class="btn btn-warning" target="_blank" text-align="center" margin="0 auto" style="width: 210px;height:50px;">
											<i class="fa fa-cloud-download"></i> REGLAMENTO
										</a><br>
									</div>
									<div class="media-body" align="justify">
										<h1 class="media-heading" align="center"><u>TRASLADOS EXTERNOS</u></h1>
										Por esta modalidad solo pueden participar los alumnos de las universidades públicas y privadas que acrediten haber aprobado los cuatro primeros ciclos académicos o dos anuales o 72 créditos. Si el postulante procede de una universidad extranjera, dicho certificado debe ser legalizado por el Consulado Peruano en el país de origen y refrendado por el Ministerio de relaciones Exteriores del Perú.<br><br>
										Los postulantes que se inscriben al concurso de admisión programado por la UNASAM deben realizar su inscripción en forma presencial en la Oficina General de Admisión.<br>
										<b class="color-3">TIPO DE EXAMEN:</b> PRESENCIAL.<br>
										<b class="color-3">FECHA DE EXAMEN:</b> 13 de Marzo del 2022.<br>
										<b class="color-3">RESPUESTA CORRECTA:</b> 4.0 Puntos.<br>
										<b class="color-3">RESPUESTA SIN RESPONDER:</b> 0.0 Puntos.<br>
										<b class="color-3">RESPUESTA INCORRECTA:</b> -0.5 Puntos.<br>
										<b class="color-3">CANTIDAD DE PREGUNTAS:</b> 50.<br>
										<b class="color-3">PUNTAJE MÍNIMO:</b> 90.00 Puntos.<br>
										<b class="color-3">DURACIÓN:</b> 1.5 Horas.<br>
									</div>
								</center>
							</div>
							<div class="modal-body">
								<div class="row">
									<div class="col-md-6 col-sm-5 col-xs-12">
										<div class="media" align="justify">
											<h3 class="media-heading" style="color: #ea7066;" align="center">
												<u>REQUISITOS PARA POSTULAR TRASLADO EXTERNO DE UNIVERSIDADES DEL PAÍS Y DEL EXTRANJERO</u>
											</h3>
											<ul class="list-unstyled para-list">
												<li>
													<i class="fa fa-check" aria-hidden="true" style="color: #ea7066;"></i>
													Vaucher de pago por derecho de Admisión para <b>Universidades Particulares S/. 750.00</b> y para <b>Universidades Nacionales S/. 600.00</b> al BANCO DE LA NACIÓN al código <b>01774</b>.
												</li>
												<li>
													<i class="fa fa-check" aria-hidden="true" style="color: #ea7066;"></i>
													Ficha de su última matrícula que acredite haber aprobado los cuatro primeros ciclos académicos o 72 créditos.
												</li>
												<li><i class="fa fa-check" aria-hidden="true" style="color: #ea7066;"></i>
													Formulario de datos de la universidad.
												</li>
												<li>
													<i class="fa fa-check" aria-hidden="true" style="color: #ea7066;margin-bottom: 7px;margin-top: -34px;"></i>
													Fotografía del Documento Nacional de Identidad <b><a href="/r_ejemplos/dni" class="color-3 abrirEjemplo">(DNI)</a></b>.
												</li>
												<li>
													<i class="fa fa-check" aria-hidden="true" style="color: #ea7066;"></i>
													Fotografía medio cuerpo de frente, en formato digital en <b>CD o USB</b>, tamaño <b><a href="/r_ejemplos/foto" class="color-3 abrirFoto">JUMBO (400x600 px)</a></b>, sin retoques, sin lentes, a colores y con fondo blanco.
												</li>
												<b class="color-3">Nota: No olvide que debe realizar con anticipación los trámites para obtener los documentos requeridos de ingreso, los cuales deben presentar de acuerdo al cronograma de Extraordinario II. {{-- (30/03/2020 al 03/04/2020) <a href="https://drive.google.com/file/d/14iNdXp_npAcQuB2LCIEKEfnuSNJrIZ-x/view" title="">Ver</a> --}}</b>.
											</ul>
											<div class="product-info">
												<center>
													<a href="/login" class="btn btn-success" target="_blank" text-align="center">
														<i class="fa fa-laptop"></i> INSCRIPCIÓN
													</a>
												</center>
											</div><br>
										</div>
									</div>
									<div class="col-md-6 col-sm-5 col-xs-12" align="justify">
										<h3 class="media-heading" style="color: #ea7066;" align="center">
											<u>REQUISITOS DEL INGRESANTE TRASLADO EXTERNO DE UNIVERSIDADES DEL PAÍS Y DEL EXTRANJERO</u>
										</h3>
										<ul class="list-unstyled para-list">
											<li><i class="fa fa-check" aria-hidden="true" style="color: #ea7066;"></i>
												<b>Copia de certificados de estudios del 1° al 5° año de educación secundaria
													con calificaciones aprobatorias</b>, con nombres y apellidos según su partida de
												nacimiento, e indicando su respectivo orden de mérito, emitido por el colegio
												donde estudió y <b>visado por la UGEL</b> correspondiente o Constancia de <b>Logrosde Aprendizaje</b>
											</li>
											<li>
												<i class="fa fa-check" aria-hidden="true" style="color: #ea7066;"></i>
												Partida de nacimiento (original).
											</li>
											<li>
												<i class="fa fa-check" aria-hidden="true" style="color: #ea7066;"></i>
												Copia del DNI del postulante legalizada.
											</li>
											<li>
												<i class="fa fa-check" aria-hidden="true" style="color: #ea7066;"></i>
												Certificado Judicial de antecedentes penales <b>(PODER JUDICAL).</b><br> para MAYORES.
											</li>
											<li>
												<i class="fa fa-check" aria-hidden="true" style="color: #ea7066;"></i>
												Certificado original de estudios expedido por la <b>UNIVERSIDAD O INSTITUCIÓN</b> académica de origen, acreditando haber <b>aprobado los cuatro primeros ciclos académicos o dos anuales o 72 créditos.</b> Si el postulante procede de una <b>UNIVERSIDAD EXTRANJERA</b>, dicho certificado debe ser legalizado por el <b>CONSULADO PERUANO</b> en el país de origen y refrendado por el ministerio de <b>RELACIONES EXTERIORES DEL PERÚ.</b>
											</li>
											<li>
												<i class="fa fa-check" aria-hidden="true" style="color: #ea7066;"></i>
												Constancia de ingreso de la institución de origen, indicando el año y modalidad de ingreso.
											</li>
											<li>
												<i class="fa fa-check" aria-hidden="true" style="color: #ea7066;"></i>
												Constancia de matrícula vigente (del <b>último ciclo académico</b> que antecede al examen de admisión al que se presente) emitida por la institución de origen.
											</li>
											<li>
												<i class="fa fa-check" aria-hidden="true" style="color: #ea7066;"></i>
												Constancia de no haber sido separado por medida disciplinaria o por asuntos académicos de la institución de origen, expedida por la secretaría general de la institución de procedencia.
											</li>
											<li>
												<i class="fa fa-check" aria-hidden="true" style="color: #ea7066;"></i>
												Copia autenticada del <b>plan de estudios y sílabos de las asignaturas aprobadas</b> en la institución de origen. documentos que deben ser refrendados por el secretario general de la institución de procedencia o por el decano de la facultad respectiva o por la oficina correspondiente.
											</li>
											<li>
												<i class="fa fa-check" aria-hidden="true" style="color: #ea7066;"></i>
												Voucher de pago de <b>S/. 20.00 al BANCO DE LA NACIÓN al código 01774.</b>
											</li>
										</ul>
										<div class="product-info">
											<center><a href="http://bit.ly/37hwQTQ" class="btn btn-info" target="_blank" text-align="center">
													<i class="fa fa-cloud-download"></i> DECLARACIÓN JURADA
												</a>
											</center>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div id="menu6" class="tab-pane fade">
							<div class="media">
								<center>
									<div class="media-left">
										<a href="/normas-legales"></a><br>&nbsp&nbsp&nbsp&nbsp
										<img class="img-rounded" style="width: 230px;height:230px;" src="/page/img/extraordinarioii/traslados.jpg"><br><br>
										<div class="product-info">
											<h5><b class="color-3 media-heading">DESCARGAR REGLAMENTO</b></h5>
											<center><a href="https://drive.google.com/file/d/17-DURyUbWV8bSJfyqK4EaZuvBsSb-rgq/view" class="btn btn-warning" target="_blank" text-align="center" margin="0 auto" style="width: 210px;height:50px;">
													<i class="fa fa-cloud-download"></i> REGLAMENTO
												</a><br>
											</center>
											<div style="width: 240px;">
												<b class="color-3">RESPUESTA CORRECTA:</b><br>4.0 Puntos.<br>
												<b class="color-3">RESPUESTA SIN RESPONDER:</b><br>0.0 Puntos.<br>
												<b class="color-3">RESPUESTA INCORRECTA:</b><br>-0.5 Puntos.<br>
												<b class="color-3">CANTIDAD DE PREGUNTAS:</b><br>50.<br>
												<b class="color-3">PUNTAJE MÍNIMO:</b><br>80.00 Puntos.<br>
												<b class="color-3">DURACIÓN:</b><br>90 Min.<br>
												<b class="color-3">TIPO DE EXAMEN:</b><br>PRESENCIAL.<br>
												<b class="color-3">FECHA DE EXAMEN:</b><br>06 de Octubre del 2021.
											</div><br>
										</div>
									</div>
									<div class="media-body" align="justify">
										<h1 class="media-heading oculto" align="center"><u>TRASLADO EXTERNO ESPECIAL</u></h1>
										En esta modalidad participan los alumnos de las universidades públicas o privadas con <b>licencia denegada</b> y que <b>tengan como mínimo un semestre academico o tener 20 créditos aprobados</b>, como se estipula en el <b><a href="https://bit.ly/TrasladosExternosEspecial" target="_blank" title="Reglamento Traslado Externo Especial" class="color-10">Reglamento de traslado externo especial.</a></b><br><br>
										<b class="color-3">CARRERAS OFERTADAS:</b><br>
										<li><b>ADMINISTRACIÓN:</b> 20 vacantes</li>
										<Li><b>ENFERMERÍA:</b> 30 vacantes</Li>
										<li><b>ECONOMÍA:</b> 30 vacantes</Li>
										<Li><b>CONTABILIDAD:</b> 30 vacantes</Li>
										<li><b>INGENIERÍA CIVIL:</b> 23 vacantes</li>
										<li><b>ARQUITECTURA Y URBANISMO:</b> 27 vacantes</li>
										<li><b>DERECHO Y CIENCIAS POLÍTICAS:</b> 40 vacantes</li><br>
										Los postulantes que se inscriben al concurso de admisión programado por la UNASAM deben realizar su <b>inscripción en forma virtual y presentar sus requisitos cuando ingresan de manera presencial</b> en la Oficina General de Admisión. <br><br></b>
										<b>El examen comprende de dos partes:</b><br><br>
										<b class="color-3">PRIMERA PARTE:</b> Comprende treinta y cinco (35) preguntas de aptitud académica según las siguientes especificaciones:
										<li><b>LÓGICO MATEMÁTICO:</b> 20 preguntas.<br></li>
										<li><b>RAZONAMIENTO VERBAL Y ESCRITA:</b> 15 preguntas.<br></li>
										</li><br>
										<b class="color-3">SEGUNDA PARTE:</b> Comprende quince (15) preguntas de cultura general de la carrera profesional a la que se presenta.
										<li><b>CULTURA GENERAL RESPECTO A LA CARRERA:</b> 15 preguntas.</li>
									</div>
								</center>
							</div>
							<div class="modal-body">
								<div class="row">
									<div class="col-md-6 col-sm-5 col-xs-12">
										<div class="media" align="justify">
											<h3 class="media-heading" style="color: #ea7066;" align="center">
												<u>REQUISITOS PARA POSTULAR TRASLADO EXTERNO ESPECIAL DE UNIVERSIDADES DEL PAÍS CON LICENCIA DENEGADA</u>
											</h3>
											<ul class="list-unstyled para-list">
												<p align="justify" style="color: #000000;">
													<i class="fa fa-check" aria-hidden="true" style="color: #ea7066;margin-bottom: 7px;margin-top: -34px;"></i>
													Comprobante de pago efectuado en el banco de la Nación al código de operación <b>N°01774</b> con el número de <b>DNI</b> del postulante.<br>
													- UNIVERSIDADES NACIONALES: <b>S/. 300.00</b><br>
													- UNIVERSIDADES PARTICULARES: <b>S/.375.00</b>
													<br><br>
													<i class="fa fa-check" aria-hidden="true" style="color: #ea7066;"></i>
													Fotografía del Documento Nacional de Identidad <b><a href="/r_ejemplos/dni" class="color-3 abrirEjemplo">(DNI)</a></b>.<br><br>
													<i class="fa fa-check" aria-hidden="true" style="color: #ea7066;"></i>
													Fotografía medio cuerpo de frente, en formato digital en <b>CD o USB</b>, tamaño <b><a href="/r_ejemplos/foto" class="color-3 abrirFoto">JUMBO (400x600 px)</a></b>, sin retoques, sin lentes, a colores y con fondo blanco.<br><br>
													<i class="fa fa-check" aria-hidden="true" style="color: #ea7066;margin-bottom: 7px;margin-top: -34px;"></i>
													Kardex o Record Integral de Notas, se debe enviar al correo (unasam.admision@gmail.com).<br><br>
												</p>
												<b>Nota: No olvide que debe realizar con anticipación los trámites para obtener los documentos requeridos de ingreso, los cuales deben presentar de acuerdo al cronograma de Extraordinario II.</b> {{-- (30/03/2020 al 03/04/2020)<a href="https://drive.google.com/file/d/14iNdXp_npAcQuB2LCIEKEfnuSNJrIZ-x/view" title="">Ver</a> --}} </b>.
											</ul>
											<div class="product-info">
												<center>
													<a href="/login" class="btn btn-success" target="_blank" text-align="center">
														<i class="fa fa-laptop"></i> INSCRIPCIÓN
													</a>
												</center><br><br>
											</div>
										</div>
									</div>
									<div class="col-md-6 col-sm-5 col-xs-12" align="justify">
										<h3 class="media-heading" style="color: #ea7066;" align="center">
											<u>REQUISITOS DEL INGRESANTE TRASLADO EXTERNO DE UNIVERSIDADES DEL PAÍS CON LICENCIA DENEGADA</u>
										</h3>
										<ul class="list-unstyled para-list">
											<li>
												<i class="fa fa-check" aria-hidden="true" style="color: #ea7066;"></i>
												Partida de nacimiento del acta original.<b>(Partida transcrita no se aceptará)</b>
											</li>
											<li>
												<i class="fa fa-check" aria-hidden="true" style="color: #ea7066;"></i>
												Copia del DNI del postulante legalizada.
											</li>
											<li>
												<i class="fa fa-check" aria-hidden="true" style="color: #ea7066;"></i>
												Certificado Judicial de antecedentes penales <b>(PODER JUDICAL).</b><br> para MAYORES.
											</li>
											<li>
												<i class="fa fa-check" aria-hidden="true" style="color: #ea7066;"></i>
												<b>Certificados de estudios originales</b> completos y sin enmendaduras del <b>primero al quinto año</b> de educación secundaria o sus equivalentes <b>visados por la UGEL</b> o la Instancia Educativa competente.<br>
											</li>
											<li>
												<i class="fa fa-check" aria-hidden="true" style="color: #ea7066;"></i>
												Certificado original de estudios expedido por la <b>UNIVERSIDAD </b>de origen, acreditando haber <b>aprobado el primero ciclo académico o 20 créditos.</b>
											</li>
											<li>
												<i class="fa fa-check" aria-hidden="true" style="color: #ea7066;"></i>
												Constancia de ingreso de la institución de origen, indicando el año y modalidad de ingreso.
											</li>
											<li>
												<i class="fa fa-check" aria-hidden="true" style="color: #ea7066;"></i>
												Constancia de matrícula.
											</li>
											<li>
												<i class="fa fa-check" aria-hidden="true" style="color: #ea7066;"></i>
												Constancia de no haber sido separado por medida disciplinaria o por asuntos académicos de la institución de origen, expedida por la institución de procedencia.
											</li>
											<li>
												<i class="fa fa-check" aria-hidden="true" style="color: #ea7066;"></i>
												Copia autenticada del <b>plan de estudios y sílabos de las asignaturas aprobadas</b> en la institución de origen. documentos que deben ser refrendados por el secretario general de la institución de procedencia o por el decano de la facultad respectiva o por la oficina correspondiente.
											</li>
											<li>
												<i class="fa fa-check" aria-hidden="true" style="color: #ea7066;"></i>
												Voucher de pago de <b>S/. 20.00 al BANCO DE LA NACIÓN al código 01774.</b>
											</li>
										</ul>
										<div class="product-info">
											<center><a href="http://bit.ly/37hwQTQ" class="btn btn-info" target="_blank" text-align="center">
													<i class="fa fa-cloud-download"></i> DECLARACIÓN JURADA
												</a>
											</center>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div id="menu7" class="tab-pane fade">
							<div class="media">
								<center>
									<div class="media-left">
										<a href="/normas-legales"></a><br>&nbsp&nbsp&nbsp&nbsp
										<img class="img-rounded" style="width: 230px;height:230px;" src="/page/img/extraordinarioii/victimas.jpg">
										<h5><br><b class="color-3 media-heading">DESCARGAR REGLAMENTO</b></h5>
										<a href="https://drive.google.com/file/d/17-DURyUbWV8bSJfyqK4EaZuvBsSb-rgq/view" class="btn btn-warning" target="_blank" text-align="center" margin="0 auto" style="width: 210px;height:50px;">
											<i class="fa fa-cloud-download"></i> REGLAMENTO
										</a><br>
									</div>
									<div class="media-body" align="justify">
										<h1 class="media-heading" align="center"><u>VICTIMAS DEL TERRORISMO Y DEL PLAN INTEGRAL DE REPARACIONES</u></h1>
										De acuerdo a la ley N°28592 Art.2 Plan Integral de Reparaciones en Programas de educación, Para efectos de la presente ley es beneficiario aquellas victimas, familiarares de las victimas y grupos humanos que por la constración de las violaciones masivas, sufrieron violación de sus derechos humanos. <br><br>
										Los postulantes que se inscriben al concurso de admisión programado por la UNASAM deben realizar su inscripción en forma presencial en la Oficina General de Admisión. <br>
										<b class="color-3">TIPO DE EXAMEN:</b> PRESENCIAL.<br>
										<b class="color-3">FECHA DE EXAMEN:</b> 20 de Marzo del 2022.<br>
										<b class="color-3">RESPUESTA CORRECTA:</b> 4.0 Puntos.<br>
										<b class="color-3">RESPUESTA SIN RESPONDER:</b> 0.0 Puntos.<br>
										<b class="color-3">RESPUESTA INCORRECTA:</b> -0.5 Puntos.<br>
										<b class="color-3">CANTIDAD DE PREGUNTAS:</b> 100.<br>
										<b class="color-3">PUNTAJE MÍNIMO:</b> 100.00 Puntos.<br>
										<b class="color-3">DURACIÓN:</b> 03 Horas.<br>
									</div>
								</center>
							</div>
							<div class="modal-body">
								<div class="row">
									<div class="col-md-6 col-sm-5 col-xs-12">
										<div class="media" align="justify">
											<h3 class="media-heading" style="color: #ea7066;" align="center"><u>REQUISITOS DEL POSTULANTE PARA VÍCTIMAS DEL TERRORISMO Y DEL PIR</u></h3>
											<ul class="list-unstyled para-list">
												<li>
													<i class="fa fa-check" aria-hidden="true" style="color: #ea7066;"></i>
													Resolución o certificado en original y copia que acredite ser beneficiario según el <b>DECRETO SUPREMO N° 051-88-PCM</b>, y la <b>LEY N° 27277</b> y los comprendidos en la <b>LEY 28592</b> y su reglamento <b>D.S. N° 015-2006-JUS. Y D.S. N° 003-2008-JUS Y D.S. N° 047-2011-PCM</b> modifica el reglamento de la <b>LEY N° 28592.</b>
												</li>
												<li>
													<i class="fa fa-check" aria-hidden="true" style="color: #ea7066;"></i>
													Declaración Jurada de no haber hecho uso del beneficio en otras universidades.</b>
												</li>
												<li>
													<i class="fa fa-check" aria-hidden="true" style="color: #ea7066;margin-bottom: 7px;margin-top: -34px;"></i>
													Fotografía del Documento Nacional de Identidad <b><a href="/r_ejemplos/dni" class="color-3 abrirEjemplo">(DNI)</a></b>.
												</li>
												<li>
													<i class="fa fa-check" aria-hidden="true" style="color: #ea7066;"></i>
													Fotografía medio cuerpo de frente, en formato digital en <b>CD o USB</b>, tamaño <b><a href="/r_ejemplos/foto" class="color-3 abrirFoto">JUMBO (400x600 px)</a></b>, sin retoques, sin lentes, a colores y con fondo blanco.
												</li>
											</ul>
											<div class="product-info">
												<center><a href="https://drive.google.com/file/d/1ALnJw8mNvWfI_fqi6nvIH2ffrNMW3MgY/view?usp=sharing" class="btn btn-info" target="_blank" text-align="center">
														<i class="fa fa-cloud-download"></i> DECLARACIÓN J. MENORES
													</a>
												</center><br>
												<center><a href="https://drive.google.com/file/d/18s4RAfsgAE3l1TMq95D4RxHv9QHAz1rj/view?usp=sharing" class="btn btn-info" target="_blank" text-align="center">
														<i class="fa fa-cloud-download"></i> DECLARACIÓN J. MAYORES
													</a>
												</center><br>
												<center>
													<a href="/login" class="btn btn-success" target="_blank" text-align="center">
														<i class="fa fa-laptop"></i> INSCRIPCIÓN
													</a>
												</center><br><br>
											</div>
										</div>
									</div>
									<div class="col-md-6 col-sm-5 col-xs-12" align="justify">
										<h3 class="media-heading" style="color: #ea7066;" align="center"><u>REQUISITOS DEL INGRESANTE VICTIMAS DEL TERRORISMO Y DEL PIR</u></h3>
										<ul class="list-unstyled para-list">
											<li><i class="fa fa-check" aria-hidden="true" style="color: #ea7066;"></i>
												<b>Copia de certificados de estudios del 1° al 5° año de educación secundaria
													con calificaciones aprobatorias</b>, con nombres y apellidos según su partida de
												nacimiento, e indicando su respectivo orden de mérito, emitido por el colegio
												donde estudió y <b>visado por la UGEL</b> correspondiente o Constancia de <b>Logrosde Aprendizaje</b>
											</li>
											<li>
												<i class="fa fa-check" aria-hidden="true" style="color: #ea7066;"></i>
												Partida de nacimiento (<b>original</b>).
											</li>
											<li>
												<i class="fa fa-check" aria-hidden="true" style="color: #ea7066;"></i>
												Copia del <b>DNI</b> del postulante legalizada.
											</li>
											<li>
												<i class="fa fa-check" aria-hidden="true" style="color: #ea7066;"></i>
												Certificado Judicial de antecedentes penales <b>(PODER JUDICAL)</b> para <b>MAYORES DE EDAD</b> y para <b>MENORES DE EDAD</b> una declaración jurada más copia del <b>DNI</b> del apoderado.
											</li>
											<li>
												<i class="fa fa-check" aria-hidden="true" style="color: #ea7066;"></i>
												Resolución o certificado en original y copia que acredite ser beneficiario según el <b>DECRETO SUPREMO N° 051-88-PCM</b>, y la <b>LEY N° 27277</b> y los comprendidos en la <b>LEY 28592</b> y su reglamento <b>D.S. N° 015-2006-JUS. Y D.S. N° 003-2008-JUS Y D.S. N° 047-2011-PCM</b> modifica el reglamento de la <b>LEY N° 28592.</b>
											</li>
											<li>
												<i class="fa fa-check" aria-hidden="true" style="color: #ea7066;"></i>
												Declaración jurada de no haber hecho uso de este derecho o modalidad en otra <b>UNIVERSIDAD DEL PAÍS</b>. Los miembros de la <b>COMISIÓN CENTRAL DE ADMISIÓN</b>, calificarán los expedientes para validar su postulación.
											</li>
											<li>
												<i class="fa fa-check" aria-hidden="true" style="color: #ea7066;"></i>
												Voucher de pago de <b>S/. 20.00 al BANCO DE LA NACIÓN al código 01774.</b>
											</li>
										</ul>
										<div class="product-info">
											<center><a href="http://bit.ly/37hwQTQ" class="btn btn-info" target="_blank" text-align="center">
													<i class="fa fa-cloud-download"></i> DECLARACIÓN JURADA
												</a>
											</center>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script>
			$(document).ready(function() {
				$menu = $(location).attr('hash');
				$div = $menu.substring(1);
				console.log($menu.substring(1));
				if ($div == "home") {
					$('.nav-tabs a[href="#' + $div + '"]').addClass("active");
					$val = $('.nav-tabs a[href="#' + $div + '"]').attr("val");
					console.log($('.nav-tabs a[href="#' + $div + '"]').attr("val"));
					$('.nav-tabs li:eq("' + $val + '") a').tab('show');
				} else {
					$('.nav-tabs a[href="#home"]').removeClass("active");
					$('.nav-tabs a[href="#' + $div + '"]').addClass("active");
					$val = $('.nav-tabs a[href="#' + $div + '"]').attr("val");
					console.log($('.nav-tabs a[href="#' + $div + '"]').attr("val"));
					$('.nav-tabs li:eq("' + $val + '") a').tab('show');
				}
			});
		</script>
</section>
@endsection
@section('scriptspage')
<script src="page/plugins/bootbox/bootbox.min.js"></script>
<script>
	showModal('.abrirEjemplo', 'medium');
	showModal('.abrirFoto', 'medium');
</script>
@endsection