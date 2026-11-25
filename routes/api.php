<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MediaController;

Route::apiResource('media', MediaController::class)
    ->parameters(['media' => 'media']);
Route::post(
    '/users/{user}/collection/{media}',
    [MediaController::class, 'addToCollection']
);

Route::get(
    '/users/{user}/collection',
    [MediaController::class, 'userCollection']
);

Route::delete(
    '/users/{user}/collection/{media}',
    [MediaController::class, 'removeFromCollection']
);