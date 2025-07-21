<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\RoleModule\Http\Controllers\Api\RoleApiController;

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


Route::post('assignRole', [RoleApiController::class, 'assignRole']);
Route::post('revokeRole', [RoleApiController::class, 'revokeRole']);
