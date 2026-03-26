<?php

use Illuminate\Support\Facades\Route;

require __DIR__ . '/posts.php';

Route::prefix('users')
    ->middleware('auth:sanctum')
    ->group(__DIR__ . '/users.php');

Route::middleware('auth:sanctum')->get('/user', function (Request $request){
    $request->user();
});
