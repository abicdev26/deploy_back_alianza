<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PendingOrderController;
use App\Http\Controllers\OrdersDeliveredController;



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

Route::post('/users', [UserController::class, 'store']);

Route::post('/login', [LoginController::class, 'login']);

Route::middleware('auth.redirect')->group(function () {
    Route::apiResource('/pending-orders', PendingOrderController::class);
    Route::get('/pending-orders/user/{user_id}', [PendingOrderController::class, 'getByUserId']);
    
    Route::get('/orders-delivered/user/{user_id}', [OrdersDeliveredController::class, 'getByUserId']);
    Route::post('/orders-delivered', [OrdersDeliveredController::class, 'store']);
    
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});