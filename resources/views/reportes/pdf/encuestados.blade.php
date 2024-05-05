<html>
<head>
    <title>{{$nombre}}</title>
    <link rel="icon" href="{{asset('img/favicon.png')}}">
    <style>
        html {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
        }

        #header {
            position: fixed;
            top: 0px;
            left: 0px;
            z-index: -1000;
        }

        #footer {
            position: fixed;
            bottom: 0px;
            left: 0px;
            z-index: -1000;
        }

        table {
            padding-left: 40px;
            padding-right: 40px;
            width: 100%;
            border-spacing: 0;
            font-size: 12px;
        }

        .text-center {
            text-align: center;
        }

        .titulo {
            font-weight: bold;
            font-size: 18px;
            margin-top: 170px;
        }
        .subtitulo {
            margin-top: 30px;
            font-size: 12px;
        }
        .tabla-header{
            margin-top: 5px;
        }
        .tabla-header thead tr th.last{
            border-right: 1px solid #333;
        }

        .tabla-header thead tr th {
            border-left: 1px solid #333;
            border-top: 1px solid #333;
            border-bottom: 1px solid #333;
            padding: 5px 10px;
            background: #F5F5F5;
        }

        .tabla-header tbody tr td {
            border-left: 1px solid #333;
            border-bottom: 1px solid #333;
            padding: 2px;
        }
        .tabla-header tbody tr td.last{
            border-right: 1px solid #333;
        }
        .tabla-header tbody tr td.interpretacion{
            background: #F5F5F5;
        }

    </style>
</head>
<body>
<div id="watermark">
    <img src="{{asset('img/header.png')}}" width="100%">
</div>

<table class="titulo">
    <tr>
        <td class="text-center">REPORTE DE ENCUESTADOS</td>
    </tr>
</table>
<table class="subtitulo">
    <tr>
        <td><b>ENCUESTA: </b>{{$encuesta->titulo}}</td>
    </tr>
    <tr>
        <td><b>DESCRIPCIÓN: </b>{{$encuesta->descripcion}}</td>
    </tr>
    <tr>
        <td><b>CANT. ENCUESTADOS: </b>{{$cantidad}}</td>
    </tr>
    <tr>
        <td><b>FECHA: </b>{{$encuesta->fecha_apertura}}</td>
    </tr>
</table>
<table class="tabla-header">
    <thead>
    <tr>
        <th class="first">CÓDIGO</th>
        <th>APELLIDOS Y NOMBRES</th>
        <th class="last">FECHA DE LLENADO</th>
    </tr>
    </thead>
    <tbody>
    @foreach($encuestados as $encuestado)
        <tr>
            <td class="text-center">{{$encuestado->codigo}}</td>
            <td>{{$encuestado->apellidos_nombres}}</td>
            <td class="last text-center">{{$encuestado->fecha_llenado}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
<div id="footer">
    <img src="{{asset('img/footer.png')}}" width="100%">
</div>
</body>
</html>
