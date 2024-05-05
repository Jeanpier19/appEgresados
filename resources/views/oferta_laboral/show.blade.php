@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <section class="card">
            <header class="card-header">
                <div class="pull-left">
                    <ol class="breadcrumb breadcrumb-simple">
                        <li><a href="{{route('home')}}">Inicio</a></li>
                        <li><a href="{{route('ofertas_laborales.index')}}">Ofertas Laborales</a></li>
                        <li class="active">Ver</li>
                    </ol>
                </div>
                <div class="pull-right">
                    <a href="{{route('ofertas_laborales.index')}}"
                       class="btn btn-inline btn-secondary btn-rounded btn-sm"><i
                            class="fa fa-angle-left"></i> Atrás</a>
                </div>
            </header>
            <div class="card-block">
                <div class="row">
                    @role('Egresado')
                    <div id="postulado" class="col-xs-12 col-sm-12 col-md-12">
                        @if($oferta_laboral->estado===1)
                            @if($verificar)
                                <div class="alert alert-info alert-no-border">
                                    <p>Ya postulaste a esta oferta laboral el
                                        <b>{{\Carbon\Carbon::create($verificar->created_at)->formatLocalized('%A %d de %B  de %Y')}}</b>
                                    </p>
                                </div>
                            @else
                                <div class="form-group pull-right">
                                    <button id="postularme" type="button" class="btn btn-primary btn-rounded"
                                            data-id="{{$oferta_laboral->id}}">Postularme
                                    </button>
                                </div>
                            @endif
                        @endif
                    </div>
                    @endrole
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="form-group">
                            @if($oferta_laboral->estado===1)
                                <label for="" class="label label-success">Abierto</label>
                            @else
                                <label for="" class="label label-default">Cerrado</label>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Entidad:</strong>
                            {{ $oferta_laboral->entidad }}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Título:</strong>
                            {{ $oferta_laboral->titulo }}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Área:</strong>
                            {{ $oferta_laboral->area }}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Jornada:</strong>
                            {{ $oferta_laboral->jornada }}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Tipo:</strong>
                            {{ $oferta_laboral->tipo }}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Fecha de contratación:</strong>
                            {{ \Carbon\Carbon::create($oferta_laboral->fecha_contratacion)->format('d-m-Y') }}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6">
                        <div class="form-group">
                            <strong>Vacantes:</strong>
                            {{ $oferta_laboral->vacantes }}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="form-group">
                            <strong>Salario:</strong>
                            S/ {{ $oferta_laboral->salario }}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Perfil:</strong>
                            {{ $oferta_laboral->perfil }}
                        </div>
                    </div>
                    @role('Administrador')
                    <div class="col-xs-12 col-sm-12 col-md-6">
                        <div class="form-group">
                            <strong>Fecha de publicación:</strong>
                            {{ \Carbon\Carbon::create($oferta_laboral->fecha_publicacion)->format('d-m-Y') }}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="form-group">
                            <strong>Fecha de vencimiento:</strong>
                            {{ \Carbon\Carbon::create($oferta_laboral->fecha_vencimiento)->format('d-m-Y') }}
                        </div>
                    </div>
                    @endrole
                    @if($oferta_laboral->documento)
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Documento:</strong>
                                <a href="{{asset($oferta_laboral->documento)}}" class="btn btn-info btn-sm"
                                   target="_blank"><i
                                        class="fa fa-file-pdf-o"></i> Ver</a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </div><!--.container-fluid-->
@endsection
@section('js')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#postularme').on('click', function () {
                let id = $(this).attr('data-id');
                swal({
                        title: '¿Quieres postular a esta oferta laboral?',
                        text: "¡Se enviará tu información a la empresa ofertante!",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonClass: "btn-success",
                        confirmButtonText: '!Si, postular!',
                        cancelButtonText: 'Aún no',
                        closeOnConfirm: false,
                        closeOnCancel: false
                    },
                    function (isConfirm) {
                        if (isConfirm) {
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            $.ajax({
                                "url": "{{ route('ofertas_laborales.postular') }}",
                                "dataType": "json",
                                "type": "POST",
                                "data": {
                                    _token: "{{csrf_token()}}",
                                    oferta_id: id
                                },
                                beforeSend: function () {
                                },
                                success: function (response) {
                                    if (response.success) {
                                        $.notify({
                                            icon: 'font-icon font-icon-check-circle',
                                            title: '<strong>¡Existoso!</strong>',
                                            message: 'Tu postulación ha sido enviada'
                                        }, {
                                            placement: {
                                                from: "top",
                                            },
                                            type: 'success'
                                        });
                                        $('#postulado').html('<div class="alert alert-info alert-no-border"><p>Acabas de postular a esta oferta laboral</b></p> </div>')
                                    } else {
                                        $.notify({
                                            icon: 'font-icon font-icon-warning',
                                            title: '<strong>¡Error!</strong>',
                                            message: 'Hubo un error al enviar tu postulación, inténtelo nuevamente'
                                        }, {
                                            placement: {
                                                from: "top",
                                            },
                                            type: 'danger'
                                        });
                                    }
                                    swal.close()
                                },
                                error: function (err) {
                                    console.log(err);
                                }
                            });
                        } else {
                            swal.close()
                        }
                    });
            });
        });
    </script>
@endsection
