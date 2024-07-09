@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <section class="card">
            <header class="card-header">
                <div class="pull-left">
                    <ol class="breadcrumb breadcrumb-simple">
                        <li><a href="{{route('home')}}">Inicio</a></li>
                        <li class="active">Alumnos</li>
                    </ol>
                </div>
                <div class="pull-right">
                    @can('alumnos-crear')
                        <a href="{{route('alumnos.create')}}" class="btn btn-inline btn-success btn-rounded btn-sm"><i
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
                            <strong>Condición:</strong>
                            {{ Form::select('condicion_id',$condicion->pluck('descripcion','id'), null, array('id' => 'condicion_id','class' => 'selectpicker','title'=>'Seleccione...','data-container'=>'body','data-width'=>'100%','data-live-search'=>'true','multiple')) }}
                        </div>
                        <div class="col-xs-12 col-md-3">
                            <strong>Facultad:</strong>
                            {{ Form::select('facultad_id',$facultad->pluck('nombre','id'), null, array('id' => 'facultad_id','class' => 'selectpicker','title'=>'Seleccione...','data-container'=>'body','data-width'=>'100%','data-live-search'=>'true','data-max-options'=>'1','multiple')) }}
                        </div>
                        <div class="col-xs-12 col-md-3">
                            <strong>Escuela:</strong>
                            {{ Form::select('escuela_id',[], null, array('id' => 'escuela_id','class' => 'selectpicker','title'=>'Seleccione...','data-container'=>'body','data-width'=>'100%','data-live-search'=>'true','data-max-options'=>'1','multiple')) }}
                        </div>
                        {{-- <div class="col-xs-12 col-md-3">
                            <div class="form-group">
                                <strong>Reporte:</strong><br>
                                <button id="excel" type="button" class="btn btn-success btn-sm"><i
                                        class="fa fa-file-excel-o"></i> Excel
                                </button>
                                <button id="pdf" type="button" class="btn btn-danger btn-sm"><i
                                        class="fa fa-file-pdf-o"></i> PDF
                                </button>
                            </div>
                        </div> --}}
                    </form>
                </div>
                <table id="table" class="display table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>Código</th>
                        <th>Apellidos y Nombres</th>
                        <th>DNI</th>
                        <th>Correo electrónico</th>
                        <th>Celular</th>
                        <th>Género</th>
                        <th width="140px">Opciones</th>
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
            eliminar();
            seleccionar_facultad();

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
                        "url": "{{ route('alumnos.all') }}",
                        "dataType": "json",
                        "type": "POST",
                        "data": function (d) {
                            d._token = "{{csrf_token()}}";
                            d.condicion_id = $('#condicion_id').val();
                            d.facultad_id = $('#facultad_id').val();
                            d.escuela_id = $('#escuela_id').val();
                        },
                    },
                    "columns": [
                        {"data": "codigo"},
                        {"data": "nombre_completo"},
                        {"data": "dni"},
                        {"data": "correo"},
                        {"data": "celular"},
                        {"data": "genero"},
                        {"data": "options"}
                    ],
                    "columnDefs": [
                        {"className": "text-center", "targets": [0, 4, 5, 6]},
                        {"bSortable": false, "aTargets": [6]},
                    ],
                }
            );

            function seleccionar_facultad() {
                $('#facultad_id').on('change', function () {
                    let id = $(this).val();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: 'POST',
                        url: "{{route('facultad.escuelas')}}",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "facultad_id": id,
                        },
                        dataType: 'JSON',
                        beforeSend: function () {
                        },
                        success: function (response) {
                            let escuelas = "";
                            $.each(response, function (index, value) {
                                escuelas += '<option value="' + value['id'] + '">' + value['nombre'] + '</option>';
                            });
                            $('#escuela_id').html(escuelas).selectpicker('refresh');
                            filtro_escuela();
                        },
                        error: function (err) {
                            console.log(err);
                        }
                    });
                });
            }

            function eliminar() {
                $('#table tbody').on('click', '.delete-confirm', function () {
                    let id = $(this).attr('data-id');
                    let url = '{!! url('admin/alumnos') !!}/' + id;
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
            }

            function filtros() {
                $('#condicion_id, #facultad_id').on('change', function () {
                    tabla.ajax.reload();
                });
            }

            function filtro_escuela() {
                $('#escuela_id').on('change', function () {
                    tabla.ajax.reload();
                });
            }

            function reporte() {
                $('#excel').on('click', function () {
                    $('#reporte').attr('action', '{{route('convenios.excel')}}');
                    $('#reporte').submit();
                });
                // $('#pdf').on('click', function () {
                //     $('#reporte').attr('action', '{{route('convenios.pdf')}}');
                //     $('#reporte').submit();
                // });
            }
        });
    </script>
@endsection
