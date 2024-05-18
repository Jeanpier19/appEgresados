@extends('layouts.web')
@section('content')
    <section class="section-white" style="background: #f5f7fc;" id="contactanos">
        <div class="container"  style="margin-top: 70px;">
            <div class="row">
                <div class="col-md-6">
                    <img src="{{ asset('img/icons/contact-form.png') }}" alt="contactanos" width="50px">
                    <h3>Ponerse en contacto</h3>
                    <p class="contact_success_box" style="display:none;">Recibimos su mensaje, nos contactaremos
                        pronto</p>
                    <div id="mensaje_respuesta"></div>
                    <form id="form-contacto" class="contact" action="{{ route('mensajes.store') }}" method="POST">
                        @csrf
                        <input id="nombre" class="contact-input white-input" required="" name="nombre"
                            placeholder="Nombre completos*" type="text">
                        <input id="correo" class="contact-input white-input" required="" name="correo"
                            placeholder="Correo electrónico*" type="email">
                        <input id="telefono" class="contact-input white-input" required="" name="telefono"
                            placeholder="Número telefónico*" type="text">
                        <textarea id="mensaje" class="contact-commnent white-input" rows="2" cols="20" name="mensaje"
                            placeholder="Tu mensaje..." required></textarea>
                        <button id="enviar-mensaje" type="button" class="btn btn-primary btn-lg">Enviar mensaje</button>
                    </form>
                </div>
                <div class="col-md-6 responsive-top-margins">
                    <img src="{{ asset('img/icons/map.png') }}" alt="contactanos" width="50px">
                    <h3>Como encontrarnos</h3>
                    <iframe title=''
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3934.8581858167277!2d-77.52814641707347!3d-9.521048224930368!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x91a90d12eb234bf1%3A0xc860f66d7ad8abd9!2sUNIVERSIDAD%20NACIONAL%20SANTIAGO%20ANT%C3%9ANEZ%20DE%20MAYOLO!5e0!3m2!1ses-419!2spe!4v1639007778685!5m2!1ses-419!2spe"
                        width="600" height="270" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                    <img src="{{ asset('img/icons/note-book.png') }}" alt="contactanos" width="50px"
                        class="padding-top-10">
                    <h3>Oficina Central</h3>
                    <p class="contact-info"><i class="bi bi-geo-alt-fill"></i> Av. Centenario</p>
                    <p class="contact-info"><i class="bi bi-envelope-open-fill"></i> <a
                            href="mailto:ogrsu-dsce@unasam.edu.pe">ogrsu-dsce@unasam.edu.pe</a></p>
                    <p class="contact-info"><i class="bi bi-telephone-fill"></i><a href="tel:+51927628748"> +51
                            927628748</a></p>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#enviar-mensaje').on('click', function() {
                if ($('#form-contacto')[0].checkValidity()) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('mensajes.store') }}',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "nombre": $('#nombre').val(),
                            "correo": $('#correo').val(),
                            "telefono": $('#telefono').val(),
                            "mensaje": $('#mensaje').val(),
                        },
                        dataType: 'JSON',
                        beforeSend: function() {},
                        success: function(response) {
                            if (response.success) {
                                $('#mensaje_respuesta').html(
                                    '<div class="alert alert-success" role="alert">Hemos recibido tu mensaje, nos pondremos en contacto contigo a la brevedad</div>'
                                    );
                                $('#form-contacto')[0].reset();
                            } else {
                                $('#mensaje_respuesta').html(
                                    '<div class="alert alert-danger" role="alert">Hubo un error al enviar tu mensaje, intente nuevamente</div>'
                                    )
                            }
                        },
                        error: function(err) {
                            console.log(err);
                        }
                    });
                } else {
                    $('#mensaje_respuesta').html(
                        '<div class="alert alert-danger" role="alert">Ingrese todos lo datos.</div>')
                }
            });
        });
    </script>
@endsection
