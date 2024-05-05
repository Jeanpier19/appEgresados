@extends('layouts.web')
@section('content')
<!-- Animación de Inicio -->
    <div id="background-overlay">
                    <div class="side-by-side">
                        <div class="circle">
                            <img src="{{ asset('img/logo.png') }}" alt="Logotipo UNASAM" class="logo"> <!-- Logo DSCE -->
                        </div>
                        <div class="vertical-bar"></div> <!-- Barra vertical -->
                        <div id="unasam-text" class="letters-container">
                            <span>SGSEGT UNASAM</span>
                        </div>
                    </div>
                </div>
    <!-- Banner -->
    <section id="Home" class="home-section" id="home">
        <div class="home-section-overlay"></div>
        <div class="container home-wrapper">
            <!--begin row -->
            <div class="row align-items-center">
                <!--begin col-md-8-->
                <div class="col-md-8 mx-auto text-center">
                    <h1>Bienvenido</h1>
                    <p class="hero-text"></p>
                    <a href="#about" class="arrow-down scrool"><i class="bi bi-chevron-double-down"></i></a>
                </div>
                <!--end col-md-8-->
            </div>
            <!--end row -->
        </div>
    </section>
    <!-- Nosotros -->
    <section class="section-grey" id="about">
        <!--begin container -->
        <div class="container">

            <!--begin row -->
            <div class="row align-items-center text-center">
                <!--begin col-md-5 -->
                <div class="col-md-5 col-sm-12">
                    <img src="{{asset('img/logo-unasam-positivo.png')}}" width="80px" alt="">
                    <h2>Nosotros</h2>

                    <p>Sistema de Gestión y Seguimiento de Egresados, Graduados y Titulados de la Universidad Nacional
                        Santiago Antúnez de Mayolo.</p>
                </div>
                <!--end col-md-5 -->

                <!--begin col-md-1 -->
                <div class="col-md-1"></div>
                <!--end col-md-1 -->

                <!--begin col-md-6-->
                <div class="col-md-6">

                    <!--begin accordion -->
                    <div class="accordion accordion-flush" id="accordionOne">

                        <div class="accordion-item">

                            <h2 class="accordion-header" id="headingOne">

                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    <i class="bi bi-people-fill"></i> Misión
                                </button>
                            </h2>

                            <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne"
                                 data-bs-parent="#accordionOne">
                                <div class="accordion-body">
                                    Prestar un óptimo servicio y fomentar la vinculación de los egresados con su alma
                                    mater, fortaleciendo la comunicación entre ellos y con la institución, en función a
                                    la mejora de la comunidad de egresados y graduados de la UNASAM.
                                    Asegurar la integración de los egresados a la comunidad de egresados y graduados
                                    manteniendo una comunicación directa para la incorporación e inserción a
                                    oportunidades laborales, programas y proyectos de mejoramiento a nivel profesional.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    <i class="bi bi-eye-fill"></i> Visión
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                 data-bs-parent="#accordionOne">
                                <div class="accordion-body">
                                    La misión de la Dirección de Seguimiento y Certificación a los Egresados tiene como
                                    visión la de establecer una amplia red de comunicación nacional e internacional
                                    entre egresados y graduados de la Universidad, que permita la constante
                                    retroalimentación sobre el quehacer institucional y el desempeño profesional de sus
                                    egresados y graduados, fortalecer los recursos necesarios para la actualización
                                    continua de la información de los egresados y graduados. con ello brindar beneficios
                                    a sus beneficiarios, de tal forma que el sector más numeroso de nuestra comunidad
                                    Universitaria, se considere una de las principales fortalezas institucionales a
                                    nivel Regional y Nacional.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--begin fun-facts -->
    <section class="section-white medium-padding-bottom">
        <!--begin container-->
        <div class="container">
            <!--begin row-->
            <div class="row">
                <!--begin col md 7 -->
                <div class="col-md-7 mx-auto margin-bottom-10 text-center">
                    <img src="{{asset('img/icons/graduado.png')}}" alt="comunicados" width="50px">
                    <h2>Nuestros Alumnos</h2>
                </div>
                <!--end col md 7-->
            </div>
            <!--end row-->
            <!--begin row-->
            <div class="row">
                <!--begin fun-facts-box -->
                <div class="col-md-2 offset-md-1 fun-facts-box blue text-center">
                    <i class="bi bi-award"></i>
                    <p class="fun-facts-title"><span class="facts-numbers">{{$cantidad_egresados}}</span><br>Egresados
                    </p>
                </div>
                <!--end fun-facts-box -->
                <!--begin fun-facts-box -->
                <div class="col-md-2 fun-facts-box red text-center">

                    <i class="bi bi-award-fill"></i>

                    <p class="fun-facts-title"><span class="facts-numbers">{{$cantidad_graduados}}</span><br>Graduados
                    </p>

                </div>
                <!--end fun-facts-box -->

                <!--begin fun-facts-box -->
                <div class="col-md-2 fun-facts-box green text-center">

                    <i class="bi bi-award"></i>

                    <p class="fun-facts-title"><span class="facts-numbers">{{$cantidad_titulados}}</span><br>Titulados
                    </p>

                </div>
                <!--end fun-facts-box -->

                <!--begin fun-facts-box -->
                <div class="col-md-2 fun-facts-box yellow text-center">

                    <i class="bi bi-award-fill"></i>

                    <p class="fun-facts-title"><span class="facts-numbers">{{$cantidad_magisteres}}</span><br>Magísteres
                    </p>

                </div>
                <!--end fun-facts-box -->

                <!--begin fun-facts-box -->
                <div class="col-md-2 fun-facts-box blue-sky text-center">

                    <i class="bi bi-award"></i>

                    <p class="fun-facts-title"><span class="facts-numbers">{{$cantidad_doctores}}</span><br>Doctores</p>

                </div>
                <!--end fun-facts-box -->

            </div>
            <!--end row-->

        </div>
        <!--end container-->

    </section>
    <!-- Comunicados -->
    <section class="section-grey small-padding-bottom my-2">
            <!--begin container -->
            <div class="container" style="overflow: hidden">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <img src="{{asset('img/icons/megafono.png')}}" alt="comunicados" width="50px">
                        <h2>Comunicados</h2>
                    </div>
                </div>
                <!--begin row -->
                @if(count($comunicados) > 0)
                    <div class="row">
                        <!--begin col md 12 -->
                        <div class="col-md-12 mx-auto padding-top-10">
                            <!--begin carrusel de comunicados -->
                            <div id="carouselComunicados" class="carousel slide" data-ride="carousel">
                                <!-- Contenido del carrusel -->
                                <div class="carousel-inner">
                                    @foreach($comunicados as $index => $comunicado)
                                        <div class="carousel-item @if($index === 0) active @endif">
                                            <div class="row align-items-center testim-inner" style="max-width: 1500px; margin: 0 auto;">
                                                <div class="col-md-6">
                                                    <!-- Aquí coloca tu contenido de imagen o video -->
                                                    @if($comunicado->imagen)
                                                        <img src="{{asset($comunicado->imagen)}}" alt="comunicados"
                                                            class="width-100 image-shadow video-popup-image responsive-bottom-margins"
                                                            style="max-width: 300px; height: auto;">
                                                    @endif
                                                    @if($comunicado->video)
                                                        <a class="popup4 video-play-icon"
                                                        href="{{$comunicado->video}}">
                                                            <i class="bi bi-caret-right-fill"></i>
                                                        </a>
                                                    @endif
                                                </div>
                                                <div class="col-md-6 testim-info">
                                                    <i class="bi bi-chat-left-quote green"></i>
                                                    <h4>{{$comunicado->titulo}}</h4>
                                                    <p>{{$comunicado->descripcion}}</p>
                                                    @if($comunicado->link)
                                                        <a href="{{$comunicado->link}}" class="scrool" target="_blank">
                                                            <button type="button" class="btn btn-sm btn-primary">Ver más</button>
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <!--end carrusel de comunicados -->
                            </div>
                            <!--end carrusel de comunicados -->
                        </div>
                        <!--end col md 12-->
                    </div>
                    <!--end row -->

            <!-- Botones de navegación personalizados con espacio vertical -->
            <div class="row mt-5 mb-5">
                <div class="col-md-12 text-center">
                    <button class="btn btn-circular btn-primary" onclick="carruselAnterior()">
                        &lt; <!-- Símbolo de menor: < -->
                    </button>

            <!-- Botones numerados -->
            <div class="btn-group">
                @for($i = 1; $i <= min(3, count($comunicados)); $i++)
                    @php
        $activo = isset($numeroComunicadoActual) && $numeroComunicadoActual === $i;
                    @endphp
                    <button class="btn btn-numero @if($activo) btn-activo @endif" onclick="irAComunicado({{$i}})">{{$i}}</button>
                @endfor
                @if(count($comunicados) > 3)
                    <span class="btn btn-puntos-suspensivos">     </span>
                    <button class="btn btn-numero @if(!isset($numeroComunicadoActual)) btn-activo @endif" onclick="irAComunicado({{count($comunicados)}})">{{count($comunicados)}}</button>
                @endif
            </div>
            <!-- end botones numerados -->

                     <button class="btn btn-circular btn-primary" onclick="carruselSiguiente()">
                        &gt; <!-- Símbolo de mayor: > -->
                    </button>
                </div>
            </div>
                        <!--end Botones de navegación personalizados -->
                    @else
                        <p class="text-muted text-center">En este momento no hay comunicados</p>
                    @endif
                    <!--end row -->
                </div>
                <!--end container -->
        </section>
    <!-- Ofertas laborales -->
    <!-- Ofertas de capacitacion -->
    <!-- Encuestas -->
    <!-- Convenios -->
    <!-- Contáctanos -->
    <section class="section-white" id="contactanos">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <img src="{{asset('img/icons/contact-form.png')}}" alt="contactanos" width="50px">
                    <h3>Ponerse en contacto</h3>
                    <p class="contact_success_box" style="display:none;">Recibimos su mensaje, nos contactaremos
                        pronto</p>
                    <div id="mensaje_respuesta"></div>
                    <form id="form-contacto" class="contact" action="{{route('mensajes.store')}}" method="POST">
                        @csrf
                        <input id="nombre" class="contact-input white-input" required="" name="nombre"
                               placeholder="Nombre completos*" type="text">
                        <input id="correo" class="contact-input white-input" required="" name="correo"
                               placeholder="Correo electrónico*" type="email">
                        <input id="telefono" class="contact-input white-input" required="" name="telefono"
                               placeholder="Número telefónico*" type="text">
                        <textarea id="mensaje" class="contact-commnent white-input" rows="2" cols="20" name="mensaje"
                                  placeholder="Tu mensaje..." required></textarea>
                        <button id="enviar-mensaje" type="button" class="btn btn-primary btn-lg">Enviar mensaje</button>
                    </form>
                </div>
                <div class="col-md-6 responsive-top-margins">
                    <img src="{{asset('img/icons/map.png')}}" alt="contactanos" width="50px">
                    <h3>Como encontrarnos</h3>
                    <iframe title=''
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3934.8581858167277!2d-77.52814641707347!3d-9.521048224930368!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x91a90d12eb234bf1%3A0xc860f66d7ad8abd9!2sUNIVERSIDAD%20NACIONAL%20SANTIAGO%20ANT%C3%9ANEZ%20DE%20MAYOLO!5e0!3m2!1ses-419!2spe!4v1639007778685!5m2!1ses-419!2spe"
                        width="600" height="270" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                    <img src="{{asset('img/icons/note-book.png')}}" alt="contactanos" width="50px"
                         class="padding-top-10">
                    <h3>Oficina Central</h3>
                    <p class="contact-info"><i class="bi bi-geo-alt-fill"></i> Av. Centenario</p>
                    <p class="contact-info"><i class="bi bi-envelope-open-fill"></i> <a
                            href="mailto:ogrsu-dsce@unasam.edu.pe">ogrsu-dsce@unasam.edu.pe</a></p>
                    <p class="contact-info"><i class="bi bi-telephone-fill"></i><a href="tel:+51927628748"> +51
                            927628748</a></p>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('js')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#enviar-mensaje').on('click', function () {
                if ($('#form-contacto')[0].checkValidity()) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('mensajes.store') }}',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "nombre": $('#nombre').val(),
                            "correo": $('#correo').val(),
                            "telefono": $('#telefono').val(),
                            "mensaje": $('#mensaje').val(),
                        },
                        dataType: 'JSON',
                        beforeSend: function () {
                        },
                        success: function (response) {
                            if (response.success) {
                                $('#mensaje_respuesta').html('<div class="alert alert-success" role="alert">Hemos recibido tu mensaje, nos pondremos en contacto contigo a la brevedad</div>');
                                $('#form-contacto')[0].reset();
                            } else {
                                $('#mensaje_respuesta').html('<div class="alert alert-danger" role="alert">Hubo un error al enviar tu mensaje, intente nuevamente</div>')
                            }
                        },
                        error: function (err) {
                            console.log(err);
                        }
                    });
                } else {
                    $('#mensaje_respuesta').html('<div class="alert alert-danger" role="alert">Ingrese todos lo datos.</div>')
                }
            });
        });
    </script>
@endsection
