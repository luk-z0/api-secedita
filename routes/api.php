<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Mail\ContactController;


require __DIR__ . '/posts.php';
require __DIR__ . '/appointment.php';


Route::prefix('users')
    ->middleware('auth:sanctum')
    ->group(__DIR__ . '/users.php');

Route::middleware('auth:sanctum')->get('/user', [AuthenticatedSessionController::class, 'me']);

Route::post('/contact', [ContactController::class, 'send']);




