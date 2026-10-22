@extends('layouts.app')

@section('titulo', 'Mis archivos')

@section('contenido')

{{-- Barra superior --}}
<header class="border-b border-zinc-200 bg-white">
    <div class="mx-auto flex max-w-4xl items-center justify-between px-4 py-3">
        <div class="flex items-center gap-2.5">
            <div class="flex size-8 items-center justify-center rounded-lg bg-zinc-900 text-white">
                <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 0 1 4.5 9.75h15A2.25 2.25 0 0 1 21.75 12v.75m-8.69-6.44-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z" />
                </svg>
            </div>
            <span class="text-sm font-semibold tracking-tight">Gestión de Archivos</span>
        </div>

        <div class="flex items-center gap-3">
            <div class="flex items-center gap-2">
                <div class="flex size-8 items-center justify-center rounded-full bg-zinc-100 text-xs font-semibold text-zinc-700">
                    {{ mb_strtoupper(mb_substr(auth()->user()->nombre, 0, 1)) }}{{ mb_strtoupper(mb_substr(auth()->user()->apellido, 0, 1)) }}
                </div>
                <span class="hidden text-sm text-zinc-600 sm:inline">
                    {{ auth()->user()->nombre }} {{ auth()->user()->apellido }}
                </span>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" title="Cerrar sesión" aria-label="Cerrar sesión"
                        class="flex items-center gap-1.5 rounded-lg border border-zinc-200 px-3 py-1.5 text-sm text-zinc-600 transition hover:bg-zinc-50 hover:text-zinc-900">
                    <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                    </svg>
                    <span class="hidden sm:inline">Salir</span>
                </button>
            </form>
        </div>
    </div>
</header>

