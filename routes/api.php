<?php

use App\Http\Controllers\CitasController;
use App\Http\Controllers\CuposController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\TiposUsuariosController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UsuariosController;
use App\Models\Cupo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


//crear usuario
Route::post('/usuarios/crear', [UsuariosController::class,'store']);

//login
Route::post('/login', [LoginController::class,'login']);


//RUTAS PROTEGIDAS POR SESION
Route::group(['middleware'=>'auth:api'], function(){

    Route::apiResource('/usuarios', UsuariosController::class);

    Route::apiResource('/citas', CitasController::class);

    Route::apiResource('/tipoUsuario', TiposUsuariosController::class);

    Route::apiResource('/cupos', CuposController::class);

    Route::post('/logout', [LoginController::class,'logout']);
});
