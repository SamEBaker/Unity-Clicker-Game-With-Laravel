<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

Route::post('/login', [AuthController::class, 'login']);
Route::get('/leaderboard', [AuthController::class, 'leaderboard']); 

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/update-score', [AuthController::class, 'saveScore']);
    Route::post('/update-sprite', [AuthController::class, 'saveSprite']);
});