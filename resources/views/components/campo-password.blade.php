@props(['id', 'name', 'label', 'placeholder' => '••••••••', 'minlength' => null])

<div>
    <label for="{{ $id }}" class="block text-sm font-medium text-zinc-700">{{ $label }}</label>

    <div class="relative mt-1.5">
        <input type="password" id="{{ $id }}" name="{{ $name }}" required
               placeholder="{{ $placeholder }}"
               @if ($minlength) minlength="{{ $minlength }}" @endif
               class="block w-full rounded-lg border border-zinc-300 bg-white py-2 pl-3 pr-10 text-sm placeholder:text-zinc-400 focus:border-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-900/10">

        <button type="button" aria-label="Mostrar contraseña"
                onclick="const i = document.getElementById('{{ $id }}'); const oculto = i.type === 'password'; i.type = oculto ? 'text' : 'password'; this.querySelector('[data-ver]').classList.toggle('hidden', oculto); this.querySelector('[data-ocultar]').classList.toggle('hidden', !oculto); this.setAttribute('aria-label', oculto ? 'Ocultar contraseña' : 'Mostrar contraseña');"
                class="absolute inset-y-0 right-0 flex items-center px-3 text-zinc-400 transition hover:text-zinc-700">

            {{-- Ojo abierto (contraseña oculta) --}}
            <svg data-ver class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
            </svg>

            {{-- Ojo tachado (contraseña visible) --}}
            <svg data-ocultar class="hidden size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
            </svg>
        </button>
    </div>
</div>