<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\JsonResponse;

class JsonController extends Controller
{
    private function isValidJson($string)
    {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }
    /**
     * Lista todos los ficheros JSON de la carpeta storage/app.
     * Se debe comprobar fichero a fichero si su contenido es un JSON válido.
     * para ello, se puede usar la función json_decode y json_last_error.
     *
     * @return JsonResponse La respuesta en formato JSON.
     *
     * El JSON devuelto debe tener las siguientes claves:
     * - mensaje: Un mensaje indicando el resultado de la operación.
     * - contenido: Un array con los nombres de los ficheros.
     */
    public function index(): JsonResponse
    {
        // Obtener todos los archivos con extensión .json
        $files = collect(Storage::disk('local')->files())
            ->filter(fn($file) => pathinfo($file, PATHINFO_EXTENSION) === 'json')  // Filtra por archivos con extensión .json
            ->filter(fn($file) => $this->isValidJson(Storage::get($file)))  // Verifica que el contenido sea un JSON válido
            ->map(fn($file) => basename($file));  // Obtiene solo el nombre del archivo
    
        return response()->json([
            'mensaje' => 'Operación exitosa',
            'contenido' => $files->values(),  // Asegura que los índices sean consecutivos
        ]);
    }
    

   /**
     * Recibe por parámetro el nombre de fichero y el contenido. Devuelve un JSON con el resultado de la operación.
     * Si el fichero ya existe, devuelve un 409.
     * Si el contenido no es un JSON válido, devuelve un 415.
     *
     * @param filename Parámetro con el nombre del fichero. Devuelve 422 si no hay parámetro.
     * @param content Contenido del fichero. Devuelve 422 si no hay parámetro.
     * @return JsonResponse La respuesta en formato JSON.
     *
     * El JSON devuelto debe tener las siguientes claves:
     * - mensaje: Un mensaje indicando el resultado de la operación.
     */
    public function store(Request $request)
    {
        // Validar parámetros de entrada
        $request->validate([
            'filename' => 'required|string',
            'content' => 'required|string',
        ]);

        // Verificar si el archivo ya existe
        if (Storage::disk('local')->exists($request->filename)) {
            return response()->json([
                'mensaje' => 'El fichero ya existe',
            ], 409);
        }

        // Verificar si el contenido es un JSON válido
        if (!$this->isValidJson($request->content)) {
            return response()->json([
                'mensaje' => 'Contenido no es un JSON válido',
            ], 415);
        }

        // Guardar el archivo
        Storage::disk('local')->put($request->filename, $request->content);

        return response()->json([
            'mensaje' => 'Fichero guardado exitosamente',
        ]);
    }

 /**
     * Recibe por parámetro el nombre de fichero y devuelve un JSON con su contenido
     *
     * @param name Parámetro con el nombre del fichero.
     * @return JsonResponse La respuesta en formato JSON.
     *
     * El JSON devuelto debe tener las siguientes claves:
     * - mensaje: Un mensaje indicando el resultado de la operación.
     * - contenido: El contenido del fichero si se ha leído con éxito.
     */
    public function show(string $id)
    {
        if (!Storage::disk('local')->exists($id)) {
            return response()->json([
                'mensaje' => 'El fichero no existe',
            ], 404);
        }
    
        $content = Storage::disk('local')->get($id);
    
        return response()->json([
            'mensaje' => 'Operación exitosa',
            'contenido' => json_decode($content, true), // Decodificar JSON
        ]);
    }

   /**
     * Recibe por parámetro el nombre de fichero, el contenido y actualiza el fichero.
     * Devuelve un JSON con el resultado de la operación.
     * Si el fichero no existe devuelve un 404.
     * Si el contenido no es un JSON válido, devuelve un 415.
     * 
     * @param filename Parámetro con el nombre del fichero. Devuelve 422 si no hay parámetro.
     * @param content Contenido del fichero. Devuelve 422 si no hay parámetro.
     * @return JsonResponse La respuesta en formato JSON.
     *
     * El JSON devuelto debe tener las siguientes claves:
     * - mensaje: Un mensaje indicando el resultado de la operación.
     */
    public function update(Request $request, string $id)
    {
        // Validar parámetros de entrada
        $request->validate([
            //'filename' => 'required|string',
            'content' => 'required|string',
        ]);

        // Verificar si el archivo existe
        if (!Storage::disk('local')->exists($id))  {
            return response()->json([
                'mensaje' => 'El fichero no existe',
            ], 404);
        }

        // Verificar si el contenido es un JSON válido
        if (!$this->isValidJson($request->content)) {
            return response()->json([
                'mensaje' => 'Contenido no es un JSON válido',
            ], 415);
        }

        // Actualizar el archivo
        Storage::disk('local')->put($id, $request->content);

        return response()->json([
            'mensaje' => 'Fichero actualizado exitosamente',
        ]);
    }

     /**
     * Recibe por parámetro el nombre de ficher y lo elimina.
     * Si el fichero no existe devuelve un 404.
     *
     * @param filename Parámetro con el nombre del fichero. Devuelve 422 si no hay parámetro.
     * @return JsonResponse La respuesta en formato JSON.
     *
     * El JSON devuelto debe tener las siguientes claves:
     * - mensaje: Un mensaje indicando el resultado de la operación.
     */
    
     public function destroy(string $id)
     {
         // Verificar si el archivo existe
        
         if (!Storage::disk('local')->exists($id)) {
             return response()->json([
                 'mensaje' => 'El fichero no existe',
                 'ruta' => $path  // Agregar la ruta para depurar el problema
             ], 404);
         }
     
         // Eliminar el archivo
         Storage::disk('local')->delete($id);
     
         return response()->json([
             'mensaje' => 'Fichero eliminado exitosamente',
         ]);
     } 
}
