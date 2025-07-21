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
use Modules\ProductModule\Http\Controllers\Admin\ProductAdminController;

Route::prefix('admin/products')->group(function () {
    Route::get('/', [ProductAdminController::class, 'index'])->name('products.index');           // List products
    Route::get('/create', [ProductAdminController::class, 'create'])->name('products.create');   // Show create form
    Route::post('/store', [ProductAdminController::class, 'store'])->name('products.store');     // Handle product creation
    Route::get('/{product}/edit', [ProductAdminController::class, 'edit'])->name('products.edit'); // Show edit form
    Route::post('/{product}/update', [ProductAdminController::class, 'update'])->name('products.update'); // Handle update
    Route::delete('/{product}/delete', [ProductAdminController::class, 'destroy'])->name('products.destroy'); // Delete product
});