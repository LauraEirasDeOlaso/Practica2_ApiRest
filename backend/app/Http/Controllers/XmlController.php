<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\JsonResponse;

class XmlController extends Controller
{
    // Listar todos los archivos XML
    public function index()
    {
        $files = Storage::files();  // Obtiene todos los archivos en storage/app
        $xmlFiles = array_filter($files, function ($file) {
            return pathinfo($file, PATHINFO_EXTENSION) === 'xml';  // Filtra los archivos XML
        });

        return response()->json([
            'mensaje' => 'Listado de ficheros',
            'contenido' => array_map(fn($file) => basename($file), $xmlFiles),  // Devuelve solo el nombre del archivo
        ]);
    }

    // Crear y almacenar un nuevo archivo XML
    public function store(Request $request)
    {
        $request->validate([
            'filename' => 'required|string',
            'content' => 'required|string',
        ]);

        if (Storage::exists($request->filename)) {
            return response()->json([
                'mensaje' => 'El fichero ya existe',
            ], 409);
        }

        // Almacenar el archivo XML directamente en storage/app/
        Storage::put($request->filename, $request->content);

        return response()->json([
            'mensaje' => 'Guardado con éxito',
        ]);
    }

    // Mostrar un archivo XML por su nombre (ID)
    public function show(string $id)
    {
        // Verificar si el archivo XML existe en storage/app/
        if (!Storage::exists($id)) {
            return response()->json(['mensaje' => 'El fichero no existe'], 404);
        }

        $content = Storage::get($id);  // Obtener el contenido del archivo
        $xml = simplexml_load_string($content);  // Convertir el contenido XML a un objeto SimpleXML

        if ($xml === false) {
            return response()->json(['mensaje' => 'Error al leer el XML'], 500);
        }

        // Convertir XML a array para retornarlo como JSON
        $json = json_decode(json_encode($xml), true);

        return response()->json([
            'mensaje' => 'Fichero leído con éxito',
            'contenido' => $json,
        ]);
    }

    // Actualizar un archivo XML
    public function update(Request $request, string $id)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        if (!Storage::exists($id)) {
            return response()->json([
                'mensaje' => 'El fichero no existe',
            ], 404);
        }

        Storage::put($id, $request->content);  // Actualizar el archivo XML

        return response()->json([
            'mensaje' => 'Fichero actualizado exitosamente',
        ]);
    }

    // Eliminar un archivo XML
    public function destroy(string $id)
    {
        if (!Storage::exists($id)) {
            return response()->json([
                'mensaje' => 'El fichero no existe',
            ], 404);
        }

        Storage::delete($id);  // Eliminar el archivo XML

        return response()->json([
            'mensaje' => 'Fichero eliminado exitosamente',
        ]);
    }
}
