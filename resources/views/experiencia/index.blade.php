@extends('layouts.app')
@section('css')
    <link href="{{ asset('web/css/typeahead.min.css') }}" rel="stylesheet">
    <link href="{{ asset('web/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('web/css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/validaciones.css') }}" rel="stylesheet">
@endsection
@section('content')
    <div class="container-fluid">
        <section class="card">
            <header class="card-header">
                <div class="pull-left">
                    <ol class="breadcrumb breadcrumb-simple">
                        <li><a href="#">Inicio</a></li>
                        <li class="active">Experiencia</li>
                    </ol>
                </div>
                <div class="pull-right">
                    <input type="hidden" id="type-send-empresa">
                    {{-- @can('usuarios-crear') --}}
                    <a href="#" id="agregar-experiencia" onclick="ResetHTMLExperiencia()" class="btn btn-inline btn-success btn-rounded btn-sm"><i
                            class="fa fa-plus-circle"></i>
                        Nuevo
                    </a>
                    {{-- @endcan --}}
                </div>
            </header>
            <div class="card-block">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-no-border alert-close alert-dismissible fade in">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <p>{{ $message }}</p>
                    </div>
                @endif
                <table id="table" class="display table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Empresa</th>
                            <th>Cargo</th>
                            <th>Fecha Inicio</th>
                            <th>Fecha Salida</th>
                            <th>Reconocimientos</th>
                            <th>Satisfacción</th>
                            <th>Archivo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </section>
    </div>

    <div class="modal fade bd-example-modal-lg" id="modal-experiencia-agregar" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true" style="overflow-y: scroll;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                {!! Form::open(['route' => 'egresado.experiencia_store', 'method' => 'POST', 'action' => 'check-imc', 'id' => 'form-experiencia', 'file' => true, 'enctype' => 'multipart/form-data','onsubmit'=>'return experienciaSubmit()']) !!}
                <div class="modal-header">
                    <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                        <i class="font-icon-close-2"></i>
                    </button>
                    <h4 class="modal-title" id="tituloexp">Agregar Experiencia</h4>
                </div>
                <div class="modal-body">
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
                                                <strong class="form-label">Busqueda de Empresas:</strong>
                                                <div id="buscador">
                                                    <div class="typeahead-container">
                                                        <div class="typeahead-field">
                                                            <span class="typeahead-query">
                                                                <input id="empresas" class="form-control" name="q"
                                                                    type="search" autocomplete="off">
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
                                                        id="agregarEmpresa" onclick="ResetHTMLEmpresa()">Agregar Entidad</button>
                                                </div>
                                                <div class="p-2">
                                                    <button type="button" class="btn btn-rounded btn-inline btn-warning"
                                                        id="editarEmpresa" onclick="ResetHTMLEmpresa()">Editar Entidad</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="column">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <strong>Tipo de Entidad:</strong>
                                            <input type="text" id="tipo_entidad" readonly class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <strong>Razon Social:</strong>
                                            <input type="text" id="razon_social" readonly class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <strong>Correo:</strong>
                                            <input type="text" id="correo" readonly class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                {!! Form::hidden('idalumno', $alumno_id, null, ['class' => 'form-control', 'id' => 'idalumno2']) !!}
                                {!! Form::hidden('identidad', null, ['class' => 'form-control', 'id' => 'idempresa']) !!}
                                <div class="form-group">
                                    <strong><span class="is-required">*</span>Cargo Laboral:</strong>
                                    {!! Form::select('cargo_laboral', $cargo, null, ['class' => 'form-control select2', 'id' => 'ecargo']) !!}
                                </div>
                                <div class="form-group">
                                    <strong><span class="is-required">*</span>Fecha Inicio:</strong>
                                    {!! Form::date('fecha_inicio', null, ['placeholder' => 'Fecha de Inicio', 'class' => 'form-control', 'id' => 'efecha_inicio','onchange'=>"dateVal(document.getElementById('send-experiencia'),this,true)"]) !!}
                                </div>
                                <div class="form-group">
                                    <strong><span class="is-required">*</span>Fecha Fin:</strong>
                                    {!! Form::date('fecha_salida', null, ['placeholder' => 'Fecha de Fin', 'class' => 'form-control', 'id' => 'efecha_fin','onchange'=>"dateVal(document.getElementById('send-experiencia'),this,true)"]) !!}
                                </div>
                                <div class="form-group">
                                    <strong>Reconocimientos:</strong>
                                    {!! Form::text('reconocimientos', null, ['placeholder' => 'Ingreses algunos reconocimientos', 'class' => 'form-control', 'id' => 'reconocimientos','onkeyup'=>"MaxMinCadenas('send-experiencia',255,10,this,false)"]) !!}
                                </div>
                                <div class="form-group">
                                    <strong><span class="is-required">*</span>Satisfacción:</strong>
                                    {!! Form::select('nivel_satisfaccion', $satisfaccion, null, ['class' => 'form-control select2', 'id' => 'satisfaccion']) !!}
                                </div>
                                <div class="form-group">
                                    <strong><span class="is-required">*</span>Estado:</strong>
                                    {!! Form::select('estado', $estado, null, ['class' => 'form-control select2', 'id' => 'estado']) !!}
                                </div>
                                <div class="form-group">
                                    <strong><span class="is-required">*</span>Certificado de Trabajo:</strong>
                                    {!! Form::file('archivo', null, ['class' => 'form-control bootstrap-select'], ['class' => 'bootstrap-select', 'id' => 'archivo']) !!}
                                </div>
                                {!! Form::hidden('updateExp', null, ['class' => 'form-control', 'id' => 'updateExp']) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-rounded btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary btn-rounded" id="send-experiencia"><i
                            class="fa fa-save"></i> Guardar</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-empresa" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                        <i class="font-icon-close-2"></i>
                    </button>
                    <h4 class="modal-title" id="myModalLabel-empresa"></h4>
                </div>
                <div class="modal-body">
                    {!! Form::open(['method' => 'POST', 'id' => 'form-empresa','onsubmit'=>'return false;']) !!}
                    <div class="card-block">

                        <div class="row">
                            <div class="col-xs-10 col-sm-10 col-md-10">
                                <div class="form-group">
                                    <strong>Tipo de Entidad:</strong><br>
                                    {!! Form::select('tipo_empresa', $tipo_empresa, ['class' => 'form-control'], ['class' => 'custom-select', 'id' => 'tipo_empresa']) !!}
                                </div>
                                <div class="form-group">
                                    <strong><span class="is-required">*</span>Nombre:</strong>
                                    {!! Form::text('nombre', null, ['placeholder' => 'Ingrese el nombre de la empresa', 'class' => 'form-control', 'id' => 'enombre','onkeyup'=>"MaxMinCadenas('send-empresa',64,10,this,true)",'onkeypress'=>"return SoloLetraNumeros('send-empresa',event,this,true)"]) !!}
                                </div>
                                <div class="form-group">
                                    <strong><span class="is-required">*</span>Correo:</strong>
                                    {!! Form::text('Correo', null, ['placeholder' => 'Ingrese el correo de la empresa', 'class' => 'form-control', 'id' => 'ecorreo','onkeyup'=>"InputCorreo('send-empresa',this,30,10,true)"]) !!}
                                </div>
                                <div class="form-group">
                                    <strong><span class="is-required">*</span>Teléfono:</strong>
                                    {!! Form::text('telefono', null, ['placeholder' => 'Ingrese un teléfono', 'class' => 'form-control', 'id' => 'etelefono','onkeyup'=>"MaxMinCadenas('send-empresa',10,5,this,true)",'onkeypress'=>"return SoloNumeros('send-empresa',event,this,true)"]) !!}
                                </div>
                                <div class="form-group">
                                    <strong><span class="is-required">*</span>Celular:</strong>
                                    {!! Form::text('celular', null, ['placeholder' => 'Ingrese un celular', 'class' => 'form-control', 'id' => 'ecelular','onkeyup'=>"MaxMinCadenas('send-empresa',9,9,this,true)",'onkeypress'=>"return SoloNumeros('send-empresa',event,this,true)"]) !!}
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-rounded btn-primary" id="send-empresa">Guardar</button>
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
    function experienciaSubmit(){
        if($('#idempresa').val()==''){
            $.notify({
                    icon: 'font-icon font-icon-check-circle',
                    title: '<strong>¡Alto!</strong>',
                    message: 'Seleccione una empresa'
                }, {
                    placement: {
                        from: "top",
                    },
                    type: 'danger'
                });
            return false;
        }
                if(IsEmpty(document.getElementById('send-experiencia'),document.getElementById('efecha_inicio'),document.getElementById('efecha_fin'),document.getElementById('reconocimientos',document.getElementById('satisfaccion'),document.getElementById('estado')))){
                    if($('input[name="archivo"]').get(0).files.length == 1){
                var nameFile = $('input[name="archivo"]').get(0).files[0].name;
                let extension = nameFile.split('.').pop();
                if(extension == 'pdf'){
                    return true;
                }else{
                    $.notify({
                    icon: 'font-icon font-icon-check-circle',
                    title: '<strong>¡Alto!</strong>',
                    message: 'Solo se acepta archivos tipo pdf'
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
                    message: 'Seleccione un documento'
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
        $(document).ready(function() {
            let tabla = $('#table').DataTable({
                responsive: true,
                "processing": true,
                "serverSide": true,
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
                    "url": "{{ route('egresado.get_experiencia') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": {
                        _token: "{{ csrf_token() }}",
                        "id": ''
                    }
                },
                "columns": [{
                        "data": "idexperiencia"
                    },
                    {
                        "data": "identidad"
                    },
                    {
                        "data": "cargo_laboral"
                    },
                    {
                        "data": "fecha_inicio"
                    },
                    {
                        "data": "fecha_salida"
                    },
                    {
                        "data": "reconocimientos"
                    },
                    {
                        "data": "nivel_satisfaccion"
                    },
                    {
                        "data": "archivo"
                    },
                    {
                        "data": "opciones"
                    }
                ],
                "columnDefs": [{
                        "className": "text-center",
                        "targets": [0, 8]
                    },
                    {
                        "bSortable": false,
                        "aTargets": [7, 8]
                    },
                ],
            });
            $('#table tbody').on('click', '.delete-confirm', function() {
                let idexperiencia = $(this).attr('data-id');
                let url = '{!! url('gape/gestion-egresado/egresado/experiencia-destroy') !!}/';
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
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            $.ajax({
                                type: 'POST',
                                url: url,
                                data: {
                                    "_token": "{{ csrf_token() }}",
                                    "_method": 'DELETE',
                                    "id": idexperiencia,
                                },
                                dataType: 'JSON',
                                beforeSend: function() {},
                                success: function(response) {
                                    if (response.success) {
                                        $.notify({
                                            icon: 'font-icon font-icon-check-circle',
                                            title: '<strong>¡Existoso!</strong>',
                                            message: 'Experiencia Laboral eliminada correctamente'
                                        }, {
                                            placement: {
                                                from: "top",
                                            },
                                            type: 'success'
                                        });
                                        $('#table').DataTable().ajax.reload();
                                    } else {
                                        $.notify({
                                            icon: 'font-icon font-icon-warning',
                                            title: '<strong>¡Error!</strong>',
                                            message: 'Hubo un error al eliminar la Experiencia Laboral.'
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

        });

        function getDataEmpresa() {
            $.ajax({
                type: 'POST',
                url: '{!! url('gape/gestion-egresado/egresado/get-empresas') !!}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "_method": 'POST',
                },
                dataType: 'JSON',
                beforeSend: function() {},
                success: function(response) {
                    if ($('#type-empresa').length) {

                        $('#buscador').html(
                            '<div class="typeahead-container"><div class="typeahead-field"><span class="typeahead-query"><input id="empresas"class="form-control"name="q"type="search"autocomplete="off"></span></div></div>'
                        );

                    }
                    $('#empresas').typeahead({
                        minLength: 0,
                        maxItem: 10,
                        order: "asc",
                        hint: true,
                        accent: true,
                        dynamic: true,
                        searchOnFocus: true,
                        backdrop: false,
                        emptyTemplate: "No hay resultado para su búsqueda",
                        source: response.data,
                        callback: {
                            onClickAfter: function(data) {
                                console.log(data[0].value);
                                $.ajax({
                                    type: 'POST',
                                    url: '{!! route('empresa.get_data_empresa') !!}',
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                        "_method": 'POST',
                                        "input": data[0].value
                                    },
                                    dataType: 'JSON',
                                    success: function(returnData) {
                                        console.log(returnData);
                                        $('#tipo_entidad').val(returnData.data[0]
                                            .tipo_entidad);
                                        $('#razon_social').val(returnData.data[0]
                                            .nombre);
                                        $('#correo').val(returnData.data[0].correo);
                                        $('#idempresa').val(returnData.data[0]
                                            .identidad);
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

        function EditarDatosAcademicos(id) {
            $('#updateExp').val(id);
            $.ajax({
                type: 'POST',
                url: '{!! route('egresado.get_data_experiencia') !!}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "_method": 'POST',
                    "id": id
                },
                dataType: 'JSON',
                success: function(data) {
                    console.log(data);
                    //$('#idalumno').val(data.alumno_id);
                    $('#identidad').val(data.entidad_id);
                    $('#ecargo').val(data.cargo_laboral).change();
                    $('#efecha_inicio').val(data.fecha_inicio);
                    $('#efecha_fin').val(data.fecha_salida);
                    $('#reconocimientos').val(data.reconocimientos);
                    $('#satisfaccion').val(data.nivel_satisfaccion).change();
                    $('#estado').val(data.estado).change();
                    $.ajax({
                        type: 'POST',
                        url: '{!! route('empresa.get_data_empresa') !!}',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "_method": 'POST',
                            "input": data.alumno_id
                        },
                        dataType: 'JSON',
                        success: function(returnData) {
                            console.log(returnData);
                            $('#tipo_entidad').val(returnData.data[0]
                                .tipo_entidad);
                            $('#razon_social').val(returnData.data[0]
                                .nombre);
                            $('#correo').val(returnData.data[0].correo);
                            $('#idempresa').val(returnData.data[0]
                                .identidad);
                        }
                    });
                }
            });
            $('#modal-experiencia-agregar').modal("show");
        }

        $('#agregarEmpresa').click(function() {
            $('#type-send-empresa').val('save');
            $('#myModalLabel-empresa').text('Agregar Empresa');
            $('#form-empresa')[0].reset();
            $('#modal-empresa').modal('show');
        });

        $('#editarEmpresa').click(function() {
            if ($('#idempresa').val() != '') {
                $('#myModalLabel-empresa').text('Editar Empresa');
                $('#type-send-empresa').val('edit');
                $.ajax({
                    type: 'POST',
                    url: '{!! route('empresa.get_empresa') !!}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "_method": 'POST',
                        id: $('#idempresa').val()
                    },
                    dataType: 'JSON',
                    success: function(response) {
                        let tipo_d = $('#tipo_empresa option').filter(function(){
                            return $(this).text()==response.data.tipo;
                        }).prop('selected',true);
                        let num_d = $('#enombre').val(response.data.nombre);
                        let paterno = $('#ecorreo').val(response.data.correo);
                        let materno = $('#etelefono').val(response.data.telefono);
                        let nombres = $('#ecelular').val(response.data.celular);
                    }
                });
                $('#form-empresa')[0].reset();
                $('#modal-empresa').modal('show');
            } else {
                $.notify({
                    icon: 'font-icon font-icon-check-circle',
                    title: '<strong>¡Alto!</strong>',
                    message: 'Seleccione un registro o agregue un nuevo dato de alguna empresa'
                }, {
                    placement: {
                        from: "top",
                    },
                    type: 'danger'
                });
            }
        });
        $('#form-empresa').on('submit', function(e) {
            if(IsEmpty(document.getElementById('send-empresa'),document.getElementById('enombre'),document.getElementById('ecorreo'),document.getElementById('etelefono'),document.getElementById('ecelular'))){
            let url = '';
            let method = '';
            let msg = '';
            if ($('#type-send-empresa').val() == 'save') {
                url = '{!! route('empresa.store') !!}';
                console.log('{!! route('empresa.store') !!}');
                method = 'POST';
                msg = 'Datos de Empresa registrada correctamente';
            } else if ($('#type-send-empresa').val() == 'edit') {
                url = '{!! route('empresa.update') !!}'
                method = 'PATCH';
                msg = 'Datos de Empresa actualizada correctamente';
            }
            e.preventDefault();
            let tipo_d = $('#tipo_empresa').val();
            console.log(tipo_d);
            let nombre = $('#enombre').val();
            let correo = $('#ecorreo').val();
            let telefono = $('#etelefono').val();
            let celular = $('#ecelular').val();
            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "_method": method,
                    "id": $('#idempresa').val(),
                    "tipo_entidad": tipo_d,
                    "nombre": nombre,
                    "correo": correo,
                    "telefono": telefono,
                    "celular": celular
                },
                dataType: 'JSON',
                success: function(response) {
                    console.log(response);

                    $('#tipo_entidad').val(response.success[0].tipo);
                    $('#razon_social').val(response.success[0].nombre);
                    $('#correo').val(response.success[0].correo);
                    $('#idempresa').val(response.success[0].id);

                    $('#form-empresa')[0].reset();

                    getDataEmpresa();

                    $('#modal-empresa').modal('hide');

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
                    // console.log(error);
                    // html = '';
                    // if (typeof error.responseJSON.errors.tipo != 'undefined') {
                    //     html += '<li>' + error.responseJSON.errors.tipo + '</li>'
                    // };
                    // if (typeof error.responseJSON.errors.nombre != 'undefined') {
                    //     html += '<li>' + error.responseJSON.errors.nombre + '</li>'
                    // };
                    // if (typeof error.responseJSON.errors.correo != 'undefined') {
                    //     html += '<li>' + error.responseJSON.errors.correo + '</li>'
                    // };
                    // if (typeof error.responseJSON.errors.telefono != 'undefined') {
                    //     html += '<li>' + error.responseJSON.errors.telefono + '</li>'
                    // };
                    // if (typeof error.responseJSON.errors.celular != 'undefined') {
                    //     html += '<li>' + error.responseJSON.errors.celular + '</li>'
                    // };

                    //$('#showErrores').html(html);
                    //$("#alert-empresa").hide();
                    //$("#alert-empresa").fadeTo(2000, 500).slideUp(500, function() {
                    //     $("#alert-empresa").slideUp(500);
                    // });
                }

            });
        }
        });

        $('#agregar-experiencia').click(function() {
            console.log($('#capacitacion_experiencia').val());
            $('#modal-experiencia-agregar').modal("show");
            $('#updateExp').val(-1);
            $('#form-experiencia')[0].reset();
            getDataEmpresa();
        });
    </script>
@endsection
