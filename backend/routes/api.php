<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JsonController;
use App\Http\Controllers\HelloWorldController;
use App\Http\Controllers\CsvController;
use App\Http\Controllers\XmlController;


Route::apiResource('hello', HelloWorldController::class);

Route::get('/json', [JsonController::class, 'index']);
Route::post('/json', [JsonController::class, 'store']);
Route::get('/json/{filename}', [JsonController::class, 'show']);
Route::put('/json/{filename}', [JsonController::class, 'update']);
Route::delete('/json/{filename}', [JsonController::class, 'destroy']);

Route::prefix('csv')->group(function () {
    Route::get('/', [CsvController::class, 'index']);
    Route::post('/', [CsvController::class, 'store']);
    Route::get('/{id}', [CsvController::class, 'show']);
    Route::put('/{id}', [CsvController::class, 'update']);
    Route::delete('/{id}', [CsvController::class, 'destroy']);
});
    

Route::get('xml', [XmlController::class, 'index']); // Para mostrar la lista de archivos XML
Route::post('xml', [XmlController::class, 'store']); // Para almacenar un archivo XML
Route::get('xml/{id}', [XmlController::class, 'show']); // Para mostrar un archivo XML por su ID
Route::put('xml/{id}', [XmlController::class, 'update']); // Para actualizar un archivo XML por su ID
Route::delete('xml/{id}', [XmlController::class, 'destroy']); // Para eliminar un archivo XML por su ID
    
    
