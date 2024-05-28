@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <section class="card">
            <header class="card-header">
                <div class="pull-left">
                    <ol class="breadcrumb breadcrumb-simple">
                        <li><a href="{{ route('home') }}">Inicio</a></li>
                        <li><a href="{{ route('banners.index') }}">Banners</a></li>
                        <li class="active">Editar</li>
                    </ol>
                </div>
                <div class="pull-right">
                    <a href="{{ route('banners.index') }}" class="btn btn-inline btn-secondary btn-rounded btn-sm"><i
                            class="fa fa-angle-left"></i> Atrás</a>
                </div>
            </header>
            <div class="card-block">
                <form action="{{ route('banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre"
                            value="{{ $banner->nombre }}">
                    </div>
                    <div class="d-flex justify-content-between">
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <div class="form-group  m-2 mx-auto d-block">
                                <img src="/banner/{{ $banner->imagen }}" id="imagenMostrar" style="max-height: 250px;">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <div class="form-group m-2">
                                <label for="">Imagen</label>
                                <input type="file" class="form-control" id="imagen" name="imagen">
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="form-group">
                            <label for="">Temporalidad</label>
                            <select class="form-control" id="tempo_id" name="tempo_id">
                                @foreach ($temporalidades as $temporal)
                                    <option value="{{ $temporal->id }}"
                                        {{ $banner->tempo_id == $temporal->id ? 'selected' : '' }}>
                                        {{ $temporal->tempo }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="form-group">
                            <label for="">Fecha fin</label>
                            <input type="date" class="form-control " id="fecha_fin" name="fecha_fin"
                                value="{{ $banner->fecha_fin }}">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Guardar</button>
                </form>
            </div>
        </section>
    </div>
@endsection

@section('js')
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#imagen').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#imagenMostrar').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    @if (session('alerta') == 'No')
        <script>
            Swal.fire({
                title: "No guardado!",
                text: "Imagen no guardada correctamente.",
                icon: "warning"
            });
        </script>
    @endif
    <script>
        $(document).ready(function() {
            var $selectElement = $('#tempo_id');
            var $dateInput = $('#fecha_fin');

            function toggleDateInput() {
                if ($selectElement.prop('selectedIndex') === 1) {
                    $dateInput.prop('readonly', true);
                } else {
                    $dateInput.prop('readonly', false);
                }
            }

            // Llamar a la función al cargar la página
            toggleDateInput();

            // Añadir el evento change para llamar a la función cuando cambie la selección
            $selectElement.on('change', toggleDateInput);
        });
    </script>

    <script>
        document.getElementById('tempo_id').addEventListener('change', function() {
            var selectedValue = this.value;
            var fechaFinInput = document.getElementById('fecha_fin');

            // Reiniciar la fecha si se selecciona el segundo elemento
            if (selectedValue == '2') {
                fechaFinInput.value = ''; // Reiniciar la fecha
            }
        });
    </script>
@endsection
