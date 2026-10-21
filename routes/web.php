<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('registro');
});

use App\Http\Controllers\AuthController;

Route::get('/registro', [AuthController::class, 'mostrarRegistro'])->name('registro');
Route::post('/registro', [AuthController::class, 'registrar'])->name('registro.guardar');