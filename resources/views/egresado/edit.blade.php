@extends('layouts.app')
@section('css')
    <link href="{{ asset('web/css/typeahead.min.css') }}" rel="stylesheet">
    <link href="{{ asset('web/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('web/css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/validaciones.css') }}" rel="stylesheet">
    <style type="text/css">
        /*    * Style the tab *! .tab {
                                            overflow: hidden;
                                            border: 1px solid #ccc;
                                            background-color: #f1f1f1;
                                        }*/
        /**Custom button excel*/
        .buttons-excel {
            background-color: #46c35f !important;
        }

        /* Style the buttons inside the tab */
        .tab button {
            background-color: inherit;
            float: left;
            border: none;
            outline: none;
            cursor: pointer;
            padding: 14px 16px;
            transition: 0.3s;
            font-size: 17px;
        }

        /* Change background color of buttons on hover */
        .tab button:hover {
            background-color: #ddd;
        }

        /* Create an active/current tablink class */
        .tab button.active {
            background-color: #ccc;
        }

        /* Style the tab content */
        .tabcontent {
            display: none;
            height: auto;
            width: auto;
        }

    </style>
    {{-- <link href="{{asset('web/css/font-awesome.min.css')}}" rel="stylesheet"> --}}
@endsection
@section('content')
    <div class="container-fluid">
        <section class="card">
            <header class="card-header">
                <div class="pull-left">
                    <ol class="breadcrumb breadcrumb-simple">
                        <li><a href="{{ route('home') }}">Inicio</a></li>
                        <li><a href="{{ route('egresado.index') }}">Egresado</a></li>
                        <li class="active">Crear</li>
                    </ol>
                </div>
                <div class="pull-right">
                    <a href="{{ route('egresado.index') }}" class="btn btn-inline btn-secondary btn-rounded btn-sm"><i
                            class="fa fa-angle-left"></i> Atrás</a>
                </div>
            </header>
            <input type="hidden" id="edit">
            <input type="hidden" id="data-typehead">
            <input type="hidden" id="type-send">
            <input type="hidden" id="condicion_id">
            {!! Form::model($alumno, ['method' => 'PATCH', 'route' => ['egresado.update', $alumno->id], 'id' => 'form-egresado','onsubmit'=>'return egresadoSubmit();']) !!}
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
                    <div class="container">
                        <div class="column">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-sm col-sm-12">
                                        <strong class="form-label">Busqueda de alumno:</strong>
                                        <div id="buscador">
                                            <div class="typeahead-container">
                                                <div class="typeahead-field">
                                                    <span class="typeahead-query">
                                                        <input id="alumno" class="form-control" name="q" type="search"
                                                            autocomplete="off">
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row text-center" style="padding-top:30px">
                                    <div class="col-sm col-sm-12 d-flex justify-content-center">
                                        <div class="p-2">
                                            <button type="button" class="btn btn-rounded btn-inline btn-success"
                                                data-toggle="modal" data-target=".bd-example-modal-lg"
                                                id="agregarAlumno"  onclick="ResetHTMLAlumno()">Agregar Datos</button>
                                        </div>
                                        <div class="p-2">
                                            <button type="button" class="btn btn-rounded btn-inline btn-warning"
                                                id="editarAlumno"  onclick="ResetHTMLAlumno()">Editar Datos</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <strong>Apellido Paterno:</strong>
                                    <input type="text" id="paterno" readonly class="form-control">
                                </div>
                                <div class="form-group">
                                    <strong>Apellido Materno:</strong>
                                    <input type="text" id="materno" readonly class="form-control">
                                </div>
                                <div class="form-group">
                                    <strong>Nombres:</strong>
                                    <input type="text" id="nombres" readonly class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        {!! Form::hidden('id', null, ['class' => 'form-control', 'id' => 'idalumno']) !!}
                        {!! Form::hidden('id', null, ['class' => 'form-control', 'id' => 'idalumno']) !!}
                        <div class="form-group">
                            <strong>Código del Alumno:</strong>
                            {!! Form::text('codigo', null, ['placeholder' => 'Ingrese Codigo del Alumno', 'class' => 'form-control','onkeyup'=>"MaxMinCadenas('send-egresado',12,10,this,true)",'onkeypress'=>"return SoloLetraNumeros('send-egresado',event,this,true)"]) !!}
                        </div>
                        <div class="form-group">
                            <strong>Condicion:</strong>
                            {!! Form::select('condicion', $condicion, ['class' => 'form-control', 'id' => 'condicion'], ['class' => 'form-control select2', 'id' => 'condicion']) !!}
                        </div>
                    </div>
                    <div class="card-block">
                        <div id="condicion_e_p" class="tabcontent">
                            <header class="card-header">
                                <button type="button" data-id='Egresado Pregrado'
                                    class="btn btn-rounded btn-inline btn-success add">
                                    Agregar
                                </button>
                                <button type="button" data-id='egresado-pregrado'
                                    class="btn btn-inline btn-danger btn-rounded pull-right minus">
                                    Editar
                                </button>
                            </header>
                            <br>
                            <div class="card-block" id="egresado-pregrado">
                                <div class="col-xs-9 col-sm-9 col-md-9">
                                    <div class="form-group">
                                        <strong>Código Local:</strong><br>
                                        {!! Form::select('codigo_local', $local, ['class' => 'form-control'], ['class' => 'custom-select', 'id' => 'local_e_p']) !!}
                                    </div>
                                    <div class="form-group">
                                        <strong>Escuela:</strong><br>
                                        {!! Form::select('escuela_id', $escuela, ['class' => 'form-control'], ['class' => 'custom-select', 'id' => 'escuela_e_p']) !!}
                                    </div>
                                    <div class="form-group">
                                        <strong>Semestre Ingreso:</strong>
                                        {!! Form::select('semestre_ingreso', $semestre, ['class' => 'form-control'], ['class' => 'custom-select', 'id' => 'semestre_ingreso_e_p']) !!}
                                    </div>
                                    <div class="form-group">
                                        <strong>Semestre Egreso:</strong>
                                        {!! Form::select('semestre_egreso', $semestre, ['class' => 'form-control'], ['class' => 'custom-select', 'id' => 'semestre_egreso_e_p']) !!}
                                    </div>
                                    <div class="form-group">
                                        <strong>Resolucion:</strong>
                                        {!! Form::select('resolucion', $resolucion, ['class' => 'form-control'], ['class' => 'custom-select', 'id' => 'resolucion_e_p']) !!}
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane">
                                    <table id="tabla-e-p" class="display table table-striped table-bordered" cellspacing="0"
                                        width="100%">
                                        <thead>
                                            <tr>
                                                <th>*</th>
                                                <th>Codigo Local</th>
                                                <th>Escuela</th>
                                                <th>Ingreso</th>
                                                <th>Egreso</th>
                                                <th>Resolución</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div id="condicion_g_p" class="tabcontent">
                            <header class="card-header">
                                <button type="button" data-id='Graduado Pregrado'
                                    class="btn btn-rounded btn-inline btn-success add ">
                                    Agregar
                                </button>
                                <button type="button" data-id='graduado-pregrado'
                                    class="btn btn-inline btn-danger btn-rounded pull-right minus">
                                    Editar
                                </button>
                            </header>
                            <br>
                            <div class="card-block" id='graduado-pregrado'>
                                <div class="col-xs-9 col-sm-9 col-md-9">
                                    <div class="form-group">
                                        <strong>Escuela:</strong><br>
                                        {!! Form::select('escuela_id', $escuela, ['class' => 'form-control'], ['class' => 'custom-select', 'id' => 'escuela_g_p']) !!}
                                    </div>
                                    <div class="form-group">
                                        <strong>Resolucion:</strong>
                                        {!! Form::select('resolucion', $resolucion, ['class' => 'form-control'], ['class' => 'custom-select', 'id' => 'resolucion_g_p']) !!}
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane">
                                    <table id="tabla-g-p" class="display table table-striped table-bordered" cellspacing="0"
                                        width="100%">
                                        <thead>
                                            <tr>
                                                <th>*</th>
                                                <th>Escuela</th>
                                                <th>Resolución</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div id="condicion_e_m" class="tabcontent">
                            <header class="card-header">
                                <button type="button" data-id='Egresado Maestria'
                                    class="btn btn-rounded btn-inline btn-success add">
                                    Agregar
                                </button>
                                <button type="button" data-id='egresado-maestria'
                                    class="btn btn-inline btn-danger btn-rounded pull-right minus">
                                    Editar
                                </button>
                            </header>
                            <br>
                            <div class="card-block" id='egresado-maestria'>
                                <div class="col-xs-9 col-sm-9 col-md-9">
                                    <div class="form-group">
                                        <strong>Código Local:</strong><br>
                                        {!! Form::select('codigo_local', $local, ['class' => 'form-control'], ['class' => 'custom-select', 'id' => 'local_e_m']) !!}
                                    </div>
                                    <div class="form-group">
                                        <strong>Maestria:</strong><br>
                                        {!! Form::select('maestria_id', $maestria, ['class' => 'form-control'], ['class' => 'custom-select', 'id' => 'maestria_e_m']) !!}
                                    </div>
                                    <div class="form-group">
                                        <strong>Semestre Ingreso:</strong>
                                        {!! Form::select('semestre_ingreso', $semestre, ['class' => 'form-control'], ['class' => 'custom-select', 'id' => 'semestre_ingreso_e_m']) !!}
                                    </div>
                                    <div class="form-group">
                                        <strong>Semestre Egreso:</strong>
                                        {!! Form::select('semestre_egreso', $semestre, ['class' => 'form-control'], ['class' => 'custom-select', 'id' => 'semestre_egreso_e_m']) !!}
                                    </div>
                                    <div class="form-group">
                                        <strong>Resolucion:</strong>
                                        {!! Form::select('resolucion', $resolucion, ['class' => 'form-control'], ['class' => 'custom-select', 'id' => 'resolucion_e_m']) !!}
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane">
                                    <table id="tabla-e-m" class="display table table-striped table-bordered" cellspacing="0"
                                        width="100%">
                                        <thead>
                                            <tr>
                                                <th>*</th>
                                                <th>Codigo Local</th>
                                                <th>Maestria</th>
                                                <th>Ingreso</th>
                                                <th>Egreso</th>
                                                <th>Resolución</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div id="condicion_g_m" class="tabcontent">
                            <header class="card-header">
                                <button type="button" data-id='Graduado Maestria'
                                    class="btn btn-rounded btn-inline btn-success add">
                                    Agregar
                                </button>
                                <button type="button" data-id='graduado-maestria'
                                    class="btn btn-inline btn-danger btn-rounded pull-right minus">
                                    Editar
                                </button>
                            </header>
                            <br>
                            <div class="card-block" id='graduado-maestria'>
                                <div class="col-xs-9 col-sm-9 col-md-9">
                                    <div class="form-group">
                                        <strong>Maestria:</strong><br>
                                        {!! Form::select('maestria_id', $maestria, ['class' => 'form-control'], ['class' => 'custom-select', 'id' => 'maestria_g_m']) !!}
                                    </div>
                                    <div class="form-group">
                                        <strong>Resolucion:</strong>
                                        {!! Form::select('resolucion', $resolucion, ['class' => 'form-control'], ['class' => 'custom-select', 'id' => 'resolucion_g_m']) !!}
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane">
                                    <table id="tabla-g-m" class="display table table-striped table-bordered" cellspacing="0"
                                        width="100%">
                                        <thead>
                                            <tr>
                                                <th>*</th>
                                                <th>Escuela</th>
                                                <th>Resolución</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div id="condicion_e_d" class="tabcontent">
                            <header class="card-header">
                                <button type="button" data-id='Egresado Doctorado'
                                    class="btn btn-rounded btn-inline btn-success add">
                                    Agregar
                                </button>
                                <button type="button" data-id='egresado-doctorado'
                                    class="btn btn-inline btn-danger btn-rounded pull-right minus">
                                    Editar
                                </button>
                            </header>
                            <br>
                            <div class="card-block" id='egresado-doctorado'>
                                <div class="col-xs-9 col-sm-9 col-md-9">
                                    <div class="form-group">
                                        <strong>Código Local:</strong><br>
                                        {!! Form::select('codigo_local', $local, ['class' => 'form-control'], ['class' => 'custom-select', 'id' => 'local_e_d']) !!}
                                    </div>
                                    <div class="form-group">
                                        <strong>Doctorado:</strong><br>
                                        {!! Form::select('doctorado_id', $doctorado, ['class' => 'form-control'], ['class' => 'custom-select', 'id' => 'doctorado_e_d']) !!}
                                    </div>
                                    <div class="form-group">
                                        <strong>Semestre Ingreso:</strong>
                                        {!! Form::select('semestre_ingreso', $semestre, ['class' => 'form-control'], ['class' => 'custom-select', 'id' => 'semestre_ingreso_e_d']) !!}
                                    </div>
                                    <div class="form-group">
                                        <strong>Semestre Egreso:</strong>
                                        {!! Form::select('semestre_egreso', $semestre, ['class' => 'form-control'], ['class' => 'custom-select', 'id' => 'semestre_egreso_e_d']) !!}
                                    </div>
                                    <div class="form-group">
                                        <strong>Resolucion:</strong>
                                        {!! Form::select('resolucion', $resolucion, ['class' => 'form-control'], ['class' => 'custom-select', 'id' => 'resolucion_e_d']) !!}
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane">
                                    <table id="tabla-e-d" class="display table table-striped table-bordered" cellspacing="0"
                                        width="100%">
                                        <thead>
                                            <tr>
                                                <th>*</th>
                                                <th>Codigo Local</th>
                                                <th>Doctorado</th>
                                                <th>Ingreso</th>
                                                <th>Egreso</th>
                                                <th>Resolución</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div id="condicion_g_d" class="tabcontent">
                            <header class="card-header">
                                <button type="button" data-id='Graduado Doctorado'
                                    class="btn btn-rounded btn-inline btn-success add">
                                    Agregar
                                </button>
                                <button type="button" data-id='graduado-doctorado'
                                    class="btn btn-inline btn-danger btn-rounded pull-right minus">
                                    Editar
                                </button>
                            </header>
                            <br>
                            <div class="card-block" id='graduado-doctorado'>
                                <div class="col-xs-9 col-sm-9 col-md-9">
                                    <div class="form-group">
                                        <strong>Doctorado:</strong><br>
                                        {!! Form::select('doctorado_id', $doctorado, ['class' => 'form-control'], ['class' => 'custom-select', 'id' => 'doctorado_g_d']) !!}
                                    </div>
                                    <div class="form-group">
                                        <strong>Resolucion:</strong>
                                        {!! Form::select('resolucion', $resolucion, ['class' => 'form-control'], ['class' => 'custom-select', 'id' => 'resolucion_g_d']) !!}
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane">
                                    <table id="tabla-g-d" class="display table table-striped table-bordered"
                                        cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>*</th>
                                                <th>Doctorado</th>
                                                <th>Resolución</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary btn-sm" id="send-egresado"><i class="fa fa-save"></i> Guardar</button>
            </div>
            {!! Form::close() !!}
        </section>
    </div>
    <!--.container-fluid-->
    <div class="modal fade bd-example-modal-lg" id="modal-alumno" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                {!! Form::open(['method' => 'POST', 'id' => 'form-alumno','onsubmit'=>'return false;']) !!}
                <div class="modal-header">
                    <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                        <i class="font-icon-close-2"></i>
                    </button>
                    <h4 class="modal-title" id="myModalLabel"></h4>
                </div>
                <div class="modal-body">
                    <div class="card-block">
                        <div id="alert-alumno">
                            <ul id="showErrores">
                            </ul>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-4">
                                <div class="form-group">
                                    <strong>Tipo de Documento de Identidad:</strong><br>
                                    {!! Form::select('tipo_documento', $tipo, ['class' => 'form-control'], ['class' => 'custom-select', 'id' => 'tipo_documento']) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-4">
                                <div class="form-group">
                                    <strong>N° de Documento:<span class="is-required">*</span></strong>
                                    {!! Form::text('num_documento', null, ['placeholder' => 'Ingrese el N° de documento', 'class' => 'form-control', 'id' => 'num_documento','onkeyup'=>"MaxMinCadenas('send-alumno',8,8,this,true)",'onkeypress'=>"return SoloNumeros('send-alumno',event,this,true)"]) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Apellido Paterno:<span class="is-required">*</span></strong>
                                    {!! Form::text('paterno', null, ['placeholder' => 'Ingrese el apellido paterno', 'class' => 'form-control', 'id' => 'apaterno','onkeyup'=>"MaxMinCadenas('send-alumno',30,3,this,true)",'onkeypress'=>"return SoloLetras('send-alumno',event,this,true)"]) !!}
                                </div>
                                <div class="form-group">
                                    <strong>Apellido Materno:<span class="is-required">*</span></strong>
                                    {!! Form::text('materno', null, ['placeholder' => 'Ingrese el apellido materno', 'class' => 'form-control', 'id' => 'amaterno','onkeyup'=>"MaxMinCadenas('send-alumno',30,3,this,true)",'onkeypress'=>"return SoloLetras('send-alumno',event,this,true)"]) !!}
                                </div>
                                <div class="form-group">
                                    <strong>Nombres:<span class="is-required">*</span></strong>
                                    {!! Form::text('nombres', null, ['placeholder' => 'Ingrese los nombres', 'class' => 'form-control', 'id' => 'anombres','onkeyup'=>"MaxMinCadenas('send-alumno',30,3,this,true)",'onkeypress'=>"return SoloLetras('send-alumno',event,this,true)"]) !!}
                                </div>
                                <div class="form-group">
                                    <strong>Sexo:<span class="is-required">*</span></strong><br>
                                    {!! Form::select('sexo', $sexo, ['class' => 'form-control'], ['class' => 'custom-select', 'id' => 'sexo']) !!}
                                </div>
                                <div class="form-group">
                                    <strong>Dirección:<span class="is-required">*</span></strong>
                                    {!! Form::text('direccion', null, ['placeholder' => 'Ingrese una dirección', 'class' => 'form-control', 'id' => 'direccion','onkeyup'=>"MaxMinCadenas('send-alumno',100,0,this,true)",'onkeypress'=>"return SoloLetraNumeros('send-alumno',event,this,true)"]) !!}
                                </div>
                                <div class="form-group">
                                    <strong>Correo:</strong>
                                    {!! Form::text('correo', null, ['placeholder' => 'Ingrese una correo', 'class' => 'form-control', 'id' => 'correo','onkeyup'=>"InputCorreo('send-alumno',document.getElementById('correo'),30,10,this,true)"]) !!}
                                </div>
                                <div class="form-group">
                                    <strong>Telefono:</strong>
                                    {!! Form::text('telefono', null, ['placeholder' => 'Ingrese un número telefónico', 'class' => 'form-control', 'id' => 'telefono','onkeyup'=>"MaxMinCadenas('send-alumno',10,5,this,false)",'onkeypress'=>"return SoloNumeros('send-alumno',event,this,false)"]) !!}
                                </div>
                                <div class="form-group">
                                    <strong>Celular:</strong>
                                    {!! Form::text('celular', null, ['placeholder' => 'Ingrese un número celular', 'class' => 'form-control', 'id' => 'celular','onkeyup'=>"MaxMinCadenas('send-alumno',9,9,this,false)",'onkeypress'=>"return SoloNumeros('send-alumno',event,this,false)"]) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-rounded btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary btn-rounded" id="send-alumno"><i
                            class="fa fa-save"></i> Guardar</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

@endsection
@section('js')
    <script src="{{ asset('web/js/jquery.typeahead.min.js') }}"></script>
    <script src="{{ asset('web/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('js/validaciones.js') }}"></script>
    <script type="text/javascript">
        //
        function openTab(evt, cityName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(cityName).style.display = "block";
            evt.currentTarget.className += " active";
        }
        //
        $(document).ready(function() {
            $('.minus').hide();
            $('#condicion').change(function() {
                $("#condicion option:selected").each(function() {
                    $('.minus').hide();
                    $('.add').show();
                    console.log($(this).text());
                    if ($(this).text() == 'Egresado Pregrado') {
                        openTab(event, 'condicion_e_p');
                        $('#tabla-e-p').DataTable().destroy();
                        let tabla = $('#tabla-e-p').DataTable({
                            dom: 'Bfrtip',
                            buttons: [],
                            responsive: true,
                            "processing": true,
                            "serverSide": true,
                            filter: false,
                            language: {
                                "decimal": "",
                                "emptyTable": "No hay información",
                                "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                                "infoEmpty": "Mostrando 0 a 0 de 0 Entradas",
                                "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                                "infoPostFix": "",
                                "thousands": ",",
                                "lengthMenu": "Mostrar _MENU_ Entradas",
                                "loadingRecords": "Cargando...",
                                "processing": "Procesando...",
                                "search": "Buscar:",
                                "zeroRecords": "Sin resultados encontrados",
                                "No results matched": "No se encontraron resultados",
                                "paginate": {
                                    "first": "Primero",
                                    "last": "Ultimo",
                                    "next": "Siguiente",
                                    "previous": "Anterior"
                                },
                            },
                            "ajax": {
                                "url": "{{ route('egresado.get-condicion-alumno') }}",
                                "dataType": "json",
                                "type": "POST",
                                "data": {
                                    _token: "{{ csrf_token() }}",
                                    id: $('#idalumno').val(),
                                    condicion: $(this).text()
                                }
                            },
                            "columns": [{
                                    "data": "id"
                                },
                                {
                                    "data": "codigo_local"
                                },
                                {
                                    "data": "escuela"
                                },
                                {
                                    "data": "ingreso"
                                },
                                {
                                    "data": "egreso"
                                },
                                {
                                    "data": "resolucion"
                                },
                                {
                                    "data": "options"
                                }
                            ],
                            "columnDefs": [{
                                    "className": "text-center",
                                    "targets": [0, 5]
                                },
                                {
                                    "bSortable": false,
                                    "aTargets": [4, 5]
                                },
                            ],
                        });
                        $('#tabla-e-p tbody').on('click', '.delete-confirm', function() {
                            let idalumno = $(this).attr('data-id');
                            let url = '{!! route('egresado.delete-condicion-alumno') !!}';
                            swal({
                                    title: '¿Estás seguro?',
                                    text: "¡No podrás revertir esto!",
                                    type: 'warning',
                                    showCancelButton: true,
                                    confirmButtonClass: "btn-danger",
                                    confirmButtonText: '!Si, eliminar!',
                                    cancelButtonText: 'Cancelar',
                                    closeOnConfirm: false,
                                    closeOnCancel: false
                                },
                                function(isConfirm) {
                                    if (isConfirm) {
                                        $.ajaxSetup({
                                            headers: {
                                                'X-CSRF-TOKEN': $(
                                                    'meta[name="csrf-token"]'
                                                ).attr('content')
                                            }
                                        });
                                        $.ajax({
                                            type: 'POST',
                                            url: url,
                                            data: {
                                                "_token": "{{ csrf_token() }}",
                                                "_method": 'DELETE',
                                                "id": idalumno,
                                            },
                                            dataType: 'JSON',
                                            beforeSend: function() {},
                                            success: function(response) {
                                                if (response.success) {
                                                    $.notify({
                                                        icon: 'font-icon font-icon-check-circle',
                                                        title: '<strong>¡Existoso!</strong>',
                                                        message: 'Condición eliminada correctamente'
                                                    }, {
                                                        placement: {
                                                            from: "top",
                                                        },
                                                        type: 'success'
                                                    });
                                                    $('#tabla-e-p')
                                                        .DataTable().ajax
                                                        .reload();
                                                } else {
                                                    $.notify({
                                                        icon: 'font-icon font-icon-warning',
                                                        title: '<strong>¡Error!</strong>',
                                                        message: 'Hubo un error al eliminar la condición'
                                                    }, {
                                                        placement: {
                                                            from: "top",
                                                        },
                                                        type: 'danger'
                                                    });
                                                }
                                                swal.close()
                                            },
                                            error: function(err) {
                                                console.log(err);
                                            }
                                        });
                                    } else {
                                        swal({
                                            title: "Cancelado",
                                            text: "El registro está a salvo",
                                            type: "error",
                                            confirmButtonClass: "btn-danger"
                                        });
                                    }
                                });
                        });
                    }
                    if ($(this).text() == 'Graduado Pregrado') {
                        openTab(event, 'condicion_g_p');
                        $('#tabla-g-p').DataTable().destroy();
                        let tabla = $('#tabla-g-p').DataTable({
                            dom: 'Bfrtip',
                            buttons: [],
                            responsive: true,
                            "processing": true,
                            "serverSide": true,
                            filter: false,
                            language: {
                                "decimal": "",
                                "emptyTable": "No hay información",
                                "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                                "infoEmpty": "Mostrando 0 a 0 de 0 Entradas",
                                "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                                "infoPostFix": "",
                                "thousands": ",",
                                "lengthMenu": "Mostrar _MENU_ Entradas",
                                "loadingRecords": "Cargando...",
                                "processing": "Procesando...",
                                "search": "Buscar:",
                                "zeroRecords": "Sin resultados encontrados",
                                "No results matched": "No se encontraron resultados",
                                "paginate": {
                                    "first": "Primero",
                                    "last": "Ultimo",
                                    "next": "Siguiente",
                                    "previous": "Anterior"
                                },
                            },
                            "ajax": {
                                "url": "{{ route('egresado.get-condicion-alumno') }}",
                                "dataType": "json",
                                "type": "POST",
                                "data": {
                                    _token: "{{ csrf_token() }}",
                                    id: $('#idalumno').val(),
                                    condicion: $(this).text()
                                }
                            },
                            "columns": [{
                                    "data": "id"
                                },
                                {
                                    "data": "escuela"
                                },
                                {
                                    "data": "resolucion"
                                },
                                {
                                    "data": "options"
                                }
                            ],
                            "columnDefs": [{
                                    "className": "text-center",
                                    "targets": [0, 3]
                                },
                                {
                                    "bSortable": false,
                                    "aTargets": [2, 3]
                                },
                            ],
                        });
                        $('#tabla-g-p tbody').on('click', '.delete-confirm', function() {
                            let idalumno = $(this).attr('data-id');
                            let url = '{!! route('egresado.delete-condicion-alumno') !!}';
                            swal({
                                    title: '¿Estás seguro?',
                                    text: "¡No podrás revertir esto!",
                                    type: 'warning',
                                    showCancelButton: true,
                                    confirmButtonClass: "btn-danger",
                                    confirmButtonText: '!Si, eliminar!',
                                    cancelButtonText: 'Cancelar',
                                    closeOnConfirm: false,
                                    closeOnCancel: false
                                },
                                function(isConfirm) {
                                    if (isConfirm) {
                                        $.ajaxSetup({
                                            headers: {
                                                'X-CSRF-TOKEN': $(
                                                    'meta[name="csrf-token"]'
                                                ).attr('content')
                                            }
                                        });
                                        $.ajax({
                                            type: 'POST',
                                            url: url,
                                            data: {
                                                "_token": "{{ csrf_token() }}",
                                                "_method": 'DELETE',
                                                "id": idalumno,
                                            },
                                            dataType: 'JSON',
                                            beforeSend: function() {},
                                            success: function(response) {
                                                if (response.success) {
                                                    $.notify({
                                                        icon: 'font-icon font-icon-check-circle',
                                                        title: '<strong>¡Existoso!</strong>',
                                                        message: 'Condición eliminada correctamente'
                                                    }, {
                                                        placement: {
                                                            from: "top",
                                                        },
                                                        type: 'success'
                                                    });
                                                    $('#tabla-g-p')
                                                        .DataTable().ajax
                                                        .reload();
                                                } else {
                                                    $.notify({
                                                        icon: 'font-icon font-icon-warning',
                                                        title: '<strong>¡Error!</strong>',
                                                        message: 'Hubo un error al eliminar la condición'
                                                    }, {
                                                        placement: {
                                                            from: "top",
                                                        },
                                                        type: 'danger'
                                                    });
                                                }
                                                swal.close()
                                            },
                                            error: function(err) {
                                                console.log(err);
                                            }
                                        });
                                    } else {
                                        swal({
                                            title: "Cancelado",
                                            text: "El registro está a salvo",
                                            type: "error",
                                            confirmButtonClass: "btn-danger"
                                        });
                                    }
                                });
                        });
                    }
                    if ($(this).text() == 'Egresado Maestria') {
                        openTab(event, 'condicion_e_m');
                        $('#tabla-e-m').DataTable().destroy();
                        let tabla = $('#tabla-e-m').DataTable({
                            dom: 'Bfrtip',
                            buttons: [],
                            responsive: true,
                            "processing": true,
                            "serverSide": true,
                            filter: false,
                            language: {
                                "decimal": "",
                                "emptyTable": "No hay información",
                                "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                                "infoEmpty": "Mostrando 0 a 0 de 0 Entradas",
                                "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                                "infoPostFix": "",
                                "thousands": ",",
                                "lengthMenu": "Mostrar _MENU_ Entradas",
                                "loadingRecords": "Cargando...",
                                "processing": "Procesando...",
                                "search": "Buscar:",
                                "zeroRecords": "Sin resultados encontrados",
                                "No results matched": "No se encontraron resultados",
                                "paginate": {
                                    "first": "Primero",
                                    "last": "Ultimo",
                                    "next": "Siguiente",
                                    "previous": "Anterior"
                                },
                            },
                            "ajax": {
                                "url": "{{ route('egresado.get-condicion-alumno') }}",
                                "dataType": "json",
                                "type": "POST",
                                "data": {
                                    _token: "{{ csrf_token() }}",
                                    id: $('#idalumno').val(),
                                    condicion: $(this).text()
                                }
                            },
                            "columns": [{
                                    "data": "id"
                                },
                                {
                                    "data": "codigo_local"
                                },
                                {
                                    "data": "maestria"
                                },
                                {
                                    "data": "ingreso"
                                },
                                {
                                    "data": "egreso"
                                },
                                {
                                    "data": "resolucion"
                                },
                                {
                                    "data": "options"
                                }
                            ],
                            "columnDefs": [{
                                    "className": "text-center",
                                    "targets": [0, 5]
                                },
                                {
                                    "bSortable": false,
                                    "aTargets": [4, 5]
                                },
                            ],
                        });
                        $('#tabla-e-m tbody').on('click', '.delete-confirm', function() {
                            let idalumno = $(this).attr('data-id');
                            let url = '{!! route('egresado.delete-condicion-alumno') !!}';
                            swal({
                                    title: '¿Estás seguro?',
                                    text: "¡No podrás revertir esto!",
                                    type: 'warning',
                                    showCancelButton: true,
                                    confirmButtonClass: "btn-danger",
                                    confirmButtonText: '!Si, eliminar!',
                                    cancelButtonText: 'Cancelar',
                                    closeOnConfirm: false,
                                    closeOnCancel: false
                                },
                                function(isConfirm) {
                                    if (isConfirm) {
                                        $.ajaxSetup({
                                            headers: {
                                                'X-CSRF-TOKEN': $(
                                                    'meta[name="csrf-token"]'
                                                ).attr('content')
                                            }
                                        });
                                        $.ajax({
                                            type: 'POST',
                                            url: url,
                                            data: {
                                                "_token": "{{ csrf_token() }}",
                                                "_method": 'DELETE',
                                                "id": idalumno,
                                            },
                                            dataType: 'JSON',
                                            beforeSend: function() {},
                                            success: function(response) {
                                                if (response.success) {
                                                    $.notify({
                                                        icon: 'font-icon font-icon-check-circle',
                                                        title: '<strong>¡Existoso!</strong>',
                                                        message: 'Condición eliminada correctamente'
                                                    }, {
                                                        placement: {
                                                            from: "top",
                                                        },
                                                        type: 'success'
                                                    });
                                                    $('#tabla-e-m')
                                                        .DataTable().ajax
                                                        .reload();
                                                } else {
                                                    $.notify({
                                                        icon: 'font-icon font-icon-warning',
                                                        title: '<strong>¡Error!</strong>',
                                                        message: 'Hubo un error al eliminar la condición'
                                                    }, {
                                                        placement: {
                                                            from: "top",
                                                        },
                                                        type: 'danger'
                                                    });
                                                }
                                                swal.close()
                                            },
                                            error: function(err) {
                                                console.log(err);
                                            }
                                        });
                                    } else {
                                        swal({
                                            title: "Cancelado",
                                            text: "El registro está a salvo",
                                            type: "error",
                                            confirmButtonClass: "btn-danger"
                                        });
                                    }
                                });
                        });
                    }
                    if ($(this).text() == 'Graduado Maestria') {
                        openTab(event, 'condicion_g_m');
                        $('#tabla-g-m').DataTable().destroy();
                        let tabla = $('#tabla-g-m').DataTable({
                            dom: 'Bfrtip',
                            buttons: [],
                            responsive: true,
                            "processing": true,
                            "serverSide": true,
                            filter: false,
                            language: {
                                "decimal": "",
                                "emptyTable": "No hay información",
                                "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                                "infoEmpty": "Mostrando 0 a 0 de 0 Entradas",
                                "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                                "infoPostFix": "",
                                "thousands": ",",
                                "lengthMenu": "Mostrar _MENU_ Entradas",
                                "loadingRecords": "Cargando...",
                                "processing": "Procesando...",
                                "search": "Buscar:",
                                "zeroRecords": "Sin resultados encontrados",
                                "No results matched": "No se encontraron resultados",
                                "paginate": {
                                    "first": "Primero",
                                    "last": "Ultimo",
                                    "next": "Siguiente",
                                    "previous": "Anterior"
                                },
                            },
                            "ajax": {
                                "url": "{{ route('egresado.get-condicion-alumno') }}",
                                "dataType": "json",
                                "type": "POST",
                                "data": {
                                    _token: "{{ csrf_token() }}",
                                    id: $('#idalumno').val(),
                                    condicion: $(this).text()
                                }
                            },
                            "columns": [{
                                    "data": "id"
                                },
                                {
                                    "data": "maestria"
                                },
                                {
                                    "data": "resolucion"
                                },
                                {
                                    "data": "options"
                                }
                            ],
                            "columnDefs": [{
                                    "className": "text-center",
                                    "targets": [0, 3]
                                },
                                {
                                    "bSortable": false,
                                    "aTargets": [2, 3]
                                },
                            ],
                        });
                        $('#tabla-g-m tbody').on('click', '.delete-confirm', function() {
                            let idalumno = $(this).attr('data-id');
                            let url = '{!! route('egresado.delete-condicion-alumno') !!}';
                            swal({
                                    title: '¿Estás seguro?',
                                    text: "¡No podrás revertir esto!",
                                    type: 'warning',
                                    showCancelButton: true,
                                    confirmButtonClass: "btn-danger",
                                    confirmButtonText: '!Si, eliminar!',
                                    cancelButtonText: 'Cancelar',
                                    closeOnConfirm: false,
                                    closeOnCancel: false
                                },
                                function(isConfirm) {
                                    if (isConfirm) {
                                        $.ajaxSetup({
                                            headers: {
                                                'X-CSRF-TOKEN': $(
                                                    'meta[name="csrf-token"]'
                                                ).attr('content')
                                            }
                                        });
                                        $.ajax({
                                            type: 'POST',
                                            url: url,
                                            data: {
                                                "_token": "{{ csrf_token() }}",
                                                "_method": 'DELETE',
                                                "id": idalumno,
                                            },
                                            dataType: 'JSON',
                                            beforeSend: function() {},
                                            success: function(response) {
                                                if (response.success) {
                                                    $.notify({
                                                        icon: 'font-icon font-icon-check-circle',
                                                        title: '<strong>¡Existoso!</strong>',
                                                        message: 'Condición eliminada correctamente'
                                                    }, {
                                                        placement: {
                                                            from: "top",
                                                        },
                                                        type: 'success'
                                                    });
                                                    $('#tabla-g-m')
                                                        .DataTable().ajax
                                                        .reload();
                                                } else {
                                                    $.notify({
                                                        icon: 'font-icon font-icon-warning',
                                                        title: '<strong>¡Error!</strong>',
                                                        message: 'Hubo un error al eliminar la condición'
                                                    }, {
                                                        placement: {
                                                            from: "top",
                                                        },
                                                        type: 'danger'
                                                    });
                                                }
                                                swal.close()
                                            },
                                            error: function(err) {
                                                console.log(err);
                                            }
                                        });
                                    } else {
                                        swal({
                                            title: "Cancelado",
                                            text: "El registro está a salvo",
                                            type: "error",
                                            confirmButtonClass: "btn-danger"
                                        });
                                    }
                                });
                        });
                    }
                    if ($(this).text() == 'Egresado Doctorado') {
                        openTab(event, 'condicion_e_d');
                        $('#tabla-e-d').DataTable().destroy();
                        let tabla = $('#tabla-e-d').DataTable({
                            dom: 'Bfrtip',
                            buttons: [],
                            responsive: true,
                            "processing": true,
                            "serverSide": true,
                            filter: false,
                            language: {
                                "decimal": "",
                                "emptyTable": "No hay información",
                                "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                                "infoEmpty": "Mostrando 0 a 0 de 0 Entradas",
                                "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                                "infoPostFix": "",
                                "thousands": ",",
                                "lengthMenu": "Mostrar _MENU_ Entradas",
                                "loadingRecords": "Cargando...",
                                "processing": "Procesando...",
                                "search": "Buscar:",
                                "zeroRecords": "Sin resultados encontrados",
                                "No results matched": "No se encontraron resultados",
                                "paginate": {
                                    "first": "Primero",
                                    "last": "Ultimo",
                                    "next": "Siguiente",
                                    "previous": "Anterior"
                                },
                            },
                            "ajax": {
                                "url": "{{ route('egresado.get-condicion-alumno') }}",
                                "dataType": "json",
                                "type": "POST",
                                "data": {
                                    _token: "{{ csrf_token() }}",
                                    id: $('#idalumno').val(),
                                    condicion: $(this).text()
                                }
                            },
                            "columns": [{
                                    "data": "id"
                                },
                                {
                                    "data": "codigo_local"
                                },
                                {
                                    "data": "doctorados"
                                },
                                {
                                    "data": "ingreso"
                                },
                                {
                                    "data": "egreso"
                                },
                                {
                                    "data": "resolucion"
                                },
                                {
                                    "data": "options"
                                }
                            ],
                            "columnDefs": [{
                                    "className": "text-center",
                                    "targets": [0, 5]
                                },
                                {
                                    "bSortable": false,
                                    "aTargets": [4, 5]
                                },
                            ],
                        });
                        $('#tabla-e-d tbody').on('click', '.delete-confirm', function() {
                            let idalumno = $(this).attr('data-id');
                            let url = '{!! route('egresado.delete-condicion-alumno') !!}';
                            swal({
                                    title: '¿Estás seguro?',
                                    text: "¡No podrás revertir esto!",
                                    type: 'warning',
                                    showCancelButton: true,
                                    confirmButtonClass: "btn-danger",
                                    confirmButtonText: '!Si, eliminar!',
                                    cancelButtonText: 'Cancelar',
                                    closeOnConfirm: false,
                                    closeOnCancel: false
                                },
                                function(isConfirm) {
                                    if (isConfirm) {
                                        $.ajaxSetup({
                                            headers: {
                                                'X-CSRF-TOKEN': $(
                                                    'meta[name="csrf-token"]'
                                                ).attr('content')
                                            }
                                        });
                                        $.ajax({
                                            type: 'POST',
                                            url: url,
                                            data: {
                                                "_token": "{{ csrf_token() }}",
                                                "_method": 'DELETE',
                                                "id": idalumno,
                                            },
                                            dataType: 'JSON',
                                            beforeSend: function() {},
                                            success: function(response) {
                                                if (response.success) {
                                                    $.notify({
                                                        icon: 'font-icon font-icon-check-circle',
                                                        title: '<strong>¡Existoso!</strong>',
                                                        message: 'Condición eliminada correctamente'
                                                    }, {
                                                        placement: {
                                                            from: "top",
                                                        },
                                                        type: 'success'
                                                    });
                                                    $('#tabla-e-d')
                                                        .DataTable().ajax
                                                        .reload();
                                                } else {
                                                    $.notify({
                                                        icon: 'font-icon font-icon-warning',
                                                        title: '<strong>¡Error!</strong>',
                                                        message: 'Hubo un error al eliminar la condición'
                                                    }, {
                                                        placement: {
                                                            from: "top",
                                                        },
                                                        type: 'danger'
                                                    });
                                                }
                                                swal.close()
                                            },
                                            error: function(err) {
                                                console.log(err);
                                            }
                                        });
                                    } else {
                                        swal({
                                            title: "Cancelado",
                                            text: "El registro está a salvo",
                                            type: "error",
                                            confirmButtonClass: "btn-danger"
                                        });
                                    }
                                });
                        });
                    }
                    if ($(this).text() == 'Graduado Doctorado') {
                        openTab(event, 'condicion_g_d');
                        $('#tabla-g-d').DataTable().destroy();
                        let tabla = $('#tabla-g-d').DataTable({
                            dom: 'Bfrtip',
                            buttons: [],
                            responsive: true,
                            "processing": true,
                            "serverSide": true,
                            filter: false,
                            language: {
                                "decimal": "",
                                "emptyTable": "No hay información",
                                "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                                "infoEmpty": "Mostrando 0 a 0 de 0 Entradas",
                                "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                                "infoPostFix": "",
                                "thousands": ",",
                                "lengthMenu": "Mostrar _MENU_ Entradas",
                                "loadingRecords": "Cargando...",
                                "processing": "Procesando...",
                                "search": "Buscar:",
                                "zeroRecords": "Sin resultados encontrados",
                                "No results matched": "No se encontraron resultados",
                                "paginate": {
                                    "first": "Primero",
                                    "last": "Ultimo",
                                    "next": "Siguiente",
                                    "previous": "Anterior"
                                },
                            },
                            "ajax": {
                                "url": "{{ route('egresado.get-condicion-alumno') }}",
                                "dataType": "json",
                                "type": "POST",
                                "data": {
                                    _token: "{{ csrf_token() }}",
                                    id: $('#idalumno').val(),
                                    condicion: $(this).text()
                                }
                            },
                            "columns": [{
                                    "data": "id"
                                },
                                {
                                    "data": "doctorado"
                                },
                                {
                                    "data": "resolucion"
                                },
                                {
                                    "data": "options"
                                }
                            ],
                            "columnDefs": [{
                                    "className": "text-center",
                                    "targets": [0, 3]
                                },
                                {
                                    "bSortable": false,
                                    "aTargets": [2, 3]
                                },
                            ],
                        });
                        $('#tabla-g-d tbody').on('click', '.delete-confirm', function() {
                            let idalumno = $(this).attr('data-id');
                            let url = '{!! route('egresado.delete-condicion-alumno') !!}';
                            swal({
                                    title: '¿Estás seguro?',
                                    text: "¡No podrás revertir esto!",
                                    type: 'warning',
                                    showCancelButton: true,
                                    confirmButtonClass: "btn-danger",
                                    confirmButtonText: '!Si, eliminar!',
                                    cancelButtonText: 'Cancelar',
                                    closeOnConfirm: false,
                                    closeOnCancel: false
                                },
                                function(isConfirm) {
                                    if (isConfirm) {
                                        $.ajaxSetup({
                                            headers: {
                                                'X-CSRF-TOKEN': $(
                                                    'meta[name="csrf-token"]'
                                                ).attr('content')
                                            }
                                        });
                                        $.ajax({
                                            type: 'POST',
                                            url: url,
                                            data: {
                                                "_token": "{{ csrf_token() }}",
                                                "_method": 'DELETE',
                                                "id": idalumno,
                                            },
                                            dataType: 'JSON',
                                            beforeSend: function() {},
                                            success: function(response) {
                                                if (response.success) {
                                                    $.notify({
                                                        icon: 'font-icon font-icon-check-circle',
                                                        title: '<strong>¡Existoso!</strong>',
                                                        message: 'Condición eliminada correctamente'
                                                    }, {
                                                        placement: {
                                                            from: "top",
                                                        },
                                                        type: 'success'
                                                    });
                                                    $('#tabla-g-d')
                                                        .DataTable().ajax
                                                        .reload();
                                                } else {
                                                    $.notify({
                                                        icon: 'font-icon font-icon-warning',
                                                        title: '<strong>¡Error!</strong>',
                                                        message: 'Hubo un error al eliminar la condición'
                                                    }, {
                                                        placement: {
                                                            from: "top",
                                                        },
                                                        type: 'danger'
                                                    });
                                                }
                                                swal.close()
                                            },
                                            error: function(err) {
                                                console.log(err);
                                            }
                                        });
                                    } else {
                                        swal({
                                            title: "Cancelado",
                                            text: "El registro está a salvo",
                                            type: "error",
                                            confirmButtonClass: "btn-danger"
                                        });
                                    }
                                });
                        });
                    }
                });
            }).change();
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        getDataAlumno();

        $('#form-egresado').ready(function() {
            $.ajax({
                type: 'POST',
                url: '{!! url('gape/gestion-egresado/alumno/get-alumno') !!}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "_method": 'POST',
                    "id": $('#idalumno').val()
                },
                dataType: 'JSON',
                success: function(returnData) {
                    $('#paterno').val(returnData.data.paterno);
                    $('#materno').val(returnData.data.materno);
                    $('#nombres').val(returnData.data.nombres);
                }
            });
        });

        function getDataAlumno() {
            $.ajax({
                type: 'POST',
                url: '{!! url('gape/gestion-egresado/egresado/get-alumno') !!}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "_method": 'POST',
                },
                dataType: 'JSON',
                beforeSend: function() {},
                success: function(response) {
                    if ($('.typeahead-container').length) {
                        $('#buscador').html(
                            '<div class="typeahead-container"><div class="typeahead-field"><span class="typeahead-query"><input id="alumno"class="form-control"name="q"type="search"autocomplete="off"></span></div></div>'
                        );
                    }
                    $('#data-typehead').val('true');
                    $('#alumno').bind('keypress',function(e){
                        var key = window.event ? e.which : e.keyCode;
                        //console.log(key);
                        var chark = String.fromCharCode(key);
                        //var tempValue = input.value + chark;
                        if (key >= 97 && key <= 122 || key >= 65 && key <= 90 || key>=48 && key<= 57) {
                            return true;
                        } else {
                            if (key === 8 || key === 16 || key === 13 || key === 32 || key === 225 || key === 180 || key === 252 || key === 233 || key == 243 || key === 250 || key === 237 || key === 235 || key === 45 || key === 241 || key === 47 || key === 46) {
                                return true;
                            } else {
                                return false;
                            }
                        }
                    });
                    $('#alumno').typeahead({
                        minLength: 0,
                        maxItem: 10,
                        order: "asc",
                        hint: true,
                        accent: true,
                        dynamic: true,
                        searchOnFocus: true,
                        backdrop: {
                            "background-color": "#3879d9",
                            "opacity": "0.1",
                            "filter": "alpha(opacity=10)"
                        },
                        dropdownFilter: true,
                        dropdownFilter: "Todo",
                        emptyTemplate: "No hay resultado para su búsqueda",
                        source: {
                            Nombres: {
                                data: response.data
                            },
                            DNI: {
                                data: response.dni
                            },
                            Pasaporte: {
                                data: response.pasaporte
                            }
                        },
                        callback: {
                            onClickAfter: function(data) {
                                console.log(data);
                                $.ajax({
                                    type: 'POST',
                                    url: '{!! url('gape/gestion-egresado/egresado/get-data-alumno') !!}',
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                        "_method": 'POST',
                                        "input": data[0].value
                                    },
                                    dataType: 'JSON',
                                    success: function(returnData) {
                                        $('#idalumno').val(returnData.data[0]
                                            .idalumno);
                                        $('#paterno').val(returnData.data[0].paterno);
                                        $('#materno').val(returnData.data[0].materno);
                                        $('#nombres').val(returnData.data[0].nombres);

                                    }
                                });
                            }
                        }
                    });
                },
                error: function(err) {
                    console.log(err);
                }
            });
        }
        $('#form-alumno').on('submit', function(e) {
            if(IsEmpty(document.getElementById('send-alumno'),document.getElementById('num_documento'), document.getElementById('apaterno'),document.getElementById('amaterno'),document.getElementById('anombres'),document.getElementById('direccion'))){
            let url = '';
            let method = '';
            let msg = '';
            if ($('#type-send').val() == 'save') {
                url = '{!! url('gape/gestion-egresado/alumno/store') !!}';
                method = 'POST';
                msg = 'Datos de Alumno registrada correctamente';
            } else if ($('#type-send').val() == 'edit') {
                url = '{!! url('gape/gestion-egresado/alumno/update') !!}'
                method = 'PATCH';
                msg = 'Datos de Alumno actualizada correctamente';
            }
            e.preventDefault();
            let tipo_d = $('#tipo_documento').val();
            let num_d = $('#num_documento').val();
            let paterno = $('#apaterno').val();
            let materno = $('#amaterno').val();
            let nombres = $('#anombres').val();
            let direccion = $('#direccion').val();
            let correo = $('#correo').val();
            let telefono = $('#telefono').val();
            let celular = $('#celular').val();
            console.log(paterno, materno);
            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "_method": method,
                    "id": $('#idalumno').val(),
                    "tipo_documento": tipo_d,
                    "num_documento": num_d,
                    "paterno": paterno,
                    "materno": materno,
                    "nombres": nombres,
                    "direccion": direccion,
                    "correo": correo,
                    "telefono": telefono,
                    "celular": celular
                },
                dataType: 'JSON',
                success: function(response) {
                    console.log(response);
                    $('#idalumno').val(response.success.id);
                    $('#paterno').val(response.success.paterno);
                    $('#materno').val(response.success.materno);
                    $('#nombres').val(response.success.nombres);
                    $('#form-alumno')[0].reset();
                    getDataAlumno();
                    $('#modal-alumno').modal('hide');
                    $.notify({
                        icon: 'font-icon font-icon-check-circle',
                        title: '<strong>¡Existoso!</strong>',
                        message: msg
                    }, {
                        placement: {
                            from: "top",
                        },
                        type: 'success'
                    });
                },
                error: function(error) {
                    console.log(error);
                    html = '';
                    if (typeof error.responseJSON.errors.tipo_documento != 'undefined') {
                        html += '<li>' + error.responseJSON.errors.tipo_documento + '</li>'
                    };
                    if (typeof error.responseJSON.errors.num_documento != 'undefined') {
                        html += '<li>' + error.responseJSON.errors.num_documento + '</li>'
                    };
                    if (typeof error.responseJSON.errors.paterno != 'undefined') {
                        html += '<li>' + error.responseJSON.errors.paterno + '</li>'
                    };
                    if (typeof error.responseJSON.errors.materno != 'undefined') {
                        html += '<li>' + error.responseJSON.errors.materno + '</li>'
                    };
                    if (typeof error.responseJSON.errors.nombres != 'undefined') {
                        html += '<li>' + error.responseJSON.errors.nombres + '</li>'
                    };
                    if (typeof error.responseJSON.errors.direccion != 'undefined') {
                        html += '<li>' + error.responseJSON.errors.direccion + '</li>'
                    };
                    if (typeof error.responseJSON.errors.correo != 'undefined') {
                        html += '<li>' + error.responseJSON.errors.correo + '</li>'
                    };
                    if (typeof error.responseJSON.errors.telefono != 'undefined') {
                        html += '<li>' + error.responseJSON.errors.telefono + '</li>'
                    };
                    if (typeof error.responseJSON.errors.celular != 'undefined') {
                        html += '<li>' + error.responseJSON.errors.celular + '</li>'
                    };
                    $('#showErrores').html(html);
                    $("#alert-alumno").hide();
                    $("#alert-alumno").fadeTo(2000, 500).slideUp(500, function() {
                        $("#alert-alumno").slideUp(500);
                    });
                }
            });
        }
        });
        $('#agregarAlumno').click(function() {
            $('#type-send').val('save');
            $('#myModalLabel').text('Agregar Alumno');
        });
        $('#editarAlumno').click(function() {
            if ($('#idalumno').val() != '') {
                $('#myModalLabel').text('Editar Alumno');
                $('#type-send').val('edit');
                $.ajax({
                    type: 'POST',
                    url: '{!! url('gape/gestion-egresado/alumno/get-alumno') !!}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "_method": 'POST',
                        id: $('#idalumno').val()
                    },
                    dataType: 'JSON',
                    success: function(response) {
                        let tipo_d = $('#tipo_documento').val(response.data.tipo_documento);
                        let num_d = $('#num_documento').val(response.data.num_documento);
                        let paterno = $('#apaterno').val(response.data.paterno);
                        let materno = $('#amaterno').val(response.data.materno);
                        let nombres = $('#anombres').val(response.data.nombres);
                        let direccion = $('#direccion').val(response.data.direccional);
                        let correo = $('#correo').val(response.data.correo);
                        let telefono = $('#telefono').val(response.data.telefono);
                        let celular = $('#celular').val(response.data.celular);
                    }
                });
                $('#form-alumno')[0].reset();
                $('#modal-alumno').modal('show');
            } else {
                $.notify({
                    icon: 'font-icon font-icon-check-circle',
                    title: '<strong>¡Alto!</strong>',
                    message: 'Seleccione un registro o agregue un nuevo dato de alumno'
                }, {
                    placement: {
                        from: "top",
                    },
                    type: 'danger'
                });
            }
        });

        $('.add').on('click', function() {
            console.log($(this).attr('data-id'));
            let condicion = $(this).attr('data-id');
            let id = $('#idalumno').val();
            if (condicion == 'Egresado Pregrado') {
                $.ajax({
                    type: 'POST',
                    url: '{!! route('egresado.store-condicion-alumno') !!}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "_method": 'POST',
                        id: id,
                        condicion: condicion,
                        codigo_local: $('#local_e_p').val(),
                        escuela: $('#escuela_e_p').val(),
                        ingreso: $('#semestre_ingreso_e_p').val(),
                        egreso: $('#semestre_egreso_e_p').val(),
                        resolucion: $('#resolucion_e_p').val()
                    },
                    dataType: 'JSON',
                    success: function(response) {
                        $('#tabla-e-p').DataTable().ajax.reload();
                        if (response.success) {
                            console.log('registro satisfactorio');
                        }
                    }
                });
            }
            if (condicion == 'Graduado Pregrado') {
                $.ajax({
                    type: 'POST',
                    url: '{!! route('egresado.store-condicion-alumno') !!}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "_method": 'POST',
                        id: id,
                        condicion: condicion,
                        escuela: $('#escuela_g_p').val(),
                        resolucion: $('#resolucion_g_p').val()
                    },
                    dataType: 'JSON',
                    success: function(response) {
                        $('#tabla-g-p').DataTable().ajax.reload();
                        if (response.success) {
                            console.log('registro satisfactorio');
                        }
                    }
                });
            }
            if (condicion == 'Egresado Maestria') {
                $.ajax({
                    type: 'POST',
                    url: '{!! route('egresado.store-condicion-alumno') !!}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "_method": 'POST',
                        id: id,
                        condicion: condicion,
                        codigo_local: $('#local_e_m').val(),
                        maestria: $('#maestria_e_m').val(),
                        ingreso: $('#semestre_ingreso_e_m').val(),
                        egreso: $('#semestre_egreso_e_m').val(),
                        resolucion: $('#resolucion_e_m').val()
                    },
                    dataType: 'JSON',
                    success: function(response) {
                        $('#tabla-e-m').DataTable().ajax.reload();
                        if (response.success) {
                            console.log('registro satisfactorio');
                        }
                    }
                });
            }
            if (condicion == 'Graduado Maestria') {
                $.ajax({
                    type: 'POST',
                    url: '{!! route('egresado.store-condicion-alumno') !!}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "_method": 'POST',
                        id: id,
                        condicion: condicion,
                        maestria: $('#maestria_g_m').val(),
                        resolucion: $('#resolucion_g_m').val()
                    },
                    dataType: 'JSON',
                    success: function(response) {
                        $('#tabla-g-m').DataTable().ajax.reload();
                        if (response.success) {
                            console.log('registro satisfactorio');
                        }
                    }
                });
            }
            if (condicion == 'Egresado Doctorado') {
                $.ajax({
                    type: 'POST',
                    url: '{!! route('egresado.store-condicion-alumno') !!}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "_method": 'POST',
                        id: id,
                        condicion: condicion,
                        codigo_local: $('#local_e_d').val(),
                        doctorado: $('#doctorado_e_d').val(),
                        ingreso: $('#semestre_ingreso_e_d').val(),
                        egreso: $('#semestre_egreso_e_d').val(),
                        resolucion: $('#resolucion_e_d').val()
                    },
                    dataType: 'JSON',
                    success: function(response) {
                        $('#tabla-e-d').DataTable().ajax.reload();
                        if (response.success) {
                            console.log('registro satisfactorio');
                        }
                    }
                });
            }
            if (condicion == 'Graduado Doctorado') {
                $.ajax({
                    type: 'POST',
                    url: '{!! route('egresado.store-condicion-alumno') !!}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "_method": 'POST',
                        id: id,
                        condicion: condicion,
                        doctorado: $('#doctorado_g_d').val(),
                        resolucion: $('#resolucion_g_d').val()
                    },
                    dataType: 'JSON',
                    success: function(response) {
                        $('#tabla-g-d').DataTable().ajax.reload();
                        if (response.success) {
                            console.log('registro satisfactorio');
                        }
                    }
                });
            }

        })

        function getDataEdit(id) {
            $.ajax({
                type: 'POST',
                url: '{!! route('egresado.get-data-condicion-alumno') !!}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "_method": 'POST',
                    id: id,
                },
                dataType: 'JSON',
                success: function(response) {
                    console.log(response);
                    $('#condicion_id').val(response.id);
                    if (response.condicion_id == 1) {
                        $('#local_e_p').val(response.codigo_local);
                        $('#local_e_p').change();
                        $('#escuela_e_p').val(response.escuela_id);
                        $('#escuela_e_p').change();
                        $('#semestre_ingreso_e_p').val(response.semestre_ingreso);
                        $('#semestre_ingreso_e_p').change();
                        $('#semestre_egreso_e_p').val(response.semestre_egreso);
                        $('#semestre_egreso_e_p').change();
                        $('#resolucion_e_p').val(response.resolucion);
                        $('#resolucion_e_p').change();
                    }
                    if (response.condicion_id == 2) {
                        $('#escuela_g_p').val(response.escuela_id);
                        $('#escuela_g_p').change();
                        $('#resolucion_g_p').val(response.resolucion);
                        $('#resolucion_g_p').change();
                    }
                    if (response.condicion_id == 3) {
                        $('#local_e_m').val(response.codigo_local);
                        $('#local_e_m').change();
                        $('#maestria_e_m').val(response.maestria_id);
                        $('#maestria_e_m').change();
                        $('#semestre_ingreso_e_m').val(response.semestre_ingreso);
                        $('#semestre_ingreso_e_m').change();
                        $('#semestre_egreso_e_m').val(response.semestre_egreso);
                        $('#semestre_egreso_e_m').change();
                        $('#resolucion_e_m').val(response.resolucion);
                        $('#resolucion_e_m').change();
                    }
                    if (response.condicion_id == 4) {
                        $('#maestria_g_m').val(response.maestria_id);
                        $('#maestria_g_m').change();
                        $('#resolucion_g_m').val(response.resolucion);
                        $('#resolucion_g_m').change();
                    }
                    if (response.condicion_id == 5) {
                        $('#local_e_d').val(response.codigo_local);
                        $('#local_e_d').change();
                        $('#doctorado_e_d').val(response.doctorado_id);
                        $('#doctorado_e_d').change();
                        $('#semestre_ingreso_e_d').val(response.semestre_ingreso);
                        $('#semestre_ingreso_e_d').change();
                        $('#semestre_egreso_e_d').val(response.semestre_egreso);
                        $('#semestre_egreso_e_d').change();
                        $('#resolucion_e_d').val(response.resolucion);
                        $('#resolucion_e_d').change();
                    }
                    if (response.condicion_id == 6) {
                        $('#doctorado_g_d').val(response.doctorado_id);
                        $('#doctorado_g_d').change();
                        $('#resolucion_g_d').val(response.resolucion);
                        $('#resolucion_g_d').change();
                    }

                    $('.add').hide();
                    $('.minus').show();
                }
            });
        }

        $(".minus").on("click", function() {
            $.ajax({
                type: 'POST',
                url: '{!! route('egresado.update-condicion-alumno') !!}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "_method": 'PATCH',
                    id: $('#condicion_id').val(),
                    codigo_local_e_p: $('#local_e_p').val(),
                    escuela_e_p: $('#escuela_e_p').val(),
                    ingreso_e_p: $('#semestre_ingreso_e_p').val(),
                    egreso_e_p: $('#semestre_egreso_e_p').val(),
                    resolucion_e_p: $('#resolucion_e_p').val(),

                    escuela_g_p: $('#escuela_g_p').val(),
                    resolucion_g_p: $('#resolucion_g_p').val(),

                    codigo_local_e_m: $('#local_e_m').val(),
                    maestria_e_m: $('#maestria_e_m').val(),
                    ingreso_e_m: $('#semestre_ingreso_e_m').val(),
                    egreso_e_m: $('#semestre_egreso_e_m').val(),
                    resolucion_e_m: $('#resolucion_e_m').val(),

                    maestria_g_m: $('#maestria_g_m').val(),
                    resolucion_g_m: $('#resolucion_g_m').val(),

                    codigo_local_e_d: $('#local_e_d').val(),
                    doctorado_e_d: $('#doctorado_e_d').val(),
                    ingreso_e_d: $('#semestre_ingreso_e_d').val(),
                    egreso_e_d: $('#semestre_egreso_e_d').val(),
                    resolucion_e_d: $('#resolucion_e_d').val(),

                    doctorado_g_d: $('#doctorado_g_d').val(),
                    resolucion_g_d: $('#resolucion_g_d').val()
                },
                dataType: 'JSON',
                success: function(response) {
                    $('.add').show();
                    $('.minus').hide();
                    if(response.success == 1){
                        $('#tabla-e-p').DataTable().ajax.reload();
                    }
                    if(response.success ==2){
                        $('#tabla-g-p').DataTable().ajax.reload();
                    }
                    if(response.success==3){
                        $('#tabla-e-m').DataTable().ajax.reload();
                    }
                    if(response.success == 4){
                        $('#tabla-g-m').DataTable().ajax.reload();
                    }
                    if(response.success==5){
                        $('#tabla-e-d').DataTable().ajax.reload();
                    }
                    if(response.success==6){
                        $('#tabla-g-d').DataTable().ajax.reload();
                    }
                }
            });
        });
    </script>
@endsection
