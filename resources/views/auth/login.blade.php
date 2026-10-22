@extends('layouts.app')

@section('titulo', 'Iniciar sesión')

@section('contenido')
<main class="flex min-h-screen items-center justify-center px-4 py-10">
    <div class="w-full max-w-sm">

        {{-- Encabezado --}}
        <div class="mb-8 text-center">
            <div class="mx-auto mb-4 flex size-11 items-center justify-center rounded-xl bg-zinc-900 text-white">
                <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 0 1 4.5 9.75h15A2.25 2.25 0 0 1 21.75 12v.75m-8.69-6.44-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z" />
                </svg>
            </div>
            <h1 class="text-2xl font-semibold tracking-tight">Bienvenido de nuevo</h1>
            <p class="mt-1 text-sm text-zinc-500">Inicia sesión para ver tus archivos</p>
        </div>

        {{-- Tarjeta --}}
        <div class="rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm">

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

            <form method="POST" action="{{ route('login.entrar') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="correo" class="block text-sm font-medium text-zinc-700">Correo</label>
                    <input type="email" id="correo" name="correo" value="{{ old('correo') }}" required
                           placeholder="nombre@correo.com"
                           class="mt-1.5 block w-full rounded-lg border border-zinc-300 bg-white px-3 py-2 text-sm placeholder:text-zinc-400 focus:border-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-900/10">
                </div>

                <div>
                    <x-campo-password id="password" name="password" label="Contraseña" />
                </div>

                <button type="submit"
                        class="w-full rounded-lg bg-zinc-900 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-zinc-700">
                    Entrar
                </button>
            </form>
        </div>

        <p class="mt-6 text-center text-sm text-zinc-500">
            ¿No tienes cuenta?
            <a href="{{ route('registro') }}" class="font-medium text-zinc-900 underline-offset-4 hover:underline">Regístrate</a>
        </p>
    </div>
</main>
@endsection