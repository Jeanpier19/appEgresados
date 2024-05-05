@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <section class="card">
            <header class="card-header">
                <div class="pull-left">
                    <ol class="breadcrumb breadcrumb-simple">
                        <li><a href="{{route('home')}}">Inicio</a></li>
                        <li><a href="{{route('convenios.index')}}">Convenios</a></li>
                        <li class="active">Editar</li>
                    </ol>
                </div>
                <div class="pull-right">
                    <a href="{{route('convenios.index')}}" class="btn btn-inline btn-secondary btn-rounded btn-sm"><i
                            class="fa fa-angle-left"></i> Atrás</a>
                </div>
            </header>
            {!! Form::model($convenio, ['id'=>'convenios','method' => 'PATCH','route' => ['convenios.update', $convenio->id]]) !!}
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
                    <input id="documento" type="hidden" name="documento" value="{{$convenio->documento}}">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Nombre:</strong>
                            {!! Form::text('nombre', null, array('id'=>'nombre','placeholder' => 'Nombre','class' => 'form-control','required')) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="form-group">
                            <strong>Resolucion:</strong>
                            {!! Form::text('resolucion',null, array('id' => 'resolucion','class' => 'form-control','placeholder'=>'Resolución','required')) !!}
                        </div>
                    </div>
                    <div id="tipo_convenio" class="col-xs-12 col-sm-6 col-md-6">
                        <div class="form-group">
                            <strong>Tipo:</strong>
                            {!! Form::select('tipo_convenio_id', $tipo_convenio->pluck('descripcion','id'),null, array('id' => 'tipo_convenio_id','class' => 'bootstrap-select','title'=>'Seleccione...','required')) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-3 col-md-3">
                        <div class="form-group">
                            <strong>Entidad:</strong>
                            {{ Form::select('entidad_id',$entidades->pluck('nombre','id'), null, array('id' => 'entidad_id','class' => 'bootstrap-select','title'=>'Seleccione...','required')) }}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-3 col-md-3">
                        <div class="form-group">
                            <strong>Vigencia:</strong>
                            {{ Form::select('vigencia',['DEFINIDO'=>'DEFINIDO','INDEFINIDO'=>'INDEFINIDO'], null, array('id' => 'vigencia','class' => 'bootstrap-select','title'=>'Seleccione...','required')) }}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-3 col-md-3">
                        <div class="form-group">
                            <strong>Fecha de inicio:</strong>
                            {!! Form::date('fecha_inicio', null, array('id'=>'fecha_inicio','placeholder' => 'Fecha de inicio','class' => 'form-control','required')) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-3 col-md-3">
                        <div class="form-group">
                            <strong>Fecha de vencimiento:</strong>
                            {!! Form::date('fecha_vencimiento', null, array('id'=>'fecha_vencimiento','placeholder' => 'Fecha de vencimiento','class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="form-group">
                            <strong>Objetivo:</strong>
                            {!! Form::textarea('objetivo', null, array('placeholder' => 'Objetivos','class' => 'form-control','rows'=>'4','required')) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="form-group">
                            <strong>Obligaciones:</strong>
                            {!! Form::textarea('obligaciones', null, array('placeholder' => 'Obligaciones','class' => 'form-control','rows'=>'4','required')) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-2 col-md-2">
                        <div class="form-group">
                            <strong>Documento actual:</strong>
                            @if($convenio->documento)
                                <a href="{{asset($convenio->documento)}}" target="_blank" class="btn btn-secondary btn-sm"> <i class="fa fa-file-pdf-o"></i> Ver documento</a>
                            @else
                                <img src="{{asset('img/default.png')}}" alt="" class="img-fluid img-thumbnail">
                            @endif
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-10 col-md-10">
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
            validaciones();

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
                    url: '{{ route('convenios.file.upload') }}',
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
                            if ($('#convenios')[0].checkValidity()) {
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
                            $('#documento').val(response['documento']);
                            myDropzone.processQueue.bind(myDropzone);
                            $('#convenios').submit();
                        });
                    }
                });
            }
        });
    </script>
@endsection
