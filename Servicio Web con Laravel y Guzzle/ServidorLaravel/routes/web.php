<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UbicacionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('ubicaciones',[UbicacionController::class,'index']);

Route::get('ubicaciones/create',[UbicacionController::class,'create']);

Route::post('ubicaciones/store',[UbicacionController::class,'store']);

Route::get('ubicaciones/{ubicacion}', [UbicacionController::class,'show'])->whereNumber('ubicacion');

Route::get('ubicaciones/{ubicacion}/edit', [UbicacionController::class,'edit'])->whereNumber('ubicacion');

Route::post('ubicaciones/{ubicacion}/update', [UbicacionController::class,'update'])->name('ubi')->whereNumber('ubicacion');

Route::get('ubicaciones/{ubicacion}/destroyconfirm',[UbicacionController::class,'destroyconfirm'])->whereNumber('ubicacion');

Route::post('ubicaciones/{ubicacion}/destroy', [UbicacionController::class,'destroy'])->name('borradoconfirm')->whereNumber('ubicacion');



