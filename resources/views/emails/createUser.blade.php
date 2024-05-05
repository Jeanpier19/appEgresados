@component('mail::layout')
![Seguimiento de Egresados](https://seguimiento.waraqod.com/img/logotipo-large.png)
{{-- Header --}}
@slot('header')
@endslot

{{-- Body --}}
¡Hola, <b>{{$nombres}}</b>!

Por favor pulsa el siguiente botón para terminar el proceso de registro en la plataforma.

@component('mail::button', ['url' => $link])
Continuar registro
@endcomponent

Si no has creado ninguna cuenta en <a href="https://seguimiento.waraqod.com">la plataforma</a>, puedes ignorar o eliminar este correo electrónico.<br>
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
