@extends('layouts.web')
@section('content')

<!-- Encuestas -->

<section class="section-white" id="encuestas">
        <div class="container" style="margin-top: 70px;">
            <div class="row">
                <div class="col-md-12 text-center padding bottom-20">
                    <img src="{{asset('img/icons/exam.png')}}" alt="oferta laboral" width="50px">
                    <h2>Encuesta</h2>
                </div>
                @if($encuesta)
                    <div class="col-md-12">
                        <div class="main-services">
                            <i class="bi bi-file-earmark-check-fill green"></i>
                            <h4>{{$encuesta->titulo}}</h4>
                            <p>{{$encuesta->descripcion}}</p>
                            <a href="{{route('respuestas.create')}}" class="scrool">
                                <button type="button" class="btn btn-sm btn-primary">Ingresar</button>
                            </a>
                        </div>
                    </div>
                @else
                    <p class="text-muted text-center">No hay ninguna encuesta por el momento</p>
                @endif
            </div>
        </div>
    </section>
@endsection
