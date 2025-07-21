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

Route::group(['namespace' => 'Api', 'prefix' => 'product', 'middleware' => 'auth:api'], function () {

    // Routes accessible by Admin and Vendor
    Route::group(['middleware' => ['check.admin.or.vendor.permission']], function () {
        Route::post('createProduct', 'ProductApiController@createProduct');
        Route::post('updateProduct', 'ProductApiController@updateProduct');
        
    });

    // Route accessible by Admin only
    Route::group(['middleware' => 'check.admin.permission'], function () {
        Route::get('deleteProduct/{product_id}', 'ProductApiController@deleteProduct');
    });


    Route::post('searchForProduct', 'ProductApiController@searchProduct');
    Route::get('getProductDetails/{product_id}', 'ProductApiController@getProductDetails');
    Route::get('getProductCategoryDetails/{cat_id}', 'ProductApiController@getProductCategoryDetails');
    Route::get('getAllProducts', 'ProductApiController@getAllProducts');
    Route::get('getAllProductCategories', 'ProductApiController@getAllProductCategories');


});
