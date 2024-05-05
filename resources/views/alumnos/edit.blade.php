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
            {!! Form::model($alumno, ['id'=>'alumnos','method' => 'PATCH','route' => ['alumnos.update', $alumno->id]]) !!}
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
                    <div class="col-xs-12 col-sm-3 col-md-3">
                        <div class="form-group has-validation">
                            <strong>Tipo documento:</strong>
                            {{ Form::select('tipo_documento',$tipo_documento->pluck('descripcion','id'), null, array('id' => 'tipo_documento','class' => 'bootstrap-select','title'=>'Seleccione...','required')) }}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-3 col-md-3">
                        <div class="form-group">
                            <strong>N° Documento:</strong>
                            {!! Form::text('num_documento', null, array('id'=>'num_documento','placeholder' => 'N° Documento','class' => 'form-control','required','maxlength'=>'8')) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-3 col-md-3">
                        <div class="form-group">
                            <strong>Código de alumno:</strong>
                            {!! Form::text('codigo', null, array('id'=>'codigo','placeholder' => 'Código de alumno','class' => 'form-control','required')) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-3 col-md-3">
                        <div class="form-group">
                            <strong>Nombres:</strong>
                            {!! Form::text('nombres', null, array('id'=>'nombres','placeholder' => 'Nombres','class' => 'form-control','required')) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-3 col-md-3">
                        <div class="form-group">
                            <strong>Apellido Paterno:</strong>
                            {!! Form::text('paterno', null, array('id'=>'paterno','placeholder' => 'Apellido Paterno','class' => 'form-control','required')) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-3 col-md-3">
                        <div class="form-group">
                            <strong>Apellido Materno:</strong>
                            {!! Form::text('materno', null, array('id'=>'materno','placeholder' => 'Apellido Materno','class' => 'form-control','required')) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-3 col-md-3">
                        <div class="form-group">
                            <strong>Género:</strong>
                            {{ Form::select('sexo',['Femenino'=>'Femenino','Masculino'=>'Masculino'], null, array('id' => 'sexo','class' => 'bootstrap-select','title'=>'Seleccione...','required')) }}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-3 col-md-3">
                        <div class="form-group">
                            <strong>Correo electrónico:</strong>
                            {!! Form::text('correo', null, array('id'=>'correo','placeholder' => 'Correo electrónico','class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="form-group">
                            <strong>Dirección:</strong>
                            {!! Form::text('direccion', null, array('id'=>'direccion','placeholder' => 'Dirección','class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-3 col-md-3">
                        <div class="form-group">
                            <strong>Celular:</strong>
                            {!! Form::text('celular', null, array('id'=>'celular','placeholder' => 'Celular','class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-3 col-md-3">
                        <div class="form-group">
                            <strong>Teléfono:</strong>
                            {!! Form::text('telefono', null, array('id'=>'telefono','placeholder' => 'Teléfono','class' => 'form-control')) !!}
                        </div>
                    </div>
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
