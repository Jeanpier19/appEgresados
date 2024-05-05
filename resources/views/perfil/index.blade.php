@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{asset('startui/css/separate/pages/profile.min.css')}}">
@endsection
@section('content')
    <div class="container-fluid">
        <section class="card">
            <header class="card-header">
                <div class="pull-left">
                    <ol class="breadcrumb breadcrumb-simple">
                        <li><a href="{{route('home')}}">Inicio</a></li>
                        <li><a href="{{route('perfil.index')}}">Perfil</a></li>
                        <li class="active">Ver</li>
                    </ol>
                </div>
                <div class="pull-right">
                </div>
            </header>
            <div class="card-block">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-no-border alert-close alert-dismissible fade in">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <p>{{ $message }}</p>
                    </div>
                @endif
                <section class="box-typical">
                    <div class="profile-card">
                        <input id="codigo" type="hidden" value="{{$perfil->codigo}}">
                        <div class="avatar-preview avatar-preview-100 m-b-md">
                            <img src="@if($perfil && $perfil->avatar){{asset($perfil->avatar)}}@else{{asset('startui/img/avatar-1-256.png')}}@endif" alt="">
                        </div>
                        <div class="profile-card-name">{{$perfil->nombres}}</div>
                        <div class="profile-card-status">{{$perfil->paterno}} {{$perfil->materno}}</div>
                        <div class="profile-card-location">{{Auth::user()->getRoleNames()[0]}}</div>
                        <a href="{{$perfil->cv}}" type="button" class="btn btn-rounded" target="_blank">CV</a>
                        <div class="btn-group">
                            <button type="button"
                                    class="btn btn-rounded btn-primary-outline dropdown-toggle"
                                    data-toggle="dropdown"
                                    aria-haspopup="true"
                                    aria-expanded="false">
                                Perfil
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{route('perfil.edit',$perfil->id)}}"><span
                                        class="font-icon font-icon-pencil"></span>Editar</a>
                                <button type="button" class="dropdown-item" data-toggle="modal"
                                        data-target="#modal-avatar"><span
                                        class="font-icon font-icon-user"></span>Avatar
                                </button>
                            </div>
                        </div>
                    </div><!--.profile-card-->

                    <div class="profile-statistic tbl">
                        <div class="tbl-row">
                            <div class="tbl-cell">
                                <b>Código</b>
                                {{$perfil->codigo}}
                            </div>
                            <div class="tbl-cell">
                                <b>Usuario</b>
                                {{$perfil->usuario}}
                            </div>
                        </div>
                    </div>

                    <ul class="profile-links-list">
                        <li class="nowrap">
                            <i class="font-icon font-icon-mail"></i>
                            <a href="#">{{$perfil->email}}</a>
                        </li>
                        <li class="nowrap">
                            <i class="font-icon font-icon-phone"></i>
                            <a href="#">{{$perfil->telefono}} {{$perfil->celular}}</a>
                        </li>
                        <li class="nowrap">
                            <i class="font-icon font-icon-contacts"></i>
                            <a href="#">{{$perfil->direccional}}</a>
                        </li>
                        <li class="nowrap">
                            <i class="font-icon font-icon-editor-numeric-list"></i>
                            <a href="#">{{$perfil->num_documento}}</a>
                        </li>
                    </ul>
                </section><!--.box-typical-->
            </div>
        </section>
    </div>
    <div class="modal fade" id="modal-avatar" tabindex="-1" role="dialog" aria-labelledby="modalAvatar"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content ">
                <div class="modal-header">
                    <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                        <i class="font-icon-close-2"></i>
                    </button>
                    <h4 class="modal-title">Avatar</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <div class="form-group">
                                <strong>Avatar Actual:</strong>
                                @if($perfil->avatar)
                                    <img src="{{asset($perfil->avatar)}}" alt="" class="img-fluid img-thumbnail">
                                @else
                                    <img src="{{asset('img/default.png')}}" alt="" class="img-fluid img-thumbnail">
                                @endif
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6">
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
                <div class="modal-footer">
                    <button id="subir" type="button" class="btn btn-success btn-sm pull-left" data-dismiss="modal"><i
                            class="fa fa-upload"></i> Subir
                    </button>
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"><i
                            class="fa fa-close"></i> Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>
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
                            if (myDropzone.getQueuedFiles().length > 0) {
                                e.preventDefault();
                                e.stopPropagation();
                                myDropzone.processQueue();
                            } else {
                                myDropzone.uploadFiles([]); //send empty
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
                            $.notify({
                                icon: 'font-icon font-icon-warning',
                                title: '<strong>¡Exitoso!</strong>',
                                message: 'Avatar actualizando correctamente'
                            }, {
                                placement: {
                                    from: "top",
                                },
                                type: 'success'
                            });
                        });
                        this.on("success", function (file, response) {
                            myDropzone.processQueue.bind(myDropzone);
                            window.location.href = "{{ route('perfil.index')}}";
                        });
                    }
                });
            }
        });
    </script>
@endsection
