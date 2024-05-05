@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <section class="card">
            <header class="card-header">
                <div class="pull-left">
                    <ol class="breadcrumb breadcrumb-simple">
                        <li><a href="{{route('home')}}">Inicio</a></li>
                        <li><a href="{{route('usuarios.index')}}">Usuarios</a></li>
                        <li class="active">Editar</li>
                    </ol>
                </div>
                <div class="pull-right">
                    <a href="{{route('usuarios.index')}}" class="btn btn-inline btn-secondary btn-rounded btn-sm"><i
                            class="fa fa-angle-left"></i> Atrás</a>
                </div>
            </header>
            {!! Form::model($user, ['id'=>'usuarios','method' => 'PATCH','route' => ['usuarios.update', $user->id]]) !!}
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
                    <input id="avatar" type="hidden" name="avatar">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Nombre:</strong>
                            {!! Form::text('name', null, array('id'=>'name','placeholder' => 'Nombre','class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Correo Electrónico:</strong>
                            {!! Form::text('email', null, array('placeholder' => 'Correo Electrónico','class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Contraseña:</strong>
                            {!! Form::password('password', array('placeholder' => 'Contraseña','class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Confirmar Contraseña:</strong>
                            {!! Form::password('confirm-password', array('placeholder' => 'Confirmar Contraseña','class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Rol:</strong>
                            {!! Form::select('roles[]', $roles,$userRole, array('class' => 'bootstrap-select','multiple','title'=>'Elige uno de los siguientes...')) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-2 col-md-2">
                        <div class="form-group">
                            <strong>Avatar Actual:</strong><br>
                            @if($user->avatar)
                                <img src="{{asset($user->avatar)}}" alt="" class="img-fluid img-thumbnail">
                            @else
                                <img src="{{asset('img/default.png')}}" alt="" class="img-fluid img-thumbnail">
                            @endif
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-10 col-md-10">
                        <strong>Avatar:</strong>
                        <div id="archivo" class="dropzone">
                            <div class="dz-default dz-message">
                                <div class="dz-icon">
                                    <i class="fa fa-file-image-o fa-3x text-info"></i>
                                </div>
                                <div>
                                    <span class="dz-text">Arrastra una imagen para subir</span>
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
                <button id="subir" type="submit" class="btn btn-primary btn-sm"><i class="fa fa-save"></i> Guardar</button>
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
            function dropzone() {
                $('#archivo').dropzone({
                    url: '{{ route('perfil.avatar.upload') }}',
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
                            if ($('#usuarios')[0].checkValidity()) {
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
                            formData.append('codigo', $('#name').val());
                        });
                        this.on("complete", function (file) {
                        });
                        this.on("success", function (file, response) {
                            $('#avatar').val(response['avatar']);
                            myDropzone.processQueue.bind(myDropzone);
                            $('#usuarios').submit();
                        });
                    }
                });
            }
        });
    </script>
@endsection
