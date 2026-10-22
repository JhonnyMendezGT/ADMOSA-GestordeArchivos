<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Archivo extends Model
{
    protected $table = 'tb_archivos';

    // Nuestra tabla usa 'fecha_creacion' y no created_at/updated_at
    public $timestamps = false;

    protected $fillable = [
        'uuid',
        'id_usuario',
        'ruta_archivo',
        'nombre_original',
        'peso',
        'tipo_archivo',
    ];

    protected function casts(): array
    {
        return [
            'fecha_creacion' => 'datetime',
        ];
    }

    // En las URLs se usa el UUID y no el ID numérico (imposible de adivinar)
    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario', 'id_usuario');
        
    }
        // Devuelve el tamaño en formato legible: "850 B", "12.5 KB", "3.2 MB"
    public function getPesoLegibleAttribute(): string
    {
        $bytes = (int) $this->peso;

        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 1) . ' MB';
        }

        if ($bytes >= 1024) {
            return number_format($bytes / 1024, 1) . ' KB';
        }

        return $bytes . ' B';
    }
}