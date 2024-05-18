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
@endsection
