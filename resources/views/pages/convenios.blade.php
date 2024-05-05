@extends('layouts.web')
@section('content')
    <section class="section-grey padding-bottom-0 padding-top-150">
        <div class="container">
            <div class="row align-items-center text-center">
                <div class="row">
                    <div class="col-md-12 text-center padding-bottom-20">
                        <img src="{{asset('img/icons/contract.png')}}" alt="oferta laboral" width="50px">
                        <h2>Convenios</h2>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section-white medium-padding-bottom" id="convenios">
        <div class="container">
            <div class="row justify-content-center">
                @if($convenios)
                    @foreach($convenios as $index => $convenio)
                        <div class="col-md-3 col-xs-6">
                            <div class="our-partners">
                                @if($convenio->logo)
                                    <img src="{{asset($convenio->logo)}}"
                                         alt="pic" height="120px">
                                    <div>
                                        <small>{{strtoupper($convenio->nombre)}}</small>
                                    </div>
                                @else
                                    <div>
                                        <h6>{{$convenio->nombre}}</h6>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                    <div class="d-flex justify-content-center padding-top-30">
                        {!! $convenios->links() !!}
                    </div>
                @else
                    <p class="text-muted text-center">No hay convenios vigentes</p>
                @endif
            </div>
        </div>
    </section>
@endsection
