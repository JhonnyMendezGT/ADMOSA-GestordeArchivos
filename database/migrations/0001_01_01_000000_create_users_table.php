<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabla de usuarios, según tu diagrama
        Schema::create('tb_usuarios', function (Blueprint $table) {
            $table->id('id_usuario');                  // PK autoincremental
            $table->string('nombre', 50);
            $table->string('apellido', 50);
            $table->string('correo', 100)->unique();   // unique = no se repite
            $table->string('password', 255);           // aquí va el hash, no la contraseña real
            $table->rememberToken();
            $table->timestamps();
        });

        // Laravel guarda aquí las sesiones iniciadas (así sabe quién está logueado)
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('tb_usuarios');
    }
};