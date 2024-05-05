@extends('layouts.web')
@section('content')

<!-- Ofertas de capacitación -->
@if($ofertas_capacitaciones)
        <section class="section-grey medium-padding-bottom" id="capacitaciones">
            <div class="container" style="margin-top: 70px;">
                <div class="row">
                    <div class="col-md-12 text-center padding bottom-20">
                        <img src="{{asset('img/icons/teach.png')}}" alt="oferta laboral" width="50px">
                        <h2>Capacitaciones en oferta</h2>
                        <p>En esta sección se presentan cursos de capacitaciones ofertadas por empresas de
                            nuestro país y de nuestra universidad.</p>
                    </div>
                </div>
                <div class="row">
                    @forelse ($ofertas_capacitaciones as $ofertas)
                        <div class="col-md-4">
                            <div class="blog-item">
                                <div class="popup-wrapper">
                                    <div class="popup-gallery">
                                        <a href="@if(strtotime($ofertas->fecha_fin) < strtotime(date("d-m-Y H:i:00", time()))) # @else {{route('ofertas_capacitaciones.registro')}} @endif">
                                            <img
                                                src="@if($ofertas->imagen) {{asset($ofertas->imagen)}} @else {{asset('img/bg2.jpeg')}} @endif"
                                                class="width-100" alt="oferta">
                                            <span class="eye-wrapper2"><i class="bi bi-link-45deg"></i></span>
                                        </a>
                                    </div>
                                </div>
                                <div class="blog-item-inner">
                                    <h3 class="blog-title"><a href="#">{{$ofertas->titulo}}</a></h3>
                                    <a href="#" class="blog-icons last"><i class="bi bi-card-text"></i> Precio
                                        &#8212; @if($ofertas->precio == 0)Gratuito @else {{$ofertas->precio}} @endif</a>
                                    <p>{{$ofertas->oferta_descripcion}}</p>
                                    <div class="students"># Alumnos:
                                        @if ($ofertas->total_alumnos)
                                            {{ $ofertas->total_alumnos }}
                                        @else
                                            0
                                        @endif
                                    </div>
                                    <div class="course-author">
                                        <p class="text-center" style="padding-left:0px">Desarrollado por<br>
                                            <span>{{ $ofertas->entidad }}</span>
                                        </p>
                                    </div>
                                    @if(strtotime($ofertas->fecha_inicio) < strtotime(date("d-m-Y H:i:00", time())))
                                        <div class="btn col-lg-12 btn-inline btn-default"><i>Cerrado</i></div>
                                    @else
                                        <a href="{{route('ofertas_capacitaciones.registro')}}" class="scrool">
                                            <div class="btn col-lg-12 btn-inline btn-success">Registrarse</div>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted text-center">En este momento no hay capacitaciones disponibles,
                            seguiremos
                            trabajando para darte el mejor servicio.</p>
                    @endforelse
                </div>
            </div>
        </section>
    @endif
@endsection