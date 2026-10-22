<?php

use App\Http\Controllers\ArchivoController;
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
        Route::get('/panel', [ArchivoController::class, 'index'])->name('panel');
        Route::post('/archivos', [ArchivoController::class, 'store'])->name('archivos.subir');
        Route::get('/archivos/{archivo}', [ArchivoController::class, 'show'])->name('archivos.abrir');
        Route::get('/archivos/{archivo}/descargar', [ArchivoController::class, 'download'])->name('archivos.descargar');
        Route::delete('/archivos/{archivo}', [ArchivoController::class, 'destroy'])->name('archivos.eliminar');
        

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});