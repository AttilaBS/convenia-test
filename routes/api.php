<?php

use App\Http\Controllers\Api\CreateUserController;
use App\Http\Controllers\Api\LoginUserController;
use App\Http\Controllers\Api\LogoutUserController;
use Illuminate\Support\Facades\Route;

Route::post('register', CreateUserController::class);
Route::post('login', LoginUserController::class);

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('logout', LogoutUserController::class);
});

