@extends('layouts.app')

@section('titulo', 'Mis archivos')

@section('contenido')
<div class="caja caja-ancha">

    <div class="encabezado">
        <h1>Mis archivos</h1>
        <div>
            <span>{{ auth()->user()->nombre }} {{ auth()->user()->apellido }}</span>
            <form method="POST" action="{{ route('logout') }}" class="en-linea">
                @csrf
                <button type="submit" class="btn-chico btn-gris">Cerrar sesión</button>
            </form>
        </div>
    </div>

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

    {{-- Formulario para subir --}}
    <div class="subida">
        <form method="POST" action="{{ route('archivos.subir') }}" enctype="multipart/form-data">
            @csrf
            <label for="archivo">Subir un archivo <span class="req">*</span></label>
            <input type="file" id="archivo" name="archivo" required>
            <p style="font-size:13px;color:#555;margin:6px 0 0;">
                Máximo 10 MB. Tipos permitidos: PDF, JPG, JPEG, PNG, TXT, DOCX, XLSX y PPTX.
            </p>
            <button type="submit">Subir archivo</button>
        </form>
    </div>

    {{-- Listado --}}
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Tipo</th>
                <th>Tamaño</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($archivos as $archivo)
                <tr>
                    <td>{{ $archivo->nombre_original }}</td>
                    <td>{{ $archivo->tipo_archivo }}</td>
                    <td>{{ $archivo->peso_legible }}</td>
                    <td>{{ $archivo->fecha_creacion?->format('d/m/Y H:i') }}</td>
                    <td>
                        <a href="{{ route('archivos.abrir', $archivo) }}" target="_blank" class="btn-chico">Abrir</a>
                        <a href="{{ route('archivos.descargar', $archivo) }}" class="btn-chico btn-gris">Descargar</a>

                        <form method="POST" action="{{ route('archivos.eliminar', $archivo) }}" class="en-linea"
                              onsubmit="return confirm('¿Seguro que quieres eliminar este archivo? No se puede deshacer.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-chico btn-rojo">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="vacio">Todavía no has subido archivos.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection