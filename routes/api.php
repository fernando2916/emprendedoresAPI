<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Blog\BlogController;
use App\Http\Controllers\Categorias\CategoriasController;
use App\Http\Controllers\Vacantes\VacantesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function() {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/verify/{id}', [AuthController::class, 'verify']);
    Route::post('/reset-verification-code', [AuthController::class, 'reset_Code']);
    Route::post('/reset-password', [AuthController::class, 'reset_Password']);
    Route::post('/new-password/{id}', [AuthController::class, 'new_Password']);
    Route::post('/login', [AuthController::class, 'login']);  
    Route::get('/refresh', [AuthController::class, 'refreshToken']);  
    Route::get('/me', [AuthController::class, 'me']);  
    Route::post('/logout', [AuthController::class, 'logout']);  
});

// Route::apiResource('posts', PostController::class);
Route::apiResource('blog', BlogController::class);
// Route::apiResource('categoria', CategoriasController::class);
Route::apiResource('vacante', VacantesController::class);
Route::apiResource('users', UserController::class);

Route::get('/categoria', [CategoriasController::class, 'index']);
Route::get('/categoria/{id}', [CategoriasController::class, 'showById']);
Route::get('/categoria/tipo/{tipo}', [CategoriasController::class, 'showByTipo']);
Route::post('/categoria', [CategoriasController::class, 'store']);
Route::put('/categoria/{id}', [CategoriasController::class, 'update']);
Route::delete('/categoria/{id}', [CategoriasController::class, 'destroy']);