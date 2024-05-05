@extends('layouts.app')
@section('css')
    <link href="{{ asset('web/css/font-awesome.min.css') }}" rel="stylesheet">
    <style>
        .error {
            color: #a94442;
            background-color: #f2dede;
            border-color: #ebccd1;
            padding: 1px 20px 1px 20px;
        }

        label.error {
            color: #a94442;
            background-color: #f2dede;
            border-color: #ebccd1;
            padding: 1px 20px 1px 20px;
        }

    </style>
@endsection
@section('content')
    <div class="container-fluid">
        <section class="card">
            <header class="card-header">
                <div class="pull-left">
                    <ol class="breadcrumb breadcrumb-simple">
                        <li><a href="{{ route('home') }}">Inicio</a></li>
                        <li><a href="{{ route('documento.index') }}">Documento</a></li>
                        <li class="active">Editar</li>
                    </ol>
                </div>
                <div class="pull-right">
                    <a href="{{ route('documento.index') }}" class="btn btn-inline btn-secondary btn-rounded btn-sm"><i
                            class="fa fa-angle-left"></i> Atrás</a>
                </div>
            </header>
            {!! Form::model($documento, ['method' => 'PATCH', 'route' => ['documento.update', $documento->id], 'file' => true, 'enctype' => 'multipart/form-data', 'id' => 'form-documento','onsubmit'=>'return submitContinue();']) !!}
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
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Tipo de Documento</strong><br>
                            {!! Form::select('tipo_documento', $tipo, ['class' => 'form-control'], ['class' => 'custom-select', 'id' => 'tipo_documento']) !!}
                        </div>
                        <div class="form-group" id="respuestaOGE">
                            <strong>Documento de Respuesta:</strong><br>
                            {!! Form::select('respuesta1', $respuestaOGE, ['class' => 'form-control'], ['class' => 'custom-select', 'placeholder' => 'Seleccionar', 'id' => 'respuesta1']) !!}
                        </div>
                        <div class="form-group" id="respuestaSGE">
                            <strong>Documento de Respuesta:</strong><br>
                            {!! Form::select('respuesta2', $respuestaSGE, ['class' => 'form-control'], ['class' => 'custom-select', 'placeholder' => 'Seleccionar', 'id' => 'respuesta2']) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Descripcion:</strong>
                            {!! Form::text('descripcion', null, ['placeholder' => 'Descripcion del documento', 'class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        {!! Form::hidden('file', null, ['id' => 'documento-file']) !!}
                        <strong>Archivo:</strong>
                        <div id="archivo" class="dropzone">
                            <div class="dz-default dz-message">
                                <div class="dz-icon">
                                    <i class="fa fa-file-pdf-o fa-3x text-danger"></i>
                                </div>
                                <div>
                                    <span class="dz-text">Arrastra el documento para subir</span>
                                    <p class="text-sm text-muted">o haga click para elegir
                                        manualmente</p>
                                </div>
                            </div>
                            <div class="fallback">
                                <input type="file" name="file2" class="form-control" multiple="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" id="subir" class="btn btn-primary btn-sm"><i class="fa fa-save"></i>
                    Guardar</button>
            </div>
            {!! Form::close() !!}
        </section>
    </div>
    <!--.container-fluid-->
@endsection
@section('js')
    <script type="text/javascript">
        Dropzone.autoDiscover = false;
        $(document).ready(function() {
            dropzone();


            $('#respuestaOGE').hide();
            $('#respuestaSGE').hide();
            $('#tipo_documento').change(function() {
                $("#tipo_documento option:selected").each(function() {
                    console.log($(this).text());
                    $('#respuestaOGE').hide();
                    $('#respuestaSGE').hide();
                    if ($(this).text() == "Respuesta OGE") {
                        console.log('hola1');
                        $('#respuestaOGE').show();
                    }
                    if ($(this).text() == "Respuesta SGE") {
                        console.log('hola2');
                        $('#respuestaSGE').show();
                    }
                })
            }).change();

            updateDocumentos();
            console.log($('#form-documento')[0]);
        });

        function submitContinue(){
            if($('#archivo')[0].dropzone.files.length != 0){
                return true;
            }else{
                $.notify({
                    icon: 'font-icon font-icon-check-circle',
                    title: '<strong>¡Alto!</strong>',
                    message: 'Suba una archivo.'
                }, {
                    placement: {
                        from: "top",
                    },
                    type: 'danger'
                });
                return false;
            }
        }

        function updateDocumentos() {
            $.ajax({
                url: '{!! route('documento.get-data-documento') !!}',
                "dataType": "json",
                "type": "POST",
                "data": {
                    _token: "{{ csrf_token() }}",
                    method: 'POST',
                    id: '{!! $documento->id !!}'
                },
                success: function(data) {
                    console.log(data);
                    $('#tipo_documento').val(data[0].tipo_documento).change();
                    if (data[0].tipo_documento == '2') {
                        $('#respuesta1').val(data[0].respuesta).change();
                    }
                    if (data[0].tipo_documento == '3') {
                        $('#respuesta2').val(data[0].respuesta).change();
                    }
                }
            });
        }

        function dropzone() {
            $('#archivo').dropzone({
                url: '{{ route('documento.upload-file') }}',
                enctype: 'multipart/form-data',
                autoProcessQueue: false,
                uploadMultiple: false,
                maxFilezise: 5,
                maxFiles: 1,
                acceptedFiles: ".pdf",
                init: function() {
                    var submitBtn = document.querySelector("#subir");
                    myDropzone = this;
                    submitBtn.addEventListener("click", function(e) {
                        $('#form-documento').validate({
                            lang: 'es',
                            rules: {
                                tipo: {
                                    required: true
                                },
                                descripcion: {
                                    required: true
                                },
                                file2: {
                                    required: true,
                                    extension: "pdf"
                                }
                            },
                            messages: {
                                tipo: "Este campo es requerido",
                                descripcion: "Seleccione una opción.",
                                file2: "Suba un archivo"
                            }
                        });

                        if ($('#form-documento').valid()) {
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
                    this.on("error", function(file, responseText) {
                        $.each(responseText, function(index, value) {
                            $('.dz-error-message').text(value);
                            console.log(value);
                        });
                    });
                    this.on("addedfile", function(file) {});
                    this.on("maxfilesexceeded", function(file) {
                        this.removeAllFiles();
                        this.addFile(file);
                    });
                    this.on("sending", function(file, xhr, formData) {
                        var csrf_token = "{{ csrf_token() }}";
                        var filename = '{!! $documento->file !!}';
                        formData.append('_token', csrf_token);
                        formData.append('filename', filename);
                    });
                    this.on("complete", function(file) {});
                    this.on("success", function(file, response) {
                        $('#documento-file').val(response['file']);
                        myDropzone.processQueue.bind(myDropzone);
                        $('#form-documento').submit();
                    });
                }
            });
        }
    </script>
@endsection
