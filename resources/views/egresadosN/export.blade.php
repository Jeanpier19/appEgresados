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
                <td style="text-align: center; border: 1px solid black;">{{ $index + 1 }}</td>
                <td style="text-align: center; border: 1px solid black;">{{ $egresado->anio }}</td>
                <td style="text-align: center; border: 1px solid black;">{{ $egresado->ciclo }}</td>
                <td style="text-align: center; border: 1px solid black;">{{ $egresado->codigo_local }}</td>
                <td style="text-align: center; border: 1px solid black;">{{ $egresado->facultad }}</td>
                <td style="text-align: center; border: 1px solid black;">{{ $egresado->escuela }}</td>
                <td style="text-align: center; border: 1px solid black;">{{ $egresado->codigo }}</td>
                <td style="text-align: center; border: 1px solid black;">{{ $egresado->num_documento }}</td>
                <td style="text-align: center; border: 1px solid black;">{{ $egresado->paterno }}</td>
                <td style="text-align: center; border: 1px solid black;">{{ $egresado->materno }}</td>
                <td style="text-align: center; border: 1px solid black;">{{ $egresado->nombres }}</td>
                <td style="text-align: center; border: 1px solid black;">{{ $egresado->f_ingreso }}</td>
                <td style="text-align: center; border: 1px solid black;">{{ $egresado->f_egreso }}</td>
                <td style="text-align: center; border: 1px solid black;">{{ $egresado->grado_academico }}</td>
                <td style="text-align: center; border: 1px solid black;">{{ $egresado->sexo }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
