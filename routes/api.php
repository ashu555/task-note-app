<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;
use App\Http\Controllers\NoteController;

RateLimiter::for('api', function ($request) { // Remove type hinting for $request
    return $request->user()
        ? Limit::perMinute(60)->by($request->user()->id) // Authenticated user limit
        : Limit::perMinute(10)->by($request->ip()); // Unauthenticated user limit
});

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum',  'throttle:60,1')->group(function () {
    Route::resource('tasks', TaskController::class);
    Route::get('tasks', [TaskController::class, 'index']);
    Route::post('tasks', [TaskController::class, 'store']);
    Route::get('tasks/{task}', [TaskController::class, 'show']);
    Route::post('/tasks/{task_id}/notes', [NoteController::class, 'store']);
});

