<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\PaymentModule\Http\Controllers\Api\PaymentApiController;

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

Route::group(['namespace' => 'Api', 'prefix' => 'payment' ,'middleware' => 'auth:api'], function () {

    Route::get('listPaymentMethods',[PaymentApiController::class, 'listPaymentMethods']);
    Route::post('payment',[PaymentApiController::class, 'processPayment']);

   


});


Route::post('/webhook/stripe',[PaymentApiController::class, 'handleWebhook']);