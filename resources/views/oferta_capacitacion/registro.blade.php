@extends('layouts.app')
@section('css')
    <link href="{{ asset('web/css/typeahead.min.css') }}" rel="stylesheet">
    <link href="{{ asset('web/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('web/css/main.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('web/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('web/css/profile.min.css') }}">

    <!-- Loading Template CSS -->
    <link href="{{ asset('web/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('web/css/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('web/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('web/css/style-magnific-popup.css') }}" rel="stylesheet">
    <style type="text/css">
        .students {
            font-size: 18px;
            font-weight: 600;
            color: #071e55;
        }

        .course-author {
            border-top: 1px solid #d4dee1;
            padding: 14px 33px;
            overflow: hidden;
        }

        .course-author p {
            padding-left: 60px;
            margin-bottom: 0;
            padding-top: 7px;
            font-weight: 600;
        }

        .course-author p span {
            color: #071e55;
        }

    </style>
@endsection
@section('content')
    <div class="container-fluid">
        {{-- @if ($ofertas_capacitaciones)
            <!--begin section-white -->
            <!-- course section -->
            <section class="section-white medium-padding-bottom">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h2>Capacitaciones en oferta</h2>
                    </div>
                </div>
                <div class="row">
                    <!-- course -->
                    <input type="hidden" value="{{ $var = 0 }}">
                    <input type="hidden" value="{{ $voucher = 0 }}">
                    <input type="hidden" value="{{ $vb = 0 }}">
                    @forelse ($ofertas_capacitaciones as $ofertas)
                        <div class="col-md-12">
                            <div class="blog-item" data-id="{{ $ofertas->id }}">
                                <img src="@if ($ofertas->imagen) {{ asset($ofertas->imagen) }} @else {{ asset('img/bg2.jpeg') }} @endif" class="width-100" alt="oferta">
                                <span class="eye-wrapper2"><i class="bi bi-link-45deg"></i></span>
                                <div class="blog-item-inner">
                                    <div class="blog-title">
                                        <h5>{{ $ofertas->titulo }}</h5>
                                        <a href="#" class="blog-icons last"><i class="bi bi-card-text"></i> Precio &#8212;
                                            @if ($ofertas->precio == 0)Gratuito @else {{ $ofertas->precio }} @endif</a>
                                        <p>{{ $ofertas->oferta_descripcion }}</p>
                                        <div class="students"># Alumnos:
                                            @if ($ofertas->total_alumnos)
                                                {{ $ofertas->total_alumnos }}
                                            @else
                                                0
                                            @endif
                                        </div>
                                    </div>
                                    <div class="course-author">
                                        <p class="text-center" style="padding-left:0px">Desarrollado por<br>
                                            <span>{{ $ofertas->nombre }}<span>
                                        </p>
                                    </div>
                                    @forelse ($alumno_ofertas as $alum_ofer)
                                        @if ($alum_ofer->alumno_id == $alumno_id && $alum_ofer->oferta_capacitaciones_id == $ofertas->id)
                                            <input type="hidden" value="{{ $var = 1 }}">
                                            @if (!empty($alum_ofer->voucher))
                                                <input type="hidden" value="{{ $voucher = 1 }}">
                                            @endif
                                            @if (empty($alum_ofer->vb) && $alum_ofer->vb != '0')
                                                <input type="hidden" value="{{ $vb = 0 }}">
                                            @endif
                                            @if ($alum_ofer->vb == '1')
                                                <input type="hidden" value="{{ $vb = 1 }}">
                                            @endif
                                            @if ($alum_ofer->vb == '0')
                                                <input type="hidden" value="{{ $vb = 2 }}">
                                            @endif
                                            @break
                                    @endif
                                @empty
                    @endforelse
                    @if ($var == 1)
                        @if ($voucher == 0)
                            <div class="btn col-lg-12 btn-inline btn-info voucher" data-alumno="{{ $alumno_id }}"
                                data-oferta="{{ $ofertas->id }}">Subir Voucher</div>
                            <div class="btn col-lg-12 btn-inline btn-danger minus" data-alumno="{{ $alumno_id }}"
                                data-oferta="{{ $ofertas->id }}">Eliminar Registro</div>
                        @else
                            @if ($vb == 0)
                                <div class="btn col-lg-12 btn-inline btn-default">Esperando Confirmación</div>
                            @endif
                            @if ($vb == 1)
                                <div class="btn col-lg-12 btn-inline btn-primary">Registro Validado</div>
                            @endif
                            @if ($vb == 2)
                                <div class="btn col-lg-12 btn-inline btn-info voucher" data-alumno="{{ $alumno_id }}"
                                    data-oferta="{{ $ofertas->id }}">Subir Voucher
                                </div>
                                <div class="btn col-lg-12 btn-inline btn-danger">Registro Invalidado</div>
                            @endif
                        @endif
                    @endif
                    @if ($var == 0)
                        <div class="btn col-lg-12 btn-inline btn-success add" data-alumno="{{ $alumno_id }}"
                            data-oferta="{{ $ofertas->id }}">Registrarse</div>
                    @endif
                </div>
    </div>
    </div>
@empty
    <div class="section-title mb-0">
        <p>En este momento no hay capacitaciones disponibles, seguiremos trabajando para
            darte el mejor servicio.</p>
    </div>
    @endforelse


    </div>
    </section>
    <!--end section-white -->
    @endif --}}
        @if ($ofertas_capacitaciones)
            <section class="section-white medium-padding-bottom" id="blog">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h2>Capacitaciones en oferta</h2>
                            <p>En esta sección se presentan algunos cursos de capacitaciones ofertadas por empresas de
                                nuestro
                                pais asi como de nuestra universidad.</p>
                        </div>
                    </div>
                    <div class="row">
                        @forelse ($ofertas_capacitaciones as $ofertas)
                            <input type="hidden" value="{{ $var = 0 }}">
                            <input type="hidden" value="{{ $voucher = 0 }}">
                            <input type="hidden" value="{{ $vb = 0 }}">
                            <input type="hidden" value="{{ $vb_apreciacion = 0 }}">
                            <input type="hidden" value="{{ $certificado = '' }}">
                            <div class="col-md-4">
                                <div class="blog-item">
                                    <div class="popup-wrapper">
                                        <div class="popup-gallery">
                                            <a href="#">
                                                <img
                                                src="@if($ofertas->imagen) {{asset($ofertas->imagen)}} @else {{asset('img/bg2.jpeg')}} @endif"
                                                class="width-100" alt="oferta">
                                                <span class="eye-wrapper2"><i class="bi bi-link-45deg"></i></span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="blog-item-inner">
                                        <h3 class="blog-title"><a href="#">{{ $ofertas->titulo }}</a></h3>
                                        <a href="#" class="blog-icons last"><i class="bi bi-card-text"></i> Precio &#8212;
                                            @if ($ofertas->precio == 0)Gratuito @else {{ $ofertas->precio }} @endif</a>
                                        <p>{{ $ofertas->oferta_descripcion }}</p>
                                        <div class="students"># Alumnos:
                                            @if ($ofertas->total_alumnos)
                                                {{ $ofertas->total_alumnos }}
                                            @else
                                                0
                                            @endif
                                        </div>
                                        <div class="course-author">
                                            <p class="text-center" style="padding-left:0px">Desarrollado por<br>
                                                <span>{{ $ofertas->entidad }}<span>
                                            </p>
                                        </div>

                                        @foreach ($alumno_ofertas as $alum_ofer)
                                            @if ($alum_ofer->alumno_id == $alumno_id && $alum_ofer->oferta_capacitaciones_id == $ofertas->idoferta)
                                                <input type="hidden" value="{{ $var = 1 }}">
                                                @if (!empty($alum_ofer->voucher))
                                                    <input type="hidden" value="{{ $voucher = 1 }}">
                                                @endif
                                                @if (empty($alum_ofer->vb) && $alum_ofer->vb != '0')
                                                    <input type="hidden" value="{{ $vb = 0 }}">
                                                @endif
                                                @if ($alum_ofer->vb == '1')
                                                    <input type="hidden" value="{{ $vb = 1 }}">
                                                @endif
                                                @if ($alum_ofer->vb == '0')
                                                    <input type="hidden" value="{{ $vb = 2 }}">
                                                @endif
                                                @if ($alum_ofer->vb_apreciacion == '1')
                                                    <input type="hidden" value="{{ $vb_apreciacion = 1 }}">
                                                @endif
                                                @if (!empty($alum_ofer->certificado))
                                                    <input type="hidden" value="{{ $certificado = $alum_ofer->certificado }}">
                                                @endif
                                            @break
                                        @endif
                        @endforeach
                        @if(strtotime($ofertas->fecha_inicio) < strtotime(date("d-m-Y H:i:00", time())) && strtotime($ofertas->fecha_fin) > strtotime(date("d-m-Y H:i:00", time())))
                        <div class="btn col-lg-12 btn-inline btn-default"><i>Incripcion Cerrada</i></div>
                        @if ($vb == 1)
                        <div class="btn col-lg-12 btn-inline btn-info">Matriculado</div>
                    @endif
                        @endif

                        @if(strtotime($ofertas->fecha_fin) < strtotime(date("d-m-Y H:i:00", time())))
                                    <div class="btn col-lg-12 btn-inline btn-danger"><i>Curso Cerrado</i></div>

                                @if ($vb_apreciacion == 1)
                                        @if(empty($certificado))
                                        <div class="btn col-lg-12 btn-inline btn-info">Esperando Constancia</div>
                                        @else
                                        <a href="{{route('alumno_ofertas.get-certificado',$certificado)}}" target="_blank" class="scrool">
                                            <div class="btn col-lg-12 btn-inline btn-success">Descargar Constancia</div>
                                        </a>
                                        @endif
                                @else
                                @if ($vb == 1)
                                    <div class="btn col-lg-12 btn-inline btn-primary constancia" data-alumno="{{ $alumno_id }}"
                                    data-oferta="{{ $ofertas->idoferta }}">Completar para constancia</div>
                                    @endif
                                @endif
                        @endif

                        @if(strtotime($ofertas->fecha_inicio) > strtotime(date("d-m-Y H:i:00", time())))
                                @if ($var == 1)
                            @if ($voucher == 0)
                                <div class="btn col-lg-12 btn-inline btn-info voucher" data-alumno="{{ $alumno_id }}"
                                    data-oferta="{{ $ofertas->idoferta }}">Subir Voucher</div>
                                <div class="btn col-lg-12 btn-inline btn-danger minus" data-alumno="{{ $alumno_id }}"
                                    data-oferta="{{ $ofertas->idoferta }}">Eliminar Registro</div>
                            @else
                                @if ($vb == 0)
                                    <div class="btn col-lg-12 btn-inline btn-default">Esperando Confirmación</div>
                                @endif
                                @if ($vb == 1)
                                    <div class="btn col-lg-12 btn-inline btn-primary">Registro Validado</div>
                                @endif
                                @if ($vb == 2)
                                    <div class="btn col-lg-12 btn-inline btn-info voucher"
                                        data-alumno="{{ $alumno_id }}" data-oferta="{{ $ofertas->idoferta }}">Subir Voucher
                                    </div>
                                    <div class="btn col-lg-12 btn-inline btn-danger">Registro Invalidado</div>
                                @endif
                            @endif
                        @endif
                        @if ($var == 0)
                            <div class="btn col-lg-12 btn-inline btn-success add" data-alumno="{{ $alumno_id }}"
                                data-oferta="{{ $ofertas->idoferta }}">Registrarse</div>
                        @endif
                                @endif

                    </div>
                </div>
    </div>
    @empty
        <p class="text-muted text-center">En este momento no hay capacitaciones disponibles, seguiremos
            trabajando para darte el mejor servicio.</p>
        @endforelse
        </div>
        </div>
        </section>
        @endif

        </div>
        <div class="modal fade" id="modal-voucher" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                            <i class="font-icon-close-2"></i>
                        </button>
                        <h4 class="modal-title" id="myModalLabel-curso">Subir voucher</h4>
                    </div>
                    <div class="modal-body">
                        {!! Form::open(['method' => 'POST', 'route' => 'alumno_ofertas.subir-voucher', 'id' => 'form-voucher', 'file' => true, 'enctype' => 'multipart/form-data']) !!}
                        <div class="card-block">
                            <div class="row">
                                <strong>Porfavor suba su voucher en formato digital (.jpg o .pdf) del pago
                                    correspondiente...</strong>
                                <div class="col-xs-10 col-sm-10 col-md-10">
                                    {!! Form::hidden('alumno_id', null, ['class' => 'form-control', 'id' => 'alumno_id']) !!}
                                    {!! Form::hidden('oferta_id', null, ['class' => 'form-control', 'id' => 'oferta_id']) !!}
                                    <div class="form-group">
                                        <br>
                                        <br>
                                        {!! Form::file('voucher', null, ['placeholder' => 'Subir aqui', 'class' => 'form-control', 'id' => 'voucher']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-rounded btn-primary" id="send-voucher">Subir</button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal-apreciacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                            <i class="font-icon-close-2"></i>
                        </button>
                        <h4 class="modal-title" id="myModalLabel-curso">Porfavor complete esta encuesta para poder continuar...</h4>
                    </div>
                    <div class="modal-body">
                        {!! Form::open(['method' => 'PATCH', 'route' => 'alumno_ofertas.update-apreciacion', 'id' => 'form-voucher']) !!}
                        <div class="card-block">
                            <div class="row">
                                {!! Form::hidden('alumno_id', null, ['class' => 'form-control', 'id' => 'a_alumno_id']) !!}
                                    {!! Form::hidden('oferta_id', null, ['class' => 'form-control', 'id' => 'a_oferta_id']) !!}
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <strong>¿Le pareció agradable la temática de estudio?</strong>
                                    <div class="form-group">
                                        {!! Form::select('pregunta1', $apreciacion, ['placeholder' => 'Seleccionar', 'class' => 'form-control select2', 'id' => 'pregunta2','required']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <strong>¿Cómo calificaria usted la enseñanza impartida por el docente??</strong>
                                    <div class="form-group">
                                        {!! Form::select('pregunta2',$apreciacion, ['placeholder' => 'Seleccionar', 'class' => 'form-control select2', 'id' => 'pregunta3','required']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <strong>De manera general, califique la capacitación recibida</strong>
                                    <div class="form-group">
                                        {!! Form::select('pregunta3', $apreciacion, ['placeholder' => 'Seleccionar', 'class' => 'form-control select2', 'id' => 'pregunta3','required']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <strong>Recomendación y/o Apreciación:</strong>
                                    <div class="form-group">
                                        {!! Form::textarea('pregunta4', null, ['placeholder' => 'Ejm: Recomiendo que...', 'class' => 'form-control', 'id' => 'pregunta4','required']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-rounded btn-primary" id="send-apreciacion">Enviar</button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>

    @endsection
    @section('js')
        <script src="{{ asset('web/js/jquery.typeahead.min.js') }}"></script>
        <script src="{{ asset('web/js/select2.full.min.js') }}"></script>
        <script src="{{ asset('web/js/slick.min.js') }}"></script>
        <script type="text/javascript">
            $('.set-bg').each(function() {
                var bg = $(this).data('setbg');
                $(this).css('background-image', 'url(' + bg + ')');
            });

            $('.add').on('click', function() {
                let alumno_id = $(this).attr('data-alumno');
                let oferta_id = $(this).attr('data-oferta');
                swal({
                        title: '¿Confirmar Inscripción?',
                        text: "",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonClass: "btn-success",
                        confirmButtonText: '!Si, deseo registrarme!',
                        cancelButtonText: 'Cancelar',
                        closeOnConfirm: false,
                        closeOnCancel: false
                    },
                    function(isConfirm) {
                        if (isConfirm) {
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            $.ajax({
                                type: 'POST',
                                url: '{!! route('alumno_ofertas.registro') !!}',
                                data: {
                                    "_token": "{{ csrf_token() }}",
                                    "_method": 'POST',
                                    "alumno_id": alumno_id,
                                    "ofertas_id": oferta_id
                                },
                                dataType: 'JSON',
                                beforeSend: function() {},
                                success: function(response) {
                                    if (response.success) {
                                        $.notify({
                                            icon: 'font-icon font-icon-check-circle',
                                            title: '<strong>¡Existoso!</strong>',
                                            message: 'Registro completado'
                                        }, {
                                            placement: {
                                                from: "top",
                                            },
                                            type: 'success'
                                        });
                                        window.location = '{!! url('gape/gestion-egresado/ofertas_capacitacion/registro') !!}/';
                                    } else {
                                        $.notify({
                                            icon: 'font-icon font-icon-warning',
                                            title: '<strong>¡Error!</strong>',
                                            message: 'Hubo un error al registrarse'
                                        }, {
                                            placement: {
                                                from: "top",
                                            },
                                            type: 'danger'
                                        });
                                    }
                                    swal.close()
                                },
                                error: function(err) {
                                    console.log(err);
                                }
                            });
                        } else {
                            swal({
                                title: "Cancelado",
                                text: "Usted canceló el registro",
                                type: "error",
                                confirmButtonClass: "btn-danger"
                            });
                        }
                    });
                //window.location ='{!! url('gape/gestion-egresado/ofertas_capacitacion/registro') !!}/' + id;

            });

            $('.minus').on('click', function() {
                let alumno_id = $(this).attr('data-alumno');
                let oferta_id = $(this).attr('data-oferta');
                swal({
                        title: '¿Eliminar Inscripción?',
                        text: "",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: '!Si, deseo eliminar inscripción!',
                        cancelButtonText: 'Cancelar',
                        closeOnConfirm: false,
                        closeOnCancel: false
                    },
                    function(isConfirm) {
                        if (isConfirm) {
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            $.ajax({
                                type: 'POST',
                                url: '{!! route('alumno_ofertas.eliminar') !!}',
                                data: {
                                    "_token": "{{ csrf_token() }}",
                                    "_method": 'POST',
                                    "alumno_id": alumno_id,
                                    "ofertas_id": oferta_id
                                },
                                dataType: 'JSON',
                                beforeSend: function() {},
                                success: function(response) {
                                    if (response.success) {
                                        $.notify({
                                            icon: 'font-icon font-icon-check-circle',
                                            title: '<strong>¡Existoso!</strong>',
                                            message: 'Registro Eliminado'
                                        }, {
                                            placement: {
                                                from: "top",
                                            },
                                            type: 'success'
                                        });
                                        window.location = '{!! url('gape/gestion-egresado/ofertas_capacitacion/registro') !!}/';
                                    } else {
                                        $.notify({
                                            icon: 'font-icon font-icon-warning',
                                            title: '<strong>¡Error!</strong>',
                                            message: 'Hubo un error al eliminar el registro'
                                        }, {
                                            placement: {
                                                from: "top",
                                            },
                                            type: 'danger'
                                        });
                                    }
                                    swal.close()
                                },
                                error: function(err) {
                                    console.log(err);
                                }
                            });
                        } else {
                            swal({
                                title: "Cancelado",
                                text: "Usted canceló el registro",
                                type: "error",
                                confirmButtonClass: "btn-danger"
                            });
                        }
                    });
                //window.location ='{!! url('gape/gestion-egresado/ofertas_capacitacion/registro') !!}/' + id;

            });

            $('.voucher').on('click', function() {
                let alumno_id = $(this).attr('data-alumno');
                let oferta_id = $(this).attr('data-oferta');
                $('#alumno_id').val(alumno_id);
                $('#oferta_id').val(oferta_id);
                $('#modal-voucher').modal('show');
            });

            $('.constancia').on('click', function() {
                let alumno_id = $(this).attr('data-alumno');
                let oferta_id = $(this).attr('data-oferta');
                $('#a_alumno_id').val(alumno_id);
                $('#a_oferta_id').val(oferta_id);
                $('#modal-apreciacion').modal('show');
            });


        </script>
    @endsection
