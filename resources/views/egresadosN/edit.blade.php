@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <section class="card">
            <header class="card-header">
                <div class="pull-left">
                    <ol class="breadcrumb breadcrumb-simple">
                        <li><a href="{{ route('home') }}">Inicio</a></li>
                        <li><a href="{{ route('egresadosn.index') }}">EgresadosN</a></li>
                        <li class="active">Editar</li>
                    </ol>
                </div>
                <div class="pull-right">
                    <a href="{{ route('egresadosn.index') }}" class="btn btn-inline btn-secondary btn-rounded btn-sm"><i
                            class="fa fa-angle-left"></i> Atrás</a>
                </div>
            </header>
            <div class="card-block">
                <form action="{{ route('egresadosn.update', $egresado->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="codigo">Código</label>
                            <input type="text" class="form-control" id="codigo" name="codigo"
                                value="{{ $egresado->codigo }}">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="apellido-paterno">Apellido
                                Paterno</label>
                            <input type="text" class="form-control" id="paterno" name="paterno"
                                value="{{ $egresado->paterno }}">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="materno">Apellido Materno</label>
                            <input type="text" class="form-control" id="materno" name="materno"
                                value="{{ $egresado->materno }}">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="nombres">Nombres</label>
                            <input type="text" class="form-control" id="nombres" name="nombres"
                                value="{{ $egresado->nombres }}">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="tipo_documento">Tipo de
                                documento</label>
                            <select class="form-control" id="tipo_documento" name="tipo_documento">
                                @foreach ($tip_doc as $index => $item_doc)
                                    <option value="{{ $index }}"
                                        {{ $egresado->tipo_documento == $item_doc ? 'selected' : '' }}>
                                        {{ $item_doc }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="documento">Documento</label>
                            <input type="text" class="form-control" id="documento" name="documento"
                                value="{{ $egresado->num_documento }}">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="direccion">Dirección</label>
                            <input type="text" class="form-control" id="direccion" name="direccion"
                                value="{{ $egresado->direccion }}">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="correo">Correo</label>
                            <input type="text" class="form-control" id="correo" name="correo"
                                value="{{ $egresado->correo }}">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="telefono">Teléfono</label>
                            <input type="text" class="form-control" id="telefono" name="telefono"
                                value="{{ $egresado->telefono }}">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="celular">Celular</label>
                            <input type="text" class="form-control" id="celular" name="celular"
                                value="{{ $egresado->celular }}">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="genero">Género</label>
                            <select class="form-control" id="genero" name="genero">
                                @foreach ($genero as $index => $item)
                                    <option value="{{ $index }}" {{ $egresado->sexo == $item ? 'selected' : '' }}>
                                        {{ $item }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="year">Año de egreso</label>
                            <select class="form-control" name="year" id="year">
                                @for ($i = date('Y'); $i >= 1970; $i--)
                                    <option value="{{ $i }}" {{ $egresado->anio == $i ? 'selected' : '' }}>
                                        {{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="ciclo">Ciclo</label>
                            <select class="form-control" name="ciclo" id="ciclo">
                                @foreach ($ciclos as $index => $ciclo)
                                    <option value="{{ $index }}"
                                        {{ $egresado->ciclo == $index ? 'selected' : '' }}>
                                        {{ $ciclo }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="f_ingreso">Semestre de ingreso</label>
                            <select class="form-control" name="f_ingreso" id="f_ingreso">
                                @for ($i = date('Y'); $i >= 1970; $i--)
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
                        <div class="form-group col-md-4">
                            <label for="f_egreso">Semestre de egreso</label>
                            <select class="form-control" name="f_egreso" id="f_egreso">
                                @for ($i = date('Y'); $i >= 1970; $i--)
                                    <option value="{{ $egresado->f_egreso }}"
                                        {{ $egresado->f_egreso == $i . '-II' ? 'selected' : '' }}>
                                        {{ $i }}-II
                                    </option>
                                    <option value="{{ $egresado->f_egreso }}"
                                        {{ $egresado->f_egreso == $i . '-I' ? 'selected' : '' }}>
                                        {{ $i }}-I
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="codigo_local">Código de Local</label>
                            <select class="form-control" style="width: auto" id="codigo_local" name="codigo_local">
                                @for ($i = 1; $i <= 200; $i++)
                                    @php
                                        $codigo = 'SL' . str_pad($i, 2, '0', STR_PAD_LEFT);
                                    @endphp
                                    <option value="{{ $codigo }}"
                                        {{ $egresado->codigo_local == $codigo ? 'selected' : '' }}>
                                        {{ $codigo }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="grado_academico">Grado
                                académico</label>
                            <select class="form-control" style="width: auto" id="grado_academico"
                                name="grado_academico">
                                @foreach ($grados as $grado)
                                    <option value="{{ $grado->id }}"
                                        {{ $egresado->grado_academico == $grado->descripcion ? 'selected' : '' }}>
                                        {{ Str::upper($grado->descripcion) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="genero">Facultad</label>
                            <select class="form-control" id="facultad_id" name="facultad_id">
                                @foreach ($facultades as $facultad)
                                    <option value="{{ $facultad->id }}"
                                        {{ $egresado->facultad_id == $facultad->id ? 'selected' : '' }}>
                                        {{ $facultad->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="year">Escuela</label>
                            <select class="form-control" id="escuela_id" name="escuela_id">
                                @foreach ($escuelas as $escuela)
                                    <option value="{{ $escuela->id }}"
                                        {{ $egresado->escuela_id == $escuela->id ? 'selected' : '' }}>
                                        {{ $escuela->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Guardar
                            Cambios</button>
                        <br><br>
                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection
@section('js')

@endsection
