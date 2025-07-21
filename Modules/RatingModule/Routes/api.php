<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\RatingModule\Http\Controllers\Api\RatingApiController;

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

Route::group(['namespace' => 'Api', 'prefix' => 'user'], function () {
    Route::post('/rating/{order_id}', [RatingApiController::class, 'create']);
    Route::get('/getOverAllProductRating/{product_id}', [RatingApiController::class, 'getOverAllRating']);

});
