<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function() {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/verify/{id}', [AuthController::class, 'verify']);
    Route::post('/reset-verification-code', [AuthController::class, 'reset_Code']);
    Route::post('/reset-password', [AuthController::class, 'reset_Password']);
    Route::post('/new-password/{id}', [AuthController::class, 'new_Password']);
    Route::post('/login', [AuthController::class, 'login']);  
});