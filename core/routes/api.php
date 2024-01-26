<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



Route::middleware(['api'])->group(function () {
    Route::post('v1/auth/login', [\App\Http\Controllers\Api\V1\AuthController::class, 'login'])->name('login');
    Route::get('v1/auth/logout', [\App\Http\Controllers\Api\V1\AuthController::class, 'logout'])->name('logout');
    Route::get('v1/auth/refresh', [\App\Http\Controllers\Api\V1\AuthController::class, 'refresh'])->name('refresh');


    Route::get('v1/users/me', [\App\Http\Controllers\Api\V1\UsersController::class, 'me'])->name('me');

});
