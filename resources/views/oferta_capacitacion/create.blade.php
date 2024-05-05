@extends('layouts.app')
@section('css')
    <link href="{{ asset('web/css/typeahead.min.css') }}" rel="stylesheet">
    <link href="{{ asset('web/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('web/css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/validaciones.css') }}" rel="stylesheet">
    {{-- <link href="{{asset('web/css/font-awesome.min.css')}}" rel="stylesheet"> --}}
    <style>
        .error {
            color: #a94442;
            background-color: #f2dede;
            border-color: #ebccd1;
            padding: 1px 20px 1px 20px;
        }

        label.error {
            color: #a94442;
            background-color: #f2dede;
            border-color: #ebccd1;
            padding: 1px 20px 1px 20px;
        }

    </style>
@endsection
@section('content')
    <div class="container-fluid">
        <section class="card">
            <header class="card-header">
                <div class="pull-left">
                    <ol class="breadcrumb breadcrumb-simple">
                        <li><a href="{{ route('home') }}">Inicio</a></li>
                        <li><a href="{{ route('ofertas_capacitaciones.index') }}">Ofertas Capacitación</a></li>
                        <li class="active">Crear</li>
                    </ol>
                </div>
                <div class="pull-right">
                    <a href="{{ route('ofertas_capacitaciones.index') }}"
                        class="btn btn-inline btn-secondary btn-rounded btn-sm"><i class="fa fa-angle-left"></i> Atrás</a>
                </div>
            </header>

            <input type="hidden" id="data-typehead">
            <input type="hidden" id="type-send">
            {!! Form::open(['route' => 'ofertas_capacitaciones.save', 'method' => 'POST', 'file' => true, 'enctype' => 'multipart/form-data', 'id' => 'form-oferta','onsubmit'=>'return submitContinue();']) !!}
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
                        <div class="card-block">
                            <div class="row">
                                {!! Form::open(['method' => 'POST', 'id' => 'form-curso']) !!}
                                <div class="col-xs-10 col-sm-10 col-md-10">
                                    <div class="form-group">
                                        <strong>Entidad:</strong><br>
                                        {!! Form::select('identidad', $empresa, ['class' => 'form-control'], ['class' => 'custom-select select2', 'id' => 'cidentidad','id'=>'sele-entidad','onchange'=>"seleVal(documento.getElementById('send-oferta',this,true))"]) !!}
                                    </div>
                                    <div class="form-group">
                                        <strong><span class="is-required">*</span>Titulo del curso:</strong>
                                        {!! Form::text('titulo', null, ['placeholder' => 'Ingrese el titulo del cursos', 'class' => 'form-control', 'id' => 'titulo','onkeyup'=>"MaxMinCadenas('send-oferta',100,0,this,true)",'onkeypress'=>"return SoloLetraNumeros('send-oferta',event,this,true)"]) !!}
                                    </div>
                                    <div class="form-group">
                                        <strong><span class="is-required">*</span>Descripción del curso:</strong>
                                        {!! Form::textarea('descripcion_curso', null, ['placeholder' => 'Ingrese una descripción del curso', 'class' => 'form-control', 'id' => 'descripcion_curso','onkeyup'=>"MaxMinCadenas('send-oferta',255,1,this,true)"]) !!}
                                    </div>
                                    <div class="form-group">
                                        <strong><span class="is-required">*</span>Créditos:</strong>
                                        {!! Form::text('creditos', null, ['placeholder' => 'Ingrese la cantidad de créditos', 'class' => 'form-control', 'id' => 'creditos','onkeyup'=>"MaxMinCadenas('send-oferta',2,1,this,true)",'onkeypress'=>"return SoloNumeros('send-oferta',event,this,true)"]) !!}
                                    </div>
                                    <div class="form-group">
                                        <strong><span class="is-required">*</span>Horas:</strong>
                                        {!! Form::text('horas', null, ['placeholder' => 'Ingrese un numero de horas', 'class' => 'form-control', 'id' => 'horas','onkeyup'=>"MaxMinCadenas('send-oferta',3,1,this,true)",'onkeypress'=>"return SoloNumeros('send-oferta',event,this,true)"]) !!}
                                    </div>
                                    <div class="form-group">
                                        <strong>Area:</strong><br>
                                        {!! Form::select('idarea', $area, ['class' => 'form-control'], ['class' => 'custom-select select2', 'id' => 'area']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-10 col-sm-10 col-md-10">
                                    <div class="form-group">
                                        <strong><span class="is-required">*</span>Descripción de la oferta de capacitación:</strong>
                                        {!! Form::textarea('descripcion_oferta', null, ['placeholder' => 'Describa el curso a publicar...', 'class' => 'form-control', 'id' => 'descripcion_oferta','onkeyup'=>"MaxMinCadenas('send-oferta',255,10,this,true)"]) !!}
                                    </div>
                                    <div class="form-group">
                                        <strong>Precio:</strong>
                                        {!! Form::text('precio', null, ['placeholder' => 'Ingrese un precio', 'class' => 'form-control', 'id' => 'precio','onkeyup'=>"MaxMinCadenas('send-oferta',4,1,this,false)",'onkeypress'=>"return SoloNumeros('send-oferta',event,this,false)"]) !!}
                                    </div>
                                    <div class="form-group">
                                        <strong><span class="is-required">*</span>Fecha Inicio:</strong>
                                        {!! Form::date('fecha_inicio', null, ['placeholder' => 'Fecha de Inicio de Capaitación', 'class' => 'form-control', 'id' => 'cfecha_inicio','onchange'=>"dateVal(document.getElementById('send-oferta'),this,true)"]) !!}
                                    </div>
                                    <div class="form-group">
                                        <strong><span class="is-required">*</span>Fecha Fin:</strong>
                                        {!! Form::date('fecha_fin', null, ['placeholder' => 'Fecha de Fin de Capacitación', 'class' => 'form-control', 'id' => 'cfecha_fin','onchange'=>"dateVal(document.getElementById('send-oferta'),this,true)"]) !!}
                                    </div>
                                    <div class="form-group">
                                        <strong>Imagen de presentación:</strong><br>
                                        {!! Form::file('file', null, [], ['class' => 'form-control ','id'=>'imagen-oferta']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary btn-sm" id="send-oferta"><i class="fa fa-save"></i> Guardar</button>
            </div>
            {!! Form::close() !!}
        </section>
    </div>
@endsection
@section('js')
    <script src="{{ asset('web/js/jquery.typeahead.min.js') }}"></script>
    <script src="{{ asset('web/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('js/validaciones.js') }}"></script>
    <script type="text/javascript">
    function submitContinue(){
        if(IsEmpty(document.getElementById('send-oferta'),document.getElementById('sele-entidad'),document.getElementById('titulo'),document.getElementById('descripcion_curso'),document.getElementById('creditos'),document.getElementById('horas'),document.getElementById('area'),document.getElementById('descripcion_oferta'),document.getElementById('precio'))){
            if($('input[name="file"]').get(0).files.length == 1){
                var nameFile = $('input[name="file"]').get(0).files[0].name;
                let extension = nameFile.split('.').pop();
                if(extension == 'png' || extension == 'jpeg' || extension == 'jpg'){
                    return true;
                }else{
                    $.notify({
                    icon: 'font-icon font-icon-check-circle',
                    title: '<strong>¡Alto!</strong>',
                    message: 'Solo se acepta archivos tipo png ,jpeg ,jpg'
                }, {
                    placement: {
                        from: "top",
                    },
                    type: 'danger'
                });
                    return false;
                }
            }else{
                $.notify({
                    icon: 'font-icon font-icon-check-circle',
                    title: '<strong>¡Alto!</strong>',
                    message: 'Seleccione un archivo de imagen'
                }, {
                    placement: {
                        from: "top",
                    },
                    type: 'danger'
                });
                return false;
            }
        }else{
            return false;
        }
    }
        // $('#form-oferta').validate({
        //     lang: 'es',
        //     rules: {
        //         identidad: {
        //             required: true,
        //         },
        //         titulo: {
        //             required: true,
        //         },
        //         descripcion_curso: {
        //             required: true,
        //         },
        //         creditos: {
        //             required: true,
        //             digits: true,
        //             minlength: 1,
        //             maxlength: 1
        //         },
        //         horas:{
        //             required: true,
        //             digits: true,
        //             minlength: 1,
        //             maxlength: 3
        //         },
        //         idarea:{
        //             required: true
        //         },
        //         descripcion_oferta:{
        //             required: true
        //         },
        //         precio:{
        //             digits: true,
        //             maxlength: 4
        //         },
        //         file:{
        //             required: true,
        //             extension: "jpeg|png"
        //         }
        //     },
        //     messages: {
        //         identidad: "Selecciones una opción",
        //         titulo: "Este campo es requerido",
        //         descripcion_curso: "Este campo es requerido",
        //         creditos: "Ingrese solo números y solo un dígito",
        //         horas: "Ingrese solo números y como máx. 3 dígitos",
        //         idarea: "Seleccione una opción",
        //         descripcion_oferta: "Este campo es requerido",
        //         precio: "Ingrese solo números y como máx. 4 dígitos",
        //         file: "Se permite solo archivos con extensión jpeg y png"
        //     }
        // });
    </script>
@endsection
