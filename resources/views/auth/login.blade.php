@extends('layouts.auth')

@section('content')
    <div class="page-center-in">
        <div class="container-fluid">
            <form class="sign-box" method="POST" action="{{ route('login') }}">
                @csrf
                <div class="text-center" style="padding: 4px; margin-bottom: 10px;">
                    <img src="{{asset('img/logotipo.png')}}" alt="" width="70px">
                </div>
                <header class="sign-title">Iniciar Sesión</header>
                <div class="form-group">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Correo electrónico"/>
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Contraseña">

                    @error('password')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <div class="checkbox float-left">
                        <input id="signed-in" class="checkbox form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label for="signed-in">Recordar</label>
                    </div>
                    <div class="float-right reset">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}">
                                {{ __('¿Olvidó su clave?') }}
                            </a>
                        @endif
                    </div>
                </div>
                <button type="submit" class="btn btn-rounded">Iniciar sesión</button>
                 <a href="{{route('register')}}">Registrarme</a>
                <!--<button type="button" class="close">
                    <span aria-hidden="true">&times;</span>
                </button>-->
            </form>
        </div>
    </div>
@endsection
