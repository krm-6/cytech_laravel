<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\CompaniesController;

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

Route::get('/', function () {
    return redirect()->route('login'); // ログイン画面にリダイレクト
});

Auth::routes();

Route::get('/products', [ProductsController::class, 'index'])->name('products.index')->middleware('auth');
Route::get('/products/registration', [ProductsController::class, 'registration'])->name('products.registration')->middleware('auth');
Route::post('/products/register', [ProductsController::class, 'register'])->name('products.register')->middleware('auth');
Route::get('/products/search', [ProductsController::class, 'search'])->name('products.search')->middleware('auth');
Route::get('/products/{id}', [ProductsController::class, 'detail'])->name('products.detail')->middleware('auth');
Route::get('/products/{id}/edit', [ProductsController::class, 'edit'])->name('products.edit')->middleware('auth');
Route::post('/products/{id}/update', [ProductsController::class, 'update'])->name('products.update')->middleware('auth');
Route::post('/products/destroy/{id}', [ProductsController::class, 'destroy'])->name('products.destroy')->middleware('auth');


