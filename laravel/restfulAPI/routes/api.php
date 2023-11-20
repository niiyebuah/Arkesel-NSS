<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

// Routes with API key middleware
Route::middleware('apikey')->group(function () {
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'delete']);
});

// Public routes
Route::get('/allusers', [UserController::class, 'index']);
Route::post('/users', [UserController::class, 'create']);
