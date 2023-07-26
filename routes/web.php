<?php

use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', function () {
    return view('auth/login');
});

Auth::routes();

Route::middleware('auth')->group(function () {

    Route::post('ajax/{method}', [App\Http\Controllers\AjaxController::class, 'handle'])->name('ajax.handle');

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
    Route::resource('/brand', \App\Http\Controllers\BrandController::class);
    Route::resource('/category', \App\Http\Controllers\CategoryController::class);
    Route::resource('/product', \App\Http\Controllers\ProductController::class);
    Route::resource('/warehouse', \App\Http\Controllers\WarehouseController::class);
    Route::resource('/account', \App\Http\Controllers\AccountController::class);

    Route::get('/purchase', [\App\Http\Controllers\PurchaseController::class, 'payment'])->name('purchase.payment');
    Route::resource('/purchase', \App\Http\Controllers\PurchaseController::class);
    Route::resource('/unit', \App\Http\Controllers\UnitController::class);
    Route::resource('/purchaseReceive', \App\Http\Controllers\PurchaseReceiveController::class);

    Route::get('/users', [RegisterController::class, 'users']);
});
