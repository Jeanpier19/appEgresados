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

        /* Style the buttons inside the tab */
        .buttons-excel {
            background-color: #46c35f !important;
        }

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
                        <li class="active">Reportes de Graudados</li>
                    </ol>
                </div>
                <div class="pull-center">

                </div>
                <div class="pull-right">
                    {{-- @can('usuarios-crear') --}}
                    {{-- @endcan --}}
                    <div class="tab">
                        <button class="tablinks" id="repo1" onclick="openTab(event, 'repor-1')">Por semestre y año
                            académico</button>
                        <button class="tablinks" id="repo2" onclick="openTab(event, 'repor-2')">Por facultades y
                            escuela</button>
                        <button class="tablinks" id="repo3" onclick="openTab(event, 'repor-3')">Por grados
                            académicos</button>
                    </div>
                </div>
            </header>
            <div class="card-block">
                <div id="repor-1" class="tabcontent">
                    <div class="form-group">
                        <div class="col-md-3">
                            <strong>Año académico:</strong>
                            {!! Form::select('anio', $anios, null, ['class' => 'select2', 'id' => 'anio']) !!}
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
                            <button type="button" id='filtrar-1' class="btn btn-inline btn-success btn-sm">
                                Filtrar
                            </button>
                        </div>
                    </div>
                    <br />
                    <br />
                </div>
                <div id="repor-2" class="tabcontent">
                    <div class="form-group">
                        <div class="col-md-3">
                            <strong>Facultades:</strong>
                            {!! Form::select('facultades', $facultades, null, ['class' => 'select2', 'id' => 'facultad']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-3">
                            <strong>Escuela:</strong>
                            <select class="select2" id="escuela">
                                <option value="">Seleccionar</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-3">
                            <br>
                            <button type="button" id='filtrar-2' class="btn btn-inline btn-success btn-sm">
                                Filtrar
                            </button>
                    </div>
                </div>
                <br />
                <br />
            </div>
            <div id="repor-3" class="tabcontent">
                <div class="form-group">
                    <div class="col-md-3">
                        <strong>Doctorados:</strong>
                        {!! Form::select('doctorado', $doctorado, null, ['class' => 'select2', 'id' => 'doctorado']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-3">
                        <strong>Maestrias:</strong>
                        {!! Form::select('maestria', $maestria, null, ['class' => 'select2', 'id' => 'maestria']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-3">
                        <strong>Menciones:</strong>
                        {!! Form::select('mencion', $mencion, null, ['class' => 'select2', 'id' => 'mencion']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-3">
                        <br>
                        <button type="button" id='filtrar-3' class="btn btn-inline btn-success btn-sm">
                            Filtrar
                        </button>
                    </div>
                </div>
                <br />
                <br />
            </div>
            <hr>
            <table id="table" class="display table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Facultad</th>
                        <th>Escuela</th>
                        <th>Apellido Paterno</th>
                        <th>Apellido Materno</th>
                        <th>Nombres</th>
                        <th>Sexo</th>
                        <th>Condicion</th>
                        <th>Semestre Ingreso</th>
                        <th>Semestre Egreso</th>
                        <th>Maestria</th>
                        <th>Mención</th>
                        <th>Doctorado</th>
                        <th>Resolucion</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
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
        });

        $('#facultad').on('change', function() {
            $.ajax({
                "url": "{{ route('reportes.get-escuela') }}",
                "dataType": "JSON",
                "type": "POST",
                "data": {
                    _token: "{{ csrf_token() }}",
                    "_method": 'POST',
                    id: $(this).val()
                },
                success: function(data) {
                    console.log(data);
                    console.log($('#escuela'));
                    $('#escuela').html('');
                    $('#escuela').append($('<option></option>').val('').html('Seleccionar'));
                    $.each(data, function(id, option) {
                        //console.log(id+"    "+option)
                        $('#escuela').append($('<option></option>').val(id).html(option));
                    });
                }
            });
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
                        //console.log(id+"    "+option)
                        $('#semestre').append($('<option></option>').val(id).html(option));
                    });
                }
            });
        });
//
        var data = {
            id: '',
            text: 'Seleccionar'
        };
        var newOption = new Option(data.text, data.id, false, false);
        $('#doctorado').append(newOption).trigger('change');
        $('#doctorado').val('');
        $('#doctorado').trigger('change');

        $('#maestria').append(newOption).trigger('change');
        $('#maestria').val('');
        $('#maestria').trigger('change');

        $('#mencion').append(newOption).trigger('change');
        $('#mencion').val('');
        $('#mencion').trigger('change');
//

$('#filtrar-1').click(function(){
    $('#table').DataTable().destroy();
    let tabla = $('#table').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {
            extend: 'excel',
            text: 'A Excel',
            title: 'Reporte'+$('#anio').find(":selected").text()+$('#semestre').find(":selected").text(),
            exportOptions : {
                modifier : {
                    // DataTables core
                    order : 'index',  // 'current', 'applied', 'index',  'original'
                    page : 'all',      // 'all',     'current'
                    search : 'none'     // 'none',    'applied', 'removed'
                }
            }
                    }
                ],
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
                    "url": "{{ route('reportes.reporteegresadosemestre') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": {
                        _token: "{{ csrf_token() }}",
                        tipo_alumno: "GRADUADO",
                        anio: $('#anio').find(":selected").val(),
                        semestre: $('#semestre').find(":selected").val(),
                    }
                },
                "columns": [{
                        "data": "id"
                    },
                    {
                        "data": "facultad"
                    },
                    {
                        "data": "escuela"
                    },
                    {
                        "data": "paterno"
                    },
                    {
                        "data": "materno"
                    },
                    {
                        "data": "nombres"
                    },
                    {
                        "data": "sexo"
                    },
                    {
                        "data": "condicion"
                    },
                    {
                        "data": "semestre_ingreso"
                    },
                    {
                        "data": "semestre_egreso"
                    },
                    {
                        "data": "maestria"
                    },
                    {
                        "data": "mencion"
                    },
                    {
                        "data": "doctorado"
                    },
                    {
                        "data": "resolucion"
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
            $('#table').DataTable().ajax.reload();
});
$('#filtrar-2').click(function(){
    $('#table').DataTable().destroy();
    let tabla = $('#table').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {
            extend: 'excel',
            text: 'A Excel',
            title: 'Reporte'+$('#facultad').find(":selected").text()+$('#escuela').find(":selected").text()
                    }
                ],
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
                    "url": "{{ route('reportes.reporteegresadofacultad') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": {
                        _token: "{{ csrf_token() }}",
                        tipo_alumno: "GRADUADO",
                        facultad: $('#facultad').find(":selected").val(),
                        escuela: $('#escuela').find(":selected").val(),
                    }
                },
                "columns": [{
                        "data": "id"
                    },
                    {
                        "data": "facultad"
                    },
                    {
                        "data": "escuela"
                    },
                    {
                        "data": "paterno"
                    },
                    {
                        "data": "materno"
                    },
                    {
                        "data": "nombres"
                    },
                    {
                        "data": "sexo"
                    },
                    {
                        "data": "condicion"
                    },
                    {
                        "data": "semestre_ingreso"
                    },
                    {
                        "data": "semestre_egreso"
                    },
                    {
                        "data": "maestria"
                    },
                    {
                        "data": "mencion"
                    },
                    {
                        "data": "doctorado"
                    },
                    {
                        "data": "resolucion"
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
            $('#table').DataTable().ajax.reload();
});

$('#filtrar-3').click(function(){
    $('#table').DataTable().destroy();
    let tabla = $('#table').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {
            extend: 'excel',
            text: 'A Excel',
            title: 'Reporte'+$('#doctorado').find(":selected").text()+$('#maestria').find(":selected").text()+$('#mencion').find(":selected").val()
                    }
                ],
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
                    "url": "{{ route('reportes.reporteegresadodoctorado') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": {
                        _token: "{{ csrf_token() }}",
                        tipo_alumno: "GRADUADO",
                        doctorado: $('#doctorado').find(":selected").val(),
                        maestria: $('#maestria').find(":selected").val(),
                        mencion: $('#mencion').find(":selected").val()
                    }
                },
                "columns": [{
                        "data": "id"
                    },
                    {
                        "data": "facultad"
                    },
                    {
                        "data": "escuela"
                    },
                    {
                        "data": "paterno"
                    },
                    {
                        "data": "materno"
                    },
                    {
                        "data": "nombres"
                    },
                    {
                        "data": "sexo"
                    },
                    {
                        "data": "condicion"
                    },
                    {
                        "data": "semestre_ingreso"
                    },
                    {
                        "data": "semestre_egreso"
                    },
                    {
                        "data": "maestria"
                    },
                    {
                        "data": "mencion"
                    },
                    {
                        "data": "doctorado"
                    },
                    {
                        "data": "resolucion"
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
            $('#table').DataTable().ajax.reload();
});
    </script>
@endsection
