<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    // Le decimos a Laravel cómo se llama nuestra tabla y su llave primaria
    protected $table = 'tb_usuarios';
    protected $primaryKey = 'id_usuario';

    // Campos que se pueden llenar al crear un usuario
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

    // 'hashed' hace que la contraseña se cifre sola al guardarla
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    // Relación: un usuario tiene muchos archivos (la usaremos en el Paso 5)
    public function archivos()
    {
        return $this->hasMany(Archivo::class, 'id_usuario', 'id_usuario');
    }
}