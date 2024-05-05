@extends('layouts.app')
@section('css')
@endsection
@section('content')
    <div class="container-fluid">
        <section class="card">
            <header class="card-header">
                <div class="pull-left">
                    <ol class="breadcrumb breadcrumb-simple">
                        <li><a href="#">Inicio</a></li>
                        <li class="active">Lista de Egresados</li>
                    </ol>
                </div>
                <div class="pull-right">
                    @can('alumnos-crear')
                        <a href="{{ route('egresado.create') }}"
                           class="btn btn-inline btn-success btn-rounded btn-sm"><i
                                class="fa fa-plus-circle"></i>
                            Nuevo
                        </a>
                    @endcan
                </div>
            </header>
            <div class="card-block">
                <input type="hidden" id="reporte-nombre">

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
                        <th>Código</th>
                        <th>Apellidos y Nombres</th>
                        <th>DNI</th>
                        <th>Condicion</th>
                        <th>Resolución Egresado</th>
                        <th>¿Activo?</th>
                        <th width="100px">Acciones</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </section>
    </div>
    <div class="modal fade" id="modal-capacitacion" tabindex="-1" role="dialog" aria-labelledby="modalCapacitaciones"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content ">
                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                        <i class="font-icon-close-2"></i>
                    </button>
                    <h4 class="modal-title">Capacitaciones</h4>
                </div>
                <div class="modal-body">
                    <section class="tabs-section">
                        <div class="tabs-section-nav tabs-section-nav-icons">
                            <div class="tbl">
                                <ul class="nav" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link" href="#capacitacion" role="tab" data-toggle="tab"><span
                                                class="nav-link-in"><i
                                                    class="fa fa-graduation-cap"></i>Capacitaciones</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#experiencia_laboral" role="tab"
                                           data-toggle="tab"><span class="nav-link-in"><span
                                                    class="fa fa-file-text-o"></span>Experiencia Laboral</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!--.tabs-section-nav-->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane fade" id="capacitacion">
                                <table id="table-cap" class="display table table-striped table-bordered" cellspacing="0"
                                       width="100%">
                                    <thead>
                                    <tr>
                                        <th>*</th>
                                        <th>Descripción</th>
                                        <th>Curso</th>
                                        <th>Estado</th>
                                        <th>¿Visto Bueno?</th>
                                        <th>Certificado</th>
                                        <th>Acciones</th>
                                    </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                            <!--.tab-pane-->
                            <div role="tabpanel" class="tab-pane fade" id="experiencia_laboral">
                                <table id="table-exp" class="display table table-striped table-bordered" cellspacing="0"
                                       width="100%">
                                    <thead>
                                    <tr>
                                        <th>*</th>
                                        <th>Entidad</th>
                                        <th>Cargo</th>
                                        <th>Fecha Inicio</th>
                                        <th>Fecha Salida</th>
                                        <th>Reconocimientos</th>
                                        <th>Satisfacción</th>
                                        <th>¿Visto Bueno?</th>
                                        <th>Archivo</th>
                                        <th>Acciones</th>
                                    </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                            <!--.tab-pane-->
                        </div>
                        <!--.tab-content-->
                    </section>
                    <!--.tabs-section-->
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade bd-example-modal-lg" id="modal-capacitacion-old" tabindex="-1" role="dialog"
         aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content ">
                <div class="modal-header">
                    <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                        <i class="font-icon-close-2"></i>
                    </button>
                    <br>
                    <br>
                    <div class="tab">
                        <button class="tablinks" id="linkcapa" onclick="openTab(event, 'cap-tab')">Capacitaciones
                        </button>
                        <button class="tablinks" id="linkexpe" onclick="openTab(event, 'exp-tab')">Experiencia
                            Laboral
                        </button>
                    </div>
                    <div class="pull-right">
                    </div>
                </div>
                <div class="modal-body">
                    <div id="cap-tab" class="tabcontent">
                        <h4 class="modal-title" id="myModalLabel"></h4>
                    </div>

                    <div id="exp-tab" class="tabcontent">
                        <h4 class="modal-title" id="myModalLabel"></h4>
                    </div>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-profile" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
         aria-hidden="true" style="overflow-y: scroll;">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                        <i class="font-icon-close-2"></i>
                    </button>
                    Perfil del Estudiante
                </div>
                <div class="modal-body">
                    <section class="box-typical">
                        <div class="profile-card">
                            <div class="profile-card-photo">
                                <img src="{{ asset('img/profile.png') }}" alt=""/>
                            </div>
                            <div class="profile-card-name" id='pname'></div>
                            <div class="profile-card-status" id='papellido'></div>
                            <div class="profile-card-location" id='pdireccion'></div>
                        </div>
                        <!--.profile-card-->

                        <div class="profile-statistic tbl">
                            <div class="tbl-row">
                                <div class="tbl-cell">
                                    # Capacitaciones
                                    <b id="num-cap"></b>
                                </div>
                                <div class="tbl-cell">
                                    # Experiencia Laboral
                                    <b id="num-exp"></b>
                                </div>
                            </div>
                        </div>

                        <ul class="profile-links-list">
                            <li class="nowrap">
                                <i class="font-icon font-icon-earth-bordered"></i>
                                <span>Correo: </span>
                                <a href="#" id="pcorreo"></a>
                            </li>
                            <li class="nowrap">
                                <i class="font-icon font-icon-fb-fill"></i>
                                <span>Telefono: </span>
                                <a href="#" id="ptelefono"></a>
                            </li>
                            <li class="nowrap">
                                <i class="font-icon font-icon-vk-fill"></i>
                                <span>Usuario: </span>
                                <a href="#" id="pusername"></a>
                            </li>
                        </ul>
                    </section>
                </div>
                <div class="modal-footer">
                </div>

            </div>
        </div>
    </div>

