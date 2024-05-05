@extends('layouts.auth')

@section('content')
    <div class="page-center-in">
        <div class="container-fluid">
            <form class="sign-box" method="POST" action="{{ route('register') }}">
                @csrf
                <div class="text-center" style="padding: 4px; margin-bottom: 10px;">
                    <img src="{{asset('img/logotipo.png')}}" alt="" width="70px">
                </div>
                <header class="sign-title">Registrarme</header>
                <input type="hidden" name="codigo" value="{{$codigo}}">
                <div class="form-group">
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                           value="{{ $codigo ?? old('codigo') }}" required autocomplete="name" autofocus placeholder="Código" readonly>
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                           name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" placeholder="Correo electrónico" readonly>
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <input id="password" type="password"
                           class="form-control @error('password') is-invalid @enderror" name="password"
                           required autocomplete="new-password" placeholder="Contraseña">

                    @error('password')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <input id="password-confirm" type="password" class="form-control"
                           name="password_confirmation" required autocomplete="new-password" placeholder="Confirmar contraseña">
                </div>
                <button type="submit" class="btn btn-rounded btn-primary sign-up">Registrarme</button>
            </form>
        </div>
    </div>
@endsection
