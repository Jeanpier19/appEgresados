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