@extends('layouts.auth')

@section('content')
    <div class="page-center-in">
        <div class="container-fluid">
            <div class="col-xl-4 offset-xl-4">
                <section class="box-typical steps-icon-block">
                    <div class="steps-icon-progress">
                        <ul>
                            <li id="step-one-icon" class="active">
                                <div class="icon">
                                    <i class="font-icon font-icon-user"></i>
                                </div>
                                <div class="caption">Validar código</div>
                            </li>
                            <li id="step-two-icon">
                                <div class="icon">
                                    <i class="font-icon font-icon-mail"></i>
                                </div>
                                <div class="caption">Correo electrónico</div>
                            </li>
                            <li id="step-three-icon">
                                <div class="icon">
                                    <i class="font-icon font-icon-check-bird"></i>
                                </div>
                                <div class="caption">Enviado</div>
                            </li>
                        </ul>
                    </div>
                    <div style="padding: 4px; margin-bottom: 10px;">
                        <img src="{{asset('img/logotipo.png')}}" alt="" width="70px">
                    </div>
                    <div id="step-one">
                        <form id="form-validar">
                            @csrf
                            <header class="steps-numeric-title">Validar código de estudiante</header>
                            <div class="form-group">
                                <input id="codigo" name="codigo" type="text" class="form-control" placeholder="Código"
                                       required/>
                            </div>
                            <div class="form-group">
                                <a href="#">Términos y condiciones</a>
                            </div>
                            <div class="form-group">
                                <a href="{{url('/login')}}" class="btn btn-rounded btn-success float-left"><i
                                        class="font-icon font-icon-lock"></i> Iniciar sesión
                                </a>
                                <button id="validar" type="button" class="btn btn-rounded float-right">Validar <i
                                        class="fa fa-arrow-right"></i></button>
                            </div>
                        </form>
                    </div>
                    <div id="step-two" style="display: none;">
                        <form id="form-correo">
                            @csrf
                            <header class="steps-numeric-header-in">Bienvenido,<br> <b id="nombre"></b><br>Ingresa tu
                                correo electrónico
                            </header>
                            <div class="form-group">
                                <input id="email" name="email" type="email" class="form-control"
                                       placeholder="Correo electrónico" required/>
                            </div>
                            <a href="{{route('register')}}" class="btn btn-rounded btn-grey float-left"><i
                                    class="fa fa-arrow-left"></i> Atrás
                            </a>
                            <button id="enviar-correo" type="button" class="btn btn-rounded float-right">Enviar correo
                                <i class="fa fa-arrow-right"></i></button>
                        </form>
                    </div>
                    <div id="step-three" style="display: none;">
                        <div class="alert alert-success alert-no-border">
                            <p>Link de acceso enviado enviado correctamente, revise su bandeja de entrada de su correo
                                <b id="correo"></b></p>
                        </div>
                        <a href="{{url('/')}}" class="btn btn-rounded btn-success float-left"><i
                                class="font-icon font-icon-lock"></i> Inicio
                        </a>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script type="text/javascript">
        $(document).ready(function () {
            var nombres;
            var codigo;
            validar_codigo();

            function validar_codigo() {
                $('#validar').on('click', function () {
                    if ($('#form-validar')[0].checkValidity()) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            type: 'POST',
                            url: '{{ route('validar') }}',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "codigo": $('#codigo').val(),
                            },
                            dataType: 'JSON',
                            beforeSend: function () {
                            },
                            success: function (response) {
                                if (response.success) {
                                    $.notify({
                                        icon: 'font-icon font-icon-check-circle',
                                        title: '<strong>¡Existoso!</strong>',
                                        message: 'Alumno identificado correctamente'
                                    }, {
                                        placement: {
                                            from: "top",
                                        },
                                        type: 'success'
                                    });
                                    $('#step-one').hide();
                                    $('#step-two').show();
                                    $('#step-two-icon').addClass('active');
                                    $('#nombre').html(response.data['nombres']);
                                    nombres = response.data['nombres'];
                                    codigo = $('#codigo').val();
                                    enviar_correo();

                                } else {
                                    $.notify({
                                        icon: 'font-icon font-icon-warning',
                                        title: '<strong>¡Error!</strong>',
                                        message: 'No encontramos ningún registro'
                                    }, {
                                        placement: {
                                            from: "top",
                                        },
                                        type: 'danger'
                                    });
                                }
                            },
                            error: function (err) {
                                console.log(err);
                            }
                        });
                    } else {
                        $('#codigo').focus();
                        $.notify({
                            icon: 'font-icon font-icon-warning',
                            title: '<strong>¡Error!</strong>',
                            message: 'Digite su código'
                        }, {
                            placement: {
                                from: "top",
                            },
                            type: 'danger'
                        });
                    }

                });
            }

            function enviar_correo() {
                $('#enviar-correo').on('click', function () {
                    if ($('#form-correo')[0].checkValidity()) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            type: 'POST',
                            url: '{{ route('enviar.correo') }}',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "email": $('#email').val(),
                                "nombres": nombres,
                                "codigo": codigo
                            },
                            dataType: 'JSON',
                            beforeSend: function () {
                            },
                            success: function (response) {
                                if (response.success) {
                                    $('#step-two').hide();
                                    $('#step-three').show();
                                    $('#step-three-icon').addClass('active');
                                    $('#correo').html($('#email').val());
                                } else {
                                    $.notify({
                                        icon: 'font-icon font-icon-warning',
                                        title: '<strong>¡Error!</strong>',
                                        message: 'No encontramos ningún registro'
                                    }, {
                                        placement: {
                                            from: "top",
                                        },
                                        type: 'danger'
                                    });
                                }
                            },
                            error: function (err) {
                                console.log(err);
                            }
                        });
                    } else {
                        $('#email').focus();
                        $.notify({
                            icon: 'font-icon font-icon-warning',
                            title: '<strong>¡Error!</strong>',
                            message: 'Ingrese un correo válido'
                        }, {
                            placement: {
                                from: "top",
                            },
                            type: 'danger'
                        });
                    }
                });
            }

        });
    </script>
@endsection
