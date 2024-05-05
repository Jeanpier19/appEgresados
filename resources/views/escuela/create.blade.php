@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <section class="card">
            <header class="card-header">
                <div class="pull-left">
                    <ol class="breadcrumb breadcrumb-simple">
                        <li><a href="{{route('home')}}">Inicio</a></li>
                        <li><a href="{{route('escuela.index')}}">Escuela</a></li>
                        <li class="active">Crear</li>
                    </ol>
                </div>
                <div class="pull-right">
                    <a href="{{route('escuela.index')}}" class="btn btn-inline btn-secondary btn-rounded btn-sm"><i
                            class="fa fa-angle-left"></i> Atrás</a>
                </div>
            </header>
            {!! Form::open(array('id'=>'escuela','route' => 'escuela.store','method'=>'POST','file' => true,'enctype'=>'multipart/form-data')) !!}
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
                    <input id="logo" type="hidden" name="logo">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Facultad</strong><br>
                            {!! Form::select('facultad_id', $facultades->pluck('nombre','id'),[], array('class' => 'bootstrap-select','title'=>'Elige uno de los siguientes...','data-live-search' => 'true', 'required')) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Nombre de escuela:</strong>
                            {!! Form::text('nombre', null, array('id'=>'nombre','placeholder' => 'Nombre de la escuela','class' => 'form-control','required')) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
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
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
    <script type="text/javascript">
        Dropzone.autoDiscover = false;
        $(document).ready(function () {
            dropzone();

            function dropzone() {
                $('#archivo').dropzone({
                    url: '{{ route('escuela.image.upload') }}',
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
                            if ($('#escuela')[0].checkValidity()) {
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
                            formData.append('nombre', $('#nombre').val());
                        });
                        this.on("complete", function (file) {
                        });
                        this.on("success", function (file, response) {
                            $('#logo').val(response['logo']);
                            myDropzone.processQueue.bind(myDropzone);
                            $('#escuela').submit();
                        });
                    }
                });
            }
        });
    </script>
@endsection
