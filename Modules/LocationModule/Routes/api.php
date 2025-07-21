<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'location','namespace'=>'Api'], function () {


    Route::get('/getCitiesToCountry', 'CityApiController@getCitiesToCountry');
    Route::get('/getAreasToCity/{id}', 'AreaApiController@getAreasToCity');
    Route::get('/listAllCities', 'CityApiController@listAllCities');
 

});