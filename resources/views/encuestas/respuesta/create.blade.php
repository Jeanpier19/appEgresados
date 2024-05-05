@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <section class="card card-default">
            {!! Form::open(array('route' => 'respuestas.store','method'=>'POST')) !!}
            <header class="card-header card-header-xl">
                <h5><b>{{$encuesta->titulo}}</b></h5>
                <h6><em>{{$encuesta->descripcion}}</em></h6>
                <input name="encuesta_id" type="hidden" value="{{$encuesta->id}}">
            </header>
            <div class="card-block">
                @foreach($grupos as $index => $grupo)
                    <h3>{{$grupo->nombre_grupo}}</h3>
                    <section>
                        @foreach($preguntas as $pregunta)
                            @if($pregunta->grupo == $grupo->grupo)
                                <div class="form-group">
                                    <label for="exampleInputEmail1"><b>{{$pregunta->titulo}}</b></label><br>
                                    @switch($pregunta->tipo)
                                        @case('Opción multiple')
                                        @foreach(json_decode($pregunta->opciones) as $index => $opcion)
                                            <div class="radio">
                                                <input name="{{$pregunta->id}}" id="radio-{{$pregunta->id}}{{$index}}"
                                                       type="radio" value="{{$opcion}}"/>
                                                <label for="radio-{{$pregunta->id}}{{$index}}">{{$opcion}}</label>
                                            </div>
                                        @endforeach
                                        @break
                                        @case('Casilla de verificación')
                                        @foreach(json_decode($pregunta->opciones) as $index => $opcion)
                                            <div class="checkbox">
                                                <input name="{{$pregunta->id}}" id="check-{{$pregunta->id}}{{$index}}"
                                                       type="checkbox" value="{{$opcion}}"/>
                                                <label for="check-{{$pregunta->id}}{{$index}}">{{$opcion}}</label>
                                            </div>
                                        @endforeach
                                        @break
                                        @case('Respuesta Breve')
                                        <input type="text" id="{{$pregunta->id}}" name="{{$pregunta->id}}" class="form-control">
                                        @break
                                        @case('Párrafo')
                                        <textarea name="{{$pregunta->id}}" rows="5" cols="50" class="form-control"></textarea>
                                        @break
                                    @endswitch
                                </div>
                            @endif
                        @endforeach
                    </section>
                @endforeach
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Enviar</button>
            </div>
            {!! Form::close() !!}
        </section>


    </div>
@endsection
