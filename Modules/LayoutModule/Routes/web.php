<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;



Route::group(['prefix' => 'admin', 'middleWare' => 'auth'], function () {
    Route::get('/dashboard', 'LayoutModuleController@index')->name('dashboard.index');
});

Route::get('/', 'LayoutModuleController@loginGet')->name('loginWeb');

Route::post('/login', 'LayoutModuleController@loginUser')->name('loginUser');

Route::group(['perfix' => 'admin', 'middleWare' => 'auth'], function () {
    Route::get('/logout', 'LayoutModuleController@logout')->name('logout');
    Route::get('changePassword', 'LayoutModuleController@changePassword')->name('changePassword'); // change password view
    Route::post('updatePassword', 'LayoutModuleController@updatePassword')->name('updatePassword'); // change password action
});
