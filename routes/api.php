<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Api\ContactController;

require __DIR__ . '/posts.php';

Route::prefix('users')
    ->middleware('auth:sanctum')
    ->group(__DIR__ . '/users.php');

Route::middleware('auth:sanctum')->get('/user', [AuthenticatedSessionController::class, 'me']);

Route::post('/contact', [ContactController::class, 'send']);
