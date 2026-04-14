<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

// 1. Change 'auth:api' to 'auth:sanctum'
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// 2. The Login route (No lock/middleware needed here)
Route::post('/login', [AuthController::class, 'login']);

// 3. The Score route (Locked so only logged-in Unity players can save)
Route::middleware('auth:sanctum')->post('/update-score', [AuthController::class, 'saveScore']);
