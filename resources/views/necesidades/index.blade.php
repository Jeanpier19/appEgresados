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
                        <li><i class="glyphicon glyphicon-list-alt"></i></li>
                        <li><a href="{{ route('home') }}">Inicio</a></li>
                        <li><a href="#">Mis expectativas</a></li>
                        <li class="active">Sobre Capacitaciones</li>
                    </ol>
                </div>
                <div class="pull-right">
                    <input type="hidden" id="type-send-curso">
                    {{-- @can('usuarios-crear') --}}
                    <a href="#" id="agregar-necesidades" class="btn btn-inline btn-success btn-rounded btn-sm"><i
                            class="fa fa-plus-circle" onclick="ResetHTMLNecesidad()"></i>
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
                            <th>Descripcion</th>
                            <th>Fecha</th>
                            <th>Horas</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </section>
    </div>
    <div class="modal fade" id="modal_necesidades" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                {!! Form::open(['route'=>'necesidad-capacitaciones.store-update','method' => 'POST', 'id' => 'form-necesidad','onsubmit'=>'return submitNecesidad()']) !!}
                <div class="modal-header">
                    <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                        <i class="font-icon-close-2"></i>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Escribir acerca de...</h4>
                </div>
                <div class="modal-body">
                    <div class="card-block">

                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                {!! Form::hidden('idalumno',$alumno_id, null, ['class' => 'form-control', 'id' => 'idalumno']) !!}
                                <div class="form-group">
                                    <strong><span class="is-required">*</span>¿Qué capacitación o entrenamiento usted desearia llevar?</strong>
                                    {!! Form::textarea('descripcion', null, ['placeholder' => 'Ingrese una descripcion de la capacitacion', 'class' => 'form-control', 'id' => 'descripcion','onkeyup'=>"MaxMinCadenas('send-necesidad',255,10,this,true)"]) !!}
                                </div>
                                <div class="form-group">
                                    <strong><span class="is-required">*</span>Expectativa de la fecha:</strong>
                                    {!! Form::date('fecha', null, ['placeholder' => 'Fecha de Inicio', 'class' => 'form-control', 'id' => 'fecha','onchange'=>"dateVal(document.getElementById('send-necesidad'),this,true)"]) !!}
                                </div>
                                <div class="form-group">
                                    <strong><span class="is-required">*</span>¿Cuántas horas de capacitación o entrenamiento esperaria? :</strong>
                                    {!! Form::text('horas', null, ['placeholder' => 'Ejm: 4', 'class' => 'form-control', 'id' => 'horas','onkeyup'=>"MaxMinCadenas('send-necesidad',3,1,this,true)",'onkeypress'=>"return SoloNumeros('send-necesidad',event,this,true)"]) !!}
                                </div>
                                <div class="form-group">
                                    <strong>Comentarios adicionales:</strong>
                                    {!! Form::text('comentarios', null, ['placeholder' => 'Ejm: Deseo que el curso fuera...', 'class' => 'form-control', 'id' => 'comentarios','onkeyup'=>"MaxMinCadenas('send-necesidad',255,10,this,false)"]) !!}
                                </div>
                                {!! Form::hidden('updateNec', null, ['class' => 'form-control', 'id' => 'updateNec']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-rounded btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary btn-rounded" id="send-necesidad"><i
                                class="fa fa-save"></i> Guardar</button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
<script src="{{ asset('js/validaciones.js') }}"></script>
    <script type="text/javascript">
    function submitNecesidad(){
        if(IsEmpty(document.getElementById('send-necesidad'),document.getElementById('descripcion'),document.getElementById('fecha'),document.getElementById('horas'))){
            return true;
        }
        return false;
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
                    "url": "{{ route('necesidad-capacitaciones.get-necesidades') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": {
                        _token: "{{ csrf_token() }}"
                    }
                },
                "columns": [{
                        "data": "idnecesidad"
                    },
                    {
                        "data": "descripcion"
                    },
                    {
                        "data": "fecha"
                    },
                    {
                        "data": "horas"
                    },
                    {
                        "data": "opciones"
                    }
                ],
                "columnDefs": [{
                        "className": "text-center",
                        "targets": [0, 4]
                    },
                    {
                        "bSortable": false,
                        "aTargets": [3, 4]
                    },
                ],
            });
            $('#table tbody').on('click', '.delete-confirm', function() {
                let idnecesidad = $(this).attr('data-id');
                let url = '{!! route('necesidad-capacitaciones.destroy') !!}/';
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
                                    "id": idnecesidad,
                                },
                                dataType: 'JSON',
                                beforeSend: function() {},
                                success: function(response) {
                                    if (response.success) {
                                        $.notify({
                                            icon: 'font-icon font-icon-check-circle',
                                            title: '<strong>¡Existoso!</strong>',
                                            message: 'Necesidad eliminada correctamente'
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
                                            message: 'Hubo un error al eliminar la necesidad.'
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

        //Editar
        function editarNecesidad(id){
            $('#updateNec').val(id);
            $.ajax({
                    type: 'POST',
                    url: '{!! route('necesidad-capacitaciones.get_data_necesidad') !!}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "_method": 'POST',
                        "id": id
                    },
                    dataType: 'JSON',
                    success: function(data) {
                        console.log(data);
                        $('#descripcion').val(data.descripcion);
                        $('#fecha').val(data.fecha);
                        $('#horas').val(data.horas);
                        $('#comentarios').val(data.comentarios);
                    }
                });
                $('#modal_necesidades').modal("show");
        }
        //
        //Open modal
        $('#agregar-necesidades').click(function() {
            //console.log($('#capacitacion_experiencia').val());
            $('#modal_necesidades').modal("show");
            $('#updateNec').val(-1);
            $('#form-necesidad')[0].reset();
            //getDataCurso();
        });
        //
    </script>
@endsection
