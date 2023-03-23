<?php

use App\Http\Controllers\EscuderiaController;
use App\Http\Controllers\RoleController;
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

Route::post('rol', [RoleController::class, 'store']);
Route::get('rol/{id}', [RoleController::class, 'show']);
Route::get('roles', [RoleController::class, 'index']);
Route::put('rol/{id}', [RoleController::class, 'update']);
Route::delete('rol/{id}', [RoleController::class, 'delete']);

Route::post('escuderia', [EscuderiaController::class, 'store']);
Route::get('escuderia/{id}', [EscuderiaController::class, 'show']);
Route::get('escuderias', [EscuderiaController::class, 'index']);
Route::put('escuderia/{id}', [EscuderiaController::class, 'update']);
Route::delete('escuderia/{id}', [EscuderiaController::class, 'delete']);
