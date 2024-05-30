@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <section class="card">
            <header class="card-header">
                <div class="pull-left">
                    <ol class="breadcrumb breadcrumb-simple">
                        <li><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="active">Egresados</li>
                    </ol>
                </div>
                <div class="pull-right">
                    <a href="{{ route('egresadosn.create') }}" class="btn btn-inline btn-success btn-rounded btn-sm"
                        data-toggle="modal" data-target="#crearModal"><i class="fa fa-plus-circle"></i>
                        Crear
                    </a>
                    <a href="{{ route('egresadosn.create') }}" class="btn btn-inline btn-warning" data-toggle="modal"
                        data-target="#importarModal" style="padding: 4px; border-radius: 5px;"><i
                            class="fas fa-file-import"></i>
                        Importación masiva
                    </a>
                    <a href="{{ route('egresadosn.create') }}" class="btn btn-inline btn-danger"
                        style="padding: 4px; border-radius: 5px;"><i class="fas fa-download"></i>
                        Exportación Excel
                    </a>
                </div>
            </header>
            <div class="card-block">
                <table id="table" class="display table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead class="text-center align-middle">
                        <tr>
                            <th>Código</th>
                            <th>Apellidos y Nombres</th>
                            <th>DNI</th>
                            <th>Correo</th>
                            <th>Celular</th>
                            <th>Género</th>
                            <th>Egresado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>02.0003.AN.AV</td>
                            <td>MAZA TAMARIZ JEANPIER JOHANN</td>
                            <td>70171918</td>
                            <td>jmazat@unasam.edu.pe</td>
                            <td>910945912</td>
                            <td>MASCULINO</td>
                            <td class="text-center align-middle">Si</td>
                            <td class="text-center align-middle">
                                <form action="" method="post">
                                    <div class="btn-group btn-group-sm" role="group" aria-label="Acciones">
                                        <a href="#" class="btn btn-primary"><i class="fa fa-graduation-cap"></i></a>
                                        <a href="#" class="btn btn-warning"><i class="fa fa-pencil-alt"></i></a>
                                        <button type="button" class="btn btn-danger delete-confirm" data-id="#"><i
                                                class="fas fa-trash"></i></button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                        {{-- @foreach ($egresadosn as $egresado)
                            <tr>
                                <td>{{  $banner->codigo }}</td>
                                <td>{{ $banner->nombre }}</td>
                                <td class="text-center align-middle">
                                    <img src="/banner/{{ $banner->imagen }}" width="60px">
                                </td>
                                <td class="text-center align-middle">{{ $banner->fecha_fin ? $banner->fecha_fin : '-' }}
                                </td>
                                <td class="text-center align-middle"><span
                                        class=" {{ $banner->temporal->tempo === 'Permanente' ? 'bg bg-success' : 'bg bg-danger' }}" style="padding: 4px; border-radius: 5px;">{{ $banner->temporal ? $banner->temporal->tempo : 'Sin temporalidad' }}</span>
                                </td>
                                <td class="text-center">
                                    <form action="{{ route('banners.destroy', $banner->id) }}" class="formulario-eliminar"
                                        method="POST">
                                        @method('DELETE')
                                        @csrf
                                        <a href="/banners/{{ $banner->id }}/edit" class="btn btn-dark">Editar</a>
                                        <button type="submit" class="btn btn-danger">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach --}}
                    </tbody>
                </table>
            </div>
        </section>
    </div>

    <!-- Modal Crear -->
    <div class="modal fade" id="crearModal" tabindex="-1" role="dialog" aria-labelledby="crearModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="crearModalLabel">Crear</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Aquí colocas el formulario para crear el nuevo elemento -->
                    <!-- Por ejemplo, podrías usar un formulario de Laravel -->
                    <form action="{{ route('egresadosn.store') }}" method="POST">
                        @csrf
                        <!-- Aquí colocas los campos del formulario -->
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="codigo">Código</label>
                                <input type="text" class="form-control" id="codigo" name="codigo">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="apellido-paterno">Apellido Paterno</label>
                                <input type="text" class="form-control" id="apellido-paterno" name="apellido-paterno">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="apellido-materno">Apellido Materno</label>
                                <input type="text" class="form-control" id="apellido-materno" name="apellido-materno">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="nombres">Nombres</label>
                                <input type="text" class="form-control" id="nombres" name="nombres">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="tipo-documento">Tipo de documento</label>
                                <select class="form-control" id="tipo-documento" name="tipo-documento">
                                    <option value="0">MASCULINO</option>
                                    <option value="1">FEMENINO</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="documento">Documento</label>
                                <input type="text" class="form-control" id="documento" name="documento">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="correo">Correo</label>
                                <input type="text" class="form-control" id="correo" name="correo">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="celular">Celular</label>
                                <input type="text" class="form-control" id="celular" name="celular">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="genero">Género</label>
                                <input type="text" class="form-control" id="genero" name="genero">
                            </div>
                        </div>

                        <!-- Otros campos del formulario -->
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Importar -->
    <div class="modal fade" id="importarModal" tabindex="-1" role="dialog" aria-labelledby="importarModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importarModalLabel">Importar Excel</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Aquí colocas el formulario para crear el nuevo elemento -->
                    <!-- Por ejemplo, podrías usar un formulario de Laravel -->
                    <form action="{{ route('egresadosn.store') }}" method="POST">
                        @csrf
                        <!-- Aquí colocas los campos del formulario -->
                        <div class="form-group">
                            <label for="campo1">Importar datos:</label>
                            <input type="file" class="form-control" id="datosMasivo" name="datosMasivo">
                        </div>
                        <!-- Otros campos del formulario -->
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
    <link rel="stylesheet" href="{{ asset('startui/css/lib/datatables-net/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('startui/css/separate/vendor/datatables-net.min.css') }}">
@stop

@section('js')
    {{-- Para implementar el datatables --}}
    <script src="{{ asset('startui/js/lib/datatables-net/datatables.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#table').DataTable({
                responsive: true,
                language: {
                    "decimal": "",
                    "emptyTable": "No hay información",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                    "infoEmpty": "Mostrando 0 a 0 de 0 Entradas",
                    "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Mostrar _MENU_ Entradas",
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
        });
    </script>

    {{-- Para eliminar una imagen usando la confirmación del paquete swal --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('info') == 'Creado')
        <script>
            Swal.fire({
                position: 'top-end',
                text: "Registro creado con exito.",
                showConfirmButton: false,
                timer: 3500,
                width: 300, // Ancho del pop-up en píxeles
                height: 40, // Desactiva el ajuste automático de altura para permitir un pop-up más pequeño
                backdrop: false // Desactiva el fondo oscuro
            });
        </script>
    @endif

    @if (session('Eliminar') == 'Ok')
        <script>
            Swal.fire({
                position: 'top-end',
                text: "Registro eliminado con exito.",
                showConfirmButton: false,
                timer: 3500,
                width: 300, // Ancho del pop-up en píxeles
                height: 40, // Desactiva el ajuste automático de altura para permitir un pop-up más pequeño
                backdrop: false // Desactiva el fondo oscuro
            });
        </script>
    @endif
    {{-- Usamos la clase nombrada como formulario-eliminar --}}
    <script>
        $('.formulario-eliminar').submit(function(e) {
            e.preventDefault();
            Swal.fire({
                title: "¿Estás seguro?",
                text: "Este registro se eliminará permanentemente",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "¡Si, Eliminar!",
                cancelButtonText: "Cancelar",
            }).then((result) => {
                if (result.value) {
                    this.submit();
                }
            });
        });
    </script>
@stop
