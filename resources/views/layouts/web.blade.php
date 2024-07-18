<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="UNASAM">
    <meta name="keywords"
        content="Egresados, Graduados, Titulados, UNASAM, Sistema de Gestión y Seguimiento de Egresados,Universidad Nacional Santiago Antúnez de Mayolo">
    <meta name="description"
        content="Sistema de Gestión y Seguimiento de Egresados, Graduados y Titulados de la Universidad Nacional Santiago Antúnez de Mayolo">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Loading Bootstrap -->
    <link href="{{ asset('web/css/bootstrap.min.css') }}" rel="stylesheet">
    @yield('css')

    <!-- Loading Template CSS -->
    <link href="{{ asset('web/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('web/css/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('web/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('web/css/style-magnific-popup.css') }}" rel="stylesheet">
    <script src="{{ asset('web/js/bootstrap.min.js') }}"></script>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com/">
    <link
        href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&amp;family=Open+Sans:ital@0;1&amp;display=swap"
        rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Font Favicon -->
    <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}">
    <style>
        .badge-light {
            background: #fff;
            color: #0a0a0a;
        }

        .navbar-nav:hover .nav-link:hover {
            color: #3c49c5;
        }
    </style>
</head>

<body>

    <!-- begin header -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
            <div class="container">
                <!-- begin logo -->
                <a class="navbar-brand" href="{{ route('welcome') }}">
                    <img src="{{ asset('img/logotipo-large.png') }}" width="120px" alt="">
                </a>
                <!-- end logo -->

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll"
                    aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"><i class="bi bi-list"></i></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarScroll">
                    <!-- begin navbar-nav -->
                    <ul class="navbar-expand d-flex m-2">
                        <li class="nav-item"><a class="nav-link text-dark" style="font-size: 15px;" href="{{ route('welcome') }}">Inicio</a></li>
                        <li class="nav-item"><a class="nav-link text-dark" style="font-size: 15px;" href="{{ route('bolsa_trabajo') }}">Bolsa de Trabajo</a></li>
                        <li class="nav-item"><a class="nav-link text-dark" style="font-size: 15px;" href="{{ route('oferta_capacitaciones') }}">Capacitaciones</a></li>
                        <li class="nav-item"><a class="nav-link text-dark" style="font-size: 15px;" href="{{ route('convenios') }}">Convenios</a></li>
                        <li class="nav-item"><a class="nav-link text-dark" style="font-size: 15px;" href="{{ route('encuestas') }}">Encuestas</a></li>
                        <li class="nav-item"><a class="nav-link text-dark" style="font-size: 15px;" href="{{ route('contactos') }}">Contáctanos</a></li>
                    </ul>

                    <div class="d-flex">
                        <a href="{{ route('login') }}">
                            <button type="button" class="btn btn-link"><i class="bi bi-person"></i> Iniciar
                                Sesión</button>
                        </a>
                        <a href="{{ route('register') }}">
                            <button type="button" class="btn btn-primary">Registrarse</button>
                        </a>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <main>

        @yield('content')
        <div class="footer" style="background: #fff">
            <div class="container">
                <div class="row">
                    <div class="col-md-7">
                        <p>© {{ date('Y') }} <span class="template-name">UNASAM</span>. Derechos reservados</p>
                    </div>
                    <div class="col-md-5">
                        <ul class="text-left">
                            <li>Contáctanos:</li>
                            <li><img src="{{asset('img/icons/contacts.png')}}" style="height: 25px"> <a style="color: #3d59d3;" href="{{route('contactos')}}">Envía tus comentarios aquí</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Load JS here for greater good =============================-->
    <script src="{{ asset('web/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('web/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('web/js/jquery.scrollTo-min.js') }}"></script>
    <script src="{{ asset('web/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('web/js/jquery.nav.js') }}"></script>
    <script src="{{ asset('web/js/wow.js') }}"></script>
    <script src="{{ asset('web/js/plugins.js') }}"></script>
    <script src="{{ asset('web/js/custom.js') }}"></script>
    <script src="{{ asset('startui/js/lib/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
    @yield('js')
</body>

</html>
