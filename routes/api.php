<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\ShiftsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserOnShiftController;
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
Route::post('login', [UserController::class, 'login']);
Route::post('user', [UserController::class, 'userRegistration']);

Route::middleware('scope.token')->group(function ()
{
    Route::get('logout', [UserController::class, 'logout']);

    Route::middleware('role.scope:admin')->group(function () {
        Route::get('user', [UserController::class, 'showUsers']);
        Route::post('work-shift', [ShiftsController::class, 'createShift']);
        Route::get('work-shift/{id}/open', [ShiftsController::class, 'shiftOpen']);
        Route::get('work-shift/{id}/close', [ShiftsController::class, 'shiftClose']);
        Route::post('work-shift/{id}/user', [UserOnShiftController::class, 'addUserOnShift']);
        Route::get('work-shift/{id}/order', [ShiftsController::class, 'showOrderOnShift']);
    });
    Route::middleware('role.cope:waiter')->group(function () {
        Route::post('order', );
    });
});
