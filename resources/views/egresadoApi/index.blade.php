@extends('layouts.app')
@section('css')
@endsection
@section('content')
    <div class="container-fluid">
        <section class="card">
            <header class="card-header">
                <div class="pull-left">
                    <ol class="breadcrumb breadcrumb-simple">
                        <li><a href="#">Inicio</a></li>
                        <li class="active">Lista de Egresados</li>
                    </ol>
                </div>
                
                {{-- <div class="pull-right">
                    @can('alumnos-crear')
                        <a href="{{ route('egresado.create') }}"
                           class="btn btn-inline btn-success btn-rounded btn-sm"><i
                                class="fa fa-plus-circle"></i>
                            Nuevo
                        </a>
                    @endcan
                </div> --}}
            </header>
            <div class="card-block">
                <input type="hidden" id="reporte-nombre">

                @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-no-border alert-close alert-dismissible fade in">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <p>{{ $message }}</p>
                    </div>
                @endif
                <div>
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-4">
                            <div>
                                <label>Escuela</label>
                            <select class="form-control" name="escuelas" id="escuelas">
                                <option value="0" hidden> Selecciona escuela...</option>
                                @foreach ($escuelas as $item)
                                    <option value="{{$item['id']}}">{{$item['nombre']}}</option>
                                @endforeach
                            </select>
                            </div>                           
                        </div>
                        <div class="col-md-4">
                            <div >
                                <label>Semestre</label>
                            <select class="form-control" name="semestres" id="semestres">
                                <option value="0" hidden> Selecciona semestre...</option>
                                @foreach ($semestres as $item)
                                    <option value="{{$item['Semestre']}}" >{{$item['Semestre']}}</option>
                                @endforeach
                            </select>
                            </div>
                        </div>
                        
                        <div class="vol-md-2"></div><br><br><hr>
                        <div class="col-md-12 ">
                            <div class="x_content" id="divTabla">
                                <div class="table-responsive">
                                    <table id="table" class="display table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Código</th>
                                            <th>Apellidos y Nombres</th>
                                            <th>DNI</th>
                                            <th>Dirección</th>
                                            <th>Celular</th>
                                            {{-- <th>Teléfono</th> --}}
                                            <th>Correo</th>
                                            <th>Facultad</th>
                                            <th>Escuela</th>
                                            <th>Creditos O. Ap.</th>
                                            <th>Creditos E. Ap.</th>
                                            <th>Semestre Egreso</th>
                                            <th>Periodo Ingreso</th>
                                            <th>1° Matricula</th>
                                            <th>Promedio Ponderado</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            
                                            @foreach ($data as $item)
                                                <tr>
                                                    <td>{{$item['alumno']['codigo']}}</td>
                                                    <td>{{$item['alumno']['nombre_completo']}}</td>
                                                    <td>{{$item['alumno']['dni']}}</td>
                                                    <td>{{$item['alumno']['direccion']}}</td>
                                                    <td>{{$item['alumno']['celular']}}</td>
                                                    {{-- <td>{{$item['alumno']['telefono']}}</td> --}}
                                                    <td>{{$item['alumno']['correo_institucional']}}</td>
                                                    <td>{{$item['facultad']['nombre']}}</td>
                                                    <td>{{$item['escuela']['nombre']}}</td>
                                                    <td>{{$item['creditos_obligatorios_aprobados']}}</td>
                                                    <td>{{$item['creditos_electivos_aprobados']}}</td>
                                                    <td>{{$item['semestre_egreso']}}</td>
                                                    <td>{{$item['periodo_ingreso']}}</td>
                                                    <td>{{$item['primera_matricula']}}</td>
                                                    <td>{{$item['promedio_ponderado']}}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </section>
    </div>
    

@endsection
@section('js')
    <script type="text/javascript">
        $(document).ready(function () {
            table();
            
        });
        $(document).on('change', '#semestres', function(event) {
            var escuela=$("#escuelas option:selected").val();
            var semestre=$("#semestres option:selected").val();
            $.ajax({
                url: "{{ route('api.escuela') }}",
                type: "POST",
                data: {
                    escuela: escuela,
                    semestre: semestre,
                    _token: "{{ csrf_token() }}",
                    method: "POST",
                },
                success: function (resultado) {
                    $('#divTabla').empty();
                    $('#divTabla').html(resultado);
                    table();
                }
            });
        });
        $(document).on('change', '#escuelas', function(event) {
            var escuela=$("#escuelas option:selected").val();
            var semestre=$("#semestres option:selected").val();
            $.ajax({
                url: "{{ route('api.escuela') }}",
                type: "POST",
                data: {
                    escuela: escuela,
                    semestre: semestre,
                    _token: "{{ csrf_token() }}",
                    method: "POST",
                },
                success: function (resultado) {
                    $('#divTabla').empty();
                    $('#divTabla').html(resultado);
                    table();
                }
            });
        });
        function table(){
            $('#table').DataTable({
                responsive: true,
                autowidth:false,
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
                }
                
            });
        }
    </script>
@endsection
