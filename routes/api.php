<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Todo\TodoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Protected route (optional - for current user)
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Public auth routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// ⛔ Remove auth protection from todos
Route::apiResource('todos', TodoController::class);

// Optional: only logout needs to be protected
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
