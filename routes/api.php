<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Mail\ContactController;
use App\Http\Controllers\Service\ServiceController;
use App\Http\Controllers\Appointment\AppointmentController;


require __DIR__ . '/posts.php';

Route::prefix('users')
    ->middleware('auth:sanctum')
    ->group(__DIR__ . '/users.php');

Route::middleware('auth:sanctum')->get('/user', [AuthenticatedSessionController::class, 'me']);

Route::post('/contact', [ContactController::class, 'send']);

Route::prefix('services')->group(function () {
    Route::get('/', [ServiceController::class, 'index']);

    Route::middleware('auth:sanctum')->group(function(){
        Route::post('/', [ServiceController::class, 'store']);
        Route::post('/{id}/restore', [ServiceController::class, 'restore']);
    });
});

Route::prefix('appointments')->group(function () {
    Route::post('/', [AppointmentController::class, 'store']);           // Cidadão Agenda

    Route::middleware('auth:sanctum')->group(function(){
        Route::patch('/{appointment}/status', [AppointmentController::class, 'updateStatus']);
        Route::post('/{id}/restore', [AppointmentController::class, 'restore']);
    });
});
