<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    // Muestra el formulario de registro
    public function mostrarRegistro()
    {
        return view('auth.registro');
    }

    // Recibe el formulario, valida y crea el usuario
    public function registrar(Request $request)
    {
        $datos = $request->validate([
            'nombre'   => ['required', 'string', 'max:50'],
            'apellido' => ['required', 'string', 'max:50'],
            'correo'   => ['required', 'email', 'max:100', 'unique:tb_usuarios,correo'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'nombre.required'   => 'El nombre es obligatorio.',
            'apellido.required' => 'El apellido es obligatorio.',
            'correo.required'   => 'El correo es obligatorio.',
            'correo.email'      => 'Escribe un correo válido, por ejemplo: nombre@correo.com.',
            'correo.unique'     => 'Este correo ya está registrado. Intenta iniciar sesión.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min'      => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        // El modelo cifra la contraseña automáticamente (por el 'hashed' que pusimos)
        User::create($datos);

        return redirect()->route('registro')
            ->with('exito', '¡Cuenta creada correctamente! (En el siguiente paso agregamos el inicio de sesión).');
    }
}