@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <section class="card">
            <header class="card-header">
                <div class="pull-left">
                    <ol class="breadcrumb breadcrumb-simple">
                        <li><i class="glyphicon glyphicon-list-alt"></i></li>
                        <li><a href="{{route('home')}}">Inicio</a></li>
                        <li><a href="{{route('encuestas.index')}}">Encuestas</a></li>
                        <li class="active">Preguntas</li>
                    </ol>
                </div>
                <div class="pull-right">
                    <a href="{{route('encuestas.index')}}" class="btn btn-inline btn-secondary btn-rounded btn-sm"><i
                            class="fa fa-angle-left"></i> Atrás</a>
                </div>
            </header>
            {!! Form::open(array('route' => 'encuestas.preguntas.store','method'=>'POST')) !!}
            <input name="encuesta" type="hidden" value="{{$id}}">
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
                    <div class="modal-upload">
                        <div class="modal-upload-cont">
                            <div class="modal-upload-cont-in">
                                <div id="tab-content" class="tab-content">
                                    @if(isset($grupos))
                                        @foreach($grupos as $grupo)
                                            <div role="tabpanel" class="tab-pane" id="tab-{{$grupo->grupo}}">
                                                <div class="col-xs-12">
                                                    <div class="form-group">
                                                        <button type="button"
                                                                class="btn btn-inline btn-primary btn-rounded btn-sm add_preguntas"
                                                                data-toggle="modal" data-target="#modal_preguntas"
                                                                data-grupo="{{$grupo->grupo}}"
                                                                data-nombregrupo="{{$grupo->nombre_grupo}}"><i
                                                                class="fa fa-plus-circle"></i> Pregunta
                                                        </button>
                                                    </div>
                                                </div>
                                                @foreach($preguntas as $pregunta)
                                                    @if($pregunta->grupo == $grupo->grupo)
                                                        <div class="col-xs-12">
                                                            <div class="col-xs-10">
                                                                <div class="form-group">
                                                                    <span>{{$pregunta->titulo}}</span><b><em
                                                                            class="text-success"
                                                                            style="font-size: 12px;">
                                                                            ({{$pregunta->tipo}})</em></b>
                                                                    @if($pregunta->tipo === 'Opción multiple')
                                                                        <div class="checkbox-bird">
                                                                            @foreach(json_decode($pregunta->opciones) as $opcion)
                                                                                <input type="checkbox"/>
                                                                                <label>{{$opcion}}</label>
                                                                            @endforeach
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-2 text-center">
                                                                <button type="button"
                                                                        class="btn btn-danger btn-rounded btn-sm eliminar_pregunta"
                                                                        data-id="{{$pregunta->id}}"
                                                                        data-grupo="{{$pregunta->grupo}}"><i
                                                                        class="fa fa-trash"></i></button>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="modal-upload-side">
                            <ul id="lista" class="upload-list" role="tablist">
                                @if(isset($grupos))
                                    @foreach($grupos as $grupo)
                                        <li class="nav-item">
                                            <button type="button"
                                                    class="btn btn-danger btn-xs btn-rounded pull-right eliminar_grupo"
                                                    data-grupo="{{$grupo->grupo}}"><i class="fa fa-close"></i>
                                            </button>
                                            <a id="li-{{$grupo->grupo}}" href="#tab-{{$grupo->grupo}}" role="tab"
                                               data-toggle="tab"><span>{{$grupo->nombre_grupo}}</span></a></li>
                                    @endforeach
                                @endif
                            </ul>
                            <button id="add_grupo" type="button" class="btn btn-inline btn-info btn-rounded btn-sm"><i
                                    class="fa fa-plus-circle"></i> Grupo
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div id="preguntas"></div>
                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-save"></i> Guardar</button>
            </div>
            {!! Form::close() !!}
        </section>
    </div>
    <div class="modal fade" id="modal_preguntas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                        <i class="font-icon-close-2"></i>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Banco de preguntas</h4>
                </div>
                <div class="modal-body">
                    <table id="table" class="display table table-xs table-striped table-bordered " cellspacing="0"
                           width="100%">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Pregunta</th>
                            <th>Opción</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script type="text/javascript">
        $(document).ready(function () {
            var numero_grupo = 0;
            var preguntas = [];
            var grupo_activo;
            var nombre_grupo;
            @if(count($preguntas)>0)
            remove_grupo();
            remove_pregunta();
            numero_grupo = parseInt('{{$last_group->grupo}}') + 1;
            grupo_activo = '{{$last_group->grupo}}';
            nombre_grupo = '{{$last_group->nombre_grupo}}';
            // Activar los tabs
            $('#tab-' + grupo_activo).addClass('active');
            $('#li-' + grupo_activo).addClass('active');
            // Cargamos las preguntas
            var pr = @json($preguntas);
            $.each(pr, function (index, value) {
                preguntas.push({
                    'id': value['pregunta_id'],
                    'grupo': value['grupo'],
                    'nombre_grupo': value['nombre_grupo']
                })
            });
            enviar_preguntas();
            @endif
            cargar_preguntas();
            add_grupo();
            add_pregunta();

            function add_grupo() {
                $('#add_grupo').on('click', function () {
                    swal({
                        title: "Nuevo Grupo",
                        text: "Escribe el nombre del grupo",
                        type: "input",
                        showCancelButton: true,
                        closeOnConfirm: false,
                        inputPlaceholder: "Escribe el nombre del grupo"
                    }, function (inputValue) {
                        if (inputValue === false) return false;
                        if (inputValue === "") {
                            swal.showInputError("Necesita escribir el nombre del grupo");
                            return false
                        }
                        $('#lista').append('<li class="nav-item"><button type="button" class="btn btn-danger btn-xs btn-rounded pull-right eliminar_grupo" data-grupo="' + numero_grupo + '"><i class="fa fa-close"></i></button> <a id="li-' + numero_grupo + '" href="#tab-' + numero_grupo + '" role="tab" data-toggle="tab" class="active"><span>' + inputValue + '</span></a></li>');
                        $('#tab-content').append('<div role="tabpanel" class="tab-pane active" id="tab-' + numero_grupo + '"> <div class="col-xs-12"><div class="form-group"><button type="button" class="btn btn-inline btn-primary btn-rounded btn-sm add_preguntas" data-toggle="modal" data-target="#modal_preguntas" data-grupo="' + numero_grupo + '" data-nombregrupo="' + inputValue + '"><i class="fa fa-plus-circle"></i> Pregunta </button></div></div></div>')
                        for (let i = 0; i < numero_grupo; i++) {
                            $('#tab-' + i).removeClass('active');
                            $('#li-' + i).removeClass('active');
                        }
                        numero_grupo++;
                        remove_grupo();
                        seleccionar_grupo();
                        swal("¡Excelente!", "Escribiste: " + inputValue, "success");
                    });

                });
            }

            function cargar_preguntas() {
                let tabla = $('#table').DataTable(
                    {
                        responsive: true,
                        "processing": true,
                        "serverSide": true,
                        language: {
                            "decimal": "",
                            "emptyTable": "No hay información",
                            "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                            "infoEmpty": "Mostrando 0 a 0 de 0 Entradas",
                            "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                            "infoPostFix": "",
                            "thousands": ",",
                            "lengthMenu": "Mostrar _MENU_ Entradas",
                            "loadingRecords": "Cargando...",
                            "processing": "Procesando...",
                            "search": "Buscar:",
                            "zeroRecords": "Sin resultados encontrados",
                            "No results matched": "No se encontraron resultados",
                            "paginate": {
                                "first": "Primero",
                                "last": "Ultimo",
                                "next": "Siguiente",
                                "previous": "Anterior"
                            },
                        },
                        "ajax": {
                            "url": "{{ route('preguntas.all') }}",
                            "dataType": "json",
                            "type": "POST",
                            "data": {
                                _token: "{{csrf_token()}}",
                                'activo': true
                            }
                        },
                        "columns": [
                            {"data": "id"},
                            {"data": "titulo"},
                            {"data": "option"}
                        ],
                        "columnDefs": [
                            {"className": "text-center", "targets": [0, 2]},
                            {"bSortable": false, "aTargets": [2]},
                        ],
                    }
                );
            }

            function seleccionar_grupo() {
                $('.add_preguntas').off('click').on('click', function () {
                    grupo_activo = $(this).attr('data-grupo');
                    nombre_grupo = $(this).attr('data-nombregrupo');
                });
            }

            function add_pregunta() {
                $('#table tbody').on('click', '.add_pregunta', function () {
                    // Ocultamos modal
                    $('#modal_preguntas').modal('hide');
                    let id = $(this).attr('data-id');
                    //verificamos si la pregunta ya se agregó a la encuesta
                    let existe = true;
                    $.each(preguntas, function (index, value) {
                        if (value['id'] == id) {
                            existe = false;
                        }
                    });
                    if (existe) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            type: 'POST',
                            url: '{{route('preguntas.get_pregunta')}}',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "id": id
                            },
                            dataType: 'JSON',
                            beforeSend: function () {
                            },
                            success: function (response) {
                                if (response) {
                                    // Agregamos al array
                                    preguntas.push({
                                        'id': response.id,
                                        'grupo': grupo_activo,
                                        'nombre_grupo': nombre_grupo
                                    });
                                    // Dijuamos la pregunta
                                    let descripcion = '<div class="col-xs-12"><div class="col-xs-10"><div class="form-group"><span>' + response.titulo + '</span><b><em class="text-success" style="font-size: 12px;"> (' + response.tipo + ')</em></b><div class="checkbox-bird">';
                                    if (response.tipo == 'Opción multiple' || response.tipo == 'Casilla de verificación') {
                                        let opciones = JSON.parse(response.opciones);
                                        for (var i = 0; i < opciones.length; i++) {
                                            descripcion += '<input type="checkbox"/><label>' + opciones[i] + '</label>';
                                        }
                                    }
                                    descripcion += '</div></div></div><div class="col-xs-2 text-center"><button type="button" class="btn btn-danger btn-rounded btn-sm eliminar_pregunta" data-id="' + response.id + '" data-grupo="' + grupo_activo + '"><i class="fa fa-trash"></i></button></div><div>';
                                    $('#tab-' + grupo_activo).append(descripcion);
                                    remove_pregunta();
                                    enviar_preguntas();
                                    // Mostramos un mensaje
                                    $.notify({
                                        icon: 'font-icon font-icon-check-circle',
                                        title: '<strong>¡Existoso!</strong>',
                                        message: 'Pregunta agregada correctamente'
                                    }, {
                                        placement: {
                                            from: "top",
                                        },
                                        type: 'success'
                                    });
                                } else {
                                    $.notify({
                                        icon: 'font-icon font-icon-warning',
                                        title: '<strong>¡Error!</strong>',
                                        message: 'Hubo un error al agregar la pregunta'
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
                        $.notify({
                            icon: 'font-icon font-icon-warning',
                            title: '<strong>¡Error!</strong>',
                            message: 'La pregunta ya está agregada'
                        }, {
                            placement: {
                                from: "top",
                            },
                            type: 'danger'
                        });
                    }

                });
            }

            function remove_pregunta() {
                $('.eliminar_pregunta').off('click').on('click', function () {
                    $(this).parent().parent().remove();
                    let id = $(this).attr('data-id');
                    let grupo = $(this).attr('data-grupo');
                    let eliminar_index;
                    $.each(preguntas, function (index, value) {
                        if (value['id'] == id && value['grupo'] == grupo) {
                            eliminar_index = index;
                        }
                    });
                    preguntas.splice(eliminar_index, 1);
                    enviar_preguntas();
                });
            }

            function remove_grupo() {
                $('.eliminar_grupo').off('click').on('click', function () {
                    let grupo = $(this).attr('data-grupo');
                    $(this).parent().remove();
                    $('#tab-' + grupo).remove();
                    // Eliminamos del array preguntas
                    let eliminar_index = [];
                    $.each(preguntas, function (index, value) {
                        if (value['grupo'] == grupo) {
                            eliminar_index.push(index);
                        }
                    });
                    console.log(eliminar_index);
                    for (var j = eliminar_index.length - 1; j >= 0; j--) {
                        preguntas.splice(eliminar_index[j], 1);
                    }
                    enviar_preguntas();
                });
            }

            function enviar_preguntas() {
                let m = "";
                $.each(preguntas, function (index, value) {
                    m += '<input type="hidden" name="id[]" value="' + value['id'] + '"><input type="hidden" name="grupo[]" value="' + value['grupo'] + '"><input type="hidden" name="nombre_grupo[]" value="' + value['nombre_grupo'] + '">';
                });
                $('#preguntas').html(m);
            }
        });
    </script>
@endsection
