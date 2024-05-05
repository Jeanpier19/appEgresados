@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <section class="card">
            <header class="card-header">
                <div class="pull-left">
                    <ol class="breadcrumb breadcrumb-simple">
                        <li><a href="{{route('home')}}">Inicio</a></li>
                        <li><a href="{{route('ofertas_laborales.index')}}">Ofertas Laborales</a></li>
                        <li class="active">Crear</li>
                    </ol>
                </div>
                <div class="pull-right">
                    <a href="{{route('ofertas_laborales.index')}}"
                       class="btn btn-inline btn-secondary btn-rounded btn-sm"><i
                            class="fa fa-angle-left"></i> Atrás</a>
                </div>
            </header>
            {!! Form::open(array('id'=>'ofertas_laborales','route' => 'ofertas_laborales.store','method'=>'POST','enctype'=>'multipart/form-data')) !!}
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
                            {!! Form::text('titulo', null, array('id'=>"nombre",'placeholder' => 'Título','class' => 'form-control','required')) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="form-group">
                            <strong>Entidad:</strong>
                            {{ Form::select('entidad_id',$entidades->pluck('nombre','id'), null, array('id' => 'entidad_id','class' => 'bootstrap-select','title'=>'Seleccione...','required')) }}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="form-group">
                            <strong>Tipo</strong>
                            {{ Form::select('tipo_contrato_id', $tipo_contrato->pluck('descripcion','id'), null, array('id' => 'tipo_contrato_id','class' => 'bootstrap-select','title'=>'Seleccione...','data-live-search' => 'true','required'))}}
                            @error('tipo')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="form-group">
                            <strong>Área</strong>
                            {{ Form::select('area', $escuelas->pluck('nombre','id'), null, array('id' => 'area','class' => 'bootstrap-select','title'=>'Seleccione...','data-live-search' => 'true','required'))}}
                            @error('area')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-3 col-md-3">
                        <div class="form-group">
                            <strong>Jornada Laboral</strong>
                            {{ Form::select('jornada', ["Tiempo completo"=>"Tiempo completo","Tiempo parcial"=>"Tiempo parcial","Por horas"=>"Por horas","Remoto"=>"Remoto","Beca/Prácticas"=>'Beca/Prácticas'], null, array('id' => 'area','class' => 'bootstrap-select','title'=>'Seleccione...','data-live-search' => 'true','required'))}}
                            @error('jornada')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-3 col-md-3">
                        <div class="form-group">
                            <strong>Salario (mensual):</strong>
                            {!! Form::number('salario', null, array('id'=>"salario",'placeholder' => 'Salario','class' => 'form-control','min'=>'0')) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-3 col-md-3">
                        <div class="form-group">
                            <strong>Vacantes:</strong>
                            {!! Form::number('vacantes', null, array('id'=>"vacantes",'placeholder' => 'Vacantes','class' => 'form-control','min'=>'1')) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-3 col-md-3">
                        <div class="form-group">
                            <strong>Fecha de contratación:</strong>
                            {!! Form::date('fecha_contratacion', null, array('id'=>"fecha_contratacion",'placeholder' => 'Fecha de contratación','class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-3 col-md-3">
                        <div class="form-group">
                            <strong>Fecha de publicación:</strong>
                            {!! Form::date('fecha_publicacion', null, array('id'=>"fecha_publicacion",'placeholder' => 'Fecha de publicación','class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-3 col-md-3">
                        <div class="form-group">
                            <strong>Fecha de vencimiento:</strong>
                            {!! Form::date('fecha_vencimiento', null, array('id'=>"fecha_vencimiento",'placeholder' => 'Fecha de vencimiento','class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Perfil:</strong>
                            {!! Form::textarea('perfil', null, array('placeholder' => 'Describa el perfil requerido','class' => 'form-control','rows'=>'4')) !!}
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
            validaciones();

            function dropzone() {
                $('#archivo').dropzone({
                    url: '{{ route('ofertas_laborales.file.upload') }}',
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
                            if ($('#ofertas_laborales')[0].checkValidity()) {
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
                            $('#ofertas_laborales').submit();
                        });
                    }
                });
            }

            function validaciones(){
                $('#fecha_publicacion').on('change', function () {
                    let fecha_inicio = $(this).val();
                    $('#fecha_vencimiento').attr('min', fecha_inicio);
                });
            }
        });
    </script>
@endsection
