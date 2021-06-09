<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

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
Route::redirect('/', '/products');

Route::group([
    'prefix' => 'products'
], function () {

    Route::get('/', [ProductController::class, 'index'])->name('products');
    Route::get('/products-list', [ProductController::class, 'list'])->name('products-list');
    Route::post('/', [ProductController::class, 'store'])->name('product-store');

});
