<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CarreraController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\EscuderiaController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\PilotoController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ResultadoController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::post('piloto', [PilotoController::class, 'store']);
Route::get('piloto/{id}', [PilotoController::class, 'show']);
Route::get('pilotos', [PilotoController::class, 'index']);
Route::put('piloto/{id}', [PilotoController::class, 'update']);
Route::delete('piloto/{id}', [PilotoController::class, 'delete']);

Route::post('carrera', [CarreraController::class, 'store']);
Route::get('carrera/{id}', [CarreraController::class, 'show']);
Route::get('carreras', [CarreraController::class, 'index']);
Route::put('carrera/{id}', [CarreraController::class, 'update']);
Route::delete('carrera/{id}', [CarreraController::class, 'delete']);

Route::post('resultado', [ResultadoController::class, 'store']);
Route::get('resultados', [ResultadoController::class, 'index']);
Route::get('resultados/carrera/{id}', [ResultadoController::class, 'showByCarrera']);
Route::put('resultado/{id}', [ResultadoController::class, 'update']);
Route::delete('resultado/{id}', [ResultadoController::class, 'delete']);


Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::post('logout', [AuthController::class, 'logout']);
Route::post('refresh', [AuthController::class, 'refresh']);
Route::get('me', [AuthController::class, 'me']);

Route::post('usuario', [UserController::class, 'store']);
Route::get('usuario/{id}', [UserController::class, 'show']);
Route::get('usuarios', [UserController::class, 'index']);
Route::put('usuario/{id}', [UserController::class, 'update']);
Route::delete('usuario/{id}', [UserController::class, 'delete']);

Route::post('producto', [ProductoController::class, 'store']);
Route::get('producto/{id}', [ProductoController::class, 'show']);
Route::get('productos', [ProductoController::class, 'index']);
Route::put('producto/{id}', [ProductoController::class, 'update']);
Route::delete('producto/{id}', [ProductoController::class, 'delete']);

Route::post('image/{id}', [ImageController::class, 'update']);
Route::delete('image/{id}', [ImageController::class, 'delete']);

Route::post('carrito', [CarritoController::class, 'store']);
Route::get('carrito', [CarritoController::class, 'indexByUser']);
Route::post('carrito/{producto}/', [CarritoController::class, 'update']);
Route::delete('carrito/{producto}', [CarritoController::class, 'deleteProducto']);
Route::delete('carrito/', [CarritoController::class, 'deleteCarrito']);
Route::get('cantidadCarrito', [CarritoController::class, 'getCantidadCarrito']);

Route::post('pedido', [PedidoController::class, 'store']);
Route::get('mispedidos', [PedidoController::class, 'indexByUser']);
Route::get('pedidos', [PedidoController::class, 'index']);
Route::put('pedido/{id}/', [PedidoController::class, 'update']);
Route::delete('pedido/{id}', [PedidoController::class, 'delete']);
