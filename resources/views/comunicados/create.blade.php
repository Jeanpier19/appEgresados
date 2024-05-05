@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <section class="card">
            <header class="card-header">
                <div class="pull-left">
                    <ol class="breadcrumb breadcrumb-simple">
                        <li><a href="{{route('home')}}">Inicio</a></li>
                        <li><a href="{{route('comunicados.index')}}">Comunicados</a></li>
                        <li class="active">Crear</li>
                    </ol>
                </div>
                <div class="pull-right">
                    <a href="{{route('comunicados.index')}}" class="btn btn-inline btn-secondary btn-rounded btn-sm"><i
                            class="fa fa-angle-left"></i> Atrás</a>
                </div>
            </header>
            {!! Form::open(array('id'=>'comunicados','route' => 'comunicados.store','method'=>'POST')) !!}
            <div class="card-block">
                @if (count($errors) > 0)
                    <div class="alert alert-danger alert-no-border alert-close alert-dismissible fade in">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Whoops!</strong> Hubo algunos problemas con su entrada.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="row">
                    <input id="imagen" type="hidden" name="imagen">
                    <div class="col-xs-12 col-sm-9 col-md-9">
                        <div class="form-group">
                            <strong>Título:</strong>
                            {!! Form::text('titulo', null, array('id'=>'titulo','placeholder' => 'Título','class' => 'form-control','required')) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-3 col-md-3">
                        <div class="form-group">
                            <strong>Fecha fin:</strong>
                            {!! Form::date('fecha_fin', null, array('id'=>'fecha_fin','placeholder' => 'Fecha','class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="form-group">
                            <strong>Vídeo:</strong>
                            {!! Form::text('video', null, array('id'=>'titulo','placeholder' => 'Link del vídeo','class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="form-group">
                            <strong>Link de publicación/archivo:</strong>
                            {!! Form::text('link', null, array('id'=>'link','placeholder' => 'Link de la publicación','class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Descripción:</strong>
                            {!! Form::textarea('descripcion', null, array('placeholder' => 'Descripción','class' => 'form-control','rows'=>'5','required')) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <strong>Imagen/Banner:</strong>
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
            <div class="card-footer">
                <button id="subir" type="submit" class="btn btn-primary btn-sm"><i class="fa fa-save"></i> Guardar
                </button>
            </div>
            {!! Form::close() !!}
        </section>
    </div><!--.container-fluid-->
@endsection
@section('js')
    <script type="text/javascript">
        Dropzone.autoDiscover = false;
        $(document).ready(function () {
            dropzone();
            //validaciones();

            function validaciones() {
                $('#vigencia').on('change', function () {
                    let vigencia = $(this).val();
                    if (vigencia === 'DEFINIDO') {
                        $('#fecha_vencimiento').prop('disabled', false);
                    } else {
                        $('#fecha_vencimiento').prop('disabled', true);
                    }
                });
                $('#fecha_inicio').on('change', function () {
                    let fecha_inicio = $(this).val();
                    $('#fecha_vencimiento').attr('min', fecha_inicio);
                });
            }

            function dropzone() {
                $('#archivo').dropzone({
                    url: '{{ route('comunicados.image.upload') }}',
                    enctype: 'multipart/form-data',
                    autoProcessQueue: false,
                    uploadMultiple: false,
                    maxFilezise: 5,
                    maxFiles: 1,
                    acceptedFiles: ".jpg,.png,.jpeg",
                    init: function () {
                        var submitBtn = document.querySelector("#subir");
                        myDropzone = this;
                        submitBtn.addEventListener("click", function (e) {
                            if ($('#comunicados')[0].checkValidity()) {
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
                        this.on("addedfile", function (file) {
                        });
                        this.on("maxfilesexceeded", function (file) {
                            this.removeAllFiles();
                            this.addFile(file);
                        });
                        this.on("sending", function (file, xhr, formData) {
                            var csrf_token = "{{ csrf_token() }}";
                            formData.append('_token', csrf_token);
                            formData.append('nombre', $('#titulo').val());
                        });
                        this.on("complete", function (file) {
                        });
                        this.on("success", function (file, response) {
                            $('#imagen').val(response['imagen']);
                            myDropzone.processQueue.bind(myDropzone);
                            $('#comunicados').submit();
                        });
                    }
                });
            }
        });
    </script>
@endsection
