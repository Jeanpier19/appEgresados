<header class="site-header">
    <div class="container-fluid">

        <a href="#" class="site-logo">
            <img class="hidden-md-down" src="{{asset('img/logotipo-large.png')}}" alt="">
            <img class="hidden-lg-up" src="{{asset('img/logotipo-short.png')}}" alt="">
        </a>

        <button id="show-hide-sidebar-toggle" class="show-hide-sidebar">
            <span>toggle menu</span>
        </button>

        <button class="hamburger hamburger--htla">
            <span>toggle menu</span>
        </button>
        <div class="site-header-content">
            <div class="site-header-content-in">
                <div class="site-header-shown">
                    @role('Egresado')
                    @if(is_null($encuesta_llenada))
                        @if(isset($encuesta))
                            <a href="{{route('respuestas.create')}}" id="encuesta"
                               class="btn btn-nav btn-rounded btn-inline btn-danger">
                                Llenar encuesta
                            </a>
                        @endif
                    @endif
                    @endrole
                    <div class="dropdown user-menu">
                        <button class="dropdown-toggle" id="dd-user-menu" type="button" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">{{Auth::user()->name }}
                            <img src="{{asset('startui/img/avatar-2-64.png')}}" alt="">
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dd-user-menu">
                            @switch (Auth::user()->getRoleNames()[0])
                                @case('Administrador')
                                <a class="dropdown-item" href="{{route('usuarios.edit',Auth::user()->id)}}">
                                    <span class="font-icon glyphicon glyphicon-user"></span>Perfil
                                </a>
                                @break
                                @case('Egresado')
                                <a class="dropdown-item" href="{{route('perfil.index')}}">
                                    <span class="font-icon glyphicon glyphicon-user"></span>Perfil
                                </a>
                            @break
                        @endswitch
                        <!--                            <a class="dropdown-item" href="#"><span class="font-icon glyphicon glyphicon-cog"></span>Configuración</a>-->
                            <a class="dropdown-item" href="#"><span
                                    class="font-icon glyphicon glyphicon-question-sign"></span>Ayuda</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><span
                                    class="font-icon glyphicon glyphicon-log-out"></span>Salir</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div><!--.site-header-shown-->

            </div><!--site-header-content-in-->
        </div><!--.site-header-content-->
    </div><!--.container-fluid-->
</header><!--.site-header-->
