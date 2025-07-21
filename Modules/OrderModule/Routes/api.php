<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\OrderModule\Http\Controllers\Api\OrderApiController;

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

Route::group(['prefix' => 'order', 'middleware' => 'auth:api'], function () {

    Route::post('create', [OrderApiController::class, 'createOrder']);
    Route::get('orderDetails/{id}', [OrderApiController::class, 'orderDetails']);
    Route::get('trackOrder/{id}', [OrderApiController::class, 'trackOrder']);
    Route::get('listOfOrders', [OrderApiController::class, 'listOfOrders']);
    Route::get('listOrderStatuses', [OrderApiController::class, 'listOrderStatuses']);

    // Routes accessible by Vendor and Admin 
    Route::group(['middleware' => 'check.admin.or.vendor.permission'], function () {
        Route::post('UpdateOrderStatus', [OrderApiController::class, 'updateOrderStatus']);
    });

    // Routes accessible by Customer 
    Route::group(['middleware' => 'check.customer.permission'], function () {
        Route::post('cancelOrder', [OrderApiController::class, 'updateOrderStatusToCancelled']);
    });
});
