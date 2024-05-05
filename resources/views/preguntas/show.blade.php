@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <section class="card">
            <header class="card-header">
                <div class="pull-left">
                    <ol class="breadcrumb breadcrumb-simple">
                        <li><a href="{{route('home')}}">Inicio</a></li>
                        <li><a href="{{route('preguntas.index')}}">Usuarios</a></li>
                        <li class="active">Ver</li>
                    </ol>
                </div>
                <div class="pull-right">
                    <a href="{{route('preguntas.index')}}" class="btn btn-inline btn-secondary btn-rounded btn-sm"><i
                            class="fa fa-angle-left"></i> Atrás</a>
                </div>
            </header>
            <div class="card-block">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Pregunta:</strong>
                        {{ $pregunta->titulo }}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Descripción:</strong>
                        {{ $pregunta->descripcion }}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Tipo:</strong>
                        {{ $pregunta->tipo }}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Indicador:</strong>
                        {{ $pregunta->indicador }}
                    </div>
                </div>
                @if(isset($pregunta->opciones))
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Opciones:</strong>
                        @foreach(json_decode($pregunta->opciones) as $opcion)
                            <div class="checkbox-bird">
                                <input type="checkbox"/>
                                <label>{{ $opcion }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
                    @endif
            </div>
        </section>
    </div><!--.container-fluid-->
@endsection
