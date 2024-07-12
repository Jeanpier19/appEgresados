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
                <input type="hidden" id="reporte-nombre">

                @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-no-border alert-close alert-dismissible fade in">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <p>{{ $message }}</p>
                    </div>
                @endif
                <div class="row">
                    <form id="reporte" method="GET" action="{{route('export')}}" target="_blank">
                        <div class="col-xs-12 col-md-3">
                            <strong>Condición:</strong>
                            {{ Form::select('condicion_id',$grados->pluck('descripcion','id'), null, array('id' => 'condicion_id','class' => 'selectpicker','title'=>'Seleccione...','data-container'=>'body','data-width'=>'100%','data-live-search'=>'true','multiple')) }}
                        </div>
                        <div class="col-xs-12 col-md-3">
                            <strong>Facultad:</strong>
                            {{ Form::select('facultad_id',$facultades->pluck('nombre','id'), null, array('id' => 'facultad_id','class' => 'selectpicker','title'=>'Seleccione...','data-container'=>'body','data-width'=>'100%','data-live-search'=>'true','data-max-options'=>'1','multiple')) }}
                        </div>
                        <div class="col-xs-12 col-md-3">
                            <strong>Escuela:</strong>
                            {{ Form::select('escuela_id',$escuelas->pluck('nombre','id'), null, array('id' => 'escuela_id','class' => 'selectpicker','title'=>'Seleccione...','data-container'=>'body','data-width'=>'100%','data-live-search'=>'true','data-max-options'=>'1','multiple')) }}
                        </div>
                        <div class="col-xs-12 col-md-3">
                            <div class="form-group">
                                <strong>Reporte:</strong><br>
                                <button id="excel" type="button" class="btn btn-success btn-sm"><i
                                        class="fa fa-file-excel-o"></i> Excel
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
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
                                            <a href="" class="btn btn-primary" data-id="{{ $egresado->id }}"
                                                data-nombre="{{ $egresado->nombre_completo }}" data-toggle="modal"
                                                data-target="#modalCapacitacion"><i class="fa fa-graduation-cap"></i></a>
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
                                                                            {{ $egresado->tipo_documento == $item_doc ? 'selected' : '' }}>
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
                                                                    @for ($i = date('Y'); $i >= 2000; $i--)
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
                                                                    @for ($i = date('Y'); $i >= 2000; $i--)
                                                                        <option value="{{ $i }}-II"
                                                                            {{ $egresado->f_ingreso == $i . '-II' ? 'selected' : '' }}>
                                                                            {{ $i }}-II
                                                                        </option>
                                                                        <option value="{{ $i }}-I"
                                                                            {{ $egresado->f_ingreso == $i . '-I' ? 'selected' : '' }}>
                                                                            {{ $i }}-I
                                                                        </option>
                                                                    @endfor
                                                                </select>
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label for="f_egreso">Semestre de egreso</label>
                                                                <select class="form-control" name="f_egreso"
                                                                    id="f_egreso">
                                                                    @for ($i = date('Y'); $i >= 2000; $i--)
                                                                        <option value="{{ $i }}-II"
                                                                            {{ $egresado->f_egreso == $i . '-II' ? 'selected' : '' }}>
                                                                            {{ $i }}-II
                                                                        </option>
                                                                        <option value="{{ $i }}-I"
                                                                            {{ $egresado->f_egreso == $i . '-I' ? 'selected' : '' }}>
                                                                            {{ $i }}-I
                                                                        </option>
                                                                    @endfor
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="form-group col-md-6">
                                                                <label for="genero">Facultad</label>
                                                                <select class="form-control" style="width: 400px"
                                                                    id="facultad_id" name="facultad_id">
                                                                    @foreach ($facultades as $facultad)
                                                                        <option value="{{ $facultad->id }}"
                                                                            {{ $egresado->facultad_id == $facultad->id ? 'selected' : '' }}>
                                                                            {{ $facultad->nombre }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label for="year">Escuela:</label>
                                                                <select class="form-control" style="width: 400px"
                                                                    id="escuela_id" name="escuela_id">
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
                                                                <select class="form-control" style="width: auto"
                                                                    id="codigo_local" name="codigo_local">
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
                                                                <select class="form-control" style="width: auto"
                                                                    id="grado_academico" name="grado_academico">
                                                                    @foreach ($grados as $grado)
                                                                        <option value="{{ $grado->id }}"
                                                                            {{ $egresado->grado_academico == $grado->descripcion ? 'selected' : '' }}>
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
                                    <option value="">Seleccionar</option>
                                    @for ($i = date('Y'); $i >= 2000; $i--)
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
                                    <option value="">Seleccionar</option>
                                    @for ($i = date('Y'); $i >= 2000; $i--)
                                        <option value="{{ $i }}">{{ $i }}-II</option>
                                        <option value="{{ $i }}">{{ $i }}-I</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="f_egreso">Semestre de egreso</label>
                                <select class="form-control" name="f_egreso" id="f_egreso">
                                    <option value="">Seleccionar</option>
                                    @for ($i = date('Y'); $i >= 2000; $i--)
                                        <option value="{{ $i }}">{{ $i }}-II</option>
                                        <option value="{{ $i }}">{{ $i }}-I</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="facultad_id">Facultad</label>
                                <select class="form-control" id="facultad_id" name="facultad_id">
                                    <option value="">Seleccionar</option>
                                    @foreach ($facultades as $facultad)
                                        <option value="{{ $facultad->id }}">{{ $facultad->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="year">Escuela:</label>
                                <select class="form-control" id="escuela_id" name="escuela_id">
                                    <option value="">Seleccionar</option>
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
                                    <option value="">Seleccionar</option>
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
                                    <option value="">Seleccionar</option>
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

    <!-- Modal Capacitaciones y experiencias -->
    <div class="modal fade" id="modalCapacitacion" tabindex="-1" role="dialog" aria-labelledby="modalCapacitaciones"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content ">
                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                        <i class="font-icon-close-2"></i>
                    </button>
                    <h4 class="modal-title">Capacitaciones</h4>
                </div>
                <div class="modal-body">
                    <section class="tabs-section">
                        <div class="tabs-section-nav tabs-section-nav-icons">
                            <div class="tbl">
                                <ul class="nav" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link" href="#capacitacion" role="tab" data-toggle="tab"><span
                                                class="nav-link-in"><i
                                                    class="fa fa-graduation-cap"></i>Capacitaciones</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#experiencia_laboral" role="tab"
                                            data-toggle="tab"><span class="nav-link-in"><span
                                                    class="fa fa-file-text-o"></span>Experiencia Laboral</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!--.tabs-section-nav-->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane fade" id="capacitacion">
                                <table id="table-cap" class="display table table-striped table-bordered" cellspacing="0"
                                    width="100%">
                                    <thead>
                                        <tr>
                                            <th>*</th>
                                            <th>Descripción</th>
                                            <th>Curso</th>
                                            <th>Estado</th>
                                            <th>¿Visto Bueno?</th>
                                            <th>Certificado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                            <!--.tab-pane-->
                            <div role="tabpanel" class="tab-pane fade" id="experiencia_laboral">
                                <table id="table-exp" class="display table table-striped table-bordered" cellspacing="0"
                                    width="100%">
                                    <thead>
                                        <tr>
                                            <th>*</th>
                                            <th>Entidad</th>
                                            <th>Cargo</th>
                                            <th>Fecha Inicio</th>
                                            <th>Fecha Salida</th>
                                            <th>Reconocimientos</th>
                                            <th>Satisfacción</th>
                                            <th>¿Visto Bueno?</th>
                                            <th>Archivo</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                            <!--.tab-pane-->
                        </div>
                        <!--.tab-content-->
                    </section>
                    <!--.tabs-section-->
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


    @if (session('Importar') == 'Importado')
        <script>
            Swal.fire({
                title: "Importado!",
                text: "Egresados importados con éxito.",
                icon: "success"
            });
        </script>
    @endif

@section('js')
    {{-- Para implementar el datatables --}}
    <script src="{{ asset('startui/js/lib/datatables-net/datatables.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            reporte();
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
            function reporte() {
                $('#excel').on('click', function () {
                    $('#reporte').attr('action', '{{route('export')}}');
                    $('#reporte').submit();
                });
            }
        });
    </script>
    {{-- Usamos la clase nombrada como formulario-eliminar --}}
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

    <script type="text/JavaScript">
        $(document).ready(function () {
            openTab();
            $('#table tbody').on('click', '.delete-confirm', function () {
                let idalumno = $(this).attr('data-id');
                let url = '{!! route('egresado.destroy', 'idalumno') !!}';
                swal({
                        title: '¿Estás seguro?',
                        text: "¡No podrás revertir esto!",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: '!Si, eliminar!',
                        cancelButtonText: 'Cancelar',
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
                                type: 'POST',
                                url: url,
                                data: {
                                    "_token": "{{ csrf_token() }}",
                                    "_method": 'DELETE',
                                    "id": idalumno,
                                },
                                dataType: 'JSON',
                                beforeSend: function () {
                                },
                                success: function (response) {
                                    if (response.success) {
                                        $.notify({
                                            icon: 'font-icon font-icon-check-circle',
                                            title: '<strong>¡Existoso!</strong>',
                                            message: 'Alumno eliminada correctamente'
                                        }, {
                                            placement: {
                                                from: "top",
                                            },
                                            type: 'success'
                                        });
                                        tabla.ajax.reload();
                                    } else {
                                        $.notify({
                                            icon: 'font-icon font-icon-warning',
                                            title: '<strong>¡Error!</strong>',
                                            message: 'Hubo un error al eliminar la Alumno'
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
                            swal({
                                title: "Cancelado",
                                text: "El registro está a salvo",
                                type: "error",
                                confirmButtonClass: "btn-danger"
                            });
                        }
                    });
            });

            $('#table tbody').off('click').on('click', '.capacitacion', function () {
                id = $(this).attr('data-id');
                nombre = $(this).attr('data-nombre');
                $('#reporte-nombre').val(nombre);
                $('[href="#capacitacion"]').tab('show');
            });

            function openTab() {
                $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                    var target = $(e.target).attr("href") // activated tab
                    if (target === '#capacitacion') {
                        let tabla = $('#table-cap').DataTable();
                        tabla.destroy();
                        tabla = $('#table-cap').DataTable({
                            dom: 'Bfrtip',
                            buttons: [{
                                extend: 'excel',
                                text: 'A Excel',
                                title: $('#reporte-nombre').val() + '_capacitaciones',
                                exportOptions: {
                                    columns: [1, 2, 3, 4, 5]
                                }
                            }],
                            responsive: true,
                            "processing": true,
                            "serverSide": true,
                            "autoWidth": true,
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
                                "url": "{{ route('egresado.get_capacitaciones') }}",
                                "dataType": "json",
                                "type": "POST",
                                "data": {
                                    _token: "{{ csrf_token() }}",
                                    "id": id
                                }
                            },
                            "columns": [{
                                "data": "idcapacitacion"
                            },
                                {
                                    "data": "descripcion"
                                },
                                {
                                    "data": "curso"
                                },
                                {
                                    "data": "estado"
                                },
                                {
                                    "data": "vistobueno"
                                },
                                {
                                    "data": "archivo"
                                },
                                {
                                    "data": "opciones"
                                }
                            ],
                            "columnDefs": [{
                                "className": "text-center",
                                "targets": [0, 1]
                            },
                                {
                                    "bSortable": true,
                                    "aTargets": [5, 6]
                                },
                            ],
                        });
                    }

                    if (target === '#experiencia_laboral') {
                        let tabla2 = $('#table-exp').DataTable();
                        tabla2.destroy();
                        tabla2 = $('#table-exp').DataTable({
                            dom: 'Bfrtip',
                            buttons: [{
                                extend: 'excel',
                                text: 'A Excel',
                                title: $('#reporte-nombre').val() + '_experiencia_laboral',
                                exportOptions: {
                                    columns: [1, 2, 3, 4, 5, 6, 7, 8]
                                }
                            }],
                            responsive: true,
                            "processing": true,
                            "serverSide": true,
                            "autoWidth": true,
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
                                "url": "{{ route('egresado.get_experiencia') }}",
                                "dataType": "json",
                                "type": "POST",
                                "data": {
                                    _token: "{{ csrf_token() }}",
                                    "id": id
                                }
                            },
                            "columns": [{
                                "data": "idexperiencia"
                            },
                                {
                                    "data": "identidad"
                                },
                                {
                                    "data": "cargo_laboral"
                                },
                                {
                                    "data": "fecha_inicio"
                                },
                                {
                                    "data": "fecha_salida"
                                },
                                {
                                    "data": "reconocimientos"
                                },
                                {
                                    "data": "nivel_satisfaccion"
                                },
                                {
                                    "data": "vb"
                                },
                                {
                                    "data": "archivo"
                                },
                                {
                                    "data": "opciones"
                                }
                            ],
                            "columnDefs": [{
                                "className": "text-center",
                                "targets": [0, 7]
                            },
                                {
                                    "bSortable": true,
                                    "aTargets": [5, 6]
                                },
                            ],
                        });
                    }
                });
            }
            });
        function validar(id, type) {
            if (type == '1') {
                $.ajax({
                    url: "{{ route('egresado.validar-experiencia') }}",
                    dataType: "JSON",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        method: "POST",
                        "id": id
                    },
                    success: function () {
                        $('#table-exp').DataTable().ajax.reload();
                    }
                });
            }
            if (type == '0') {
                console.log("validado")
                $.ajax({
                    url: "{{ route('egresado.validar-capacitacion') }}",
                    dataType: "JSON",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        method: "POST",
                        "id": id
                    },
                    success: function () {
                        $('#table-cap').DataTable().ajax.reload();
                    }
                });
            }
        }

        function invalidar(id, type) {
            swal({
                    title: '¿Invalidar?',
                    text: "¡No podrás revertir esto!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: '!Si, invalidar!',
                    cancelButtonText: 'Cancelar',
                    closeOnConfirm: true,
                    closeOnCancel: false
                },
                function (isConfirm) {
                    if (isConfirm) {
                        if (type == '1') {
                            $.ajax({
                                url: "{{ route('egresado.invalidar-experiencia') }}",
                                dataType: "JSON",
                                type: "DELETE",
                                data: {
                                    _token: "{{ csrf_token() }}",
                                    method: "DELETE",
                                    "id": id
                                },
                                success: function () {
                                    $('#table-exp').DataTable().ajax.reload();
                                }
                            });
                        }
                        if (type == '0') {
                            $.ajax({
                                url: "{{ route('egresado.invalidar-capacitacion') }}",
                                dataType: "JSON",
                                type: "DELETE",
                                data: {
                                    _token: "{{ csrf_token() }}",
                                    method: "DELETE",
                                    "id": id
                                },
                                success: function () {
                                    $('#table-cap').DataTable().ajax.reload();
                                }
                            });
                        }
                    } else {
                        swal({
                            title: "Cancelado",
                            text: "El registro está a salvo",
                            type: "error",
                            confirmButtonClass: "btn-danger"
                        });
                    }
                });
        }
    </script>

@stop

@stop
