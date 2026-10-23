<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    // Nombre de la traba y la PK
    protected $table = 'tb_usuarios';
    protected $primaryKey = 'id_usuario';

    // Campos para crear usuario
    protected $fillable = [
        'nombre',
        'apellido',
        'correo',
        'password',
    ];

    // Campos que nunca se muestran si el usuario se convierte a texto/JSON
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Funcion hashed - Contrasña al guardar
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    // Relación: un usuario tiene muchos archivos
    public function archivos()
    {
        return $this->hasMany(Archivo::class, 'id_usuario', 'id_usuario');
    }
}