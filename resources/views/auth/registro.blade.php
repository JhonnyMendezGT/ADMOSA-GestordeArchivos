@extends('layouts.app')

@section('titulo', 'Crear cuenta')

@section('contenido')
<main class="flex min-h-screen items-center justify-center px-4 py-10">
    <div class="w-full max-w-md">

        @if (session('exito'))
            {{-- Pantalla de éxito: solo aparece justo después de registrarse --}}
            <div class="rounded-2xl border border-zinc-200 bg-white p-8 text-center shadow-sm">
                <div class="mx-auto mb-4 flex size-12 items-center justify-center rounded-full bg-emerald-50 text-emerald-600">
                    <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                    </svg>
                </div>
                <h1 class="text-2xl font-semibold tracking-tight">¡Cuenta creada exitosamente!</h1>
                <p class="mt-2 text-sm text-zinc-500">Ya puedes iniciar sesión con tu correo y contraseña.</p>

                <a href="{{ route('login') }}"
                   class="mt-6 block w-full rounded-lg bg-zinc-900 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-zinc-700">
                    Regresar al login
                </a>
            </div>
        @else
            {{-- Encabezado --}}
            <div class="mb-8 text-center">
                <div class="mx-auto mb-4 flex size-11 items-center justify-center rounded-xl bg-zinc-900 text-white">
                    <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                    </svg>
                </div>
                <h1 class="text-2xl font-semibold tracking-tight">Crea tu cuenta</h1>
                <p class="mt-1 text-sm text-zinc-500">
                    Los campos con <span class="text-red-500">*</span> son obligatorios
                </p>
            </div>

            {{-- Tarjeta --}}
            <div class="rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm">

                @if ($errors->any())
                    <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-3 py-2 text-sm text-red-700">
                        @foreach ($errors->all() as $mensaje)
                            <div>{{ $mensaje }}</div>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('registro.guardar') }}" class="space-y-4">
                    @csrf

                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label for="nombre" class="block text-sm font-medium text-zinc-700">
                                Nombre <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" required maxlength="50"
                                   class="mt-1.5 block w-full rounded-lg border border-zinc-300 bg-white px-3 py-2 text-sm placeholder:text-zinc-400 focus:border-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-900/10">
                        </div>

                        <div>
                            <label for="apellido" class="block text-sm font-medium text-zinc-700">
                                Apellido <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="apellido" name="apellido" value="{{ old('apellido') }}" required maxlength="50"
                                   class="mt-1.5 block w-full rounded-lg border border-zinc-300 bg-white px-3 py-2 text-sm placeholder:text-zinc-400 focus:border-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-900/10">
                        </div>
                    </div>

                    <div>
                        <label for="correo" class="block text-sm font-medium text-zinc-700">
                            Correo <span class="text-red-500">*</span>
                        </label>
                        <input type="email" id="correo" name="correo" value="{{ old('correo') }}" required maxlength="100"
                               placeholder="nombre@correo.com"
                               class="mt-1.5 block w-full rounded-lg border border-zinc-300 bg-white px-3 py-2 text-sm placeholder:text-zinc-400 focus:border-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-900/10">
                    </div>

                    <x-campo-password id="password" name="password" label="Contraseña *" minlength="8" />
                    <p class="-mt-2 text-xs text-zinc-500">Mínimo 8 caracteres.</p>

                    <x-campo-password id="password_confirmation" name="password_confirmation" label="Repetir contraseña *" />

                    <button type="submit"
                            class="w-full rounded-lg bg-zinc-900 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-zinc-700">
                        Registrarme
                    </button>
                </form>
            </div>

            <p class="mt-6 text-center text-sm text-zinc-500">
                ¿Ya tienes cuenta?
                <a href="{{ route('login') }}" class="font-medium text-zinc-900 underline-offset-4 hover:underline">Inicia sesión</a>
            </p>
        @endif

    </div>
</main>
@endsection