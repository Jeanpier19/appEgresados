@extends('layouts.app')
@section('css')
    <link href="{{ asset('web/css/typeahead.min.css') }}" rel="stylesheet">
    <link href="{{ asset('web/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('web/css/main.css') }}" rel="stylesheet">
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
@endsection
@section('content')
    <div class="container-fluid">
        <section class="card">
            <header class="card-header">
                <div class="pull-left">
                    <ol class="breadcrumb breadcrumb-simple">
                        <li><a href="#">Inicio</a></li>
                        <li class="active">Reportes de ofertas de capacitación</li>
                    </ol>
                </div>
                <div class="pull-center">

                </div>
                <div class="pull-right">
                    {{-- @can('usuarios-crear') --}}
                    {{-- @endcan --}}
                    <div class="tab">
                        <button class="tablinks" id="repo1" data-id="repor-1"
                            onclick="openTab(event, 'repor-1')">Demanda de
                            Capacitaciones</button>
                        <button class="tablinks" id="repo2" data-id="repor-2"
                            onclick="openTab(event, 'repor-2')">Apreciaciones de
                            alumnos</button>
                        <button class="tablinks" id="repo3" data-id="repor-3"
                            onclick="openTab(event, 'repor-3')">Ofertas por
                            semestre</button>
                        <button class="tablinks" id="repo4" data-id="repor-4"
                            onclick="openTab(event, 'repor-4')">Recomendaciones por
                            entidades</button>
                    </div>
                </div>
            </header>
            <div class="card-block">
                <div id="repor-1" class="tabcontent">
                    <br />
                    <br />
                    <hr>
                    <table id="table1" class="display table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Entidades</th>
                                <th>Cursos de Capacitacion</th>
                                <th>Cantidad de alumnos inscritos</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div id="repor-2" class="tabcontent">
                    <br />
                    <br />
                    <hr>
                    <table id="table2" class="display table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Entidades</th>
                                <th>Cursos de Capacitacion</th>
                                <th>Alumno</th>
                                <th>Pregunta 1</th>
                                <th>Pregunta 2</th>
                                <th>Pregunta 3</th>
                                <th>Pregunta 4</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div id="repor-3" class="tabcontent">
                    <div class="form-group">
                        <div class="col-md-3">
                            <strong>Año académico:</strong>
                            {!! Form::select('anio', $anios, null, ['class' => 'custom-select select2', 'placeholder' => 'Seleccionar', 'id' => 'anio']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-3">
                            <strong>Semestre:</strong>
                            <select class="select2" id="semestre">
                                <option value="">Seleccionar</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-3">
                            <br>
                            <button type="button" id='filtrar-semestre' class="btn btn-inline btn-success btn-sm">
                                Filtrar
                            </button>
                        </div>
                    </div>
                    <br />
                    <br />
                    <hr>
                    <table id="table3" class="display table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Entidades</th>
                                <th>Cursos de Capacitacion</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div id="repor-4" class="tabcontent">
                    <div class="form-group">
                        <div class="col-md-3">
                            <strong>Entidades:</strong>
                            {!! Form::select('entidad', $entidades, null, ['class' => 'select2', 'placeholder' => 'Seleccionar', 'id' => 'entidad']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-3">
                            <br>
                            <button type="button" id='filtrar-entidad' class="btn btn-inline btn-success btn-sm">
                                Filtrar
                            </button>
                        </div>
                    </div>
                    <br />
                    <br />
                    <hr>
                    <table id="table4" class="display table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Entidades</th>
                                <th>Cursos de Capacitacion</th>
                                <th>Recomendaciones</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>

            </div>
        </section>
    </div>
@endsection
@section('js')
    <script src="{{ asset('web/js/jquery.typeahead.min.js') }}"></script>
    <script src="{{ asset('web/js/select2.full.min.js') }}"></script>
    <script type="text/javascript">
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

        $(document).ready(function() {
            openTab(event, 'repor-1');
            $('#repo1').last().addClass("active");
            $('#table1').DataTable().destroy();
            let tabla = $('#table1').DataTable({
                dom: 'Bfrtip',
                buttons: [{
                    extend: 'excel',
                    text: 'A Excel',
                    title: 'Reporte' + $('#anio').find(":selected").text() + $('#semestre').find(
                        ":selected").text(),
                        exportOptions : {
                modifier : {
                    // DataTables core
                    order : 'index',  // 'current', 'applied', 'index',  'original'
                    page : 'all',      // 'all',     'current'
                    search : 'none'     // 'none',    'applied', 'removed'
                }
            }
                }],
                filter: false,
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
                    //"url": "{{ route('reportes.reporteegresadosemestre') }}",
                    "url": "{{ route('reportes.reporte3') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": {
                        _token: "{{ csrf_token() }}"
                    }
                },
                "columns": [{
                        "data": "id"
                    },
                    {
                        "data": "entidad"
                    },
                    {
                        "data": "ofertas"
                    },
                    {
                        "data": "numero_alumnos"
                    }
                ],
                "columnDefs": [{
                        "className": "text-center",
                        "targets": [0, 2]
                    },
                    {
                        "bSortable": false,
                        "aTargets": [1, 2]
                    },
                ],
            });
            $('#table1').DataTable().ajax.reload();
        });

        $('#anio').on('change', function() {
            $.ajax({
                "url": "{{ route('reportes.get-semestre') }}",
                "dataType": "JSON",
                "type": "POST",
                "data": {
                    _token: "{{ csrf_token() }}",
                    "_method": 'POST',
                    id: $(this).val()
                },
                success: function(data) {
                    console.log(data);
                    console.log($('#semestre'));
                    $('#semestre').html('');
                    $('#semestre').append($('<option></option>').val('').html('Seleccionar'));
                    $.each(data, function(id, option) {
                        $('#semestre').append($('<option></option>').val(id).html(option));
                    });
                }
            });
        });

        $('.tablinks').on('click', function() {
            let tipo = $(this).attr('data-id');

            if (tipo == 'repor-1') {
                $('#table1').DataTable().destroy();
                let tabla = $('#table1').DataTable({
                    dom: 'Bfrtip',
                    buttons: [{
                        extend: 'excel',
                        text: 'A Excel',
                        title: 'Reporte' + $('#anio').find(":selected").text() + $('#semestre')
                            .find(
                                ":selected").text(),
                                exportOptions : {
                modifier : {
                    // DataTables core
                    order : 'index',  // 'current', 'applied', 'index',  'original'
                    page : 'all',      // 'all',     'current'
                    search : 'none'     // 'none',    'applied', 'removed'
                }
            }
                    }],
                    filter: false,
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
                        //"url": "{{ route('reportes.reporteegresadosemestre') }}",
                        "url": "{{ route('reportes.reporte3') }}",
                        "dataType": "json",
                        "type": "POST",
                        "data": {
                            _token: "{{ csrf_token() }}"
                        }
                    },
                    "columns": [{
                            "data": "id"
                        },
                        {
                            "data": "entidad"
                        },
                        {
                            "data": "ofertas"
                        },
                        {
                            "data": "numero_alumnos"
                        }
                    ],
                    "columnDefs": [{
                            "className": "text-center",
                            "targets": [0, 2]
                        },
                        {
                            "bSortable": false,
                            "aTargets": [1, 2]
                        },
                    ],
                });
                $('#table1').DataTable().ajax.reload();
            }
            if (tipo == 'repor-2') {
                $('#table2').DataTable().destroy();
                let tabla = $('#table2').DataTable({
                    dom: 'Bfrtip',
                    buttons: [{
                        extend: 'excel',
                        text: 'A Excel',
                        title: 'Reporte' + $('#anio').find(":selected").text() + $('#semestre')
                            .find(
                                ":selected").text(),
                                exportOptions : {
                modifier : {
                    // DataTables core
                    order : 'index',  // 'current', 'applied', 'index',  'original'
                    page : 'all',      // 'all',     'current'
                    search : 'none'     // 'none',    'applied', 'removed'
                }
            }
                    }],
                    filter: false,
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
                        //"url": "{{ route('reportes.reporteegresadosemestre') }}",
                        "url": "{{ route('reportes.reporte4') }}",
                        "dataType": "json",
                        "type": "POST",
                        "data": {
                            _token: "{{ csrf_token() }}"
                        }
                    },
                    "columns": [{
                            "data": "id"
                        },
                        {
                            "data": "entidad"
                        },
                        {
                            "data": "ofertas"
                        },
                        {
                            "data": "alumno"
                        },
                        {
                            "data": "pregunta1"
                        },
                        {
                            "data": "pregunta2"
                        },
                        {
                            "data": "pregunta3"
                        },
                        {
                            "data": "pregunta4"
                        }
                    ],
                    "columnDefs": [{
                            "className": "text-center",
                            "targets": [0, 2]
                        },
                        {
                            "bSortable": false,
                            "aTargets": [1, 2]
                        },
                    ],
                });
                $('#table2').DataTable().ajax.reload();
            }
        });

        $('#filtrar-semestre').click(function() {
            $('#table3').DataTable().destroy();
            let tabla = $('#table3').DataTable({
                dom: 'Bfrtip',
                buttons: [{
                    extend: 'excel',
                    text: 'A Excel',
                    title: 'Reporte anio-' + $('#anio').find(":selected").val() + '-semestre-' + $(
                        '#semestre').find(":selected").val(),
                        exportOptions : {
                modifier : {
                    // DataTables core
                    order : 'index',  // 'current', 'applied', 'index',  'original'
                    page : 'all',      // 'all',     'current'
                    search : 'none'     // 'none',    'applied', 'removed'
                }
            }
                }],
                filter: false,
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
                    "url": "{{ route('reportes.reporte5') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": {
                        _token: "{{ csrf_token() }}",
                        anio: $('#anio').find(":selected").val(),
                        semestre: $('#semestre').find(":selected").val()
                    }
                },
                "columns": [{
                        "data": "id"
                    },
                    {
                        "data": "entidad"
                    },
                    {
                        "data": "ofertas"
                    }
                ],
                "columnDefs": [{
                        "className": "text-center",
                        "targets": [0, 2]
                    },
                    {
                        "bSortable": false,
                        "aTargets": [1, 2]
                    },
                ],
            });
            $('#table3').DataTable().ajax.reload();
        });

        $('#filtrar-entidad').click(function() {
            $('#table4').DataTable().destroy();
            let tabla = $('#table4').DataTable({
                dom: 'Bfrtip',
                buttons: [{
                    extend: 'excel',
                    text: 'A Excel',
                    title: 'Reporte' + $('#doctorado').find(":selected").text() + $('#maestria')
                        .find(":selected").text() + $('#mencion').find(":selected").val(),
                        exportOptions : {
                modifier : {
                    // DataTables core
                    order : 'index',  // 'current', 'applied', 'index',  'original'
                    page : 'all',      // 'all',     'current'
                    search : 'none'     // 'none',    'applied', 'removed'
                }
            }
                }],
                filter: false,
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
                    "url": "{{ route('reportes.reporte6') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": {
                        _token: "{{ csrf_token() }}",
                        entidad: $('#entidad').find(":selected").val()
                    }
                },
                "columns": [{
                        "data": "id"
                    },
                    {
                        "data": "entidad"
                    },
                    {
                        "data": "ofertas"
                    },
                    {
                        "data": "recomendaciones"
                    },
                ],
                "columnDefs": [{
                        "className": "text-center",
                        "targets": [0, 2]
                    },
                    {
                        "bSortable": false,
                        "aTargets": [1, 2]
                    },
                ],
            });
            $('#table4').DataTable().ajax.reload();
        });
    </script>
@endsection
