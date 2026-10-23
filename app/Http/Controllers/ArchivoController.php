<?php

namespace App\Http\Controllers;

use App\Models\Archivo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArchivoController extends Controller
{
    // DISCO DONDE SE GUARDA LOS ARCHIVOS (definido en config/filesystems.php)
    private const DISCO = 'archivos';

    // FUNCION QUE LISTA LOS ARCHIVOS DEL USUARIO CON SESION INICIADA
    public function index(Request $request)
    {
        $archivos = $request->user()
            ->archivos()
            ->orderByDesc('fecha_creacion')
            ->get();

        return view('panel', compact('archivos'));
    }

    // FUNCION SUBIR ARCHIVO Y VALIDACIONES DE PESO, CON EXTENSIONES
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

        // SE GUARDA EL ARCHIVO CON NOMBRE DIFERENTE EN LA CARPETA DEL USUARIO
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

    // FUNCION ABRIR ARCHIVO
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

    // FUNCION DESCARGAR ARCHIVO CON SU NOMBRE
    public function download(Archivo $archivo)
    {
        Gate::authorize('view', $archivo);

        $disco = Storage::disk(self::DISCO);

        if (! $disco->exists($archivo->ruta_archivo)) {
            abort(404, 'El archivo ya no está disponible en el servidor.');
        }

        return $disco->download($archivo->ruta_archivo, $archivo->nombre_original);
    }

    // FUNCION PARA ELMINAR EL ARCHIVO EN DISCO Y BD
    public function destroy(Archivo $archivo)
    {
        Gate::authorize('delete', $archivo);

        Storage::disk(self::DISCO)->delete($archivo->ruta_archivo);
        $archivo->delete();

        return back()->with('exito', 'Archivo eliminado correctamente.');
    }
}