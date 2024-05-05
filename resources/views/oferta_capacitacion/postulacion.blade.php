@extends('layouts.app')
@section('css')
    <link href="{{ asset('web/css/typeahead.min.css') }}" rel="stylesheet">
    <link href="{{ asset('web/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('web/css/main.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('web/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('web/css/profile.min.css') }}">
@endsection
@section('content')
    <div class="container-fluid">
        <section class="card">
            <header class="card-header">
                <div class="pull-left">
                    <ol class="breadcrumb breadcrumb-simple">
                        <li><a href="#">Inicio</a></li>
                        <li class="active">Lista de Postulaciones a las Ofertas de Capacitación</li>
                    </ol>
                </div>
            </header>
            <div class="card-block">
                <table id="table" class="display table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Empresa</th>
                            <th>Curso Oferta</th>
                            <th>Inscritos</th>
                            <th>¿Registrado?</th>
                            <th>Acciones</th>
                            <th>Certificado</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </section>
    </div>

    <div class="modal fade" id="modal-certificado" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                            <i class="font-icon-close-2"></i>
                        </button>
                        <h4 class="modal-title" id="myModalLabel-curso">Subir voucher</h4>
                    </div>
                    <div class="modal-body">
                        {!! Form::open(['method' => 'POST', 'route' => 'alumno_ofertas.subir-certificado', 'id' => 'form-certificado', 'file' => true, 'enctype' => 'multipart/form-data']) !!}
                        <div class="card-block">
                            <div class="row">
                                <strong>Suba el certificado correspondiente del asistente:</strong>
                                <div class="col-xs-10 col-sm-10 col-md-10">
                                    {!! Form::hidden('id', null, ['class' => 'form-control', 'id' => 'id']) !!}
                                    <div class="form-group">
                                        <br>
                                        <br>
                                        {!! Form::file('certificado', null, ['placeholder' => 'Subir aqui', 'class' => 'form-control', 'id' => 'certificado']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-rounded btn-primary" id="send-certificado">Subir</button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
@endsection
@section('js')
    <script src="{{ asset('web/js/jquery.typeahead.min.js') }}"></script>
    <script src="{{ asset('web/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('web/js/slick.min.js') }}"></script>
    <script type="text/javascript">
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
                    "url": "{{ route('alumno_ofertas.get-postulacion-alumno') }}",
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
                        "data": "inscritos"
                    },
                    {
                        "data": "vb"
                    },
                    {
                        "data": "opciones"
                    },
                    {
                        "data": "certificado"
                    }
                ],
                "columnDefs": [{
                        "className": "text-center",
                        "targets": [0, 5]
                    },
                    {
                        "bSortable": false,
                        "aTargets": [4, 5]
                    },
                ],
            });
        });

        function validarVoucher(id) {
            $.ajax({
                type: 'POST',
                url: '{!! route('alumno_ofertas.validar-voucher') !!}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "_method": 'POST',
                    "id": id,
                },
                dataType: 'JSON',
                success: function(data) {
                    if (data.success) {
                        $.notify({
                            icon: 'font-icon font-icon-check-circle',
                            title: '<strong>¡Existoso!</strong>',
                            message: 'Registro validado correctamente'
                        }, {
                            placement: {
                                from: "top",
                            },
                            type: 'success'
                        });
                        $('#table').DataTable().ajax.reload();
                    }
                }
            });
        }

        function invalidarVoucher(id) {
            $.ajax({
                type: 'POST',
                url: '{!! route('alumno_ofertas.invalidar-voucher') !!}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "_method": 'POST',
                    "id": id,
                },
                dataType: 'JSON',
                success: function(data) {
                    if (data.success) {
                        $.notify({
                            icon: 'font-icon font-icon-check-circle',
                            title: '<strong>¡Existoso!</strong>',
                            message: 'Registro invalidado correctamente'
                        }, {
                            placement: {
                                from: "top",
                            },
                            type: 'info '
                        });
                        $('#table').DataTable().ajax.reload();
                    }
                }
            });
        }
        function SubirCertificado(id){
            $('#form-certificado')[0].reset();
            $('#id').val(id);
            $('#modal-certificado').modal('show');
        }
    </script>
@endsection
