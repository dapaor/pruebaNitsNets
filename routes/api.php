<?php

use App\Http\Controllers\PistaController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\SocioController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DeporteController;
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

Route::resource('/deporte', DeporteController::class);

Route::resource('/pista', PistaController::class);

Route::resource('/socio', SocioController::class);

Route::resource('/reserva', ReservaController::class);

Route::post('/reserva/{pista}', [ReservaController::class,'getReservasPistaDiaHora']);
