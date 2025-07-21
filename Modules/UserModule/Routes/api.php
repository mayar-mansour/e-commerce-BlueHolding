<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\UserModule\Entities\ShippingAddress;
use Modules\UserModule\Http\Controllers\Api\ShippingAddressApiController;
use Modules\UserModule\Http\Controllers\Api\UserApiController;
use Modules\UserModule\Http\Controllers\Api\VerificationController;

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


//--------------------------user-------------------------------//
Route::group(['namespace' => 'Api', 'prefix' => 'user'], function () {
    Route::post('checkExist', 'UserApiController@checkExist');
    Route::post('register', 'UserApiController@register');
    Route::post('verifyEmail', 'UserApiController@verifyEmail');
    Route::post('login', 'UserApiController@login');
    Route::get('loginMessage', 'UserApiController@loginMessage')->name('login');
    Route::post('checkAuth', 'UserApiController@checkAuth');

    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('email/verify', [VerificationController::class, 'verify'])->name('verification.verify');
        Route::post('email/resend', [VerificationController::class, 'resend'])->name('verification.resend');
        Route::get('getProfile', 'UserApiController@getProfile');
        Route::get('logout', 'UserApiController@logout');
    });
});

Route::group(['namespace' => 'Api', 'prefix' => 'ShippingAddress', 'middleware' => 'auth:api'], function () {
    Route::post('create', [ShippingAddressApiController::class, 'store']);
    Route::get('delete/{id}', [ShippingAddressApiController::class, 'delete']);
    Route::post('update/{id}', [ShippingAddressApiController::class, 'update']);
    Route::get('viewShippingAddress/{id}', [ShippingAddressApiController::class, 'viewShippingAddress']);
    Route::get('listShippingAddresses', [ShippingAddressApiController::class, 'listShippingAddresses']);
});
