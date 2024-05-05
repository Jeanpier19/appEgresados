@extends('layouts.auth')

@section('content')
    <div class="page-center-in">
        <div class="container-fluid">
            <form class="sign-box" method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="text-center" style="padding: 4px; margin-bottom: 10px;">
                    <img src="{{asset('img/logotipo.png')}}" alt="" width="70px">
                </div>
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <header class="sign-title">Restablecer contraseña</header>
                <div class="form-group">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                           name="email" value="{{ old('email') }}" required autocomplete="email"
                           placeholder="Correo electrónico" autofocus>

                    @error('email')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-rounded">Restablecer contraseña</button>
            </form>
        </div>
    </div>
@endsection