<main class="mx-auto max-w-4xl px-4 py-8">

    <div class="mb-6">
        <h1 class="text-2xl font-semibold tracking-tight">Mis archivos</h1>
        <p class="mt-1 text-sm text-zinc-500">Sube, consulta y administra tus documentos.</p>
    </div>

    {{-- Mensajes --}}
    @if (session('exito'))
        <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-3 py-2 text-sm text-emerald-700">
            {{ session('exito') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-3 py-2 text-sm text-red-700">
            @foreach ($errors->all() as $mensaje)
                <div>{{ $mensaje }}</div>
            @endforeach
        </div>
    @endif

    {{-- Subir archivo --}}
    <form method="POST" action="{{ route('archivos.subir') }}" enctype="multipart/form-data" class="mb-8">
        @csrf

        <label id="zona" for="archivo"
               class="flex cursor-pointer flex-col items-center justify-center rounded-2xl border-2 border-dashed border-zinc-300 bg-white px-4 py-10 text-center transition hover:border-zinc-400 hover:bg-zinc-50">
            <div class="mb-3 flex size-11 items-center justify-center rounded-full bg-zinc-100 text-zinc-600">
                <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5" />
                </svg>
            </div>
            <p class="text-sm font-medium text-zinc-700">
                Arrastra un archivo aquí o <span class="underline underline-offset-4">haz clic para elegir</span>
            </p>
            <p class="mt-1 text-xs text-zinc-500">PDF, JPG, PNG, TXT, DOCX, XLSX o PPTX · Máximo 10 MB</p>

            <p id="nombre-archivo" class="mt-3 text-sm font-medium text-zinc-900"></p>
            <p id="aviso-archivo" class="mt-1 text-sm text-red-600"></p>

            <input type="file" id="archivo" name="archivo" required class="sr-only">
        </label>

        <div class="mt-3 flex justify-end">
            <button type="submit" id="btn-subir" disabled
                    class="rounded-lg bg-zinc-900 px-5 py-2.5 text-sm font-medium text-white transition hover:bg-zinc-700 disabled:cursor-not-allowed disabled:opacity-40 disabled:hover:bg-zinc-900">
                Subir archivo
            </button>
        </div>
    </form>

    {{-- Listado --}}
    <div class="overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-sm">

        <div class="flex items-center justify-between border-b border-zinc-200 px-4 py-3">
            <h2 class="text-sm font-semibold">Archivos subidos</h2>
            <span class="rounded-full bg-zinc-100 px-2.5 py-0.5 text-xs font-medium text-zinc-600">
                {{ $archivos->count() }}
            </span>
        </div>

        @forelse ($archivos as $archivo)
            @php
                $ext = strtoupper(pathinfo($archivo->nombre_original, PATHINFO_EXTENSION)) ?: 'FILE';
                $color = match ($ext) {
                    'PDF'              => 'bg-red-50 text-red-600',
                    'JPG', 'JPEG', 'PNG' => 'bg-violet-50 text-violet-600',
                    'DOCX'             => 'bg-blue-50 text-blue-600',
                    'XLSX'             => 'bg-emerald-50 text-emerald-600',
                    'PPTX'             => 'bg-orange-50 text-orange-600',
                    default            => 'bg-zinc-100 text-zinc-600',
                };
            @endphp

            <div class="flex items-center gap-3 border-b border-zinc-100 px-4 py-3 last:border-b-0">

                {{-- Insignia del tipo --}}
                <div class="flex size-10 shrink-0 items-center justify-center rounded-lg text-[10px] font-bold {{ $color }}">
                    {{ $ext }}
                </div>

                {{-- Nombre, tamaño y fecha --}}
                <div class="min-w-0 flex-1">
                    <p class="truncate text-sm font-medium" title="{{ $archivo->nombre_original }}">
                        {{ $archivo->nombre_original }}
                    </p>
                    <p class="text-xs text-zinc-500">
                        {{ $archivo->peso_legible }}
                        <span class="hidden sm:inline">· {{ $archivo->fecha_creacion?->format('d/m/Y H:i') }}</span>
                    </p>
                </div>

                {{-- Acciones --}}
                <div class="flex shrink-0 items-center gap-1">
                    <a href="{{ route('archivos.abrir', $archivo) }}" target="_blank" title="Abrir" aria-label="Abrir"
                       class="rounded-lg p-2 text-zinc-500 transition hover:bg-zinc-100 hover:text-zinc-900">
                        <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                    </a>

                    <a href="{{ route('archivos.descargar', $archivo) }}" title="Descargar" aria-label="Descargar"
                       class="rounded-lg p-2 text-zinc-500 transition hover:bg-zinc-100 hover:text-zinc-900">
                        <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                        </svg>
                    </a>

                    <form method="POST" action="{{ route('archivos.eliminar', $archivo) }}"
                          onsubmit="return confirm('¿Seguro que quieres eliminar este archivo? No se puede deshacer.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" title="Eliminar" aria-label="Eliminar"
                                class="rounded-lg p-2 text-zinc-500 transition hover:bg-red-50 hover:text-red-600">
                            <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="px-4 py-14 text-center">
                <p class="text-sm font-medium text-zinc-700">Todavía no has subido archivos</p>
                <p class="mt-1 text-xs text-zinc-500">Cuando subas uno, aparecerá aquí.</p>
            </div>
        @endforelse
    </div>
</main>

<script>
(function () {
    const zona    = document.getElementById('zona');
    const input   = document.getElementById('archivo');
    const boton   = document.getElementById('btn-subir');
    const nombre  = document.getElementById('nombre-archivo');
    const aviso   = document.getElementById('aviso-archivo');

    const permitidas = ['pdf', 'jpg', 'jpeg', 'png', 'txt', 'docx', 'xlsx', 'pptx'];
    const MAXIMO = 10 * 1024 * 1024; // 10 MB en bytes

    // Revisa el archivo elegido y habilita o no el botón
    function revisar() {
        const f = input.files[0];
        aviso.textContent = '';

        if (!f) {
            nombre.textContent = '';
            boton.disabled = true;
            return;
        }

        nombre.textContent = f.name + ' (' + (f.size / 1048576).toFixed(2) + ' MB)';

        const ext = f.name.split('.').pop().toLowerCase();

        if (!permitidas.includes(ext)) {
            aviso.textContent = 'Tipo de archivo no permitido. Solo se aceptan: PDF, JPG, JPEG, PNG, TXT, DOCX, XLSX y PPTX.';
            boton.disabled = true;
            return;
        }

        if (f.size > MAXIMO) {
            aviso.textContent = 'El archivo es demasiado grande. El tamaño máximo es 10 MB.';
            boton.disabled = true;
            return;
        }

        boton.disabled = false;
    }

    input.addEventListener('change', revisar);

    // Resaltar la zona mientras se arrastra encima
    ['dragenter', 'dragover'].forEach(function (ev) {
        zona.addEventListener(ev, function (e) {
            e.preventDefault();
            zona.classList.add('border-zinc-900', 'bg-zinc-50');
        });
    });

    ['dragleave', 'drop'].forEach(function (ev) {
        zona.addEventListener(ev, function (e) {
            e.preventDefault();
            zona.classList.remove('border-zinc-900', 'bg-zinc-50');
        });
    });

    // Al soltar, pasamos el archivo al campo del formulario
    zona.addEventListener('drop', function (e) {
        if (e.dataTransfer.files.length) {
            input.files = e.dataTransfer.files;
            revisar();
        }
    });

    revisar();
})();
</script>

@endsection