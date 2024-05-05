@component('mail::layout')
![Seguimiento de Egresados](https://seguimiento.waraqod.com/img/logotipo-large.png)
{{-- Header --}}
@slot('header')
@endslot

{{-- Body --}}
¡Hola, <b>{{$entidad->nombre}}</b>!

El convenio <b>{{$convenio->tipo_convenio}}</b> denominado <b>{{$convenio->nombre}}</b>, realizado con la <b>Universidad Nacional Santiago Antúnez de Mayolo</b> el <i>{{Carbon\Carbon::create($convenio->fecha_inicio)->formatLocalized('%A %d de %B  de %Y')}}</i> está próximo a finalizar el <i>{{\Carbon\Carbon::create($convenio->fecha_vencimiento)->formatLocalized('%A %d de %B de %Y')}}</i>.
<br><br> Por favor comuniquese con la Oficina General de Responsabilidad Social Universitario para renovar el convenio.

<small>No responda este mensaje automatizado.</small>
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