@endsection
@section('js')
    <script type="text/javascript">
        $(document).ready(function () {
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
                    "url": "{{ route('egresado.get_egresado') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": {
                        _token: "{{ csrf_token() }}"
                    }
                },
                "columns": [
                    {"data": "codigo"},
                    {"data": "nombres"},
                    {"data": "num_documento"},
                    {"data": "condicion"},
                    {"data": "resolucion"},
                    {"data": "activo"},
                    {"data": "options"},
                ],
                "columnDefs": [
                    {"className": "text-center", "targets": [0, 2, 3, 4, 5, 6]},
                    {"bSortable": false, "aTargets": [6]},
                ],
            });
            var id;
            var nombre;
            openTab();
            $('#table tbody').on('click', '.delete-confirm', function () {
                let idalumno = $(this).attr('data-id');
                let url = '{!! route('egresado.destroy', 'idalumno') !!}';
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
                    function (isConfirm) {
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
                                    "id": idalumno,
                                },
                                dataType: 'JSON',
                                beforeSend: function () {
                                },
                                success: function (response) {
                                    if (response.success) {
                                        $.notify({
                                            icon: 'font-icon font-icon-check-circle',
                                            title: '<strong>¡Existoso!</strong>',
                                            message: 'Alumno eliminada correctamente'
                                        }, {
                                            placement: {
                                                from: "top",
                                            },
                                            type: 'success'
                                        });
                                        tabla.ajax.reload();
                                    } else {
                                        $.notify({
                                            icon: 'font-icon font-icon-warning',
                                            title: '<strong>¡Error!</strong>',
                                            message: 'Hubo un error al eliminar la Alumno'
                                        }, {
                                            placement: {
                                                from: "top",
                                            },
                                            type: 'danger'
                                        });
                                    }
                                    swal.close()
                                },
                                error: function (err) {
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

            $('#table tbody').off('click').on('click', '.capacitacion', function () {
                id = $(this).attr('data-id');
                nombre = $(this).attr('data-nombre');
                $('#reporte-nombre').val(nombre);
                $('[href="#capacitacion"]').tab('show');
            });

            function openTab() {
                $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                    var target = $(e.target).attr("href") // activated tab
                    if (target === '#capacitacion') {
                        let tabla = $('#table-cap').DataTable();
                        tabla.destroy();
                        tabla = $('#table-cap').DataTable({
                            dom: 'Bfrtip',
                            buttons: [{
                                extend: 'excel',
                                text: 'A Excel',
                                title: $('#reporte-nombre').val() + '_capacitaciones',
                                exportOptions: {
                                    columns: [1, 2, 3, 4, 5]
                                }
                            }],
                            responsive: true,
                            "processing": true,
                            "serverSide": true,
                            "autoWidth": true,
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
                                    "id": id
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
                                    "data": "vistobueno"
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
                                "targets": [0, 1]
                            },
                                {
                                    "bSortable": true,
                                    "aTargets": [5, 6]
                                },
                            ],
                        });
                    }

                    if (target === '#experiencia_laboral') {
                        let tabla2 = $('#table-exp').DataTable();
                        tabla2.destroy();
                        tabla2 = $('#table-exp').DataTable({
                            dom: 'Bfrtip',
                            buttons: [{
                                extend: 'excel',
                                text: 'A Excel',
                                title: $('#reporte-nombre').val() + '_experiencia_laboral',
                                exportOptions: {
                                    columns: [1, 2, 3, 4, 5, 6, 7, 8]
                                }
                            }],
                            responsive: true,
                            "processing": true,
                            "serverSide": true,
                            "autoWidth": true,
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
                                    "id": id
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
                                    "data": "vb"
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
                                "targets": [0, 7]
                            },
                                {
                                    "bSortable": true,
                                    "aTargets": [5, 6]
                                },
                            ],
                        });
                    }
                });
            }
        });

        function validar(id, type) {
            if (type == '1') {
                $.ajax({
                    url: "{{ route('egresado.validar-experiencia') }}",
                    dataType: "JSON",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        method: "POST",
                        "id": id
                    },
                    success: function () {
                        $('#table-exp').DataTable().ajax.reload();
                    }
                });
            }
            if (type == '0') {
                console.log("validado")
                $.ajax({
                    url: "{{ route('egresado.validar-capacitacion') }}",
                    dataType: "JSON",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        method: "POST",
                        "id": id
                    },
                    success: function () {
                        $('#table-cap').DataTable().ajax.reload();
                    }
                });
            }
        }

        function invalidar(id, type) {
            swal({
                    title: '¿Invalidar?',
                    text: "¡No podrás revertir esto!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: '!Si, invalidar!',
                    cancelButtonText: 'Cancelar',
                    closeOnConfirm: true,
                    closeOnCancel: false
                },
                function (isConfirm) {
                    if (isConfirm) {
                        if (type == '1') {
                            $.ajax({
                                url: "{{ route('egresado.invalidar-experiencia') }}",
                                dataType: "JSON",
                                type: "DELETE",
                                data: {
                                    _token: "{{ csrf_token() }}",
                                    method: "DELETE",
                                    "id": id
                                },
                                success: function () {
                                    $('#table-exp').DataTable().ajax.reload();
                                }
                            });
                        }
                        if (type == '0') {
                            $.ajax({
                                url: "{{ route('egresado.invalidar-capacitacion') }}",
                                dataType: "JSON",
                                type: "DELETE",
                                data: {
                                    _token: "{{ csrf_token() }}",
                                    method: "DELETE",
                                    "id": id
                                },
                                success: function () {
                                    $('#table-cap').DataTable().ajax.reload();
                                }
                            });
                        }
                    } else {
                        swal({
                            title: "Cancelado",
                            text: "El registro está a salvo",
                            type: "error",
                            confirmButtonClass: "btn-danger"
                        });
                    }
                });
        }
    </script>
@endsection
