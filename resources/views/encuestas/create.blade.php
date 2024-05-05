@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <section class="card">
            <header class="card-header">
                <div class="pull-left">
                    <ol class="breadcrumb breadcrumb-simple">
                        <li><i class="glyphicon glyphicon-list-alt"></i></li>
                        <li><a href="{{route('home')}}">Inicio</a></li>
                        <li><a href="{{route('encuestas.index')}}">Encuestas</a></li>
                        <li class="active">Crear</li>
                    </ol>
                </div>
                <div class="pull-right">
                    <a href="{{route('encuestas.index')}}" class="btn btn-inline btn-secondary btn-rounded btn-sm"><i
                            class="fa fa-angle-left"></i> Atrás</a>
                </div>
            </header>
            {!! Form::open(array('id'=>'encuesta','route' => 'encuestas.store','method'=>'POST')) !!}
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
                    <input id="documento" type="hidden" name="documento">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Título:</strong>
                            {!! Form::text('titulo', null, array('id'=>'titulo','placeholder' => 'Título','class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Descripción:</strong>
                            {!! Form::textarea('descripcion', null, array('placeholder' => 'Descripción','class' => 'form-control','rows'=>'4')) !!}
                        </div>
                    </div>
                    <!--                    <div class="col-xs-12 col-sm-4">
                                            <div class="form-group">
                                                <strong>Estado</strong>
                                                <select class="bootstrap-select">
                                                    <option value="P" data-content='<span class="fa fa-circle text-primary"></span> Programado'>Programado</option>
                                                    <option value="I" data-content='<span class="fa fa-circle text-success"></span> Iniciado'>Iniciado</option>
                                                    <option value="C" data-content='<span class="fa fa-circle text-danger"></span> Cerrado'>Cerrado</option>
                                                </select>
                                            </div>
                                        </div>-->
                    <div class="col-xs-12 col-sm-4">
                        <div class="form-group">
                            <strong>Fecha de apertura:</strong>
                            {!! Form::date('fecha_apertura', null, array('id'=>'fecha_apertura','placeholder' => 'Fecha de apertura','class' => 'form-control','min'=>$fecha_inicio)) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4">
                        <div class="form-group">
                            <strong>Fecha de cierre:</strong>
                            {!! Form::date('fecha_vence', null, array('id'=>'fecha_vence','placeholder' => 'Fecha de cierre','class' => 'form-control','min'=>$fecha_inicio)) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <strong>Documento:</strong>
                        <div id="archivo" class="dropzone">
                            <div class="dz-default dz-message">
                                <div class="dz-icon">
                                    <i class="fa fa-file-pdf-o fa-3x text-danger"></i>
                                    <i class="fa fa-file-word-o fa-3x text-primary"></i>
                                </div>
                                <div>
                                    <span class="dz-text">Arrastra el archivo para subir</span>
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
            $('#fecha_apertura').on('change', function () {
                let fecha_inicio = $(this).val();
                $('#fecha_vence').attr('min', fecha_inicio);
            });

            function dropzone() {
                $('#archivo').dropzone({
                    url: '{{ route('encuestas.documento.upload') }}',
                    enctype: 'multipart/form-data',
                    autoProcessQueue: false,
                    uploadMultiple: false,
                    maxFilezise: 5,
                    maxFiles: 1,
                    acceptedFiles: ".doc,.pdf,.docx",
                    init: function () {
                        var submitBtn = document.querySelector("#subir");
                        myDropzone = this;
                        submitBtn.addEventListener("click", function (e) {
                            if ($('#encuesta')[0].checkValidity()) {
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
                            $('#documento').val(response['documento']);
                            myDropzone.processQueue.bind(myDropzone);
                            $('#encuesta').submit();
                        });
                    }
                });
            }
        });
    </script>
@endsection
