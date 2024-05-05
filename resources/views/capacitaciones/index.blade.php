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
                        <li class="active">Capacitaciones</li>
                    </ol>
                </div>
                <div class="pull-right">
                    <input type="hidden" id="type-send-curso">
                    {{-- @can('usuarios-crear') --}}
                    <a href="#" id="agregar-capacitaciones" onclick="ResetHTMLCapacitacion()" class="btn btn-inline btn-success btn-rounded btn-sm"><i
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
                            <th>Descripción</th>
                            <th>Curso</th>
                            <th>Estado</th>
                            <th>Certificado</th>
                            <th>Acciones</th>

                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </section>
    </div>

    <div class="modal fade bd-example-modal-lg" id="modal-capacitacion-agregar" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true" style="overflow-y: scroll;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                {!! Form::open(['route' => 'egresado.capacitacion_store', 'method' => 'POST', 'id' => 'form-capacitacion', 'file' => true, 'enctype' => 'multipart/form-data','onsubmit'=>'return capacitacionSubmit()']) !!}
                <div class="modal-header">
                    <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                        <i class="font-icon-close-2"></i>
                    </button>
                    <h4 class="modal-title" id="titulocapa">Agregar Capacitación</h4>
                </div>
                <div class="modal-body">
                    <div class="card-block">
                        <div class="row">
                            <div class="container">
                                <div class="column">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-sm col-sm-12">
                                                <strong class="form-label">Busqueda de Cursos:</strong>
                                                <div id="buscador2">
                                                    <div class="typeahead-container">
                                                        <div class="typeahead-field">
                                                            <span class="typeahead-query">
                                                                <input id="cursos" class="form-control" name="q"
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
                                                        id="agregarCurso" onclick="ResetHTMLCurso()">Agregar Curso</button>
                                                </div>
                                                <div class="p-2">
                                                    <button type="button" class="btn btn-rounded btn-inline btn-warning"
                                                        id="editarCurso" onclick="ResetHTMLCurso()">Editar Curso</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="column">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <strong>Titulo del Cursos:</strong>
                                            <input type="text" id="ctitulo" readonly class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <strong>Creditos:</strong>
                                            <input type="text" id="ccreditos" readonly class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <strong>Horas:</strong>
                                            <input type="text" id="choras" readonly class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <strong>Area:</strong>
                                            <input type="text" id="carea" readonly class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                {!! Form::hidden('idalumno',$alumno_id, null, ['class' => 'form-control', 'id' => 'idalumno']) !!}
                                {!! Form::hidden('idcurso', null, ['class' => 'form-control', 'id' => 'idcurso']) !!}
                                <div class="form-group">
                                    <strong><span class="is-required">*</span>Descripcion:</strong>
                                    {!! Form::text('descripcion', null, ['placeholder' => 'Ingrese una descripcion de la capacitacion', 'class' => 'form-control', 'id' => 'cdescripcion','onkeyup'=>"MaxMinCadenas('send-capacitacion',255,10,this,false)"]) !!}
                                </div>
                                <div class="form-group">
                                    <strong><span class="is-required">*</span>Fecha Inicio:</strong>
                                    {!! Form::date('fecha_inicio', null, ['placeholder' => 'Fecha de Inicio', 'class' => 'form-control', 'id' => 'cfecha_inicio','onchange'=>"dateVal(document.getElementById('send-capacitacion'),this,true)"]) !!}
                                </div>
                                <div class="form-group">
                                    <strong><span class="is-required">*</span>Fecha Fin:</strong>
                                    {!! Form::date('fecha_fin', null, ['placeholder' => 'Fecha de Fin', 'class' => 'form-control', 'id' => 'cfecha_fin','onchange'=>"dateVal(document.getElementById('send-capacitacion'),this,true)"]) !!}
                                </div>
                                <div class="form-group">
                                    <strong><span class="is-required">*</span>Estado:</strong>
                                    {!! Form::select('condicion', $estado, null, ['class' => 'form-control select2', 'id' => 'cestado']) !!}
                                </div>
                                <div class="form-group">
                                    <strong><span class="is-required">*</span>Certificado de Capacitación:</strong>
                                    {!! Form::file('archivo', null, ['class' => 'form-control bootstrap-select'], ['class' => 'bootstrap-select', 'id' => 'archivo']) !!}
                                </div>
                                {!! Form::hidden('updateCap', null, ['class' => 'form-control', 'id' => 'updateCap']) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-rounded btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary btn-rounded" id="send-capacitacion"><i
                            class="fa fa-save"></i> Guardar</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-curso" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                    <i class="font-icon-close-2"></i>
                </button>
                <h4 class="modal-title" id="myModalLabel-curso">Agregar Curso</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(['method' => 'POST', 'id' => 'form-curso','onsubmit'=>'return false;']) !!}
                <div class="card-block">

                    <div class="row">
                        <div class="col-xs-10 col-sm-10 col-md-10">
                            <div class="form-group">
                                <strong><span class="is-required">*</span>Entidad:</strong><br>
                                {!! Form::select('identidad', $curso_empresa, ['class' => 'form-control'], ['class' => 'custom-select', 'id' => 'cidentidad','onchange'=>"seleVal(documento.getElementById('send-curso',this,true))"]) !!}
                            </div>
                            <div class="form-group">
                                <strong><span class="is-required">*</span>Titulo:</strong>
                                {!! Form::text('titulo', null, ['placeholder' => 'Ingrese el titulo del cursos', 'class' => 'form-control', 'id' => 'titulo','onkeyup'=>"MaxMinCadenas('send-curso',100,0,this,true)",'onkeypress'=>"return SoloLetraNumeros('send-curso',event,this,true)"]) !!}
                            </div>
                            <div class="form-group">
                                <strong><span class="is-required">*</span>Descripción:</strong>
                                {!! Form::text('descripcion', null, ['placeholder' => 'Ingrese una descripción del curso', 'class' => 'form-control', 'id' => 'descripcion','onkeyup'=>"MaxMinCadenas('send-curso',255,1,this,true)"]) !!}
                            </div>
                            <div class="form-group">
                                <strong><span class="is-required">*</span>Créditos:</strong>
                                {!! Form::text('creditos', null, ['placeholder' => 'Ingrese la cantidad de créditos', 'class' => 'form-control', 'id' => 'creditos','onkeyup'=>"MaxMinCadenas('send-curso',2,1,this,true)",'onkeypress'=>"return SoloNumeros('send-curso',event,this,true)"]) !!}
                            </div>
                            <div class="form-group">
                                <strong><span class="is-required">*</span>Horas:</strong>
                                {!! Form::text('horas', null, ['placeholder' => 'Ingrese un numero de horas', 'class' => 'form-control', 'id' => 'horas','onkeyup'=>"MaxMinCadenas('send-curso',3,1,this,true)",'onkeypress'=>"return SoloNumeros('send-curso',event,this,true)"]) !!}
                            </div>
                            <div class="form-group">
                                <strong><span class="is-required">*</span>Area:</strong><br>
                                {!! Form::select('idarea', $area, ['class' => 'form-control'], ['class' => 'custom-select', 'id' => 'area']) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-rounded btn-primary" id="send-curso">Guardar</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

<div class="modal fade" id="modal-apreciacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                    <i class="font-icon-close-2"></i>
                </button>
                <h4 class="modal-title" id="myModalLabel-curso">Apreciación</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(['method' => 'POST', 'id' => 'form-apreciacion']) !!}
                <div class="card-block">
                    <div class="row">
                        <div class="col-xs-10 col-sm-10 col-md-10">
                            {!! Form::hidden('idalumnooferta', null, ['class' => 'form-control', 'id' => 'idAlumnoOferta']) !!}
                            <div class="form-group">
                                <strong>Ingrese una apreciación respecto a la capacitación:</strong>
                                {!! Form::textarea('descripcion', null, ['placeholder' => 'Ingrese una apreciación sobre el curso', 'class' => 'form-control', 'id' => 'apreciacion']) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-rounded btn-primary" id="send-apreciacion">Guardar</button>
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
    function capacitacionSubmit(){
        if($('#idcurso').val()==''){
            $.notify({
                    icon: 'font-icon font-icon-check-circle',
                    title: '<strong>¡Alto!</strong>',
                    message: 'Seleccione un curso'
                }, {
                    placement: {
                        from: "top",
                    },
                    type: 'danger'
                });
            return false;
        }
                if(IsEmpty(document.getElementById('send-capacitacion'),document.getElementById('cdescripcion'),document.getElementById('cfecha_inicio'),document.getElementById('cfecha_fin'))){
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
                    "url": "{{ route('egresado.get_capacitaciones') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": {
                        _token: "{{ csrf_token() }}",
                        "id": ''
                    }
                },
                "columns": [{
                        "data": "idcapacitacion"
                    },
                    {
                        "data": "descripcion"
                    },
                    {
                        "data": "curso"
                    },
                    {
                        "data": "estado"
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
                        "targets": [0, 5]
                    },
                    {
                        "bSortable": false,
                        "aTargets": [4, 5]
                    },
                ],
            });
            $('#table tbody').on('click', '.delete-confirm', function() {
                let idcapacitacion = $(this).attr('data-id');
                let url = '{!! url('gape/gestion-egresado/egresado/destroy-capacitacion') !!}/';
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
                                    "id": idcapacitacion,
                                },
                                dataType: 'JSON',
                                beforeSend: function() {},
                                success: function(response) {
                                    if (response.success) {
                                        $.notify({
                                            icon: 'font-icon font-icon-check-circle',
                                            title: '<strong>¡Existoso!</strong>',
                                            message: 'Capacitación eliminada correctamente'
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
                                            message: 'Hubo un error al eliminar la Capacitacion.'
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

        function getDataCurso() {
            $.ajax({
                type: 'POST',
                url: '{!! url('gape/gestion-egresado/curso/get-cursos') !!}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "_method": 'POST',
                },
                dataType: 'JSON',
                success: function(returnData) {
                    if ($('#type-curso').length) {
                        $('#buscador2').html(
                            '<div class="typeahead-container"><div class="typeahead-field"><span class="typeahead-query"><input id="cursos"class="form-control"name="q"type="search"autocomplete="off"></span></div></div>'
                        );
                    }
                    $('#cursos').typeahead({
                        minLength: 0,
                        maxItem: 10,
                        order: "asc",
                        hint: true,
                        accent: true,
                        dynamic: true,
                        searchOnFocus: true,
                        backdrop: false,
                        emptyTemplate: "No hay resultado para su búsqueda",
                        source: returnData.data,
                        callback: {
                            onClickAfter: function(data) {
                                console.log(data[0].value);
                                $.ajax({
                                    type: 'POST',
                                    url: '{!! route('curso.get_data_curso') !!}',
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                        "_method": 'POST',
                                        "input": data[0].value
                                    },
                                    dataType: 'JSON',
                                    success: function(response) {
                                        console.log(response);
                                        $('#idcurso').val(response.data[0].idcurso);
                                        $('#ctitulo').val(response.data[0].titulo);
                                        $('#ccreditos').val(response.data[0].creditos);
                                        $('#choras').val(response.data[0].horas);
                                        $('#carea').val(response.data[0].area);
                                    }
                                });
                            }
                        }

                    });
                }
            });
        }

        function EditarDatosAcademicos(id) {
            $('#updateCap').val(id);
                $.ajax({
                    type: 'POST',
                    url: '{!! route('egresado.get_data_capacitacion') !!}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "_method": 'POST',
                        "id": id
                    },
                    dataType: 'JSON',
                    success: function(data) {
                        console.log(data);
                        //$('#idalumno').val(data.alumno_id);
                        $('#cdescripcion').val(data.descripcion);
                        $('#cfecha_inicio').val(data.fecha_inicio);
                        $('#cfecha_fin').val(data.fecha_fin);
                        $('#capreciacion').val(data.apreciacion);
                        $('#cestado').val(data.estado).change();

                        $.ajax({
                            type: 'POST',
                            url: '{!! route('curso.get_data_curso') !!}',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "_method": 'POST',
                                "input": data.curso_id
                            },
                            dataType: 'JSON',
                            success: function(response) {
                                console.log(response);
                                $('#idcurso').val(response.data[0].idcurso);
                                $('#ctitulo').val(response.data[0].titulo);
                                $('#ccreditos').val(response.data[0].creditos);
                                $('#choras').val(response.data[0].horas);
                                $('#carea').val(response.data[0].area).change();
                                $('#cidentidad').val(response.data[0].identidad).change();
                            }
                        });
                    }
                });
                $('#modal-capacitacion-agregar').modal("show");
        }

        $('#agregarCurso').click(function() {
            $('#form-curso')[0].reset();
            $('#modal-curso').modal('show');
            $('#type-send-curso').val('save');
            $('#myModalLabel-curso').text('Agregar Curso');
        });

        $('#editarCurso').click(function() {
            if ($('#idcurso').val() != '') {
                $('#myModalLabel-curso').text('Editar Curso');
                $('#type-send-curso').val('edit');
                $.ajax({
                    type: 'POST',
                    url: '{!! url('gape/gestion-egresado/curso/get-curso') !!}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "_method": 'POST',
                        id: $('#idcurso').val()
                    },
                    dataType: 'JSON',
                    success: function(response) {
                        let tipo_d = $('#cidentidad').val(response.data.entidad_id).change();
                        let titulo = $('#titulo').val(response.data.titulo);
                        let descripcion = $('#descripcion').val(response.data.descripcion);
                        let creditos = $('#creditos').val(response.data.creditos);
                        let horas = $('#horas').val(response.data.horas);
                        let area = $('#carea').val(response.data.idarea).change();
                    }
                });
                $('#form-curso')[0].reset();
                $('#modal-curso').modal('show');
            } else {
                $.notify({
                    icon: 'font-icon font-icon-check-circle',
                    title: '<strong>¡Alto!</strong>',
                    message: 'Seleccione un registro o agregue un nuevo dato de algun curso'
                }, {
                    placement: {
                        from: "top",
                    },
                    type: 'danger'
                });
            }
        });
        $('#form-curso').on('submit', function(e) {
            if(IsEmpty(document.getElementById('send-curso'),document.getElementById('titulo'),document.getElementById('descripcion'),document.getElementById('creditos'),document.getElementById('horas'))){
            let url = '';
            let method = '';
            let msg = '';
            if ($('#type-send-curso').val() == 'save') {
                url = '{!! url('gape/gestion-egresado/curso/store') !!}';
                method = 'POST';
                msg = 'Datos del Curso registrada correctamente';
            } else if ($('#type-send-curso').val() == 'edit') {
                url = '{!! url('gape/gestion-egresado/curso/update') !!}'
                method = 'PATCH';
                msg = 'Datos del Curso actualizada correctamente';
            }
            e.preventDefault();
            let tipo_d = $('#cidentidad').val();
            let titulo = $('#titulo').val();
            let descripcion = $('#descripcion').val();
            let creditos = $('#creditos').val();
            let horas = $('#horas').val();
            let area = $('#area').val();
            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "_method": method,
                    "id": $('#idcurso').val(),
                    "identidad": tipo_d,
                    "titulo": titulo,
                    "descripcion": descripcion,
                    "creditos": creditos,
                    "horas": horas,
                    "area": area
                },
                dataType: 'JSON',
                success: function(response) {
                    console.log(response);
                    $('#idcurso').val(response.success.id);
                    $('#ctitulo').val(response.success.titulo);
                    $('#ccreditos').val(response.success.creditos);
                    $('#choras').val(response.success.horas);
                    $('#carea').val(response.success.idarea);

                    $('#form-curso')[0].reset();

                    getDataCurso();

                    $('#modal-curso').modal('hide');

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
                    if (typeof error.responseJSON.errors.identidad != 'undefined') {
                        html += '<li>' + error.responseJSON.errors.identidad + '</li>'
                    };
                    if (typeof error.responseJSON.errors.titulo != 'undefined') {
                        html += '<li>' + error.responseJSON.errors.titulo + '</li>'
                    };
                    if (typeof error.responseJSON.errors.descripcion != 'undefined') {
                        html += '<li>' + error.responseJSON.errors.descripcion + '</li>'
                    };
                    if (typeof error.responseJSON.errors.creditos != 'undefined') {
                        html += '<li>' + error.responseJSON.errors.creditos + '</li>'
                    };
                    if (typeof error.responseJSON.errors.horas != 'undefined') {
                        html += '<li>' + error.responseJSON.errors.horas + '</li>'
                    };
                    if (typeof error.responseJSON.errors.area != 'undefined') {
                        html += '<li>' + error.responseJSON.errors.area + '</li>'
                    };

                    $('#showErrores2').html(html);
                    $("#alert-empresa").hide();
                    $("#alert-empresa").fadeTo(2000, 500).slideUp(500, function() {
                        $("#alert-empresa").slideUp(500);
                    });
                }
            });
        }
        });

        $('#agregar-capacitaciones').click(function() {
            //console.log($('#capacitacion_experiencia').val());
            $('#modal-capacitacion-agregar').modal("show");
            $('#updateCap').val(-1);
            $('#form-capacitacion')[0].reset();
            getDataCurso();
        });

        //apreciacion
        function Apreciacion(idalumno,idcurso){
            $('#modal-apreciacion').modal("show");
            $('#form-apreciacion')[0].reset();
            $.ajax({
                type: 'POST',
                url: '{!! route('alumno_ofertas.get-apreciacion') !!}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "_method": 'POST',
                    "idalumno": idalumno,
                    "idcurso": idcurso
                },
                dataType: 'JSON',
                success:function(data){
                    console.log(data.data[0].id);
                    $('#apreciacion').val(data.data[0].apreciacion);
                    $('#idAlumnoOferta').val(data.data[0].id);
                }
            });
        }

        $('#form-apreciacion').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: '{!! route('alumno_ofertas.update-apreciacion') !!}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "_method": 'PATCH',
                    "id": $('#idAlumnoOferta').val(),
                    "apreciacion": $('#apreciacion').val()
                },
                dataType: 'JSON',
                success: function(response) {
                    if(response.success){
                    $('#table').DataTable().ajax.reload();
                    $('#modal-apreciacion').modal('hide');
                    $('#form-apreciacion')[0].reset();

                    $.notify({
                        icon: 'font-icon font-icon-check-circle',
                        title: '<strong>¡Existoso!</strong>',
                        message: 'Apreciación registrada con éxito'
                    }, {
                        placement: {
                            from: "top",
                        },
                        type: 'success'
                    });
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });
    </script>
@endsection
