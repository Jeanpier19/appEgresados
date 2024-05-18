@extends('layouts.web')
@section('content')
    <!-- Convenios -->
    <section class="section-grey medium-padding-bottom" id="convenios">
        <div class="container" style="margin-top: 70px;">
            <div class="row">
                <div class="col-md-12 text-center padding bottom-20">
                    <img src="{{ asset('img/icons/contract.png') }}" alt="oferta laboral" width="50px">
                    <h2>Convenios</h2>
                </div>
            </div>
            <div class="row justify-content-center">
                <img src="{{ asset($entidades->logo) }}" alt="pic" height="120px">
                @if (count($convenios) > 0)
                    @foreach ($convenios as $index => $convenio)
                        <div class="col-md-3 col-xs-6">
                            <div class="our-partners">
                                @if ($convenio->logo)
                                    <img src="{{ asset($convenio->logo) }}" alt="pic" height="120px">
                                    <div>
                                        <small>{{ strtoupper($convenio->nombre) }}</small>
                                    </div>
                                @else
                                    <div>
                                        <h6>{{ $convenio->nombre }}</h6>
                                    </div>
                                @endif

                            </div>
                        </div>
                    @endforeach
                    <div class="col-xs-12 text-center padding-top-30">
                        <a href="{{ route('convenios.page') }}" class="scrool">
                            <button type="button" class="btn btn-lg btn-primary">Ver todos <span
                                    class="badge badge-pill badge-light">{{ $convenios_total }}</span></button>
                        </a>
                    </div>
                @else
                    <p class="text-muted text-center">No hay convenios vigentes</p>
                @endif
            </div>
        </div>
    </section>
@endsection
