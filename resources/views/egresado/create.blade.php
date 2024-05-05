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
                        <li><a href="{{ route('egresado.index') }}">Egresado</a></li>
                        <li class="active">Crear</li>
                    </ol>
                </div>
                <div class="pull-right">
                    <a href="{{ route('egresado.index') }}" class="btn btn-inline btn-secondary btn-rounded btn-sm"><i
                            class="fa fa-angle-left"></i> Atrás</a>
                </div>
            </header>

            <input type="hidden" id="data-typehead">
            <input type="hidden" id="type-send">
            {!! Form::open(['route' => 'egresado.store', 'method' => 'POST', 'id' => 'form-egresado','onsubmit'=>'return egresadoSubmit();']) !!}
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
                                        <strong class="form-label">Busqueda de alumnos:</strong>
                                        <div id="buscador">
                                            <div class="typeahead-container">
                                                <div class="typeahead-field">
                                                    <span class="typeahead-query">
                                                        <input id="alumno" class="form-control" name="q" type="search"
                                                            autocomplete="off" onkeypress="return SearchNumerosLetras(event,this)">
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
                                                id="agregarAlumno" onclick="ResetHTMLAlumno()">Agregar Datos</button>
                                        </div>
                                        <div class="p-2">
                                            <button type="button" class="btn btn-rounded btn-inline btn-warning"
                                            id="editarAlumno" onclick="ResetHTMLAlumno()">Editar Datos</button>
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
                        <div class="form-group">
                            <strong>Código del Alumno:<span class="is-required">*</span></strong>
                            {!! Form::text('codigo', null, ['placeholder' => 'Ingrese Codigo del Alumno', 'class' => 'form-control','id'=>'codigo','onkeyup'=>"MaxMinCadenas('send-egresado',12,10,this,true)",'onkeypress'=>"return SoloLetraNumeros('send-egresado',event,this,true)"]) !!}
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
                        <div>
                            <button type="button" class="close" data-dismiss="alert" aria-label="close">
                                <span aria-hidden="true">&times;</span>
                            </button>
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
                                    {!! Form::text('correo', null, ['placeholder' => 'Ingrese una correo', 'class' => 'form-control', 'id' => 'correo','onkeyup'=>"InputCorreo('send-alumno',this,30,10,true)"]) !!}
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
        $(document).ready(function() {

            // $('#form-egresado').validate({
            //     lang: 'es',
            //     rules: {
            //         codigo: {
            //             required: true,
            //             minlength: 10,
            //             maxlength: 10
            //         }
            //     },
            //     messages: {
            //         codigo: "Este campo es requerido."
            //     }
            // });

        });
        function egresadoSubmit(){
                if(IsEmpty(document.getElementById('send-egresado'),document.getElementById('codigo'))){
                    console.log('sd');
                    return true;
                }
                return false;
        }
        //
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        getDataAlumnos();

        function getDataAlumnos() {
            $.ajax({
                type: 'POST',
                url: '{!! url('gape/gestion-egresado/egresado/get-alumnos') !!}',
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
                                        console.log(returnData);
                                        $('#idalumno').val(returnData.data[0]
                                            .alumno_id);
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
        $('#form-alumno').on('submit',function(e) {
            if(IsEmpty(document.getElementById('send-alumno'),document.getElementById('num_documento'), document.getElementById('apaterno'),document.getElementById('amaterno'),document.getElementById('anombres'),document.getElementById('direccion'))){
                console.log(IsEmpty(document.getElementById('send-alumno'),document.getElementById('num_documento'), document.getElementById('apaterno'),document.getElementById('amaterno'),document.getElementById('anombres'),document.getElementById('direccion')));
            // $('#form-alumno').validate({
            //     lang: 'es',
            //     rules: {
            //         num_documento: {
            //             required: true,
            //             digits: true,
            //             minlength: 8,
            //             maxlength: 8
            //         },
            //         paterno: {
            //             required: true,
            //             maxlength: 20
            //         },
            //         materno: {
            //             required: true,
            //             maxlength: 20
            //         },
            //         nombres: {
            //             required: true,
            //             maxlength: 30
            //         },
            //         sexo: {
            //             required: true
            //         },
            //         direccion: {
            //             required: true
            //         },
            //         correo: {
            //             required: true
            //         },
            //         telefono: {
            //             required: true,
            //             digits: true,
            //             maxlength: 9,
            //             minlength: 9
            //         },
            //         celular: {
            //             required: true,
            //             digits: true,
            //             maxlength: 9,
            //             minlength: 9
            //         }
            //     },
            //     messages: {
            //         num_documento: "Ingrese solo números y solo 8 digitos.",
            //         paterno: "Ingrese un apellido paterno.",
            //         materno: "Ingrese un apellido materno.",
            //         nombres: "Ingrese un nombre.",
            //         sexo: "seleccione una opción.",
            //         direccion: "Este campo es requerido.",
            //         correo: "Este campo es requerido.",
            //         telefono: "Ingrese solo números y solo 9 dígitos",
            //         celular: "Ingrese solo números y solo 9 dígitos"
            //     }
            // });
            if($('#form-alumno').valid()){
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
            let sexo = $('#sexo').val();
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
                    "celular": celular,
                    "sexo": sexo
                },
                dataType: 'JSON',
                success: function(response) {
                    console.log(response);
                    $('#idalumno').val(response.success.id);
                    $('#paterno').val(response.success.paterno);
                    $('#materno').val(response.success.materno);
                    $('#nombres').val(response.success.nombres);
                    $('#form-alumno')[0].reset();
                    getDataAlumnos();
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
                    if (typeof error.responseJSON.errors.sexo != 'undefined') {
                        html += '<li>' + error.responseJSON.errors.sexo + '</li>'
                    };
                    $('#showErrores').html(html);
                    $("#alert-alumno").hide();
                    $("#alert-alumno").fadeTo(2000, 500).slideUp(500, function() {
                        $("#alert-alumno").slideUp(500);
                    });
                }
            });
            }
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
                        let sexo = $('#sexo').val(response.data.sexo);
                    }
                });
                $('#form-alumno')[0].reset();
                $('#modal-alumno').modal('show');
            } else {
                $.notify({
                    icon: 'font-icon font-icon-check-circle',
                    title: '<strong>¡Alto!</strong>',
                    message: 'Seleccione un registro o agregue un nuevo dato de alumnos'
                }, {
                    placement: {
                        from: "top",
                    },
                    type: 'danger'
                });
            }
        });
    </script>
@endsection
