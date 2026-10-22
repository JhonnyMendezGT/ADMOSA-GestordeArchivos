@extends('layouts.app')

@section('titulo', 'Iniciar sesión')

@section('contenido')
<div class="caja">
    <h1>Iniciar sesión</h1>

    @if (session('exito'))
        <div class="exito">{{ session('exito') }}</div>
    @endif

    @if ($errors->any())
        <div class="error">
            @foreach ($errors->all() as $mensaje)
                <div>{{ $mensaje }}</div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('login.entrar') }}">
        @csrf

        <label for="correo">Correo <span class="req">*</span></label>
        <input type="email" id="correo" name="correo" value="{{ old('correo') }}" required>

        <label for="password">Contraseña <span class="req">*</span></label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Entrar</button>
    </form>

    <p class="enlace">¿No tienes cuenta? <a href="{{ route('registro') }}">Regístrate</a></p>
</div>
@endsection