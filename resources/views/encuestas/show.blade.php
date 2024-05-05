@extends('layouts.app')
@section('css')
    <style>
        button.btn-inline {
            margin-bottom: -20px !important;
        }
    </style>
@endsection
@section('content')
    <div class="container-fluid">
        <section class="card">
            <header class="card-header">
                <div class="pull-left">
                    <ol class="breadcrumb breadcrumb-simple">
                        <li><a href="{{route('home')}}">Inicio</a></li>
                        <li><a href="{{route('encuestas.index')}}">Encuesta</a></li>
                        <li class="active">Resultados</li>
                    </ol>
                </div>
                <div class="pull-right">
                    <button id="btn_interpretacion" class="btn btn-inline btn-primary btn-rounded btn-sm"
                            data-toggle="modal" data-target="#modal_interpretacion"><i class="fa fa-plus-circle"></i>
                        Interpretación
                    </button>
                    <a href="{{route('encuestas.index')}}" class="btn btn-inline btn-secondary btn-rounded btn-sm"><i
                            class="fa fa-angle-left"></i> Atrás</a>
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
                @if ($message = Session::get('warning'))
                    <div class="alert alert-warning alert-no-border alert-close alert-dismissible fade in">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <p>{{ $message }}</p>
                    </div>
                @endif
                <div class="row">
                    <div class="col-xs-6">
                        <section class="card">
                            <form id="reporte" method="GET" action="{{route('respuestas.excel')}}" target="_blank">
                                <input type="hidden" name="encuesta_id" value="{{$encuesta->id}}">
                                <header class="card-header">
                                    <div class="pull-left">
                                        Reportes
                                    </div>
                                    <div class="pull-right">
                                        <button id="excel" type="button" class="btn btn-success btn-rounded btn-sm"><i
                                                class="fa fa-file-excel-o"></i> Excel
                                        </button>
                                        <button id="pdf" type="button" class="btn btn-danger btn-rounded btn-sm"><i
                                                class="fa fa-file-pdf-o"></i> PDF
                                        </button>
                                    </div>
                                </header>
                                <div class="card-block">
                                    <div class="col-xs-12 col-md-6">
                                        <strong>Semestre:</strong>
                                        {{ Form::select('semestre',['2021'=>'2021-I'], null, array('id' => 'semestre','class' => 'bootstrap-select','title'=>'Seleccione...')) }}
                                    </div>
                                    <div class="col-xs-12 col-md-6">
                                        <strong>Sexo:</strong>
                                        {{ Form::select('sexo',['Masculino'=>'Masculino','Femenino'=>'Femenino'], null, array('id' => 'sexo','class' => 'bootstrap-select','title'=>'Seleccione...')) }}
                                    </div>
                                </div>
                            </form>
                        </section>
                    </div><!--.col-->
                    <div class="col-xs-6">
                        <section class="card">
                            <header class="card-header">
                                <div class="pull-left">
                                    Generar gráficos
                                </div>
                                <div class="pull-right">
                                    <button id="generar_grafico" type="button" class="btn btn-info btn-rounded btn-sm">
                                        <i
                                            class="fa fa-line-chart"></i> Ver
                                    </button>
                                </div>
                            </header>
                            <div class="card-block">
                                <div class="col-xs-12">
                                    <strong>Preguntas:</strong>
                                    {{ Form::select('preguntas',$preguntas->pluck('titulo', 'id'), null, array('id' => 'preguntas','class' => 'bootstrap-select','title'=>'Seleccione...','data-live-search' => 'true')) }}
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
                <table id="table" class="display table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>Código</th>
                        <th>Apellidos y nombre</th>
                        <th>Fecha llenado</th>
                        <th>Sexo</th>
                        <th>Opciones</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </section>
    </div><!--.container-fluid-->
    <div class="modal fade" id="modal_pregunta" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                        <i class="font-icon-close-2"></i>
                    </button>
                    <h4 class="modal-title" id="modal_label">Gráfico</h4>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12">
                            <canvas id="myChart"></canvas>
                        </div>
                        <div class="col-xs-12">
                            <div id="automatico" class="text-muted"></div>
                        </div>
                        <div class="col-xs-12">
                            <strong>Interpretación:</strong>
                            <textarea id="pregunta_interpretacion" rows="4" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button id="guardar_pregunta_interpretacion" type="button"
                            class="btn btn-success btn-rounded btn-sm" data-dismiss="modal"> Guardar
                    </button>
                    <button type="button" class="btn btn-danger btn-rounded btn-sm" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal_interpretacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                        <i class="font-icon-close-2"></i>
                    </button>
                    <h4 class="modal-title">Encuesta</h4>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12">
                            <strong>Interpretación:</strong>
                            <textarea id="interpretacion" rows="8" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button id="guardar_interpretacion" type="button" class="btn btn-success" data-dismiss="modal">
                        Guardar
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.6.0/chart.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            reporte();
            filtros();
            graficar();
            interpretacion_store();
            pregunta_interpretacion_store();

            const ctx = document.getElementById('myChart').getContext('2d');
            var myChart = new Chart(ctx);
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
                        "url": "{{ route('respuestas.all') }}",
                        "dataType": "json",
                        "type": "POST",
                        "data": function (d) {
                            d.encuesta_id = '{{$encuesta->id}}';
                            d.sexo = $('#sexo').val();
                            d._token = "{{csrf_token()}}";
                        },
                    },
                    "columns": [
                        {"data": "codigo"},
                        {"data": "nombre_completo"},
                        {"data": "fecha_llenado"},
                        {"data": "sexo"},
                        {"data": "options"}
                    ],
                    "columnDefs": [
                        {"className": "text-center", "targets": [0, 2, 3, 4]},
                        {"bSortable": false, "aTargets": [4]},
                    ],
                }
            );
            var interpretacion = '{{$encuesta->interpretacion}}';


            function reporte() {
                $('#excel').on('click', function () {
                    $('#reporte').attr('action', '{{route('respuestas.excel')}}');
                    $('#reporte').submit();
                });
                $('#pdf').on('click', function () {
                    $('#reporte').attr('action', '{{route('encuestados.pdf')}}');
                    $('#reporte').submit();
                });
            }

            function filtros() {
                $('#sexo').on('change', function () {
                    tabla.ajax.reload();
                });
            }

            function graficar() {
                $('#generar_grafico').on('click', function () {
                    let pregunta_id = $('#preguntas').val();
                    if (pregunta_id) {
                        $('#modal_pregunta').modal('show');
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            type: 'POST',
                            url: "{{ route('respuestas.pregunta') }}",
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "encuesta_id": '{{$encuesta->id}}',
                                "pregunta_id": pregunta_id,
                            },
                            dataType: 'JSON',
                            beforeSend: function () {
                            },
                            success: function (response) {
                                if (response.success) {
                                    $('#modal_label').html(response.titulo);
                                    $('#pregunta_interpretacion').val(response.interpretacion);
                                    let suma = response.datos.reduce((a, b) => a + b, 0);
                                    let interpretacion = "";
                                    $.each(response.datos, function (index, value){
                                        let porcentaje = Math.round((value / suma) * 100 * 100) / 100;
                                        interpretacion += '<b>'+response.labels[index]+': </b>'+ porcentaje + ' % <br>';
                                    })
                                    $('#automatico').html(interpretacion);
                                    myChart.destroy();
                                    myChart = new Chart(ctx, {
                                        type: 'bar',
                                        data: {
                                            labels: response.labels,
                                            datasets: [{
                                                label: '# de respuestas',
                                                data: response.datos,
                                                backgroundColor: [
                                                    'rgba(255, 99, 132, 0.2)',
                                                    'rgba(54, 162, 235, 0.2)',
                                                    'rgba(255, 206, 86, 0.2)',
                                                    'rgba(75, 192, 192, 0.2)',
                                                    'rgba(153, 102, 255, 0.2)',
                                                    'rgba(255, 159, 64, 0.2)'
                                                ],
                                                borderColor: [
                                                    'rgba(255, 99, 132, 1)',
                                                    'rgba(54, 162, 235, 1)',
                                                    'rgba(255, 206, 86, 1)',
                                                    'rgba(75, 192, 192, 1)',
                                                    'rgba(153, 102, 255, 1)',
                                                    'rgba(255, 159, 64, 1)'
                                                ],
                                                borderWidth: 1
                                            }]
                                        },
                                        options: {
                                            scales: {
                                                y: {
                                                    beginAtZero: true,
                                                    ticks: {
                                                        stepSize: 1
                                                    },
                                                }
                                            },
                                            plugins: {
                                                tooltip: {
                                                    callbacks: {
                                                        label: function (context) {
                                                            let label = "";
                                                            suma = context.dataset.data.reduce((a, b) => a + b, 0);
                                                            porcentaje = Math.round((context.parsed.y / suma) * 100 * 100) / 100;

                                                            if (context.parsed.y !== null) {
                                                                label += porcentaje + '%';
                                                            }
                                                            return label;
                                                        },
                                                    }
                                                }
                                            },
                                        }
                                    });
                                } else {
                                    $.notify({
                                        icon: 'font-icon font-icon-warning',
                                        title: '<strong>¡Error!</strong>',
                                        message: 'Hubo un error al gráficar'
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
                            title: '<strong>¡Aviso!</strong>',
                            message: 'Seleccione una pregunta'
                        }, {
                            placement: {
                                from: "top",
                            },
                            type: 'info'
                        });
                    }
                });
            }

            function interpretacion_store() {
                $('#btn_interpretacion').on('click', function () {
                    $('#interpretacion').val(interpretacion);
                });
                $('#guardar_interpretacion').on('click', function () {
                    interpretacion = $('#interpretacion').val();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('interpretacion.store') }}",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "encuesta_id": '{{$encuesta->id}}',
                            "interpretacion": interpretacion,
                        },
                        dataType: 'JSON',
                        beforeSend: function () {
                        },
                        success: function (response) {
                            if (response.success) {
                                $.notify({
                                    icon: 'font-icon font-icon-check-circle',
                                    title: '<strong>¡Excelente!</strong>',
                                    message: 'Interpretación guardada correctamente'
                                }, {
                                    placement: {
                                        from: "top",
                                    },
                                    type: 'success'
                                });
                                $("#interpretacion").val('');
                            } else {
                                $.notify({
                                    icon: 'font-icon font-icon-warning',
                                    title: '<strong>¡Error!</strong>',
                                    message: 'Hubo un error al gráficar'
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
                });
            }

            function pregunta_interpretacion_store() {
                $('#guardar_pregunta_interpretacion').on('click', function () {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('pregunta.interpretacion.store') }}",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "encuesta_id": '{{$encuesta->id}}',
                            "pregunta_id": $('#preguntas').val(),
                            "interpretacion": $('#pregunta_interpretacion').val(),
                        },
                        dataType: 'JSON',
                        beforeSend: function () {
                        },
                        success: function (response) {
                            if (response.success) {
                                $.notify({
                                    icon: 'font-icon font-icon-check-circle',
                                    title: '<strong>¡Excelente!</strong>',
                                    message: 'Interpretación de pregunta guardada correctamente'
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
                                    message: 'Hubo un error al gráficar'
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
                });
            }
        });
    </script>
@endsection
