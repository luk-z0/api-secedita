<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Post\{PostController, PostPublicController};

Route::get('portal/posts', [PostPublicController::class, 'index']);

Route::middleware('auth:sanctum')->prefix('admin')->group(function () {
    Route::apiResource('posts', PostController::class);
    Route::patch('posts/{post}/toggle-publish', [PostController::class, 'toggleStatus']);
});
