@extends('layouts.app')

@section('content')

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
                    <a href="#" class="btn btn-inline btn-success btn-rounded btn-sm" data-toggle="modal"
                        data-target="#crearModal"><i class="fa fa-plus-circle"></i>
                        Crear
                    </a>
                    <a href="#" class="btn btn-inline btn-warning" data-toggle="modal" data-target="#importarModal"
                        style="padding: 4px; border-radius: 5px;"><i class="fas fa-file-import"></i>
                        Importación masiva
                    </a>
                    <a href="{{ route('export') }}" class="btn btn-inline btn-danger"
                        style="padding: 4px; border-radius: 5px;"><i class="fas fa-download"></i>
                        Exportación Excel
                    </a>
                </div>
            </header>
            <div class="card-block">
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                <table id="table" class="display table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead class="text-center align-middle">
                        <tr>
                            <th>N°</th>
                            <th>Código estudiante</th>
                            <th>DNI</th>
                            <th>Apellidos y Nombres</th>
                            <th>Género</th>
                            <th>F. Egreso</th>
                            <th>Grado Académico</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($egresados as $egresado)
                            <tr>
                                <td>{{ $egresado->id }}</td>
                                <td>{{ $egresado->codigo }}</td>
                                <td>{{ $egresado->num_documento }}</td>
                                <td>{{ $egresado->nombre_completo }}</td>
                                <td>{{ $egresado->sexo }}</td>
                                <td class="text-center align-middle">{{ $egresado->f_egreso }}</td>
                                <td>{{ $egresado->grado_academico }}</td>
                                <td>
                                    <form action="{{ route('egresadosn.destroy', $egresado->id) }}"
                                        class="formulario-eliminar" method="POST">
                                        @method('DELETE')
                                        @csrf
                                        <input type="hidden" name="egresado_id" value="{{ $egresado->id }}">
                                        <div class="btn-group btn-group-sm" role="group" aria-label="Acciones">
                                            <a href="#" class="btn btn-primary"><i
                                                    class="fa fa-graduation-cap"></i></a>
                                            <a href="" class="btn btn-warning" data-toggle="modal"
                                                data-target="#editarModal{{ $egresado->id }}"><i
                                                    class="fa fa-pencil-alt"></i></a>
                                            <button type="submit" class="btn btn-danger delete-confirm" data-id=""><i
                                                    class="fas fa-trash"></i></button>
                                        </div>
                                    </form>

                                    <!-- Modal Editar -->
                                    <div class="modal fade" id="editarModal{{ $egresado->id }}" tabindex="-1"
                                        role="dialog" aria-labelledby="editarModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editarModalLabel">Editar</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body"
                                                    style="max-height: calc(100vh - 200px); overflow-y: auto;">
                                                    <form action="{{ route('egresadosn.update', $egresado->id) }}"
                                                        method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="form-row">
                                                            <div class="form-group col-md-6">
                                                                <label for="codigo">Código</label>
                                                                <input type="text" class="form-control" id="codigo"
                                                                    name="codigo" value="{{ $egresado->codigo }}">
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label for="apellido-paterno">Apellido
                                                                    Paterno</label>
                                                                <input type="text" class="form-control" id="paterno"
                                                                    name="paterno" value="{{ $egresado->paterno }}">
                                                            </div>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="form-group col-md-6">
                                                                <label for="materno">Apellido Materno</label>
                                                                <input type="text" class="form-control" id="materno"
                                                                    name="materno" value="{{ $egresado->materno }}">
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label for="nombres">Nombres</label>
                                                                <input type="text" class="form-control" id="nombres"
                                                                    name="nombres" value="{{ $egresado->nombres }}">
                                                            </div>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="form-group col-md-6">
                                                                <label for="tipo_documento">Tipo de
                                                                    documento</label>
                                                                <select class="form-control" id="tipo_documento"
                                                                    name="tipo_documento">
                                                                    @foreach ($tip_doc as $index => $item_doc)
                                                                        <option value="{{ $index }}"
                                                                            {{ $egresado->tipo_documento == $index ? 'selected' : '' }}>
                                                                            {{ $item_doc }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label for="documento">Documento</label>
                                                                <input type="text" class="form-control" id="documento"
                                                                    name="documento"
                                                                    value="{{ $egresado->num_documento }}">
                                                            </div>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="form-group col-md-6">
                                                                <label for="direccion">Dirección</label>
                                                                <input type="text" class="form-control" id="direccion"
                                                                    name="direccion" value="{{ $egresado->direccion }}">
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label for="correo">Correo</label>
                                                                <input type="text" class="form-control" id="correo"
                                                                    name="correo" value="{{ $egresado->correo }}">
                                                            </div>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="form-group col-md-6">
                                                                <label for="telefono">Teléfono</label>
                                                                <input type="text" class="form-control" id="telefono"
                                                                    name="telefono" value="{{ $egresado->telefono }}">
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label for="celular">Celular</label>
                                                                <input type="text" class="form-control" id="celular"
                                                                    name="celular" value="{{ $egresado->celular }}">
                                                            </div>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="form-group col-md-6">
                                                                <label for="genero">Género</label>
                                                                <select class="form-control" id="genero"
                                                                    name="genero">
                                                                    @foreach ($genero as $index => $item)
                                                                        <option value="{{ $index }}"
                                                                            {{ $egresado->sexo == $item ? 'selected' : '' }}>
                                                                            {{ $item }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label for="year">Año de egreso</label>
                                                                <select class="form-control" name="year"
                                                                    id="year">
                                                                    @for ($i = 2000; $i <= date('Y'); $i++)
                                                                        <option value="{{ $i }}"
                                                                            {{ $egresado->anio == $i ? 'selected' : '' }}>
                                                                            {{ $i }}</option>
                                                                    @endfor
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="form-group col-md-6">
                                                                <label for="ciclo">Ciclo</label>
                                                                <select class="form-control" name="ciclo"
                                                                    id="ciclo">
                                                                    @foreach ($ciclos as $index => $ciclo)
                                                                        <option value="{{ $index }}"
                                                                            {{ $egresado->ciclo == $index ? 'selected' : '' }}>
                                                                            {{ $ciclo }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label for="f_ingreso">Semestre de ingreso</label>
                                                                <select class="form-control" name="f_ingreso"
                                                                    id="f_ingreso">
                                                                    @for ($i = 2000; $i <= date('Y'); $i++)
                                                                        <option value="{{ $i }}-I"
                                                                            {{ $egresado->f_ingreso == $i . '-I' ? 'selected' : '' }}>
                                                                            {{ $i }}-I
                                                                        </option>
                                                                        <option value="{{ $i }}-II"
                                                                            {{ $egresado->f_ingreso == $i . '-II' ? 'selected' : '' }}>
                                                                            {{ $i }}-II</option>
                                                                    @endfor
                                                                </select>
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label for="f_egreso">Semestre de egreso</label>
                                                                <select class="form-control" name="f_egreso"
                                                                    id="f_egreso">
                                                                    @for ($i = 2000; $i <= date('Y'); $i++)
                                                                        <option value="{{ $i }}-I"
                                                                            {{ $egresado->f_egreso == $i . '-I' ? 'selected' : '' }}>
                                                                            {{ $i }}-I
                                                                        </option>
                                                                        <option value="{{ $i }}-II"
                                                                            {{ $egresado->f_egreso == $i . '-II' ? 'selected' : '' }}>
                                                                            {{ $i }}-II
                                                                        </option>
                                                                    @endfor
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="form-group col-md-6">
                                                                <label for="genero">Facultad</label>
                                                                <select class="form-control" id="facultad_id"
                                                                    name="facultad_id">
                                                                    @foreach ($facultades as $facultad)
                                                                        <option value="{{ $facultad->id }}"
                                                                            {{ $egresado->facultad_id == $facultad->id ? 'selected' : '' }}>
                                                                            {{ $facultad->nombre }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label for="year">Escuela:</label>
                                                                <select class="form-control" id="escuela_id"
                                                                    name="escuela_id">
                                                                    @foreach ($escuelas as $escuela)
                                                                        <option value="{{ $escuela->id }}"
                                                                            {{ $egresado->escuela_id == $escuela->id ? 'selected' : '' }}>
                                                                            {{ $escuela->nombre }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="form-group col-md-6">
                                                                <label for="codigo_local">Código de Local</label>
                                                                <select class="form-control" id="codigo_local"
                                                                    name="codigo_local">
                                                                    @for ($i = 1; $i <= 200; $i++)
                                                                        @php
                                                                            // Generar el código en el formato SLXX
                                                                            $codigo =
                                                                                'SL' .
                                                                                str_pad($i, 2, '0', STR_PAD_LEFT);
                                                                        @endphp
                                                                        <option value="{{ $codigo }}"
                                                                            {{ $egresado->codigo_local == $codigo ? 'selected' : '' }}>
                                                                            {{ $codigo }}</option>
                                                                    @endfor
                                                                </select>
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label for="grado_academico">Grado
                                                                    académico</label>
                                                                <select class="form-control" id="grado_academico"
                                                                    name="grado_academico">
                                                                    @foreach ($grados as $grado)
                                                                        <option value="{{ $grado->id }}" {{ $egresado->grado_academico == $grado->descripcion ? 'selected' : '' }}>
                                                                            {{ Str::upper($grado->descripcion) }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-12">
                                                            <button type="submit" class="btn btn-primary"><i
                                                                    class="fa fa-save"></i> Guardar
                                                                Cambios</button>
                                                            <br><br>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </div>

    <!-- Modal Crear -->
    <div class="modal fade" id="crearModal" tabindex="-1" role="dialog" aria-labelledby="crearModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="crearModalLabel">Crear</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="max-height: calc(100vh - 200px); overflow-y: auto;">
                    <form action="{{ route('egresadosn.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="codigo">Código</label>
                                <input type="text" class="form-control" id="codigo" name="codigo">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="apellido-paterno">Apellido Paterno</label>
                                <input type="text" class="form-control" id="paterno" name="paterno">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="materno">Apellido Materno</label>
                                <input type="text" class="form-control" id="materno" name="materno">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="nombres">Nombres</label>
                                <input type="text" class="form-control" id="nombres" name="nombres">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="tipo_documento">Tipo de documento</label>
                                <select class="form-control" id="tipo_documento" name="tipo_documento">
                                    @foreach ($tip_doc as $index => $item_doc)
                                        <option value="{{ $index }}">{{ $item_doc }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="documento">Documento</label>
                                <input type="text" class="form-control" id="documento" name="documento">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="direccion">Dirección</label>
                                <input type="text" class="form-control" id="direccion" name="direccion">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="correo">Correo</label>
                                <input type="text" class="form-control" id="correo" name="correo">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="telefono">Teléfono</label>
                                <input type="text" class="form-control" id="telefono" name="telefono">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="celular">Celular</label>
                                <input type="text" class="form-control" id="celular" name="celular">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="genero">Género</label>
                                <select class="form-control" id="genero" name="genero">
                                    @foreach ($genero as $index => $item)
                                        <option value="{{ $index }}">{{ $item }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="year">Año de egreso</label>
                                <select class="form-control" name="year" id="year">
                                    @for ($i = 2000; $i <= date('Y'); $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="ciclo">Ciclo</label>
                                <select class="form-control" name="ciclo" id="ciclo">
                                    @foreach ($ciclos as $index => $ciclo)
                                        <option value="{{ $index }}">{{ $ciclo }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="f_ingreso">Semestre de ingreso</label>
                                <select class="form-control" name="f_ingreso" id="f_ingreso">
                                    @for ($i = 2000; $i <= date('Y'); $i++)
                                        <option value="{{ $i }}">{{ $i }}-I</option>
                                        <option value="{{ $i }}">{{ $i }}-II</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="f_egreso">Semestre de egreso</label>
                                <select class="form-control" name="f_egreso" id="f_egreso">
                                    @for ($i = 2000; $i <= date('Y'); $i++)
                                        <option value="{{ $i }}">{{ $i }}-I</option>
                                        <option value="{{ $i }}">{{ $i }}-II</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="facultad_id">Facultad</label>
                                <select class="form-control" id="facultad_id" name="facultad_id">
                                    @foreach ($facultades as $facultad)
                                        <option value="{{ $facultad->id }}">{{ $facultad->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="year">Escuela:</label>
                                <select class="form-control" id="escuela_id" name="escuela_id">
                                    @foreach ($escuelas as $escuela)
                                        <option value="{{ $escuela->id }}">{{ $escuela->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="codigo_local">Código de Local</label>
                                <select class="form-control" id="codigo_local" name="codigo_local">
                                    @for ($i = 1; $i <= 200; $i++)
                                        @php
                                            // Generar el código en el formato SLXX
                                            $codigo = 'SL' . str_pad($i, 2, '0', STR_PAD_LEFT);
                                        @endphp
                                        <option value="{{ $codigo }}">{{ $codigo }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="grado_academico">Grado académico</label>
                                <select class="form-control" id="grado_academico" name="grado_academico">
                                    @foreach ($grados as $grado)
                                        <option value="{{ $grado->id }}">{{ Str::upper($grado->descripcion) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Guardar</button>
                            <br><br>
                        </div>
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
                    <form action="{{ route('importar') }}" method="POST" enctype="multipart/form-data">
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
    {{-- Para eliminar una imagen usando la confirmación del paquete swal --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- Para implementar el datatables --}}
    <script src="{{ asset('startui/js/lib/datatables-net/datatables.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#table').DataTable({
                responsive: true,
                pageLength: 10, // Número de filas por página
                lengthMenu: [10, 25, 50, 100, 200, 500, 1000],
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
                    }
                }
            });
        });
    </script>

    @if (session('Importar') == 'Importado')
        <script>
            Swal.fire({
                title: "Importado!",
                text: "Egresados importados con éxito.",
                icon: "success"
            });
        </script>
    @endif

    {{-- Usamos la clase nombrada como formulario-eliminar --}}
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Selecciona todos los formularios con la clase 'formulario-eliminar'
            const forms = document.querySelectorAll('.formulario-eliminar');

            forms.forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    event.preventDefault(); // Previene el envío inmediato del formulario

                    // Mostrar SweetAlert2 para la confirmación
                    Swal.fire({
                        title: "¿Estás seguro?",
                        text: "Este registro se eliminará permanentemente",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "¡Sí, Eliminar!",
                        cancelButtonText: "Cancelar",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form
                                .submit(); // Envía el formulario si la confirmación es positiva
                        }
                    });
                });
            });
        });
    </script>
    @if (session('eliminar') == 'ok')
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
@stop

@stop
