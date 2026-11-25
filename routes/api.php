<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MediaController;

Route::apiResource('media', MediaController::class);

Route::post(
    '/users/{user}/collection/{medium}',
    [MediaController::class, 'addToCollection']
);

Route::get(
    '/users/{user}/collection',
    [MediaController::class, 'userCollection']
);

Route::delete(
    '/users/{user}/collection/{medium}',
    [MediaController::class, 'removeFromCollection']
);