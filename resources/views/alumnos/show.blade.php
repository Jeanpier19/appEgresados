@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <section class="card">
            <header class="card-header">
                <div class="pull-left">
                    <ol class="breadcrumb breadcrumb-simple">
                        <li><a href="{{route('home')}}">Inicio</a></li>
                        <li><a href="{{route('alumnos.index')}}">Alumnos</a></li>
                        <li class="active">Condición</li>
                    </ol>
                </div>
                <div class="pull-right">
                    <a href="{{route('alumnos.index')}}" class="btn btn-inline btn-secondary btn-rounded btn-sm"><i
                            class="fa fa-angle-left"></i> Atrás</a>
                </div>
            </header>
            {!! Form::open(array('id'=>'alumnos','route' => 'alumnos.condicion.store','method'=>'POST')) !!}
            <div class="card-block">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-no-border alert-close alert-dismissible fade in">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <p>{{ $message }}</p>
                    </div>
                @endif
                <div class="row">
                    <input name="alumno_id" type="hidden" value="{{$alumno->id}}">
                    <div class="col-xs-10 col-sm-10 col-md-10">
                        <div class="form-group">
                            <strong>Condición:</strong>
                            {{ Form::select('condicion_id',$condicion->pluck('descripcion','id'), null, array('id' => 'condicion_id','class' => 'bootstrap-select','data-live-search'=>'true','title'=>'Seleccione...')) }}
                        </div>
                    </div>
                    <div class="col-xs-2 col-sm-2 col-md-2" style="margin-top: 18px;">
                        <button id="guardar_condicion" type="button" class="btn btn-info btn-block"><i
                                class="fa fa-plus-circle"></i>
                            Agregar
                        </button>
                    </div>
                    <div
                        class="col-xs-12 col-sm-4 col-md-4 condicion-1 condicion-2 condicion-3 condicion-4 condicion-5 condicion-6 condicion-7"
                        style="display: none;">
                        <div class="form-group">
                            <strong>Código de local: <span class="text-danger">*</span></strong>
                            {{ Form::select('codigo_local',$codigo_local->pluck('descripcion','valor'), null, array('id' => 'codigo_local','class' => 'bootstrap-select','data-live-search'=>'true','title'=>'Seleccione...','required')) }}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4 condicion-1 condicion-2 condicion-3"
                         style="display: none;">
                        <div class="form-group">
                            <strong>Facultad: <span class="text-danger">*</span></strong>
                            {{ Form::select('facultad_id',$facultad->pluck('nombre','id'), null, array('id' => 'facultad_id','class' => 'select2')) }}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4 condicion-1 condicion-2 condicion-3"
                         style="display: none;">
                        <div class="form-group">
                            <strong>Escuela: <span class="text-danger">*</span></strong>
                            <select name="escuela_id" id="escuela_id" class="select2">
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4 condicion-2" style="display: none;">
                        <div class="form-group">
                            <strong>Grado: <span class="text-danger">*</span></strong>
                            <select name="grado_id" id="grado_id" class="select2" disabled>
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4 condicion-3"
                         style="display: none;">
                        <div class="form-group">
                            <strong>Título: <span class="text-danger">*</span></strong>
                            <select name="titulo_id" id="titulo_id" class="select2" disabled>
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4 condicion-4 condicion-5" style="display: none;">
                        <div class="form-group">
                            <strong>Maestría: <span class="text-danger">*</span></strong>
                            {{ Form::select('maestria_id',$maestrias->pluck('nombre','id'), null, array('id' => 'maestria_id','class' => 'select2')) }}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4 condicion-4 condicion-5" style="display: none;">
                        <div class="form-group">
                            <strong>Mención: <span class="text-danger">*</span></strong>
                            {{ Form::select('mencion_id',[], null, array('id' => 'mencion_id','class' => 'select2')) }}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4 condicion-6 condicion-7" style="display: none;">
                        <div class="form-group">
                            <strong>Doctorado: <span class="text-danger">*</span></strong>
                            {{ Form::select('doctorado_id',$doctorados->pluck('nombre','id'), null, array('id' => 'doctorado_id','class' => 'select2')) }}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4 condicion-1 condicion-4 condicion-6"
                         style="display: none;">
                        <div class="form-group">
                            <strong>Semestre Ingreso: <span class="text-danger">*</span></strong>
                            {{ Form::select('semestre_ingreso',$semestres->pluck('descripcion','id'), null, array('id' => 'semestre_ingreso','class' => 'select2')) }}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4 condicion-1 condicion-4 condicion-6"
                         style="display: none;">
                        <div class="form-group">
                            <strong>Semestre Egreso: <span class="text-danger">*</span></strong>
                            {{ Form::select('semestre_egreso',$semestres->pluck('descripcion','id'), null, array('id' => 'semestre_egreso','class' => 'select2')) }}
                        </div>
                    </div>
                    <div
                        class="col-xs-12 col-sm-4 col-md-4 condicion-1 condicion-2 condicion-3 condicion-4 condicion-5 condicion-6 condicion-7"
                        style="display: none;">
                        <div class="form-group">
                            <strong>Resolución:</strong>
                            {!! Form::text('resolucion', null, array('id'=>'resolucion','placeholder' => 'Resolución','class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4 condicion-2 condicion-3 condicion-5 condicion-7"
                         style="display: none;">
                        <div class="form-group">
                            <strong>Fecha:</strong>
                            {!! Form::date('fecha', null, array('id'=>'fecha','placeholder' => 'Fecha','class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <table id="table" class="display table table-striped table-bordered" cellspacing="0"
                               width="100%">
                            <thead>
                            <tr>
                                <th>Condición</th>
                                <th>Descripción</th>
                                <th>Código Local</th>
                                <th>Semestres/Fecha</th>
                                <th>Resolución</th>
                                <th width="100px">Opciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </section>
    </div><!--.container-fluid-->
@endsection
@section('js')
    <script type="text/javascript">
        $(document).ready(function () {
            var condicion_id;
            inicializar();
            seleccionar_condicion();
            seleccionar_facultad();
            seleccionar_maestria();
            guardar_condicion();
            eliminar_condicion();

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
                        "url": "{{ route('alumnos.condicion.all') }}",
                        "dataType": "json",
                        "type": "POST",
                        "data": function (d) {
                            d._token = "{{csrf_token()}}";
                            d.alumno_id = "{{$alumno->id}}"
                        },
                    },
                    "columns": [
                        {"data": "condicion"},
                        {"data": "descripcion"},
                        {"data": "codigo_local"},
                        {"data": "semestre_fecha"},
                        {"data": "resolucion"},
                        {"data": "options"}
                    ],
                    "columnDefs": [
                        {"className": "text-center", "targets": [0, 5]},
                        {"bSortable": false, "aTargets": [0, 1, 2, 3, 4, 5]},
                    ],
                }
            );

            function inicializar() {
                $(".select2").select2({
                    placeholder: "Seleccione",
                }).val('').trigger('change');
            }

            function seleccionar_condicion() {
                $('#condicion_id').on('change', function () {
                    if (condicion_id) {
                        $('.condicion-' + condicion_id).hide();
                    }
                    let id = parseInt($(this).val());
                    condicion_id = id;
                    $('.condicion-' + id).show();
                    validaciones(id);
                });
            }

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
                            let grados = "";
                            let titulos = "";
                            $.each(response, function (index, value) {
                                escuelas += '<option value="' + value['id'] + '">' + value['nombre'] + '</option>';
                                grados += '<option value="' + value['id'] + '">' + value['grado'] + '</option>';
                                titulos += '<option value="' + value['id'] + '">' + value['titulo'] + '</option>';
                            });
                            $('#escuela_id').html(escuelas);
                            $('#grado_id').html(grados);
                            $('#titulo_id').html(titulos);
                            seleccionar_grado();
                        },
                        error: function (err) {
                            console.log(err);
                        }
                    });
                });
            }

            function seleccionar_maestria() {
                $('#maestria_id').on('change', function () {
                    let id = $(this).val();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: 'POST',
                        url: "{{route('maestria.menciones')}}",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "maestria_id": id,
                        },
                        dataType: 'JSON',
                        beforeSend: function () {
                        },
                        success: function (response) {
                            let menciones = "";
                            $.each(response.data, function (index, value) {
                                menciones += '<option value="' + value['id'] + '">' + value['nombre'] + '</option>'
                            });
                            $('#mencion_id').html(menciones);
                        },
                        error: function (err) {
                            console.log(err);
                        }
                    });
                });
            }

            function seleccionar_grado() {
                $('#escuela_id').on('change', function () {
                    let id = $(this).val();
                    $('#grado_id').val(id).trigger('change');
                    $('#titulo_id').val(id).trigger('change');
                })
            }

            function validaciones(condicion) {
                if (condicion === 1) {
                    $('#facultad_id').prop('required', true);
                    $('#escuela_id').prop('required', true);
                    $('#semestre_ingrego').prop('required', true);
                    $('#semestre_egreso').prop('required', true);
                } else if (condicion === 2) {
                    $('#facultad_id').prop('required', true);
                    $('#escuela_id').prop('required', true);
                } else if (condicion === 3) {
                    $('#facultad_id').prop('required', true);
                    $('#escuela_id').prop('required', true);
                } else if (condicion === 4) {
                    $('#maestria_id').prop('required', true);
                    $('#mencion_id').prop('required', true);
                    $('#semestre_ingrego').prop('required', true);
                    $('#semestre_egreso').prop('required', true);
                } else if (condicion === 5) {
                    $('#maestria_id').prop('required', true);
                    $('#mencion_id').prop('required', true);
                } else if (condicion === 6) {
                    $('#doctorado_id').prop('required', true);
                    $('#semestre_ingrego').prop('required', true);
                    $('#semestre_egreso').prop('required', true);
                } else if (condicion === 7) {
                    $('#doctorado_id').prop('required', true);
                }
            }

            function guardar_condicion() {
                $('#guardar_condicion').on('click', function () {
                    if ($('#alumnos')[0].checkValidity()) {
                        $('#alumnos').submit();
                    } else {
                        $.notify({
                            icon: 'font-icon font-icon-warning',
                            title: '<strong>¡Error!</strong>',
                            message: 'Es necesario ingresar todos los datos obligatorios (*)',
                        }, {
                            placement: {from: "top",},
                            type: 'danger',
                            z_index: 2000,
                        });
                    }
                });
            }

            function eliminar_condicion() {
                $('#table tbody').on('click', '.delete-confirm', function () {
                    let id = $(this).attr('data-id');
                    let url = '{!! url('admin/alumnos/condicion') !!}/'+id;
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
                                                message: 'Condición eliminado correctamente'
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
                                                message: 'Hubo un error al eliminar.'
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
                                    text: "El registro no se eliminó",
                                    type: "error",
                                    confirmButtonClass: "btn-danger"
                                });
                            }
                        });
                });
            }
        });
    </script>
@endsection
