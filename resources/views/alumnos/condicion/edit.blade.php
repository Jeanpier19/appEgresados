@extends('layouts.app')
@section('css')
@endsection
@section('content')
    <div class="container-fluid">
        <section class="card">
            <header class="card-header">
                <div class="pull-left">
                    <ol class="breadcrumb breadcrumb-simple">
                        <li><a href="{{route('home')}}">Inicio</a></li>
                        <li><a href="{{route('alumnos.index')}}">Alumnos</a></li>
                        <li class="active">Editar</li>
                    </ol>
                </div>
                <div class="pull-right">
                    <a href="{{route('alumnos.index')}}" class="btn btn-inline btn-secondary btn-rounded btn-sm"><i
                            class="fa fa-angle-left"></i> Atrás</a>
                </div>
            </header>
            {!! Form::model($condicion_alumno, ['id'=>'alumnos','method' => 'PATCH','route' => ['alumnos.condicion.update', $condicion_alumno->id]]) !!}
            <div class="card-block">
                @if (count($errors) > 0)
                    <div class="alert alert-danger alert-no-border alert-close alert-dismissible fade in">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Whoops!</strong> Hubo algunos problemas con su entrada.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="row">
                    <div class="col-xs-12 col-sm-4 col-md-4">
                        <div class="form-group">
                            <strong>Código de local:</strong>
                            {{ Form::select('codigo_local',$codigo_local->pluck('descripcion','valor'), null, array('id' => 'codigo_local','class' => 'bootstrap-select','data-live-search'=>'true','title'=>'Seleccione...','required')) }}
                        </div>
                    </div>
                    @if(in_array($condicion_alumno->condicion_id, [1,2,3]))
                        <div class="col-xs-12 col-sm-4 col-md-4">
                            <div class="form-group">
                                <strong>Facultad:</strong>
                                {{ Form::select('facultad_id',$facultad->pluck('nombre','id'), null, array('id' => 'facultad_id','class' => 'select2')) }}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4 col-md-4">
                            <div class="form-group">
                                <strong>Escuela:</strong>
                                {{ Form::select('escuela_id',$escuela->pluck('nombre','id'), null, array('id' => 'escuela_id','class' => 'select2')) }}
                            </div>
                        </div>
                    @endif
                    @if(in_array($condicion_alumno->condicion_id, [2]))
                        <div class="col-xs-12 col-sm-4 col-md-4">
                            <div class="form-group">
                                <strong>Grado:</strong>
                                <select name="grado_id" id="grado_id" class="select2" disabled>
                                </select>
                            </div>
                        </div>
                    @endif
                    @if(in_array($condicion_alumno->condicion_id, [3]))
                        <div class="col-xs-12 col-sm-4 col-md-4">
                            <div class="form-group">
                                <strong>Títuto:</strong>
                                <select name="titulo_id" id="titulo_id" class="select2" disabled>
                                </select>
                            </div>
                        </div>
                    @endif
                    @if(in_array($condicion_alumno->condicion_id, [4,5]))
                        <div class="col-xs-12 col-sm-4 col-md-4">
                            <div class="form-group">
                                <strong>Maestría:</strong>
                                {{ Form::select('maestria_id',$maestrias->pluck('nombre','id'), null, array('id' => 'maestria_id','class' => 'select2')) }}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4 col-md-4">
                            <div class="form-group">
                                <strong>Mención:</strong>
                                {{ Form::select('mencion_id',[], null, array('id' => 'mencion_id','class' => 'select2')) }}
                            </div>
                        </div>
                    @endif
                    @if(in_array($condicion_alumno->condicion_id, [6,7]))
                        <div class="col-xs-12 col-sm-4 col-md-4">
                            <div class="form-group">
                                <strong>Doctorado:</strong>
                                {{ Form::select('doctorado_id',$doctorados->pluck('nombre','id'), null, array('id' => 'doctorado_id','class' => 'select2')) }}
                            </div>
                        </div>
                    @endif
                    @if(in_array($condicion_alumno->condicion_id, [1,4,6]))
                        <div class="col-xs-12 col-sm-4 col-md-4">
                            <div class="form-group">
                                <strong>Semestre Ingreso:</strong>
                                {{ Form::select('semestre_ingreso',$semestres->pluck('descripcion','id'), null, array('id' => 'semestre_ingreso','class' => 'select2')) }}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4 col-md-4">
                            <div class="form-group">
                                <strong>Semestre Egreso:</strong>
                                {{ Form::select('semestre_egreso',$semestres->pluck('descripcion','id'), null, array('id' => 'semestre_egreso','class' => 'select2')) }}
                            </div>
                        </div>
                    @endif
                    <div class="col-xs-12 col-sm-4 col-md-4">
                        <div class="form-group">
                            <strong>Resolución:</strong>
                            {!! Form::text('resolucion', null, array('id'=>'resolucion','placeholder' => 'Resolución','class' => 'form-control')) !!}
                        </div>
                    </div>
                    @if(in_array($condicion_alumno->condicion_id, [2,3,5,7]))
                        <div class="col-xs-12 col-sm-4 col-md-4">
                            <div class="form-group">
                                <strong>Fecha:</strong>
                                {!! Form::date('fecha', null, array('id'=>'fecha','placeholder' => 'Fecha','class' => 'form-control')) !!}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="card-footer">
                <div id="panel_condiciones"></div>
                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-save"></i> Guardar
                </button>
            </div>
            {!! Form::close() !!}
        </section>
    </div><!--.container-fluid-->
@endsection
@section('js')
    <script type="text/javascript">
        $(document).ready(function () {
            seleccionar_facultad();
            seleccionar_maestria();

            function seleccionar_facultad() {
                $('#facultad_id').on('change', function () {
                    let id = $(this).val();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: 'POST',
                        url: "{{route('facultad.escuelas')}}",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "facultad_id": id,
                        },
                        dataType: 'JSON',
                        beforeSend: function () {
                        },
                        success: function (response) {
                            let escuelas = "";
                            let grados = "";
                            let titulos = "";
                            $.each(response, function (index, value) {
                                escuelas += '<option value="' + value['id'] + '">' + value['nombre'] + '</option>';
                                grados += '<option value="' + value['id'] + '">' + value['grado'] + '</option>';
                                titulos += '<option value="' + value['id'] + '">' + value['titulo'] + '</option>';
                            });
                            $('#escuela_id').html(escuelas);
                            $('#grado_id').html(grados);
                            $('#titulo_id').html(titulos);
                            seleccionar_grado();
                        },
                        error: function (err) {
                            console.log(err);
                        }
                    });
                });
            }

            function seleccionar_maestria() {
                $('#maestria_id').on('change', function () {
                    let id = $(this).val();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: 'POST',
                        url: "{{route('maestria.menciones')}}",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "maestria_id": id,
                        },
                        dataType: 'JSON',
                        beforeSend: function () {
                        },
                        success: function (response) {
                            let menciones = "";
                            $.each(response.data, function (index, value) {
                                menciones += '<option value="' + value['id'] + '">' + value['nombre'] + '</option>'
                            });
                            $('#mencion_id').html(menciones);
                        },
                        error: function (err) {
                            console.log(err);
                        }
                    });
                });
            }

            function seleccionar_grado() {
                $('#escuela_id').on('change', function () {
                    let id = $(this).val();
                    $('#grado_id').val(id).trigger('change');
                    $('#titulo_id').val(id).trigger('change');
                })
            }
        });
    </script>
@endsection
