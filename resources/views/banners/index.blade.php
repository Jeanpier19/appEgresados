@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <section class="card">
            <header class="card-header">
                <div class="pull-left">
                    <ol class="breadcrumb breadcrumb-simple">
                        <li><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="active">Banners</li>
                    </ol>
                </div>
                <div class="pull-right">
                    <a href="{{ route('banners.create') }}" class="btn btn-inline btn-success btn-rounded btn-sm"><i
                            class="fa fa-plus-circle"></i>
                        Nuevo
                    </a>
                </div>
            </header>
            <div class="card-block">
                <table id="table" class="display table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead class="text-center align-middle">
                        <tr>
                            <th>N°</th>
                            <th>Nombre</th>
                            <th>Imagen</th>
                            <th>Fecha Fin</th>
                            <th>Temporalidad</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($banners as $banner)
                            <tr>
                                <td>{{ $banner->id }}</td>
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
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </div>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
    <link rel="stylesheet" href="{{asset('startui/css/lib/datatables-net/datatables.min.css')}}">
    <link rel="stylesheet" href="{{asset('startui/css/separate/vendor/datatables-net.min.css')}}">
@stop

@section('js')
    {{-- Para implementar el datatables --}}
    <script src="{{asset('startui/js/lib/datatables-net/datatables.min.js')}}"></script>
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
                text: "Banner creado con exito.",
                showConfirmButton: false,
                timer: 3500,
                width: 300, // Ancho del pop-up en píxeles
                height: 40, // Desactiva el ajuste automático de altura para permitir un pop-up más pequeño
                backdrop: false // Desactiva el fondo oscuro
            });
        </script>
    @endif

    @if (session('modificate') == 'Modifica')
        <script>
            Swal.fire({
                position: 'top-end',
                text: "Banner modificado con exito.",
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
                text: "Banner eliminado con exito.",
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
