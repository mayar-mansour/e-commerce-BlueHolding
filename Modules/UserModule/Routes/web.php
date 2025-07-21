<?php

use Illuminate\Support\Facades\Route;
use Modules\UserModule\Http\Controllers\Admin\AdminUserController;

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

// Route::prefix('usermodule')->group(function() {
//     Route::get('/', 'UserModuleController@index');
// });

// --------------------------Admin-------------------------------------
Route::prefix('admin/users')->group(function () {
    Route::get('', [AdminUserController::class, 'index'])->name('admin.users.index');
    Route::get('/edit/{id}', [AdminUserController::class, 'edit'])->name('admin.users.edit');
    Route::get('/create', [AdminUserController::class, 'create'])->name('admin.users.create');
    Route::post('store', [AdminUserController::class, 'store'])->name('admin.users.store');
    Route::put('/{id}', [AdminUserController::class, 'update'])->name('admin.users.update');
   
});
