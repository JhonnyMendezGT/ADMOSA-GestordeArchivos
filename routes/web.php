<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Página principal: si hay sesión va al panel, si no, al login
Route::get('/', function () {
    return auth()->check() ? redirect()->route('panel') : redirect()->route('login');
});

// Rutas para quien NO ha iniciado sesión
Route::middleware('guest')->group(function () {
    Route::get('/registro', [AuthController::class, 'mostrarRegistro'])->name('registro');
    Route::post('/registro', [AuthController::class, 'registrar'])->name('registro.guardar');

    Route::get('/login', [AuthController::class, 'mostrarLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.entrar');
});

// Rutas para quien SÍ ha iniciado sesión
Route::middleware('auth')->group(function () {
    Route::get('/panel', function () {
        return view('panel');
    })->name('panel');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});