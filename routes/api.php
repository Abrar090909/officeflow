<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CommentController;

// All dashboard interactions are now moved here for REST compliance
Route::middleware('auth:sanctum')->group(function () {
    // Task Endpoints
    Route::get('/tasks', [TaskController::class, 'indexApi']);
    Route::post('/tasks', [TaskController::class, 'store']);
    Route::put('/tasks/{task}', [TaskController::class, 'update']);
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy']);
    Route::put('/tasks/{task}/status', [TaskController::class, 'updateStatus']);

    // Comment Endpoints
    Route::post('/tasks/{task}/comments', [CommentController::class, 'store']);
});
