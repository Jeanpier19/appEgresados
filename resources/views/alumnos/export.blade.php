<table>
    <thead>
        <tr>
            <th style="text-align: center; border: 1px solid black;">N°</th>
            <th style="text-align: center; border: 1px solid black;">ESCUELA</th>
            <th style="text-align: center; border: 1px solid black; color: red;">CODIGO ESTUDIANTE</th>
            <th style="text-align: center; border: 1px solid black;">DNI</th>
            <th style="text-align: center; border: 1px solid black;">APELLIDO PATERNO</th>
            <th style="text-align: center; border: 1px solid black;">APELLIDO MATERNO</th>
            <th style="text-align: center; border: 1px solid black;">NOMBRES</th>
            <th style="text-align: center; border: 1px solid black;">GRADO ACADEMICO</th>
            <th style="text-align: center; border: 1px solid black;">GENERO</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($alumnos as $index => $alumno)
            <tr>
                <td style="text-align: center; border: 1px solid black;">{{ $index + 1 }}</td>
                <td style="text-align: center; border: 1px solid black;">{{ $alumno->escuela }}</td>
                <td style="text-align: center; border: 1px solid black;">{{ $alumno->codigo }}</td>
                <td style="text-align: center; border: 1px solid black;">{{ $alumno->num_documento }}</td>
                <td style="text-align: center; border: 1px solid black;">{{ $alumno->paterno }}</td>
                <td style="text-align: center; border: 1px solid black;">{{ $alumno->materno }}</td>
                <td style="text-align: center; border: 1px solid black;">{{ $alumno->nombres }}</td>
                <td style="text-align: center; border: 1px solid black;">{{ $alumno->grado_academico }}</td>
                <td style="text-align: center; border: 1px solid black;">{{ $alumno->sexo }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
