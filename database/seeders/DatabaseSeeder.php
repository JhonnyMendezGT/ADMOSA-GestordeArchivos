<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $usuarios = [
            ['nombre' => 'Usuario', 'apellido' => 'Uno',  'correo' => 'usuario1@prueba.com', 'password' => 'Prueba1234'],
            ['nombre' => 'Usuario', 'apellido' => 'Dos',  'correo' => 'usuario2@prueba.com', 'password' => 'Prueba1234'],
        ];

        foreach ($usuarios as $datos) {
            // Si el correo ya existe, no lo duplica
            User::firstOrCreate(['correo' => $datos['correo']], $datos);
        }
    }
}