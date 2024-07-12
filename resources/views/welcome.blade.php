@extends('layouts.web')

@section('css')
    <style>
        .carousel-item {
            transition: transform 1s ease;
        }

        .carousel-item.left {
            transform: translateX(-100%);
        }

        .carousel-item.right {
            transform: translateX(100%);
        }

        .carousel-principal {
            padding-top: 130px;
            padding-bottom: 25px;
        }

        .carousel-principal::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 800px;
            background-image: url('img/logoPrincipalBanner/imagen.jpg');
            /* Reemplaza 'ruta/de/tu/imagen.jpg' con la ruta de tu imagen de fondo */
            background-size: cover;
            background-position: center;
            z-index: -1;
        }

        .social-bar {
            position: fixed;
            top: 50%;
            transform: translateY(-50%);
            right: 20px;
            z-index: 1000;
        }

        .social-bar a {
            display: block;
            font-size: 20px;
            margin-bottom: 10px;
            color: #fff;
            width: 40px;
            height: 40px;
            text-align: center;
            line-height: 40px;
            border-radius: 50%;
            transition: background-color 0.3s ease;
        }

        .social-bar a:hover {
            background-color: #555;
            color: #e2197e;
        }

        .facebook {
            background-color: #3b5998;
        }

        .twitter {
            background-color: #1da1f2;
        }

        .instagram {
            background-color: #e2197e;
        }
        .youtube {
            background-color: #e4405f;
        }
        .social-bar a i:hover {
            color: #e2197e;
        }
    </style>
@endsection

