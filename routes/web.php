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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/products', [ProductsController::class, 'index'])->name('products.index');
Route::get('/products/registration', [ProductsController::class, 'registration'])->name('products.registration');
Route::post('/products/register', [ProductsController::class, 'register'])->name('products.register');
Route::get('/products/search', [ProductsController::class, 'search'])->name('products.search');
Route::get('/products/{id}', [ProductsController::class, 'detail'])->name('products.detail');
Route::get('/products/{id}/edit', [ProductsController::class, 'edit'])->name('products.edit');
Route::post('/products/{id}/update', [ProductsController::class, 'update'])->name('products.update');
Route::post('/products/destroy/{id}', [ProductsController::class, 'destroy'])->name('products.destroy');


