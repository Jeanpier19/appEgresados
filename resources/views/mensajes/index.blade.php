@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <section class="card">
            <header class="card-header">
                <div class="pull-left">
                    <ol class="breadcrumb breadcrumb-simple">
                        <li><a href="{{route('home')}}">Inicio</a></li>
                        <li class="active">Mensajes</li>
                    </ol>
                </div>
                <div class="pull-right">
                </div>
            </header>
            <div class="card-block">
                @if ($message = Session::get('info'))
                    <div class="alert alert-info alert-no-border alert-close alert-dismissible fade in">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <p>{{ $message }}</p>
                    </div>
                @endif
                @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-no-border alert-close alert-dismissible fade in">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <p>{{ $message }}</p>
                    </div>
                @endif
                @if ($message = Session::get('warning'))
                    <div class="alert alert-warning alert-no-border alert-close alert-dismissible fade in">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <p>{{ $message }}</p>
                    </div>
                @endif
                <table id="table" class="display table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>N°</th>
                        <th>Fecha</th>
                        <th>Nombres</th>
                        <th>Correo electrónico</th>
                        <th>Celular</th>
                        <th>Mensaje</th>
                        <th>Ver</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </section>
    </div><!--.container-fluid-->
@endsection
@section('js')
    <script type="text/javascript">
        $(document).ready(function () {
            let tabla = $('#table').DataTable(
                {
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
                        "url": "{{ route('mensajes.all') }}",
                        "dataType": "json",
                        "type": "POST",
                        "data": function (d) {
                            d._token = "{{csrf_token()}}";
                        },
                    },
                    "columns": [
                        {"data": "id"},
                        {"data": "fecha"},
                        {"data": "nombre"},
                        {"data": "correo"},
                        {"data": "telefono"},
                        {"data": "mensaje"},
                        {"data": "options"}
                    ],
                    "columnDefs": [
                        {"className": "text-center", "targets": [0, 1, 3, 4, 6]},
                        {"bSortable": false, "aTargets": [6]},
                    ],
                    "order": [[ 1, "desc" ]]
                }
            );
        });
    </script>
@endsection
