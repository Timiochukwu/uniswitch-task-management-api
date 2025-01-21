<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TaskController;

Route::middleware('auth:sanctum')->get('/user', function (Illuminate\Http\Request $request) {
    return $request->user();
});

Route::apiResource('tasks', TaskController::class);