@extends('layouts.app')

@section('titulo', 'Panel')

@section('contenido')
<div class="caja">
    <h1>Hola, {{ auth()->user()->nombre }} {{ auth()->user()->apellido }}</h1>
    <p>Has iniciado sesión correctamente. Aquí irá la gestión de archivos.</p>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Cerrar sesión</button>
    </form>
</div>
@endsection