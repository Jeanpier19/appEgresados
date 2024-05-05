@component('mail::layout')
![Seguimiento de Egresados](https://seguimiento.waraqod.com/img/logotipo-large.png)
{{-- Header --}}
@slot('header')
@endslot

{{-- Body --}}
¡Hola, <b>{{$empresa_nombre}}</b>!

En nombre de la Oficina General de Responsabilidad Social Universitaria Social Universitaria - <b>Dirección de Seguimiento y Certificación al Egresado</b>
Acerca del curso <b>{{$curso_nombre}}</b>, realizado con la <b>Universidad Nacional Santiago Antúnez de Mayolo</b> desde <i>{{Carbon\Carbon::create($fecha_inicio)->formatLocalized('%A %d de %B  de %Y')}}</i> a <i>{{\Carbon\Carbon::create($fecha_fin)->formatLocalized('%A %d de %B de %Y')}}</i>.
<br><br> Se realizó las siguientes recomendaciones, en base a las apreciaciones de los asistentes:
<br><br>{{$recomendacion}}
<br><br>A continuación se adjunta la evidencia de dichas apreciaciones:
<br><br>{{asset($imagen)}}
<br><br> Agradecemos su confianza por la participación conjunta en dicha actividad y los esperamos en futuros eventos.

<small>Porfavor no responda a este mensaje automatizado.</small>
{{-- Subcopy --}}
@slot('subcopy')
@component('mail::subcopy')
    <p style="text-align: center">Copyright {{ date('Y') }} UNASAM® - Todos los derechos reservados.</p>
@endcomponent
@endslot

{{-- Footer --}}
@slot('footer')
@endslot
@endcomponent
