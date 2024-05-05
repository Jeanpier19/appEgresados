<nav class="side-menu">
    <div class="side-menu-avatar">
        <div class="avatar-preview avatar-preview-100">
            @switch (Auth::user()->getRoleNames()[0])
                @case('Administrador')
                <img src="@if( Auth::user()->avatar){{asset(Auth::user()->avatar)}}@else{{asset('startui/img/avatar-1-256.png')}}@endif"
                     alt="">
                @break
                @case('Egresado')
                <img src="@if($perfil->avatar){{asset($perfil->avatar)}}@else{{asset('startui/img/avatar-1-256.png')}}@endif"
                     alt="">
                @break
            @endswitch
        </div>
    </div>
    <div>
        <header class="side-menu-title">General</header>
    </div>

    <ul class="side-menu-list">
        <li class="blue-dark">
            <a href="{{route('home')}}">
                <i class="font-icon font-icon-dashboard {{ (request()->is('home')) ? 'active' : '' }}"></i>
                <span class="lbl">Dashboard</span>
            </a>
        </li>
        @switch (Auth::user()->getRoleNames()[0])
            @case('Administrador')
            <li class="blue-dark with-sub"><span>
                <i class="fa fa-user-graduate {{ (request()->is('egresado*','documento*')) ? 'active' : '' }}"></i>
                <span class="lbl">Gestión Académica</span></span>
                <ul>
                    <li><a href="{{route('alumnos.index')}}"><span class="lbl">Alumnos</span></a></li>
                    <li><a href="{{route('egresado.index')}}"><span class="lbl">Egresado</span></a></li>
                    <li><a href="{{route('documento.index')}}"><span class="lbl">Documentos</span></a></li>
                </ul>
            </li>
            <li class="blue-dark with-sub"><span>
                <i class="fa fa-poll {{ (request()->is('encuestas*','preguntas*')) ? 'active' : '' }}"></i>
                <span class="lbl">Encuesta</span></span>
                <ul>
                    <li><a href="{{route('encuestas.index')}}"><span class="lbl">Gestionar</span></a></li>
                    <li><a href="{{route('preguntas.index')}}"><span class="lbl">Banco de Preguntas</span></a></li>
                </ul>
            </li>
            <li class="blue-dark with-sub"><span><i
                        class="fa fa-briefcase {{ (request()->is('ofertas_laborales*','postulaciones*')) ? 'active' : '' }}"></i>
                <span class="lbl">Ofertas Laborales</span></span>
                <ul>
                    <li><a href="{{route('ofertas_laborales.index')}}"><span class="lbl">Gestionar</span></a></li>
                    <li><a href="{{route('postulaciones.index')}}"><span class="lbl">Postulaciones</span></a></li>
                </ul>
            </li>
            <li class="blue-dark with-sub"><span>
                    <i class="fa fa-chalkboard-teacher {{ (request()->is('ofertas_capacitaciones*')) ? 'active' : '' }}"></i>
                    <span class="lbl">Ofertas Capacitación</span></span>
                <ul>
                    <li><a href="{{route('ofertas_capacitaciones.index')}}"><span class="lbl">Gestionar</span></a></li>
                    <li><a href="{{route('ofertas_capacitaciones.postulacion')}}"><span class="lbl">Postulaciones</span></a>
                    </li>
                </ul>
            </li>
            <li class="blue-dark">
                <a href="{{route('convenios.index')}}">
                    <i class="fa fa-scroll {{ (request()->is('convenios')) ? 'active' : '' }}"></i>
                    <span class="lbl">Convenios</span>
                </a>
            </li>
            <li class="blue-dark">
                <a href="{{route('comunicados.index')}}">
                    <i class="fa fa-newspaper {{ (request()->is('comunicados')) ? 'active' : '' }}"></i>
                    <span class="lbl">Comunicados</span>
                </a>
            </li>
            <header class="side-menu-title">Administración</header>
            <li class="blue-dark with-sub"><span>
                <i class="font-icon font-icon-dashboard {{ (request()->is('entidades*')) ? 'active' : '' }}"></i>
                <span class="lbl">Mantenedores</span></span>
                <ul>
                    <li><a href="{{route('facultad.index')}}"><span class="lbl">Facultad</span></a></li>
                    <li><a href="{{route('escuela.index')}}"><span class="lbl">Escuela</span></a></li>
                    <li><a href="{{route('doctorado.index')}}"><span class="lbl">Doctorado</span></a></li>
                    <li><a href="{{route('maestrias.index')}}"><span class="lbl">Maestrías</span></a></li>
                    <li><a href="{{route('menciones.index')}}"><span class="lbl">Menciones</span></a></li>
                    <li><a href="{{route('anio.index')}}"><span class="lbl">Año Académico</span></a></li>
                    <li><a href="{{route('semestre.index')}}"><span class="lbl">Semestre Académico</span></a></li>
                    <li><a href="{{route('oge.index')}}"><span class="lbl">Director de OGE</span></a></li>
                    <li><a href="{{route('sge.index')}}"><span class="lbl">Director de SGE</span></a></li>
                    <li><a href="{{route('tipo.index')}}"><span class="lbl">Tipo de Documentos</span></a></li>
                    <li><a href="{{route('entidades.index')}}"><span class="lbl">Entidades</span></a></li>
                </ul>
            </li>
            <li class="blue-dark with-sub"><span><i
                        class="font-icon font-icon-users {{ (request()->is('usuarios*')) ? 'active' : '' }}"></i>
                <span class="lbl">Usuarios</span></span>
                <ul>
                    <li><a href="{{route('usuarios.index')}}"><span class="lbl">Gestionar</span></a></li>
                    <li><a href="{{route('roles.index')}}"><span class="lbl">Roles</span></a></li>
                </ul>
            </li>
            <li class="blue-dark with-sub">
                <span>
                    <i class="fa fa-chart-area {{ (request()->is('reportes*')) ? 'active' : '' }}"></i>
                    <span class="lbl">Reportes</span>
                </span>
                <ul>
                    <li><a href="{{route('reportes.index')}}"><span class="lbl">Egresados</span></a></li>
                    <li><a href="{{route('reportes.index2')}}"><span class="lbl">Graduados</span></a></li>
                    <li><a href="{{route('reportes.index_ofertas')}}"><span class="lbl">Ofertas Capacitación</span></a>
                    </li>
                </ul>
            </li>
            <li class="blue-dark">
                <a href="{{route('data.create')}}">
                    <i class="fa fa-database {{ (request()->is('data')) ? 'active' : '' }}"></i>
                    <span class="lbl">Datos</span>
                </a>
            </li>
            <li class="blue-dark">
                <a href="{{route('mensajes.index')}}">
                    <i class="fa fa-comment-alt {{ (request()->is('mensajes')) ? 'active' : '' }}"></i>
                    <span class="lbl">Mensajes</span>
                </a>
            </li>
            @break
            @case('Egresado')
            <li class="blue-dark">
                <a href="{{route('experiencia.index')}}">
                    <i class="glyphicon glyphicon-pushpin {{ (request()->is('experiencia')) ? 'active' : '' }}"></i>
                    <span class="lbl">Mis Experiencias Laborales</span>
                </a>
            </li>
            <li class="blue-dark">
                <a href="{{route('capacitaciones.index')}}">
                    <i class="glyphicon glyphicon-book {{ (request()->is('capacitaciones')) ? 'active' : '' }}"></i>
                    <span class="lbl">Mis Capacitaciones</span>
                </a>
            </li>
            <li class="blue-dark with-sub">
                <span>
                    <i class="glyphicon glyphicon-file {{ (request()->is('reportes*')) ? 'active' : '' }}"></i>
                    <span class="lbl">Mis expectativas</span>
                </span>
                <ul>
                    <li><a href="{{route('necesidad-capacitaciones.index')}}"><span
                                class="lbl">Sobre Capacitaciones</span></a></li>
                </ul>
            </li>
            <li class="blue-dark">
                <a href="{{route('ofertas_laborales.index')}}">
                    <i class="fa fa-briefcase {{ (request()->is('ofertas_laborales')) ? 'active' : '' }}"></i>
                    <span class="lbl">Ofertas Laborales</span>
                </a>
            </li>
            <li class="blue-dark">
                <a href="{{route('postulaciones.index')}}">
                    <i class="fa fa-check {{ (request()->is('postulaciones')) ? 'active' : '' }}"></i>
                    <span class="lbl">Postulaciones</span>
                </a>
            </li>
            <li class="blue-dark">
                <a href="{{route('ofertas_capacitaciones.registro')}}">
                    <i class="glyphicon glyphicon-book {{ (request()->is('ofertas_capacitaciones')) ? 'active' : '' }}"></i>
                    <span class="lbl">Ofertas de Capacitación</span>
                </a>
            </li>
            @break
        @endswitch
    </ul>
</nav><!--.side-menu-->
