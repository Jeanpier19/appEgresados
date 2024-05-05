@component('mail::layout')
![Seguimiento de Egresados](https://seguimiento.waraqod.com/img/logotipo-large.png)
{{-- Header --}}
@slot('header')
@endslot

{{-- Body --}}
<b>Nombre:</b><br>
{{$message->nombre}}<br>
<b>Correo:</b><br>
{{$message->correo}}<br>
<b>Teléfono:</b><br>
{{$message->telefono}}<br>
<b>Mensaje:</b><br>
{{$message->mensaje}}<br>

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
