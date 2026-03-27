<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Service\ServiceController;
use App\Http\Controllers\Appointment\AppointmentController;


Route::prefix('services')->group(function () {
    Route::get('/', [ServiceController::class, 'index']);
    Route::get('/{service}', [ServiceController::class, 'show']);


    Route::middleware('auth:sanctum')->group(function(){
        Route::post('/', [ServiceController::class, 'store']);
        Route::post('/{id}/restore', [ServiceController::class, 'restore']);
    });
});

Route::prefix('appointments')->group(function () {
    Route::post('/', [AppointmentController::class, 'store']);        

    Route::middleware('auth:sanctum')->group(function(){
        Route::patch('/{appointment}/status', [AppointmentController::class, 'updateStatus']);
        Route::post('/{id}/restore', [AppointmentController::class, 'restore']);
    });
});
