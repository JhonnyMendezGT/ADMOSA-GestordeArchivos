@extends('layouts.app')

@section('titulo', 'Registro')

@section('contenido')
<div class="caja">

    @if (session('exito'))
        {{-- Pantalla de éxito: solo se muestra después de registrarse --}}
        <div class="exito-grande">
            <h1>¡Cuenta creada exitosamente!</h1>
            <p>Ya puedes iniciar sesión con tu correo y contraseña.</p>
            <a href="{{ route('login') }}" class="boton">Regresar al login</a>
        </div>
    @else
        <h1>Crear cuenta</h1>
        <p style="font-size:13px;color:#555;">Los campos con <span class="req">*</span> son obligatorios.</p>

        @if ($errors->any())
            <div class="error">
                @foreach ($errors->all() as $mensaje)
                    <div>{{ $mensaje }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('registro.guardar') }}">
            @csrf

            <label for="nombre">Nombre <span class="req">*</span></label>
            <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" required>

            <label for="apellido">Apellido <span class="req">*</span></label>
            <input type="text" id="apellido" name="apellido" value="{{ old('apellido') }}" required>

            <label for="correo">Correo <span class="req">*</span></label>
            <input type="email" id="correo" name="correo" value="{{ old('correo') }}" required>

            <label for="password">Contraseña (mínimo 8 caracteres) <span class="req">*</span></label>
            <input type="password" id="password" name="password" minlength="8" required>

            <label for="password_confirmation">Repetir contraseña <span class="req">*</span></label>
            <input type="password" id="password_confirmation" name="password_confirmation" required>

            <button type="submit">Registrarme</button>
        </form>

        <p class="enlace">¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia sesión</a></p>
    @endif

</div>
@endsection