<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // ---------- REGISTRO ----------

    public function mostrarRegistro()
    {
        return view('auth.registro');
    }

    public function registrar(Request $request)
    {
        $datos = $request->validate([
            'nombre'   => ['required', 'string', 'max:50'],
            'apellido' => ['required', 'string', 'max:50'],
            'correo'   => ['required', 'email', 'max:100', 'unique:tb_usuarios,correo'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'nombre.required'    => 'El nombre es obligatorio.',
            'apellido.required'  => 'El apellido es obligatorio.',
            'correo.required'    => 'El correo es obligatorio.',
            'correo.email'       => 'Escribe un correo válido, por ejemplo: nombre@correo.com.',
            'correo.unique'      => 'Este correo ya está registrado. Intenta iniciar sesión.',
            'password.required'  => 'La contraseña es obligatoria.',
            'password.min'       => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        User::create($datos);

        return redirect()->route('registro')->with('exito', true);
    }

    // ---------- LOGIN ----------

    public function mostrarLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credenciales = $request->validate([
            'correo'   => ['required', 'email'],
            'password' => ['required'],
        ], [
            'correo.required'   => 'Escribe tu correo.',
            'correo.email'      => 'Escribe un correo válido.',
            'password.required' => 'Escribe tu contraseña.',
        ]);

        // Auth::attempt busca el usuario por correo y compara la contraseña con el hash
        if (Auth::attempt($credenciales)) {
            // Por seguridad, se crea una sesión nueva al entrar
            $request->session()->regenerate();
            return redirect()->intended(route('panel'));
        }

        return back()
            ->withErrors(['correo' => 'El correo o la contraseña son incorrectos.'])
            ->onlyInput('correo');
    }

    // ---------- LOGOUT ----------

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();       // destruye la sesión
        $request->session()->regenerateToken();  // cambia el token de seguridad

        return redirect()->route('login')->with('exito', 'Sesión cerrada correctamente.');
    }
}