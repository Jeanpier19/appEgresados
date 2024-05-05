@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{asset('startui/css/separate/vendor/blockui.min.css')}}">
@endsection
@section('content')
    <div class="container-fluid">
        <section id="blockui" class="card">
            <header class="card-header">
                <div class="pull-left">
                    <ol class="breadcrumb breadcrumb-simple">
                        <li><a href="{{route('home')}}">Inicio</a></li>
                        <li class="active">Importar datos</li>
                    </ol>
                </div>
            </header>
            {!! Form::open(array('id'=>'importar','route' => 'data.import','method'=>'POST')) !!}
            <div class="card-block">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-no-border alert-close alert-dismissible fade in">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <p>{{ $message }}</p>
                    </div>
                @endif
                @if (count($errors) > 0)
                    <div class="alert alert-danger alert-no-border alert-close alert-dismissible fade in">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Whoops!</strong> Hubo algunos problemas con datos.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Importar:</strong>
                            {!! Form::select('importar', ['E' => 'Egresados','G'=>'Graduados','T'=>'Titulados','C'=>'Convenios'],[], array('id'=>'tipo','class' => 'bootstrap-select','title'=>'Elige uno de los siguientes...')) !!}
                            <span
                                class="text-danger text-muted"><small>Se recomienda importar un máximo de 5000 filas</small></span>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div id="archivo" class="dropzone">
                            <div class="dz-default dz-message">
                                <div class="dz-icon">
                                    <i class="fa fa-file-excel-o fa-3x text-success"></i>
                                </div>
                                <div>
                                    <span class="dz-text">Arrastra archivos para subir</span>
                                    <p class="text-sm text-muted">o haga click para elegir
                                        manualmente</p>
                                </div>
                            </div>
                            <div class="fallback">
                                <input name="file" type="file" multiple="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button id="subir" type="button" class="btn btn-primary btn-sm"><i class="fa fa-save"></i> Guardar
                </button>
            </div>
            {!! Form::close() !!}
        </section>
    </div><!--.container-fluid-->
@endsection
@section('js')
    <script type="text/javascript" src="{{asset('startui/js/lib/blockUI/jquery.blockUI.js')}}"></script>
    <script type="text/javascript">
        Dropzone.autoDiscover = false;
        $(document).ready(function () {
            dropzone();

            function dropzone() {
                $('#archivo').dropzone({
                    url: '{{ route('data.upload') }}',
                    enctype: 'multipart/form-data',
                    autoProcessQueue: false,
                    uploadMultiple: false,
                    maxFilezise: 5,
                    maxFiles: 1,
                    acceptedFiles: ".xlsx",
                    init: function () {
                        var submitBtn = document.querySelector("#subir");
                        myDropzone = this;
                        submitBtn.addEventListener("click", function (e) {
                            if ($('#importar')[0].checkValidity()) {
                                if (myDropzone.getQueuedFiles().length > 0) {
                                    $('#blockui').block({
                                        message: '<div id="blockui-message" class="blockui-default-message"><i class="fa fa-circle-o-notch fa-spin"></i><h6>Subiendo archivo</h6></div>',
                                        overlayCSS: {
                                            background: 'rgba(24, 44, 68, 0.4)',
                                            opacity: 1,
                                            cursor: 'wait'
                                        },
                                        css: {
                                            width: '50%'
                                        },
                                        blockMsgClass: 'block-msg-default'
                                    });
                                    e.preventDefault();
                                    e.stopPropagation();
                                    myDropzone.processQueue();
                                } else {
                                    myDropzone.uploadFiles([]); //send empty
                                }
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
                            var tipo = $('#tipo').val();
                            formData.append('_token', csrf_token);
                            formData.append('tipo', tipo);
                        });
                        this.on("complete", function (file) {
                        });
                        this.on("success", function (file, response) {
                            myDropzone.processQueue.bind(myDropzone);
                            $('#importar').submit();
                            $('#blockui-message').html('<i class="fa fa-circle-o-notch fa-spin"></i><h6>Importando datos</h6>');
                        });
                    }
                });
            }
        });
    </script>
@endsection
