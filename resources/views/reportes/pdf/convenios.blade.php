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
            font-size: 10px;
        }

        .tabla-header {
            margin-top: 20px;
        }

        .tabla-header thead tr th.last {
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

        .tabla-header tbody tr td.last {
            border-right: 1px solid #333;
        }

        .tabla-header tbody tr td.detalle {
            background: #F5F5F5;
        }

    </style>
</head>
<body>
<div id="header">
    <img src="{{asset('img/header.png')}}" width="100%">
</div>

<table class="titulo">
    <tr>
        <td class="text-center">REPORTE DE CONVENIOS</td>
    </tr>
</table>
<table>
    <tr class="subtitulo">
        <td class="text-center">{{implode(', ',$filtros)}}</td>
    </tr>
</table>
<table class="tabla-header">
    <thead>
    <tr>
        <th class="first">N°</th>
        <th>ENTIDAD</th>
        <th>TIPO CONVENIO</th>
        <th>FECHA DE INICIO</th>
        <th>FECHA DE VENCIMIENTO</th>
        <th>DIAS RESTANTES</th>
        <th>VIGENCIA</th>
        <th class="last">ESTADO</th>
    </tr>
    </thead>
    <tbody>
    @foreach($convenios as $convenio)
        <tr>
            <td class="text-center">{{$convenio->id}}</td>
            <td>{{$convenio->entidad}}</td>
            <td class="text-center">{{$convenio->tipo_convenio}}</td>
            <td class="text-center">{{ \Carbon\Carbon::create($convenio->fecha_inicio)->format('d-m-Y')}}</td>
            <td class="text-center">{{Carbon\Carbon::create($convenio->fecha_vencimiento)->format('d-m-Y')}}</td>
            <td class="text-center">{{$convenio->dias_restantes}}</td>
            <td class="text-center">{{$convenio->vigencia}}</td>
            <td class="last text-center">{{$convenio->estado}}</td>
        </tr>
        <tr>
            <td colspan="2" class="text-left detalle">
                <b>OBJETIVO</b>
            </td>
            <td colspan="6" class="last">
                {{$convenio->objetivo}}
            </td>
        </tr>
        <tr>
            <td colspan="2" class="text-right detalle">
                <b>OBLIGACIONES</b>
            </td>
            <td colspan="6" class="last">
                {{$convenio->obligaciones}}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<div id="footer">
    <img src="{{asset('img/footer.png')}}" width="100%">
</div>
</body>
</html>
