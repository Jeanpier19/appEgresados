@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <section class="card">
            <header class="card-header">
                <div class="pull-left">
                    <ol class="breadcrumb breadcrumb-simple">
                        <li><a href="{{route('home')}}">Inicio</a></li>
                        <li class="active">Comunicados</li>
                    </ol>
                </div>
                <div class="pull-right">
                    {{--@can('convenios-crear')--}}
                        <a href="{{route('comunicados.create')}}" class="btn btn-inline btn-success btn-rounded btn-sm"><i
                                class="fa fa-plus-circle"></i>
                            Nuevo
                        </a>
                    {{--@endcan--}}
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
                        <th>Titulo</th>
                        <th>Descripción</th>
                        <th>Fecha Fin</th>
                        <th>Estado</th>
                        <th>Opciones</th>
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
            //filtros();
            //reporte();
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
                        "url": "{{ route('comunicados.all') }}",
                        "dataType": "json",
                        "type": "POST",
                        "data": function (d) {
                            /*d.estado = $('#estado').val();
                            d.tipo_convenio = $('#tipo_convenio').val();
                            d.vigencia = $('#vigencia').val();*/
                            d._token = "{{csrf_token()}}";
                        },
                    },
                    "columns": [
                        {"data": "id"},
                        {"data": "titulo"},
                        {"data": "descripcion"},
                        {"data": "fecha_fin"},
                        {"data": "estado"},
                        {"data": "options"}
                    ],
                    "columnDefs": [
                        {"className": "text-center", "targets": [0, 3, 4, 5]},
                        {"bSortable": false, "aTargets": [5]},
                    ],
                }
            );
            $('#table tbody').on('click', '.delete-confirm', function () {
                let id = $(this).attr('data-id');
                let url = '{!! url('admin/comunicados') !!}/' + id;
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
                                    "id": id,
                                },
                                dataType: 'JSON',
                                beforeSend: function () {
                                },
                                success: function (response) {
                                    if (response.success) {
                                        $.notify({
                                            icon: 'font-icon font-icon-check-circle',
                                            title: '<strong>¡Existoso!</strong>',
                                            message: 'Comunicado eliminado correctamente'
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
                                            message: 'Hubo un error al eliminar el comunicado.'
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

            function filtros() {
                $('#tipo_convenio, #estado, #vigencia').on('change', function () {
                    tabla.ajax.reload();
                });
            }

            function reporte() {
                $('#excel').on('click', function () {
                    $('#reporte').attr('action', '{{route('convenios.excel')}}');
                    $('#reporte').submit();
                });
                $('#pdf').on('click', function () {
                    $('#reporte').attr('action', '{{route('convenios.pdf')}}');
                    $('#reporte').submit();
                });
            }
        });
    </script>
@endsection
