<table>
    <thead>
        <tr>
            <th style="text-align: center; border: 1px solid black;">N°</th>
            <th style="text-align: center; border: 1px solid black;">ANIO</th>
            <th style="text-align: center; border: 1px solid black;">CICLO</th>
            <th style="text-align: center; border: 1px solid black;">CODIGO DE LOCAL</th>
            <th style="text-align: center; border: 1px solid black;">FACULTAD</th>
            <th style="text-align: center; border: 1px solid black;">ESCUELA</th>
            <th style="text-align: center; border: 1px solid black; color: red;">CODIGO ESTUDIANTE</th>
            <th style="text-align: center; border: 1px solid black;">DNI</th>
            <th style="text-align: center; border: 1px solid black;">APELLIDO PATERNO</th>
            <th style="text-align: center; border: 1px solid black;">APELLIDO MATERNO</th>
            <th style="text-align: center; border: 1px solid black;">NOMBRES</th>
            <th style="text-align: center; border: 1px solid black;">INGRESO</th>
            <th style="text-align: center; border: 1px solid black;">EGRESO</th>
            <th style="text-align: center; border: 1px solid black;">GRADO ACADEMICO</th>
            <th style="text-align: center; border: 1px solid black;">GENERO</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($egresados as $index => $egresado)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $egresado->anio }}</td>
                <td>{{ $egresado->ciclo }}</td>
                <td>{{ $egresado->codigo_local }}</td>
                <td>{{ $egresado->facultad }}</td>
                <td>{{ $egresado->escuela }}</td>
                <td>{{ $egresado->codigo }}</td>
                <td>{{ $egresado->num_documento }}</td>
                <td>{{ $egresado->paterno }}</td>
                <td>{{ $egresado->materno }}</td>
                <td>{{ $egresado->nombres }}</td>
                <td>{{ $egresado->f_ingreso }}</td>
                <td>{{ $egresado->f_egreso }}</td>
                <td>{{ $egresado->grado_academico }}</td>
                <td>{{ $egresado->sexo }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
