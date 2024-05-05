@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <section class="card">
            <header class="card-header">
                <div class="pull-left">
                    <ol class="breadcrumb breadcrumb-simple">
                        <li><i class="glyphicon glyphicon-list-alt"></i></li>
                        <li><a href="{{route('home')}}">Inicio</a></li>
                        <li><a href="{{route('preguntas.index')}}">Preguntas</a></li>
                        <li class="active">Crear</li>
                    </ol>
                </div>
                <div class="pull-right">
                    <a href="{{route('preguntas.index')}}"
                       class="btn btn-header btn-inline btn-secondary btn-rounded btn-sm"><i
                            class="fa fa-angle-left"></i> Atrás</a>
                </div>
            </header>
            {!! Form::open(array('route' => 'preguntas.store','method'=>'POST')) !!}
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
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Pregunta:</strong>
                            {!! Form::textarea('titulo', null, array('placeholder' => 'Escriba la pregunta','class' => 'form-control','rows'=>'2','required')) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Descripción:</strong>
                            {!! Form::textarea('descripcion', null, array('placeholder' => 'Descripción','class' => 'form-control','rows'=>'2')) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4">
                        <div class="form-group">
                            <strong>Tipo</strong>
                            {!!Form::select('tipo', ['Respuesta Breve' => 'Respuesta Breve', 'Párrafo' => 'Párrafo','Opción multiple'=>'Opción multiple','Casilla de verificación'=>'Casilla de verificación'], null, ['id'=>'tipo','class'=>'bootstrap-select','title'=>'Elige uno de los siguientes...'])!!}
                            @error('tipo')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-8 col-md-8">
                        <div class="form-group">
                            <strong>Indicador:</strong>
                            {!! Form::text('indicador', null, array('placeholder' => 'Indicador','class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div id="multiple" style="display: none;">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <button id="add_option" type="button" class="btn btn-default btn-sm"><i
                                        class="fa fa-plus-circle"></i> Agregar opción
                                </button>
                            </div>
                        </div>
                        <div id="opciones" class="col-xs-12 col-sm-12 col-md-12">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-save"></i> Guardar</button>
            </div>
            {!! Form::close() !!}
        </section>
    </div><!--.container-fluid-->
@endsection
@section('js')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#tipo').change('change', function () {
                $tipo = $(this).val();
                if ($tipo === 'Opción multiple' || $tipo === 'Casilla de verificación') {
                    $('#multiple').show();
                } else {
                    $('#multiple').hide();
                }
            });
            $('#add_option').on('click', function () {
                let opciones = '<div class="form-group input-group"><div class="input-group-addon"><i class="fa fa-check-circle"></i></div><input name="opciones[]" type="text" class="form-control" placeholder="Agregar una opción"><div class="input-group-btn"><button type="button" class="btn btn-default-outline eliminar_opcion"><i class="fa fa-minus-circle"></i></button></div></div>';
                $("#opciones").append(opciones);
                eliminar_opcion();
            });

            function eliminar_opcion() {
                $('.eliminar_opcion').on('click', function () {
                    $(this).parent().parent().remove();
                });

            }
        });
    </script>
@endsection
