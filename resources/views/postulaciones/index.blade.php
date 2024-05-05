@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <section class="card">
            <header class="card-header">
                <div class="pull-left">
                    <ol class="breadcrumb breadcrumb-simple">
                        <li><a href="#">Inicio</a></li>
                        <li class="active">Postulaciones</li>
                    </ol>
                </div>
            </header>
            <div class="card-block">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-no-border alert-close alert-dismissible fade in cerrar">
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
                        <th>Oferta Laboral</th>
                        @switch (Auth::user()->getRoleNames()[0])
                            @case('Administrador')
                            <th>Alumno</th>
                            @break
                        @endswitch
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </section>
    </div>
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
                        "url": "{{ route('postulaciones.all') }}",
                        "dataType": "json",
                        "type": "POST",
                        "data": {
                            _token: "{{csrf_token()}}"
                        }
                    },
                    "columns": [
                        {"data": "id"},
                        {"data": "oferta_laboral"},
                        @switch (Auth::user()->getRoleNames()[0])
                            @case('Administrador')
                                {"data": "alumno"},
                            @break
                        @endswitch
                        {"data": "fecha"},
                        {"data": "options"}],
                    "columnDefs": [
                            @switch (Auth::user()->getRoleNames()[0])
                            @case('Administrador')
                            {"className": "text-center", "targets": [0, 3, 4]},
                            {"bSortable": false, "aTargets": [4]},
                            @break
                            @case('Egresado')
                            {"className": "text-center", "targets": [0,2, 3]},
                            {"bSortable": false, "aTargets": [3]},
                            @break
                            @endswitch

                    ],
                }
            );
            $('#table tbody').on('click', '.asignar', function () {
                let id = $(this).attr('data-id');
                let nombre = $(this).attr('data-alumno');
                swal({
                        title: '¿El alumno '+nombre+' ocupó esta oferta laboral?',
                        text: "¡Se actualizará automáticamente en la experiencia laboral del alumno!",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: '!Si, registrar!',
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
                                "url": "{{ route('postulaciones.asignar') }}",
                                "dataType": "json",
                                "type": "POST",
                                "data": {
                                    _token: "{{csrf_token()}}",
                                    postulacion_id: id
                                },
                                beforeSend: function () {
                                },
                                success: function (response) {
                                    if (response.success) {
                                        $.notify({
                                            icon: 'font-icon font-icon-check-circle',
                                            title: '<strong>¡Existoso!</strong>',
                                            message: 'Registrado correctamente'
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
                                            message: 'Hubo un error al registrar.'
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
                            console.log(err);
                        }
                    });
            });
        });
    </script>
@endsection
