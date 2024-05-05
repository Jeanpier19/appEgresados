@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <section class="card">
            <header class="card-header">
                <div class="pull-left">
                    <ol class="breadcrumb breadcrumb-simple">
                        <li><a href="{{route('home')}}">Inicio</a></li>
                        <li class="active">Convenios</li>
                    </ol>
                </div>
                <div class="pull-right">
                    <a href="{{route('convenios.verificar')}}" class="btn btn-inline btn-info btn-rounded btn-sm"><i
                            class="fa fa-check"></i>
                        Verificar
                    </a>
                    @can('convenios-crear')
                        <a href="{{route('convenios.create')}}" class="btn btn-inline btn-success btn-rounded btn-sm"><i
                                class="fa fa-plus-circle"></i>
                            Nuevo
                        </a>
                    @endcan
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
                <div class="row">
                    <form id="reporte" method="GET" action="{{route('convenios.excel')}}" target="_blank">
                        <div class="col-xs-12 col-md-3">
                            <strong>Estado:</strong>
                            {{ Form::select('estado',['VIGENTE'=>'VIGENTE','NO VIGENTE'=>'NO VIGENTE','POR FINALIZAR'=>'POR FINALIZAR'], null, array('id' => 'estado','class' => 'selectpicker','title'=>'Seleccione...','data-max-options'=>'1','data-container'=>'body','data-width'=>'100%','multiple')) }}
                        </div>
                        <div class="col-xs-12 col-md-3">
                            <strong>Vigencia:</strong>
                            {{ Form::select('vigencia',['DEFINIDO'=>'DEFINIDO','INDEFINIDO'=>'INDEFINIDO'], null, array('id' => 'vigencia','class' => 'selectpicker','title'=>'Seleccione...','data-max-options'=>'1','data-container'=>'body','data-width'=>'100%','multiple')) }}
                        </div>
                        <div class="col-xs-12 col-md-3">
                            <strong>Tipo:</strong>
                            {{ Form::select('tipo_convenio',$tipo_convenio->pluck('descripcion','descripcion'), null, array('id' => 'tipo_convenio','class' => 'bootstrap-select','title'=>'Seleccione...','data-max-options'=>'1','data-container'=>'body','data-width'=>'100%','multiple')) }}
                        </div>
                        <div class="col-xs-12 col-sm-3 col-md-3">
                            <div class="form-group">
                                <strong>Reporte:</strong><br>
                                <button id="excel" type="button" class="btn btn-success btn-sm"><i
                                        class="fa fa-file-excel-o"></i> Excel
                                </button>
                                <button id="pdf" type="button" class="btn btn-danger btn-sm"><i
                                        class="fa fa-file-pdf-o"></i> PDF
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <table id="table" class="display table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>N°</th>
                        <th>Nombre</th>
                        <th>Resolución</th>
                        <th>Objetivo</th>
                        <th>Fecha de Inicio</th>
                        <th>Fecha de Vencimiento</th>
                        <th>Dias restantes</th>
                        <th>Estado</th>
                        <th>Tipo</th>
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
            filtros();
            reporte();
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
                        "url": "{{ route('convenios.all') }}",
                        "dataType": "json",
                        "type": "POST",
                        "data": function (d) {
                            d.estado = $('#estado').val();
                            d.tipo_convenio = $('#tipo_convenio').val();
                            d.vigencia = $('#vigencia').val();
                            d._token = "{{csrf_token()}}";
                        },
                    },
                    "columns": [
                        {"data": "id"},
                        {"data": "nombre"},
                        {"data": "resolucion"},
                        {"data": "objetivo"},
                        {"data": "fecha_inicio"},
                        {"data": "fecha_vencimiento"},
                        {"data": "dias_restantes"},
                        {"data": "estado"},
                        {"data": "tipo_convenio"},
                        {"data": "options"}
                    ],
                    "columnDefs": [
                        {"className": "text-center", "targets": [0, 4, 5, 6, 7, 8, 9]},
                        {"bSortable": false, "aTargets": [1, 2, 9]},
                    ],
                }
            );
            $('#table tbody').on('click', '.delete-confirm', function () {
                let id = $(this).attr('data-id');
                let url = '{!! url('admin/convenios') !!}/' + id;
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
                                            message: 'Convenio eliminado correctamente'
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
                                            message: 'Hubo un error al eliminar el convenio.'
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
