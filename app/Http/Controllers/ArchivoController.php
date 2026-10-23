<?php

namespace App\Http\Controllers;

use App\Models\Archivo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArchivoController extends Controller
{
    // Disco donde se guardan los archivos (definido en config/filesystems.php)
    private const DISCO = 'archivos';

    // Lista SOLO los archivos del usuario con sesión iniciada
    public function index(Request $request)
    {
        $archivos = $request->user()
            ->archivos()
            ->orderByDesc('fecha_creacion')
            ->get();

        return view('panel', compact('archivos'));
    }

    // Sube un archivo
    public function store(Request $request)
    {
        $request->validate([
            'archivo' => ['required', 'file', 'max:10240', 'mimes:pdf,jpg,jpeg,png,txt,json,docx,xlsx,pptx,zip,rar'],
        ], [
            'archivo.required' => 'Selecciona un archivo para subir.',
            'archivo.file'     => 'Lo que seleccionaste no es un archivo válido.',
            'archivo.uploaded' => 'No se pudo subir el archivo. Puede superar el tamaño máximo de 10 MB.',
            'archivo.max'      => 'El archivo es demasiado grande. El tamaño máximo es 10 MB.',
            'archivo.mimes'    => 'Tipo de archivo no permitido. Solo se aceptan: PDF, JPG, JPEG, PNG, TXT, JSON, DOCX, XLSX, PPTX, ZIP y RAR.',
        ]);

        $archivo = $request->file('archivo');
        $usuario = $request->user();

        // Se guarda en el disco con nombre aleatorio, dentro de una carpeta por usuario
        $ruta = $archivo->store((string) $usuario->id_usuario, self::DISCO);

        Archivo::create([
            'uuid'            => (string) Str::uuid(),
            'id_usuario'      => $usuario->id_usuario,
            'ruta_archivo'    => $ruta,
            'nombre_original' => Str::limit($archivo->getClientOriginalName(), 250, ''),
            'peso'            => $archivo->getSize(),
            'tipo_archivo'    => $archivo->getMimeType(),
        ]);

        return back()->with('exito', 'Archivo subido correctamente.');
    }

    // Abre el archivo en el navegador
    public function show(Archivo $archivo)
    {
        Gate::authorize('view', $archivo);

        $disco = Storage::disk(self::DISCO);

        if (! $disco->exists($archivo->ruta_archivo)) {
            abort(404, 'El archivo ya no está disponible en el servidor.');
        }

        return $disco->response($archivo->ruta_archivo, $archivo->nombre_original, [
            'Content-Type'           => $archivo->tipo_archivo,
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }

    // Descarga el archivo con su nombre original
    public function download(Archivo $archivo)
    {
        Gate::authorize('view', $archivo);

        $disco = Storage::disk(self::DISCO);

        if (! $disco->exists($archivo->ruta_archivo)) {
            abort(404, 'El archivo ya no está disponible en el servidor.');
        }

        return $disco->download($archivo->ruta_archivo, $archivo->nombre_original);
    }

    // Elimina el archivo (del disco y de la base de datos)
    public function destroy(Archivo $archivo)
    {
        Gate::authorize('delete', $archivo);

        Storage::disk(self::DISCO)->delete($archivo->ruta_archivo);
        $archivo->delete();

        return back()->with('exito', 'Archivo eliminado correctamente.');
    }
}