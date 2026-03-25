<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;


Route::get('roles', [UserController::class, 'roles'])->name('users.roles');

Route::prefix('{user}')->group(function () {
    Route::patch('toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
    Route::patch('restore', [UserController::class, 'restore'])->name('users.restore');
    Route::patch('update-role/{role}', [UserController::class, 'updateRole'])->name('users.update-role');
    Route::delete('force-delete', [UserController::class, 'forceDelete'])->name('users.force-delete');
});

Route::apiResource('/', UserController::class)->parameters(['' => 'user']);
