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
use Modules\OrderModule\Http\Controllers\Admin\OrderAdminController;

Route::prefix('admin/orders')->group(function () {
    Route::get('/', [OrderAdminController::class, 'index'])->name('orders.index');
    Route::get('/{order}/show', [OrderAdminController::class, 'show'])->name('orders.show');
    Route::get('/{order}/edit', [OrderAdminController::class, 'edit'])->name('orders.edit');
    Route::post('/{order}/update', [OrderAdminController::class, 'update'])->name('orders.update');
    Route::post('/{order}/cancel', [OrderAdminController::class, 'cancel'])->name('orders.cancel');
});
