<?php

use App\Http\Controllers\PistaController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\SocioController;
use App\Http\Controllers\UserController;
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
Route::post('/login', [UserController::class, 'login']);
Route::post('/register', [UserController::class, 'store']);

Route::middleware(['auth:sanctum'])->group(function(){
    Route::resource('/user', UserController::class);
    Route::resource('/deporte', DeporteController::class);
    Route::resource('/pista', PistaController::class);
    Route::resource('/socio', SocioController::class);
    Route::resource('/rese rva', ReservaController::class);
    Route::get('logout', [UserController::class,'logout']);
});
