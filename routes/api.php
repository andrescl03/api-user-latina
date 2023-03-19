<?php

use App\Http\Controllers\UserController;
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

/*REGISTRO DE USUARIO*/
Route::post('/register', [UserController::class, 'register']);
/*LOGIN DE USUARIO*/
Route::post('/login', [UserController::class, 'login']);
/*ENVIO DE CORREO CON ACTUALIZACIÓN DE CONTRASEÑA */
Route::post('/reset-password', [UserController::class, 'resetPassword']);
