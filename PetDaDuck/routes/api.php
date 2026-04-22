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
Route::get('/leaderboard', [AuthController::class, 'leaderboard']); 
