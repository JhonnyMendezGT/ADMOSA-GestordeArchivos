<?php

namespace App\Policies;

use App\Models\Archivo;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ArchivoPolicy
{
    // ¿Puede ver/abrir/descargar este archivo?
    public function view(User $user, Archivo $archivo): Response
    {
        return $this->esDueno($user, $archivo);
    }

    // ¿Puede eliminar este archivo?
    public function delete(User $user, Archivo $archivo): Response
    {
        return $this->esDueno($user, $archivo);
    }

    private function esDueno(User $user, Archivo $archivo): Response
    {
        // Solo pasa si el dueño del archivo es quien tiene la sesión iniciada.
        // Si no, responde "no encontrado" para ni confirmar que el archivo existe.
        return (int) $user->id_usuario === (int) $archivo->id_usuario
            ? Response::allow()
            : Response::denyAsNotFound();
    }
}