<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AccountController;
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

//Grouping was made for User.
Route::prefix('/user')->group(function () {
    Route::post('/', [UserController::class, 'store']);
    Route::get('/{username}/{password}', [UserController::class, 'show']);
});

//Grouping was made for Account.
Route::prefix('/account')->group(function () {
    Route::post('/deposit', [AccountController::class, 'deposit']);
    Route::post('/withdraw', [AccountController::class, 'withdraw']);
});