@section('content')
    <section class="carousel-container">
        <div id="carouselExample" class="carousel slide">
            <div class="carousel-inner d-flex justify-content-center">
                <div class="carousel-indicators d-none">
                    @foreach ($carousel as $key => $slide)
                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="{{ $key }}"
                            class="{{ $loop->first ? 'active' : '' }}" aria-current="{{ $loop->first ? 'true' : 'false' }}"
                            aria-label="Slide {{ $key + 1 }}"></button>
                    @endforeach
                </div>
                <div class="carousel-principal">
                    @forelse ($carousel as $slide)
                        <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                            <img src="/banner/{{ $slide->imagen }}" class="d-block  border border-white"
                                style="max-height: 490px; object-fit: contain;" alt="{{ $slide->nombre }}">
                        </div>
                    @empty
                        <div class="text-center mx-5 px-5">
                            <img class="" src="{{ asset('img/icons/banner.png') }}" alt="">
                            <h1 class="text-white">Banners</h1>
                            <p class="text-white">No existen banners en este momento</p>
                        </div>
                    @endforelse
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </section>

    <!-- Redes Sociales Barra Flotante -->
    <div class="social-bar">
        <a href="https://www.facebook.com/profile.php?id=100076293338986" target="_blank" class="facebook">
            <i class="fab fa-facebook"></i>
        </a>
        <a href="https://twitter.com/DsceUnasam96090/" target="_blank" class="twitter">
            <i class="fab fa-twitter"></i>
        </a>
        <a href="https://www.instagram.com/dscegresados/" target="_blank" class="instagram">
            <i class="fab fa-instagram"></i>
        </a>
        <a href="https://www.youtube.com/channel/UCP89yg9JPKA3Gy0rpuuAn9A/" target="_blank" class="youtube">
            <i class="fab fa-youtube"></i>
        </a>
        <!-- Agrega más redes sociales según sea necesario -->
    </div>
    <!-- Fin Redes Sociales Barra Flotante -->

    <!-- Nosotros -->
    <section class="section-grey" id="about">
        <!--begin container -->
        <div class="container">

            <!--begin row -->
            <div class="row align-items-center text-center">
                <!--begin col-md-5 -->
                <div class="col-md-5 col-sm-12">
                    <img src="{{ asset('img/logo-unasam-positivo.png') }}" width="80px" alt="">
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
                                La misión de la Dirección de Seguimiento y Certificación a los Egresados tiene
                                como
                                visión la de establecer una amplia red de comunicación nacional e internacional
                                entre egresados y graduados de la Universidad, que permita la constante
                                retroalimentación sobre el quehacer institucional y el desempeño profesional de
                                sus
                                egresados y graduados, fortalecer los recursos necesarios para la actualización
                                continua de la información de los egresados y graduados. con ello brindar
                                beneficios
                                a sus beneficiarios, de tal forma que el sector más numeroso de nuestra
                                comunidad
                                Universitaria, se considere una de las principales fortalezas institucionales a
                                nivel Regional y Nacional.
                            </div>
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
                    <img src="{{ asset('img/icons/graduado.png') }}" alt="comunicados" width="50px">
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
                    <p class="fun-facts-title"><span class="facts-numbers">{{ $cantidad_egresados }}</span><br>Egresados
                    </p>
                </div>
                <!--end fun-facts-box -->
                <!--begin fun-facts-box -->
                <div class="col-md-2 fun-facts-box red text-center">

                    <i class="bi bi-award-fill"></i>

                    <p class="fun-facts-title"><span class="facts-numbers">{{ $cantidad_graduados }}</span><br>Graduados
                    </p>

                </div>
                <!--end fun-facts-box -->

                <!--begin fun-facts-box -->
                <div class="col-md-2 fun-facts-box green text-center">

                    <i class="bi bi-award"></i>

                    <p class="fun-facts-title"><span class="facts-numbers">{{ $cantidad_titulados }}</span><br>Titulados
                    </p>

                </div>
                <!--end fun-facts-box -->

                <!--begin fun-facts-box -->
                <div class="col-md-2 fun-facts-box yellow text-center">

                    <i class="bi bi-award-fill"></i>

                    <p class="fun-facts-title"><span
                            class="facts-numbers">{{ $cantidad_magisteres }}</span><br>Magísteres
                    </p>

                </div>
                <!--end fun-facts-box -->

                <!--begin fun-facts-box -->
                <div class="col-md-2 fun-facts-box blue-sky text-center">

                    <i class="bi bi-award"></i>

                    <p class="fun-facts-title"><span class="facts-numbers">{{ $cantidad_doctores }}</span><br>Doctores
                    </p>

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
                    <img src="{{ asset('img/icons/megafono.png') }}" alt="comunicados" width="50px">
                    <h2>Comunicados</h2>
                </div>
            </div>
            <!--begin row -->
            @if (count($comunicados) > 0)
                <div class="row">
                    <!--begin col md 12 -->
                    <div class="col-md-12 mx-auto padding-top-10">
                        <!--begin carrusel de comunicados -->
                        <div id="carouselComunicados" class="carousel slide" data-bs-ride="carousel">
                            <!-- Contenido del carrusel -->
                            <div class="carousel-inner">
                                @foreach ($comunicados as $index => $comunicado)
                                    <div class="carousel-item items @if ($index === 0) active @endif">
                                        <div class="row align-items-center testim-inner"
                                            style="max-width: 1500px; margin: 0 auto;">
                                            <div class="col-md-6">
                                                <!-- Aquí coloca tu contenido de imagen o video -->
                                                @if ($comunicado->imagen)
                                                    <img src="{{ asset($comunicado->imagen) }}" alt="comunicados"
                                                        class="width-100 image-shadow video-popup-image responsive-bottom-margins"
                                                        style="max-width: 300px; height: auto;">
                                                @endif
                                                @if ($comunicado->video)
                                                    <a class="popup4 video-play-icon" href="{{ $comunicado->video }}">
                                                        <i class="bi bi-caret-right-fill"></i>
                                                    </a>
                                                @endif
                                            </div>
                                            <div class="col-md-6 testim-info">
                                                <i class="bi bi-chat-left-quote green"></i>
                                                <h4>{{ $comunicado->titulo }}</h4>
                                                <p>{{ $comunicado->descripcion }}</p>
                                                @if ($comunicado->link)
                                                    <a href="{{ $comunicado->link }}" class="scrool" target="_blank">
                                                        <button type="button" class="btn btn-sm btn-primary">Ver
                                                            más</button>
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

                <!-- Botones de navegación personalizados con espacio vertical -->
                <div class="row m-5">
                    <div class="col-md-12 text-center">
                        <button class="btn btn-circular btn-primary" onclick="$('#carouselComunicados').carousel('prev')">
                            &lt; <!-- Símbolo de menor: < -->
                        </button>

                        <!-- Botones numerados -->
                        <div class="btn-group">
                            @for ($i = 0; $i < min(3, count($comunicados)); $i++)
                                <button class="btn btn-numero @if ($i === 0) btn-activo @endif"
                                    onclick="$('#carouselComunicados').carousel({{ $i }})">{{ $i + 1 }}</button>
                            @endfor
                            @if (count($comunicados) > 3)
                                <span class="btn btn-puntos-suspensivos">...</span>
                                <button class="btn btn-numero"
                                    onclick="$('#carouselComunicados').carousel({{ count($comunicados) - 1 }})">{{ count($comunicados) }}</button>
                            @endif
                        </div>
                        <!-- end botones numerados -->

                        <button class="btn btn-circular btn-primary" onclick="$('#carouselComunicados').carousel('next')">
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
@endsection

@section('scripts')
    <!-- Scripts de Bootstrap -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>

    <!-- Estilos personalizados -->
    <style>
        .btn-circular {
            border-radius: 50%;
            padding: 10px 15px;
            font-size: 18px;
        }

        .btn-numero {
            padding: 10px 15px;
            font-size: 18px;
        }

        .btn-activo {
            background-color: #007bff;
            color: #fff;
        }

        .btn-puntos-suspensivos {
            cursor: default;
            pointer-events: none;
            padding: 10px 15px;
            font-size: 18px;
        }

        .items img {
            max-width: 100%;
            height: auto;
        }

        .testim-info {
            text-align: left;
        }

        .testim-inner {
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .bi-caret-right-fill {
            font-size: 2rem;
        }

        .carousel-container {
            width: 100%;
            overflow: hidden;
        }
    </style>
@endsection
