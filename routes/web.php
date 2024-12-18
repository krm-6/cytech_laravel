<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;


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


// ログインルート
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// 登録ルート
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

Route::get('/products', [ProductsController::class, 'index'])->name('products.index');
Auth::routes(['registration' => false]);
Route::get('/products/registration', [ProductsController::class, 'registration'])->name('products.registration');
Route::post('/products/register', [ProductsController::class, 'register'])->name('products.register');
Route::get('/products/search', [ProductsController::class, 'search'])->name('products.search');
Route::get('/products/{id}', [ProductsController::class, 'detail'])->name('products.detail');
Route::get('/products/{id}/edit', [ProductsController::class, 'edit'])->name('products.edit');
Route::post('/products/{id}/update', [ProductsController::class, 'update'])->name('products.update');
Route::post('/products/destroy', [ProductsController::class, 'destroy'])->name('products.destroy');