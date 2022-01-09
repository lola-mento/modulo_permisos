<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\PermisoController;




/* Route::get('/', function () {
    return view('welcome');
}); */

//! ****** RUTAS DEL MODULO PERSONAS ****************************************
Route::resource('/api/persona',PersonaController::class);
Route::get('/api/persona/buscar/{bq}',[PersonaController::class,'buscar']);
//! ****** RUTAS DEL MODULO USUARIOS ****************************************
Route::resource('/api/user',UserController::class);
Route::get('/api/user/buscar/{bq}',[UserController::class,'buscar']);
Route::post('/api/user/login',[UserController::class,'login']);
Route::resource('/api/rol',RolController::class);
//! ****** RUTAS DEL MODULO EMPLEADOS ****************************************
Route::resource('/api/empleado',EmpleadoController::class);
//! ****** RUTAS DEL MODULO PERMISOS ****************************************
Route::resource('/api/permiso',PermisoController::class);








