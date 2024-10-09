<?php

use App\Http\Controllers\TalleresControllerAPI;
use App\Http\Controllers\UbicacionesControllerAPI;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/ubicaciones', [UbicacionesControllerAPI::class, 'listar']);

Route::get('/ubicaciones/{idubicacion}/talleres', [UbicacionesControllerAPI::class, 'talleres']);

Route::post('/ubicaciones/{idubicacion}/creartaller', [TalleresControllerAPI::class, 'store']);

Route::delete('/talleres/{idtaller}', [TalleresControllerAPI::class, 'destroy']);

Route::patch('/talleres/{idtaller}/cambiarubicacion', [TalleresControllerAPI::class, 'cambiarUbicacion']);