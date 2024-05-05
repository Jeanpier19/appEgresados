@extends('layouts.app')
@section('css')
@endsection
@section('content')
    <div class="container-fluid">
        <section class="card">
            <header class="card-header">
                <div class="pull-left">
                    <ol class="breadcrumb breadcrumb-simple">
                        <li><a href="{{route('home')}}">Inicio</a></li>
                        <li><a href="{{route('perfil.index')}}">Perfil</a></li>
                        <li class="active">Editar</li>
                    </ol>
                </div>
                <div class="pull-right">
                    <a href="{{route('perfil.index')}}" class="btn btn-inline btn-secondary btn-rounded btn-sm"><i
                            class="fa fa-angle-left"></i> Atrás</a>
                </div>
            </header>
            {!! Form::model($perfil, ['id'=>'perfil','method' => 'PATCH','route' => ['perfil.update', $perfil->id]]) !!}
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
                    <input id="cv" type="hidden" name="cv">
                    <input id="codigo" type="hidden" name="codigo" value="{{$perfil->codigo}}">
                    <div class="col-xs-12 col-sm-4 col-md-4">
                        <div class="form-group">
                            <strong>Apellido Paterno:</strong>
                            {!! Form::text('paterno', null, array('id'=>'paterno','placeholder' => 'Nombre','class' => 'form-control','required')) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4">
                        <div class="form-group">
                            <strong>Apellido Materno:</strong>
                            {!! Form::text('materno', null, array('id'=>'materno','placeholder' => 'Nombre','class' => 'form-control','required')) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4">
                        <div class="form-group">
                            <strong>Nombres:</strong>
                            {!! Form::text('nombres',null, array('id' => 'nombres','class' => 'form-control','placeholder'=>'Nombres','required')) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4">
                        <div class="form-group">
                            <strong>Teléfono:</strong>
                            {!! Form::text('telefono',null, array('id' => 'telefono','class' => 'form-control','placeholder'=>'Teléfono')) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4">
                        <div class="form-group">
                            <strong>Celular:</strong>
                            {!! Form::text('celular',null, array('id' => 'celular','class' => 'form-control','placeholder'=>'Celular')) !!}
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-2 col-md-2">
                        <div class="form-group">
                            <strong>Tipo documento:</strong>
                            {{ Form::select('tipo_documento',$tipo_documento->pluck('descripcion','id'), null, array('id' => 'tipo_documento','class' => 'bootstrap-select','title'=>'Seleccione...','required')) }}
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-2 col-md-2">
                        <div class="form-group">
                            <strong>N° Documento:</strong>
                            {!! Form::number('num_documento',null, array('id' => 'num_documento','class' => 'form-control','placeholder'=>'N° Documento','required','max' => 99999999,'min'=>0,'maxlength' => 10 )) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4">
                        <div class="form-group">
                            <strong>Dirección:</strong>
                            {!! Form::text('direccional',null, array('id' => 'correo','class' => 'form-control','placeholder'=>'Dirección')) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4">
                        <div class="form-group">
                            <strong>Sexo:</strong>
                            {{ Form::select('sexo',['Masculino'=>'Masculino','Femenino'=>'Femenino'], null, array('id' => 'sexo','class' => 'bootstrap-select','title'=>'Seleccione...')) }}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4">
                        <div class="form-group">
                            <strong>Usuario:</strong>
                            {!! Form::text('usuario',null, array('id' => 'usuario','class' => 'form-control','placeholder'=>'Usuario','required')) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-4 col-md-4">
                        <div class="form-group">
                            <strong>Correo electrónico:</strong>
                            {!! Form::email('correo',null, array('id' => 'correo','class' => 'form-control','placeholder'=>'Correo electrónico','required')) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4">
                        <div class="form-group">
                            <strong>Contraseña:</strong>
                            {!! Form::password('password', array('placeholder' => 'Contraseña','class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4">
                        <div class="form-group">
                            <strong>Confirmar Contraseña:</strong>
                            {!! Form::password('confirm-password', array('placeholder' => 'Confirmar Contraseña','class' => 'form-control')) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-2 col-md-2">
                        <div class="form-group">
                            <strong>CV Actual:</strong>
                            @if($perfil->cv)
                                <a href="{{asset($perfil->cv)}}" target="_blank"
                                   class="btn btn-secondary btn-sm"> <i class="fa fa-file-pdf-o"></i> Ver CV</a>
                            @else
                                <img src="{{asset('img/default.png')}}" alt="" class="img-fluid img-thumbnail">
                            @endif
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-10 col-md-10">
                        <strong>CV:</strong>
                        <div id="archivo" class="dropzone">
                            <div class="dz-default dz-message">
                                <div class="dz-icon">
                                    <i class="fa fa-file-pdf-o fa-3x text-danger"></i>
                                </div>
                                <div>
                                    <span class="dz-text">Arrastra tu CV para subir</span>
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
    </div>
@endsection
@section('js')
    <script type="text/javascript">
        Dropzone.autoDiscover = false;
        $(document).ready(function () {
            dropzone();
           // limit_string();

            function dropzone() {
                $('#archivo').dropzone({
                    url: '{{ route('perfil.cv.upload') }}',
                    enctype: 'multipart/form-data',
                    autoProcessQueue: false,
                    uploadMultiple: false,
                    maxFilezise: 5,
                    maxFiles: 1,
                    acceptedFiles: ".pdf",
                    init: function () {
                        var submitBtn = document.querySelector("#subir");
                        myDropzone = this;
                        submitBtn.addEventListener("click", function (e) {
                            if ($('#perfil')[0].checkValidity()) {
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
                            formData.append('codigo', $('#codigo').val());
                        });
                        this.on("complete", function (file) {
                        });
                        this.on("success", function (file, response) {
                            $('#cv').val(response['cv']);
                            myDropzone.processQueue.bind(myDropzone);
                            $('#perfil').submit();
                        });
                    }
                });
            }

            function limit_string(){
                $('#num_documento').keydown( function(e){
                    if ($(this).val().length >= 8) {
                        $(this).val($(this).val().substr(0, 8));
                    }
                }).keyup( function(e){
                    if ($(this).val().length >= 8) {
                        $(this).val($(this).val().substr(0, 8));
                    }
                });
            }
        });
    </script>
@endsection
