<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_archivos', function (Blueprint $table) {
            $table->id();                                   // ID (PK)
            $table->uuid('uuid')->unique();                 // identificador único e imposible de adivinar
            $table->unsignedBigInteger('id_usuario');       // dueño del archivo (FK)
            $table->string('ruta_archivo', 250);
            $table->string('nombre_original', 250);
            $table->unsignedBigInteger('peso');             // tamaño en bytes
            $table->string('tipo_archivo', 100);
            $table->dateTime('fecha_creacion')->useCurrent();

            // Relación: cada archivo pertenece a un usuario.
            // onDelete('cascade') borra sus archivos si se borra el usuario.
            $table->foreign('id_usuario')
                  ->references('id_usuario')
                  ->on('tb_usuarios')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_archivos');
    }
};