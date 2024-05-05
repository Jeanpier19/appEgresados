@extends('layouts.app')
@section('css')
@endsection
@section('content')
    <div class="container-fluid">
        <section class="card">
            <header class="card-header">
                <div class="pull-left">
                    <ol class="breadcrumb breadcrumb-simple">
                        <li><a href="#">Inicio</a></li>
                        <li class="active">Lista de Ofertas de Capacitación</li>

                    </ol>
                </div>
                <div class="pull-right">
                    {{-- @can('usuarios-crear') --}}
                    <a href="{{ route('ofertas_capacitaciones.create') }}"
                        class="btn btn-inline btn-success btn-rounded btn-sm"><i class="fa fa-plus-circle"></i>
                        Nuevo
                    </a>
                    {{-- @endcan --}}
                </div>
            </header>
            <div class="card-block">
                <input type="hidden" id="reporte-nombre">
                <input id="logo" type="hidden" name="logo">
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
                            <th>Estado</th>
                            <th>Empresa</th>
                            <th>Curso</th>
                            <th>Descripción</th>
                            <th>Fecha Inicio</th>
                            <th>Fecha Fin</th>
                            <th>¿Publicado?</th>
                            <th>Acciones</th>
                            <th>Publicación</th>
                            <th>Recomendación</th>
                            <th>¿Correo enviado?</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </section>
    </div>
    <div class="modal fade" id="modal-preview" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true" style="overflow-y: scroll;">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                        <i class="font-icon-close-2"></i>
                    </button>
                    Vista Previa de la Publicación
                </div>

                    <div class="col-md-12">
                        <div class="blog-item">
                            <div class="popup-wrapper">
                                <div class="popup-gallery">
                                    <a href="#">
                                        <img src="{{asset('img/default.png')}}" class="width-100" alt="oferta">
                                        <span class="eye-wrapper2"><i class="bi bi-link-45deg"></i></span>
                                    </a>
                                </div>
                            </div>
                            <div class="blog-item-inner">
                                <h3 class="blog-title"><a href="#" id="p_titulo"></a></h3>
                                <a href="#" class="blog-icons last" id="p_precio"><i class="bi bi-card-text"></i>Precio &#8212;</a>
                                <p id="p_descripcion"></p>
                                <div class="students"># Alumnos: 0
                                </div>
                                <div class="course-author">
                                    <p class="text-center" style="padding-left:0px">Desarrollado por<br>
                                        <span id="p_empresa"></span>
                                    </p>
                                </div>
                                <a href="#" class="scrool">
                                    <div class="btn col-lg-12 btn-inline btn-success">Registrarse</div>
                                </a>
                            </div>
                        </div>
                    </div>

                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-recomendacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                        <i class="font-icon-close-2"></i>
                    </button>
                    <h4 class="modal-title" id="myModalLabel-curso">Recomendación</h4>
                </div>
                <div class="modal-body">
                    {!! Form::open(['method' => 'POST', 'id' => 'form-recomendacion']) !!}
                    <div class="card-block">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                {!! Form::hidden('idofertacapacitacion', null, ['class' => 'form-control', 'id' => 'idofertacapacitacion']) !!}
                                {!! Form::hidden('empresa', null, ['class' => 'form-control', 'id' => 'empresa']) !!}
                                {!! Form::hidden('correo', null, ['class' => 'form-control', 'id' => 'correo']) !!}
                                {!! Form::hidden('vb_send', null, ['class' => 'form-control', 'id' => 'vb_send']) !!}
                                <div class="form-group">
                                    <strong>Ingrese una recomendación respecto a la oferta de capacitación:</strong>
                                    {!! Form::textarea('recomendacion', null, ['placeholder' => 'Ingrese una recomendacion...', 'class' => 'form-control', 'id' => 'recomendacion']) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <div class="form-group">
                                <strong>Evidencia actual:</strong>
                                <img id="imagen_r" src="{{asset('img/default.png')}}" alt="" class="img-fluid img-thumbnail">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <strong>Imagen de evidencia:</strong>
                                <div id="archivo" class="dropzone">
                                    <div class="dz-default dz-message">
                                        <div class="dz-icon">
                                            <i class="fa fa-file-image-o fa-3x text-success"></i>
                                        </div>
                                        <div>
                                            <span class="dz-text">Arrastra la imagen para subir</span>
                                            <p class="text-sm text-muted">o haga click para elegir
                                                manualmente</p>
                                        </div>
                                    </div>
                                    <div class="fallback">
                                        <input type="file" multiple="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-rounded btn-primary" id="send-recomendacion">Guardar</button>
                    <button type="button" class="btn btn-rounded btn-info" id="send-correo-recomendacion"></button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script type="text/javascript">
        Dropzone.autoDiscover = false;
        $(document).ready(function() {
            $('#send-correo-recomendacion').hide();
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
                    "url": "{{ route('ofertas_capacitaciones.get_ofertas') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": {
                        _token: "{{ csrf_token() }}"
                    }
                },
                "columns": [{
                    "data": "codigo"
                }],

                "columns": [{
                        "data": "estado"
                    },
                    {
                        "data": "empresa"
                    },
                    {
                        "data": "curso"
                    },
                    {
                        "data": "descripcion"
                    },
                    {
                        "data": "fecha_inicio"
                    },
                    {
                        "data": "fecha_fin"
                    },
                    {
                        "data": "vb"
                    },
                    {
                        "data": "options"
                    },
                    {
                        "data": "validacion"
                    },
                    {
                        "data": "recomendacion"
                    },
                    {
                        "data": "vb_send"
                    }
                ],
                "columnDefs": [{
                        "className": "text-center",
                        "targets": [0, 6]
                    },
                    {
                        "bSortable": false,
                        "aTargets": [5, 6]
                    },
                ],
            });
            var id;
            var nombre;
            $('#table tbody').on('click', '.delete-confirm', function() {
                let idofertas = $(this).attr('data-id');
                let url = '{!! route('ofertas_capacitaciones.destroy') !!}';
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
                                    "id": idofertas,
                                },
                                dataType: 'JSON',
                                beforeSend: function() {},
                                success: function(response) {
                                    if (response.success) {
                                        $.notify({
                                            icon: 'font-icon font-icon-check-circle',
                                            title: '<strong>¡Existoso!</strong>',
                                            message: 'Oferta eliminada correctamente'
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
                                            message: 'Hubo un error al eliminar la oferta'
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

        function validacion(id) {
            $.ajax({
                type: 'POST',
                url: '{!! route('ofertas_capacitaciones.validacion') !!}',
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
                            message: 'Oferta validada correctamente'
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

        function invalidacion(id) {
            $.ajax({
                type: 'POST',
                url: '{!! route('ofertas_capacitaciones.invalidacion') !!}',
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
                            message: 'Oferta invalidada correctamente'
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

        //apreciacion
        function Recomendacion(idoferta) {
            $('#modal-recomendacion').modal("show");
            $('#form-recomendacion')[0].reset();
            $.ajax({
                type: 'POST',
                url: '{!! route('ofertas_capacitaciones.get-recomendacion') !!}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "_method": 'POST',
                    "id": idoferta
                },
                dataType: 'JSON',
                success: function(data) {
                    console.log(data.data[0].imagen);
                    $('#recomendacion').val(data.data[0].recomendacion);
                    if(data.data[0].recomendacion !=null){
                        $('#send-correo-recomendacion').show();
                    }else{
                        $('#send-correo-recomendacion').hide();
                    }
                    if(data.data[0].imagen != null){
                        let src= '{!! asset('img/default.png') !!}';
                        $('#image_r').attr('src',src);
                    }
                    $('#idofertacapacitacion').val(data.data[0].id);
                    $('#empresa').val(data.data[0].empresa);
                    $('#correo').val(data.data[0].correo);
                    if(data.data[0].vb_send == '1'){
                        $('#send-correo-recomendacion').text('Reenviar Correo');
                    }else{
                        $('#send-correo-recomendacion').text('Enviar Correo');
                    }
                }
            });
        }

        $(document).ready(function() {
            Dropzone.autoDiscover = false;
            $('#archivo').dropzone({
                url: '{{ route('ofertas_capacitaciones.uploadImage') }}',
                enctype: 'multipart/form-data',
                autoProcessQueue: false,
                uploadMultiple: false,
                maxFilezise: 5,
                maxFiles: 1,
                acceptedFiles: ".jpg,.png,.jpeg",
                init: function() {
                    var submitBtn = document.querySelector("#send-recomendacion");
                    myDropzone = this;
                    submitBtn.addEventListener("click", function(e) {
                        if ($('#form-recomendacion')[0].checkValidity()) {
                            if (myDropzone.getQueuedFiles().length > 0) {
                                e.preventDefault();
                                e.stopPropagation();
                                myDropzone.processQueue();
                            } else {
                                myDropzone.uploadFiles([]); //send empty
                            }
                        } else {
                            $.notify({
                                icon: 'font-icon font-icon-warning',
                                title: '<strong>¡Error!</strong>',
                                message: 'Ingrese todos los campos'
                            }, {
                                placement: {
                                    from: "top",
                                },
                                type: 'danger'
                            });
                        }
                    });
                    this.on("addedfile", function(file) {});
                    this.on("maxfilesexceeded", function(file) {
                        this.removeAllFiles();
                        this.addFile(file);
                    });
                    this.on("sending", function(file, xhr, formData) {
                        var csrf_token = "{{ csrf_token() }}";
                        formData.append('_token', csrf_token);
                        formData.append('recomendacion', $('#recomendacion').val());
                    });
                    this.on("complete", function(file) {
                    });
                    this.on("success", function(file, response) {
                        myDropzone.processQueue.bind(myDropzone);
                        $('#logo').val(response['logo']);
                        console.log(response['logo']);
                        $.ajax({
                            type: 'POST',
                            url: '{!! route('ofertas_capacitaciones.update-recomendacion') !!}',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "_method": 'PATCH',
                                "id": $('#idofertacapacitacion').val(),
                                "recomendacion": $('#recomendacion').val(),
                                "imagen_evidencia": response['logo']
                            },
                            dataType: 'JSON',
                            success: function(response) {
                                if (response.success) {
                                    $('#table').DataTable().ajax
                                        .reload();
                                    $('#modal-recomendacion').modal(
                                        'hide');
                                    $('#form-recomendacion')[0].reset();

                                    $.notify({
                                        icon: 'font-icon font-icon-check-circle',
                                        title: '<strong>¡Existoso!</strong>',
                                        message: 'Recomendación registrada con éxito'
                                    }, {
                                        placement: {
                                            from: "top",
                                        },
                                        type: 'success'
                                    });
                                }
                            },
                            error: function(error) {
                                console.log(error);
                            }
                        });
                        this.removeAllFiles(true);
                    });
                }
            });
        });

        $('#send-correo-recomendacion').on('click',function(){
            swal({
                        title: 'Esta a punto de enviar un correo a '+$('#empresa').val(),
                        text: "La recomendación se enviará a "+$('#correo').val()+',¿Desea continuar?',
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonClass: "btn-success",
                        confirmButtonText: 'Continuar',
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
                                url: '{!! route('ofertas_capacitaciones.send-correo') !!}',
                                data: {
                                    "_token": "{{ csrf_token() }}",
                                    "_method": 'POST',
                                    "id":$('#idofertacapacitacion').val()
                                },
                                dataType: 'JSON',
                                beforeSend: function() {},
                                success: function(response) {
                                    if (response.success) {
                                        $.notify({
                                            icon: 'font-icon font-icon-check-circle',
                                            title: '<strong>¡Existoso!</strong>',
                                            message: '¡Se envió el correo exitosamente!'
                                        }, {
                                            placement: {
                                                from: "top",
                                            },
                                            type: 'success'
                                        });
                                        window.location = '{!! url('gape/gestion-egresado/ofertas_capacitacion/index') !!}/';
                                    } else {
                                        console.log(response.mensaje);
                                        $.notify({
                                            icon: 'font-icon font-icon-warning',
                                            title: '<strong>¡Error!</strong>',
                                            message: 'Hubo un error al enviar el correo'
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
                                text: "Usted canceló el envío de correo",
                                type: "error",
                                confirmButtonClass: "btn-danger"
                            });
                        }
                    });
        });

        function vistaPrevia(id){
            $('#modal-preview').modal('show');
            $.ajax({
                            type: 'POST',
                            url: '{!! route('ofertas_capacitaciones.preview') !!}',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "_method": 'POST',
                                "id": id
                            },
                            dataType: 'JSON',
                            success: function(data) {
                                console.log(data);
                                $('#p_titulo').text(data.data[0].titulo);
                                if(data.data[0].imagen != null){
                                    let src= '{!! asset('data.data[0].imagen') !!}';
                                    $('#p_imagen').attr('src',src);
                                }
                                $('#p_precio').text('Precio S/.'+data.data[0].precio);
                                $('#p_empresa').text(data.data[0].empresa);
                                $('#p_descripcion').text(data.data[0].oferta_descripcion);

                            },
                            error: function(error) {
                                console.log(error);
                            }
                        });
        }
    </script>
@endsection
