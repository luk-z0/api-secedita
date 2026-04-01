<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Mail\ContactController;


require __DIR__ . '/posts.php';
require __DIR__ . '/appointment.php';
require __DIR__ . '/auth.php';


Route::prefix('users')
    ->middleware('auth:sanctum')
    ->group(__DIR__ . '/users.php');

Route::post('/contact', [ContactController::class, 'send']);




