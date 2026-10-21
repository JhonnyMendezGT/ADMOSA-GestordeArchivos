@extends('layouts.app')

@section('titulo', 'Registro')

@section('contenido')
<div class="caja">
    <h1>Crear cuenta</h1>

    {{-- Mensaje de éxito --}}
    @if (session('exito'))
        <div class="exito">{{ session('exito') }}</div>
    @endif

    {{-- Mensajes de error de validación --}}
    @if ($errors->any())
        <div class="error">
            @foreach ($errors->all() as $mensaje)
                <div>{{ $mensaje }}</div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('registro.guardar') }}">
        @csrf

        <label for="nombre">Nombre</label>
        <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" required>

        <label for="apellido">Apellido</label>
        <input type="text" id="apellido" name="apellido" value="{{ old('apellido') }}" required>

        <label for="correo">Correo</label>
        <input type="email" id="correo" name="correo" value="{{ old('correo') }}" required>

        <label for="password">Contraseña (mínimo 8 caracteres)</label>
        <input type="password" id="password" name="password" required>

        <label for="password_confirmation">Repetir contraseña</label>
        <input type="password" id="password_confirmation" name="password_confirmation" required>

        <button type="submit">Registrarme</button>
    </form>
</div>
@endsection