@extends('layouts.web')
@section('content')
<!-- Ofertas laborales -->
@if($ofertas_laborales)
        <section class="section-white medium-padding-bottom" id="bolsa_trabajo">
            <div class="container"  style="margin-top: 70px;">
                <div class="row">
                    <div class="col-md-12 text-center padding bottom-20">
                        <img src="{{asset('img/icons/job.png')}}" alt="oferta laboral" width="50px">
                        <h2>Bolsa de Trabajo</h2>
                        <p>Encuentra las mejores oportunidades laborales en nuestra bolsa de trabajo.</p>
                    </div>
                </div>
                <div class="row">
                    @forelse($ofertas_laborales as $oferta_laboral)
                        <div class="col-md-4">
                            <div class="blog-item">
                                <div class="popup-wrapper">
                                    <div class="popup-gallery">
                                        <a href="#">
                                            <span class="eye-wrapper2"><i class="bi bi-link-45deg"></i></span>
                                        </a>
                                    </div>
                                </div>
                                <div class="blog-item-inner">
                                    <a href="#" class="blog-icons last"><i
                                            class="bi bi-book"></i>{{$oferta_laboral->area}}</a><br>
                                    <h3 class="blog-title"><a href="#">{{$oferta_laboral->titulo}}</a></h3>
                                    <span class="blog-icons last text-muted"><small><i
                                                class="bi bi-briefcase"></i> <i>{{$oferta_laboral->entidad}}
                                        &#8212; {{$oferta_laboral->tipo}}</i></small></span><br>
                                    <span class="blog-icons last text-muted"><small><i
                                                class="bi bi-calendar-date"></i> <i>Fecha de contratación &#8212; {{Carbon\Carbon::create($oferta_laboral->fecha_contratacion)->formatLocalized('%A %d de %B  de %Y')}}</i></small></span><br><br>
                                    <a href="{{route('ofertas_laborales.show', $oferta_laboral->id)}}" class="scrool">
                                        <button type="button" class="btn btn-sm btn-primary">Postular</button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted text-center">En este momento no hay ofertas laborales</p>
                    @endforelse
                </div>
            </div>
        </section>
    @endif
@endsection